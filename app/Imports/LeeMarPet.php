<?php


namespace App\Imports;

use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Helpers\ImageHelper;
use App\Models\ImageModel;
use App\Models\LeeMarPetModel;

class LeeMarPet
{
    private $errors = [];

    public function getSyncUploadPendingSheetRows($vendor_id, $numbers)
    {

        $logs_data = [];

        $lee_products = DB::table('vendor_leemarpets as l')->where('l.status', 'not_sync')->take($numbers)->get();

        DB::beginTransaction();
        try {
            foreach ($lee_products as $key => $product) {

                $check_dup_pro = DB::table('products as p')->join('product_variations as v', 'v.product_id', 'p.product_id')->where('v.variation_upc', $product->upc)->where('p.vendor_id', 5)->first();
                // dd($check_dup_pro);
                // dd($product->brand_name);
                if (!empty($product->brand_name)) {
                    $vendor_child_breadcrumb = strtolower(str_replace([' ', "/", "&", ",", ",-"], '-', $product->brand_name));
                    $vendor_child_breadcrumb = str_replace(".", '-', $vendor_child_breadcrumb);
                    $vendor_child_breadcrumb = str_replace("--", '-', $vendor_child_breadcrumb);
                    $vendor_child_breadcrumb = rtrim($vendor_child_breadcrumb, '-');
                    $brnad_obj = DB::table('brands as b')->where('b.breadcrumb', $vendor_child_breadcrumb)->first();


                    if (empty($brnad_obj->brand_id)) {

                        $b_data = [];
                        $b_data['title'] = $product->brand_name;
                        $b_data['breadcrumb'] = $vendor_child_breadcrumb;
                        DB::table('brands')->insert($b_data);
                        $brand_id = DB::getPdo()->lastInsertId();
                    } else {
                        $brand_id = $brnad_obj->brand_id;
                    }
                }

                if (empty($check_dup_pro)) {



                    $insert_products['title'] = $product->product_name;
                    // $insert_products['external_product_id'] = $item->product_id;
                    $insert_products['description'] = $product->product_desc;
                    // $insert_products['ingredients'] = $product->ingredients;
                    $product_title_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "!", "=", "/", ".", '"', "&", "'", ",", "#"), '-', $product->product_name));
                    $product_title_breadcrumb = str_replace(['---', '--', '--', "+-"], '-', $product_title_breadcrumb);
                    $insert_products['title_breadcrumb'] = rtrim($product_title_breadcrumb, '-');
                    $insert_products['brand'] = !empty($brand_id) ? $brand_id : '';
                    if ($product->p_status == 'Discontinued') {
                        $insert_products['status'] = 'closed';
                    } elseif ($product->p_status == '') {
                        $insert_products['status'] = 'published';
                    }
                    // $insert_products['status'] = 'published';
                    $insert_products['vendor_id'] = $vendor_id;

                    DB::table('products')->insert($insert_products);
                    $product_id = DB::getPdo()->lastInsertId();

                    $size_obj = DB::table('sizes')->where('value', $product->weight)->first();

                    if (!empty($size_obj)) {
                        $size_id = $size_obj->size_id;
                        $size_value = $size_obj->value;
                    } else {
                        DB::table('sizes')->insert(['value' => $product->weight]);
                        $size_value = $product->weight;
                        $size_id = DB::getPdo()->lastInsertId();
                    }

                    $product_variations = [];
                    $product_variations['product_id'] = $product_id;
                    $product_variations['size_id'] = $size_id;
                    $product_variations['v_price'] = !empty($product->price) ? $product->price : $product->price;
                    $product_variations['minimum_advertised_price'] = !empty($product->map_minimum_advertise_price) ? $product->map_minimum_advertise_price : $product->map_minimum_advertise_price;
                    $product_variations['s_price'] = $product_variations['v_price'] * env('PETS_PRODUCT_SALE_PERCENTAGE');
                    $product_variations['variation_upc'] =  $product->upc;
                    $product_variations['product_size'] =  $product->product_size;
                    $product_variations['length'] =  $product->length;
                    $product_variations['width'] =  $product->width;
                    $product_variations['height'] =  $product->height;
                    $product_variations['manufacturer_no'] =  $product->manufacturer_no;
                    $product_variations['variation_quantity'] =  $product->qty_available;
                    $product_variations['variation_sku'] =  $product->sku;
                    $product_variations['type'] = 'simple';

                    DB::table('product_variations')->insert($product_variations);
                    $variation_id = DB::getPdo()->lastInsertId();

                    $product_sizes = [];
                    $product_sizes['product_id'] = $product_id;
                    $product_sizes['variation_id'] = $variation_id;
                    $product_sizes['size_id'] = $size_id;
                    $product_sizes['size_value'] = $size_value;
                    DB::table('product_sizes')->insert($product_sizes);


                    $params_category = [];


                    // $res_cat = DB::table('vendor_categories as vc')
                    //     ->select('c.*')
                    //     ->join('categories as c', 'c.category_id', 'vc.map_with')->where('vc.category_name', $product->pet_type)->where('vc.vendor_id', $vendor_id)->first();

                    $res_cats = DB::table('vendor_categories as vc')
                        ->select('vcc.*', 'c.title as category_title', 'c.breadcrumb')
                        ->join('vendor_categories_to_categories as vcc' , 'vc.id' , 'vcc.vendor_cat_id')
                        ->join('categories as c' , 'c.category_id' , 'vcc.category_id')
                        ->where('vc.vendor_id', $vendor_id)
                        ->where('vc.category_name', $product->pet_type)->groupBy('vcc.category_id')->get();

                    $itr = 0;
                    foreach($res_cats as $cat_obj){

                        $params_category[$itr]['category_id'] = $cat_obj->category_id;
                        $params_category[$itr]['category_value'] = $cat_obj->category_title;
                        $params_category[$itr]['product_id'] = $product_id;
                        $itr++;
                    }

                    $category_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-',$product->pet_type));
                    $category_breadcrumb = str_replace("&-", '-', $category_breadcrumb);
                    $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                    $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                    $category_breadcrumb = rtrim($category_breadcrumb, '-');

                    $cat_breadcrumb = strtolower($product->pet_type);

                    if (!empty($product->category_name)) {

                        $category_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-',$product->category_name));
                        $category_breadcrumb = str_replace("&-", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $category_breadcrumb = str_replace("--", '-', $category_breadcrumb);
                        $cat_breadcrumb = $cat_breadcrumb . '-' . rtrim($category_breadcrumb, '-');

                        $res_cat2 = DB::table('vendor_categories as vc')
                        ->select('vcc.*', 'c.title as category_title', 'c.breadcrumb')
                        ->join('vendor_categories_to_categories as vcc' , 'vc.id' , 'vcc.vendor_cat_id')
                        ->join('categories as c' , 'c.category_id' , 'vcc.category_id')
                        ->where('vc.vendor_id', $vendor_id)
                        ->where('vc.category_name', $product->category_name)
                        ->where('vc.category_breadcrumb' , $cat_breadcrumb)->groupBy('vcc.category_id')->get();


                        foreach($res_cat2 as $cat_obj){

                            $params_category[$itr]['category_id'] = $cat_obj->category_id;
                            $params_category[$itr]['category_value'] = $cat_obj->category_title;
                            $params_category[$itr]['product_id'] = $product_id;
                            $itr++;
                        }
                    }

                    DB::table('product_categories')->insert($params_category);



                    $obj_product = DB::table('products as p')->where('p.product_id', $product_id)->first();

                    $image_helper = new ImageHelper();
                    $time_hash = md5(time() . rand(0, 100));
                    $upload_images =  $image_helper->uploadImageUsingWebUrl($product->product_image_link, 'products', $obj_product, $time_hash);

                    $objImageModel = new ImageModel();

                    $objImageModel->uploadProductImages($upload_images, $product_id);


                    DB::table('vendor_leemarpets')->where('id', $product->id)->update(['status' => 'sync']);
                }
            }


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

    public function getSyncLeemarpetCategories($vendor_id)
    {

        $logs_data = [];

        $lee_products = DB::table('vendor_leemarpets as l')->where('l.status', 'not_sync')->get();


        DB::beginTransaction();

        try {
            foreach ($lee_products as $key => $product) {

                // dd($product);
                $category = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $product->pet_type));
                $category = str_replace("&-", '-', $category);
                $category = str_replace("--", '-', $category);
                $category = str_replace("--", '-', $category);
                $category_bread = rtrim($category, '-');


                $check_dup_cat =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread)->where('vc.vendor_id', $vendor_id)->first();
                $category_name = $product->pet_type;

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


                $category_1 = strtolower(str_replace(array("\r\n", "\r", " ", "'", ",", "/", "#"), '-', $product->category_name));
                $category_1 = str_replace("&-", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_1 = str_replace("--", '-', $category_1);
                $category_bread_1 = rtrim($category_1, '-');
                $category_bread_1 = $category_bread . '-' . $category_bread_1;
                $category_bread_1 = rtrim($category_bread_1, '-');


                $check_dup_cat_1 =  DB::table('vendor_categories as vc')->where('vc.category_breadcrumb', $category_bread_1)->where('vc.vendor_id', $vendor_id)->first();
                $category1_name = $product->category_name;


                if (empty($check_dup_cat_1)) {
                    $add_category = [];
                    $add_category['category_name'] =  $category1_name;
                    $add_category['category_breadcrumb'] =  $category_bread_1;
                    $add_category['vendor_id'] =  $vendor_id;

                    DB::table('vendor_categories')->insert($add_category);
                }
            }


            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product Category Added Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Category Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Category Not Added Successfully Pease Try Again';
        }

        return $response;
    }

    public function uploadSheet($sheet, $vendor_id)
    {

        $theArray = Excel::toArray([], $sheet);


        $lee_products = $theArray[0];
        // dd($lee_products );
        // dd($lee_products[0]);
        unset($lee_products[0]);
        // dd($lee_products);

        // dd($lee_products);
        // DB::beginTransaction();

        try {

            $itr = 0;
            foreach ($lee_products as $key => $product) {
                $data = [];
                // dd($product);
                $check_dup_pro = '';
                if (!empty($product[5])) {
                    $check_dup_pro =  DB::table('vendor_leemarpets as l')->where('l.upc', $product[5])->first();
                }
                // dd($check_dup_pro);
                if (empty($product[5])) {
                    $check_dup_pro = DB::table('vendor_leemarpets as l')->where('l.manufacturer_no', $product[4])->where('l.sku', $product[0])->first();
                }


                if (empty($check_dup_pro)) {
                    $data[$itr]['sku'] = !empty($product[0]) ? $product[0] : '';
                    $data[$itr]['qty_available'] = !empty($product[1]) ? $product[1] : 0.0;
                    $data[$itr]['price'] = !empty($product[2]) ? $product[2] : 0.0;
                    $data[$itr]['map_minimum_advertise_price'] = !empty($product[3]) ? $product[3] : 0.0;
                    $data[$itr]['manufacturer_no'] = !empty($product[4]) ? $product[4] : '';
                    $data[$itr]['upc'] = !empty($product[5]) ? $product[5] : '';
                    $data[$itr]['amazon_restricted'] = !empty($product[6]) ? $product[6] : '';
                    $data[$itr]['walmart_restricted'] = !empty($product[7]) ? $product[7] : '';
                    $data[$itr]['ebay_restricted'] = !empty($product[8]) ? $product[8] : '';
                    $data[$itr]['weight'] = !empty($product[9]) ? $product[9] : 0.0;
                    $data[$itr]['length'] = !empty($product[10]) ? $product[10] : 0.0;
                    $data[$itr]['width'] = !empty($product[11]) ? $product[11] : 0.0;
                    $data[$itr]['height'] = !empty($product[12]) ? $product[12] : 0.0;
                    $data[$itr]['creation_date'] = !empty($product[13]) ? $product[13] : '';
                    $data[$itr]['p_status'] = !empty($product[14]) ? $product[14] : '';
                    $data[$itr]['pet_type'] = !empty($product[15]) ? $product[15] : '';
                    $data[$itr]['category_name'] = !empty($product[16]) ? $product[16] : '';
                    $data[$itr]['brand_name'] = !empty($product[17]) ? $product[17] : '';
                    $data[$itr]['product_name'] = !empty($product[18]) ? $product[18] : '';
                    $data[$itr]['product_size'] = !empty($product[19]) ? $product[19] : '';
                    $data[$itr]['product_desc'] = !empty($product[20]) ? $product[20] : '';
                    $data[$itr]['product_attr'] = !empty($product[21]) ? $product[21] : '';
                    $data[$itr]['product_position'] = !empty($product[22]) ? $product[22] : '';
                    $data[$itr]['product_image_link'] = !empty($product[23]) ? $product[23] : '';
                    $data[$itr]['status'] = 'not_sync';
                    $itr++;
                }

                if (!empty($data)) {
                    LeeMarPetModel::insert($data);
                }
            }


            // DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product Added Successfully';
        } catch (\Throwable $e) {
            dd($e);
            // DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            dd($e);
            // DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        }

        return $response;
    }

    private function addFirstLevelCategory($title)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $level_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $title));
        $level_bread = str_replace('--', '-', $level_bread);
        $data['breadcrumb'] = $level_bread;
        $data['cat_level'] = 1;

        DB::table('categories')->insert($data);
        $cat_id = DB::getPdo()->lastInsertId();

        $cat_res = DB::table('categories as c')->where('category_id', $cat_id)->first();

        return $cat_res;
    }

    private function addSecondLevelCategory($title, $first_level_cat)
    {

        $data = [];

        $data['title'] = ucwords(strtolower($title));
        $level_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $title));
        $level_bread = str_replace('--', '-', $level_bread);
        $data['breadcrumb'] = $first_level_cat->breadcrumb . '-' . $level_bread;
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
