<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function settings() {
        return view('admin.profile.settings');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Str::slug($user->name) . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('user/avatar/');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }

            $avatar->move($path, $filename);
            $user->avatar = 'user/avatar/' . $filename;
        }

        $user->save();
        return back()->with('success', 'Request has been completed');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
