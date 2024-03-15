<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use Illuminate\Support\Facades\Auth;
use Session;

class VendorProductController extends Controller
{
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