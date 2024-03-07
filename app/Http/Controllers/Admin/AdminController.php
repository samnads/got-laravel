<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // The user is logged in...
            return redirect()->route('admin-dashboard');
        }
        return view('admin.login', []);
    }
    public function dashboard(Request $request)
    {
        return view('admin.dashboard', []);
    }
}
