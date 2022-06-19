<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class CustomerOrdersDashboardDataComposer
{

    public function compose(View $view)
    {
        // dd('asd');
        $order_stats = DB::table('order_items as oi')->select('v.title', 'oi.v_id' ,'oi.v_price as vendor_price', DB::raw('count(pets_oi.order_item_id) AS total_products') , DB::raw('SUM(pets_oi.p_qty) AS total_qty'),DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price'),DB::raw('(SUM(pets_oi.p_qty) * pets_oi.price) AS total_price'))
        ->join('vendors as v' , 'v.vendor_id' , 'oi.v_id')
        ->join('payment_transactions as pt', 'pt.order_id' , 'oi.order_id')
        ->where('oi.send_to_vendor', '=' , 0)
        ->where('pt.payment_status', '=' , 'completed')
        ->groupBy('oi.v_id','oi.product_id')
        ->get()->toArray();
        $order_data = [];

        // dd($order_stats);
        foreach ($order_stats as $key => $stat) {
            $order_data[$stat->v_id]['title'] = $stat->title;
            $order_data[$stat->v_id]['vendor_price'] = $stat->vendor_price;
            $order_data[$stat->v_id]['total_qty'] = !empty($order_data[$stat->v_id]['total_qty']) ? $order_data[$stat->v_id]['total_qty'] +  $stat->total_qty : $stat->total_qty;
            $order_data[$stat->v_id]['total_vendor_price'] = !empty($order_data[$stat->v_id]['total_vendor_price']) ? $order_data[$stat->v_id]['total_vendor_price'] + $stat->total_vendor_price : $stat->total_vendor_price;
            $order_data[$stat->v_id]['total_price'] = !empty($order_data[$stat->v_id]['total_price']) ? $order_data[$stat->v_id]['total_price'] + $stat->total_price : $stat->total_price;
        }

        $view->with('order_stats', json_decode(json_encode($order_data)));
    }
}
