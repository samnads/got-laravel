<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function product_list(Request $request)
    {
        $data['products'] = Product::select(
            'products.name',
            'products.code',
            'products.item_size',
            'u.name as unit',
            'b.name as brand',
            'u.code as unit_code',
            'products.description',
        )
            ->leftJoin('units as u', function ($join) {
                $join->on('products.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('products.brand_id', '=', 'b.id');
            })
            ->get();
        return view('admin.product.product-list', $data);
    }
}
