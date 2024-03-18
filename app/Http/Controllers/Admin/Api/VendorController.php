<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use Response;

class VendorController extends Controller
{
    public function save_vendor(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'shop_name' => 'required|string',
                'shop_contact_number' => 'required|string',
                'address' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ],
            [],
            [
                'shop_name' => 'Shop Name',
                'shop_contact_number' => 'Contact Number',
                'address' => 'Address',
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
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
        $vendor = new Vendor();
        $vendor->vendor_name = $input['shop_name'];
        $vendor->mobile_number = $input['shop_contact_number'];
        $vendor->address = $input['address'];
        $vendor->latitude = $input['latitude'];
        $vendor->longitude = $input['longitude'];
        $vendor->save();
        $response = [
            'status' => [
                'code' => 200,
                'success' => true,
                'hasdata' => false,
                'message' => 'Vendor saved successfully',
            ],
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
