<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvoiceStatus;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\VendorInvoice;
use App\Models\VendorInvoiceLineItem;
use App\Models\VendorInvoicePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class VendorPaymentController extends Controller
{
    public function payments(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorInvoicePayment::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'vendor_invoice_payments.id',
                            'vendor_invoice_payments.payment_reference',
                            'vendor_invoice_payments.vendor_invoice_id',
                            'vendor_invoice_payments.paid_amount',
                            //
                            'vi.vendor_id',
                            'vi.invoice_reference',
                            DB::raw('DATE_FORMAT(vi.for_month, "%M %Y") as for_month'),
                            DB::raw('DATE_FORMAT(vi.due_date, "%d/%m/%Y") as due_date'),
                            'vi.total_payable',
                            'vi.invoice_status_id',
                            DB::raw('DATE_FORMAT(vi.invoice_date, "%d/%m/%Y") as invoice_date'),
                            'vi.created_at',
                            'v.vendor_name',
                            'is.label as is_label',
                            'is.description as is_description',
                            'is.code as is_code',
                            'is.css_class as is_css_class'
                        )
                            ->leftJoin('vendor_invoices as vi', function ($join) {
                                $join->on('vendor_invoice_payments.vendor_invoice_id', '=', 'vi.id');
                            })
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('vi.vendor_id', '=', 'v.id');
                            })
                            ->leftJoin('invoice_statuses as is', function ($join) {
                                $join->on('vi.invoice_status_id', '=', 'is.id');
                            });
                        if (@$request->filter_invoice_status_id) {
                            $rows->where('vi.invoice_status_id', $request->filter_invoice_status_id);
                        }
                        if (@$request->filter_vendor_id) {
                            $rows->where('v.id', $request->filter_vendor_id);
                        }
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['vi.invoice_reference', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['v.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vi.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['invoice_status'] = '<div class="d-flex justify-content-between"><div class="flex-fill"><span class="badge shadow-sm w-100 ' . $row['is_css_class'] . '">' . $row['is_label'] . '</span></div><div class=""></div></div>';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
                            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Change Status" data-action="change-invoice-status" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-primary text-light"><i class="bx bx-info-circle"></i></button>
										</div>';
                        }
                        return response()->json($data_table, 200, [], JSON_PRETTY_PRINT);
                    case 'get-orders-by-month-for-invoice':
                        $vendor = Vendor::findOrFail($request->vendor_id);
                        $month_start = Carbon::parse($request->for_month)->startOfMonth()->format('Y-m-d');
                        $month_end = Carbon::parse($request->for_month)->endOfMonth()->format('Y-m-d');
                        $orders = Order::
                            select(
                                'orders.id',
                                'orders.order_reference',
                                'orders.order_status_id',
                                'orders.got_commission',
                                DB::raw('DATE_FORMAT(orders.created_at, "%d/%m/%Y") as order_date'),
                                'os.labelled as os_labelled'
                            )
                            ->leftJoin('order_statuses as os', function ($join) {
                                $join->on('orders.order_status_id', '=', 'os.id');
                            })
                            ->where(
                                [
                                    ['vendor_id', '=', $request->vendor_id],
                                    ['order_status_id', '=', 5] // 5 - Completed
                                ]
                            )
                            ->whereBetween('orders.created_at', [$month_start, $month_end])
                            ->get();
                        $response = [
                            'status' => true,
                            'message' => [
                                'type' => 'success',
                                'title' => 'Fetched !',
                                'content' => 'Orders fetched successfully.'
                            ],
                            'data' => [
                                'vendor' => $vendor,
                                'orders' => $orders,
                                'month_start' => Carbon::parse($request->for_month)->startOfMonth()->format('Y-m-d'),
                                'month_end' => Carbon::parse($request->for_month)->endOfMonth()->format('Y-m-d')
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
        $data['invoice_statuses'] = InvoiceStatus::get();
        return view('user.accounts.vendor-payments', $data);
    }
    public function add_payment(Request $request)
    {
        try {
            DB::beginTransaction();
            // Invoice main data update
            $vendor_invoice = VendorInvoice::findOrFail($request->invoice_id);
            $vendor_invoice->invoice_status_id = 3; // 3 - Paid
            $vendor_invoice->save();
            // New payment
            $VendorInvoicePayment = new VendorInvoicePayment;
            $VendorInvoicePayment->vendor_invoice_id = $vendor_invoice->id;
            $VendorInvoicePayment->paid_amount = $vendor_invoice->total_payable;
            $VendorInvoicePayment->save();
            $VendorInvoicePayment->payment_reference = 'PAY-' . sprintf('%07d', $VendorInvoicePayment->id);
            $VendorInvoicePayment->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Payment Added !',
                    'content' => 'Payment added successfully.'
                ],
                'data' => []
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
                ]
            ];
            return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        }
    }
}
