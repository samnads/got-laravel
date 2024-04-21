<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDropdownController extends Controller
{
    public function brands(Request $request, $usage)
    {
        switch ($usage) {
            case 'new-product-request':
                $query_string = @$request->all()['query'];
                $items = Brand::
                    select('brands.id as value', 'brands.name as label')
                    ->whereAny([
                        'brands.name',
                    ], 'LIKE', "%" . $query_string . "%")
                    ->take(30)
                    ->get();
                $response = [
                    'status' => true,
                    'items' => $items
                ];
                break;
            default:
                $response = [
                    'status' => false,
                    'error' => 'Unknown usage.'
                ];
        }
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
    public function categories(Request $request, $usage)
    {
        switch ($usage) {
            case 'new-product-request':
                $query_string = @$request->all()['query'];
                $items = ProductCategories::
                    select('product_categories.id as value', 'product_categories.name as label')
                    ->whereAny([
                        'product_categories.name',
                    ], 'LIKE', "%" . $query_string . "%")
                    ->take(30)
                    ->get();
                $response = [
                    'status' => true,
                    'items' => $items
                ];
                break;
            default:
                $response = [
                    'status' => false,
                    'error' => 'Unknown usage.'
                ];
        }
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
