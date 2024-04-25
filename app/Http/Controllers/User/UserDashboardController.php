<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('user.dashboard', []);
    }
}
