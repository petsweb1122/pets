<?php

namespace App\Helpers;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use DB;

class BreadCrumb {

    public function getSearchBreadCrumb($cat_obj) {
        $data = array();


        for($i = $cat_obj->cat_level; $i >= 0 ; $i-- ){

            if($i == $cat_obj->cat_level){
                $data[$i]['link'] = '';
                $data[$i]['title'] = $cat_obj->title;
            }else if($i < $cat_obj->cat_level && $i !== 0){
                $objCategory = new CategoryModel;
                $getCat = $objCategory->getSingleCategoryById($cat_obj->{'cat_'.$i});
                $data[$i]['link'] = url('/'.$getCat->breadcrumb);
                $data[$i]['title'] = $getCat->title;
            }

            if($i == 0){
                $data[$i]['link'] = url('/');
                $data[$i]['title'] = 'Home';
            }

        }

        ksort($data);
        return $data;

    }

    public function getDetailBreadCrumb($id) {

        $data = array();

        $cat_obj = DB::table('product_categories as pc')
                    ->join('categories as c', 'c.category_id' , 'pc.category_id')
                    ->where('pc.product_id', $id)->orderBy('cat_level', 'desc')->first();
        // dd($cat_obj);
        for($i = $cat_obj->cat_level; $i >= 1 ; $i-- ){
            if($i == $cat_obj->cat_level){
                $data[$i]['link'] = url('/'.$cat_obj->breadcrumb);
                $data[$i]['title'] = $cat_obj->title;
            }else if($i < $cat_obj->cat_level && $i !== 0){
                $objCategory = new CategoryModel;
                $getCat = $objCategory->getSingleCategoryById($cat_obj->{'cat_'.$i});

                $data[$i]['link'] = url('/'.$getCat->breadcrumb);
                $data[$i]['title'] = $getCat->title;
            }

            if($i == 0){
                $data[$i]['link'] = url('/');
                $data[$i]['title'] = 'Home';
            }


        }

        $obj_pro = new ProductModel();
        $product = $obj_pro->getSingleProductById($id);
        // dd($product);
        $count = count($data);
        $data[$count]['link'] = '';
        $data[$count]['title'] = $product->title;

        ksort($data);
        return $data;

    }

}
