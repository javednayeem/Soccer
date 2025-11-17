<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Mail;
use Hash;

use App\User;

class UserController extends Controller {

    public function index() {

        $users = DB::table('users')
            ->where('role', '<>', 'player')
            ->get();

        return view('admin.user.index', [
            'users' => $users
        ]);
    }


    public function addUser(Request $request) {

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->designation = $request->input('designation');
        $user->responsibility = $request->input('responsibility');

        $user->save();
        $id = $user->id;

        if ($request->hasFile('user_image')) {

            $destinationPath = 'images/users';
            $user_image = $request->file('user_image');
            $imageName = 'user_' . $id . '.' . $user_image->getClientOriginalExtension();
            $user_image->move($destinationPath, $imageName);

            $user->user_image = $imageName;
            $user->save();

        }


        return json_encode($id);
    }


    public function editUser(Request $request) {

        $id = $request->input('id');

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->designation = $request->input('designation');
        $user->responsibility = $request->input('responsibility');

        if ($request->hasFile('user_image')) {

            $destinationPath = 'images/users';
            $user_image = $request->file('user_image');
            $imageName = 'user_' . $id . '.' . $user_image->getClientOriginalExtension();
            $user_image->move($destinationPath, $imageName);

            $user->user_image = $imageName;
            $user->save();

        }

        $user->save();

        return json_encode('success');
    }


    public function deleteUser(Request $request) {

        $data = $request->input('params');

        $user = User::find($data['id']);
        $user->delete();

        return json_encode('success');
    }

}
