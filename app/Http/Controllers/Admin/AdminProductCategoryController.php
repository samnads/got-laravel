<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategories;

class AdminProductCategoryController extends Controller
{
    public function categories_list(Request $request)
    {
        $data['categories'] = ProductCategories::where([['parent_id', '=', null]])->orderByDesc('id')->get();
        return view('admin.master.product-category-list', $data);
    }
    public function edit_category(Request $request,$category_id)
    {
        $data['category'] = ProductCategories::where([['id', '=', $category_id]])->first();
        return view('admin.master.category-edit', $data);
    }
    public function sub_categories_list(Request $request)
    {
        $data['categories'] = ProductCategories::where([['parent_id','!=',null]])->orderByDesc('id')->get();
        return view('admin.master.category-list', $data);
    }
    public function new_category(Request $request)
    {
        return view('admin.master.category-new', []);
    }
}
