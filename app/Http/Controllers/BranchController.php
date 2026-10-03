<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the branches.
     */
    public function index()
    {
        $branches = Branch::withCount('users')->latest()->paginate(10);
        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code',
            'region' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Branch::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'region' => $request->region,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('branches.index')->with('success', 'ব্র্যাঞ্চ সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'region' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $branch->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'region' => $request->region,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('branches.index')->with('success', 'ব্র্যাঞ্চের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy(Branch $branch)
    {
        if ($branch->users()->count() > 0) {
            return redirect()->route('branches.index')->with('error', 'এই ব্র্যাঞ্চে ইউজার যুক্ত রয়েছে, তাই ডিলিট করা সম্ভব নয়।');
        }

        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'ব্র্যাঞ্চ সফলভাবে মুছে ফেলা হয়েছে।');
    }
}