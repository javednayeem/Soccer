<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;

use App\User;

class ProfileController extends Controller {

    public function index() {

        $user = Auth::user();

        return view('admin.profile.index', [
            'user' => $user
        ]);
    }


    public function editProfile(Request $request) {

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('user_image')) {
            // Delete old image if it's not the default
            if ($user->user_image !== 'default_user.png') {
                $oldImagePath = public_path('admin/images/users/' . $user->user_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('user_image');
            $user_img = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('admin/images/users');

            $file->move($destinationPath, $user_img);
            $user->user_image = $user_img;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }


    public function editPassword(Request $request) {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password changed successfully!']);
    }


    public function removeProfilePicture() {

        $user = Auth::user();

        if ($user->user_image !== 'default_user.png') {
            $path = public_path('admin/images/users/' . $user->user_image);
            if (file_exists($path)) unlink($path);
        }

        $user->user_image = 'default_user.png';
        $user->save();

        return response()->json(['success' => 'Profile picture removed successfully!']);
    }

}
