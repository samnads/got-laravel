<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\VendorProduct;
use App\Models\Order;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // The user is logged in...
            return redirect()->route('admin.dashboard');
            //return view('admin.dashboard', []);
        }
        return view('admin.login', []);
    }
    public function dashboard(Request $request)
    {
        $data['vendors_count'] = Vendor::count();
        $data['products_count'] = Product::count();
        $data['vendor_products_count'] = VendorProduct::count();
        $data['orders_count'] = Order::count();
        return view('admin.dashboard', $data);
    }
}
