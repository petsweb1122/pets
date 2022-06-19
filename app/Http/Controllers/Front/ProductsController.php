<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\ViewComposingController;
use App\Models\ProductModel;
// use App\Models\CategoryModel;

class ProductsController extends ViewComposingController
{

    public function getSingleProductDetails($bread, $id, ProductModel $obj_product){


        $product = $obj_product->getSingleProductDetail($bread, $id);

        if(empty($product)){
            abort(404);
        }

        $product_releateds = $obj_product->getReleatedProductsDetailPage($product->product_id);


        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        $this->viewData['product'] = $product;
        $this->viewData['product_releateds'] = $product_releateds;

        return $this->buildTemplate('single-product');

    }

}

