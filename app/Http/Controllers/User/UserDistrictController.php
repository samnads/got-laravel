<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use DB;

class UserDistrictController extends Controller
{
    public function add_district(Request $request)
    {
        try {
            DB::beginTransaction();
            $row = new District;
            $row->state_id = $request->state_id;
            $row->name = $request->name;
            $row->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Saved !',
                    'content' => 'District added successfully.'
                ],
                'data' => [
                    'district' => [
                        'id' => $row->district_id,
                        'name' => $row->name
                    ]
                ]
            ];
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollback();
            }
            $response = [
                'status' => false,
                'error' => [
                    'type' => 'error',
                    'title' => 'Exception !',
                    'content' => $e->getMessage()
                ],
            ];
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
        }
    }
}
