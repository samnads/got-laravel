<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendorAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('vendor.dashboard');
        }
        return back()->withErrors([]);
    }
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }
    public function vendor_login(Request $request)
    {
        if ($request->ajax()) {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
            if (Auth::guard('vendor')->attempt($credentials)) {
                $request->session()->regenerate();
                $response = [
                    'status' => 'success',
                    'message' => 'Logged in successfully.',
                    'redirect'=> route('vendor.dashboard')
                ];
                //return redirect()->route('vendor.dashboard');
            }
            else{
                $response = [
                    'status' => 'failed',
                    'message'=> 'Invalid username / password.'
                ];
            }
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            //return back()->withErrors([]);
        }
    }
}
