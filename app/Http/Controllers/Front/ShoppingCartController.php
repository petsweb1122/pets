<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\ViewComposingController;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use Cart;
use App\Helpers\PaypalHelper;

class ShoppingCartController extends ViewComposingController
{

    public function getViewCartPage()
    {

        $this->viewData['seo_title'] = "Shopping Cart | SHEIN WEARS";
        $this->viewData['seo_description'] = "Shopping Cart Page at SHEIN WEARS.";
        return $this->buildTemplate('view_cart');
    }


    public function getCheckoutPage()
    {

        $this->viewData['seo_title'] = "Shopping Cart Checkout | SHEIN WEARS";
        $this->viewData['seo_description'] = "Shopping Cart Checkout Page at SHEIN WEARS.";
        return $this->buildTemplate('checkout');
    }

    public function getCart()
    {
        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('cart');
    }


    public function getCheckout()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('checkout');
    }


    public function getPaypalExecution(Request $request, PaypalHelper $objPaypal)
    {


        return $objPaypal->executionPaypalPayment($request);
    }

    public function getPaypalCencelInformation(Request $request, PaypalHelper $objPaypal)
    {

        return $objPaypal->cancelPaypalPayment($request);
    }


    public function postCheckoutDetails(Request $request, UserModel $objUser)
    {

        $params = array();
        $messages = [];
        $data = [];

        $errors = array();

        $params['name'] = $request->get('shipping_first_name');
        $params['last_name'] = $request->get('shipping_last_name');
        $params['country'] = $request->get('shipping_country');
        $params['city'] = $request->get('shipping_city');
        $params['postcode'] = $request->get('shipping_postcode');
        $params['contact_number'] = $request->get('shipping_phone');
        $params['address'] = $request->get('shipping_address_1');
        $params['notes'] = $request->get('order_comments');
        $params['company'] = $request->get('shipping_company');
        $params['state'] = $request->get('shipping_state');
        $params['email'] = $request->get('shipping_email');

        $rules = [
            'name' => 'required|string',
            'last_name' => 'string|nullable',
            'country' => 'required',
            'email' => 'required|email',
            'postcode' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required'
        ];


        // dd($params);
        $validation = Validator::make($params, $rules, $messages);

        $errors = $validation->messages()->all();

        $check_postcode = DB::table('shipping_taxes as st')->where('st.zip_code', $params['postcode'])->first();

        if (empty($check_postcode)) {
            $errors['zip_code'] = 'Please Enter Correct Zip Code';
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $params['tax_rate'] = !empty($check_postcode->rate) ? $check_postcode->rate : 0;



        if (strpos($params['state'], $check_postcode->state_name) === false && strpos($params['state'], $check_postcode->regin_name) === false) {
            $errors['state'] = 'Your State and Postal code mismatch';
        }






        $find_shipping_short = substr($params['postcode'], 0, 3);
        $find_shipping_full = $params['postcode'];

        $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_full)->where('r.match', 'full')->first();

        if (empty($ship_value_full)) {
            $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_short)->where('r.match', 'short')->first();
        }

        if (empty($ship_value)) {
            $errors['zip_code'] = 'Please Enter Correct Zip Code for shipping cost';
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $carts = Cart::getContent();
        $weight_lbs = 0;

        foreach ($carts as $key => $cart) {
            $weight_lbs = $weight_lbs + ($cart['attributes']['weight'] * $cart['quantity']);
        }

        $weight_value = (int) ceil($weight_lbs);

        $shipping_value = 0;
        // dd($ship_value);
        if ($weight_value <= 150) {
            $shipping_value = $ship_value->{'lb' . "$weight_value"};
        } else {
            $diff_lbs = $weight_value - 150;
            $shipping_value  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
        }

        $params['shipping_rate'] = $shipping_value;


        // dd('asd');
        if (empty($errors)) {
            $response =  $objUser->addFrontUserAndCustomerAndOrders($params);
            // dd($response );

            if ($response['status'] == 200) {
                return redirect($response['approve_link']);
            } else {
                $data['message'] =  'Something went wrong!';
            }
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }
        return redirect()->back()->with($data);
    }

    public function getTax(Request $request)
    {
        $carts = Cart::getContent();



        $data = array();
        $tax = DB::table('shipping_taxes as t')->where('t.zip_code', $request->get('zip_code'))->first();

        if (empty($tax)) {
            $data['status']  = 404;
            $data['error']  = 'Zip Code is not Correct';
            return json_encode($data);
        }

        if (strpos($request->get('shipping_state'), $tax->state_name) === false && strpos($request->get('shipping_state'), $tax->regin_name) === false) {
            $data['status']  = 404;
            $data['error']  = 'Zip Code and State Doesnot Match';
            return json_encode($data);
        }

        $find_shipping_short = substr($request->get('zip_code'), 0, 3);
        $find_shipping_full = $request->get('zip_code');

        $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_full)->where('r.match', 'full')->first();
        // dd($ship_value_full);

        if (empty($ship_value)) {
            $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_short)->where('r.match', 'short')->first();
        }

        if (empty($ship_value)) {
            $data['status']  = 404;
            $data['error']  = 'Zip Code not correct';
            $data['ship_error']  = 'Need Correct Zip Code';
            return json_encode($data);
        }



        $shipping_sort = [];
        $itr = 0;
        foreach ($carts as $key => $cart) {
            $explode = explode('_', $cart->id);
            $p_id = $explode[0];
            $variation_id = $explode[1];
            $product = DB::table('products as p')->where('p.product_id' , $p_id)->first();
            $variation = DB::table('product_variations as pv')->select('pv.*' , 's.value as size_value')->join('sizes as s' , 's.size_id', 'pv.size_id')->where('pv.variation_id' , $variation_id)->first();
            $shipping_sort[$product->vendor_id][$itr]['product'] = $product;
            $shipping_sort[$product->vendor_id][$itr]['variation'] = $variation;
            $itr++;
        }
        ////////////////
        dd($shipping_sort);


        $weight_lbs = 0;

        foreach ($carts as $key => $cart) {
            $weight_lbs = $weight_lbs + ($cart['attributes']['weight'] * $cart['quantity']);
        }

        $weight_value = (int) ceil($weight_lbs);
        // $weight_value = 151;

        $shipping_value = 0;
        if ($weight_value <= 150) {
            $shipping_value = $ship_value->{'lb' . "$weight_value"};
        } else {
            $diff_lbs = $weight_value - 150;
            $shipping_value  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
        }

        $rate =  $tax->rate;
        $get_total_price = (Cart::getTotal() - (Cart::getTotal() * env('PETS_DISC')));
        $data['tax']  = number_format($rate * $get_total_price, 2);
        $data['shipping']  = number_format($shipping_value, 2);
        $data['status']  = 200;

        $data['cart_total_tax']  = number_format($data['tax'] + $get_total_price + $data['shipping'], 2);
        $data['cart_total']  = number_format(Cart::getTotal(), 2);


        return json_encode($data);
    }

    public function getOrderComplete(Request $request, OrderModel $objOrder){

        $user_data = json_decode(session()->get('user_data'));

        if(!empty($request->order_id)){
            $order_detail = $objOrder->getSingleOrderDetails($request->order_id, $user_data->user_id);
        }

        if(empty($order_detail['order'])){
            abort(401);
        }

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        $this->viewData['order'] = !empty($order_detail) ? $order_detail : [];
        return $this->buildTemplate('order-complete');

    }


}
