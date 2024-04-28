<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Location;
use App\Models\State;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\ProductCategories;
use DB;
use Intervention\Image\Facades\Image as Image;

class UserVendorController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        $rows = Vendor::select(
                            'vendors.id',
                            'vendors.vendor_name as name',
                            'vendors.owner_name as owner',
                            'vendors.mobile_number',
                            'vendors.gst_number',
                            'vendors.deleted_at',
                            'l.name as location',
                            'd.name as district',
                            's.name as state',
                            'vendors.shop_thumbnail as thumbnail_image'
                        )
                            ->leftJoin('locations as l', function ($join) {
                                $join->on('vendors.location_id', '=', 'l.id');
                            })
                            ->leftJoin('districts as d', function ($join) {
                                $join->on('l.district_id', '=', 'd.district_id');
                            })
                            ->leftJoin('states as s', function ($join) {
                                $join->on('d.state_id', '=', 's.state_id');
                            });
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['vendors.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['vendors.mobile_number', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendors.id', 'desc');
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
                            $data_table['data'][$key]['thumbnail_image_html'] = '<img src="' . config('url.uploads_cdn') . 'vendors/' . ($row['thumbnail_image'] ?: 'default.jpg') . '" class="product-img-2" alt="product img">';
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
        $data['states'] = State::select('states.state_id as value','states.name as label')->get();
        return view('user.vendors.vendors-list', $data);
    }
    public function read(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->action == 'quick-edit') {
                $data['vendor'] = Vendor::findOrFail($id);
                $data['vendor']['location'] = Location::find(@$data['vendor']->location_id);
                $data['vendor']['district'] = District::find(@$data['vendor']['location']->district_id);
                $data['vendor']['state'] = State::find(@$data['vendor']['district']->state_id);
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
    public function update(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                if ($request->action == 'quick-edit') {
                    $brand = Vendor::findOrFail($id);
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
                    $row = Vendor::withTrashed()->findOrFail($id);
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
                            'content' => 'Vendor ' . $status . ' successfully.'
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
