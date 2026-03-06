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

        $taskProgress = Tasks::with('user')
            ->whereHas('user')
            ->where('status', '!=', 'COMPLETED')
            ->where('task_level', 'DEPARTMENT')
            ->get();

        return view('pages.dashboard_management.index', compact('standBy', 'outSide', 'taskProgress'));
    }
}
