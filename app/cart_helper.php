<?php
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

function cartPrice($input)
{
    $cart_products = Cart::select(
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
        DB::raw('ROUND((IFNULL(cart.quantity,0) * vp.maximum_retail_price) - (IFNULL(cart.quantity,0) * vp.retail_price),2) as saved_amount'),
        DB::raw('ROUND((IFNULL(cart.quantity,0) * vp.retail_price),2) as total_amount'),
        DB::raw('ROUND((IFNULL(cart.quantity,0) * vp.maximum_retail_price),2) as maximum_retail_price_total'),
        DB::raw('ROUND((IFNULL(cart.quantity,0) * vp.retail_price),2) as retail_price_total'),
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
        ->where([['cart.customer_id', '=', $input['id']], ['vp.vendor_id', '=', $input['vendor_id']], ['vp.deleted_at', '=', null], ['p.deleted_at', '=', null]])
        ->get();
    $response = [
        'maximum_retail_price' => 0,
        'retail_price' => 0,
        'saved_amount' => 0,
        'got_commission' => 0,
        'total_payable' => 0,
    ];
    foreach ($cart_products as $key => $cart_product) {
        $response['maximum_retail_price'] += $cart_products[$key]['maximum_retail_price_total'];
        $response['retail_price'] += $cart_products[$key]['retail_price_total'];
    }
    $response['saved_amount'] = $response['maximum_retail_price'] - $response['retail_price'];
    $response['got_commission'] = 0;
    $response['total_payable'] = $response['retail_price'];
    return $response;
}