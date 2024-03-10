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

class ProfileController extends Controller
{
    public function basic_data_entry(Request $request)
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
            $otp = '1234';
            $customer->mobile_number_1_otp = $otp;
            $customer->mobile_number_1_otp_expired_at = Carbon::now()->addSeconds(5);
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
            $otp = '1234';
            $customer = new Customer();
            $customer->mobile_number_1_cc = $input['country_code'];
            $customer->mobile_number_1 = $input['mobile_no'];
            $customer->mobile_number_1_otp = $otp;
            $customer->mobile_number_1_otp_expired_at = Carbon::now()->addSeconds(5);
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
}
