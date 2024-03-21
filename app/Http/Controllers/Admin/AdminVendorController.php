<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\State;
use Session;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;
use stdClass;


class AdminVendorController extends Controller
{
    public function vendors_list(Request $request)
    {
        $data['vendors'] = Vendor::
            select(
                'vendors.*',
                's.name as state',
                'd.name as district',
                'l.name as location',
            )
            ->leftJoin('locations as l', function ($join) {
                $join->on('vendors.location_id', '=', 'l.id');
            })
            ->leftJoin('districts as d', function ($join) {
                $join->on('l.district_id', '=', 'd.district_id');
            })
            ->leftJoin('states as s', function ($join) {
                $join->on('d.state_id', '=', 's.state_id');
            })
            ->get();
        return view('admin.vendor.list-vendors', $data);
    }
    public function block_vendor(Request $request, $vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
        $vendor->blocked_at = now();
        $vendor->save();
        Session::flash('toast', ['type' => 'info', 'title' => 'Blocked !', 'message' => 'Vendor <b>' . $vendor->vendor_name . '</b> blocked successfully.']);
        return redirect()->route('admin.vendors');
    }
    public function unblock_vendor(Request $request, $vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
        $vendor->blocked_at = null;
        $vendor->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Unblocked !', 'message' => 'Vendor <b>' . $vendor->vendor_name . '</b> unblocked successfully.']);
        return redirect()->route('admin.vendors');
    }
    public function vendor_new(Request $request)
    {
        $data['states'] = State::get();
        return view('admin.vendor.new-vendor', $data);
    }
    public function vendor_edit(Request $request,$vendor_id)
    {
        $data['vendor'] = Vendor::findOrFail($vendor_id);
        return view('admin.vendor.edit-vendor', $data);
    }
    public function index(Request $request)
    {
        switch ($request->method()) {
            case 'POST':
                $row = new Vendor();
                $row->latitude = $request->latitude;
                $row->longitude = $request->longitude;
                $row->gst_number = $request->gst_number;
                $row->email = $request->email;
                $row->vendor_name = $request->vendor_name;
                $row->username = $request->username;
                $row->password = $request->password;
                $row->owner_name = $request->owner_name;
                $row->mobile_number = $request->mobile_number;
                $row->address = $request->address;
                $row->save();
                $response = ['status' => 'success', 'type' => 'success', 'title' => 'Saved !', 'message' => 'Vendor added successfully.'];
                Session::flash('toast', $response);
                break;
            case 'PUT':
                $input = $request->all();
                $validator = Validator::make(
                    (array) $input,
                    [
                        'id' => 'required|exists:vendors,id',
                        'email' => 'unique:vendors,email,'. $input['id'],
                    ],
                    [],
                    [
                        'id' => 'Vendor',
                        'email' => 'Email',
                    ]
                );
                if ($validator->fails()) {
                    $response = ['status' => 'failed', 'type' => 'error', 'title' => 'Error !', 'message' => $validator->errors()->first()];
                    return response()->json($response);
                }
                $row = Vendor::find($input['id']);
                $row->latitude = $request->latitude;
                $row->longitude = $request->longitude;
                $row->gst_number = $request->gst_number;
                $row->email = $request->email;
                $row->vendor_name = $request->vendor_name;
                if($request->username){
                    $row->username = $request->username;
                }
                if ($request->password) {
                    $row->password = $request->password;
                }
                $row->owner_name = $request->owner_name;
                $row->mobile_number = $request->mobile_number;
                $row->address = $request->address;
                $row->save();
                $response = ['status' => 'success', 'type' => 'success', 'title' => 'Updated !', 'message' => 'Vendor updated successfully.'];
                Session::flash('toast', $response);
                break;
            case 'DELETE':
                break;
            default:
                break;
        }
        return response()->json($response);
    }
}
