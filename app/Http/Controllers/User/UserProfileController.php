<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function update_password(Request $request)
    {
        $data['user'] = User::findOrFail(Auth::guard('user')->id());
        return view('user.profile.update-password', $data);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->method()) {
                    case 'PUT':
                        if ($request->action == "update-password") {
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
                            $auth = Auth::guard('user')->user();
                            if (!Hash::check($request->current_password, $auth->password)) {
                                throw new \ErrorException('Current password is invalid');
                            }
                            $user = User::findOrFail(Auth::guard('user')->id());
                            $user->password = $request->new_password;
                            $user->save();
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
