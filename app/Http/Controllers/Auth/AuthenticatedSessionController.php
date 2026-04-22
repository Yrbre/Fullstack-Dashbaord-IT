<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Activity;
use App\Models\ActivityHistory;
use App\Models\Tasks;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (in_array(Auth::user()->role, ['MANAGEMENT'])) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if (Auth::user()->id == 1) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $activityHisotry = ActivityHistory::where('user_id', $request->user()->id)
            ->whereNull('end_time')
            ->latest()
            ->first();

        if (!$activityHisotry) {
            $activity = Activity::where('id', '1')->first();
            ActivityHistory::create([
                'user_id' => $request->user()->id,
                'reference_id' => $activity->id,
                'reference_type' => "ACTIVITY",
                'location' => $activity->location,
                'status' => "LOGIN",
                'start_time' => now(),
            ]);
        }


        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $activityHistory = ActivityHistory::where('user_id', $request->user()->id)
            ->whereNull('end_time')
            ->latest()
            ->first();

        if ($activityHistory) {
            if ($activityHistory->reference_type === "TASK") {
                DB::transaction(function () use ($activityHistory, $request) {
                    $task = Tasks::find($activityHistory->reference_id); // fix typo

                    if ($task) {
                        $task->update([
                            'status' => 'ON HOLD'
                        ]);

                        // Update pivot hanya untuk user yang logout
                        $task->task_user()->updateExistingPivot($request->user()->id, [
                            'taken' => false  // fix: hanya user ini, field 'taken'
                        ]);
                    }

                    $activityHistory->update([
                        'status' => 'ON HOLD & LOGOUT',
                        'end_time' => now(),
                    ]);
                });
            } else {
                $activityHistory->update([
                    'status' => 'LOGOUT',
                    'end_time' => now(),
                ]);
            }
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();





        return redirect('/');
    }
}
