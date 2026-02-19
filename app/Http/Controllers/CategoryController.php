<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetCategoryRequest $request)
    {

        $search = $request->validated();

        if (isset($search['search'])) {
            $category = Category::where('name', 'like', '%' . $search['search'] . '%')->get();
        } else {
            $category = Category::orderBy('name', 'asc')->get();
        }


        return view('pages.category.index', compact('category', 'search'));
    }
    public function create()
    {
        $category = Category::select('type')->distinct()->orderBy('type', 'asc')->pluck('type');
        return view('pages.category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $type = $request->validated()['type'] === 'other'
            ? $request->validated()['other_type']
            : $request->validated()['type'];

        Category::firstOrCreate([
            'name' => $request->validated()['name'],
            'type' => $type
        ]);
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $types = Category::select('type')->distinct()->orderBy('type', 'asc')->pluck('type');
        return view('pages.category.edit', compact('category', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $type = $request->validated()['type'] === 'other'
            ? $request->validated()['other_type']
            : $request->validated()['type'];

        $category->update([
            'name' => $request->validated()['name'],
            'type' => $type
        ]);
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
