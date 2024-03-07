<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        dd('login');
        //return view('admin.login', []);
    }
}
