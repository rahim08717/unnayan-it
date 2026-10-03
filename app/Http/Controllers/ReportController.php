<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Ticket;
use App\Models\Branch;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $activeAssets = Asset::where('status', 'active')->count();
        $repairAssets = Asset::where('status', 'in_repair')->count();
        $scrappedAssets = Asset::where('status', 'scrapped')->count();

        $totalTickets = Ticket::count();
        $openTickets = Ticket::whereIn('status', ['open', 'in_progress'])->count();
        $closedTickets = Ticket::where('status', 'closed')->count();

        $branches = Branch::withCount(['assets', 'tickets'])->get();

        return view('reports.index', compact(
            'totalAssets', 'activeAssets', 'repairAssets', 'scrappedAssets',
            'totalTickets', 'openTickets', 'closedTickets', 'branches'
        ));
    }

    public function exportAssets()
    {
        $fileName = 'assets_report_' . date('Y-m-d') . '.csv';
        $assets = Asset::with(['branch', 'assignedUser', 'assetCategory'])->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Asset Tag', 'Item Name', 'Category', 'Branch', 'Assigned To', 'Status', 'Purchase Cost'];

        $callback = function() use($assets, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel Bengali character compatibility
            fputcsv($file, $columns);

            foreach ($assets as $asset) {
                $categoryName = $asset->assetCategory->name ?? (is_object($asset->category) ? $asset->category->name : ($asset->category ?? 'N/A'));
                
                fputcsv($file, [
                    $asset->asset_tag,
                    $asset->name,
                    $categoryName,
                    $asset->branch->name ?? 'N/A',
                    $asset->assignedUser->name ?? ($asset->employee->name ?? 'Unassigned'),
                    ucfirst($asset->status),
                    $asset->purchase_cost ?? '0.00'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}