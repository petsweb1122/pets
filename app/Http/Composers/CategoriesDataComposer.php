<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\Pagination;
use App\Models\CategoryModel;

class CategoriesDataComposer {

    public function compose(View $view) {

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;
        $objCategory = new CategoryModel();

        $categories = $objCategory->getAllCategoriesForParentCategory();
        $params = array(
            'page' => $page_param,
            'rows' => 15
        );

        $paginations = Pagination::getPaginationLinks(count($categories), $page, request()->url(), $params['rows']);

        $catObjs = $objCategory->getAllCategoriesFullColums($params);

        $view->with('categories', !empty($categories) ? $categories : []);
        $view->with('catObjs', !empty($catObjs) ? $catObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($categories) ? $paginations : []);
    }

}
