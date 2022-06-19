<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ImageModel extends Model
{

    protected $table = 'images';


    public function uploadProductImages($upload_images, $product_id)
    {

        $response = [];
        $add_image_data = [];
        $add_image_size_data = [];
        $number = 0;

        DB::beginTransaction();

        try {

            $add_image_data['object_type'] = 'product';
            $add_image_data['object_id'] = $product_id;
            $get_product = DB::table($this->table)->where('object_id', $product_id)->where('object_type', 'product')->first();
            if (!empty($get_product)) {
                $image_id = $get_product->id;

                $get_max_number = DB::table('images_sizes as is')->where('is.object_type', 'product')->where('is.image_id', $image_id)->max('is.image_number');
                $number = $get_max_number;
            } else {
                DB::table($this->table)->insert($add_image_data);
                $image_id = DB::getPdo()->lastInsertId();
                $number = 0;
            }

            $number = !empty($number) ? $number : 0;
            $itr = 0;
            foreach ($upload_images as $images) {
                $number++;
                foreach ($images as $size => $image) {
                    $add_image_size_data[$itr]['object_type'] = 'product';
                    $add_image_size_data[$itr]['object_id'] =  $image['object_id'];
                    $add_image_size_data[$itr]['image_id'] = $image_id;
                    $add_image_size_data[$itr]['image_name'] = $image['name'];
                    $add_image_size_data[$itr]['folder_name'] = $image['folder_name'];
                    $add_image_size_data[$itr]['image_number'] = $number;
                    $add_image_size_data[$itr]['size_number'] = $size;
                    $itr++;
                }
            }
            DB::table('images_sizes')->insert($add_image_size_data);
            DB::commit();

            $response['status'] = 200;
            $response['message'] = 'Images Successfully Uploaded';
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Images not Uploaded, Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Product Images not Uploaded, Pease Try Again';
        }

        return $response;
    }


    public function uploadUserImage($upload_images, $user_id)
    {

        $add_image_data = [];
        $add_image_size_data = [];



        $add_image_data['object_type'] = 'user';
        $add_image_data['object_id'] = $user_id;

        DB::table($this->table)->insert($add_image_data);
        $image_id = DB::getPdo()->lastInsertId();

        $itr = 0;
        foreach ($upload_images as $images) {

            foreach ($images as $size => $image) {
                $add_image_size_data[$itr]['object_type'] = 'user';
                $add_image_size_data[$itr]['object_id'] =  $user_id;
                $add_image_size_data[$itr]['image_id'] = $image_id;
                $add_image_size_data[$itr]['image_name'] = $image['name'];
                $add_image_size_data[$itr]['image_number'] = 1;
                $add_image_size_data[$itr]['size_number'] = $size;
                $itr++;
            }
        }

        DB::table('images_sizes')->insert($add_image_size_data);
    }


    public function getImagesAgainstProductId($product_id, $sel_size = 'all')
    {

        $images = [];
        $images_results = DB::table('images as i')
        ->join('images_sizes as is', 'i.id', 'is.image_id')
        ->select(['is.*'])
        ->where('i.object_type', 'product')
        ->where('i.object_id', $product_id)
        ->get()->toArray();
        $itr = 0;
        foreach ($images_results as $key => $image) {
            if ($sel_size === 'all') {
                $images[$key]['number'] = $itr;
                $images[$key]['object_id'] = $image->object_id;
                $images[$key]['image'] = url('/products/' . $image->folder_name . '/' . $image->image_name);
                $images[$key]['size'] = $image->size_number;
                $images[$key]['image_number'] = $image->image_number;
            }
            if ($image->size_number == $sel_size) {

                $images[$key]['number'] = $itr;
                $images[$key]['object_id'] = $image->object_id;
                $images[$key]['image'] = url('/products/' . $image->folder_name . '/' . $image->image_name);
                $images[$key]['size'] = $image->size_number;
                $images[$key]['image_number'] = $image->image_number;

            }

            $itr++;
        }

        return $images;
    }
    public function getUserImageByUserId($obj_user)
    {

        $data = [];

        if (!empty($obj_user->user_id)) {
            $images = DB::table('images_sizes as is')->where('object_type', 'user')->where('object_id', $obj_user->user_id)->get()->toArray();
            if(!empty($images)){
                foreach ($images  as $key => $image) {
                    $data[$image->size_number] = url('/users/' . $obj_user->user_name . '/' . $image->image_name);
                }
            }else{
                $data['s'] = url('/users/no_user_image.png');
                $data['m'] = url('/users/no_user_image.png');
                $data['l'] = url('/users/no_user_image.png');
            }

        }
        return $data;

    }
}
