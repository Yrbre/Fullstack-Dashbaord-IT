<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivtiyRequest;
use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetActivityRequest $request)
    {
        $search = $request->validated();

        if (isset($search['search'])) {
            $activity = Activity::where('name', 'like', '%' . $search['search'] . '%')->get();
        } else {
            $activity = Activity::orderBy('name', 'asc')->get();
        }

        return view('pages.activity.index', compact('activity', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activity = Activity::select('location')->distinct()->orderBy('location', 'asc')->pluck('location');
        return view('pages.activity.create', compact('activity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $location = $request->validated()['location'] === 'other'
            ? $request->validated()['other_location']
            : $request->validated()['location'];

        Activity::firstOrCreate([
            'name' => $request->validated()['name'],
            'location' => $location,
            'description' => $request->validated()['description'],
        ]);

        return redirect()->route('activity.index')->with('success', 'Activity created successfully.');
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
        $activity = Activity::findOrFail($id);
        $location = Activity::select('location')->distinct()->orderBy('location', 'asc')->pluck('location');
        return view('pages.activity.edit', compact('activity', 'location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivtiyRequest $request, string $id)
    {
        $activtiy = Activity::findOrFail($id);

        $location = $request->validated()['location'] === 'other'
            ? $request->validated()['other_location']
            : $request->validated()['location'];

        $activtiy->update([
            'name' => $request->validated()['name'],
            'location' => $location,
            'description' => $request->validated()['description'],
        ]);
        return redirect()->route('activity.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->route('activity.index')->with('success', 'Activity deleted successfully.');
    }
}
