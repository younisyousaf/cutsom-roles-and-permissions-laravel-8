<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    //
    public function loadLogin()
    {
        return view('login');
    }
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $userCredentials = $request->only('email', 'password');
        if (Auth::attempt($userCredentials)) {
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Invalid email or password');
        }
    }
    public function loadDashboard()
    {
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        try {
            $request->session()->flush();
            Auth::logout();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // User Registration
    public function loadRegister()
    {
        return view('register');
    }
    public function userRegister(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|min:6',
            ]);
            $role = Role::where('name', 'User')->first();
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $role ? $role->id : 0,

            ]);

            return back()->with('success', 'User Registered successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
