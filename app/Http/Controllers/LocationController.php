<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLocationRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;


class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetLocationRequest $request)
    {

        $location = Location::orderBy('location', 'asc')->get();


        return view('pages.location.index', compact('location'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {

        $request->validated();

        Location::firstOrCreate([
            'location' => $request->location,
            'building' => $request->building
        ]);

        return redirect()->route('location.index')->with('success', 'Location created successfully.');
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
        $location       = Location::findOrFail($id);

        return view('pages.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, string $id)
    {
        $location = Location::findOrFail($id);
        $request->validated();


        $location->update([
            'location' => $request->location,
            'building' => $request->building
        ]);
        return redirect()->route('location.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('location.index')->with('success', 'Location deleted successfully.');
    }
}
