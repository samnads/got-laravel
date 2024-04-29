<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Str;
use Response;

class LoginController extends Controller
{
    public function login_otp_send(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'country_code' => 'required|string',
                'mobile_no' => 'required|integer',
            ],
            [],
            [
                'country_code' => 'Country Code',
                'mobile_no' => 'Mobile Number',
            ]
        );
        if ($validator->fails()) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => $validator->errors()->first()
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $customer = Customer::where('mobile_number_1_cc', '=', $input['country_code'])->where('mobile_number_1', '=', $input['mobile_no'])->first();
        DB::beginTransaction();
        if ($customer) {
            // EXISTING CUSTOMER FOUND
            $otp = generateOTP(4);
            sendSmsOTP($input['mobile_no'], $otp);
            $customer->mobile_number_1_otp = $otp;
            $customer->mobile_number_1_otp_expired_at = Carbon::now()->addSeconds(60);
            $customer->save();
            $response = [
                'status' => [
                    'success' => 'true',
                    'hasdata' => 'false',
                    'message' => 'OTP Send Successfully !'
                ]
            ];
            DB::commit();
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        } else {
            // NEW CUSTOMER FOUND
            $otp = generateOTP(4);
            sendSmsOTP($input['mobile_no'], $otp);
            $customer = new Customer();
            $customer->mobile_number_1_cc = $input['country_code'];
            $customer->mobile_number_1 = $input['mobile_no'];
            $customer->mobile_number_1_otp = $otp;
            $customer->mobile_number_1_otp_expired_at = Carbon::now()->addSeconds(60);
            $customer->save();
            $response = [
                'status' => [
                    'success' => 'true',
                    'hasdata' => 'false',
                    'message' => 'OTP Send Successfully !'
                ]
            ];
            DB::commit();
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
    }
    public function login_otp_resend(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'country_code' => 'required|string',
                'mobile_no' => 'required|integer',
            ],
            [],
            [
                'country_code' => 'Country Code',
                'mobile_no' => 'Mobile Number',
            ]
        );
        if ($validator->fails()) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => $validator->errors()->first()
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $customer = Customer::where('mobile_number_1_cc', '=', $input['country_code'])->where('mobile_number_1', '=', $input['mobile_no'])->first();
        if (!$customer) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Unknown customer !'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        $startTime = Carbon::now();
        $finishTime = Carbon::parse($customer->mobile_number_1_otp_expired_at);
        $seconds = $finishTime->diffInSeconds($startTime);
        if ($customer->mobile_number_1_otp_expired_at > Carbon::now() && $seconds >= 1) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Please wait ' . $seconds . ' second' . ($seconds > 0 ? 's' : '') . ' before resend OTP.'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        DB::beginTransaction();
        $otp = generateOTP(4);
        sendSmsOTP($input['mobile_no'], $otp);
        $customer->mobile_number_1_otp = $otp;
        $customer->mobile_number_1_otp_expired_at = Carbon::now()->addSeconds(60);
        $customer->save();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'false',
                'message' => 'OTP Resend Successfully !'
            ]
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function login_otp_verify(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'country_code' => 'required|string',
                'mobile_no' => 'required|integer',
                'otp' => 'required|string',
            ],
            [],
            [
                'country_code' => 'Country Code',
                'mobile_no' => 'Mobile Number',
                'otp' => 'OTP',
            ]
        );
        if ($validator->fails()) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => $validator->errors()->first()
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $customer = Customer::where('mobile_number_1_cc', '=', $input['country_code'])->where('mobile_number_1', '=', $input['mobile_no'])->first();
        if ($input['otp'] == $customer->mobile_number_1_otp && $customer->mobile_number_1_otp_expired_at >= date('Y-m-d H:i:s')) {
            // otp verified
            DB::beginTransaction();
            $customer->mobile_number_1_otp = null;
            $customer->token = bcrypt($input['otp'] . date('Y-m-d H:i:s'));
            $customer->save();
            $response = [
                'status' => [
                    'success' => 'true',
                    'hasdata' => 'true',
                    'message' => 'OTP verified successfully !'
                ],
                'data' => [
                    'id' => $customer->id,
                    'token' => $customer->token,
                    'profile' => [
                        'name' => $customer->name,
                        'email' => $customer->email,
                    ]
                ]
            ];
            DB::commit();
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        } else {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Invalid or Expired OTP'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
    }
    public function logout(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [],
            [],
            []
        );
        if ($validator->fails()) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => $validator->errors()->first()
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $customer = Customer::find($input['id']);
        DB::beginTransaction();
        $customer->token = null;
        $customer->save();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'false',
                'message' => 'Logged out successfully!'
            ],
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
