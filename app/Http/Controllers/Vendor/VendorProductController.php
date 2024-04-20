<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
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
                            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(p.thumbnail_image,"default.jpg"),"?v=","'. config('version.vendor_assets').'") as thumbnail_url'),
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
                        $rows->where(function ($query) use ($request) {
                            $query->where([['p.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['p.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_products.id', 'asc');
                        }
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
                        }
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
        return view('shop.product.my-products', []);
    }
    public function available_products(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $v_products = VendorProduct::select('product_id')->where('vendor_id', Auth::guard('vendor')->id())->withTrashed()->get();
                        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
                        $rows = Product::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'products.id',
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
                            DB::raw('CONCAT("' . config('url.uploads_cdn') . '","products/",IFNULL(products.thumbnail_image,"default.jpg"),"?v=","'. config('version.vendor_assets').'") as thumbnail_url'),
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
                        $rows->where(function ($query) use ($request) {
                            $query->where([['products.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['products.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('products.id', 'asc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
										</div>';
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . $row['thumbnail_url'] . '" class="product-img-2" alt="product img">';
                        }
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
        return view('shop.product.available-products', []);
    }
    public function product_requests(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $v_products = VendorProduct::select('product_id')->where('vendor_id', Auth::guard('vendor')->id())->withTrashed()->get();
                        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
                        $rows = Product::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'products.id',
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
                        $rows->where(function ($query) use ($request) {
                            $query->where([['products.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['products.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('products.id', 'asc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
										</div>';
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . $row['thumbnail_url'] . '" class="product-img-2" alt="product img">';
                        }
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
        return view('shop.product.product-request-list', []);
    }
    public function new_product_request(Request $request)
    {
        return view('shop.product.new-product-request', []);
    }
}