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
                'address_type' => 'required|integer',
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
                'address_type' => 'required|integer',
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
                'apartment_name' => 'Apartment Name',
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
    public function update_default_address(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'address_id' => 'required',
            ],
            [],
            [
                'address_id' => 'Address ID',
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
        $customer->selected_address_id = $input['address_id'];
        $customer->save();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'false',
                'message' => 'Default address changed successfully !',
            ],
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function delete_address(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'address_id' => 'required',
            ],
            [],
            [
                'address_id' => 'Address ID',
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
        if ($customer_address->id == $customer->default_address_id) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Default address can\'t be deleted !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        DB::beginTransaction();
        CustomerAddress::find($input['address_id'])->delete();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'false',
                'message' => 'Address deleted successfully !',
            ],
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function get_default_address(Request $request)
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
        $default_address = CustomerAddress::find($customer->default_address_id);
        if (!$default_address) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'No default address found !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Default address fetched successfully !',
            ],
            'data' => [
                'default_address' => [
                    'customer_address_id' => $default_address->id,
                    'customer_id' => $default_address->customer_id,
                    'name' => $default_address->name,
                    'address' => $default_address->address,
                    'latitude' => $default_address->latitude,
                    'longitude' => $default_address->longitude,
                    'apartment_no' => $default_address->apartment_no,
                    'apartment_name' => $default_address->apartment_name,
                    'landmark' => $default_address->landmark,
                    'mobile_no' => $default_address->mobile_no,
                    'address_type' => $default_address->address_type,
                    'default_address' => 1,

                ]
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function list_all_address(Request $request)
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
        $addresses = CustomerAddress::where('customer_id', $input['id'])->get();
        /***************************************************************************************************** */
        foreach ($addresses as $key => $address) {
            $address_list[] = [
                'customer_address_id' => $address->id,
                'name' => $address->name,
                'address' => $address->address,
                'latitude' => $address->latitude,
                'longitude' => $address->longitude,
                'apartment_no' => $address->apartment_no,
                'apartment_name' => $address->apartment_name,
                'landmark' => $address->landmark,
                'mobile_no' => $address->mobile_no,
                'address_type' => $address->address_type,
                'default_address' => $customer->default_address_id == $address->id ? 1 : null,
                'selected_address' => $customer->selected_address_id == $address->id ? 1 : null,

            ];
        }
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => sizeof($address_list) > 0 ? 'true' : 'false',
                'message' => 'Address list fetched successfully !',
            ],
            'data' => [
                'address_list' => $address_list
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
