<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Config;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Response;

class ValidateCustomerApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        /************************************************************* */
        $validator = Validator::make(
            (array) $input,
            [
                'id' => 'required|integer',
                'token' => 'required|string',
            ],
            [],
            [
                'id' => 'Customer ID',
                'token' => 'Token',
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
        /************************************************************* */
        $customer = Customer::find($input['id']);
        if ($customer) {
            // check customer id
            if ($customer->token == $input['token']) {
                return $next($request);
            } else {
                $response = [
                    'status' => [
                        'success' => 'false',
                        'hasdata' => 'false',
                        'message' => 'Invalid or expired token !'
                    ]
                ];
                return Response::json($response, 200, [], JSON_PRETTY_PRINT);
            }
        } else {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Unknown customer !'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /************************************************************* */
    }
}
