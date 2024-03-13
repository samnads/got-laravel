<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\Cart;
use App\Models\ProductCategories;
use Illuminate\Support\Str;
use Response;

class CartController extends Controller
{
    public function get_cart(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'vendor_id' => 'required',
            ],
            [],
            [
                'vendor_id' => 'Vendor ID',
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
        $vendor = Vendor::find($input['vendor_id']);
        if (!$vendor) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Vendor not found !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        $vendor = Vendor::select(
            'id',
            'vendor_name as name',
        )
            ->where([['id', '=', $request->vendor_id]])
            ->first();
        $cart_products = Cart::select(
            'cart.vendor_product_id as id',
            'p.name as name',
            'p.code as code',
            'p.description as description',
            DB::raw('null as thumbnail_url'),
            'cart.quantity',
            'vp.maximum_retail_price',
            'vp.retail_price'
        )
            ->leftJoin('vendor_products as vp', function ($join) {
                $join->on('cart.vendor_product_id', '=', 'vp.id');
            })
            ->leftJoin('products as p', function ($join) {
                $join->on('vp.product_id', '=', 'p.id');
            })
            ->where([['vp.vendor_id', '=', $request->vendor_id], ['vp.deleted_at', '=', null], ['p.deleted_at', '=', null]])
            ->get();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Cart fetched successfully !',
            ],
            'data' => [
                'vendor' => $vendor,
                'cart_products' => $cart_products

            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function update_cart(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'vendor_id' => 'required|integer',
                'product_id' => 'required|integer',
                'quantity' => 'required|integer',
            ],
            [],
            [
                'vendor_id' => 'Vendor ID',
                'product_id' => 'Product ID',
                'quantity' => 'Quantity',
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
        $vendor = Vendor::select(
            'id',
            'vendor_name as name',
        )
            ->where([['id', '=', $request->vendor_id]])
            ->first();
        if (!$vendor) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Vendor not found !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        switch ($request->quantity) {
            case '0':
            case null:
                $item = Cart::where([['customer_id', '=', $request->id], ['vendor_product_id', '=', $request->product_id]])->withTrashed()->first();
                if ($item) {
                    // update
                    $item->delete();
                }
                break;
            default:
                $item = Cart::where([['customer_id', '=', $request->id], ['vendor_product_id', '=', $request->product_id]])->withTrashed()->first();
                if ($item) {
                    // update
                    $item->quantity = $request->quantity;
                    $item->updated_at = now();
                    $item->deleted_at = now();
                } else {
                    // create
                    $item = new Cart();
                    $item->customer_id = $request->id;
                    $item->vendor_product_id = $request->product_id;
                    $item->quantity = $request->quantity;
                }
                $item->save();
                break;
        }
        /***************************************************************************************************** */
        $cart_products = Cart::select(
            'cart.vendor_product_id as id',
            'p.name as name',
            'p.code as code',
            'p.description as description',
            DB::raw('null as thumbnail_url'),
            'cart.quantity',
            'vp.maximum_retail_price',
            'vp.retail_price'
        )
            ->leftJoin('vendor_products as vp', function ($join) {
                $join->on('cart.vendor_product_id', '=', 'vp.id');
            })
            ->leftJoin('products as p', function ($join) {
                $join->on('vp.product_id', '=', 'p.id');
            })
            ->where([['vp.vendor_id', '=', $request->vendor_id], ['vp.deleted_at', '=', null], ['p.deleted_at', '=', null]])
            ->get();
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Cart updated successfully !',
            ],
            'data' => [
                'vendor' => $vendor,
                'cart_products' => $cart_products

            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
