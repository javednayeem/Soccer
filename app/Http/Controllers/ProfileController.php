<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\User;


class ProfileController extends Controller {

    public function __construct() {
        #$this->middleware('auth');
    }


    public function index() {

        $user_id = Auth::user()->id;

        $user = User::find($user_id);

        return view('admin.profile.index', [
            'user' => $user,
        ]);

    }


    public function editProfile(Request $request) {

        $user_id = Auth::user()->id;

        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $user = User::find($user_id);

        if ($request->hasFile('user_image')) {

            $this->validate($request, [
                'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $file = $request->file('user_image');
            $user_img = 'user_' . $user_id . '.' .$file->getClientOriginalExtension();
            $destinationPath = 'admin/images/users';

            $file->move($destinationPath, $user_img);
            $user->user_image = $user_img;

        }

        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if ($key != 'user_image') {
                $user->$key = $value;
            }
        }

        $user->save();

        return back()->with('status', 'success');
    }


    public function editPassword(Request $request) {

        $data = $request->input('params');
        $user_id = Auth::user()->id;
        $method = 'userPasswordChange';

        $old_password = $data['old_password'];
        $password = $data['new_password'];

        $user = User::find($user_id);
        $hashedPassword = $user->password;

        if (Hash::check($old_password, $hashedPassword)) {

            $user->password = Hash::make($password);
            $user->save();

            return json_encode('success');
        }

        else return json_encode('failure');
    }


    public function removeProfilePicture() {

        $user_id = Auth::user()->id;
        $destinationPath = '/admin/images/users/';

        $user = User::find($user_id);

        if ($user->user_image != 'default_user.png') {
            $path = public_path($destinationPath . $user->user_image);
            unlink($path);
        }

        $user->user_image = 'default_user.png';
        $user->save();

        return json_encode('success');
    }

}
