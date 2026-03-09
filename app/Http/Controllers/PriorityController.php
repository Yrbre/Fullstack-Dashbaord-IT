<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use App\Models\Priority;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priority = Priority::all();
        return view('pages.priority.index', compact('priority'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.priority.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePriorityRequest $request)
    {
        $priority = Priority::firstOrCreate($request->validated());
        return redirect()->route('priority.index');
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
        $priority = Priority::findOrFail($id);
        return view('pages.priority.edit', compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriorityRequest $request, string $id)
    {
        $priority = Priority::findOrFail($id);
        $priority->update($request->validated());
        return redirect()->route('priority.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priority = Priority::findOrFail($id);
        $priority->delete();
        return redirect()->route('priority.index');
    }
}
