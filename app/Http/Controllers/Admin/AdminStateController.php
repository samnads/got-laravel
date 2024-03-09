<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class AdminStateController extends Controller
{
    public function states_list(Request $request)
    {
        $data['states'] = State::get();
        return view('admin.master.state-list', $data);
    }
}
