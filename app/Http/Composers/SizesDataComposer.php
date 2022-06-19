<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\Pagination;
use App\Models\SizeModel;

class SizesDataComposer {

    public function compose(View $view) {

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;

        $objSize = new SizeModel();

        $sizes = $objSize->getAllSizesCount();
        
        $params = array(
            'page' => $page_param,
            'rows' => 15
        );

        $paginations = Pagination::getPaginationLinks($sizes, $page, request()->url(), $params['rows']);

        $sizeObjs = $objSize->getAllSizesFullColums($params);
        
        $view->with('sizeObjs', !empty($sizeObjs) ? $sizeObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($sizes) ? $paginations : []);
    }

}
