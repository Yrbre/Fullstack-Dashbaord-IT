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
            $allRoutineWorks = RoutineWork::orderBy('name', 'asc')->get();
            return view('pages.routine_work.index', compact('allRoutineWorks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve routine works' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('pages.routine_work.create');
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
                    'name'          => $data['name'],
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
            return view('pages.routine_work.edit', compact('routineWork'));
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
