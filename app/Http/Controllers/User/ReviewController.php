<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReviewLevel;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use DB;

class ReviewController extends Controller
{
    public function list_reviews(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $rows = VendorReview::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'vendor_reviews.id',
                            'vendor_reviews.customer_id',
                            'vendor_reviews.vendor_id',
                            'vendor_reviews.review_level_id',
                            'vendor_reviews.review_title',
                            'vendor_reviews.review',
                            DB::raw('DATE_FORMAT(vendor_reviews.created_at, "%d/%m/%Y") as date'),
                            'v.vendor_name as vendor',
                            'c.name as customer',
                            'rl.name as review_level_name',
                            'rl.level as review_level',
                        )
                            ->leftJoin('customers as c', function ($join) {
                                $join->on('vendor_reviews.customer_id', '=', 'c.id');
                            })
                            ->leftJoin('vendors as v', function ($join) {
                                $join->on('vendor_reviews.vendor_id', '=', 'v.id');
                            })
                            ->leftJoin('review_levels as rl', function ($join) {
                                $join->on('vendor_reviews.review_level_id', '=', 'rl.id');
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
                            $query->where([['vendor_reviews.review', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['vendor_reviews.review_title', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['v.vendor_name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('vendor_reviews.id', 'desc');
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
        $data['review_levels'] = ReviewLevel::get();
        return view('user.reviews.reviews-list', $data);
    }
}
