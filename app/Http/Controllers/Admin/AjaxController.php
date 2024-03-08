<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use Session;

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
        /******************** */
        Session::flash('title', 'Success !');
        Session::flash('message', 'Category Added Successfully !');
        Session::flash('type', 'success');
        $response = ['status' => 'success', 'message' => 'Category Added Successfully !'];
        /********************* */
        return response()->json($response);
    }
}
