<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('toast', ['type' => 'info', 'title' => 'Hi, '. Auth::user()->name, 'message' => 'Welcome back...']);
            return redirect()->route('admin.dashboard');
        }
        Session::flash('toast', ['type' => 'warning', 'title' => 'Authentication Error !', 'message' => 'Invalid login credentials']);
        return back()->withErrors([]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Logged out successfully.']);
        return redirect()->route('admin.login');
    }
}
