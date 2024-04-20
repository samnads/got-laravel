<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class VendorOrderController extends Controller
{
    public function pending_orders_list(Request $request)
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
                            'orders.vendor_id',
                            'orders.address_id',
                            'orders.total_payable',
                            DB::raw('"Pending" as order_status'),
                            DB::raw('"Cash" as payment_mode'),
                            DB::raw('"Pending" as payment_status'),
                        )
                            ->leftJoin('customers as c', function ($join) {
                                $join->on('orders.customer_id', '=', 'c.id');
                            })
                            ->leftJoin('order_customer_addresses as oca', function ($join) {
                                $join->on('orders.id', '=', 'oca.order_id');
                            })
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
                            $rows->orderBy('orders.id', 'asc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
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
        return view('shop.orders.pending-list', []);
    }
}