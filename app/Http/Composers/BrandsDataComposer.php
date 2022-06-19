<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\Pagination;
use App\Models\BrandModel;

class BrandsDataComposer {

    public function compose(View $view) {

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;

        $objBrand = new BrandModel();

        $brands = $objBrand->getAllBrandsCount();

        $params = array(
            'page' => $page_param,
            'rows' => 25
        );

        $paginations = Pagination::getPaginationLinks($brands, $page, request()->url(), $params['rows']);

        $brandObjs = $objBrand->getAllBrandsFullColums($params);

        $view->with('brandObjs', !empty($brandObjs) ? $brandObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($brands) ? $paginations : []);
    }

}
