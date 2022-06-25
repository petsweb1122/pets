<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderModel extends Model
{
    protected $table = 'orders';

    public function getAllOrdersFullColums($params = [])
    {

        $results = DB::table('orders as o');
        $user_data = json_decode(session()->get('user_data'));
        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;
        $orders = $results
            ->select('o.order_id', 'o.user_id', 'o.total_items', 'o.total_qty', 'o.total_price', 'o.order_status', 'o.created_at', 'u.name', 'u.last_name', 'sd.contact_number')
            ->join('users as u', 'o.user_id', 'u.user_id')
            ->join('customer_shipping_details as sd', 'sd.user_id', 'u.user_id')
            ->join('payment_transactions as pt', 'pt.order_id', 'o.order_id')
            ->when(($user_data->role != 'super-admin'), function ($q) use ($user_data) {
                return $q->where('o.user_id', $user_data->user_id);
            })
            ->where('pt.payment_status', 'completed')
            ->skip($skip_val)
            ->take($take)
            ->groupBy('o.order_id')
            ->get()
            ->toArray();
        // dd($orders);
        return $orders;
    }

    public function getAllVenodrOrdersFullColums($params = [])
    {

        $results = DB::table('vendor_orders as vo');
        // $user_data = json_decode(session()->get('user_data'));
        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;
        $orders = $results
            ->select('*')
            ->where('vo.vendor_id', request()->vendor_id)
            ->skip($skip_val)
            ->take($take)
            // ->toSql();
            ->get()
            ->toArray();
        return $orders;
    }

    public function getAllOrdersCount()
    {
        $user_data = json_decode(session()->get('user_data'));
        return DB::table('orders as o')->join('payment_transactions as pt', 'pt.order_id', 'o.order_id')
            ->when(($user_data->role != 'super-admin'), function ($q) use ($user_data) {
                return $q->where('o.user_id', $user_data->user_id);
            })
            ->where('pt.payment_status', 'completed')->count();
    }
    public function getAllVendorOrdersCount()
    {

        $results = DB::table('vendor_orders as vo')->where('vo.vendor_id', request()->vendor_id)->count();
        return $results;
    }

    public function getAllOrdersForDropDown()
    {
        $orders = [];
        $results = DB::table($this->table)->get();

        foreach ($results as $size) {
            $sizes[$size->size_id] = $size->name;
        }

        return $sizes;
    }

    public function getAllOrders()
    {
        $orders = [];
        $results = DB::table($this->table)->get();

        return $results;
    }

    public function getSingleOrderDetails($order_id, $front_access_id = '')
    {
        // dd($order_id);

        $data = array();
        $user_data = json_decode(session()->get('user_data'));

        $results = DB::table('orders as o')
            ->select('o.order_id', 'o.total_items as total_products', 'o.total_qty as total_quantities', 'o.total_price as final_price', 'o.order_status as order_status', 'o.order_message as s_message', 'o.created_at as creation_date', 'oi.product_id', 'p.title as product_title', 'p.title_breadcrumb as product_bread', 'pv.variation_sku as sku', 'oi.p_qty as order_product_qty', 'oi.price as order_product_price', 'cus.shipping_first_name as customer_first_name', 'cus.shipping_last_name as customer_last_name', 'cus.shipping_email as customer_email', 'cus.shipping_city as customer_city', 'cus.address as customer_address', 'cus.contact_number as customer_contact_number', 'pv.variation_upc as upc', 'ven.title as vendor_name')
            ->join('order_items as oi', 'oi.order_id', 'o.order_id')
            ->join('products as p', 'p.product_id', 'oi.product_id')
            ->join('product_variations as pv', 'pv.variation_id', 'oi.variation_id')
            ->join('vendors as ven', 'ven.vendor_id', 'p.vendor_id')
            ->join('customer_shipping_details as cus', 'cus.order_id', 'o.order_id')
            ->when(($user_data->role == 'customer'), function ($q) use ($user_data) {
                return $q->where('o.user_id', $user_data->user_id);
            })
            ->when(!empty($front_access_id), function ($q) use ($front_access_id) {
                return $q->where('o.user_id', $front_access_id);
            })
            ->where('o.order_id', $order_id)
            ->get()->toArray();
        $order = DB::table('orders as o')->where('o.order_id', $order_id)
            ->when(($user_data->role == 'customer'), function ($q) use ($user_data) {
                return $q->where('o.user_id', $user_data->user_id);
            })
            ->when(!empty($front_access_id), function ($q) use ($front_access_id) {
                return $q->where('o.user_id', $front_access_id);
            })
            ->first();

        $data['products'] = $results;
        $data['order'] = $order;

        return $data;
    }

    public function getVendorSingleOrderDetails($vendor_id, $order_id)
    {

        $data = array();
        // $user_data = json_decode(session()->get('user_data'));

        $results = DB::table('order_items as oi')
            ->select('oi.patch_order_id as order_id', 'p.title as product_title', 'p.product_id as product_id', 'oi.v_price', 'p.title_breadcrumb as product_bread', 'pv.variation_sku as sku', DB::raw('SUM(pets_oi.p_qty) AS total_qty'), DB::raw('SUM(pets_oi.p_qty) AS order_product_qty'), 'pv.variation_upc as upc', 'oi.v_price as order_product_price', 'ven.title as vendor_name',  DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price'),  DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price'), 'p.title as product_title')
            ->join('products as p', 'p.product_id', 'oi.product_id')
            ->join('product_variations as pv', 'pv.variation_id', 'oi.variation_id')
            ->join('vendors as ven', 'ven.vendor_id', 'p.vendor_id')
            // ->join('customer_shipping_details as cus', 'cus.order_id', 'o.order_id')
            // ->when(($user_data->role == 'customer'), function ($q) use ($user_data) {
            //     return $q->where('o.user_id', $user_data->user_id);
            // })
            ->where('oi.patch_order_id', $order_id)
            ->where('oi.v_id', $vendor_id)
            // ->groupBy('oi.order_item_id')
            ->groupBy('oi.product_id')
            ->get()->toArray();

        $order = DB::table('vendor_orders as vo')->where('vo.ref_patch_order_id', $order_id)->where('vo.vendor_id', $vendor_id)->first();
        // dd($order);
        // $order = DB::table('orders as o')->where('o.order_id', $order_id)->first();
        $data['products'] = $results;
        $data['order'] = $order;

        return $data;
    }

    public function createAnOrderForEndlessApi($data)
    {

        // $endpoint = "https://app-qa.endlessaisles.io/api/orders";
        // // dd($endpoint);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $endpoint);
        // curl_setopt($ch, CURLOPT_POST, 0);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $headers = [
        //     'X-EA-REQUEST-TOKEN: 95687a6609f66954f5a48556ea868317'
        //     // 'X-EA-REQUEST-TOKEN: 75509131ad521fde9f074c911039c31d'
        // ];

        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $response = curl_exec($ch);
        // // $err = curl_error($ch);
        // curl_close($ch);
        // dd($response);
        // $response = json_decode($response);




        $data = array();
        $results_orders = DB::table('order_items as oi')->where('oi.v_id', 7)->where('oi.send_to_vendor', 0)->get()->toArray();


        $orders_results = [];
        $itr = 0;
        foreach ($results_orders as $key => $order) {
            $variation_obj = DB::table('product_variations as pv')->select('pv.*', 's.value as size_value')->join('sizes as s', 's.size_id', 'pv.size_id')->where('pv.product_id', $order->product_id)->where('pv.variation_id', $order->variation_id)->first();
            $orders_results[$order->order_id]['items'][$itr]['upc'] = $variation_obj->variation_upc;
            $orders_results[$order->order_id]['items'][$itr]['size_value'] = $variation_obj->size_value;
            $orders_results[$order->order_id]['items'][$itr]['order_item_id'] = $order->order_item_id;
            $orders_results[$order->order_id]['items'][$itr]['order_id'] = $order->order_id;
            $orders_results[$order->order_id]['items'][$itr]['product_id'] = $order->product_id;
            $orders_results[$order->order_id]['items'][$itr]['price'] = $order->price;
            $orders_results[$order->order_id]['items'][$itr]['p_qty'] = $order->p_qty;
            $orders_results[$order->order_id]['items'][$itr]['v_price'] = $order->v_price;
            $orders_results[$order->order_id]['items'][$itr]['variation_id'] = $order->variation_id;
            $orders_results[$order->order_id]['items'][$itr]['order_id'] = $order->order_id;
            $itr++;
        }


        $params = [];


        //line items , upc , price , quantity
        // main shipping price , tax , discount , custom order id

        $package_value_endless = DB::table('packaging_rates_endless as p')->first();

        foreach ($orders_results as $order_id => $order_items) {

            $shippings = DB::table('customer_shipping_details as cus')->select('cus.*', 't.state_short')->join('shipping_taxes as t', 'cus.zipcode', 't.zip_code')->where('cus.order_id', $order_id)->first();

            $params['shipping']['first_name'] = $shippings->shipping_first_name;
            $params['shipping']['last_name'] = $shippings->shipping_last_name;
            $params['shipping']['phone'] = $shippings->contact_number;
            $params['shipping']['address_line_1'] = $shippings->address . 'sdkjhajksdhkjahsdkjhajkshdkjahskdhak';
            // $params['shipping']['address_line_2'] = $shippings->address. 'sdkjhajksdhkjahsdkjhajkshdkjahskdhak';
            $params['shipping']['city'] = $shippings->shipping_city;
            $params['shipping']['state'] = $shippings->state_short;
            // $params['shipping']['zip'] = '00'.$shippings->zipcode;

            // for Temp
            $params['shipping']['zip'] = 60002;
            $shippings->zipcode =  60002;


            $params['customer']['email'] = $shippings->shipping_email;

            $total_weight = 0;
            $total_price = 0;

            foreach ($order_items['items'] as $key => $item) {
                $params['line_items'][$key]['id'] = rand(2,4000);
                // $params['line_items'][$key]['upc'] = $item['upc'];
                $params['line_items'][$key]['price'] = $item['price'];
                $params['line_items'][$key]['quantity'] = $item['p_qty'];
                $total_weight = $total_weight + ($item['size_value'] *  $item['p_qty']);
                $total_price = $total_price +  ($item['price'] *  $item['p_qty']);
            }

            $shipping_value = 0;

            $ship_value_endless = DB::table('shipping_rates_endless as e')->where('e.zip_codes',$shippings->zipcode)->first();
            $tax = DB::table('shipping_taxes as t')->where('t.zip_code',  $shippings->zipcode)->first();

            // dd($ship_value_endless);
            // $pick_pack_value = count($order_items['items']) > 1 ? $ship_value_endless->{'1_plus_lines'} : $ship_value_endless->{'1_line'};
            $pick_pack_value = 3.32;

            // dd($params, $total_weight, $pick_pack_value, $package_value_endless, $ship_value_endless);

            // $weight_cal = false;
            // $rem_total_weight = $total_weight;
            // $itr_weight = (int) ceil($total_weight / 69.99);
            // if ($itr_weight != 1) {
            //     for ($j = 1; $j < $itr_weight; $j++) {
            //         $rem_total_weight = $rem_total_weight - 69.99;
            //         $weight_cal = true;
            //     }
            // }

            // for ($i = 1; $i <= $itr_weight; $i++) {
            //     if ($weight_cal && $i == 1) {
            //         $total_weight =  $rem_total_weight;
            //     } elseif ($weight_cal) {
            //         $total_weight =  69.99;
            //     }
            //     if ($total_weight > 0 && $total_weight < 15) {
            //         $shipping_value = $shipping_value + $package_value_endless->lb15 + $ship_value_endless->lb15 + $pick_pack_value;
            //     } elseif ($total_weight > 14.99 && $total_weight < 30) {
            //         $shipping_value = $shipping_value + $package_value_endless->lb30 + $ship_value_endless->lb30 + $pick_pack_value;
            //     } elseif ($total_weight > 29.99 && $total_weight < 50) {
            //         $shipping_value = $shipping_value + $package_value_endless->lb50 + $ship_value_endless->lb50 + $pick_pack_value;
            //     } elseif ($total_weight > 49.99 && $total_weight < 70) {
            //         $shipping_value = $shipping_value + $package_value_endless->lb70 + $ship_value_endless->lb70 + $pick_pack_value;
            //     }
            // }



            $custom_order_number = substr(time(), 0, 4) . rand(3, 98989);

            $rate =  $tax->rate;
            // $tax_rate  = (float) number_format($rate * $total_price, 2);
            // $params['shipping_cost'] = $shipping_value;
            $params['shipping_cost'] = 79.32;
            // $params['tax_rate'] = $tax_rate;
            $params['tax_rate'] = 79.21;
            $params['custom_order_id'] = $custom_order_number;

                // dd(json_encode($params));

            $endpoint = "https://app-qa.endlessaisles.io/api/orders";
            // dd($endpoint);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            $headers = [
                'X-EA-REQUEST-TOKEN: 95687a6609f66954f5a48556ea868317'
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            dd($response);
            $response = json_decode($response);

            dd($params);
        }

        dd($orders_results);
    }
}
