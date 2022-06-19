<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use Cart;
use DB;

class CartController extends Controller
{

    public function addToCart(Request $request, ProductModel $objProductM)
    {

        $error = [];
        $data = [];
        $image_data = [];
        $product_id = (int) $request->get('p_id');
        $quantity = (int) $request->get('quantity');

        $product = $objProductM->getProductCartPageData($product_id, 'm');

        $size_id =  (int) $request->get('size_id');
        $size_obj = DB::table('sizes as s')->where('s.size_id' , $size_id)->first();
        $product_size = $product->variations[$size_obj->value];
        if (empty($error)) {

            Cart::add(array(
                'id' => $product->product_id . '_' .$product_size->variation_id, // unique row ID
                'name' => $product->title,
                'price' => $product_size->s_price,
                'quantity' => !empty($quantity) ? $quantity : 1,
                'attributes' => [
                    'weight' => $product_size->size_value,
                    'image' => $product->image
                ]
            ));
        }



        $data['status'] = 200;
        $data['data'] = Cart::getContent();
        return json_encode($data);
    }


    public function deleteToCart(Request $request, ProductModel $objProductM){
        $data = [];
        $image_data = [];
        $cart_key = $request->get('cart_key');

        if(!empty(Cart::get($cart_key))){
            Cart::remove($cart_key);

            $carts = Cart::getContent();
            foreach ($carts as $key => $cart) {
                $p_id = $cart['id'];
                $product_id = explode('_', $p_id);
                $product_id = $product_id[0];
                $product_obj = $objProductM->getProductCartPageData($product_id, 's');
            }

            $data['status'] = 200;
            $data['data'] = Cart::getContent();


        }
        return  !empty($data) ? json_encode($data) :false;

    }
    public function deleteToCartByGet(Request $request, ProductModel $objProductM){
        $data = [];
        $image_data = [];

        $cart_key = $request->cart_key;

        if(!empty(Cart::get($cart_key))){
            Cart::remove($cart_key);

        }
        return  redirect()->back();

    }

    public function updateCartData(Request $request){

        // dd($request->all());
        $carts = Cart::getContent();
        if(!empty($carts)){
            foreach ($carts as $key => $cart) {
                $qty_val = $request->get($cart->id.'_quantity') - $cart->quantity ;

                Cart::update($cart->id, array(
                    'quantity' => $qty_val,
                ));
            }
        }

        return  redirect()->back();

    }
}
