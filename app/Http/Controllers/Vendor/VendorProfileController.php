<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Auth;
use DB;

class VendorProfileController extends Controller
{
    public function view(Request $request)
    {
        $data['vendor'] = Vendor::findOrFail(Auth::guard('vendor')->id());
        return view('vendor.profile.profile', $data);
    }
    public function update_password(Request $request)
    {
        $data['vendor'] = Vendor::findOrFail(Auth::guard('vendor')->id());
        return view('vendor.profile.update-password', $data);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->method()) {
                    case 'PUT':
                        if($request->action == "profile-update"){
                            $vendor = Vendor::findOrFail(Auth::guard('vendor')->id());
                            $vendor->vendor_name = $request->vendor_name;
                            $vendor->owner_name = $request->owner_name;
                            $vendor->gst_number = $request->gst_number;
                            $vendor->email = $request->email;
                            $vendor->mobile_number_cc = $request->mobile_number_cc;
                            $vendor->mobile_number = $request->mobile_number;
                            $vendor->address = $request->address;
                            $vendor->save();
                            $response = [
                                'status' => true,
                                'message' => [
                                    'type' => 'success',
                                    'title' => 'Profile Updated',
                                    'content' => 'Profile updated successfully.'
                                ]
                            ];
                        }
                        else if ($request->action == "update-password") {
                            $vendor = Vendor::findOrFail(Auth::guard('vendor')->id());
                            $vendor->vendor_name = $request->vendor_name;
                            $vendor->owner_name = $request->owner_name;
                            $vendor->gst_number = $request->gst_number;
                            $vendor->email = $request->email;
                            $vendor->mobile_number_cc = $request->mobile_number_cc;
                            $vendor->mobile_number = $request->mobile_number;
                            $vendor->address = $request->address;
                            $vendor->save();
                            $response = [
                                'status' => true,
                                'message' => [
                                    'type' => 'success',
                                    'title' => 'Password Updated',
                                    'content' => 'Password changed successfully.'
                                ]
                            ];
                        }
                        break;
                    default:
                }
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                if (DB::transactionLevel() > 0) {
                    DB::rollback();
                }
                $response = [
                    'status' => false,
                    'error' => [
                        'type' => 'error',
                        'title' => 'Error !',
                        'content' => $e->getMessage()
                    ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }
        }
    }
}
