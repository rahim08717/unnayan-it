<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with(['branch', 'assetCategory', 'vendor', 'assignedUser']);

        // Non-admin users only see assets of their assigned branch
        if (!auth()->user()->isAdmin()) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        // Search Query (Tag, Name, Serial Number)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asset_tag', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('serial_number', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('asset_category_id', $request->category_id);
        }

        // Branch Filter (For Admin)
        if ($request->filled('branch_id') && auth()->user()->isAdmin()) {
            $query->where('branch_id', $request->branch_id);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->latest()->paginate(10)->withQueryString();
        $categories = AssetCategory::all();
        $branches = Branch::where('is_active', true)->get();

        return view('assets.index', compact('assets', 'categories', 'branches'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        $branches = Branch::where('is_active', true)->get();
        $vendors = Vendor::all();
        $employees = Employee::all();

        return view('assets.create', compact('categories', 'branches', 'vendors', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_tag' => 'required|unique:assets,asset_tag',
            'name' => 'required|string|max:255',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'branch_id' => 'required|exists:branches,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'warranty_months' => 'nullable|integer',
            'vendor_id' => 'nullable|exists:vendors,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,in_use,in_repair,damaged,scrapped,disposed',
            'notes' => 'nullable|string',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'নতুন IT অ্যাসেট সফলভাবে যুক্ত করা হয়েছে!');
    }

    public function show(Asset $asset)
    {
        $asset->load(['branch', 'assetCategory', 'vendor', 'assignedUser', 'tickets']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        $branches = Branch::where('is_active', true)->get();
        $vendors = Vendor::all();
        $employees = Employee::all();

        return view('assets.edit', compact('asset', 'categories', 'branches', 'vendors', 'employees'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_tag' => 'required|unique:assets,asset_tag,' . $asset->id,
            'name' => 'required|string|max:255',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'branch_id' => 'required|exists:branches,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number,' . $asset->id,
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'warranty_months' => 'nullable|integer',
            'vendor_id' => 'nullable|exists:vendors,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,in_use,in_repair,damaged,scrapped,disposed',
            'notes' => 'nullable|string',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'অ্যাসেটের তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'অ্যাসেট সফলভাবে ডিলিট করা হয়েছে!');
    }
}