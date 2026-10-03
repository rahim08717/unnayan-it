<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Branch;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['branch', 'asset', 'user']);

        // Filter tickets by user's branch if non-admin
        if (!auth()->user()->isAdmin()) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        // Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority Filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $userBranchId = auth()->user()->branch_id;

        if (auth()->user()->isAdmin()) {
            $assets = Asset::all();
            $branches = Branch::where('is_active', true)->get();
        } else {
            $assets = Asset::where('branch_id', $userBranchId)->get();
            $branches = Branch::where('id', $userBranchId)->get();
        }

        return view('tickets.create', compact('assets', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'branch_id' => 'required|exists:branches,id',
            'asset_id' => 'nullable|exists:assets,id',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['ticket_number'] = 'TICK-' . strtoupper(uniqid());
        $validated['status'] = 'open';

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'সাপোর্ট টিকিট সফলভাবে তৈরি করা হয়েছে!');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['branch', 'asset', 'user', 'comments.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)->with('success', 'টিকিটের স্ট্যাটাস আপডেট করা হয়েছে!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'টিকিট ডিলিট করা হয়েছে!');
    }
}