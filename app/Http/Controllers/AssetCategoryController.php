<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name',
            'code' => 'nullable|string|max:10|unique:asset_categories,code',
            'description' => 'nullable|string',
        ]);

        AssetCategory::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Asset Category created successfully.');
    }

    public function show(AssetCategory $category)
    {
        return view('categories.index', compact('category'));
    }

    public function edit(AssetCategory $category)
    {
        return view('categories.index', compact('category'));
    }

    public function update(Request $request, AssetCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name,' . $category->id,
            'code' => 'nullable|string|max:10|unique:asset_categories,code,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Asset Category updated successfully.');
    }

    public function destroy(AssetCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Asset Category deleted successfully.');
    }
}