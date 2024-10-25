<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function users()
    {
        $users = User::with('role')->where('role_id', '!=', 1)->where('id', '!=', auth()->user()->id)->get();
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        // dd($users);
        return view('users', compact(['roles', 'users']));
    }
    public function createUser(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,

            ]);

            return response()->json([
                'success' => true,
                'message' => 'User Registered successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    // Update User
    public function updateUser(Request $request)
    {
        try {
            $validateData = $request->validate([
                'id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($request->id),
                ],
                'password' => 'nullable|min:6',
                'role' => 'required'
            ]);

            $user = User::find($validateData['id']);
            $oldEmail = $user->email;
            $user->name = $validateData['name'];
            $user->email = $validateData['email'];
            $user->role_id = $validateData['role'];
            if (isset($validateData['password'])) {
                $user->password = Hash::make($validateData['password']);
            }
            $user->save();
            if ($oldEmail != $validateData['email'] || isset($validateData['password'])) {
            }
            return response()->json([
                'success' => true,
                'message' => 'User Updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function deleteUser(Request $request)
    {
        try {
            $validateData = $request->validate([
                'id' => 'required',
            ]);
            User::where('id', $validateData['id'])->delete();
            return response()->json([
                'success' => true,
                'message' => 'User Deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
