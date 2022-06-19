<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductVariationModel extends Model
{
    protected $table = 'product_variations';


    public function addVariationProducts($variations , $p_id){

        $insert_data = [];

        $variation_type = (count($variations) > 1) ? 'variation' : 'simple';

        $itr = 0;
        foreach ($variations as $size_id => $data) {

            $insert_data[$itr]['product_id'] = $p_id;
            $insert_data[$itr]['size_id'] =$size_id;
            $insert_data[$itr]['variation_sku'] = $data['size_'.$size_id.'_sku'];
            $insert_data[$itr]['variation_upc'] = $data['size_'.$size_id.'_upc'];
            $insert_data[$itr]['variation_quantity'] = $data['size_'.$size_id.'_qty'];
            $insert_data[$itr]['manufacturer_no'] = $data['size_'.$size_id.'_mfn'];
            $insert_data[$itr]['v_price'] = $data['size_'.$size_id.'_vprice'];
            $insert_data[$itr]['s_price'] = $data['size_'.$size_id.'_sprice'];
            $insert_data[$itr]['r_price'] = $data['size_'.$size_id.'_rprice'];
            $insert_data[$itr]['type'] = $variation_type;
            $insert_data[$itr]['sale'] = $data['size_'.$size_id.'_sale'];
            $insert_data[$itr]['length'] = $data['size_'.$size_id.'_length'];
            $insert_data[$itr]['width'] = $data['size_'.$size_id.'_width'];
            $insert_data[$itr]['height'] = $data['size_'.$size_id.'_height'];
            $insert_data[$itr]['product_size'] = $data['size_'.$size_id.'_product_size'];
            $insert_data[$itr]['discount_percent'] = $data['size_'.$size_id.'_discount_percent'];
            $insert_data[$itr]['discount_price'] = $data['size_'.$size_id.'_discount_price'];
            $insert_data[$itr]['discount_apply'] = $data['size_'.$size_id.'_discount_apply_on'];

            $itr++;

        }

        DB::table($this->table)->insert($insert_data);

    }

}
