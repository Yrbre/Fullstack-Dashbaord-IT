<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoutineWorkRequest;
use App\Http\Requests\UpdateRoutineWorkRequest;
use App\Models\EndUser;
use App\Models\Location;
use App\Models\RoutineWork;
use Illuminate\Support\Facades\DB;

class RoutineWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allRoutineWorks = RoutineWork::orderBy('owner_id', 'asc')->orderBy('name', 'asc')->get();
            $routineWorks = RoutineWork::where('owner_id', auth()->id())->get();
            return view('pages.routine_work.index', compact('routineWorks', 'allRoutineWorks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve routine works');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $locations  = Location::orderBy('building', 'asc')->orderBy('location', 'asc')->get();
            $endusers    = EndUser::whereNotNull('name')->orderBy('name', 'asc')->get();
            return view('pages.routine_work.create', compact('locations', 'endusers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load create form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoutineWorkRequest $request)
    {
        try {
            $data = $request->validated();
            DB::transaction(function () use ($data) {
                RoutineWork::create([
                    'owner_id'      => auth()->id(),
                    'name'          => $data['name'],
                    'location_id'   => $data['location_id'],
                    'enduser_id'    => $data['enduser_id'],
                    'duration'      => $data['duration'],
                    'description'   => $data['description'] ?? null,
                ]);
            });
            return redirect()->route('routine_works.index')->with('success', 'Routine work created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create routine work: ' . $e->getMessage())
                ->withInput();
        }
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
        try {
            $routineWork = RoutineWork::findOrFail($id);
            $locations  = Location::all();
            $endusers    = EndUser::whereNotNull('name')->get();
            return view('pages.routine_work.edit', compact('routineWork', 'locations', 'endusers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoutineWorkRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            DB::transaction(function () use ($id, $data) {
                $routineWork = RoutineWork::findOrFail($id);
                $routineWork->update($data);
            });
            return redirect()->route('routine_works.index')->with('success', 'Routine work updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update routine work: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $routineWork = RoutineWork::findOrFail($id);
            $routineWork->delete();
            return redirect()->route('routine_works.index')->with('success', 'Routine work deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete routine work: ' . $e->getMessage());
        }
    }
}
