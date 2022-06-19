<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\ProductModel;
use App\Helpers\Pagination;

class AllProductsDataComposer {

    public function compose(View $view) {
        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;

        $objProduct = new ProductModel();
        $products_count = $objProduct->getAllProductsCount();

        $params = array(
            'page' => $page_param,
            'rows' => 30
        );

        $paginations = Pagination::getPaginationLinks($products_count, $page, request()->url(), $params['rows']);

        $product_results= $objProduct->getAllProductsFullColums($params);

        $view->with('products', !empty($product_results) ? $product_results : []);
        $view->with('pagination', !empty($paginations) && !empty($products_count) ? $paginations : []);

    }

}
