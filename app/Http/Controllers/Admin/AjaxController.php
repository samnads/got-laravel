<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\District;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use Session;
use Intervention\Image\Facades\Image as Image;

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
                /************************************* */
                if ($request->file('thumbnail_image')) {
                    $file = $request->file('thumbnail_image');
                    $fileName = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('uploads/categories/' . $file->hashName()), 100);
                    //$filePath = $file->store('categories', 'public_uploads');
                    $category->thumbnail_image = $file->hashName();
                }
                /************************************* */
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Category <b>' . $category->name . '</b> added successfully.']);
                $response = ['status' => 'success', 'message' => 'Category added successfully.'];
                break;
            case 'PUT':
                $category = ProductCategories::find($request->category_id);
                $category->name = $request->name;
                $category->description = $request->description;
                $category->updated_at = now();
                /************************************* */
                if ($request->file('thumbnail_image')) {
                    $file = $request->file('thumbnail_image');
                    $fileName = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('uploads/categories/' . $file->hashName()), 100);
                    //$filePath = $file->store('categories', 'public_uploads');
                    $category->thumbnail_image = $file->hashName();
                }
                $category->save();
                /************************************* */
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
    public function product_sub_category(Request $request)
    {
        switch ($request->method()) {
            case 'POST':
                $category = new ProductCategories();
                $category->parent_id = $request->parent_id;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->created_at = now();
                $category->updated_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Sub category <b>' . $category->name . '</b> added successfully.']);
                $response = ['status' => 'success', 'message' => 'Sub category added successfully.'];
                break;
            case 'PUT':
                $category = ProductCategories::find($request->category_id);
                $category->parent_id = $request->parent_id;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->updated_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Sub Category <b>' . $category->name . '</b> updated successfully.']);
                $response = ['status' => 'success', 'message' => 'Sub Category <b>' . $category->name . '</b> updated successfully.'];
                break;
            case 'DELETE':
                $category = ProductCategories::find($request->category_id);
                $category->deleted_at = now();
                $category->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Deleted !', 'message' => 'Sub category <b>' . $category->name . '</b> deleted successfully.']);
                $response = ['status' => 'success', 'message' => 'Sub category <b>' . $category->name . '</b> deleted successfully.'];
                break;
            default:
                // invalid request
                break;
        }
        return response()->json($response);
    }
    public function brand(Request $request)
    {
        switch ($request->method()) {
            case 'POST':
                $row = new Brand();
                $row->name = $request->name;
                $row->description = $request->description;
                $row->created_at = now();
                $row->updated_at = now();
                /************************************* */
                if ($request->file('thumbnail_image')) {
                    $file = $request->file('thumbnail_image');
                    $fileName = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('uploads/brands/' . $file->hashName()), 100);
                    //$filePath = $file->store('categories', 'public_uploads');
                    $row->thumbnail_image = $file->hashName();
                }
                /************************************* */
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Brand <b>' . $row->name . '</b> added successfully.']);
                $response = ['status' => 'success', 'message' => 'Brand added successfully.'];
                break;
            case 'PUT':
                $row = Brand::find($request->id);
                $row->name = $request->name;
                $row->description = $request->description;
                $row->updated_at = now();
                /************************************* */
                if ($request->file('thumbnail_image')) {
                    $file = $request->file('thumbnail_image');
                    $fileName = $file->getClientOriginalName();
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('uploads/brands/' . $file->hashName()), 100);
                    //$filePath = $file->store('categories', 'public_uploads');
                    $row->thumbnail_image = $file->hashName();
                }
                /************************************* */
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Brand <b>' . $row->name . '</b> updated successfully.']);
                $response = ['status' => 'success', 'message' => 'Brand <b>' . $row->name . '</b> updated successfully.'];
                break;
            case 'DELETE':
                $row = Brand::find($request->id);
                $row->deleted_at = now();
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Deleted !', 'message' => 'Brand <b>' . $row->name . '</b> deleted successfully.']);
                $response = ['status' => 'success', 'message' => 'Brand <b>' . $row->name . '</b> deleted successfully.'];
                break;
            default:
                // invalid request
                break;
        }
        return response()->json($response);
    }
    public function location(Request $request)
    {
        switch ($request->method()) {
            case 'POST':
                $row = new Location();
                $row->name = $request->name;
                $row->district_id = $request->district_id;
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Location added successfully.']);
                $response = ['status' => 'success', 'message' => 'Location added successfully.'];
                break;
            case 'PUT':
                $row = Location::find($request->id);
                $row->name = $request->name;
                $row->district_id = $request->district_id;
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Location updated successfully.']);
                $response = ['status' => 'success', 'message' => 'Location updated successfully.'];
                break;
            case 'DELETE':
                $row = Brand::find($request->id);
                $row->deleted_at = now();
                $row->save();
                Session::flash('toast', ['type' => 'success', 'title' => 'Deleted !', 'message' => 'Brand <b>' . $row->name . '</b> deleted successfully.']);
                $response = ['status' => 'success', 'message' => 'Brand <b>' . $row->name . '</b> deleted successfully.'];
                break;
            default:
                // invalid request
                break;
        }
        return response()->json($response);
    }
    public function get_districts_by_state(Request $request)
    {
        $response['items'] = District::select('district_id as id', 'name')->where('state_id', $request->state_id)->get();
        return response()->json($response);
    }
    public function get_location_by_id(Request $request)
    {
        $response['location'] = Location::
            select(
                'locations.id',
                'd.state_id',
                'locations.district_id',
                'locations.name'
            )
            ->leftJoin('districts as d', function ($join) {
                $join->on('locations.district_id', '=', 'd.district_id');
            })
            ->where('locations.id', $request->location_id)
            ->first();
        $response['districts'] = District::select('district_id as id', 'name')->where('state_id', $response['location']->state_id)->get();
        return response()->json($response);
    }
}
