<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductCategories;
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
                'vendor_id' => 'nullable|integer',
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
        $categories = ProductCategories::select('id', 'name', 'description')->where([
            ['parent_id', '=', null],
        ])->get();
        /***************************************************************************************************** */
        $response = [
            'status' => [
                'success' => 'true',
                'hasdata' => 'true',
                'message' => 'Categories fetched successfully !',
            ],
            'categories' => $categories
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
