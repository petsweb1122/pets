<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ViewComposingController;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Validator;
use DB;
use Mail;
use App\Mail\CustomerOrderIUpdateMail;
use App\Mail\CreateVendorsOrderMail;

use function GuzzleHttp\json_decode;

class OrdersController extends ViewComposingController
{

    public function getAllOrders()
    {

        return $this->buildTemplate('orders');
    }

    public function getAllVendorOrders()
    {

        return $this->buildTemplate('vendor_orders');
    }

    public function getViewOrder($id, OrderModel $objOrder)
    {
        $user_data = json_decode(session()->get('user_data'));
        // dd($user_data->role);
        $find_order = OrderModel::where('order_id', $id)
        ->when(!empty($user_data->role != 'super-admin' ), function($q) use($user_data){
            return $q->where('user_id', $user_data->user_id);
        })->count();

        if (empty($find_order)) {
            abort(401);
        }
        $get_order_detail = $objOrder->getSingleOrderDetails($id);
        if (empty($get_order_detail)) {
            abort(401);
        }
        $this->viewData['order_details']  = $get_order_detail['products'];
        $this->viewData['order_obj']  = $get_order_detail['order'];

        return $this->buildTemplate('order_detail');
    }

    public function getViewVendorOrder($vendor_id, $order_id, OrderModel $objOrder)
    {

        $find_vendor_order = DB::table('vendor_orders as vo')->where('vo.vendor_order_id', $order_id)->where('vo.vendor_id', $vendor_id)->first();

        if(empty($find_vendor_order)){
            abort(401);
        }
        $find_order = DB::table('order_items as oi')->where('oi.patch_order_id', $find_vendor_order->ref_patch_order_id)->where('oi.v_id', $vendor_id)->count();
        // dd($find_order );
        if (empty($find_order)) {
            abort(401);
        }

        $get_order_detail = $objOrder->getVendorSingleOrderDetails($vendor_id, $find_vendor_order->ref_patch_order_id);

        if (empty($get_order_detail)) {
            abort(401);
        }
        $this->viewData['order_details']  = $get_order_detail['products'];
        $this->viewData['order_obj']  = $get_order_detail['order'];

        return $this->buildTemplate('vendor_order_detail');
    }

    public function updateOrder(Request $request)
    {

        $params = array();

        $params['order_id'] = $request->get('order_id');
        $params['update_order'] = $request->get('update_order');
        $params['shipping_company'] = $request->get('shipping_company');
        $params['tracking_number'] = $request->get('tracking_number');
        $params['message'] = $request->get('message');

        $user_data = json_decode(session()->get('user_data'));
        // dd();
        $shipping_details  = DB::table('customer_shipping_details')->where('order_id', $params['order_id'])->first();



        $rules = [
            'order_id' => 'required',
            'update_order' => 'required',
            'message' => 'nullable',
            'shipping_company' => 'nullable',
            'tracking_number' => 'nullable',
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $errors = $validation->messages()->all();

        $data = [];
        $update = [];
        if (empty($errors)) {

            $update['order_status'] = $params['update_order'];
            $update['order_message'] = $params['message'];
            $update['shipping_method'] = $params['shipping_company'];
            $update['tracking_number'] = $params['tracking_number'];

            $result = DB::table('orders')->where('order_id', $params['order_id'])->update($update);


            $update['order_status'] = str_replace('-', ' ', $params['update_order']);
            $update['order_status']  = ucwords($update['order_status'] );
            $update['order_id']  = $params['order_id'];

            $details = [
                // 'name' => $add_user_data['name'] . ' ' . $add_user_data['last_name'],
                'order' => $update,
            ];

            Mail::to($shipping_details->shipping_email)->cc($user_data->email)->send(new CustomerOrderIUpdateMail($details));


            $data['message'] = !empty($result) ? 'Successfully Updated' : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function updateVendorOrder(Request $request)
    {

        // dd($request->all());
        $params = array();

        $params['order_id'] = $request->get('order_id');
        $params['update_order'] = $request->get('update_order');
        $params['shipping_company'] = $request->get('shipping_company');
        $params['tracking_number'] = $request->get('tracking_number');
        $params['message'] = $request->get('message');


        $rules = [
            'order_id' => 'required',
            'update_order' => 'required',
            'message' => 'nullable',
            'shipping_company' => 'nullable',
            'tracking_number' => 'nullable',
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $errors = $validation->messages()->all();

        $data = [];
        $update = [];
        if (empty($errors)) {

            $update['order_status'] = $params['update_order'];
            $update['order_message'] = $params['message'];
            $update['shipping_method'] = $params['shipping_company'];
            $update['tracking_number'] = $params['tracking_number'];

            $result = DB::table('vendor_orders')->where('vendor_order_id', $params['order_id'])->update($update);
            $data['message'] = !empty($result) ? 'Successfully Updated' : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function getCustomerOrderDashboard()
    {
        return $this->buildTemplate('customer_order_home');
    }


    public function getVendorsOrderDashboard()
    {
        return $this->buildTemplate('vendor_order_home');
    }

    public function sendToVendors(Request $request, OrderModel $objOrder)
    {
        // dd($request->get('vendor_name'));
        $get_vendor = DB::table('vendors as v')->where('v.title', $request->get('vendor_name'))->first();

        if (empty($get_vendor)) {

            return redirect()->back()->with(['error' => 'Vendor not found']);
        }

        $result = DB::table('order_items as oi')->select(DB::raw('max(pets_oi.patch_order_id) as v_order_id'))->where('oi.v_id', $get_vendor->vendor_id)->first();


        $result_items = DB::table('order_items as oi')->select('v.title', 'oi.v_id',  'oi.v_price as vendor_price', 'oi.price', DB::raw('count(pets_oi.order_item_id) AS total_products'), DB::raw('max(pets_oi.patch_order_id) AS total_v_orders'), DB::raw('SUM(pets_oi.p_qty) AS total_qty'), DB::raw('(SUM(pets_oi.p_qty) * pets_oi.v_price) AS total_vendor_price'), DB::raw('(SUM(pets_oi.p_qty) * pets_oi.price) AS total_price'))
            ->join('vendors as v', 'v.vendor_id', 'oi.v_id')
            ->where('oi.v_id', $get_vendor->vendor_id)
            ->where('oi.send_to_vendor', '=', 0)
            ->groupBy('oi.v_id', 'oi.product_id')
            ->get()->toArray();

        $data_update = array(
            'send_to_vendor' => 1,
            'patch_order_id' => $result->v_order_id + 1
        );

        $insert_vendor_orders = [];


        foreach ($result_items as $key => $item) {
            $insert_vendor_orders[$item->v_id]['vendor_id'] = $item->v_id;
            $insert_vendor_orders[$item->v_id]['ref_patch_order_id'] = $data_update['patch_order_id'];

            $insert_vendor_orders[$item->v_id]['total_qty'] = !empty($insert_vendor_orders[$item->v_id]['total_qty']) ? $insert_vendor_orders[$item->v_id]['total_qty']  + (int) $item->total_qty : (int)  $item->total_qty;

            $insert_vendor_orders[$item->v_id]['total_items'] = count($result_items);

            $insert_vendor_orders[$item->v_id]['total_price'] = !empty($insert_vendor_orders[$item->v_id]['total_price']) ? $insert_vendor_orders[$item->v_id]['total_price'] + $item->total_vendor_price : $item->total_vendor_price;

            $insert_vendor_orders[$item->v_id]['shipping_price'] = ($insert_vendor_orders[$item->v_id]['total_price'] >=1000) ? 0 : 125;
            $insert_vendor_orders[$item->v_id]['tax'] = 0;

            $insert_vendor_orders[$item->v_id]['final_amount'] = $insert_vendor_orders[$item->v_id]['tax'] + $insert_vendor_orders[$item->v_id]['shipping_price'] + $insert_vendor_orders[$item->v_id]['total_price'];
        }


        DB::beginTransaction();
        try {


            $update =  DB::table('order_items')->where('v_id', $get_vendor->vendor_id)->where('send_to_vendor', '=', 0)->update($data_update);

            $message = '';
            $vendor_name = $request->get('vendor_name');
            if (!empty($update)) {
                DB::table('vendor_orders')->insert($insert_vendor_orders);
                $message = "Successfully sent to $vendor_name";
                $get_order_detail = $objOrder->getVendorSingleOrderDetails($get_vendor->vendor_id, $data_update['patch_order_id']);

                $vendor_email = ($get_vendor->vendor_id == 4) ? 'mister_saqib@rocketmail.com' : 'evslearnings@gmail.com';
                // dd($vendor_email);
                Mail::to($vendor_email)->cc('mrdevsaqib@gmail.com')->send(new CreateVendorsOrderMail($get_order_detail));


            } else {
                $message = "Already sent to $vendor_name";
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Something! Went wrong please contact administration';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Something! Went wrong please contact administration';
        }






        return redirect()->back()->with(['success' => "$message"]);
    }
}
