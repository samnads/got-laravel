<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function vendor_login(Request $request)
    {
        if (Auth::guard('vendor')->check()) {
            // The user is logged in...
            return redirect()->route('vendor.dashboard');
        }
        return view('shop.login', []);
    }
    public function vendor_profile(Request $request)
    {
        return view('shop.profile', []);
    }
}
