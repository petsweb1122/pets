<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;
use App\Helpers\Pagination;
use App\Models\CategoryModel;

class SingleCategoryValidationDataComposer
{

    public function compose(View $view)
    {


        $objCategory = new CategoryModel();
        $categories = $objCategory->getAllCategoriesForParentCategory();

        $cur_obj = $objCategory->getCurrentCategory(request()->cat_id, request()->vendor_id);

        $view->with('categories', !empty($categories) ? $categories : []);
        $view->with('cat_obj', !empty($cur_obj) ? $cur_obj : []);

    }
}
