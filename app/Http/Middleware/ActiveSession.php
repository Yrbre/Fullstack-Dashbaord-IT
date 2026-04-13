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
        $allowRoles = ['OPERATOR', 'ADMIN', 'MANAGEMENT'];
        if (!$user || !in_array($user->role, $allowRoles)) {
            return $next($request);
        }

        $activeTaskSession = ActivityHistory::query()
            ->where('user_id', $user->id)
            ->whereNull('end_time')
            ->where(function ($query) {
                $query->where('reference_type', 'TASK')
                    ->orWhere(function ($query) {
                        $query->where('reference_type', 'ACTIVITY')
                            ->where('reference_id', '!=', 1);
                    });
            })
            ->latest()
            ->first();


        if (!$activeTaskSession) {
            return $next($request);
        }

        $redirect = $activeTaskSession->reference_type === 'ACTIVITY'
            ? redirect()->route('dashboard_operator.idle', $activeTaskSession->id)
            : redirect()->route('dashboard_operator.index');


        return $redirect->with('error', 'Selesaikan Activity Anda Terlebih Dahulu');
    }
}
