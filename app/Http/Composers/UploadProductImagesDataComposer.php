<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\ProductModel;
use App\Models\ImageModel;

class UploadProductImagesDataComposer
{

    public function compose(View $view)
    {
        $objProduct = new ProductModel();
        $objImageModel = new ImageModel();

        $product_id = request()->product_id;
        $single_product = $objProduct->getSingleProductById($product_id);
        if (!empty($single_product)) {
            $all_images = $objImageModel->getImagesAgainstProductId($product_id , 's');
        }
        // dd($all_images);
        $view->with('all_images', !empty($all_images)? $all_images :[]);

    }
}
