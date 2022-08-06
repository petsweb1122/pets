<?php

namespace App\Imports;

use DB;
use App\Helpers\ImageHelper;
use App\Models\ImageModel;
use App\Models\ProductModel;


class EndlessImporter
{

    private $errors = [];

    public function uploadProductsByApi($items, $vendor_id)
    {
        $items_arrays = $items->toArray();

        // VALIDATE API STRUCTURE

        $insert_products = [];
        // DB::beginTransaction();
        $sync_upcs = array();

        try {

            foreach ($items as $key => $item) {

                $check_dup_obj = DB::table('products as p')->where('p.external_product_id', $item->product_id)->where('p.vendor_id', $vendor_id)->first();

                if (empty($check_dup_obj)) {

                    if (!empty($item->brand)) {
                        $vendor_child_breadcrumb = strtolower(str_replace([' ', "/", "&", ",", ",-"], '-', $item->brand));
                        $vendor_child_breadcrumb = str_replace(".", '-', $vendor_child_breadcrumb);
                        $vendor_child_breadcrumb = str_replace("--", '-', $vendor_child_breadcrumb);
                        $vendor_child_breadcrumb = rtrim($vendor_child_breadcrumb, '-');
                        $brnad_obj = DB::table('brands as b')->where('b.breadcrumb', $vendor_child_breadcrumb)->first();

                        if (empty($brnad_obj->brand_id)) {

                            $b_data = [];
                            $b_data['title'] = $item->brand;
                            $b_data['breadcrumb'] = $vendor_child_breadcrumb;

                            DB::table('brands')->insert($b_data);
                            $brand_id = DB::getPdo()->lastInsertId();
                        } else {
                            $brand_id = $brnad_obj->brand_id;
                        }
                    }

                    $insert_products['title'] = $item->title;
                    $insert_products['external_product_id'] = $item->product_id;
                    $insert_products['description'] = $item->description;
                    $insert_products['ingredients'] = $item->ingredients;
                    $product_title_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "!", "=", "/", ".", '"', "&", "'", ",", "#"), '-', $item->title));
                    $product_title_breadcrumb = str_replace(['---', '--', '--', "+-"], '-', $product_title_breadcrumb);
                    $insert_products['title_breadcrumb'] = rtrim($product_title_breadcrumb, '-');
                    $insert_products['brand'] = !empty($brand_id) ? $brand_id : '';
                    $insert_products['status'] = 'published';
                    $insert_products['vendor_id'] = $vendor_id;

                    // dd( $insert_products);

                    DB::table('products')->insert($insert_products);
                    $product_id = DB::getPdo()->lastInsertId();


                    $size_results = json_decode($item->sizes);
                    $metadata = json_decode($item->metadata);


                    foreach ($size_results as $key => $res) {

                        $size_obj = DB::table('sizes')->where('value', $res->shipping_weight_lbs)->first();

                        if (!empty($size_obj)) {
                            $size_id = $size_obj->size_id;
                            $size_value = $size_obj->value;
                        } else {
                            DB::table('sizes')->insert(['value' => $res->shipping_weight_lbs]);
                            $size_value = $res->shipping_weight_lbs;
                            $size_id = DB::getPdo()->lastInsertId();
                        }

                        $product_variations = [];
                        $product_variations['product_id'] = $product_id;
                        $product_variations['size_id'] = $size_id;
                        $product_variations['v_price'] = !empty($res->wholesale) ? $res->wholesale : $res->wholesale;
                        $product_variations['minimum_advertised_price'] = !empty($res->minimum_advertised_price) ? $res->minimum_advertised_price : $res->minimum_advertised_price;
                        $product_variations['s_price'] = $product_variations['v_price'] * env('PETS_PRODUCT_SALE_PERCENTAGE');
                        $product_variations['variation_upc'] =  $res->upc;
                        $product_variations['type'] = 'variation';

                        // $sync_ids[] = $item->product_id;

                        DB::table('product_variations')->insert($product_variations);
                        $variation_id = DB::getPdo()->lastInsertId();

                        $product_sizes = [];
                        $product_sizes['product_id'] = $product_id;
                        $product_sizes['variation_id'] = $variation_id;
                        $product_sizes['size_id'] = $size_id;
                        $product_sizes['size_value'] = $size_value;
                        DB::table('product_sizes')->insert($product_sizes);
                    }


                    $params_category = [];

                    $res_cats = DB::table('vendor_categories as vc')
                        ->select('vcc.*', 'c.title as category_title', 'c.breadcrumb')
                        ->join('vendor_categories_to_categories as vcc' , 'vc.id' , 'vcc.vendor_cat_id')
                        ->join('categories as c' , 'c.category_id' , 'vcc.category_id')
                        ->where('vc.vendor_id', $vendor_id)
                        ->where('vc.category_name', $metadata->species)->groupBy('vcc.category_id')->get();
                    $itr = 0;

                    foreach($res_cats as $cat_obj){

                        $params_category[$itr]['category_id'] = $cat_obj->category_id;
                        $params_category[$itr]['category_value'] = $cat_obj->category_title;
                        $params_category[$itr]['product_id'] = $product_id;
                        $itr++;
                    }

                    $category_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-',$metadata->species));
                    $category_breadcrumb = str_replace("&-", '-', $category_breadcrumb);
                    $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                    $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                    $category_breadcrumb = rtrim($category_breadcrumb, '-');

                    $cat_breadcrumb = strtolower($metadata->species);

                    if (!empty($metadata->category)) {

                        $category_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-',$metadata->category));
                        $category_breadcrumb = str_replace("&-", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $cat_breadcrumb = $cat_breadcrumb . '-' . rtrim($category_breadcrumb, '-');

                        $res_cat2 = DB::table('vendor_categories as vc')
                        ->select('vcc.*', 'c.title as category_title', 'c.breadcrumb')
                        ->join('vendor_categories_to_categories as vcc' , 'vc.id' , 'vcc.vendor_cat_id')
                        ->join('categories as c' , 'c.category_id' , 'vcc.category_id')
                        ->where('vc.vendor_id', $vendor_id)
                        ->where('vc.category_name', $metadata->category)
                        ->where('vc.category_breadcrumb' , $cat_breadcrumb)
                        ->groupBy('vcc.category_id')->get();

                        foreach($res_cat2 as $cat_obj){

                            $params_category[$itr]['category_id'] = $cat_obj->category_id;
                            $params_category[$itr]['category_value'] = $cat_obj->category_title;
                            $params_category[$itr]['product_id'] = $product_id;
                            $itr++;

                        }
                    }

                    // dd($vendor_id);

                    if (!empty($metadata->subcategory)) {

                        $category_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-',$metadata->subcategory));
                        $category_breadcrumb = str_replace("&-", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $cat_breadcrumb = $cat_breadcrumb . '-' . rtrim($category_breadcrumb, '-');

                        $res_cat3 = DB::table('vendor_categories as vc')
                        ->select('vcc.*', 'c.title as category_title', 'c.breadcrumb')
                        ->join('vendor_categories_to_categories as vcc' , 'vc.id' , 'vcc.vendor_cat_id')
                        ->join('categories as c' , 'c.category_id' , 'vcc.category_id')
                        ->where('vc.vendor_id', $vendor_id)
                        ->where('vc.category_name', $metadata->subcategory)
                        ->where('vc.category_breadcrumb' , $cat_breadcrumb)
                        ->groupBy('vcc.category_id')->get();

                        foreach($res_cat3 as $cat_obj){

                            $params_category[$itr]['category_id'] = $cat_obj->category_id;
                            $params_category[$itr]['category_value'] = $cat_obj->category_title;
                            $params_category[$itr]['product_id'] = $product_id;
                            $itr++;
                        }

                    }

                    DB::table('product_categories')->insert($params_category);

                    $more_images = !empty($item->additional_image_urls) ?  json_decode($item->additional_image_urls) : [];
                    // dd($more_images);
                    $objProduct = new ProductModel();
                    $product = $objProduct->getSingleProductById($product_id);

                    $image_helper = new ImageHelper();
                    $time_hash = md5(time() . rand(0, 100));
                    $upload_images =  $image_helper->uploadImageUsingWebUrl($item->image_url, 'products', $product, $time_hash);

                    $objImageModel = new ImageModel();

                    $response = $objImageModel->uploadProductImages($upload_images, $product->product_id);
                    // dd($response);
                    // foreach ($more_images as $key => $image) {
                    //     $objProduct = new ProductModel();
                    //     $product = $objProduct->getSingleProductById($product_id);

                    //     $image_helper = new ImageHelper();
                    //     $time_hash = md5(time() . rand(0, 100));
                    //     $upload_images =  $image_helper->uploadImageUsingWebUrl($item->image_url, 'products', $product, $time_hash);

                    //     $objImageModel = new ImageModel();

                    //     $response = $objImageModel->uploadProductImages($upload_images, $product->product_id);
                    // }
                }

                DB::table('vendor_endless as ve')->where('ve.id', $item->id)->update(['ve.status' => 'synced']);
            }



            // DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product Added Successfully';
        } catch (\Throwable $e) {
            // dd($e);
            // DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            // dd($e);
            // DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        }

        return $response;
    }

    private function addVendorChild($title, $p_vendor_id, $breadcrumb)
    {

        $data = [];
        // $vendor_child_breadcrumb = strtolower(str_replace(' ', '-', $title));
        $data['vendor_child_title'] = $title;
        $data['vendor_child_breadcrumb'] = $breadcrumb;
        $data['vendor_parent_id'] = $p_vendor_id;

        DB::table('vendor_childs')->insert($data);
        $id = DB::getPdo()->lastInsertId();

        // $result = DB::table('vendor_childs as vc')->where('vendor_child_id', $id)->first();

        return $id;
    }

    private function addFirstLevelCategory($title, $breadcrumb)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $data['breadcrumb'] = $breadcrumb;
        $data['cat_level'] = 1;

        DB::table('categories')->insert($data);
        $cat_id = DB::getPdo()->lastInsertId();

        $cat_res = DB::table('categories as c')->where('category_id', $cat_id)->first();

        return $cat_res;
    }

    private function addSecondLevelCategory($title, $first_level_cat, $breadcrumb)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $data['breadcrumb'] = $breadcrumb;
        $data['parent_id'] = $first_level_cat->category_id;
        $data['parent_title'] = $first_level_cat->title;
        $data['parent_breadcrumb'] = $first_level_cat->breadcrumb;
        $data['cat_1'] = $first_level_cat->category_id;
        $data['cat_level'] = 2;

        DB::table('categories')->insert($data);
        $cat_id = DB::getPdo()->lastInsertId();

        $cat_res = DB::table('categories as c')->where('category_id', $cat_id)->first();

        return $cat_res;
    }

    private function addThirdLevelCategory($title, $first_level_cat, $second_level_cat, $breadcrumb)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $data['breadcrumb'] = $breadcrumb;
        $data['parent_id'] = $second_level_cat->category_id;
        $data['parent_title'] = $second_level_cat->title;
        $data['parent_breadcrumb'] = $second_level_cat->breadcrumb;
        $data['cat_1'] = $first_level_cat->category_id;
        $data['cat_2'] = $second_level_cat->category_id;
        $data['cat_level'] = 3;

        DB::table('categories')->insert($data);
        $cat_id = DB::getPdo()->lastInsertId();

        $cat_res = DB::table('categories as c')->where('category_id', $cat_id)->first();

        return $cat_res;
    }

    private function addFourthLevelCategory($title, $first_level_cat, $second_level_cat, $third_level_cat, $breadcrumb)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $data['breadcrumb'] = $breadcrumb;
        $data['parent_id'] = $third_level_cat->category_id;
        $data['parent_title'] = $third_level_cat->title;
        $data['parent_breadcrumb'] = $third_level_cat->breadcrumb;
        $data['cat_1'] = $first_level_cat->category_id;
        $data['cat_1'] = $second_level_cat->category_id;
        $data['cat_3'] = $third_level_cat->category_id;
        $data['cat_level'] = 4;

        DB::table('categories')->insert($data);
        $cat_id = DB::getPdo()->lastInsertId();

        $cat_res = DB::table('categories as c')->where('category_id', $cat_id)->first();

        return $cat_res;
    }

    private function getCheckStructure($received_structure)
    {

        foreach ($received_structure as $key => $value) {
            if (!in_array($value, $this->structure)) {
                $this->errors[] = "$value not exists in our structure, please check";
            }
        }

        return $this->errors;
    }



    public function uploadEndlessCategories($vendor_id)
    {
        // VALIDATE API STRUCTURE

        $items = DB::table('vendor_endless as ve')->where('ve.status', 'not-synced')->get()->toArray();

        DB::beginTransaction();

        try {
            foreach ($items as $key => $item) {
                $metadata  = json_decode($item->metadata);
                // dd($metadata->species);
                // dd($metadata->category);
                // dd($metadata->subcategory);

                $category = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $metadata->species));
                $category = str_replace("&-", '-', $category);
                $category = str_replace("--", '-', $category);
                $category = str_replace("--", '-', $category);
                $category_bread = rtrim($category, '-');


                $check_dup_cat =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread)->where('vc.vendor_id', $vendor_id)->first();
                $category_name = $metadata->species;


                if (empty($check_dup_cat)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category_name;
                    $add_category['category_breadcrumb'] =  $category_bread;
                    $add_category['vendor_id'] =  $vendor_id;

                    DB::table('vendor_categories')->insert($add_category);
                } else {
                    $category_bread = $check_dup_cat->category_breadcrumb;
                    $category_name = $check_dup_cat->category_name;
                }

                $category_1 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $metadata->category));
                $category_1 = str_replace("&-", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_bread_1 = rtrim($category_1, '-');
                $category_bread_1 = $category_bread . '-' . $category_bread_1;


                $check_dup_cat_1 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_1)->where('vc.vendor_id', $vendor_id)->first();
                $category1_name = $metadata->category;


                if (empty($check_dup_cat_1)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category1_name;
                    $add_category['category_breadcrumb'] =  $category_bread_1;
                    $add_category['vendor_id'] =  $vendor_id;

                    DB::table('vendor_categories')->insert($add_category);
                } else {
                    $category_bread_1 = $check_dup_cat_1->category_breadcrumb;
                    $category1_name = $check_dup_cat_1->category_name;
                }

                $category_2 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $metadata->subcategory));
                $category_2 = str_replace("&-", '-', $category_2);
                $category_2 = str_replace("--", '-', $category_2);
                $category_2 = str_replace("--", '-', $category_2);
                $category_bread_2 = rtrim($category_2, '-');
                $category_bread_2 = $category_bread_1 . '-' . $category_bread_2;
                $category_bread_2 = rtrim($category_bread_2, '-');


                $check_dup_cat_2 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_2)->where('vc.vendor_id', $vendor_id)->first();
                $category2_name = $metadata->subcategory;


                if (empty($check_dup_cat_2)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category2_name;
                    $add_category['category_breadcrumb'] =  $category_bread_2;
                    $add_category['vendor_id'] =  $vendor_id;

                    // dd($add_category);
                    DB::table('vendor_categories')->insert($add_category);
                }
            }

            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Categories Added Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Categories Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Categories Not Added Successfully Pease Try Again';
        }

        return $response;
    }
}
