<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\CategoryModel;

class ShopByCategoryDataComposer {

    public function compose(View $view) {

        $obj_cat = new CategoryModel();

        $catObjs = $obj_cat->getShopByCategoryData();

        $view->with('categories', !empty( $catObjs) ?  $catObjs : []);
    }

}
