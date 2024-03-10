<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Response;

class VendorController extends Controller
{
    public function nearby_vendors(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'latitude' => 'required',
                'longitude' => 'required',
                'distance' => 'required|numeric|min:2|max:5'
            ],
            [],
            [
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'distance' => 'Distance',
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
        $shops = Vendor::select(
            'vendor_name as shop_name',
            'latitude',
            'longitude',
            'address',
            'mobile_number as shop_contact_number',
            'mobile_number as contact_number',
            DB::raw('ROUND((6371 * acos( cos( radians(' . $input['latitude'] . ') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(' . $input['longitude'] . ')) + sin(radians(' . $input['latitude'] . ')) * sin(radians(latitude)) )),2) as distance')
        )
            ->having('distance', '<=', $input['distance'])
            ->get();
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Nearby shops fetched successfully !',
            ],
            'data' => [
                'shops'=> $shops
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function vendors_locations(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
            ],
            [],
            [
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
        $shops = Vendor::select(
            'id as shop_id',
            'vendor_name as shop_name',
            'latitude',
            'longitude',
            'mobile_number as shop_contact_number',
        )
            ->get();
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Shop locations fetched successfully !',
            ],
            'data' => [
                'shops' => $shops
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
