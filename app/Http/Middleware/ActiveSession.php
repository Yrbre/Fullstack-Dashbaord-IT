<?php

namespace App\Http\Middleware;

use App\Models\ActivityHistory;
use Closure;
use Illuminate\Http\Request;

class ActiveSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        // Hindari infinite loop
        if (
            $request->routeIs('dashboard_operator.idle_task') ||
            $request->routeIs('dashboard_operator.idle') ||
            $request->routeIs('dashboard_operator.update_task') ||
            $request->routeIs('dashboard_operator.complete')
        ) {
            return $next($request);
        }

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
                return redirect()
                    ->route('dashboard_operator.idle_task', $activeSession->reference_id)
                    ->with('warning', 'Selesaikan task Anda sebelum mengambil yang baru.');
            }

            return redirect()
                ->route('dashboard_operator.idle', $activeSession->id)
                ->with('warning', 'Selesaikan activity Anda sebelum mengambil yang baru.');
        }

        return $next($request);
    }
}
