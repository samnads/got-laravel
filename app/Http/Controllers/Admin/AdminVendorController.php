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
    public function block_vendor(Request $request,$vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
        $vendor->blocked_at = now();
        $vendor->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Blocked !', 'message' => 'Vendor <b>' . $vendor->vendor_name . '</b> blocked successfully.']);
        return redirect()->route('admin.vendors');
    }
    public function unblock_vendor(Request $request, $vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
        $vendor->blocked_at = null;
        $vendor->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Blocked !', 'message' => 'Vendor <b>' . $vendor->vendor_name . '</b> unblocked successfully.']);
        return redirect()->route('admin.vendors');
    }
}
