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
        $debug = toggleDebug(); // pass boolean to overide default
        /************************************************************* */
        if (!$debug) {
            // live input
            $data = json_decode($request->getContent(), true);
        } else {
            // test input
            $data['params']['id'] = Config::get('values.debug_customer_id');
            $data['params']['token'] = Customer::where(['customer_id' => Config::get('values.debug_customer_id')])->first()->oauth_token;
        }
        $input = @$data['params'];
        /************************************************************* */
        $except_route_names = ['notifications']; // bypass token validation for these route names
        if ($input['id'] == null && in_array($request->route()->getName(), $except_route_names)) {
            return $next($request);
        }
        /************************************************************* */
        // required input check
        $validator = Validator::make(
            (array) $input,
            [
                'token' => 'required|string',
                'id' => 'required|integer',
            ],
            [],
            [
                'token' => 'Token',
                'id' => 'Customer ID',
            ]
        );
        if ($validator->fails()) {
            return Response::json(array('result' => array('status' => 'failed', 'message' => $validator->errors()->first()), 'debug' => $debug), 200, array(), JSON_PRETTY_PRINT);
        }
        /************************************************************* */
        $customer = Customer::where(['oauth_token' => $input['token']])->first();
        if ($customer) {
            // check customer id
            $customer = Customer::where(['oauth_token' => $input['token'], 'customer_id' => $input['id']])->first();
            if ($customer) {
            } else {
                return Response::json(array('result' => array('status' => 'failed', 'message' => 'Customer not found !'), 'debug' => $debug), 200, array(), JSON_PRETTY_PRINT);
            }
        } else {
            return Response::json(array('result' => array('status' => 'failed', 'message' => 'Invalid or Expired Token !', 'status_code' => 401), 'debug' => $debug), 200, array(), JSON_PRETTY_PRINT);
        }
        /************************************************************* */
        return $next($request);
    }
}
