<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ProductCategoryMapping;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\Unit;
use Session;
use Intervention\Image\Facades\Image as Image;

class AdminProductController extends Controller
{
    public function product_list(Request $request)
    {
        $data['products'] = Product::select(
            'products.id',
            'products.name',
            'products.code',
            'products.item_size',
            'u.name as unit',
            'b.name as brand',
            'u.code as unit_code',
            'products.description',
            'products.deleted_at',
            'products.thumbnail_image'
        )
            ->leftJoin('units as u', function ($join) {
                $join->on('products.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('products.brand_id', '=', 'b.id');
            })
            ->withTrashed()
            ->orderByDesc('products.id')
            ->get();
        return view('admin.product.product-list', $data);
    }
    public function product_new(Request $request)
    {
        $data['units'] = Unit::get();
        $data['categories'] = ProductCategories::get();
        $data['brands'] = Brand::get();
        return view('admin.product.product-new', $data);
    }
    public function product_edit(Request $request, $product_id)
    {
        $data['product'] = Product::find($product_id);
        $data['product_category'] = ProductCategoryMapping::where('product_id', $product_id)->first();
        $data['units'] = Unit::get();
        $data['categories'] = ProductCategories::get();
        $data['brands'] = Brand::get();
        return view('admin.product.product-edit', $data);
    }
    public function product_save(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->item_size = $request->item_size;
        $product->unit_id = $request->unit_id;
        $product->brand_id = $request->brand_id;
        $product->maximum_retail_price = $request->maximum_retail_price;
        /************************************* */
        if ($request->file('thumbnail_image')) {
            $file = $request->file('thumbnail_image');
            $fileName = $file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('uploads/products/' . $file->hashName()), 100);
            //$filePath = $file->store('categories', 'public_uploads');
            $product->thumbnail_image = $file->hashName();
        }
        $product->save();
        /************************************* */
        $pcm = new ProductCategoryMapping();
        $pcm->product_id = $product->id;
        $pcm->category_id = $request->category_id;
        $pcm->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Product saved successfully.']);
        $response = ['status' => 'success', 'message' => 'Product saved successfully.'];
        return redirect()->route('admin.product-list');
    }
    public function product_update(Request $request)
    {
        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->item_size = $request->item_size;
        $product->unit_id = $request->unit_id;
        $product->brand_id = $request->brand_id;
        $product->maximum_retail_price = $request->maximum_retail_price;
        /************************************* */
        if ($request->file('thumbnail_image')) {
            $file = $request->file('thumbnail_image');
            $fileName = $file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('uploads/products/' . $file->hashName()), 100);
            //$filePath = $file->store('categories', 'public_uploads');
            $product->thumbnail_image = $file->hashName();
        }
        $product->save();
        /************************************* */
        $pcm = ProductCategoryMapping::where([['product_id', '=', $product->id], ['category_id', '=', $request->category_id]])->first() ?: new ProductCategoryMapping();
        $pcm->product_id = $product->id;
        $pcm->category_id = $request->category_id;
        $pcm->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Success !', 'message' => 'Product updated successfully.']);
        $response = ['status' => 'success', 'message' => 'Product updated successfully.'];
        return redirect()->route('admin.product-list');
    }
    public function product_block(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        $product->deleted_at = now();
        $product->save();
        Session::flash('toast', ['type' => 'info', 'title' => 'Blocked !', 'message' => 'Product <b>' . $product->name . '</b> blocked successfully.']);
        return redirect()->route('admin.product-list');
    }
    public function product_unblock(Request $request, $product_id)
    {
        $product = Product::withTrashed()->find($product_id);
        $product->deleted_at = null;
        $product->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Unblocked !', 'message' => 'Product <b>' . $product->name . '</b> unblocked successfully.']);
        return redirect()->route('admin.product-list');
    }
}
