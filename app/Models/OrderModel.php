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
            ->join('payment_transactions as pt' , 'pt.order_id' , 'o.order_id')
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
        return DB::table('orders as o')->join('payment_transactions as pt' , 'pt.order_id' , 'o.order_id')
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

    public function getSingleOrderDetails($order_id, $front_access_id= '')
    {
        // dd($order_id);

        $data = array();
        $user_data = json_decode(session()->get('user_data'));

        $results = DB::table('orders as o')
            ->select('o.order_id', 'o.total_items as total_products', 'o.total_qty as total_quantities', 'o.total_price as final_price', 'o.order_status as order_status', 'o.order_message as s_message', 'o.created_at as creation_date', 'oi.product_id', 'p.title as product_title', 'p.title_breadcrumb as product_bread', 'p.p_sku as sku', 'oi.p_qty as order_product_qty', 'oi.price as order_product_price', 'cus.shipping_first_name as customer_first_name', 'cus.shipping_last_name as customer_last_name', 'cus.shipping_email as customer_email', 'cus.shipping_city as customer_city', 'cus.address as customer_address', 'cus.contact_number as customer_contact_number', 'p.p_upc as upc', 'ven.title as vendor_name')
            ->join('order_items as oi', 'oi.order_id', 'o.order_id')
            ->join('products as p', 'p.product_id', 'oi.product_id')
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
        // dd($order_id);

        $data = array();
        // $user_data = json_decode(session()->get('user_data'));

        $results = DB::table('order_items as oi')
            ->select('oi.patch_order_id as order_id' ,'p.title as product_title','p.product_id as product_id', 'oi.v_price', 'p.title_breadcrumb as product_bread', 'p.p_sku as sku', DB::raw('SUM(pets_oi.p_qty) AS total_qty'), DB::raw('SUM(pets_oi.p_qty) AS order_product_qty'),'p.p_upc as upc', 'oi.v_price as order_product_price', 'ven.title as vendor_name',  DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price'),  DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price') , 'p.title as product_title')
            ->join('products as p', 'p.product_id', 'oi.product_id')
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
}
