<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class VendorOrdersDashboardDataComposer
{

    public function compose(View $view)
    {

        $user_data = json_decode(session()->get('user_data'));

        $order_stats = DB::table('vendor_orders as vo')->select(DB::raw('sum(pets_vo.total_items) AS total_products'), DB::raw('sum(pets_vo.total_qty) AS total_quantities'), DB::raw('sum(pets_vo.final_amount) AS total_vendor_price'), DB::raw('count(pets_vo.vendor_order_id) AS total_v_orders'), 'v.title as title', 'v.vendor_id')->join('vendors as v', 'v.vendor_id', 'vo.vendor_id')
        ->when(!empty($user_data->is_vendor) , function($q) use($user_data){
            return $q->where('vo.vendor_id', $user_data->vendor_id);
        })
        ->groupBy('vo.vendor_id')->get()->toArray();

        $view->with('order_stats', $order_stats);
    }
}
