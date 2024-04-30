<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class VendorOrderController extends Controller
{
    public function orders_list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = Order::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'orders.id',
                            'orders.order_reference',
                            'orders.customer_id',
                            'c.name as customer_name',
                            'c.mobile_number_1 as customer_mobile_number_1',
                            'orders.vendor_id',
                            'orders.address_id',
                            'orders.total_payable',
                            DB::raw('"Pending" as order_status'),
                            DB::raw('"Cash" as payment_mode'),
                            DB::raw('"Pending" as payment_status'),
                            //
                            'orders.order_status_id',
                            'os.labelled as os_labelled',
                            'os.bg_color as os_bg_color',
                            'os.text_color as os_text_color',
                            'os.progress as os_progress'
                        )
                            ->leftJoin('customers as c', function ($join) {
                                $join->on('orders.customer_id', '=', 'c.id');
                            })
                            ->leftJoin('order_customer_addresses as oca', function ($join) {
                                $join->on('orders.id', '=', 'oca.order_id');
                            })
                            ->leftJoin('order_statuses as os', function ($join) {
                                $join->on('orders.order_status_id', '=', 'os.id');
                            })
                            ->where('orders.vendor_id', Auth::guard('vendor')->id());
                        if (@$request->filter_order_status_id) {
                            $rows->where('orders.order_status_id', $request->filter_order_status_id);
                        }
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['orders.order_reference', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['c.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.address', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.apartment_name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.landmark', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.mobile_no', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('orders.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['order_status'] = '<div class="d-flex justify-content-between">
  <div class="flex-fill"><span class="badge shadow-sm w-100" style="background:' . $row['os_bg_color'] . ';color:' . $row['os_text_color'] . ';">
                                                                            ' . $row['os_labelled'] .
                                '</span></div>
  <div class="">&nbsp;<button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Update Status" data-action="update-order-status" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-play"></i></button></div>
</div>';
                            $data_table['data'][$key]['order_status_progess'] = '<div class="progress" style="height: 20px;">
									<div class="progress-bar" style="background:' . $row['os_bg_color'] . ';color:' . $row['os_text_color'] . ';width: ' . $row['os_progress'] . '%" role="progressbar">' . $row['os_progress'] .'%</div>
								  </div>';
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
										</div>';
                        }
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'update-order-status':
                        $order = Order::findOrFail($request->id);
                        $order_status = OrderStatus::findOrFail($order->order_status_id);
                        $response = [
                            'status' => true,
                            'data' => [
                                'order' => $order,
                                'order_status' => $order_status
                            ]
                        ];
                        return response()->json($response ?: [], 200, [], JSON_PRETTY_PRINT);
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
        return view('vendor.orders.orders-list', $data);
    }
    public function orders_list_by_status_code(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = Order::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'orders.id',
                            'orders.order_reference',
                            'orders.customer_id',
                            'c.name as customer_name',
                            'c.mobile_number_1 as customer_mobile_number_1',
                            'orders.vendor_id',
                            'orders.address_id',
                            'orders.total_payable',
                            DB::raw('"Pending" as order_status'),
                            DB::raw('"Cash" as payment_mode'),
                            DB::raw('"Pending" as payment_status'),
                            //
                            'orders.order_status_id',
                            'os.labelled as os_labelled',
                            'os.bg_color as os_bg_color',
                            'os.text_color as os_text_color'
                        )
                            ->leftJoin('customers as c', function ($join) {
                                $join->on('orders.customer_id', '=', 'c.id');
                            })
                            ->leftJoin('order_customer_addresses as oca', function ($join) {
                                $join->on('orders.id', '=', 'oca.order_id');
                            })
                            ->leftJoin('order_statuses as os', function ($join) {
                                $join->on('orders.order_status_id', '=', 'os.id');
                            })
                            ->where('os.code', $request->status_code)
                            ->where('orders.vendor_id', Auth::guard('vendor')->id());
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['orders.order_reference', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['c.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.address', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.apartment_name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.landmark', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['oca.mobile_no', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('orders.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['order_status'] = '<span class="badge shadow-sm w-100" style="background:' . $row['os_bg_color'] . ';color:' . $row['os_text_color'] . ';">' . $row['os_labelled'] . '</span>';
                            $data_table['data'][$key]['action_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
											<button data-action="add-product" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-warning"><i class="fadeIn animated bx bx-plus"></i></button>
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
        return view('vendor.orders.orders-by-status-list', []);
    }
}