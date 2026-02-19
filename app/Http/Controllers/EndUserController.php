<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetEndUserRequest;
use App\Http\Requests\StoreEndUserRequest;
use App\Http\Requests\UpdateEndUserRequest;
use App\Models\EndUser;
use Illuminate\Http\Request;

class EndUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetEndUserRequest $request)
    {
        $search = $request->validated();

        if (isset($search['search'])) {
            $endUser = EndUser::where('name', 'like', '%' . $search['search'] . '%')
                ->orWhere('department', 'like', '%' . $search['search'] . '%')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $endUser = EndUser::orderBy('name', 'asc')->get();
        }


        return view('pages.enduser.index', compact('endUser', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = EndUser::select('department')->distinct()->orderBy('department', 'asc')->pluck('department');
        return view('pages.enduser.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEndUserRequest $request)
    {
        $department = $request->validated()['department'] === 'other'
            ? $request->validated()['other_department']
            : $request->validated()['department'];

        EndUser::firstOrCreate([
            'name' => $request->validated()['name'],
            'department' => $department
        ]);

        return redirect()->route('enduser.index')->with('success', 'End User created successfully.');
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
        $endUser = EndUser::findOrFail($id);
        $department = EndUser::select('department')->distinct()->orderBy('department', 'asc')->pluck('department');
        return view('pages.enduser.edit', compact('endUser', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEndUserRequest $request, string $id)
    {
        $endUser = EndUser::findOrFail($id);

        $department = $request->validated()['department'] === 'other'
            ? $request->validated()['other_department']
            : $request->validated()['department'];

        $endUser->update([
            'name' => $request->validated()['name'],
            'department' => $department
        ]);

        return redirect()->route('enduser.index')->with('success', 'End User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $endUser = EndUser::findOrFail($id);
        $endUser->delete();

        return redirect()->route('enduser.index')->with('success', 'End User deleted successfully.');
    }
}
