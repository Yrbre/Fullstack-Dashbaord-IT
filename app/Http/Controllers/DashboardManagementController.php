<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\ActivityHistory;
use App\Models\Tasks;
use Carbon\Carbon;

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
                $query->whereIn('reference_type', ['TASK', 'JOB'])
                    ->whereHas('task', function ($t) {
                        $t->where('location', 'like', '%IT OFFICE%');
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
                $query->whereIn('reference_type', ['TASK', 'JOB'])
                    ->whereHas('task', function ($t) {
                        $t->where('location', 'not like', '%IT OFFICE%');
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

        $taskProgress = Tasks::with(['user', 'enduser', 'children', 'category'])
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

                Tasks::where('id', $task->id)->update(['progress' => $task->progress]);
                return $task;
            });

        $taskCompleted = Tasks::with(['user', 'enduser', 'children', 'category'])
            ->whereHas('user')
            ->where('status', 'COMPLETED')
            ->where('task_level', 'DEPARTMENT')
            ->get();

        $weight = Tasks::withSum('children', 'task_load')->get()->pluck('children_sum_task_load', 'id');

        // Logika untuk menampilkan data absen hanya sampai pukul 16:30
        $cutoff = Carbon::today()->setTime(16, 30);
        if (Carbon::now()->gt($cutoff)) {
            // Sudah lewat 16:30 → kosongkan hasil
            $absences = collect();
        } else {
            // Masih sebelum 16:30 → ambil data hari ini sampai 16:30
            $absences = Absen::with('user')
                ->whereBetween('absent_at', [
                    Carbon::today(),
                    $cutoff
                ])
                ->get();
        }
        return view('pages.dashboard_management.index', compact('standBy', 'outSide', 'taskProgress', 'weight', 'absences', 'taskCompleted'));
    }
}
