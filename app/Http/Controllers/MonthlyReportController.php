<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\WorkEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    public function monthly(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        $reports = DailyReport::whereYear('report_date', $year)
            ->whereMonth('report_date', $month)
            ->with(['workEntries.category', 'workEntries.branch', 'workEntries.asset', 'workEntries.ticket'])
            ->get();

        $allEntries = WorkEntry::whereHas('dailyReport', function ($q) use ($year, $month) {
            $q->whereYear('report_date', $year)->whereMonth('report_date', $month);
        })->get();

        $stats = [
            'total_working_days' => $reports->count(),
            'total_entries' => $allEntries->count(),
            'total_duration_minutes' => $allEntries->sum('duration_minutes'),
            'branches_visited' => $allEntries->pluck('branch_id')->filter()->unique()->count(),
            'tickets_handled' => $allEntries->pluck('ticket_id')->filter()->unique()->count(),
            'assets_handled' => $allEntries->pluck('asset_id')->filter()->unique()->count(),
        ];

        // Category-wise Breakdown
        $categoryBreakdown = $allEntries->groupBy('work_category_id')->map(function ($items) {
            return [
                'name' => $items->first()->category->name ?? 'Uncategorized',
                'count' => $items->count(),
                'duration' => $items->sum('duration_minutes'),
            ];
        });

        return view('reports.monthly_it_report', compact('stats', 'categoryBreakdown', 'year', 'month', 'reports'));
    }
}