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
        $carts = Cart::getContent();
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

        // dd( $params);

        if (strpos($params['state'], $check_postcode->state_name) === false && strpos($params['state'], $check_postcode->regin_name) === false) {
            $errors['state'] = 'Your State and Postal code mismatch';
        }






        $find_shipping_short = substr($params['postcode'], 0, 3);
        $find_shipping_full = $params['postcode'];

        $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_full)->where('r.match', 'full')->first();
        $ship_value_endless = DB::table('shipping_rates_endless as e')->where('e.zip_codes', $find_shipping_full)->first();
        $package_value_endless = DB::table('packaging_rates_endless as p')->first();

        if (empty($ship_value)) {
            $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_short)->where('r.match', 'short')->first();
        }

        if (empty($ship_value) || empty($ship_value_endless)) {
            $errors['zip_code'] = 'Please Enter Correct Zip Code for shipping cost';
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }


        $shipping_sort = [];
        $itr = 0;
        foreach ($carts as $key => $cart) {
            $explode = explode('_', $cart->id);
            $p_id = $explode[0];
            $variation_id = $explode[1];
            $product = DB::table('products as p')->where('p.product_id', $p_id)->first();
            $variation = DB::table('product_variations as pv')->select('pv.*', 's.value as size_value')->join('sizes as s', 's.size_id', 'pv.size_id')->where('pv.variation_id', $variation_id)->first();
            $shipping_sort[$product->vendor_id][$key]['product'] = $product;
            $shipping_sort[$product->vendor_id][$key]['variation'] = $variation;
            $shipping_sort[$product->vendor_id][$key]['cart']['quantity'] = $cart->quantity;
            $shipping_sort[$product->vendor_id][$key]['cart']['image'] = $cart->attributes->image;
            $itr++;
        }
        $shipping_value = 0;
        foreach ($shipping_sort as $vendor => $products) {
            switch ($vendor) {
                case 7: // Endless
                    $total_weight = 0;

                    $pick_pack_value = count($products) > 1 ? $ship_value_endless->{'1_plus_lines'} : $ship_value_endless->{'1_line'};

                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }

                    $weight_cal = false;
                    $rem_total_weight = $total_weight;
                    $itr_weight = (int) ceil($total_weight / 69.99);
                    if($itr_weight != 1){
                        for($j = 1; $j < $itr_weight ; $j++){
                            $rem_total_weight = $rem_total_weight - 69.99;
                            $weight_cal = true;
                        }
                    }
                    for ($i = 1; $i <= $itr_weight; $i++) {
                        if($weight_cal && $i == 1){
                            $total_weight =  $rem_total_weight;
                        }elseif($weight_cal){
                            $total_weight =  69.99;
                        }
                        if ($total_weight > 0 && $total_weight < 15) {
                            $shipping_value = $shipping_value + $package_value_endless->lb15 + $ship_value_endless->lb15 + $pick_pack_value;
                        } elseif ($total_weight > 14.99 && $total_weight < 30) {
                            $shipping_value = $shipping_value + $package_value_endless->lb30 + $ship_value_endless->lb30 + $pick_pack_value;
                        } elseif ($total_weight > 29.99 && $total_weight < 50) {
                            $shipping_value = $shipping_value + $package_value_endless->lb50 + $ship_value_endless->lb50 + $pick_pack_value;
                        } elseif ($total_weight > 49.99 && $total_weight < 70) {
                            $shipping_value = $shipping_value + $package_value_endless->lb70 + $ship_value_endless->lb70 + $pick_pack_value;
                        }
                    }
                    break;
                case 5: // Leemarpet
                    $total_weight = 0;
                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }
                    $total_weight = (int) ceil($total_weight);
                    if ($total_weight <= 150) {
                        $leemarpet_shipping = $ship_value->{'lb' . "$total_weight"};
                    } else {
                        $diff_lbs = $total_weight - 150;
                        $leemarpet_shipping  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
                    }

                    $shipping_value  = $shipping_value + $leemarpet_shipping + 3;

                    break;
                case 4: // phillipsPet
                    $total_weight = 0;
                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }
                    $total_weight = (int) ceil($total_weight);
                    if ($total_weight <= 150) {
                        $philip_shipping = $ship_value->{'lb' . "$total_weight"};
                    } else {
                        $diff_lbs = $total_weight - 150;
                        $philip_shipping  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
                    }
                    $shipping_value  = $shipping_value + $philip_shipping;
                    break;
            }
        }

        $params['shipping_rate'] = $shipping_value;

        if (empty($errors)) {
            $response =  $objUser->addFrontUserAndCustomerAndOrders($params);
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
        $ship_value_endless = DB::table('shipping_rates_endless as e')->where('e.zip_codes', $find_shipping_full)->first();
        $package_value_endless = DB::table('packaging_rates_endless as p')->first();

        if (empty($ship_value)) {
            $ship_value = DB::table('shipping_rates as r')->where('r.zip_codes', $find_shipping_short)->where('r.match', 'short')->first();
        }

        if (empty($ship_value) || empty($ship_value_endless)) {
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
            $product = DB::table('products as p')->where('p.product_id', $p_id)->first();
            $variation = DB::table('product_variations as pv')->select('pv.*', 's.value as size_value')->join('sizes as s', 's.size_id', 'pv.size_id')->where('pv.variation_id', $variation_id)->first();
            $shipping_sort[$product->vendor_id][$key]['product'] = $product;
            $shipping_sort[$product->vendor_id][$key]['variation'] = $variation;
            $shipping_sort[$product->vendor_id][$key]['cart']['quantity'] = $cart->quantity;
            $shipping_sort[$product->vendor_id][$key]['cart']['image'] = $cart->attributes->image;
            $itr++;
        }
        $shipping_value = 0;
        foreach ($shipping_sort as $vendor => $products) {
            switch ($vendor) {
                case 7: // Endless
                    $total_weight = 0;

                    $pick_pack_value = count($products) > 1 ? $ship_value_endless->{'1_plus_lines'} : $ship_value_endless->{'1_line'};

                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }
                    // $rem_weight = 0;
                    $weight_cal = false;
                    $rem_total_weight = $total_weight;
                    $itr_weight = (int) ceil($total_weight / 69.99);
                    if($itr_weight != 1){
                        for($j = 1; $j < $itr_weight ; $j++){
                            $rem_total_weight = $rem_total_weight - 69.99;
                            $weight_cal = true;
                        }
                    }

                    for ($i = 1; $i <= $itr_weight; $i++) {
                        if($weight_cal && $i == 1){
                            $total_weight =  $rem_total_weight;
                        }elseif($weight_cal){
                            $total_weight =  69.99;
                        }
                        if ($total_weight > 0 && $total_weight < 15) {
                            $shipping_value = $shipping_value + $package_value_endless->lb15 + $ship_value_endless->lb15 + $pick_pack_value;
                        } elseif ($total_weight > 14.99 && $total_weight < 30) {
                            $shipping_value = $shipping_value + $package_value_endless->lb30 + $ship_value_endless->lb30 + $pick_pack_value;
                        } elseif ($total_weight > 29.99 && $total_weight < 50) {
                            $shipping_value = $shipping_value + $package_value_endless->lb50 + $ship_value_endless->lb50 + $pick_pack_value;
                        } elseif ($total_weight > 49.99 && $total_weight < 70) {
                            $shipping_value = $shipping_value + $package_value_endless->lb70 + $ship_value_endless->lb70 + $pick_pack_value;
                        }
                    }

                    break;
                case 5: // Leemarpet
                    $total_weight = 0;
                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }
                    $total_weight = (int) ceil($total_weight);
                    if ($total_weight <= 150) {
                        $leemarpet_shipping = $ship_value->{'lb' . "$total_weight"};
                    } else {
                        $diff_lbs = $total_weight - 150;
                        $leemarpet_shipping  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
                    }

                    $shipping_value  = $shipping_value + $leemarpet_shipping + 3;

                    break;
                case 4: // phillipsPet
                    $total_weight = 0;
                    foreach ($products as $key => $pro) {
                        $total_weight = $total_weight + ($pro['variation']->size_value * $pro['cart']['quantity']);
                    }
                    $total_weight = (int) ceil($total_weight);
                    if ($total_weight <= 150) {
                        $philip_shipping = $ship_value->{'lb' . "$total_weight"};
                    } else {
                        $diff_lbs = $total_weight - 150;
                        $philip_shipping  = ($diff_lbs * $ship_value->per_lbs) + $ship_value->lb150;
                    }
                    $shipping_value  = $shipping_value + $philip_shipping;
                    break;
            }
        }


        $rate =  $tax->rate;
        $get_total_price = (Cart::getTotal() - (Cart::getTotal() * env('PETS_DISC')));
        // dd($get_total_price);
        $data['tax']  = (float) number_format($rate * $get_total_price, 2);
        $data['shipping']  = (float) number_format($shipping_value, 2);
        $data['status']  = 200;
        $data['cart_total_tax']  = (float) number_format($data['tax'] + $get_total_price + $data['shipping'], 2);
        $data['cart_total']  = (float) number_format(Cart::getTotal(), 2);


        return json_encode($data);
    }

    public function getOrderComplete(Request $request, OrderModel $objOrder)
    {

        $user_data = json_decode(session()->get('user_data'));

        if (!empty($request->order_id)) {
            $order_detail = $objOrder->getSingleOrderDetails($request->order_id, $user_data->user_id);
        }

        if (empty($order_detail['order'])) {
            abort(401);
        }

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        $this->viewData['order'] = !empty($order_detail) ? $order_detail : [];
        return $this->buildTemplate('order-complete');
    }
}
