<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use Session;

class AjaxController extends Controller
{
    public function product_category(Request $request)
    {
        switch ($request->method()) {
            case 'POST':
                $category = new ProductCategories();
                $category->name = $request->name;
                $category->description = $request->description;
                $category->created_at = now();
                $category->updated_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Category <b>' . $category->name . '</b> Added Successfully !']);
                $response = ['status' => 'success', 'message' => 'Category Added Successfully.'];
                break;
            case 'PUT':
                $category = ProductCategories::find($request->category_id);
                $category->name = $request->name;
                $category->description = $request->description;
                $category->updated_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Category <b>' . $category->name . '</b> updated successfully.']);
                $response = ['status' => 'success', 'message' => 'Category <b>' . $category->name . '</b> updated successfully.'];
                break;
            default:
                // invalid request
                break;
        }
        return response()->json($response);
    }
}
