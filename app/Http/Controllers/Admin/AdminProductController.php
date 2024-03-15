<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;

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
        )
            ->leftJoin('units as u', function ($join) {
                $join->on('products.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('products.brand_id', '=', 'b.id');
            })
            ->withTrashed()
            ->get();
        return view('admin.product.product-list', $data);
    }
    public function product_block(Request $request,$product_id)
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
        Session::flash('toast', ['type' => 'success', 'title' => 'Blocked !', 'message' => 'Product <b>' . $product->name . '</b> unblocked successfully.']);
        return redirect()->route('admin.product-list');
    }
}
