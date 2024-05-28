<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use App\Models\ProductCategoryMapping;
use App\Models\VendorProduct;
use App\Models\ProductCategories;
use Illuminate\Support\Str;
use Response;

class VendorProductController extends Controller
{
    public function vendor_products(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'vendor_id' => 'required|exists:vendors,id',
                'category_id' => 'required|exists:product_categories,id',
            ],
            [],
            [
                'vendor_id' => 'Vendor',
                'category_id' => 'Category',
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
        /***************************************************************************************************** */
        $vendor = Vendor::select(
            'id',
            'vendor_name as name',
        )
            ->where([['id', '=', $request->vendor_id]])
            ->first();
        /***************************************************************************************************** */
        $category = ProductCategories::select('id as category_id', 'name', 'description', DB::raw('CONCAT("' . config('url.uploads_cdn') . '","categories/",thumbnail_image) as thumbnail_url'), )->where([['id', '=', $request->category_id]])->first();
        $v_products = VendorProduct::select('product_id')->where('vendor_id', $request->vendor_id)->get();
        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
        $vendor_products = ProductCategoryMapping::select(
            DB::raw('DISTINCT(vp.id) as product_id'),
            'vp.product_id as master_product_id',
            'p.parent_product_id',
            'p.name',
            'p.code',
            'p.item_size',
            'u.name as unit',
            'u.code as unit_code',
            'p.description',
            'vp.maximum_retail_price',
            'vp.retail_price',
            'vp.min_cart_quantity',
            'vp.max_cart_quantity',
            'vo.variant_option_name',
            'vrt.variant_name',
            DB::raw('IFNULL(cr.quantity,0) as quantity'),
            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(p.thumbnail_image,"default.jpg")) as thumbnail_url'),
            DB::raw('ROUND((vp.maximum_retail_price - vp.retail_price),2) as offer'),
            DB::raw('IFNULL(ROUND((((vp.maximum_retail_price - vp.retail_price) / vp.maximum_retail_price)*100),2),0) as offer_percentage'),
            DB::raw('ROUND((IFNULL(cr.quantity,0) * vp.maximum_retail_price) - (IFNULL(cr.quantity,0) * vp.retail_price),2) as saved_amount'),
            DB::raw('ROUND((IFNULL(cr.quantity,0) * vp.retail_price),2) as total_amount')
        )
            ->leftJoin('products as p', function ($join) {
                $join->on('product_category_mappings.product_id', '=', 'p.id');
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
            ->leftJoin('vendor_products as vp', function ($join) use ($request) {
                $join->on('product_category_mappings.product_id', '=', 'vp.product_id');
                $join->where('vp.vendor_id', '=', $request->vendor_id);
            })
            ->leftJoin('cart as cr', function ($join) use ($request, $input) {
                $join->on('vp.id', '=', 'cr.vendor_product_id');
                $join->where('cr.customer_id', '=', $input['id']);
                $join->where('cr.deleted_at', '=', null);
            })
            ->whereIn('product_category_mappings.product_id', $vendor_product_ids)
            ->where([['product_category_mappings.category_id', '=', $request->category_id], ['p.deleted_at', '=', null], ['vp.deleted_at', '=', null]])
            ->get()
            ->toArray();
        /************************************************************************************** */
        $vendor_main_products = [];
        foreach ($vendor_products as $key => $vendor_product) {
            // Exclude variants, keep main product
            if ($vendor_product['parent_product_id'] == null || ($vendor_product['parent_product_id'] == $vendor_product['master_product_id'])) {
                $vendor_main_products[] = $vendor_product;
            }
        }
        /************************************************************************************** */
        $products = [];
        foreach ($vendor_main_products as $key => $vendor_main_product) {
            if ($vendor_main_product['parent_product_id'] != null) {
                // variant found
                $vendor_main_product['variants'][$vendor_main_product['variant_name']] = array_values(array_filter($vendor_products, function ($vendor_productss) use ($vendor_main_product) {
                    return ($vendor_main_product['parent_product_id'] == $vendor_productss['parent_product_id'] && $vendor_main_product['parent_product_id'] != $vendor_productss['master_product_id']);
                }));
                $products[] = $vendor_main_product;
            } else {
                //$vendor_main_product['variants'] = null;
                $products[] = $vendor_main_product;
            }
        }
        /************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => sizeof($vendor_products) ? 'true' : 'false',
                'message' => 'Vendor products fetched successfully !',
            ],
            'data' => [
                'category' => $category,
                'products' => $products,
                'cart_price' => cartPrice($input)

            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
