<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderCustomerAddress;
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
        // validate address id
        $address = CustomerAddress::find($input['address_id']);
        if (@$address->customer_id != $input['id']) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Invalid address.'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        $products = Cart::select(
            'cart.vendor_product_id as product_id',
            'vp.product_id as master_product_id',
            'p.parent_product_id',
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
            'vo.variant_option_name',
            'vrt.variant_name',
            DB::raw('ROUND((vp.maximum_retail_price - vp.retail_price),2) as offer'),
            DB::raw('ROUND((((vp.maximum_retail_price - vp.retail_price) / vp.maximum_retail_price)*100),2) as offer_percentage'),
        )
            ->leftJoin('vendor_products as vp', function ($join) {
                $join->on('cart.vendor_product_id', '=', 'vp.id');
            })
            ->leftJoin('products as p', function ($join) {
                $join->on('vp.product_id', '=', 'p.id');
            })
            ->leftJoin('product_variants as pv', function ($join) {
                $join->on('p.id', '=', 'pv.product_id');
            })
            ->leftJoin('variant_options as vo', function ($join) {
                $join->on('pv.variant_option_id', '=', 'vo.id');
            })
            ->leftJoin('variants as vrt', function ($join) {
                $join->on('vo.variant_id', '=', 'vrt.id');
            })
            ->leftJoin('units as u', function ($join) {
                $join->on('p.unit_id', '=', 'u.id');
            })
            ->where([['vp.vendor_id', '=', $request->vendor_id], ['vp.deleted_at', '=', null], ['p.deleted_at', '=', null]])
            ->get()
            ->toArray();
        /***************************************************************************************************** */
        if (sizeof($products) == 0) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'No product in cart.'
                ]
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        /***************************************************************************************************** */
        DB::beginTransaction();
        $vendor = Vendor::findOrFail($request->vendor_id);
        // save order
        $order = new Order();
        $order->customer_id = $input['id'];
        $order->vendor_id = $input['vendor_id'];
        $order->address_id = $input['address_id'];
        $order->order_total = 0;
        $order->got_commission_per_order = 0;
        $order->total_payable = 0;
        $order->save();
        $order->order_reference = config('prefix.ORDER_REF') . sprintf('%07d', $order->id);
        $order->save();
        // save products
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
        $order->order_total = $order->total_payable;
        $order->got_commission_per_order = $vendor->got_commission_per_order;
        $order->got_commission_type = $vendor->got_commission_type;
        $order->got_commission = $order->got_commission_per_order;
        $order->total_payable = $order->order_total + $order->got_commission;
        $order->save();
        // reset ordered cart data
        $vendor_product_cart_ids = array_column($products, 'cart_id');
        Cart::destroy($vendor_product_cart_ids);
        // save order address
        $order_address = new OrderCustomerAddress();
        $order_address->order_id = $order->id;
        $order_address->name = $address->name;
        $order_address->address = $address->address;
        $order_address->latitude = $address->latitude;
        $order_address->longitude = $address->longitude;
        $order_address->apartment_no = $address->apartment_no;
        $order_address->apartment_name = $address->apartment_name;
        $order_address->street = $address->street;
        $order_address->landmark = $address->landmark;
        $order_address->pin_code = $address->pin_code;
        $order_address->mobile_no = $address->mobile_no;
        $order_address->address_type = $address->address_type;
        $order_address->save();
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
                    "got_commission" => $order->got_commission,
                    "total_payable" => $order->total_payable,
                ],
                'products' => $products,
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        /***************************************************************************************************** */
    }
    public function order_history(Request $request){
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
        $orders = Order::select(
            'orders.id as order_id',
            'orders.order_reference',
            DB::raw('DATE_FORMAT(orders.created_at,"%Y-%m-%d") as order_date'),
            'v.id as vendor_id',
            'v.vendor_name',
            'orders.total_payable'
        )
            ->leftJoin('order_customer_addresses as oca', function ($join) {
                $join->on('orders.id', '=', 'oca.order_id');
            })
            ->leftJoin('vendors as v', function ($join) {
                $join->on('orders.vendor_id', '=', 'v.id');
            })
            ->where([['orders.customer_id', '=', $request->id], ['v.deleted_at', '=', null]])
            ->orderBy('orders.id', 'DESC')
            ->get()
            ->toArray();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => sizeof($orders) > 0 ? 'true' : 'false',
                'message' => 'Orders fetched successfully !',
            ],
            'data' => [
                'orders' => $orders,
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
