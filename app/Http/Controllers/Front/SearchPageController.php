<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\ViewComposingController;
use App\Models\CategoryModel;

class SearchPageController extends ViewComposingController
{

    public function getShop(){

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('shop');

    }

    public function getSearchPage(CategoryModel $obj_cat){

        $check_title = $obj_cat->getCategoryIdAndLevelByTitle(request()->cat_title);

        if(empty($check_title)){
            abort('404');
        }

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('shop');

    }

}

