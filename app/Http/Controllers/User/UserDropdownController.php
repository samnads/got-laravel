<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Location;
use App\Models\ProductCategories;
use App\Models\Vendor;
use Illuminate\Http\Request;

class UserDropdownController extends Controller
{
    public function districts(Request $request, $usage)
    {
        switch ($usage) {
            case 'quick-edit-vendor':
                $query_string = @$request->all()['query'];
                $items = District::
                    select('districts.district_id as value', 'districts.name as label')
                    ->where('districts.state_id', $request->state_id)
                    ->whereAny([
                        'districts.name',
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
    public function locations(Request $request, $usage)
    {
        switch ($usage) {
            case 'quick-edit-vendor':
                $query_string = @$request->all()['query'];
                $items = Location::
                    select('locations.id as value', 'locations.name as label')
                    ->where('locations.district_id', $request->district_id)
                    ->whereAny([
                        'locations.name',
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
            case 'quick-edit-product':
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
            case 'quick-add-product':
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
    public function vendors(Request $request, $usage)
    {
        switch ($usage) {
            case 'new-invoice':
                $query_string = @$request->all()['query'];
                $items = Vendor::
                    select('vendors.id as value', 'vendors.vendor_name as label', 'vendors.owner_name', 'vendors.mobile_number', 'vendors.address')
                    ->whereAny([
                        'vendors.vendor_name',
                        'vendors.owner_name',
                        'vendors.mobile_number',
                        'vendors.address',
                    ], 'LIKE', "%" . $query_string . "%")
                    ->take(100)
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
