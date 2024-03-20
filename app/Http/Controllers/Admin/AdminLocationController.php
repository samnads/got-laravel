<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class AdminLocationController extends Controller
{
    public function locations_list(Request $request)
    {
        $data['states'] = State::get();
        return view('admin.location.location-list', $data);
    }
}
