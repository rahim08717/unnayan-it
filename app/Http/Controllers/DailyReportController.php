<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\DailyReport;
use App\Models\WorkEntry;
use App\Models\WorkEntryAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyReport::with(['user', 'workEntries.branch', 'workEntries.asset', 'workEntries.attachments']);

        if ($request->filled('date')) {
            $query->where('report_date', $request->date);
        }

        if ($request->filled('branch_id')) {
            $query->whereHas('workEntries', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        $reports = $query->latest('report_date')->paginate(10);
        $branches = Branch::all();

        return view('daily_reports.index', compact('reports', 'branches'));
    }

    public function create()
    {
        $branches = Branch::all();
        $assets = Asset::all();
        return view('daily_reports.create', compact('branches', 'assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'entries' => 'required|array|min:1',
            'entries.*.title' => 'required|string|max:255',
            'entries.*.category' => 'required|string',
            'entries.*.duration_minutes' => 'required|integer|min:1',
            'entries.*.description' => 'nullable|string',
            'entries.*.branch_id' => 'nullable|exists:branches,id',
            'entries.*.asset_id' => 'nullable|exists:assets,id',
            'entries.*.attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,doc,docx|max:51200',
        ]);

        $report = DailyReport::create([
            'user_id' => Auth::id(),
            'report_date' => $request->report_date,
            'notes' => $request->notes,
            'status' => 'submitted',
        ]);

        foreach ($request->entries as $entryData) {
            $workEntry = $report->workEntries()->create([
                'branch_id' => $entryData['branch_id'] ?? null,
                'asset_id' => $entryData['asset_id'] ?? null,
                'title' => $entryData['title'],
                'category' => $entryData['category'],
                'duration_minutes' => $entryData['duration_minutes'],
                'description' => $entryData['description'] ?? null,
            ]);

            if (isset($entryData['attachments'])) {
                foreach ($entryData['attachments'] as $file) {
                    $mime = $file->getMimeType();

                    if (str_contains($mime, 'image')) {
                        $fileType = 'image';
                    } elseif (str_contains($mime, 'video')) {
                        $fileType = 'video';
                    } else {
                        $fileType = 'document';
                    }

                    $path = $file->store('report_attachments', 'public');

                    WorkEntryAttachment::create([
                        'work_entry_id' => $workEntry->id,
                        'file_path' => $path,
                        'file_type' => $fileType,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }
        }

        return redirect()->route('daily-reports.index')->with('success', 'ডেইলি ওয়ার্কিং রিপোর্ট সফলভাবে তৈরি হয়েছে।');
    }

    public function show($id)
    {
        $report = DailyReport::with(['user', 'workEntries.branch', 'workEntries.asset', 'workEntries.attachments'])->findOrFail($id);
        return view('daily_reports.show', compact('report'));
    }

    public function history(Request $request)
    {
        $branches = Branch::all();
        $assets = Asset::all();

        $query = WorkEntry::with(['dailyReport.user', 'branch', 'asset', 'attachments']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('asset_id')) {
            $query->where('asset_id', $request->asset_id);
        }

        $historyEntries = $query->latest()->paginate(15);

        return view('daily_reports.history', compact('historyEntries', 'branches', 'assets'));
    }

    public function printPdf($id)
    {
        $report = DailyReport::with(['user', 'workEntries.branch', 'workEntries.asset', 'workEntries.attachments'])->findOrFail($id);
        return view('daily_reports.print', compact('report'));
    }

    public function destroy($id)
    {
        $report = DailyReport::findOrFail($id);

        foreach ($report->workEntries as $entry) {
            foreach ($entry->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $report->delete();

        return redirect()->route('daily-reports.index')->with('success', 'রিপোর্টটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}