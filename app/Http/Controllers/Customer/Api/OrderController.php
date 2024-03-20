<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\Cart;
use App\Models\ProductCategories;
use Illuminate\Support\Str;
use Response;

class OrderController extends Controller
{
    public function create_order(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'vendor_id' => 'required|exists:vendors,id',
                'address_id' => 'required|exists:customer_addresses,id',
            ],
            [],
            [
                'vendor_id' => 'Vendor',
                'address_id' => 'Delivery Address',
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
        $products = Cart::select(
            'cart.vendor_product_id as product_id',
            'cart.id as cart_id',
            'p.name as name',
            'p.code as code',
            'p.item_size',
            'u.name as unit',
            'u.code as unit_code',
            'p.description as description',
            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(p.thumbnail_image,"default.jpg")) as thumbnail_url'),
            'cart.quantity',
            'vp.maximum_retail_price',
            'vp.retail_price',
            'vp.min_cart_quantity',
            'vp.max_cart_quantity',
            DB::raw('ROUND((vp.maximum_retail_price - vp.retail_price),2) as offer'),
            DB::raw('ROUND((((vp.maximum_retail_price - vp.retail_price) / vp.maximum_retail_price)*100),2) as offer_percentage'),
        )
            ->leftJoin('vendor_products as vp', function ($join) {
                $join->on('cart.vendor_product_id', '=', 'vp.id');
            })
            ->leftJoin('products as p', function ($join) {
                $join->on('vp.product_id', '=', 'p.id');
            })
            ->leftJoin('units as u', function ($join) {
                $join->on('p.unit_id', '=', 'u.id');
            })
            ->where([['vp.vendor_id', '=', $request->vendor_id], ['vp.deleted_at', '=', null], ['p.deleted_at', '=', null]])
            ->get()
            ->toArray();
        if (!$products) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'No product in cart.'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        DB::beginTransaction();
        $order = new Order();
        $order->customer_id = $input['id'];
        $order->vendor_id = $input['vendor_id'];
        $order->address_id = $input['address_id'];
        $order->total_payable = 0;
        $order->save();
        $order->order_reference = config('prefix.ORDER_REF') . sprintf('%06d', $order->id);
        $order->save();
        foreach ($products as $key => $product) {
            $order_product = new OrderProduct();
            $order_product->order_id = $order->id;
            $order_product->vendor_product_id = $product['product_id'];
            $order_product->unit_price = $product['retail_price'];
            $order_product->quantity = $product['quantity'];
            $order_product->total_price = $product['retail_price'] * $product['quantity'];
            $order->total_payable += $order_product->total_price;
            $order_product->save();
        }
        $order->save();
        // reset ordered cart data
        $vendor_product_cart_ids = array_column($products, 'cart_id');
        Cart::destroy($vendor_product_cart_ids);
        DB::commit();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Order created successfully !',
            ],
            'data' => [
                'order' => [
                    "order_id" => $order->id,
                    "order_reference" => $order->order_reference,
                ],
                'amount' => [
                    "total_payable" => $order->total_payable,
                ],
                'products' => $products,
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        /***************************************************************************************************** */
    }
}
