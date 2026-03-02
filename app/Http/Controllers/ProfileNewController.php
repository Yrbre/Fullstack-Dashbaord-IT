<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileNewRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileNewController extends Controller
{
    public function edit(string $id)
    {
        $user = auth()->user();
        return view('pages.profile.edit', compact('user'));
    }

    public function update(UpdateProfileNewRequest $request)
    {

        $user = User::findOrFail(auth()->id());
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('user-images', 'public');
        } else {
            $data['photo'] = $user->photo;
        }

        $user->update($data);

        $route = match ($user->role) {
            'OPERATOR' => 'dashboard_operator.index',
            'MANAGEMENT' => 'dashboard_management.index',
            default => 'dashboard',
        };

        return redirect()->route($route)->with('success', 'Profile updated successfully.');
    }
}
