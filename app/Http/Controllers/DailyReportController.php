<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\ReportShareHistory;
use App\Models\Ticket;
use App\Models\WorkCategory;
use App\Models\WorkEntry;
use App\Models\WorkEntryAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    // 1. Daily IT Dashboard
    public function dashboard(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        $todayReport = DailyReport::where('report_date', $today)->with('workEntries')->first();

        $stats = [
            'today_entries' => $todayReport ? $todayReport->workEntries->count() : 0,
            'today_duration' => $todayReport ? $todayReport->formatted_total_duration : '0 Mins',
            'completed_works' => $todayReport ? $todayReport->workEntries->where('status', 'completed')->count() : 0,
            'pending_works' => $todayReport ? $todayReport->workEntries->whereIn('status', ['pending', 'in_progress'])->count() : 0,
            'branches_covered' => $todayReport ? $todayReport->workEntries->pluck('branch_id')->filter()->unique()->count() : 0,
            'tickets_resolved' => $todayReport ? $todayReport->workEntries->pluck('ticket_id')->filter()->unique()->count() : 0,
            'assets_handled' => $todayReport ? $todayReport->workEntries->pluck('asset_id')->filter()->unique()->count() : 0,
        ];

        $recentReports = DailyReport::with('user')->latest('report_date')->take(7)->get();

        return view('daily_reports.dashboard', compact('stats', 'todayReport', 'recentReports'));
    }

    // 2. Calendar View
    public function calendar(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        $reports = DailyReport::whereYear('report_date', $year)
            ->whereMonth('report_date', $month)
            ->get()
            ->keyBy(function ($item) {
                return $item->report_date->format('Y-m-d');
            });

        return view('daily_reports.calendar', compact('reports', 'year', 'month'));
    }

    // 3. Reports List with Advanced Search & Filter
    public function index(Request $request)
    {
        $query = DailyReport::with(['user', 'workEntries.branch', 'workEntries.category']);

        // Date Presets Filter
        if ($request->filled('date_preset')) {
            switch ($request->date_preset) {
                case 'today':
                    $query->whereDate('report_date', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('report_date', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('report_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('report_date', Carbon::now()->month)->whereYear('report_date', Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('report_date', Carbon::now()->subMonth()->month)->whereYear('report_date', Carbon::now()->subMonth()->year);
                    break;
            }
        }

        // Custom Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('report_date', [$request->start_date, $request->end_date]);
        }

        // Keyword Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('workEntries', function ($we) use ($search) {
                      $we->where('title', 'LIKE', "%{$search}%")
                         ->orWhere('description', 'LIKE', "%{$search}%")
                         ->orWhere('problem', 'LIKE', "%{$search}%")
                         ->orWhere('action_taken', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest('report_date')->paginate(12)->withQueryString();

        return view('daily_reports.index', compact('reports'));
    }

    // 4. Create New Daily Report
    public function create(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));

        // Check if report already exists for this date
        $existingReport = DailyReport::where('report_date', $date)->first();
        if ($existingReport) {
            return redirect()->route('daily-reports.edit', $existingReport)
                ->with('info', "{$date} তারিখের রিপোর্ট ইতিমধ্যে তৈরি করা রয়েছে!");
        }

        $report = DailyReport::create([
            'report_number' => 'REP-' . date('Ymd') . '-' . rand(100, 999),
            'user_id' => auth()->id(),
            'report_date' => $date,
            'status' => 'draft',
        ]);

        return redirect()->route('daily-reports.edit', $report);
    }

    // 5. Show Detailed Report
    public function show(DailyReport $dailyReport)
    {
        $dailyReport->load([
            'user',
            'workEntries.category',
            'workEntries.branch',
            'workEntries.asset',
            'workEntries.ticket',
            'workEntries.employee',
            'workEntries.attachments',
            'shareHistories.user',
        ]);

        return view('daily_reports.show', compact('dailyReport'));
    }

    // 6. Edit Daily Report & Work Entries
    public function edit(DailyReport $dailyReport)
    {
        if ($dailyReport->status === 'submitted' && !auth()->user()->isAdmin()) {
            return redirect()->route('daily-reports.show', $dailyReport)
                ->with('error', 'সাবমিট করা রিপোর্ট এডিট করার অনুমতি আপনার নেই!');
        }

        $dailyReport->load(['workEntries.attachments']);
        $categories = WorkCategory::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        $assets = Asset::all();
        $tickets = Ticket::all();
        $employees = Employee::all();

        return view('daily_reports.edit', compact('dailyReport', 'categories', 'branches', 'assets', 'tickets', 'employees'));
    }

    // 7. Store / Add Individual Work Entry
    public function storeWorkEntry(Request $request, DailyReport $dailyReport)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'work_category_id' => 'required|exists:work_categories,id',
            'branch_id' => 'nullable|exists:branches,id',
            'asset_id' => 'nullable|exists:assets,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'employee_id' => 'nullable|exists:employees,id',
            'department' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:draft,pending,in_progress,completed,cancelled',
            'problem' => 'nullable|string',
            'action_taken' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Calculate Duration in Minutes
        $duration = 0;
        if ($request->filled('start_time') && $request->filled('end_time')) {
            $start = Carbon::parse($request->start_time);
            $end = Carbon::parse($request->end_time);
            if ($end->greaterThan($start)) {
                $duration = $start->diffInMinutes($end);
            }
        }

        $validated['daily_report_id'] = $dailyReport->id;
        $validated['duration_minutes'] = $duration;

        $workEntry = WorkEntry::create($validated);

        // Upload Attachments (Multiple Files)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $mime = $file->getMimeType();
                $type = 'document';
                if (str_contains($mime, 'image')) $type = 'image';
                elseif (str_contains($mime, 'video')) $type = 'video';

                $path = $file->store('report_attachments', 'public');

                WorkEntryAttachment::create([
                    'work_entry_id' => $workEntry->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $type,
                    'attachment_type' => $request->get('attachment_type', 'general'),
                    'mime_type' => $mime,
                    'file_size' => round($file->getSize() / 1024),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        // Recalculate Report Totals
        $this->updateReportTotals($dailyReport);

        return redirect()->back()->with('success', 'ওয়ার্ক এন্ট্রি সফলভাবে যুক্ত করা হয়েছে!');
    }

    // 8. Delete Work Entry
    public function destroyWorkEntry(WorkEntry $workEntry)
    {
        $report = $workEntry->dailyReport;
        $workEntry->delete();
        $this->updateReportTotals($report);

        return redirect()->back()->with('success', 'ওয়ার্ক এন্ট্রি ডিলিট করা হয়েছে!');
    }

    // 9. Submit Report
    public function submitReport(DailyReport $dailyReport)
    {
        $dailyReport->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('daily-reports.show', $dailyReport)
            ->with('success', 'ডেইলি ওয়ার্ক রিপোর্ট সফলভাবে জমা করা হয়েছে!');
    }

    // 10. Print Friendly View
    public function print(DailyReport $dailyReport)
    {
        $dailyReport->load([
            'user',
            'workEntries.category',
            'workEntries.branch',
            'workEntries.asset',
            'workEntries.ticket',
            'workEntries.attachments',
        ]);

        // Record Share History
        ReportShareHistory::create([
            'daily_report_id' => $dailyReport->id,
            'shared_via' => 'print',
            'shared_by' => auth()->id(),
            'shared_at' => now(),
        ]);

        return view('daily_reports.print', compact('dailyReport'));
    }

    // 11. WhatsApp Share Link Generator
    public function shareWhatsapp(DailyReport $dailyReport)
    {
        $dailyReport->load(['user', 'workEntries.branch']);

        $message = "📝 *Daily IT Working Report*\n";
        $message .= "📅 Date: " . $dailyReport->report_date->format('d M, Y') . "\n";
        $message .= "👤 Officer: " . $dailyReport->user->name . "\n";
        $message .= "📊 Total Work Entries: " . $dailyReport->total_entries . "\n";
        $message .= "⏱️ Total Duration: " . $dailyReport->formatted_total_duration . "\n\n";

        $message .= "*Summary of Works:*\n";
        foreach ($dailyReport->workEntries as $index => $entry) {
            $num = $index + 1;
            $branch = $entry->branch->name ?? 'General';
            $message .= "{$num}. {$entry->title} ({$branch}) - {$entry->formatted_duration}\n";
        }

        $whatsappUrl = "https://wa.me/?text=" . urlencode($message);

        // Record History
        ReportShareHistory::create([
            'daily_report_id' => $dailyReport->id,
            'shared_via' => 'whatsapp',
            'shared_by' => auth()->id(),
            'notes' => 'Shared summary on WhatsApp',
            'shared_at' => now(),
        ]);

        return redirect()->away($whatsappUrl);
    }

    // Helper: Recalculate Report Totals
    private function updateReportTotals(DailyReport $report)
    {
        $report->update([
            'total_entries' => $report->workEntries()->count(),
            'total_duration_minutes' => $report->workEntries()->sum('duration_minutes'),
        ]);
    }
}