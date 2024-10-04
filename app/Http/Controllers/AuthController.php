<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
}
