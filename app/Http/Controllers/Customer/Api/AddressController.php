<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Str;
use Response;

class AddressController extends Controller
{
    public function create_address(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'latitude' => 'required',
                'longitude' => 'required',
                'name' => 'required|string',
                'apartment_no' => 'required|string',
                'apartment_name' => 'required|string',
                'landmark' => 'required|string',
                'mobile_no' => 'required|integer',
                'address_type' => 'integer',
                'default_address' => 'integer|nullable',
                'address' => 'required|string',
            ],
            [],
            [
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'name' => 'Name',
                'apartment_no' => 'Apartment No',
                'apartment_name' => 'Aprtment Name',
                'landmark' => 'Landmark',
                'mobile_no' => 'Mobile No',
                'address_type' => 'Address Type',
                'default_address' => 'Default Address',
                'address' => 'Address',
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
        $customer = Customer::find($input['id']);
        $customer_address = new CustomerAddress();
        DB::beginTransaction();
        $customer_address->customer_id = $input['id'];
        $customer_address->latitude = $input['latitude'];
        $customer_address->longitude = $input['longitude'];
        $customer_address->name = $input['name'];
        $customer_address->apartment_no = $input['apartment_no'];
        $customer_address->apartment_name = $input['apartment_name'];
        $customer_address->landmark = $input['landmark'];
        $customer_address->mobile_no = $input['mobile_no'];
        $customer_address->address_type = $input['address_type'];
        $customer_address->address = $input['address'];
        $customer_address->save();
        if (@$input['default_address'] == 1 || $customer->default_address_id == null) {
            $customer->default_address_id = $customer_address->id;
            $customer->save();
        }
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Address added successfully !',
            ],
            'data' => [
                'default_address_id' => $customer->default_address_id,
            ]
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function update_address(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'address_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'name' => 'required|string',
                'apartment_no' => 'required|string',
                'apartment_name' => 'required|string',
                'landmark' => 'required|string',
                'mobile_no' => 'required|integer',
                'address_type' => 'integer',
                'default_address' => 'integer|nullable',
                'address' => 'required|string',
            ],
            [],
            [
                'address_id' => 'Address ID',
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'name' => 'Name',
                'apartment_no' => 'Apartment No',
                'aprtment_name' => 'Aprtment Name',
                'landmark' => 'Landmark',
                'mobile_no' => 'Mobile No',
                'address_type' => 'Address Type',
                'default_address' => 'Default Address',
                'address' => 'Address',
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
        $customer_address = CustomerAddress::where([
            ['id', '=', $input['address_id']],
            ['customer_id', '=', $input['id']],
        ])->first();
        if (!$customer_address) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Invalid address !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $customer = Customer::find($input['id']);
        DB::beginTransaction();
        $customer_address->latitude = $input['latitude'];
        $customer_address->longitude = $input['longitude'];
        $customer_address->name = $input['name'];
        $customer_address->apartment_no = $input['apartment_no'];
        $customer_address->apartment_name = $input['apartment_name'];
        $customer_address->landmark = $input['landmark'];
        $customer_address->mobile_no = $input['mobile_no'];
        $customer_address->address_type = $input['address_type'];
        $customer_address->address = $input['address'];
        $customer_address->save();
        if (@$input['default_address'] == 1 || $customer->default_address_id == null) {
            $customer->default_address_id = $customer_address->id;
            $customer->save();
        }
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Address updated successfully !',
            ],
            'data' => [
                'default_address_id' => $customer->default_address_id,
            ]
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
