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
        $search = $request->validated();

        if (isset($search['search'])) {
            $location = Location::where('department', 'like', '%' . $search['search'] . '%')
                ->orWhere('location', 'like', '%' . $search['search'] . '%')
                ->orderBy('department', 'asc')
                ->get();
        } else {
            $location = Location::orderBy('department', 'asc')->get();
        }

        return view('pages.location.index', compact('location', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = Location::select('department')->distinct()->orderBy('department', 'asc')->pluck('department');
        $location   = Location::select('location')->distinct()->orderBy('location', 'asc')->pluck('location');

        return view('pages.location.create', compact('department', 'location'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        $departmentOther = $request->validated()['department'] === 'other'
            ? $request->validated()['other_department']
            : $request->validated()['department'];

        $locationOther = $request->validated()['location'] === 'other'
            ? $request->validated()['other_location']
            : $request->validated()['location'];

        Location::firstOrCreate([
            'department' => $departmentOther,
            'location' => $locationOther
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
        $department     = Location::select('department')->distinct()->orderBy('department', 'asc')->pluck('department');
        $locationList   = Location::select('location')->distinct()->orderBy('location', 'asc')->pluck('location');
        return view('pages.location.edit', compact('location', 'department', 'locationList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, string $id)
    {
        $location = Location::findOrFail($id);

        $departmentOther = $request->validated()['department'] === 'other'
            ? $request->validated()['other_department']
            : $request->validated()['department'];

        $locationOther = $request->validated()['location'] === 'other'
            ? $request->validated()['other_location']
            : $request->validated()['location'];

        $location->update([
            'department' => $departmentOther,
            'location' => $locationOther
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
