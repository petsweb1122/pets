<?php

namespace App\Helpers;

use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use DB;
use Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateCustomerOrderMail;


class PaypalHelper
{

    public function getContext()
    {

        $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET')));
        $apiContext->setConfig(array(
            'mode' => env('PAYPAL_MODE'),
        ));

        return $apiContext;
    }


    public function sendPaymentToPaypal($order_data, $order_items, $order_id)
    {


        $apiContext = $this->getContext();
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($order_data['final_amount']);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setInvoiceNumber(uniqid());
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/paypal_execution.html'))
            ->setCancelUrl(url('/paypal_cencel.html'));

        $payment = new Payment();

        $payment->setIntent("sale")
            ->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array(
                $transaction
            ));
        $payment->create($apiContext);

        $session_order_data = [];
        $session_order_data['order_data'] = $order_data;
        $session_order_data['order_items'] = $order_items;
        $session_order_data['order_id'] = $order_id;

        session(['session_order_data' => json_encode($session_order_data)]);

        return $payment;
    }

    public function executionPaypalPayment($request)
    {

        $apiContext = $this->getContext();


        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        $transaction = new Transaction();
        $amount = new Amount();

        $session_order_data = json_decode(session()->get('session_order_data'));
        $user_data = json_decode(session()->get('user_data'));

        $amount->setCurrency('USD');
        $amount->setTotal($session_order_data->order_data->final_amount);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);


        $customer_details = DB::table('customer_shipping_details as cd')->where('cd.order_id', $session_order_data->order_id)->first();
        // dd($customer_details->shipping_first_name);
        // dd($session_order_data->order_data);

        $result = $payment->execute($execution, $apiContext);

        $order_detail = DB::table('orders as o')->where('o.order_id', $session_order_data->order_id)->first();
        $session_order_data->order_data = $order_detail;

        foreach ($session_order_data->order_items as $key => $item) {
            $single_pro = DB::table('products as p')->where('p.product_id', $item->product_id)->first();

            $image = DB::table('images as i')
                ->join('images_sizes as is', 'i.id', 'is.image_id')
                ->where('is.object_type', 'product')
                ->where('is.object_id', $item->product_id)
                ->where('is.size_number', 'm')
                ->first();
            $item->upc = $single_pro->p_upc;
            $item->image = !empty($image->image_name)  ? url("/products/$item->product_id" . '_' . "$single_pro->p_upc/$image->image_name") : url('/img/no_image.png');
        }

        $details = [
            'customer_details' => $customer_details,
            'session_order_data' => $session_order_data
        ];

        Mail::to($customer_details->shipping_email)->send(new CreateCustomerOrderMail($details));

        $data_paypal = [];
        $data_paypal['paypal_id'] = !empty($result->id) ? $result->id : 0;
        $data_paypal['order_id'] = $session_order_data->order_id;
        $data_paypal['user_id'] = $user_data->user_id;
        $data_paypal['token'] = !empty($request->token) ? $request->token : 0;
        $data_paypal['cart_no'] = !empty($result->cart) ? $result->cart : 0;
        $data_paypal['payer_info_method'] = !empty($result->payer->payment_method) ? $result->payer->payment_method : 0;
        $data_paypal['payer_info_status'] = !empty($result->payer->status) ? $result->payer->status : 0;
        $data_paypal['payer_info_email'] = !empty($result->payer->payer_info->email) ? $result->payer->payer_info->email : 0;
        $data_paypal['payer_info_first_name'] = !empty($result->payer->payer_info->first_name) ? $result->payer->payer_info->first_name : 0;
        $data_paypal['payer_info_last_name'] = !empty($result->payer->payer_info->last_name) ? $result->payer->payer_info->last_name : 0;
        $data_paypal['payer_id'] = !empty($result->payer->payer_info->payer_id) ? $result->payer->payer_info->payer_id : 0;
        $data_paypal['paypal_shipping_name'] = !empty($result->payer->payer_info->shipping_address->recipient_name) ? $result->payer->payer_info->shipping_address->recipient_name : 0;
        $data_paypal['paypal_shipping_line1'] = !empty($result->payer->payer_info->shipping_address->line1) ? $result->payer->payer_info->shipping_address->line1 : 0;
        $data_paypal['paypal_shipping_state'] = !empty($result->payer->payer_info->shipping_address->state) ? $result->payer->payer_info->shipping_address->state : 0;
        $data_paypal['paypal_shipping_city'] = !empty($result->payer->payer_info->shipping_address->city) ? $result->payer->payer_info->shipping_address->city : 0;
        $data_paypal['paypal_shipping_postalcode'] = !empty($result->payer->payer_info->shipping_address->postal_code) ? $result->payer->payer_info->shipping_address->postal_code : 0;
        $data_paypal['paypal_shipping_country_code'] = !empty($result->payer->payer_info->shipping_address->country_code) ? $result->payer->payer_info->shipping_address->country_code : 0;

        $data_paypal['transaction_amount'] = !empty($result->transactions[0]->amount->total) ? $result->transactions[0]->amount->total : 0;
        $data_paypal['transaction_subtotal'] = !empty($result->transactions[0]->amount->details->subtotal) ? $result->transactions[0]->amount->details->subtotal : 0;
        $data_paypal['transaction_shipping'] = !empty($result->transactions[0]->amount->details->shipping) ? $result->transactions[0]->amount->details->shipping : 0;
        $data_paypal['transaction_insurance'] = !empty($result->transactions[0]->amount->details->insurance) ? $result->transactions[0]->amount->details->insurance : 0;
        $data_paypal['transaction_handling_fee'] = !empty($result->transactions[0]->amount->details->handling_fee) ? $result->transactions[0]->amount->details->handling_fee : 0;
        $data_paypal['transaction_shipping_discount'] = !empty($result->transactions[0]->amount->details->shipping_discount) ? $result->transactions[0]->amount->details->shipping_discount : 0;
        $data_paypal['transaction_discount'] = !empty($result->transactions[0]->amount->details->discount) ? $result->transactions[0]->amount->details->discount : 0;
        $data_paypal['invoice_number'] = !empty($result->transactions[0]->invoice_number) ? $result->transactions[0]->invoice_number : 0;
        $data_paypal['payment_status'] = !empty($result->transactions[0]->related_resources[0]->sale->state) ? $result->transactions[0]->related_resources[0]->sale->state : 0;
        $data_paypal['payment_saleid'] = !empty($result->transactions[0]->related_resources[0]->sale->id) ? $result->transactions[0]->related_resources[0]->sale->id : 0;
        $data_paypal['payment_mode'] = !empty($result->transactions[0]->related_resources[0]->sale->payment_mode) ? $result->transactions[0]->related_resources[0]->sale->payment_mode : 0;
        $data_paypal['transaction_fee'] = !empty($result->transactions[0]->related_resources[0]->sale->transaction_fee->value) ? $result->transactions[0]->related_resources[0]->sale->transaction_fee->value : 0;


        $result = DB::table('payment_transactions')->insert($data_paypal);

        Cart::clear();
        session()->forget('session_order_data');


        return redirect()->action('Front\ShoppingCartController@getOrderComplete', ['order_id' => $session_order_data->order_id]);
    }


    public function cancelPaypalPayment($request)
    {


        $session_order_data = json_decode(session()->get('session_order_data'));
        $user_data = json_decode(session()->get('user_data'));


        $data_paypal = [];
        $data_paypal['order_id'] = !empty($session_order_data->order_id) ? $session_order_data->order_id : '';
        $data_paypal['user_id'] = $user_data->user_id;
        $data_paypal['token'] = !empty($request->token) ? $request->token : 0;


        $result = DB::table('payment_transactions')->insert($data_paypal);


        session()->forget('session_order_data');

        return redirect()->action('Front\ShoppingCartController@getCheckout', []);
    }
}
