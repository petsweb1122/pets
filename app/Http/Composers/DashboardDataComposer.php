<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class DashboardDataComposer
{

    public function compose(View $view)
    {


        $products_by_vcount = DB::table('products as p')->select('v.title', 'v.breadcrumb', DB::raw('count(*) as total'))
            ->join('vendors as v', 'v.vendor_id', 'p.vendor_id')
            ->groupBy('p.vendor_id')->get()->toArray();


        $total_parent_vendors = DB::table('vendors as v')->count();
        $total_childs_vendors = DB::table('vendor_childs as vc')->count();
        $total_categories = DB::table('categories')->count();
        $total_brands = DB::table('brands')->count();

        $product_with_images = DB::table('products as p')->join('images as i', 'i.object_id', 'p.product_id')->where('i.object_type','product')->count();
        $product_without_images = DB::table('products as p')->count()  - $product_with_images;

        $view->with('vendor_product_count', !empty($products_by_vcount) ? $products_by_vcount : 0)
            ->with('child_vendors', $total_childs_vendors)
            ->with('total_categories', $total_categories)
            ->with('total_brands', $total_brands)
            ->with('product_without_images', $product_without_images)
            ->with('product_with_images', $product_with_images)
            ->with('parent_vendors', $total_parent_vendors);
    }
}
