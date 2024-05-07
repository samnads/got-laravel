<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class VendorProfileController extends Controller
{
    public function view(Request $request)
    {
        $data['vendor'] = Vendor::findOrFail(Auth::guard('vendor')->id());
        return view('vendor.profile.profile', $data);
    }
    public function order_settings(Request $request)
    {
        $data['vendor'] = Vendor::findOrFail(Auth::guard('vendor')->id());
        return view('vendor.profile.order-settings', $data);
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
                        if ($request->action == "profile-update") {
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
                        else if ($request->action == "order-settings-update") {
                            $vendor = Vendor::findOrFail(Auth::guard('vendor')->id());
                            $vendor->min_order_value = $request->min_order_value;
                            $vendor->min_order_weight = $request->min_order_weight;
                            $vendor->max_order_weight = $request->max_order_weight;
                            $vendor->home_delivery_status_id = $request->home_delivery_status_id == 1 ? 1 : 2;
                            $vendor->save();
                            $response = [
                                'status' => true,
                                'message' => [
                                    'type' => 'success',
                                    'title' => 'Updated',
                                    'content' => 'Order settings updated successfully.'
                                ]
                            ];
                        }
                        else if ($request->action == "update-password") {
                            /******************************************************************************* */
                            $validator = Validator::make(
                                (array) $request->all(),
                                [
                                    'current_password' => 'required|string',
                                    'new_password' => 'required|min:8|max:25|required_with:new_password_confirm|same:new_password_confirm',
                                    'new_password_confirm' => 'required|min:8|',
                                ],
                                [],
                                [
                                    'current_password' => 'Current Password',
                                    'new_password' => 'New Password',
                                    'new_password_confirm' => 'Confirm New Password',
                                ]
                            );
                            if ($validator->fails()) {
                                $response = [
                                    'status' => false,
                                    'error' => [
                                            'type' => 'error',
                                            'title' => 'Validation Error !',
                                            'content' => $validator->errors()->first()
                                        ]
                                ];
                                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                            }
                            /******************************************************************************* */
                            $auth = Auth::guard('vendor')->user();
                            if (!Hash::check($request->current_password, $auth->password)) {
                                throw new \ErrorException('Current password is invalid');
                            }
                            $vendor = Vendor::findOrFail(Auth::guard('vendor')->id());
                            $vendor->password = $request->new_password;
                            $vendor->save();
                            $request->session()->invalidate();
                            $response = [
                                'status' => true,
                                'message' => [
                                        'type' => 'success',
                                        'title' => 'Password Updated',
                                        'content' => 'You\'ve been logged out, please log in again.'
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
