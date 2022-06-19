<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\ProductModel;
use App\Helpers\ProductSizeHelper;
use DB;

class SingleProductDataComposer {

    public function compose(View $view) {

        $objProduct = new ProductModel();

        $pDetails  = $objProduct->getSingleProductFullDetailsById(request()->product_id);
        // dd($pDetails);

        $sizes_results = !empty(session()->get('size_results')) ? session()->get('size_results') : [];
        $sizes = !empty(session()->get('add_sizes')) ?  json_decode(session()->get('add_sizes'), 1) : [];

        // dd($sizes);


        $obj_size_helper = new ProductSizeHelper();

        $product_sizes = [];

        foreach ($pDetails->variations as $key => $v_prop) {

            $size_obj = DB::table('sizes as s')->where('s.size_id', $v_prop->size_id)->first();
            $sizes[$v_prop->size_id] = $v_prop->size_id;
            $product_sizes[$v_prop->size_id] = $v_prop->size_id;
            if(!empty($size_obj) && in_array($v_prop->size_id, $sizes)){
                $sizes_results[$v_prop->size_id]  = $obj_size_helper->getSizeHtml($size_obj , $v_prop);
                $sizes[$v_prop->size_id] = $v_prop->size_id;
            }

        }

        $rem_sizes =array_diff($sizes,$product_sizes);

        foreach ($rem_sizes as $key => $size) {

            $size_obj = DB::table('sizes as s')->where('s.size_id', $size)->first();

            if(!empty($size_obj)){
                $sizes_results[$size]  = $obj_size_helper->getSizeHtml($size_obj);
            }

        }

        session(['add_sizes' => json_encode($sizes)]);
        session(['size_results' => $sizes_results]);
        $view->with('product',$pDetails);
    }

}
