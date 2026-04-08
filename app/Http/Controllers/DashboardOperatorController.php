<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskActiveRequest;
use App\Models\Activity;
use App\Models\ActivityHistory;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardOperatorController extends Controller
{
    public function index()
    {
        // Card Active Job hanya menampilkan task yang masih berjalan.
        $activeSession = ActivityHistory::with('task', 'activity')
            ->where('user_id', auth()->id())
            ->whereNull('end_time')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('reference_type', 'ACTIVITY')
                        ->where('reference_id', '!=', 1);
                })->orWhere(function ($q) {
                    $q->where('reference_type', 'TASK');
                });
            })
            ->latest()
            ->first();





        $activityList = Activity::where('id', '!=', '1')
            ->orderBy('name', 'asc')
            ->get();

        $taskReady = Auth::user()
            ->user_task()
            ->with('deliveredUser')
            ->where('task_level', 'PERSONAL')
            ->where('status', '!=', 'COMPLETED')
            ->get();

        $taskCompleted = Auth::user()
            ->user_task()
            ->where('status', 'COMPLETED')
            ->where('task_level', 'PERSONAL')
            ->get();
        return view('pages.dashboard_operator.index', compact('activityList', 'taskReady', 'taskCompleted', 'activeSession'));
    }

    public function takeActivity(string $id)
    {
        $activityHistory = ActivityHistory::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->latest()
            ->first();
        if (!empty($activityHistory)) {
            $activityHistory->update([
                'end_time' => now()->format('Y-m-d H:i:s'),
            ]);
        }
        $activity = Activity::findOrFail($id);

        $activityHistory = ActivityHistory::create([
            'user_id'           => auth()->id(),
            'reference_id'      => $activity->id,
            'reference_type'    => 'ACTIVITY',
            'location'          => $activity->location,
            'start_time'        => now(),

        ]);
        return redirect()->route('dashboard_operator.idle', $activityHistory->id)->with('success', 'Activity taken successfully.');
    }

    public function takeTask(string $id)
    {

        $activityHistory = ActivityHistory::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->latest()
            ->first();
        if (!empty($activityHistory)) {
            $activityHistory->update([
                'end_time' => now()->format('Y-m-d H:i:s'),
            ]);
        }
        $task = Tasks::findOrFail($id);

        $task->update([
            'status' => 'ON DUTY',
        ]);


        $task->where('id', $task->id)
            ->where('progress', 0)
            ->update([
                'progress' => 10,
            ]);

        $task->where('id', $task->id)
            ->whereNull('actual_start')
            ->update(['actual_start' => now()->format('Y-m-d H:i:s'),]);

        $relationTask = $task->relation_task ? Tasks::where('id', $task->relation_task)->first() : null;
        if ($relationTask && $relationTask->status != 'ON PROGRESS') {
            $relationTask->update([
                'status' => 'ON PROGRESS',
            ]);

            $relationTask->where('id', $relationTask->id)
                ->where('progress', 0)
                ->update([
                    'progress' => 10,
                ]);

            $relationTask->where('id', $relationTask->id)
                ->whereNull('actual_start')
                ->update(['actual_start' => now()->format('Y-m-d H:i:s'),]);
        }


        ActivityHistory::create([
            'user_id'           => auth()->id(),
            'reference_id'      => $task->id,
            'reference_type'    => 'TASK',
            'location'          => $task->location->location ?? null,
            'start_time'        => now(),
        ]);

        return redirect()->route('dashboard_operator.index')->with('success', 'Task taken successfully.');
    }

    public function idleTask(string $id)
    {
        $task = Tasks::findOrFail($id);
        return view('pages.dashboard_operator.idle_task', compact('task'));
    }

    public function completeActivity(string $id)
    {
        $activityHistory = ActivityHistory::findOrFail($id);
        if ($activityHistory->reference_type == 'TASK') {
            $activityHistory->update([
                'end_time' => now()->format('Y-m-d H:i:s'),
            ]);

            $standby = Activity::where('id', '1')->first();

            ActivityHistory::create([
                'user_id'           => auth()->id(),
                'reference_id'      => $standby->id,
                'reference_type'    => 'ACTIVITY',
                'location'          => $standby->location,
                'start_time'        => now(),
            ]);
        } elseif ($activityHistory->reference_type == 'ACTIVITY') {
            $activityHistory->update([
                'end_time' => now()->format('Y-m-d H:i:s'),
            ]);
            $standby = Activity::where('id', '1')->first();
            ActivityHistory::create([
                'user_id'           => auth()->id(),
                'reference_id'      => $standby->id,
                'reference_type'    => 'ACTIVITY',
                'location'          => $standby->location,
                'start_time'        => now(),
            ]);
        }


        return redirect()->route('dashboard_operator.index')->with('success', 'Activity completed successfully.');
    }

    public function idle(string $id)
    {
        $activityHistory = ActivityHistory::findOrFail($id);
        return view('pages.dashboard_operator.idle', compact('activityHistory'));
    }

    public function updateTask(UpdateTaskActiveRequest $request, string $id,)
    {
        $task = Tasks::findOrFail($id);
        $data = $request->validated();


        if ($request->status === 'COMPLETED') {
            $task->update([
                'actual_end' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        if ($task->actual_end && $task->schedule_end) {
            $actualEnd = Carbon::parse($task->actual_end);
            $scheduleEnd = Carbon::parse($task->schedule_end);
            if ($actualEnd->greaterThan($scheduleEnd)) {
                $task->update([
                    'in_timeline' => false,
                ]);
            }
        } else {
            $task->update([
                'in_timeline' => true,
            ]);
        }


        $task->update([
            'progress'      => $request['progress'] ?? $task->progress,
            'status'        => $request['status'] ?? $task->status,
            'description'   => $request['description'] ?? $task->description,
            'in_timeline'   => $task->in_timeline,
        ]);



        if ($request->status == 'ON DUTY') {
            return redirect()->route('dashboard_operator.idle_task', $task->id)->with('success', 'Task updated successfully.');
        } else {

            $activityHistory = ActivityHistory::where('reference_type', 'TASK')
                ->where('reference_id', $task->id)
                ->where('user_id', auth()->id())
                ->latest()
                ->firstOrFail();

            $activityHistory->update([
                'status' => $request->status,
                'end_time' => now()->format('Y-m-d H:i:s'),
            ]);


            $standby = Activity::where('id', '1')->first();

            ActivityHistory::create([
                'user_id'           => auth()->id(),
                'reference_id'      => $standby->id,
                'reference_type'    => 'ACTIVITY',
                'location'          => $standby->location,
                'start_time'        => now(),
            ]);
        }



        return redirect()->route('dashboard_operator.index')->with('success', 'Task updated successfully.');
    }
}
