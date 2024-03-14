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
        $category = ProductCategories::select('id', 'name', 'description', DB::raw('null as thumbnail_url'))->where([['id', '=', $request->category_id]])->first();
        $v_products = VendorProduct::select('product_id')->where('vendor_id', $request->vendor_id)->get();
        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
        $vendor_products = ProductCategoryMapping::select(
            DB::raw('DISTINCT(p.id) as id'),
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
            DB::raw('null as thumbnail_url'),
        )
            ->leftJoin('products as p', function ($join) {
                $join->on('product_category_mappings.product_id', '=', 'p.id');
            })
            ->leftJoin('units as u', function ($join) {
                $join->on('p.unit_id', '=', 'u.id');
            })
            ->leftJoin('vendor_products as vp', function ($join) use ($request) {
                $join->on('product_category_mappings.product_id', '=', 'vp.product_id');
                $join->where('vp.vendor_id', '=', $request->vendor_id);
            })
            ->whereIn('product_category_mappings.product_id', $vendor_product_ids)
            ->where([['product_category_mappings.category_id', '=', $request->category_id], ['p.deleted_at', '=', null], ['vp.deleted_at', '=', null]])
            ->get();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Vendor products fetched successfully !',
            ],
            'data' => [
                'category' => $category,
                'products' => $vendor_products

            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
