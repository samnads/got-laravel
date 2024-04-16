<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('vendor')->check()) {
            // The user is logged in...
            return redirect()->route('vendor.dashboard');
            //return view('admin.dashboard', []);
        }
        return view('vendor.login', []);
    }
    public function dashboard(Request $request)
    {
        return view('vendor.dashboard', []);
    }
    public function vendor_login(Request $request)
    {
        if ($request->ajax()) {
            die('ajax');
        }
        if (Auth::guard('vendor')->check()) {
            // The user is logged in...
            return redirect()->route('vendor.dashboard');
            //return view('admin.dashboard', []);
        }
        return view('shop.login', []);
    }
}
