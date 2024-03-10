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
                'name' => 'required|string',
                'email' => 'email',
            ],
            [],
            [
                'name' => 'Name',
                'email' => 'Email',
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
        DB::beginTransaction();
        $customer->name = $input['name'];
        $customer->email = $input['email'];
        $customer->save();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Profile updated successfully !',
                'data' => [
                    'name' => $customer->name,
                    'email' => $customer->email,
                ]
            ]
        ];
        DB::commit();
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
