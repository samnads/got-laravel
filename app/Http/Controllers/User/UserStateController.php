<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use DB;

class UserStateController extends Controller
{
    public function add_state(Request $request)
    {
        try {
            DB::beginTransaction();
            $row = new State;
            $row->name = $request->name;
            $row->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Saved !',
                    'content' => 'State added successfully.'
                ],
                'data' => [
                    'state' => [
                        'id' => $row->state_id,
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
