<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\CategoryModel;
use Cart;
use App\Models\ProductModel;

class TopBarDataComposer {

    public function compose(View $view) {
        $objCategory = new CategoryModel();
        $objProductModel = new ProductModel();
        $image_data = [];
        // dd(Cart::getTotal());
        $cart_total = Cart::getTotal();
        $carts = Cart::getContent();

        // foreach ($carts as $key => $cart) {
        //     $p_id = $cart['id'];

        //     $product_obj = $objProductModel->getProductCartPageData($p_id, 's');
        //     $image_data[$product_obj->product_id]['image'] = $product_obj->images;
        // }

        $carts = (Cart::isEmpty()) ? [] : $carts;
        $view
        // ->with('image_data', $image_data)
            ->with('cart_total', $cart_total)
            ->with('cart_count', count($carts))
            ->with('carts', $carts);

    }

}
