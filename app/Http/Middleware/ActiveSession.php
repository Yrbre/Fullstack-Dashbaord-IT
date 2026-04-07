<?php

namespace App\Http\Middleware;

use App\Models\ActivityHistory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveSession
{
    public function handle(Request $request, Closure $next)
    {
        // Only guard the actions that start a new assignment; other menus should remain accessible.
        if (!$request->routeIs('active_task.index', 'dashboard_operator.take')) {
            return $next($request);
        }

        $user = Auth::user();
        if (!$user || $user->role !== 'OPERATOR') {
            return $next($request);
        }

        $activeTaskSession = ActivityHistory::query()
            ->where('user_id', $user->id)
            ->whereIn('reference_type', ['TASK', 'ACTIVITY'])
            ->whereNull('end_time')
            ->where(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->orWhere(function ($query) {
                        $query->where('reference_type', 'ACTIVITY')
                            ->whereHas('activity', function ($q) {
                                $q->where('id', '!=', '1');
                            });
                    });
            })
            ->latest()
            ->first();

        if (!$activeTaskSession) {
            return $next($request);
        }

        return redirect()
            ->route('dashboard_operator.index', $activeTaskSession->reference_id)
            ->with('error', 'Selesaikan Activity Anda Terlebih Dahulu');
    }
}
