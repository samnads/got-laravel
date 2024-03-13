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
                'vendor_id' => 'required',
                'sub_category_id' => 'required|integer',
            ],
            [],
            [
                'vendor_id' => 'Vendor ID',
                'sub_category_id' => 'Sub Category ID',
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
        if (@$request->sub_category_id) {
            $sub_category = ProductCategories::where([['id', '=', $request->sub_category_id], ['parent_id', '!=', null]])->first();
            $category = ProductCategories::where([['id', '=', $sub_category->parent_id]])->first();
        }
        $vendor = Vendor::select(
            'id',
            'vendor_name as name',
        )
            ->where([['id', '=', $request->vendor_id]])
            ->first();
        $vendor_products = VendorProduct::select(
            'vendor_products.id as id',
            'p.name',
            'p.code',
            'p.description',
            'vendor_products.maximum_retail_price',
            'vendor_products.retail_price'
        )
            ->leftJoin('products as p', function ($join) {
                $join->on('vendor_products.product_id', '=', 'p.id');
            });
        if (@$request->sub_category_id) {
            $vendor_products->where([['p.product_sub_category_id', '=', $request->sub_category_id]]);
        }
        $vendor_products = $vendor_products->where([['vendor_products.vendor_id', '=', $request->vendor_id], ['p.deleted_at', '=', null]])
            ->get();
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Vendor products fetched successfully !',
            ],
            'data' => [
                'vendor' => $vendor,
                'category' => [
                    'id' => @$category->id,
                    'name' => @$category->name
                ],
                'sub_category' => [
                    'id' => @$sub_category->id,
                    'name' => @$sub_category->name
                ],
                'products' => $vendor_products

            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
