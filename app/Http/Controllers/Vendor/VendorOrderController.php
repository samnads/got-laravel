<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class VendorOrderController extends Controller
{
    /*public function pending_orders_list(Request $request)
    {
        $data['products'] = VendorProduct::select(
            'vendor_products.id',
            'vendor_products.product_id',
            'vendor_products.maximum_retail_price',
            'vendor_products.retail_price',
            'p.name',
            'p.code',
            'p.item_size',
            'u.name as unit',
            'u.code as unit_code',
            'b.name as brand',
            'p.description',
            'p.deleted_at',
            'pc.name as category',
            'vendor_products.deleted_at'
        )
            ->leftJoin('products as p', function ($join) {
                $join->on('vendor_products.product_id', '=', 'p.id');
            })
            ->leftJoin('units as u', function ($join) {
                $join->on('p.unit_id', '=', 'u.id');
            })
            ->leftJoin('brands as b', function ($join) {
                $join->on('p.brand_id', '=', 'b.id');
            })
            ->leftJoin('product_category_mappings as pcm', function ($join) {
                $join->on('p.id', '=', 'pcm.product_id');
            })
            ->leftJoin('product_categories as pc', function ($join) {
                $join->on('pcm.category_id', '=', 'pc.id');
            })
            ->where('vendor_products.vendor_id', Auth::guard('vendor')->id())
            ->withTrashed()
            ->get();
        return view('vendor.order-pending-list', $data);
    }*/
    public function pending_orders_list(Request $request){
        if ($request->ajax()) {
            try {
                switch ($request->action) {
                    case 'datatable':
                        $data_table['draw'] = $request->draw;
                        DB::statement("SET @count:=" . $request->start);
                        $v_products = VendorProduct::select('product_id')->where('vendor_id', Auth::guard('vendor')->id())->withTrashed()->get();
                        $vendor_product_ids = array_column($v_products->toArray(), 'product_id');
                        $rows = Product::select(
                            DB::raw('@count:=@count+1 AS slno'),
                            'products.id',
                            'products.code',
                            'products.item_size',
                            'products.name',
                            'products.description',
                            'products.maximum_retail_price',
                            'u.name as unit',
                            'u.code as unit_code',
                            DB::raw('IFNULL(b.name,"-") as brand'),
                            DB::raw('CONCAT(ROUND(products.item_size,2)," ",u.name) as size_label'),
                            'pc.name as category',
                        )
                            ->leftJoin('units as u', function ($join) {
                                $join->on('products.unit_id', '=', 'u.id');
                            })
                            ->leftJoin('brands as b', function ($join) {
                                $join->on('products.brand_id', '=', 'b.id');
                            })
                            ->leftJoin('product_category_mappings as pcm', function ($join) {
                                $join->on('products.id', '=', 'pcm.product_id');
                            })
                            ->leftJoin('product_categories as pc', function ($join) {
                                $join->on('pcm.category_id', '=', 'pc.id');
                            })
                            ->whereNotIn('products.id', $vendor_product_ids);
                        $data_table['recordsTotal'] = $rows->count();
                        $rows->where(function ($query) use ($request) {
                            $query->where([['products.name', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['products.code', 'LIKE', "%{$request->search['value']}%"]]);
                            $query->orWhere([['pc.name', 'LIKE', "%{$request->search['value']}%"]]);
                        });
                        if (@$request->order[0]['name']) {
                            $rows->orderBy($request->order[0]['name'], $request->order[0]['dir']);
                        } else {
                            $rows->orderBy('products.id', 'asc');
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