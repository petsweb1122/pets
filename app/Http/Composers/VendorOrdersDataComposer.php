<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Helpers\Pagination;
use App\Models\OrderModel;

class VendorOrdersDataComposer {

    public function compose(View $view) {

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;

        $objOrder = new OrderModel();

        $orders = $objOrder->getAllVendorOrdersCount();
        // dd($orders );
        $params = array(
            'page' => $page_param,
            'rows' => 30
        );

        $paginations = Pagination::getPaginationLinks($orders, $page, request()->url(), $params['rows']);

        $orderObjs = $objOrder->getAllVenodrOrdersFullColums($params);


        $view->with('orderObjs', !empty($orderObjs) ? $orderObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($orders) ? $paginations : []);
    }

}
