<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use DB;
use Intervention\Image\Facades\Image as Image;

class UserBrandController extends Controller
{
    public function brands_list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        $rows = Brand::select(
                            'brands.id',
                            'brands.name',
                            'brands.description',
                            'brands.thumbnail_image',
                            'brands.deleted_at'
                        );
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['brands.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['brands.description', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('brands.id', 'desc');
                        }
                        if ($request->filter_status == null) {
                            $rows->withTrashed();
                        } else if (@$request->filter_status == "0") {
                            $rows->onlyTrashed();
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['slno'] = $key + 1;
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . config('url.uploads_cdn') . 'brands/' . ($row['thumbnail_image'] ?: 'default.jpg') . '" class="product-img-2" alt="product img">';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm bg-light" role="group">
											<button type="button" data-action="quick-edit" data-id="' . $row['id'] . '" class="btn btn-outline-primary"><i class="bx bx-pencil"></i>
											</button>
										</div>';
                            $data_table['data'][$key]['status_html'] = '<div class="form-check-success form-check form-switch">
									<input data-action="toggle-status" data-id="' . $row['id'] . '" class="form-check-input" type="checkbox" id="status_' . $row['id'] . '" ' . ($row['deleted_at'] == null ? 'checked' : '') . '>
									<label class="form-check-label" for="status_' . $row['id'] . '"></label>
								</div>';
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
        return view('user.brands.brands-list', []);
    }
    public function get_brand(Request $request, $brand_id)
    {
        if ($request->ajax()) {
            if ($request->action == 'quick-edit') {
                $data['brand'] = Brand::findOrFail($brand_id);
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
    public function add_brand(Request $request)
    {
        try {
            DB::beginTransaction();
            $row = new Brand;
            $row->name = $request->name;
            $row->description = $request->description;
            /************************************* */
            if ($request->file('thumbnail_image')) {
                $file = $request->file('thumbnail_image');
                $image_resize = Image::make($file->getRealPath());
                $image_resize->fit(300, 300);
                $image_resize->save(public_path('uploads/brands/' . $file->hashName()), 100);
                $row->thumbnail_image = $file->hashName();
            }
            /************************************* */
            $row->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Brand Saved !',
                    'content' => 'Brand added successfully.'
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
    public function update_brand(Request $request, $brand_id)
    {
        try {
            if ($request->ajax()) {
                if ($request->action == 'quick-edit') {
                    $brand = Brand::findOrFail($brand_id);
                    $brand->name = $request->name;
                    $brand->description = $request->description;
                    /************************************* */
                    if ($request->file('thumbnail_image')) {
                        $file = $request->file('thumbnail_image');
                        $image_resize = Image::make($file->getRealPath());
                        $image_resize->fit(300, 300);
                        $image_resize->save(public_path('uploads/brands/' . $file->hashName()), 100);
                        $brand->thumbnail_image = $file->hashName();
                    }
                    /************************************* */
                    $brand->save();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Brand Updated !',
                            'content' => 'Brand updated successfully.'
                        ]
                    ];
                } else if ($request->action == 'toggle-status') {
                    $brand = Brand::withTrashed()->findOrFail($brand_id);
                    if ($request->status == "disable") {
                        $brand->delete();
                        $status = 'disabled';
                    } else {
                        $brand->restore();
                        $status = 'enabled';
                    }
                    $brand->save();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Status Updated !',
                            'content' => 'Brand ' . $status . ' successfully.'
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
