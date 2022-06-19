<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cache;
use App\Helpers\Common;
use App\Models\CategoryModel;
use App\Models\ProductVariationModel;

class ProductModel extends Model
{

    protected $table = 'products';


    public function getAllProductsFullColums($params = [])
    {

        $user_data = json_decode(session()->get('user_data'));



        $results = DB::table('products as p')->select(['p.*', 'v.title as vendor_title'])
            ->join('vendors as v', 'v.vendor_id', 'p.vendor_id');

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $data = $results
            ->when(($user_data->role == 'vendor'), function ($q) use ($user_data) {
                // dd($user_data);
                $q->where('p.vendor_id' , $user_data->vendor_id);

            })
            ->skip($skip_val)
            ->take($take)
            ->get()
            ->toArray();

        return $data;
    }

    public function addProduct($data)
    {

        // dd($data);
        $response = [];
        $add_product_data = [];
        $add_product_data['title'] = $data['title'];
        $add_product_data['title_breadcrumb'] = $data['title_breadcrumb'];
        $add_product_data['description'] = $data['description'];
        $add_product_data['ingredients'] = $data['ingredients'];
        $add_product_data['brand'] = $data['all_brands'];
        $add_product_data['vendor_id'] = $data['all_vendors'];
        $add_product_data['status'] = $data['status'];

        $response['data'] = [];
        DB::beginTransaction();

        try {

            // Add data in Product Table
            DB::table($this->table)->insert($add_product_data);
            $product_id = DB::getPdo()->lastInsertId();

            // dd( $data);

            $p_variations = $data['variation_sizes'];
            $obj_variations = new ProductVariationModel();
            $obj_variations->addVariationProducts($p_variations, $product_id);

            $p_categories = $data['all_categories'];

            $obj_categories = new CategoryModel();
            $cache_categories = $obj_categories->getCategoryDropdowns();

            $catePro = [];
            foreach ($p_categories as $key => $cate) {
                $catePro[$key]['product_id']  = $product_id;
                $catePro[$key]['category_id']  = $cate;
                $catePro[$key]['category_value']  = $cache_categories[$cate];
            }

            DB::table('product_categories')->insert($catePro);

            DB::commit();

            $response['status'] = 200;
            $response['message'] = 'Product Added Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        }

        return $response;
    }


    public function updateProduct($data, $product_obj)
    {

        $add_sizes = json_decode(session()->get('add_sizes'), 1);
        // dd($add_sizes);
        $response = [];
        $product_data = [];
        $product_data['title'] = $data['title'];
        $product_data['title_breadcrumb'] = $data['title_breadcrumb'];
        $product_data['description'] = $data['description'];
        $product_data['ingredients'] = $data['ingredients'];
        $product_data['status'] = $data['status'];
        $product_data['brand'] = $data['all_brands'];
        $product_data['vendor_id'] = $data['all_vendors'];

        $response['data'] = [];

        DB::beginTransaction();
        try {
            // Update data in Product Table
            DB::table($this->table)->where('product_id', $product_obj->product_id)
                ->update($product_data);

            $product_id = $product_obj->product_id;


            $variations = DB::table('product_variations as pv')->where('pv.product_id', $product_id)->get();


            $sizes_data = [];

            foreach($variations as $variation){

                $variations_data = [];
                $variations_data['variation_sku'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_sku'];
                $variations_data['variation_upc'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_upc'];
                $variations_data['variation_quantity'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_qty'];
                $variations_data['manufacturer_no'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_mfn'];
                $variations_data['v_price'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_vprice'];
                $variations_data['s_price'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_sprice'];
                $variations_data['r_price'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_rprice'];
                $variations_data['type'] = (count($add_sizes) > 1) ? 'variation' : 'simple';
                $variations_data['sale'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_sale'];
                $variations_data['length'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_length'];
                $variations_data['width'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_width'];
                $variations_data['height'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_height'];
                $variations_data['product_size'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_product_size'];
                $variations_data['discount_percent'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_discount_percent'];
                $variations_data['discount_price'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_discount_price'];
                $variations_data['discount_apply'] = $data['variation_sizes'][$variation->size_id]['size_' .$variation->size_id . '_discount_apply_on'];
                // dd($variation);

                $update = DB::table('product_variations')->where('variation_id' , $variation->variation_id)->update($variations_data);

                $sizes_data[$variation->size_id] = $variation->size_id;
                // unset($add_sizes[$variation->size_id]);

            }

            $rem_sizes = array_diff( $add_sizes, $sizes_data);
            // dd($rem_sizes);


            foreach ($rem_sizes as $key => $size_id) {
                $variations_data = [];
                // dd($data);
                $variations_data['variation_sku'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_sku'];
                $variations_data['variation_upc'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_upc'];
                $variations_data['variation_quantity'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_qty'];
                $variations_data['manufacturer_no'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_mfn'];
                $variations_data['v_price'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_vprice'];
                $variations_data['s_price'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_sprice'];
                $variations_data['r_price'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_rprice'];
                $variations_data['type'] = (count($add_sizes) > 1) ? 'variation' : 'simple';
                $variations_data['sale'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_sale'];
                $variations_data['length'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_length'];
                $variations_data['width'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_width'];
                $variations_data['height'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_height'];
                $variations_data['product_size'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_product_size'];
                $variations_data['discount_percent'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_discount_percent'];
                $variations_data['discount_price'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_discount_price'];
                $variations_data['discount_apply'] = $data['variation_sizes'][$size_id]['size_' .$size_id . '_discount_apply_on'];
                $variations_data['product_id'] = $product_id;
                $variations_data['size_id'] = $size_id;

                $insert = DB::table('product_variations')->insert($variations_data);

            }

            $p_categories = $data['all_categories'];

            $obj_categories = new CategoryModel();

            $cache_categories = $obj_categories->getCategoryDropdowns();

            $catePro = [];
            foreach ($p_categories as $key => $cate) {
                $catePro[$key]['product_id']  = $product_id;
                $catePro[$key]['category_id']  = $cate;
                $catePro[$key]['category_value']  = $cache_categories[$cate];
            }

            DB::table('product_categories')->where('product_id', $product_id)->delete();
            DB::table('product_categories')->insert($catePro);

            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product Updated Successfully';
        } catch (\Throwable $e) {
            // dd($e);
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not updated  Please Try Again';
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not Added Successfully Pease Try Again';
        }

        return $response;
    }


    public function getProductSizesData($sizes, $product_id)
    {

        $sizes_data = [];

        $itr = 0;
        foreach ($sizes as $size_id => $cloth_sizes) {

            foreach ($cloth_sizes as $cs_id =>  $cs_value) {
                $sizes_data[$itr]['product_id'] = $product_id;
                $sizes_data[$itr]['size_id'] = $size_id;
                $sizes_data[$itr]['cloth_size_id'] = $cs_id;
                $sizes_data[$itr]['cloth_size_value'] = $cs_value;
                $itr++;
            }
        }

        return $sizes_data;
    }


    public function getAllProductsCount()
    {
        // dd(session()->get('user_data'));
        $user_data = json_decode(session()->get('user_data'));

        return DB::table($this->table)
        ->when(($user_data->role == 'vendor'), function ($q) use ($user_data) {
            // dd($user_data);
            $q->where('vendor_id' , $user_data->vendor_id);

        })
        ->count();
    }

    public function getAllProducts()
    {
        $results = DB::table($this->table)->get();
        return $results;
    }

    public function getSingleProductById($id)
    {
        $results = DB::table($this->table)->where('product_id', $id)->first();
        return $results;
    }

    public function getSingleProductFullDetailsById($id)
    {
        $results = DB::table($this->table)->where('product_id', $id)->first();

        $cat_ids = DB::table('product_categories as pc')->where('pc.product_id', $id)->get()->pluck('category_id')->toArray();
        $results->cat_ids = $cat_ids;

        $variations = DB::table('product_variations as pv')->where('pv.product_id', $id)->get()->toArray();
        $results->variations = $variations;

        return $results;
    }

    public function deleteProductById($id)
    {

        $response = [];
        DB::beginTransaction();

        try {
            $product_obj = DB::table($this->table)->where('product_id', $id)->first();

            $image_id = DB::table('images as i')->where('i.object_type', 'product')->where('i.object_id', $id)->first();

            if (!empty($image_id)) {
                $image_sizes = DB::table('images_sizes as is')->where('is.image_id', $image_id->id)->get();
                DB::table('images_sizes')->where('image_id', $image_id->id)->delete();
                DB::table('images')->where('id', $image_id->id)->delete();
            }

            DB::table($this->table)->where('product_id', $id)->delete();
            DB::table('product_categories')->where('product_id', $id)->delete();

            if (!empty($image_id)) {
                $folder_name = $id . '_' . $product_obj->p_upc;
                foreach ($image_sizes as $image) {
                    if (file_exists(public_path('/') . "products/$folder_name/$image->image_name")) {
                        unlink(public_path('/') . "products/$folder_name/$image->image_name");
                    }
                }
            }

            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Product deleted Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not delete  Please Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Not delete  Please Try Again';
        }

        return $response;
    }


    public function getSearchPageProducts($cat_obj = '', $params)
    {
        $data = [];
        // dd(request()->all());
        $results = DB::table('products as p')->select('p.*', 'pv.*')
        ->join('product_variations as pv', 'pv.product_id' , 'p.product_id')
            ->join('product_categories as pc', 'pc.product_id', 'p.product_id')
            ->join('categories as c', 'c.category_id', 'pc.category_id')
            ->when(!empty($cat_obj), function ($q) use ($cat_obj) {
                $level = $cat_obj->cat_level; //488
                $q->where(function($q) use($level , $cat_obj){
                    $q->where('c.cat_' . $level, $cat_obj->category_id)->orWhere('c.category_id', $cat_obj->category_id);
                });

            })
            ->when(!empty(request()->get('q')), function ($q) {
                $q->where('p.title', 'like', '%'.request()->get('q').'%');
            })
            ->when(!empty(request()->get('keyword')), function ($q) {
                $q->where('p.description', 'like', '%'.request()->get('keyword').'%');
            })
            ->when(!empty(request()->get('upc')), function ($q) {
                // dd(request()->get('upc'));
                $q->where('pv.variation_upc', request()->get('upc'));
            })
            ->when(!empty(request()->get('min_price')), function ($q) {
                $q->where('pv.s_price', '>=', request()->get('min_price'));
            })
            ->when(!empty(request()->get('max_price')), function ($q) {
                $q->where('pv.s_price', '<=', request()->get('max_price'));
            })
            ->where('p.status', 'published')
            ->when(!empty(request()->sort), function ($q) {
                $price_filter = (request()->sort == 'asc') ? 'ASC' : 'DESC';
                $q->orderBy('pv.s_price', $price_filter);
            })
            ->groupBy('p.product_id');

        $total_results = $results->get()->count();

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;


        $data['results'] =    $results->skip($skip_val)->take($take)
            ->get();
        foreach ($data['results'] as $key => $product) {
            $image = DB::table('images as i')
                ->join('images_sizes as is', 'i.id', 'is.image_id')
                ->where('is.object_type', 'product')
                ->where('is.object_id', $product->product_id)
                ->where('is.size_number', 'm')
                ->first();
            $product->image = !empty($image->image_name)  ? url("/products/$image->folder_name/$image->image_name") : '';
        }

        $data['total_results'] = $total_results;

        return $data;
    }

    public function getSingleProductDetail($bread, $id, $size = 'l')
    {

        $product = DB::table('products as p')
        ->select('p.*', 'b.title as brand_title')
        ->join('brands as b', 'b.brand_id' , 'p.brand')
        ->when(!empty($bread) , function($q) use($bread){
            return $q->where('title_breadcrumb', $bread);
        })
        ->where('p.product_id', $id)->first();

        if (empty($product)) {
            return false;
        }

        $variations = DB::table('product_variations as pv')
        ->select('pv.*' , 's.value as size_value')
        ->join('sizes as s', 's.size_id' , 'pv.size_id')
        ->where('pv.product_id', $id)->orderBy('s.value', 'ASC')->get();
        $variation_data = [];
        foreach($variations as $vari){
            $variation_data[$vari->size_value] = $vari;
        }
        $product->variations = $variation_data;
        ksort($product->variations);

        $image = DB::table('images as i')
            ->join('images_sizes as is', 'i.id', 'is.image_id')
            ->where('is.object_type', 'product')
            ->where('is.object_id', $product->product_id)
            ->where('is.size_number', $size)
            ->first();

        $product->image = !empty($image->image_name)  ? url("/products/$image->folder_name/$image->image_name") : url('/img/no_image.png');


        $cat_ids = DB::table('product_categories as pc')->select('c.category_id', 'c.title', 'c.breadcrumb')
            ->join('categories as c', 'c.category_id', 'pc.category_id')
            ->where('pc.product_id', $id)->groupBy('c.category_id')->get()->toArray();

        $product->categories = $cat_ids;

        return $product;
    }

    public function getReleatedProductsDetailPage($id)
    {

        $data = [];

        $c_ids = DB::table('product_categories as pc')->where('pc.product_id', $id)->get()->pluck('category_id')->toArray();



        $results = DB::table('products as p')->select('p.*', 'pv.*')
            ->join('product_variations as pv' , 'pv.product_id' , 'p.product_id')
            ->join('product_categories as pc', 'pc.product_id', 'p.product_id')
            ->whereIn('pc.category_id', $c_ids)
            ->where('p.status', 'published')
            ->groupBy('p.product_id')->take(8)
            ->get();

        foreach ($results as $key => $product) {
            $image = DB::table('images as i')
                ->join('images_sizes as is', 'i.id', 'is.image_id')
                ->where('is.object_type', 'product')
                ->where('is.object_id', $product->product_id)
                ->where('is.size_number', 'l')
                ->first();
            $product->image = !empty($image->image_name)  ? url("/products/$image->folder_name/$image->image_name") : url('/img/no_image.png');
        }

        return $results;
    }

    public function getProductCartPageData($p_ids, $image_size = 'm')
    {

        $data = [];
        $product = $this->getSingleProductDetail('' ,$p_ids, 's');

        return $product;
    }
}
