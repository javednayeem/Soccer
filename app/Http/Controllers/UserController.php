<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Mail;
use Hash;

use App\User;
use App\Models\Team;

class UserController extends Controller {

    public function index(Request $request) {

        $query = User::where('role', '<>', 'player');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->get();
        $roles = ['admin', 'manager', 'staff'];
        $teams = Team::all();

        return view('admin.user.index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => $request->only(['search', 'role']),
            'teams' => $teams
        ]);
    }


    public function addUser(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('user_image')) {
            $destinationPath = 'images/users';
            $user_image = $request->file('user_image');
            $imageName = 'user_' . time() . '.' . $user_image->getClientOriginalExtension();
            $user_image->move($destinationPath, $imageName);
            $user->user_image = $imageName;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'User added successfully']);
    }


    public function editUser(Request $request) {

        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = User::find($request->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->team_id = $request->team_id;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('user_image')) {
            $destinationPath = 'images/users';
            $user_image = $request->file('user_image');
            $imageName = 'user_' . $user->id . '_' . time() . '.' . $user_image->getClientOriginalExtension();
            $user_image->move($destinationPath, $imageName);
            $user->user_image = $imageName;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }


    public function changePassword(Request $request) {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
    }


    public function deleteUser(Request $request) {
        $user = User::find($request->params['id']);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

}
