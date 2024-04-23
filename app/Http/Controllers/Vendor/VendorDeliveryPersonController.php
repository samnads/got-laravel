<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\VendorDeliveryPerson;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class VendorDeliveryPersonController extends Controller
{
    public function delivery_persons_list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorDeliveryPerson::select(
                            'vendor_delivery_persons.id',
                            'vendor_delivery_persons.code',
                            'vendor_delivery_persons.vendor_id',
                            'vendor_delivery_persons.name',
                            'vendor_delivery_persons.mobile_number_1_cc',
                            'vendor_delivery_persons.mobile_number_1',
                        )
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('vendor_delivery_persons.vendor_id', '=', 'v.id');
                            })
                            ->where('vendor_delivery_persons.vendor_id', Auth::guard('vendor')->id());
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['vendor_delivery_persons.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['vendor_delivery_persons.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['vendor_delivery_persons.mobile_number_1', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_delivery_persons.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['slno'] = $key + 1;
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
											<button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" data-action="edit-row" data-id="' . $row['id'] . '" type="button" class="btn btn-warning"><i class="bx bxs-pencil"></i>
											</button>
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
        $data['order_statuses'] = OrderStatus::get();
        return view('vendor.masters.delivery-persons', $data);
    }
    public function index(Request $request)
    {
        try {
            switch ($request->method()) {
                case 'POST':
                    /******************************************************************************* */
                    $validator = Validator::make(
                        (array) $request->all(),
                        [
                            'name' => 'required|string|unique:vendor_delivery_persons,name',
                            'mobile_number_1' => 'required|digits:10|unique:vendor_delivery_persons,mobile_number_1',

                        ],
                        [],
                        [
                            'name' => 'Delivery Person\'s Name',
                            'mobile_number_1' => 'Mobile Number',
                        ]
                    );
                    if ($validator->fails()) {
                        $response = [
                            'status' => false,
                            'error' => [
                                'type' => 'error',
                                'title' => 'Failed !',
                                'content' => $validator->errors()->first()
                            ]
                        ];
                        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                    }
                    /******************************************************************************* */
                    DB::beginTransaction();
                    $vendor_delivery_person = new VendorDeliveryPerson();
                    $vendor_delivery_person->code = time();
                    $vendor_delivery_person->vendor_id = Auth::guard('vendor')->id();
                    $vendor_delivery_person->name = $request->name;
                    $vendor_delivery_person->mobile_number_1 = $request->mobile_number_1;
                    $vendor_delivery_person->save();
                    $vendor_delivery_person->code = config('prefix.DELIVERY_PERSON_CODE') . sprintf('%07d', $vendor_delivery_person->id);
                    $vendor_delivery_person->save();
                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Saved !',
                            'content' => 'Delivery person added successfully.'
                        ],
                    ];
                    break;
                case 'GET':
                    switch ($request->action) {
                        case 'quick-edit-popup':
                            $vendor_delivery_person = VendorDeliveryPerson::findOrFail($request->id);
                            $response = [
                                'status' => true,
                                'data' => [
                                    'vendor_delivery_person' => $vendor_delivery_person
                                ]
                            ];
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
                    break;
                case 'PUT':
                    /******************************************************************************* */
                    $validator = Validator::make(
                        (array) $request->all(),
                        [
                            'name' => 'required|string|unique:vendor_delivery_persons,name,'.$request->id,
                            'mobile_number_1' => 'required|digits:10|unique:vendor_delivery_persons,mobile_number_1,'.$request->id,

                        ],
                        [],
                        [
                            'name' => 'Delivery Person\'s Name',
                            'mobile_number_1' => 'Mobile Number',
                        ]
                    );
                    if ($validator->fails()) {
                        $response = [
                            'status' => false,
                            'error' => [
                                'type' => 'error',
                                'title' => 'Failed !',
                                'content' => $validator->errors()->first()
                            ]
                        ];
                        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
                    }
                    /******************************************************************************* */
                    DB::beginTransaction();
                    $vendor_delivery_person = VendorDeliveryPerson::findOrFail($request->id);
                    $vendor_delivery_person->name = $request->name;
                    $vendor_delivery_person->mobile_number_1 = $request->mobile_number_1;
                    $vendor_delivery_person->save();
                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => [
                            'type' => 'success',
                            'title' => 'Updated !',
                            'content' => 'Delivery person updated successfully.'
                        ],
                    ];
                    break;
                case 'DELETE':
                    break;
                default:
                    $response = [
                        'status' => false,
                        'error' => [
                            'type' => 'error',
                            'title' => 'Error !',
                            'content' => 'Unknown method.'
                        ]
                    ];
            }
            return response()->json(@$response ?: [], 200, [], JSON_PRETTY_PRINT);
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
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }
    }
}
