<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        return view('admin.login', []);
    }
    public function index(Request $request)
    {
        return view('admin.dashboard', []);
    }
    public function dashboard(Request $request)
    {
        return view('admin.dashboard', []);
    }
}
