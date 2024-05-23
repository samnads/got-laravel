<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InvoiceStatus;
use App\Models\Order;
use App\Models\OrderCustomerAddress;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Vendor;
use App\Models\VendorInvoice;
use App\Models\VendorInvoiceLineItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Http\Request;
use DB;

class VendorInvoiceController extends Controller
{
    public function invoices(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorInvoice::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'vendor_invoices.id',
                            'vendor_invoices.vendor_id',
                            'vendor_invoices.invoice_reference',
                            DB::raw('DATE_FORMAT(vendor_invoices.for_month, "%M %Y") as for_month'),
                            DB::raw('DATE_FORMAT(vendor_invoices.due_date, "%d/%m/%Y") as due_date'),
                            'vendor_invoices.total_payable',
                            'vendor_invoices.invoice_status_id',
                            DB::raw('DATE_FORMAT(vendor_invoices.invoice_date, "%d/%m/%Y") as invoice_date'),
                            'vendor_invoices.created_at',
                            'v.vendor_name',
                            'is.label as is_label',
                            'is.description as is_description',
                            'is.code as is_code',
                            'is.css_class as is_css_class'
                        )
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('vendor_invoices.vendor_id', '=', 'v.id');
                            })
                            ->leftJoin('invoice_statuses as is', function ($join) {
                                $join->on('vendor_invoices.invoice_status_id', '=', 'is.id');
                            });
                        if (@$request->filter_invoice_status_id) {
                            $rows->where('vendor_invoices.invoice_status_id', $request->filter_invoice_status_id);
                        }
                        if (@$request->filter_vendor_id) {
                            $rows->where('v.id', $request->filter_vendor_id);
                        }
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['vendor_invoices.invoice_reference', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['v.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_invoices.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
                            $data_table['data'][$key]['invoice_status'] = '<div class="d-flex justify-content-between"><div class="flex-fill"><span class="badge shadow-sm w-100 ' . $row['is_css_class'] . '">' . $row['is_label'] . '</span></div><div class=""></div></div>';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
                            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Details" data-action="order-details" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-primary text-light"><i class="bx bx-info-circle"></i></button>
											<button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print" data-action="print-invoice" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-info text-light"><i class="fadeIn animated bx bx-printer"></i></button>
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
        return view('user.accounts.vendor-invoices', $data);
    }
    public function create_invoice(Request $request)
    {
        try {
            DB::beginTransaction();
            // Invoice main data
            $vendor_invoice = new VendorInvoice;
            $vendor_invoice->vendor_id = $request->vendor_id;
            $vendor_invoice->for_month = $request->for_month;
            $vendor_invoice->due_date = $request->due_date;
            $vendor_invoice->total_payable = 0;
            $vendor_invoice->invoice_status_id = 2; // 1 - Draft
            $vendor_invoice->invoice_date = now();
            $vendor_invoice->save();
            // Line items add
            $orders = Order::whereIn('id', $request->order_ids)->where('vendor_id', $request->vendor_id)->get();
            foreach ($orders as $key => $order) {
                $VendorInvoiceLineItem = new VendorInvoiceLineItem;
                $VendorInvoiceLineItem->vendor_invoice_id = $vendor_invoice->id;
                $VendorInvoiceLineItem->order_id = $order->id;
                $VendorInvoiceLineItem->amount = $order->got_commission;
                $VendorInvoiceLineItem->save();
                $vendor_invoice->total_payable += $order->got_commission;
            }
            $vendor_invoice->invoice_reference = 'INV-' . sprintf('%07d', $vendor_invoice->id);
            $vendor_invoice->save();
            DB::commit();
            $response = [
                'status' => true,
                'message' => [
                    'type' => 'success',
                    'title' => 'Invoice Created !',
                    'content' => 'Invoice created successfully.'
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
    public function invoice_pdf_view(Request $request, $invoice_id)
    {
        $data['vendor_invoice'] = VendorInvoice::
            select(
                'vendor_invoices.*',
                DB::raw('DATE_FORMAT(vendor_invoices.invoice_date, "%d/%m/%Y") as invoice_date'),
                DB::raw('DATE_FORMAT(vendor_invoices.due_date, "%d/%m/%Y") as due_date')
            )
            ->findOrFail($invoice_id);
        $data['vendor_invoice_line_items'] = VendorInvoiceLineItem::
            select(
                'vendor_invoice_line_items.id',
                'vendor_invoice_line_items.order_id',
                'vendor_invoice_line_items.amount',
                'o.order_reference',
            )
            ->where('vendor_invoice_id', $invoice_id)
            ->leftJoin('orders as o', 'vendor_invoice_line_items.order_id', '=', 'o.id')
            ->get();
        $data['vendor'] = Vendor::find($data['vendor_invoice']->vendor_id);
        $pdf = DomPDF::loadView('user.pdf.invoice', $data);
        $pdf->set_option('isHtml5ParserEnabled', true);
        return $pdf->stream($data['vendor_invoice']->invoice_reference . '.pdf');
    }
}
