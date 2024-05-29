<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ProductCategories;
use App\Models\ProductRequest;
use App\Models\ProductRequestStatus;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;

class VendorProductController extends Controller
{
    public function my_products(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorProduct::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'vendor_products.id',
                            'p.id as master_id',
                            'p.parent_product_id',
                            'vendor_products.product_id',
                            'vendor_products.maximum_retail_price',
                            'vendor_products.retail_price',
                            'p.name',
                            'p.code',
                            'p.item_size',
                            'u.name as unit',
                            'u.code as unit_code',
                            DB::raw('IFNULL(b.name,"-") as brand'),
                            'p.description',
                            'pc.name as category',
                            DB::raw('CONCAT(ROUND(p.item_size,2)," ",u.name) as size_label'),
                            'vendor_products.deleted_at',
                            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(p.thumbnail_image,"default.jpg"),"?v=","' . config('version.vendor_assets') . '") as thumbnail_url'),
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
                            ->where('p.deleted_at', null)
                            ->withTrashed();
                        $data_table['recordsTotal'] = $rows->count();
                        // Main and Variant family only
                        $rows->where(function ($query) use ($request) {
                            $query->whereNull('p.parent_product_id');
                            $query->orWhereColumn('p.parent_product_id', 'p.id');
                        });
                        $rows->where(function ($query) use ($request) {
                            $query->where([['p.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['p.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_products.id', 'desc');
                        }
                        // filter start
                        if (@$request->filter_category_id) {
                            $rows->where('pcm.category_id', $request->filter_category_id);
                        }
                        if (@$request->filter_brand_id) {
                            $rows->where('b.id', $request->filter_brand_id);
                        }
                        if (@$request->filter_status == "1") {
                            $rows->where([['vendor_products.deleted_at', '=', null]]);
                        } else if (@$request->filter_status == "0") {
                            //$rows->where([['vendor_products.deleted_at', '!=', null]]);

                            $rows->where(function ($query) use ($request) {
                                $query->where([['vendor_products.deleted_at', '!=', null]]);
                                $query->orWhere('p.parent_product_id', '!=', null);
                            });
                        }
                        // filter end
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group bg-light" role="group" aria-label="Basic example">
											<button type="button" data-action="quick-edit-product" data-id="' . $row['id'] . '" class="btn btn-outline-primary"><i class="bx bx-pencil"></i>
											</button>
										</div>';
                            $data_table['data'][$key]['status_html'] = '<div class="form-check-success form-check form-switch">
									<input data-action="toggle-status" data-id="' . $row['id'] . '" class="form-check-input" type="checkbox" id="status_' . $row['id'] . '" ' . ($row['deleted_at'] == null ? 'checked' : '') . '>
									<label class="form-check-label" for="status_' . $row['id'] . '"></label>
								</div>';
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . $row['thumbnail_url'] . '" class="product-img-2" alt="product img">';
                            if ($row['master_id'] != $row['parent_product_id']) {
                                // No variant product
                                //$data_table['data'][$key]['name'] = '';
                            } else {
                                // Variant product
                                $data_table['data'][$key]['name'] .= '<p class="mt-2"><button data-action="show-variants" class="small" role="button"><i class="lni lni-angle-double-right"></i> View variation SKUs</button></p>';
                                $data_table['data'][$key]['maximum_retail_price'] = '';
                                $data_table['data'][$key]['item_size'] = '';
                                $data_table['data'][$key]['status_html'] = '';
                                $data_table['data'][$key]['retail_price'] = '';
                                $data_table['data'][$key]['action_html'] = '';
                            }
                        }
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'variants':
                        $rows = Product::select(
                            'products.id',
                            'products.parent_product_id',
                            'products.code',
                            DB::raw('CONCAT(round(products.item_size)," ",u.name) as item_size'),
                            'products.name',
                            'products.maximum_retail_price',
                            'products.thumbnail_image',
                            'b.name as brand',
                            'u.name as unit',
                            'pc.name as product_category',
                            'products.deleted_at',
                            'vp.deleted_at as vp_deleted_at',
                            'vo.variant_option_name',
                            'vp.id as vp_id'
                        )
                            ->leftJoin('vendor_products as vp', function ($join) {
                                $join->on('products.id', '=', 'vp.product_id');
                                $join->where('vp.vendor_id', '=', DB::raw(Auth::guard('vendor')->id()));
                            })
                            ->leftJoin('brands as b', function ($join) {
                                $join->on('products.brand_id', '=', 'b.id');
                            })
                            ->leftJoin('units as u', function ($join) {
                                $join->on('products.unit_id', '=', 'u.id');
                            })
                            ->leftJoin('product_category_mappings as pcm', function ($join) {
                                $join->on('products.id', '=', 'pcm.product_id');
                            })
                            ->leftJoin('product_categories as pc', function ($join) {
                                $join->on('pcm.category_id', '=', 'pc.id');
                            })
                            ->leftJoin('product_variants as pv', function ($join) {
                                $join->on('products.id', '=', 'pv.product_id');
                            })
                            ->leftJoin('variant_options as vo', function ($join) {
                                $join->on('pv.variant_option_id', '=', 'vo.id');
                            })
                            ->where('products.parent_product_id', '=', $request->id)
                            ->whereColumn('products.parent_product_id', '!=', 'products.id')
                            ->whereNull('products.deleted_at')
                            ->whereNotNull('vp.id');
                        if (@$request->filter_status == "1") {
                            $rows->where([['vp.deleted_at', '=', null]]);
                        } else {
                            $rows->where([['vp.deleted_at', '!=', null]]);
                        }
                        $rows = $rows->orderBy('products.id', 'asc');
                        $data_table['data'] = $rows->withTrashed()->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['slno'] = ($request->start + $key + 1);
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . config('url.uploads_cdn') . 'products/' . ($row['thumbnail_image'] ?: 'default.jpg') . '" class="product-img-2" alt="product img">';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group bg-light" role="group" aria-label="Basic example">
											<button type="button" data-action="quick-edit-product" data-id="' . $row['vp_id'] . '" class="btn btn-outline-primary"><i class="bx bx-pencil"></i>
											</button>
										</div>';
                            $data_table['data'][$key]['status_html'] = '<div class="form-check-success form-check form-switch">
									<input data-action="toggle-status" data-id="' . $row['vp_id'] . '" class="form-check-input" type="checkbox" id="status_' . $row['vp_id'] . '" ' . ($row['vp_deleted_at'] == null ? 'checked' : '') . '>
									<label class="form-check-label" for="status_' . $row['vp_id'] . '"></label>
								</div>';
                            if ($row['id'] != $row['parent_product_id']) {
                                // No varint product
                                //$data_table['data'][$key]['name'] = '';
                            } else {
                                // Variant product
                                $data_table['data'][$key]['name'] .= '<p class="mt-2"><button class="small" role="button" data-action="show-variants"><i class="lni lni-angle-double-right"></i> View variation SKUs</button></p>';
                                //$data_table['data'][$key]['maximum_retail_price'] = '';
                                //$data_table['data'][$key]['item_size'] = '';
                                //$data_table['data'][$key]['status_html'] = '';
                                //$data_table['data'][$key]['actions_html'] = '';
                            }
                        }
                        $data_table['status'] = true;
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'quick-edit':
                        switch ($request->method()) {
                            case 'GET':
                                $product = VendorProduct::select(
                                    'vendor_products.id',
                                    'vendor_products.product_id',
                                    'vendor_products.maximum_retail_price',
                                    'vendor_products.retail_price',
                                    'p.name',
                                    'p.code',
                                    'p.item_size',
                                    'u.name as unit',
                                    'u.code as unit_code',
                                    DB::raw('IFNULL(b.name,"-") as brand'),
                                    'p.description',
                                    'p.deleted_at',
                                    'pc.name as category',
                                    'vendor_products.deleted_at',
                                    'vendor_products.min_cart_quantity',
                                    'vendor_products.max_cart_quantity'
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
                                    ->where('vendor_products.id', $request->id)
                                    ->withTrashed()
                                    ->first();
                                $response = [
                                    'status' => true,
                                    'data' => [
                                            'product' => $product
                                        ]
                                ];
                                break;
                            case 'PUT':
                                /******************************************************************************* */
                                $validator = Validator::make(
                                    (array) $request->all(),
                                    [
                                        'id' => 'required|exists:vendor_products,id',
                                        'min_cart_quantity' => 'required|integer|min:1',
                                        'max_cart_quantity' => 'required|integer|gte:min_cart_quantity',
                                        'maximum_retail_price' => 'required_with:retail_price|regex:/^\d+(\.\d{1,2})?$/',
                                        'retail_price' => 'required_with:maximum_retail_price|lte:maximum_retail_price',
                                    ],
                                    [],
                                    [
                                        'id' => 'Product',
                                        'min_cart_quantity' => 'Min. Cart Quantity',
                                        'max_cart_quantity' => 'Max Cart Quantity',
                                        'maximum_retail_price' => 'MRP.',
                                        'retail_price' => 'Selling Price',
                                    ]
                                );
                                if ($validator->fails()) {
                                    $response = [
                                        'status' => false,
                                        'error' => [
                                                'type' => 'error',
                                                'title' => 'Validation Error !',
                                                'content' => $validator->errors()->first()
                                            ]
                                    ];
                                    return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                                }
                                /******************************************************************************* */
                                $product = VendorProduct::where('vendor_products.vendor_id', Auth::guard('vendor')->id())
                                    ->where('vendor_products.id', $request->id)
                                    ->withTrashed()
                                    ->first();
                                $product->min_cart_quantity = $request->min_cart_quantity;
                                $product->max_cart_quantity = $request->max_cart_quantity;
                                $product->maximum_retail_price = $request->maximum_retail_price;
                                $product->retail_price = $request->retail_price;
                                $product->save();
                                $response = [
                                    'status' => true,
                                    'message' => [
                                            'type' => 'success',
                                            'title' => 'Product Updated',
                                            'content' => 'Task completed successfully.'
                                        ]
                                ];
                                break;
                            default:
                                $response = [
                                    'status' => false,
                                    'type' => 'error',
                                    'title' => 'Error !',
                                    'content' => 'Unknown method !',
                                ];
                        }
                        break;
                    case 'toggle-status':
                        $product = VendorProduct::where('vendor_products.vendor_id', Auth::guard('vendor')->id())
                            ->where('vendor_products.id', $request->id)
                            ->withTrashed()
                            ->first();
                        if ($request->status == "disable") {
                            $product->delete();
                        } else {
                            $product->restore();
                        }
                        $product->save();
                        DB::commit();
                        $response = [
                            'status' => true,
                            'message' => [
                                    'type' => 'success',
                                    'title' => 'Status Updated !',
                                    'content' => 'Product status updated successfully.'
                                ]
                        ];
                        break;
                    default:
                        $response = [
                            'status' => false,
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => 'Unknown action !',
                            'data' => null
                        ];
                }
                DB::commit();
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                if (DB::transactionLevel() > 0) {
                    DB::rollback();
                }
                $response = [
                    'status' => false,
                    'error' => [
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => $e->getMessage()
                        ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }

        }
        $data['product_categories'] = ProductCategories::select('product_categories.id as value', 'product_categories.name as label')->get();
        $data['brands'] = Brand::select('brands.id as value', 'brands.name as label')->get();
        return view('vendor.product.my-products', $data);
    }
    public function available_products(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $v_products = VendorProduct::select('product_id')
                            ->leftJoin('products as p', function ($join) {
                                $join->on('vendor_products.product_id', '=', 'p.id');
                            })
                            ->where(function ($query) use ($request) {
                                $query->whereNull('p.parent_product_id');
                            })
                            ->where('vendor_products.vendor_id', Auth::guard('vendor')->id())
                            ->withTrashed()->get();
                        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
                        $rows = Product::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'products.id',
                            'products.parent_product_id',
                            'products.code',
                            'products.item_size',
                            'products.name',
                            'products.description',
                            'products.maximum_retail_price',
                            'u.name as unit',
                            'u.code as unit_code',
                            DB::raw('IFNULL(b.name,"-") as brand'),
                            DB::raw('CONCAT(ROUND(products.item_size,2)," ",u.name) as size_label'),
                            'pc.name as category',
                            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(products.thumbnail_image,"default.jpg"),"?v=","' . config('version.vendor_assets') . '") as thumbnail_url'),
                        )
                            ->leftJoin('units as u', function ($join) {
                                $join->on('products.unit_id', '=', 'u.id');
                            })
                            ->leftJoin('brands as b', function ($join) {
                                $join->on('products.brand_id', '=', 'b.id');
                            })
                            ->leftJoin('product_category_mappings as pcm', function ($join) {
                                $join->on('products.id', '=', 'pcm.product_id');
                            })
                            ->leftJoin('product_categories as pc', function ($join) {
                                $join->on('pcm.category_id', '=', 'pc.id');
                            })
                            ->whereNotIn('products.id', $vendor_product_ids);
                        $data_table['recordsTotal'] = $rows->count();
                        // Main and Variant family only
                        $rows->where(function ($query) use ($request) {
                            $query->whereNull('products.parent_product_id');
                            $query->orWhereColumn('products.parent_product_id', 'products.id');
                        });
                        $rows->where(function ($query) use ($request) {
                            $query->where([['products.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['products.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('products.id', 'desc');
                        }
                        // filter start
                        if (@$request->filter_category_id) {
                            $rows->where('pcm.category_id', $request->filter_category_id);
                        }
                        if (@$request->filter_brand_id) {
                            $rows->where('b.id', $request->filter_brand_id);
                        }
                        // filter end
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
										</div>';
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . $row['thumbnail_url'] . '" class="product-img-2" alt="product img">';
                            if ($row['id'] != $row['parent_product_id']) {
                                // No varint product
                                //$data_table['data'][$key]['name'] = '';
                            } else {
                                // Variant product
                                $data_table['data'][$key]['name'] .= '<p class="mt-2"><button data-action="show-variants" class="small" role="button"><i class="lni lni-angle-double-right"></i> View variation SKUs</button></p>';
                                $data_table['data'][$key]['maximum_retail_price'] = '';
                                $data_table['data'][$key]['item_size'] = '';
                                $data_table['data'][$key]['action_html'] = '';
                            }
                        }
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'variants':
                        $rows = Product::select(
                            'products.id',
                            'products.parent_product_id',
                            'products.code',
                            DB::raw('CONCAT(round(products.item_size)," ",u.name) as item_size'),
                            'products.name',
                            'products.maximum_retail_price',
                            'products.thumbnail_image',
                            'b.name as brand',
                            'u.name as unit',
                            'pc.name as product_category',
                            'products.deleted_at',
                            'vo.variant_option_name',
                        )
                            ->leftJoin('vendor_products as vp', function ($join) {
                                $join->on('vp.product_id', '=', 'products.id');
                                $join->on('vp.vendor_id', '=', DB::raw(Auth::guard('vendor')->id()));
                            })
                            ->leftJoin('brands as b', function ($join) {
                                $join->on('products.brand_id', '=', 'b.id');
                            })
                            ->leftJoin('units as u', function ($join) {
                                $join->on('products.unit_id', '=', 'u.id');
                            })
                            ->leftJoin('product_category_mappings as pcm', function ($join) {
                                $join->on('products.id', '=', 'pcm.product_id');
                            })
                            ->leftJoin('product_categories as pc', function ($join) {
                                $join->on('pcm.category_id', '=', 'pc.id');
                            })
                            ->leftJoin('product_variants as pv', function ($join) {
                                $join->on('products.id', '=', 'pv.product_id');
                            })
                            ->leftJoin('variant_options as vo', function ($join) {
                                $join->on('pv.variant_option_id', '=', 'vo.id');
                            })
                            // Exclude if already exist
                            ->whereNull('vp.id')
                            // Hide variants if parent is not active
                            ->where(function ($query) use ($request) {
                                $query->where('products.parent_product_id', '=', $request->id)
                                    ->whereNull('products.deleted_at');
                            })
                            // Exclude parent
                            ->where('products.id', '!=', $request->id)
                            ->orderBy('products.id', 'asc');
                        $data_table['data'] = $rows->withTrashed()->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['slno'] = ($request->start + $key + 1);
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . config('url.uploads_cdn') . 'products/' . ($row['thumbnail_image'] ?: 'default.jpg') . '" class="product-img-2" alt="product img">';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
										</div>';
                            if ($row['id'] != $row['parent_product_id']) {
                                // No varint product
                                //$data_table['data'][$key]['name'] = '';
                            } else {
                                // Variant product
                                $data_table['data'][$key]['name'] .= '<p class="mt-2"><button class="small" role="button" data-action="show-variants"><i class="lni lni-angle-double-right"></i> View variation SKUs</button></p>';
                                //$data_table['data'][$key]['maximum_retail_price'] = '';
                                //$data_table['data'][$key]['item_size'] = '';
                                //$data_table['data'][$key]['status_html'] = '';
                                //$data_table['data'][$key]['actions_html'] = '';
                            }
                        }
                        $data_table['status'] = true;
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'product-for-add':
                        $product = Product::findOrFail($request->id);
                        $response = [
                            'status' => true,
                            'data' => [
                                    'product' => $product
                                ]
                        ];
                        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                    case 'save-new-product':
                        /******************************************************************************* */
                        $validator = Validator::make(
                            (array) $request->all(),
                            [
                                'id' => 'required|exists:products,id',
                                'min_cart_quantity' => 'required|integer|min:1',
                                'max_cart_quantity' => 'required|integer|gte:min_cart_quantity',
                                'maximum_retail_price' => 'required|numeric|gt:0',
                                'retail_price' => 'required|numeric|lte:maximum_retail_price',
                            ],
                            [],
                            [
                                'id' => 'Product',
                                'min_cart_quantity' => 'Min. Cart Quantity',
                                'max_cart_quantity' => 'Max Cart Quantity',
                                'maximum_retail_price' => 'MRP.',
                                'retail_price' => 'Selling Price',
                            ]
                        );
                        if ($validator->fails()) {
                            $response = [
                                'status' => false,
                                'error' => [
                                        'type' => 'error',
                                        'title' => 'Validation Error !',
                                        'content' => $validator->errors()->first()
                                    ]
                            ];
                            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                        }
                        /******************************************************************************* */
                        $product_master = Product::findOrFail($request->id);
                        if ($product_master->parent_product_id != null && ($product_master->parent_product_id != $product_master->id)) {
                            // Product from variant family
                            // Check product exist
                            $check = VendorProduct::where([['vendor_id', '=', Auth::guard('vendor')->id()], ['product_id', '=', $product_master->id]])->first();
                            if (!$check) {
                                // add parent first
                                $product_new = VendorProduct::where([['vendor_id', '=', Auth::guard('vendor')->id()], ['product_id', '=', $product_master->parent_product_id]])->first() ?: new VendorProduct();
                                $product_new->vendor_id = Auth::guard('vendor')->id();
                                $product_new->product_id = $product_master->parent_product_id;
                                $product_new->min_cart_quantity = $request->min_cart_quantity;
                                $product_new->max_cart_quantity = $request->max_cart_quantity;
                                $product_new->maximum_retail_price = $request->maximum_retail_price;
                                $product_new->retail_price = $request->retail_price;
                                $product_new->save();
                            }
                        }
                        /******************************************************************************* */
                        // add product
                        $product = new VendorProduct();
                        $product->vendor_id = Auth::guard('vendor')->id();
                        $product->product_id = $request->id;
                        $product->min_cart_quantity = $request->min_cart_quantity;
                        $product->max_cart_quantity = $request->max_cart_quantity;
                        $product->maximum_retail_price = $request->maximum_retail_price;
                        $product->retail_price = $request->retail_price;
                        $product->save();
                        $response = [
                            'status' => true,
                            'message' => [
                                    'type' => 'success',
                                    'title' => 'Added !',
                                    'content' => 'Product added successfully.'
                                ]
                        ];
                        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                    default:
                        $response = [
                            'status' => false,
                            'error' => [
                                    'type' => 'error',
                                    'title' => 'Error !',
                                    'content' => 'Unknown action.'
                                ]
                        ];
                }
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                if (DB::transactionLevel() > 0) {
                    DB::rollback();
                }
                $response = [
                    'status' => false,
                    'error' => [
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => $e->getMessage()
                        ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }

        }
        $data['product_categories'] = ProductCategories::select('product_categories.id as value', 'product_categories.name as label')->get();
        $data['brands'] = Brand::select('brands.id as value', 'brands.name as label')->get();
        return view('vendor.product.available-products', $data);
    }
    public function product_requests(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = ProductRequest::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'product_requests.id',
                            'product_requests.product_request_reference',
                            'product_requests.vendor_id',
                            'product_requests.product_id',
                            DB::raw('IFNULL(product_requests.code,"-") as code'),
                            'product_requests.item_size',
                            'product_requests.unit_id',
                            'product_requests.brand_id',
                            'product_requests.name',
                            'product_requests.description',
                            'product_requests.maximum_retail_price',
                            'product_requests.retail_price',
                            'product_requests.product_request_status_id',
                            'prs.label as product_request_status',
                            'product_requests.product_request_status_user_id',
                            'product_requests.product_request_status_changed_at',
                            'product_requests.additional_information',
                            'u.name as unit',
                            'u.code as unit_code',
                            DB::raw('IFNULL(b.name,"-") as brand'),
                            DB::raw('CONCAT(ROUND(product_requests.item_size,2)," ",u.name) as size_label'),
                            'prs.bg_color as product_request_status_bg_color',
                            'prs.text_color as product_request_status_text_color',
                            DB::raw('IFNULL(pc.name,"-") as category'),
                        )
                            ->leftJoin('units as u', function ($join) {
                                $join->on('product_requests.unit_id', '=', 'u.id');
                            })
                            ->leftJoin('brands as b', function ($join) {
                                $join->on('product_requests.brand_id', '=', 'b.id');
                            })
                            ->leftJoin('product_request_statuses as prs', function ($join) {
                                $join->on('product_requests.product_request_status_id', '=', 'prs.id');
                            })
                            ->leftJoin('product_categories as pc', function ($join) {
                                $join->on('product_requests.product_category_id', '=', 'pc.id');
                            })
                            ->where('product_requests.vendor_id', Auth::guard('vendor')->id());
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['product_requests.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['product_requests.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['product_requests.description', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['product_requests.additional_information', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('product_requests.id', 'desc');
                        }
                        if (@$request->filter_request_status_id) {
                            $rows->where('product_request_status_id', $request->filter_request_status_id);
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['product_request_status_html'] = '<span class="badge shadow-sm w-100" style="background:' . $row['product_request_status_bg_color'] . ';color:' . $row['product_request_status_text_color'] . ';">' . $row['product_request_status'] . '</span>';
                        }
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    default:
                        $response = [
                            'status' => false,
                            'error' => [
                                    'type' => 'error',
                                    'title' => 'Error !',
                                    'content' => 'Unknown action.'
                                ]
                        ];
                }
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                if (DB::transactionLevel() > 0) {
                    DB::rollback();
                }
                $response = [
                    'status' => false,
                    'error' => [
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => $e->getMessage()
                        ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }

        }
        $data['product_request_statuses'] = ProductRequestStatus::get();
        return view('vendor.product.product-request-list', $data);
    }
    public function new_product_request(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->method()) {
                    case 'POST':
                        DB::beginTransaction();
                        /******************************************************************************* */
                        $validator = Validator::make(
                            (array) $request->all(),
                            [
                                'name' => 'required|string',
                                'code' => 'nullable|unique:products,code',
                                'description' => 'nullable|string',
                                'category_id' => 'required|exists:product_categories,id',
                                'brand_id' => 'nullable|exists:brands,id',
                                'maximum_retail_price' => 'required|numeric|gt:0',
                                'retail_price' => 'nullable|numeric|lte:maximum_retail_price',
                                'item_size' => 'required|numeric|min:1',
                                'unit_id' => 'required|exists:units,id',
                                'additional_information' => 'nullable|string',

                            ],
                            [],
                            [
                                'name' => 'Name',
                                'code' => 'Code',
                                'description' => 'Description',
                                'category_id' => 'Category',
                                'brand_id' => 'Brand',
                                'maximum_retail_price' => 'MRP.',
                                'retail_price' => 'Selling Price',
                                'item_size' => 'Item Size',
                                'unit_id' => 'Unit',
                                'additional_information' => 'Additional Information',
                            ]
                        );
                        if ($validator->fails()) {
                            $response = [
                                'status' => false,
                                'error' => [
                                        'type' => 'error',
                                        'title' => 'Validation Error !',
                                        'content' => $validator->errors()->first()
                                    ]
                            ];
                            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                        }
                        /******************************************************************************* */
                        $product_request = new ProductRequest();
                        $product_request->vendor_id = Auth::guard('vendor')->id();
                        $product_request->code = $request->code;
                        $product_request->item_size = $request->item_size;
                        $product_request->unit_id = $request->unit_id;
                        $product_request->brand_id = $request->brand_id;
                        $product_request->product_category_id = $request->category_id;
                        $product_request->name = $request->name;
                        $product_request->description = $request->description;
                        $product_request->maximum_retail_price = $request->maximum_retail_price;
                        $product_request->retail_price = $request->retail_price;
                        $product_request->product_request_status_id = 1;
                        $product_request->additional_information = $request->additional_information;
                        $product_request->save();
                        $product_request->product_request_reference = config('prefix.PRODUCT_REQUEST_REF') . sprintf('%07d', $product_request->id);
                        $product_request->save();
                        DB::commit();
                        $response = [
                            'status' => true,
                            'message' => [
                                    'type' => 'success',
                                    'title' => 'Request Sent !',
                                    'content' => 'Product request send successfully.'
                                ],
                            'redirect' => route('vendor.product.requests')
                        ];
                        //Session::flash('toast', $response['message']);
                        break;
                    default:
                        $response = [
                            'status' => false,
                            'error' => [
                                    'type' => 'error',
                                    'title' => 'Error !',
                                    'content' => 'Unknown action.'
                                ]
                        ];
                }
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                if (DB::transactionLevel() > 0) {
                    DB::rollback();
                }
                $response = [
                    'status' => false,
                    'error' => [
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => $e->getMessage()
                        ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }
        }
        return view('vendor.product.new-product-request', []);
    }
}