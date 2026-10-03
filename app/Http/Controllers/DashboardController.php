<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            // Admin Metrics (All Branches)
            $totalBranches = Branch::count();
            $totalAssets = Asset::count();
            $activeAssets = Asset::whereIn('status', ['active', 'in_use'])->count();
            $repairAssets = Asset::where('status', 'in_repair')->count();
            $damagedAssets = Asset::whereIn('status', ['damaged', 'disposed', 'scrapped'])->count();

            $totalTickets = Ticket::count();
            $openTickets = Ticket::where('status', 'open')->count();
            $inProgressTickets = Ticket::where('status', 'in_progress')->count();
            $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->count();

            $recentTickets = Ticket::with(['asset', 'branch', 'user'])->latest()->take(5)->get();
            $recentAssets = Asset::with(['branch', 'assetCategory'])->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalBranches', 'totalAssets', 'activeAssets', 'repairAssets', 'damagedAssets',
                'totalTickets', 'openTickets', 'inProgressTickets', 'resolvedTickets',
                'recentTickets', 'recentAssets'
            ));
        } else {
            // Branch User Metrics (Filtered by user's branch)
            $branchId = $user->branch_id;
            $totalBranches = 1;

            $totalAssets = Asset::where('branch_id', $branchId)->count();
            $activeAssets = Asset::where('branch_id', $branchId)->whereIn('status', ['active', 'in_use'])->count();
            $repairAssets = Asset::where('branch_id', $branchId)->where('status', 'in_repair')->count();
            $damagedAssets = Asset::where('branch_id', $branchId)->whereIn('status', ['damaged', 'disposed', 'scrapped'])->count();

            $totalTickets = Ticket::where('branch_id', $branchId)->count();
            $openTickets = Ticket::where('branch_id', $branchId)->where('status', 'open')->count();
            $inProgressTickets = Ticket::where('branch_id', $branchId)->where('status', 'in_progress')->count();
            $resolvedTickets = Ticket::where('branch_id', $branchId)->whereIn('status', ['resolved', 'closed'])->count();

            $recentTickets = Ticket::where('branch_id', $branchId)->with(['asset', 'user'])->latest()->take(5)->get();
            $recentAssets = Asset::where('branch_id', $branchId)->with('assetCategory')->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalBranches', 'totalAssets', 'activeAssets', 'repairAssets', 'damagedAssets',
                'totalTickets', 'openTickets', 'inProgressTickets', 'resolvedTickets',
                'recentTickets', 'recentAssets'
            ));
        }
    }
}