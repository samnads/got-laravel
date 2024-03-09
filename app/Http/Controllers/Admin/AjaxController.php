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
                if ($request->parent_id) {
                    $category = new ProductCategories();
                    $category->parent_id = $request->parent_id;
                    $category->name = $request->name;
                    $category->description = $request->description;
                    $category->created_at = now();
                    $category->updated_at = now();
                    $category->save();
                    Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Sub category <b>' . $category->name . '</b> added successfully.']);
                    $response = ['status' => 'success', 'message' => 'Sub category added successfully.'];
                } else {
                    $category = new ProductCategories();
                    $category->name = $request->name;
                    $category->description = $request->description;
                    $category->created_at = now();
                    $category->updated_at = now();
                    $category->save();
                    Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Category <b>' . $category->name . '</b> added successfully.']);
                    $response = ['status' => 'success', 'message' => 'Category added successfully.'];
                }
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
            case 'DELETE':
                $category = ProductCategories::find($request->category_id);
                $category->updated_at = now();
                $category->deleted_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Deleted !', 'message' => 'Category <b>' . $category->name . '</b> deleted successfully.']);
                $response = ['status' => 'success', 'message' => 'Category <b>' . $category->name . '</b> deleted successfully.'];
                break;
            default:
                // invalid request
                break;
        }
        return response()->json($response);
    }
}
