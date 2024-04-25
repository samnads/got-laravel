<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        return redirect()->route('vendor.login');
    }
    public function login(Request $request)
    {
        if ($request->ajax()) {
            $remember = $request->remember_me == "1" ? true : false;
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
            if (Auth::guard('vendor')->attempt($credentials, $remember)) {
                $request->session()->regenerate();
                $response = [
                    'status' => 'success',
                    'message' => 'Logged in successfully.',
                    'redirect' => route('vendor.dashboard')
                ];
            } else {
                $response = [
                    'status' => 'failed',
                    'message' => 'Invalid username / password.'
                ];
            }
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }
        else if (Auth::guard('user')->check()) {
            // The user is logged in...
            return redirect()->route('user.dashboard');
        }
        return view('user.login', []);
    }
}
