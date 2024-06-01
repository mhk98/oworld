<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Login Form
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:dn_users',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = ($request->filled('remember')) ? true : false;

        if (auth()->attempt($credentials, $remember)) {
            $user = auth()->user();
        
            // Check if the user is an admin
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login successful');
            } else {
                auth()->logout();
                return redirect()->route('adminAuth.loginForm')
                    ->with('error', 'You do not have permission to access the admin dashboard');
            }
        }

        return redirect()->route('adminAuth.loginForm')
            ->with('error', 'Incorrect email or password.');
    }
}
