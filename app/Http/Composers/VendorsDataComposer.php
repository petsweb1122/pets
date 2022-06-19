<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\Pagination;
use App\Models\VendorModel;

class VendorsDataComposer {

    public function compose(View $view) {

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;

        $objVendor = new VendorModel();

        $vendors = $objVendor->getAllVendorsCount();

        $params = array(
            'page' => $page_param,
            'rows' => 15
        );

        $paginations = Pagination::getPaginationLinks($vendors, $page, request()->url(), $params['rows']);

        $vendorObjs = $objVendor->getAllVendorsFullColums($params);

        $view->with('vendorObjs', !empty($vendorObjs) ? $vendorObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($vendors) ? $paginations : []);
    }

}
