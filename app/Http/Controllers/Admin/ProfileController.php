<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin-backend.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $updatePayload = [
            'email' => (string) $data['email'],
        ];

        if (! empty($data['password'])) {
            $updatePayload['password'] = Hash::make((string) $data['password']);
        }

        if ($request->hasFile('profile_image')) {
            $updatePayload['profile_image'] = $request->file('profile_image')->store('admin-profiles', 'public');
        }

        $user->update($updatePayload);

        return back()->with('status', 'Profile updated successfully.');
    }
}
