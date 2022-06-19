<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Helpers\Pagination;

class ShopDataComposer
{

    public function compose(View $view)
    {

        $obj_cat = new CategoryModel();
        $obj_product = new ProductModel();


         // dd('UserModel');
         $page = !empty(request()->get('page')) ? request()->get('page') : 1;
         $page_param = $page - 1;


         $params = array(
             'page' => $page_param,
             'rows' => 60
         );


         if(!empty(request()->query('sort')) && request()->query('sort') == 'asc'){
            request()->merge(['sort' => 'asc']);
         }else if(!empty(request()->query('sort')) && request()->query('sort') == 'desc'){

         }

        $query_params = request()->query();
        //  dd($query_params);
        $query_string_link = '?';
        $query_string_desc = '?';
        if(!empty($query_params)){
            foreach($query_params as $k => $val){
                $query_string_link .=   "$k=$val&";
            }
            $query_string_link = rtrim($query_string_link, '&');

            $query_string_link = str_replace('&sort=asc', '', $query_string_link);
            $query_string_link = str_replace('&sort=desc', '', $query_string_link);

            $query_string_asc = request()->url() . $query_string_link .  '&sort=asc';
            $query_string_desc = request()->url() .  $query_string_link .  '&sort=desc';

        }else{
            $query_string_asc = request()->url() .  '?sort=asc';
            $query_string_desc = request()->url() .  '?sort=desc';
        }

        $left_cat_navigations = $obj_cat->getLeftCatNavLinks();

        $cat_data  = $obj_cat->getCategoryIdAndLevelByTitle(request()->cat_title);

        $products = $obj_product->getSearchPageProducts($cat_data,$params);
        $paginations = Pagination::getFrontPaginationLinks($products['total_results'], $page, request()->url(), $params['rows']);

        //  dd($paginations);

        $view->with('left_cat_navigations', !empty($left_cat_navigations) ?  $left_cat_navigations : [])
            ->with('product_results', $products['results'])
            ->with('paginations', $paginations)
            ->with('link_sort_asc', $query_string_asc)
            ->with('link_sort_desc', $query_string_desc)
            ->with('total_count', $products['total_results']);
    }
}
