<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;
use App\Models\Location;
use Illuminate\Http\Request;

class AdminLocationController extends Controller
{
    public function locations_list(Request $request)
    {
        $data['locations'] = Location::
            select(
                'locations.*',
                's.state_id',
                's.name as state',
                'd.name as district',
            )
            ->leftJoin('districts as d', function ($join) {
                $join->on('locations.district_id', '=', 'd.district_id');
            })
            ->leftJoin('states as s', function ($join) {
                $join->on('d.state_id', '=', 's.state_id');
            })
            ->get();
        $data['states'] = State::get();
        return view('admin.location.location-list', $data);
    }
}
