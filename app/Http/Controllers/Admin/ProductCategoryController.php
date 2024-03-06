<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function categories_list(Request $request)
    {
        return view('admin.master.category-list', []);
    }
}
