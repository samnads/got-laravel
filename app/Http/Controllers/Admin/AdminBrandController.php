<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class AdminBrandController extends Controller
{
    public function brands_list(Request $request)
    {
        $data['brands'] = Brand::get();
        return view('admin.master.brands-list', $data);
    }
    public function new_brand(Request $request)
    {
        return view('admin.master.brand-new', []);
    }
    public function edit_brand(Request $request,$brand_id)
    {
        $data['brand'] = Brand::findOrFail($brand_id);
        return view('admin.master.brand-edit', $data);
    }
}
