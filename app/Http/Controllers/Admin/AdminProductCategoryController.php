<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProductCategoryController extends Controller
{
    public function categories_list(Request $request)
    {
        return view('admin.master.category-list', []);
    }
    public function new_category(Request $request)
    {
        return view('admin.master.category-new', []);
    }
}
