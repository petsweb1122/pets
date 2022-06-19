<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\CategoryModel;
use App\Helpers\BreadCrumb;

class BreadCrumbDataComposer {

    public function compose(View $view) {

        $breadCrumb = [];
        $breadCrumb_details = [];
        if(!empty(request()->cat_title)){
            $objCategory = new CategoryModel();
            $category_name  = request()->cat_title;

            $result_cat = $objCategory->getCategoriesByName($category_name);

            if(!empty($result_cat)){
                $obj_bread_helper = new BreadCrumb();
                $breadCrumb = $obj_bread_helper->getSearchBreadCrumb($result_cat);
            }

        }
        if(!empty(request()->product_id)){
            $obj_bread_helper = new BreadCrumb();
            $breadCrumb_details = $obj_bread_helper->getDetailBreadCrumb(request()->product_id);
        }

        // dd($breadCrumb_details);
        $view->with('breadCrumb',$breadCrumb)
        ->with('breadCrumb_details', $breadCrumb_details);
    }

}
