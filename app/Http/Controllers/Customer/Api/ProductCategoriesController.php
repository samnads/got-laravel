<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Models\VendorProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductCategories;
use App\Models\ProductCategoryMapping;
use Illuminate\Support\Str;
use Response;

class ProductCategoriesController extends Controller
{
    public function categories(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'vendor_id' => 'required|exists:vendors,id',
            ],
            [],
            [
                'vendor_id' => 'Vendor',
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
        $vendor_products = VendorProduct::select('product_id')->where('vendor_id', $request->vendor_id)->get();
        $vendor_product_ids = array_column($vendor_products->toArray(), 'product_id');
        $categories = ProductCategoryMapping::select(
            'pc.id',
            'pc.name',
            'pc.description'
        )
            ->leftJoin('product_categories as pc', function ($join) {
                $join->on('product_category_mappings.category_id', '=', 'pc.id');
            })
            ->whereIn('product_category_mappings.product_id', $vendor_product_ids)
            ->where([['pc.deleted_at', '=', null]])
            ->get();
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Categories fetched successfully !',
            ],
            'data' => [
                'categories' => $categories
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function sub_categories(Request $request)
    {
        /***************************************************************************************************** */
        $input = $request->all();
        $validator = Validator::make(
            (array) $input,
            [
                'category_id' => 'required|integer',
                'vendor_id' => 'nullable|integer',
            ],
            [],
            [
                'category_id' => 'Parent Category',
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
        $category = ProductCategories::find($input['category_id']);
        if (!$category) {
            $response = [
                'status' => [
                    'success' => 'false',
                    'hasdata' => 'false',
                    'message' => 'Category not found !',
                ],
            ];
            return Response::json($response, 200, [], JSON_PRETTY_PRINT);
        }
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Sub Categories fetched successfully !',
            ],
            'data' => [
                'sub_categories' => $category->sub_categories()->select('id', 'name', 'description')->get()
            ]
        ];
        return Response::json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
