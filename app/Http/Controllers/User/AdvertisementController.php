<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\VendorAdRequest;
use Illuminate\Http\Request;
use DB;

class AdvertisementController extends Controller
{
    public function ads_list(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = Advertisement::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'advertisements.id',
                            'advertisements.ref_code',
                            'advertisements.vendor_ad_request_id',
                            'advertisements.vendor_id',
                            DB::raw('DATE_FORMAT(advertisements.from, "%d/%m/%Y") as from_date'),
                            DB::raw('DATE_FORMAT(advertisements.to, "%d/%m/%Y") as to_date'),
                            'advertisements.banner_file',
                            'advertisements.banner_url',
                            'v.vendor_name'
                        )
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('advertisements.vendor_id', '=', 'v.id');
                            })
                            ->leftJoin('vendor_ad_requests as var', function ($join) {
                                $join->on('advertisements.vendor_ad_request_id', '=', 'var.id');
                            });
                        if (@$request->filter_status == 1) {
                            // Active
                        }
                        else if (@$request->filter_status == 0) {
                            // Expired
                        }
                        if (@$request->filter_vendor_id) {
                            $rows->where('v.id', $request->filter_vendor_id);
                        }
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['advertisements.ref_code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['v.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('advertisements.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
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
        $data = [];
        return view('user.ads.ads-list', $data);
    }
    public function ads_requests(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorAdRequest::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'vendor_ad_requests.id',
                            'vendor_ad_requests.ref_code',
                            'vendor_ad_requests.vendor_id',
                            DB::raw('DATE_FORMAT(vendor_ad_requests.from, "%d/%m/%Y") as from_date'),
                            DB::raw('DATE_FORMAT(vendor_ad_requests.to, "%d/%m/%Y") as to_date'),
                            'vendor_ad_requests.banner_file',
                            'vendor_ad_requests.banner_url',
                            'v.vendor_name'
                        )
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('vendor_ad_requests.vendor_id', '=', 'v.id');
                            });
                        if (@$request->filter_status == 1) {
                            // Active
                        } else if (@$request->filter_status == 0) {
                            // Expired
                        }
                        if (@$request->filter_vendor_id) {
                            $rows->where('v.id', $request->filter_vendor_id);
                        }
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['vendor_ad_requests.ref_code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['v.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_ad_requests.id', 'desc');
                        }
                        $data_table['recordsFiltered'] = $rows->count();
                        $data_table['data'] = $rows->offset($request->start)->limit($request->length)->get()->toArray();
                        foreach ($data_table['data'] as $key => $row) {
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
        $data = [];
        return view('user.ads.ads-request-list', $data);
    }
}
