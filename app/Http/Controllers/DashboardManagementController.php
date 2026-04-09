<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use App\Models\Tasks;

class DashboardManagementController extends Controller
{

    public function index()
    {
        $standBy = ActivityHistory::with('activity', 'user')
            ->whereHas('user')
            ->where('reference_type', 'ACTIVITY')
            ->whereNull('end_time')
            ->whereHas('activity', function ($query) {
                $query->where('location', 'IT OFFICE');
            })
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('activity_histories')
                    ->whereNull('deleted_at')
                    ->groupBy('user_id');
            })
            ->orWhere(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->whereHas('task', function ($t) {
                        $t->where('location', 'IT OFFICE');
                    })
                    ->whereNull('end_time')
                    ->whereIn('id', function ($q) {
                        $q->selectRaw('MAX(id)')
                            ->from('activity_histories')
                            ->whereNull('deleted_at')
                            ->groupBy('user_id');
                    });
            })
            ->latest()
            ->get();

        $outSide = ActivityHistory::with('activity', 'user', 'task',)
            ->whereHas('user')
            ->whereNull('end_time')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('activity_histories')
                    ->whereNull('deleted_at')
                    ->groupBy('user_id');
            })
            ->where(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->whereHas('task', function ($t) {
                        $t->where('location', '!=', 'IT OFFICE');
                    })
                    ->whereNull('end_time')
                    ->orWhere(function ($q) {
                        $q->where('reference_type', 'ACTIVITY')
                            ->whereHas('activity', function ($a) {
                                $a->where('location', '!=', 'IT OFFICE');
                            })
                            ->whereNull('end_time');
                    });
            })
            ->latest()
            ->get();

        $taskProgress = Tasks::with(['user', 'enduser', 'children'])
            ->whereHas('user')
            ->where('status', '!=', 'COMPLETED')
            ->where('task_level', 'DEPARTMENT')
            ->get()
            ->map(function ($task) {
                $totalWeight = $task->children->sum(fn($child) => (float) $child->task_load);
                $weightedProgress = $task->children->sum(fn($child) => (float) $child->task_load * ((float) $child->progress / 100));

                $task->progress = $totalWeight > 0
                    ? round(($weightedProgress / $totalWeight) * 100)
                    : 0;
                $completedCount = $task->children->where('status', 'COMPLETED')->count();
                $totalCount = $task->children->count();
                $task->progress_label = $completedCount . '/' . $totalCount;
                $task->progress_color = $task->progress == 100 ? 'bg-success' : ($task->progress >= 50 ? 'bg-info' : 'bg-warning');
                return $task;
            });

        $weight = Tasks::withSum('children', 'task_load')->get()->pluck('children_sum_task_load', 'id');
        return view('pages.dashboard_management.index', compact('standBy', 'outSide', 'taskProgress', 'weight'));
    }
}
