<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Session;

class AdminVendorController extends Controller
{
    public function vendors_list(Request $request)
    {
        $data['vendors'] = Vendor::get();
        return view('admin.master.vendor-list', $data);
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
    public function vendors_new(Request $request)
    {
        $data = [];
        return view('admin.vendor.new-vendor-form', $data);
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
                break;
            case 'DELETE':
                break;
            default:
                break;
        }
        return response()->json($response);
    }
}
