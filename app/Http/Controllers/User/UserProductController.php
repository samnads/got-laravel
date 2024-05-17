<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategoryMapping;
use App\Models\ProductVariant;
use App\Models\Unit;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Location;
use App\Models\State;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\ProductCategories;
use Illuminate\Support\Facades\Validator;
use DB;
use Intervention\Image\Facades\Image as Image;

class UserProductController extends Controller
{
    public function new_product(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($request->method() == 'POST') {
                    if ($request->have_variations == "1") {
                        DB::beginTransaction();
                        /************************************************************* */
                        // Variant family identifier
                        $product = new Product();
                        $product->unit_id = $request->unit_id;
                        $product->brand_id = $request->brand_id;
                        $product->name = $request->name;
                        $product->description = $request->description;
                        $product->code = $request->code;
                        $product->item_size = $request->item_size;
                        $product->maximum_retail_price = $request->maximum_retail_price;
                        $product->save();
                        $product->parent_product_id = $product->id;
                        $parent_product_id = $product->id;
                        $product->save();
                        $product_ids[] = $product->id;
                        /************************************************************* */
                        foreach ($request->variants as $key => $variant) {
                            $product = new Product();
                            $product->parent_product_id = $parent_product_id;
                            $product->unit_id = $request->unit_id;
                            $product->brand_id = $request->brand_id;
                            $product->name = $request->name;
                            $product->description = $request->description;
                            $product->code = $request->variant_codes[$key];
                            $product->item_size = $request->variant_sizes[$key];
                            $product->maximum_retail_price = $request->variant_mrps[$key];
                            $product->save();
                            $product_ids[] = $product->id;
                            /************************************* */
                            if (@$request->file('variant_thumbnail_images')[$key]) {
                                $file = $request->file('variant_thumbnail_images')[$key];
                                $image_resize = Image::make($file->getRealPath());
                                $image_resize->fit(300, 300);
                                $thumbnail_image_name = $product->id . '-' . $file->hashName();
                                $image_resize->save(config('filesystems.uploads_path') . ('products/' . $thumbnail_image_name), 100);
                                $product->thumbnail_image = $thumbnail_image_name;
                            }
                            /************************************* */
                            $product->save();
                        }
                        /************************************************************* */
                        foreach ($product_ids as $product_id) {
                            $category_mapping = new ProductCategoryMapping();
                            $category_mapping->product_id = $product_id;
                            $category_mapping->category_id = $request->category_id;
                            $category_mapping->save();
                            // Save variant details
                            $variant_option = VariantOption::where([['variant_id', '=', 1], ['variant_option_name', '=', $request->variant_labels[$key]]])->first();
                            if (!$variant_option) {
                                $variant_option = new VariantOption;
                                $variant_option->variant_id = 1;
                                $variant_option->variant_option_name = $request->variant_labels[$key];
                                $variant_option->save();
                            }
                            // Map variant to product
                            $product_variant = new ProductVariant;
                            $product_variant->product_id = $product_id;
                            $product_variant->variant_option_id = $variant_option->id;
                            $product_variant->save();
                        }
                        DB::commit();
                    } else {
                        DB::beginTransaction();
                        $product = new Product();
                        $product->unit_id = $request->unit_id;
                        $product->brand_id = $request->brand_id;
                        $product->name = $request->name;
                        $product->description = $request->description;
                        $product->code = $request->code;
                        $product->item_size = $request->item_size;
                        $product->maximum_retail_price = $request->maximum_retail_price;
                        $product->save();
                        /************************************* */
                        if ($request->file('thumbnail_image')) {
                            $file = $request->file('thumbnail_image');
                            $image_resize = Image::make($file->getRealPath());
                            $image_resize->fit(300, 300);
                            //$image_resize->save(public_path('uploads/products/' . $file->hashName()), 100);
                            $thumbnail_image_name = $product->id . '-' . $file->hashName();
                            $image_resize->save(config('filesystems.uploads_path') . ('products/' . $thumbnail_image_name), 100);
                            $product->thumbnail_image = $thumbnail_image_name;
                        }
                        /************************************* */
                        $product->save();
                        $category_mapping = new ProductCategoryMapping();
                        $category_mapping->product_id = $product->id;
                        $category_mapping->category_id = $request->category_id;
                        $category_mapping->save();
                        DB::commit();
                    }
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Product Saved !',
                            'content' => 'Product added successfully.'
                        ],
                    ];
                    return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
                }
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
        } else {
            $data['units'] = Unit::select('units.id as value', 'units.name as label', 'units.code')->get();
            $data['brands'] = Brand::select('brands.id as value', 'brands.name as label')->get();
            $data['product_categories'] = ProductCategories::select('product_categories.id as value', 'product_categories.name as label')->get();
            return view('user.products.new-product', $data);
        }
    }
    public function list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
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
                            });
                        $data_table['recordsTotal'] = $rows->count();
                        // Main and Variant family only
                        $rows->where(function ($query) use ($request) {
                            $query->whereNull('products.parent_product_id');
                            $query->orWhereColumn('products.parent_product_id', 'products.id');
                        });
                        $rows->where(function ($query) use ($request) {
                            $query->where([['products.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['products.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['b.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('products.id', 'desc');
                        }
                        if ($request->filter_status == null) {
                            $rows->withTrashed();
                        } else if (@$request->filter_status == "0") {
                            $rows->onlyTrashed();
                        }
                        if ($request->filter_brand_id) {
                            $rows->where('b.id', $request->filter_brand_id);
                        }
                        if (@$request->filter_category_id) {
                            $rows->where('pcm.category_id', $request->filter_category_id);
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        if ($request->length != -1) {
                            $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        } else {
                            $data_table['data'] = $rows->get()->toArray();
                        }
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['slno'] = ($request->start + $key + 1);
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . config('url.uploads_cdn') . 'products/' . ($row['thumbnail_image'] ?: 'default.jpg') . '" class="product-img-2" alt="product img">';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm bg-light" role="group">
											<button type="button" data-action="quick-edit" data-id="' . $row['id'] . '" class="btn btn-outline-primary"><i class="bx bx-pencil"></i>
											</button>
										</div>';
                            $data_table['data'][$key]['status_html'] = '<div class="form-check-success form-check form-switch">
									<input data-action="toggle-status" data-id="' . $row['id'] . '" class="form-check-input" type="checkbox" id="status_' . $row['id'] . '" ' . ($row['deleted_at'] == null ? 'checked' : '') . '>
									<label class="form-check-label" for="status_' . $row['id'] . '"></label>
								</div>';
                            if ($row['id'] != $row['parent_product_id']) {
                                // No varint product
                                //$data_table['data'][$key]['name'] = '';
                            }
                            else{
                                // Variant product
                                $data_table['data'][$key]['name'] .= '<p class="mt-2"><button class="small" role="button"><i class="lni lni-angle-double-right"></i> View variation SKUs</button></p>';
                                $data_table['data'][$key]['maximum_retail_price'] = '';
                                $data_table['data'][$key]['item_size'] = '';
                                $data_table['data'][$key]['status_html'] = '';
                                $data_table['data'][$key]['actions_html'] = '';
                            }
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
        $data['units'] = Unit::select('units.id as value', 'units.name as label', 'units.code')->get();
        $data['brands'] = Brand::select('brands.id as value', 'brands.name as label')->get();
        $data['product_categories'] = ProductCategories::select('product_categories.id as value', 'product_categories.name as label')->get();
        return view('user.products.products-list', $data);
    }
    public function read(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->action == 'quick-edit') {
                $data['product'] = Product::withTrashed()->findOrFail($id);
                $data['product']['category'] = ProductCategoryMapping::
                    select(
                        'pc.id',
                        'pc.name'
                    )
                    ->leftJoin('product_categories as pc', function ($join) {
                        $join->on('product_category_mappings.category_id', '=', 'pc.id');
                    })
                    ->withTrashed()
                    ->where('product_category_mappings.product_id', $id)
                    ->first();
                /*$data['vendor']['location'] = Location::withTrashed()->find(@$data['vendor']->location_id);
                $data['vendor']['district'] = District::withTrashed()->find(@$data['vendor']['location']->district_id);
                $data['vendor']['state'] = State::withTrashed()->find(@$data['vendor']['district']->state_id);*/
            }
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Data fetched !',
                    'content' => 'Data fetched successfully.'
                ],
                'data' => @$data ?: []
            ];
            return response()->json($response ?: [], 200, [], JSON_PRETTY_PRINT);
        }
    }
    public function create(Request $request)
    {
        try {
            /******************************************************************************* */
            $validator = Validator::make(
                (array) $request->all(),
                [
                    'code' => 'required|unique:products,code',
                    'description' => 'nullable|string',
                    'category_id' => 'required|exists:product_categories,id',
                    'brand_id' => 'nullable|exists:brands,id',
                    'item_size' => 'required|integer',
                    'unit_id' => 'required|exists:units,id',
                    'maximum_retail_price' => 'required|numeric',

                ],
                [],
                [
                    'id' => 'Product',
                    'code' => 'Code',
                    'description' => 'Description',
                    'category_id' => 'Category',
                    'brand_id' => 'Brand',
                    'item_size' => 'Item Size',
                    'unit_id' => 'Unit',
                    'maximum_retail_price' => 'MRP.',
                ]
            );
            if ($validator->fails()) {
                $response = [
                    'status' => false,
                    'error' => [
                        'type' => 'error',
                        'title' => 'Error !',
                        'content' => $validator->errors()->first()
                    ]
                ];
                return response()->json($response, 200, [], JSON_PRETTY_PRINT);
            }
            /******************************************************************************* */
            DB::beginTransaction();
            $row = new Product();
            $row->name = $request->name;
            $row->brand_id = $request->brand_id;
            $row->item_size = $request->item_size;
            $row->unit_id = $request->unit_id;
            $row->maximum_retail_price = $request->maximum_retail_price;
            $row->code = $request->code;
            $row->description = $request->description;
            $row->save();
            /************************************* */
            if ($request->file('thumbnail_image')) {
                $file = $request->file('thumbnail_image');
                $image_resize = Image::make($file->getRealPath());
                $image_resize->fit(300, 300);
                //$image_resize->save(public_path('uploads/products/' . $file->hashName()), 100);
                $thumbnail_image_name = $row->id . '-' . $file->hashName();
                $image_resize->save(config('filesystems.uploads_path') . ('products/' . $thumbnail_image_name), 100);
                $row->thumbnail_image = $thumbnail_image_name;
            }
            /************************************* */
            $row->save();
            $category_mapping = new ProductCategoryMapping();
            $category_mapping->product_id = $row->id;
            $category_mapping->category_id = $request->category_id;
            $category_mapping->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Product Saved !',
                    'content' => 'Product added successfully.'
                ],
            ];
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
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
                ],
                'request' => json_decode(file_get_contents('php://input'), true)
            ];
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                if ($request->action == 'quick-edit') {
                    /******************************************************************************* */
                    $validator = Validator::make(
                        (array) $request->all(),
                        [
                            'id' => 'required|exists:products,id',
                            'code' => 'required|unique:products,code,' . $request->id,
                            'description' => 'nullable|string',
                            'category_id' => 'required|exists:product_categories,id',
                            'brand_id' => 'nullable|exists:brands,id',
                            'item_size' => 'required|integer',
                            'unit_id' => 'required|exists:units,id',
                            'maximum_retail_price' => 'required|numeric',

                        ],
                        [],
                        [
                            'id' => 'Product',
                            'code' => 'Code',
                            'description' => 'Description',
                            'category_id' => 'Category',
                            'brand_id' => 'Brand',
                            'item_size' => 'Item Size',
                            'unit_id' => 'Unit',
                            'maximum_retail_price' => 'MRP.',
                        ]
                    );
                    if ($validator->fails()) {
                        $response = [
                            'status' => false,
                            'error' => [
                                'type' => 'error',
                                'title' => 'Error !',
                                'content' => $validator->errors()->first()
                            ]
                        ];
                        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                    }
                    /******************************************************************************* */
                    DB::beginTransaction();
                    $row = Product::withTrashed()->findOrFail($id);
                    $row->name = $request->name;
                    $row->brand_id = $request->brand_id;
                    $row->item_size = $request->item_size;
                    $row->unit_id = $request->unit_id;
                    $row->maximum_retail_price = $request->maximum_retail_price;
                    $row->code = $request->code;
                    $row->description = $request->description;
                    /************************************* */
                    if ($request->file('thumbnail_image')) {
                        $file = $request->file('thumbnail_image');
                        $image_resize = Image::make($file->getRealPath());
                        $image_resize->fit(300, 300);
                        //$image_resize->save(public_path('uploads/products/' . $file->hashName()), 100);
                        $thumbnail_image_name = $row->id . '-' . $file->hashName();
                        $image_resize->save(config('filesystems.uploads_path') . ('products/' . $thumbnail_image_name), 100);
                        $row->thumbnail_image = $thumbnail_image_name;
                    }
                    $row->save();
                    $category_mapping = ProductCategoryMapping::where([['product_id', '=', $row->id]])->first();
                    $category_mapping->category_id = $request->category_id;
                    $category_mapping->save();
                    // Delete duplicate category entries
                    ProductCategoryMapping::where([['product_id', '=', $row->id], ['category_id', '!=', $request->category_id]])->withTrashed()->forceDelete();
                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Product Updated !',
                            'content' => 'Product updated successfully.'
                        ]
                    ];
                } else if ($request->action == 'toggle-status') {
                    $row = Product::withTrashed()->findOrFail($id);
                    if ($request->status == "disable") {
                        $row->delete();
                        $status = 'disabled';
                    } else {
                        $row->restore();
                        $status = 'enabled';
                    }
                    $row->save();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Status Updated !',
                            'content' => 'Product ' . $status . ' successfully.'
                        ]
                    ];
                }
                return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
            }
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollback();
            }
            $response = [
                'status' => false,
                'error' => [
                    'type' => 'error',
                    'title' => 'Exception !',
                    'content' => $e->getMessage()
                ]
            ];
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
        }
    }
}
