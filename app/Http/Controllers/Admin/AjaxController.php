<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategories;

class AjaxController extends Controller
{
    public function save_product_category(Request $request)
    {
        $category = new ProductCategories();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_at = now();
        $category->updated_at = now();
        $category->save();
        $response = ['success' => true, 'message' => 'Category Added Successfully !'];
        return response()->json($response);
    }
}
