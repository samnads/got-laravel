<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvoiceStatus;
use App\Models\VendorInvoice;
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
                            $data_table['data'][$key]['invoice_status'] = '<div class="d-flex justify-content-between"><div class="flex-fill"><span class="badge shadow-sm w-100 ' . $row['is_css_class'] . '">' . $row['is_label'] .'</span></div><div class=""></div></div>';
                            $data_table['data'][$key]['actions_html'] = '<div class="btn-group btn-group-sm" role="group" aria-label="First group">
                            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Details" data-action="order-details" data-id="' . $row['id'] . '" type="button" class="btn btn-sm btn-primary text-light"><i class="bx bx-info-circle"></i></button>
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
        $data['invoice_statuses'] = InvoiceStatus::get();
        return view('user.accounts.vendor-invoices', $data);
    }

}
