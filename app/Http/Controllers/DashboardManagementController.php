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
            ->whereHas('activity', function ($query) {
                $query->where('location', 'IT OFFICE');
            })
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('activity_histories')
                    ->whereNull('deleted_at')
                    ->groupBy('user_id');
            })
            ->latest()
            ->get();

        $outSide = ActivityHistory::with('activity', 'user', 'task')
            ->whereHas('user')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('activity_histories')
                    ->whereNull('deleted_at')
                    ->groupBy('user_id');
            })
            ->where(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->orWhere(function ($q) {
                        $q->where('reference_type', 'ACTIVITY')
                            ->whereHas('activity', function ($a) {
                                $a->where('location', '!=', 'IT OFFICE');
                            });
                    });
            })
            ->latest()
            ->get();

        $taskProgress = Tasks::with('user', 'enduser')
            ->withCount([
                'children',
                'children as completed_children_count' => function ($query) {
                    $query->where('status', 'COMPLETED');
                }
            ])
            ->whereHas('user')
            ->where('status', '!=', 'COMPLETED')
            ->where('task_level', 'DEPARTMENT')
            ->get()
            ->map(function ($task) {
                $task->progress = $task->children_count > 0
                    ? round(($task->completed_children_count / $task->children_count) * 100)
                    : 0;
                $task->progress_label = $task->completed_children_count . '/' . $task->children_count;
                $task->progress_color = $task->progress == 100 ? 'bg-success' : ($task->progress >= 50 ? 'bg-info' : 'bg-warning');
                return $task;
            });

        return view('pages.dashboard_management.index', compact('standBy', 'outSide', 'taskProgress'));
    }
}
