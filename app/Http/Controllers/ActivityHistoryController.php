<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateActivityHistoryRequest;
use App\Models\ActivityHistory;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function list(string $id)
    {
        $user = User::findOrFail($id);
        $taskList = Tasks::with('enduser', 'location')
            ->where('assign_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.activity_history.showListActivityUser', compact('taskList', 'user'));
    }

    public function listFilter(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $query = ActivityHistory::with('user', 'task', 'activity')
            ->where('user_id', $user->id);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        } elseif ($request->filled('filter')) {
            $filterMap = [
                '1d'  => now()->subDay(),
                '7d'  => now()->subDays(7),
                '1m'  => now()->subMonth(),
                '1y'  => now()->subYear(),
            ];

            if (isset($filterMap[$request->filter])) {
                $query->where('start_time', '>=', $filterMap[$request->filter]);
            }
        }

        $activityHistory = $query->orderBy('created_at', 'desc')->get();

        return response()->json($activityHistory->map(function ($item) {
            return [
                'activity_name' => $item->reference_type === 'ACTIVITY'
                    ? ($item->activity->name ?? '-')
                    : ($item->task->name ?? '-'),
                'location'       => $item->location,
                'reference_type' => $item->reference_type,
                'start_time'     => \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i'),
                'end_time'       => $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d-m-Y H:i') : '-',
            ];
        }));
    }
}
