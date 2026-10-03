<?php

namespace App\Http\Controllers;

use App\Models\WorkCategory;
use Illuminate\Http\Request;

class WorkCategoryController extends Controller
{
    public function index()
    {
        $categories = WorkCategory::latest()->get();
        return view('work_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:work_categories,name',
            'code' => 'nullable|string|max:10',
        ]);

        WorkCategory::create([
            'name' => $request->name,
            'code' => $request->code ?? strtoupper(substr(str_replace(' ', '', $request->name), 0, 4)),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'নতুন ওয়ার্ক ক্যাটাগরি যুক্ত করা হয়েছে!');
    }

    public function update(Request $request, WorkCategory $workCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:work_categories,name,' . $workCategory->id,
            'code' => 'nullable|string|max:10',
            'is_active' => 'required|boolean',
        ]);

        $workCategory->update($request->only('name', 'code', 'is_active'));

        return redirect()->back()->with('success', 'ওয়ার্ক ক্যাটাগরি আপডেট করা হয়েছে!');
    }

    public function destroy(WorkCategory $workCategory)
    {
        $workCategory->delete();
        return redirect()->back()->with('success', 'ওয়ার্ক ক্যাটাগরি ডিলিট করা হয়েছে!');
    }
}