<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateActivityHistoryRequest;
use App\Models\ActivityHistory;

class ActivityHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activity_history = ActivityHistory::with(['user', 'task.enduser', 'activity'])->orderBy('created_at', 'desc')->get();
        return view('pages.activity_history.index', compact('activity_history'));
    }

    public function show(string $id)
    {
        $activityHistory = ActivityHistory::with(['task.enduser', 'activity'])->findOrFail($id);
        return view('pages.activity_history.show', compact('activityHistory'));
    }

    public function edit(string $id)
    {
        $activityHistory = ActivityHistory::findOrFail($id);
        return view('pages.activity_history.edit', compact('activityHistory'));
    }

    public function update(UpdateActivityHistoryRequest $request, string $id)
    {
        $activityHistory = ActivityHistory::findOrFail($id);
        $activityHistory->update($request->validated());
        return redirect()->route('activity_history.index')->with('success', 'Activity history updated successfully.');
    }

    public function destroy(string $id)
    {
        $activityHistory = ActivityHistory::findOrFail(($id));
        $activityHistory->delete();
        return redirect()->route('activity_history.index')->with('success', 'Activity history deleted successfully.');
    }
}
