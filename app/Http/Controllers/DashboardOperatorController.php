<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskActiveRequest;
use App\Models\Activity;
use App\Models\ActivityHistory;
use App\Models\Tasks;

class DashboardOperatorController extends Controller
{
    public function index()
    {
        // Jika user masih punya sesi aktif (belum isi end_time), redirect ke idle
        // Kecuali sesi aktif tersebut adalah activity dengan nama STAND BY
        $activeSession = ActivityHistory::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->where(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->orWhere(function ($query) {
                        $query->where('reference_type', 'ACTIVITY')
                            ->whereHas('activity', function ($q) {
                                $q->where('name', '!=', 'STAND BY');
                            });
                    });
            })
            ->latest()
            ->first();


        if ($activeSession) {
            if ($activeSession->reference_type === 'TASK') {
                return redirect()->route('dashboard_operator.idle_task', $activeSession->reference_id)
                    ->with('warning', 'Selesaikan task Anda sebelum mengambil yang baru.');
            } else {
                return redirect()->route('dashboard_operator.idle', $activeSession->id)
                    ->with('warning', 'Selesaikan activity Anda sebelum mengambil yang baru.');
            }
        }

        $activityList = Activity::where('name', '!=', 'STAND BY')
            ->get();

        $taskReady = Tasks::where('status', '!=', 'COMPLETED')
            ->where('assign_to', Auth()->id())
            ->where('task_level', 'PERSONAL')
            ->get();
        return view('pages.dashboard_operator.index', compact('activityList', 'taskReady'));
    }

    public function takeActivity(string $id)
    {
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

        return redirect()->route('dashboard_operator.idle_task', $task->id)
            ->with('success', 'Task taken successfully.');
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

            $standby = Activity::where('name', 'STAND BY')->first();
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
            $standby = Activity::where('name', 'STAND BY')->first();
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
        $activityHistory = ActivityHistory::where('reference_type', 'TASK')
            ->where('reference_id', $task->id)
            ->whereNull('end_time')
            ->firstOrFail();


        $task->update([
            'progress'      => $request['progress'] ?? $task->progress,
            'status'        => $request['status'] ?? $task->status,
            'description'   => $request['description'] ?? $task->description,
        ]);

        if ($request->status === 'COMPLETED') {
            $task->update([
                'actual_end' => now()->format('Y-m-d H:i:s'),
            ]);
        }


        $activityHistory->update([
            'end_time' => now()->format('Y-m-d H:i:s'),
        ]);

        $standby = Activity::where('name', 'STAND BY')->first();

        ActivityHistory::create([
            'user_id'           => auth()->id(),
            'reference_id'      => $standby->id,
            'reference_type'    => 'ACTIVITY',
            'location'          => $standby->location,
            'start_time'        => now(),
        ]);

        return redirect()->route('dashboard_operator.index')->with('success', 'Task updated successfully.');
    }
}
