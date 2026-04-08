<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Activity;
use App\Models\ActivityHistory;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (in_array(Auth::user()->role, ['ADMIN', 'MANAGEMENT'])) {
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
            $activityHistory->update([
                'status' => 'LOGOUT',
                'end_time' => now(),
            ]);
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();





        return redirect('/');
    }
}
