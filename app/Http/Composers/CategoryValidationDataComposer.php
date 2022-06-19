<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;
use App\Helpers\Pagination;
use App\Models\CategoryModel;

class CategoryValidationDataComposer
{

    public function compose(View $view)
    {


        request()->show_type;

        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;
        $objCategory = new CategoryModel();

        $categories = $objCategory->getAllValidationCategories(request()->show_type, request()->vendor_id);

        $params = array(
            'page' => $page_param,
            'rows' => 25
        );

        $paginations = Pagination::getPaginationLinks(count($categories), $page, request()->url(), $params['rows']);

        $catObjs = $objCategory->getAllValidationCategoriesFullColums($params, request()->show_type , request()->vendor_id);


        $vendor_obj = DB::table('vendors as v')->where('v.vendor_id', request()->vendor_id)->first();

        $vendor_categories_mapped = DB::table('vendor_categories as vc')
        ->select('vc.vendor_id' ,  DB::raw('count(pets_vc.vendor_id) as `count`'))
        ->groupBy('vc.vendor_id')->where('vc.map_with', '!=', null)->where('vc.vendor_id', request()->vendor_id)->first();

        $vendor_categories_not_mapped = DB::table('vendor_categories as vc')
        ->join('vendors as v', 'v.vendor_id', 'vc.vendor_id')
        ->select('vc.vendor_id' , 'v.title' , DB::raw('count(pets_vc.vendor_id) as `count`'))
        ->groupBy('vc.vendor_id')->where('vc.map_with', '=', null)->where('vc.vendor_id', request()->vendor_id)->first();


        $view->with('vendor_obj', !empty($vendor_obj) ? $vendor_obj : []);
        $view->with('vendor_categories_mapped_count', !empty($vendor_categories_mapped->count) ? $vendor_categories_mapped->count : 0);
        $view->with('vendor_categories_not_mapped_count', !empty($vendor_categories_not_mapped->count) ? $vendor_categories_not_mapped->count : 0);

        $view->with('categories', !empty($categories) ? $categories : []);
        $view->with('catObjs', !empty($catObjs) ? $catObjs : []);
        $view->with('pagination', !empty($paginations) && !empty($categories) ? $paginations : []);
    }
}
