<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEndUserDepartmentRequest;
use App\Models\EndUser;
use Illuminate\Http\Request;

class EndUserDepartmentController extends Controller
{
    public function index()
    {
        $department = EndUser::whereNull('name')->get();
        return view('pages.enduser_department.index', compact('department'));
    }

    public function edit(string $id)
    {
        $department = EndUser::findOrFail($id);
        return view('pages.enduser_department.edit', compact('department'));
    }

    public function update(UpdateEndUserDepartmentRequest $request, string $id)
    {
        $department = EndUser::findOrFail($id);
        $department->update($request->validated());

        return redirect()->route('enduser_department.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(string $id)
    {
        $department = EndUser::findOrFail($id);
        $department->delete();

        return redirect()->route('enduser_department.index')->with('success', 'Department deleted successfully.');
    }
}
