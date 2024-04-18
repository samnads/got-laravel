<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;

class VendorProductController extends Controller
{
    public function my_products(Request $request)
    {
        return view('shop.product.my-products', []);
    }
    public function available_products(Request $request)
    {
        return view('shop.product.available-products', []);
    }
    public function product_list(Request $request)
    {
        $data['products'] = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.product_id',
            'vendor_products.maximum_retail_price',
            'vendor_products.retail_price',
            'p.name',
            'p.code',
            'p.item_size',
            'u.name as unit',
            'u.code as unit_code',
            'b.name as brand',
            'p.description',
            'p.deleted_at',
            'pc.name as category',
            'vendor_products.deleted_at'
        )
            ->leftJoin('products as p', function ($join) {
                $join->on('vendor_products.product_id', '=', 'p.id');
            })
            ->leftJoin('units as u', function ($join) {
                $join->on('p.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('p.brand_id', '=', 'b.id');
            })
            ->leftJoin('product_category_mappings as pcm', function ($join) {
                $join->on('p.id', '=', 'pcm.product_id');
            })
            ->leftJoin('product_categories as pc', function ($join) {
                $join->on('pcm.category_id', '=', 'pc.id');
            })
            ->where('vendor_products.vendor_id', Auth::guard('vendor')->id())
            ->withTrashed()
            ->get();
        return view('vendor.product-list', $data);
    }
    public function product_list_for_add(Request $request)
    {
        $v_products = VendorProduct::select('product_id')->where('vendor_id', Auth::guard('vendor')->id())->withTrashed()->get();
        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
        $data['products'] = Product::select(
            'products.id',
            'products.code',
            'products.item_size',
            'products.name',
            'products.description',
            'products.maximum_retail_price',
            'u.name as unit',
            'u.code as unit_code',
            'b.name as brand',
            'pc.name as category',
        )
            ->leftJoin('units as u', function ($join) {
                $join->on('products.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('products.brand_id', '=', 'b.id');
            })
            ->leftJoin('product_category_mappings as pcm', function ($join) {
                $join->on('products.id', '=', 'pcm.product_id');
            })
            ->leftJoin('product_categories as pc', function ($join) {
                $join->on('pcm.category_id', '=', 'pc.id');
            })
            ->whereNotIn('products.id', $vendor_product_ids)
            ->get();
        return view('vendor.product-list-for-add', $data);
    }
    public function update_product(Request $request)
    {
        $product = VendorProduct::withTrashed()->find($request->id);
        $product->retail_price = $request->retail_price;
        $product->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Updated !', 'message' => 'Product updated successfully.']);
        return redirect()->route('vendor.product.list');
    }
    public function add_product(Request $request)
    {
        $product = new VendorProduct();
        $product->vendor_id = Auth::guard('vendor')->id();
        $product->product_id = $request->id;
        $product->min_cart_quantity = $request->min_cart_quantity;
        $product->max_cart_quantity = $request->max_cart_quantity;
        $product->maximum_retail_price = $request->maximum_retail_price;
        $product->retail_price = $request->retail_price;
        $product->save();
        Session::flash('toast', ['type' => 'success', 'title' => 'Added !', 'message' => 'Product added successfully.']);
        return redirect()->route('vendor.product.list');
    }
    public function delete(Request $request, $product_id)
    {
        $product = VendorProduct::where([['vendor_id', '=', Auth::guard('vendor')->id()]])->withTrashed()->find($product_id);
        $product->delete();
        Session::flash('toast', ['type' => 'success', 'title' => 'Removed !', 'message' => 'Product removed successfully.']);
        return redirect()->route('vendor.product.list');
    }
    public function restore(Request $request, $product_id)
    {
        $product = VendorProduct::where([['vendor_id', '=', Auth::guard('vendor')->id()]])->withTrashed()->find($product_id);
        $product->restore();
        Session::flash('toast', ['type' => 'success', 'title' => 'Removed !', 'message' => 'Product restored successfully.']);
        return redirect()->route('vendor.product.list');
    }
}