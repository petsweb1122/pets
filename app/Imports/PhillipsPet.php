<?php

namespace App\Imports;

use DB;

class PhillipsPet
{

    private $errors = [];

    public function uploadProductsByApi($items, $vendor_id)
    {
        $items_arrays = $items->toArray();

        // VALIDATE API STRUCTURE

        $insert_products = [];
        DB::beginTransaction();
        $sync_upcs = array();

        try {

            foreach ($items as $key => $item) {
                $check_dup_pro = '';

                if (!empty($item->upc1)) {
                    $check_dup_pro =  DB::table('products as p')->join('product_variations as v', 'v.product_id', 'p.product_id')->where('v.variation_upc', $item->upc1)->first();
                } else {
                    $check_dup_pro = DB::table('products as p')->join('product_variations as v', 'v.product_id', 'p.product_id')->where('v.variation_upc', $item->upc2)->first();
                }

                if (empty($check_dup_pro) && (!empty($item->upc1) || !empty($item->upc2))) {

                    if (!empty($item->vendor_name)) {
                        $vendor_child_breadcrumb = strtolower(str_replace([' ', "/", "&", ",", ",-"], '-', $item->vendor_name));
                        $vendor_child_breadcrumb = str_replace(".", '-', $vendor_child_breadcrumb);
                        $vendor_child_breadcrumb = str_replace("--", '-', $vendor_child_breadcrumb);
                        $vendor_child_breadcrumb = rtrim($vendor_child_breadcrumb, '-');
                        $vendor_child_obj = DB::table('vendor_childs as vc')->where('vc.vendor_child_breadcrumb', $vendor_child_breadcrumb)->first();
                        $brnad_obj = DB::table('brands as b')->where('b.breadcrumb', $vendor_child_breadcrumb)->first();


                        if (empty($vendor_child_obj->vendor_child_id)) {
                            $vendor_child_id = $this->addVendorChild($item->vendor_name, $vendor_id, $vendor_child_breadcrumb);
                        } else {
                            $vendor_child_id = $vendor_child_obj->vendor_child_id;
                        }

                        if (empty($brnad_obj->brand_id)) {

                            $b_data = [];
                            $b_data['title'] = $item->vendor_name;
                            $b_data['breadcrumb'] = $vendor_child_breadcrumb;

                            DB::table('brands')->insert($b_data);
                            $brand_id = DB::getPdo()->lastInsertId();
                        } else {
                            $brand_id = $brnad_obj->brand_id;
                        }
                    }

                    $insert_products['title'] = $item->short_desc;
                    $product_title_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "!", "=", "/", ".", '"', "&", "'", ",", "#"), '-', $item->short_desc));
                    $product_title_breadcrumb = str_replace(['---', '--', '--', "+-"], '-', $product_title_breadcrumb);
                    $insert_products['title_breadcrumb'] = rtrim($product_title_breadcrumb, '-');
                    $insert_products['brand'] = !empty($brand_id) ? $brand_id : '';
                    $insert_products['status'] = 'draft';
                    $insert_products['vendor_id'] = $vendor_id;

                    // dd( $insert_products);

                    DB::table('products')->insert($insert_products);
                    $product_id = DB::getPdo()->lastInsertId();



                    $size_obj = DB::table('sizes')->where('value', $item->weight_1)->first();
                    if (!empty($size_obj)) {
                        $size_id = $size_obj->size_id;
                        $size_value = $size_obj->value;
                    } else {
                        DB::table('sizes')->insert(['value' => $item->weight_1]);
                        $size_value = $item->weight_1;
                        $size_id = DB::getPdo()->lastInsertId();
                    }

                    $product_variations = [];
                    $product_variations['product_id'] = $product_id;
                    $product_variations['size_id'] = $size_id;
                    $product_variations['v_price'] = !empty($item->price_1) ? $item->price_1 : $item->price_2;
                    $product_variations['s_price'] = $product_variations['v_price'] * env('PETS_PRODUCT_SALE_PERCENTAGE');
                    $product_variations['variation_upc'] = !empty($item->upc1) ? $item->upc1 : $item->upc2;
                    $product_variations['case_quantity'] = $item->case_qty;
                    $product_variations['variation_quantity'] = $item->in_stock;
                    $product_variations['type'] = 'simple';
                    $product_variations['uom'] = !empty($item->uom1) ? $item->uom1 : $item->uom2;
                    $product_variations['uom_temp'] = !empty($item->uom1) ? $item->uom1 : $item->uom2;

                    $sync_upcs[] = $product_variations['variation_upc'];

                    DB::table('product_variations')->insert($product_variations);
                    $variation_id = DB::getPdo()->lastInsertId();

                    $product_sizes = [];
                    $product_sizes['product_id'] = $product_id;
                    $product_sizes['variation_id'] = $variation_id;
                    $product_sizes['size_id'] = $size_id;
                    $product_sizes['size_value'] = $size_value;
                    DB::table('product_sizes')->insert($product_sizes);



                    $params_category = [];
                    // $category = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->primary_animal));
                    // $category = str_replace("&-", '-', $category);
                    // $category = str_replace("--", '-', $category);
                    // $category = str_replace("--", '-', $category);
                    // $category = rtrim($category, '-');
                    // $res_cat = DB::table('categories as c')->where('c.breadcrumb', $category)->where('c.cat_level', 1)->first();


                    // if (empty($res_cat->category_id)) {
                    //     $res_cat = $this->addFirstLevelCategory($item->primary_animal, $category);
                    // }

                    // $first_level_cat = $res_cat->category_id;

                    $res_cat = DB::table('vendor_categories as vc')
                        ->select('c.*')
                        ->join('categories as c', 'c.category_id', 'vc.map_with')->where('vc.category_name', $item->primary_animal)->where('vc.vendor_id', $vendor_id)->first();

                    $params_category[0]['category_id'] = $res_cat->category_id;
                    $params_category[0]['category_value'] = $res_cat->title;
                    $params_category[0]['product_id'] = $product_id;

                    if (!empty($item->cat1)) {
                        // $category2 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat1));
                        // $category2 = str_replace("&-", '-', $category2);
                        // $category2 = str_replace("--", '-', $category2);
                        // $category2 = str_replace("--", '-', $category2);
                        // $category2 = rtrim($category2, '-');

                        // $cat2_bread = $category . '-' . $category2;
                        // $res_cat2 = DB::table('categories as c')->where('c.breadcrumb', $cat2_bread)->where('c.cat_level', 2)->first();

                        // if (empty($res_cat2->category_id)) {
                        //     $res_cat2 = $this->addSecondLevelCategory($item->cat1, $res_cat, $cat2_bread);
                        // }

                        // $second_level_cat = $res_cat2->category_id;

                        $res_cat2 = DB::table('vendor_categories as vc')
                            ->select('c.*')
                            ->join('categories as c', 'c.category_id', 'vc.map_with')->where('vc.category_name', $item->cat1)->where('vc.vendor_id', $vendor_id)->first();

                        $params_category[1]['category_id'] = $res_cat2->category_id;
                        $params_category[1]['category_value'] = $res_cat2->title;
                        $params_category[1]['product_id'] = $product_id;
                    }

                    if (!empty($item->cat2)) {
                        //     $category3 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat2));
                        //     $category3 = str_replace("&-", '-', $category3);
                        //     $category3 = str_replace("--", '-', $category3);
                        //     $category3 = str_replace("--", '-', $category3);
                        //     $category3 = rtrim($category3, '-');

                        //     $cat3_bread = $category . '-' . $category2 . '-' . $category3;
                        //     $res_cat3 = DB::table('categories as c')->where('c.breadcrumb', $cat3_bread)->where('c.cat_level', 3)->first();

                        //     if (empty($res_cat3->category_id)) {
                        //         $res_cat3 = $this->addThirdLevelCategory($item->cat2, $res_cat, $res_cat2, $cat3_bread);
                        //     }

                        //     $third_level_cat = $res_cat3->category_id;

                        $res_cat3 = DB::table('vendor_categories as vc')
                            ->select('c.*')
                            ->join('categories as c', 'c.category_id', 'vc.map_with')->where('vc.category_name', $item->cat2)->where('vc.vendor_id', $vendor_id)->first();

                        $params_category[2]['category_id'] = $res_cat3->category_id;
                        $params_category[2]['category_value'] = $res_cat3->title;
                        $params_category[2]['product_id'] = $product_id;
                    }

                    if (!empty($item->cat3)) {
                        //     $category4 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat3));
                        //     $category4 = str_replace("&-", '-', $category4);
                        //     $category4 = str_replace("--", '-', $category4);
                        //     $category4 = str_replace("--", '-', $category4);
                        //     $category4 = rtrim($category4, '-');

                        //     $cat4_bread = $category . '-' . $category2 . '-' . $category3 . '-' . $category4;
                        //     $res_cat4 = DB::table('categories as c')->where('c.breadcrumb', $cat4_bread)->where('c.cat_level', 4)->first();

                        //     if (empty($res_cat4->category_id)) {
                        //         $res_cat4 = $this->addFourthLevelCategory($item->cat3, $res_cat, $res_cat2, $res_cat3, $cat4_bread);
                        //     }

                        //     $fourth_level_cat = $res_cat4->category_id;

                        $res_cat4 = DB::table('vendor_categories as vc')
                            ->select('c.*')
                            ->join('categories as c', 'c.category_id', 'vc.map_with')->where('vc.category_name', $item->cat2)->where('vc.vendor_id', $vendor_id)->first();

                        $params_category[3]['category_id'] = $res_cat4->category_id;
                        $params_category[3]['category_value'] = $res_cat4->title;
                        $params_category[3]['product_id'] = $product_id;
                    }


                    DB::table('product_categories')->insert($params_category);

                    if (!empty($vendor_child_id)) {
                        $vendor_child_products = [];
                        $vendor_child_products['vendor_child_id'] = $vendor_child_id;
                        $vendor_child_products['product_id'] = $product_id;
                        $vendor_child_products['vendor_id'] = $vendor_id;

                        DB::table('vendor_child_products')->insert($vendor_child_products);
                    }
                }
            }

            DB::table('vendor_phillipspets')
                ->whereIn('upc1', $sync_upcs)
                ->orWhereIn('upc2', $sync_upcs)
                ->update(['status' => 'sync']);

            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product Added Successfully';
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        }

        return $response;
    }

    public function uploadProductsCategoriesByApi($items, $vendor_id)
    {
        // VALIDATE API STRUCTURE

        DB::beginTransaction();

        try {
            foreach ($items as $key => $item) {

                $category = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->primary_animal));
                $category = str_replace("&-", '-', $category);
                $category = str_replace("--", '-', $category);
                $category = str_replace("--", '-', $category);
                $category_bread = rtrim($category, '-');


                $check_dup_cat =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread)->where('vc.vendor_id', $vendor_id)->first();
                $category_name = $item->primary_animal;


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


                $category_1 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat1));
                $category_1 = str_replace("&-", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_bread_1 = rtrim($category_1, '-');
                $category_bread_1 = $category_bread . '-' . $category_bread_1;


                $check_dup_cat_1 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_1)->where('vc.vendor_id', $vendor_id)->first();
                $category1_name = $item->cat1;


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

                $category_2 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat2));
                $category_2 = str_replace("&-", '-', $category_2);
                $category_2 = str_replace("--", '-', $category_2);
                $category_2 = str_replace("--", '-', $category_2);
                $category_bread_2 = rtrim($category_2, '-');
                $category_bread_2 = $category_bread_1 . '-' . $category_bread_2;


                $check_dup_cat_2 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_2)->where('vc.vendor_id', $vendor_id)->first();
                $category2_name = $item->cat2;


                if (empty($check_dup_cat_2)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category2_name;
                    $add_category['category_breadcrumb'] =  $category_bread_2;
                    $add_category['vendor_id'] =  $vendor_id;

                    DB::table('vendor_categories')->insert($add_category);
                } else {
                    $category_bread_2 = $check_dup_cat_2->category_breadcrumb;
                    $category2_name = $check_dup_cat_2->category_name;
                }


                $category_3 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $item->cat3));
                $category_3 = str_replace("&-", '-', $category_3);
                $category_3 = str_replace("--", '-', $category_3);
                $category_3 = str_replace("--", '-', $category_3);
                $category_bread_3 = rtrim($category_3, '-');
                $category_bread_3 = $category_bread_2 . '-' . $category_bread_3;
                $category_bread_3 = rtrim($category_bread_3, '-');

                $check_dup_cat_3 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_3)->where('vc.vendor_id', $vendor_id)->first();
                $category3_name = $item->cat3;

                if (empty($check_dup_cat_3)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category3_name;
                    $add_category['category_breadcrumb'] =  $category_bread_3;
                    $add_category['vendor_id'] =  $vendor_id;

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
}
