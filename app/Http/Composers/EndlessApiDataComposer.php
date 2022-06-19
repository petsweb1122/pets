<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class EndlessApiDataComposer
{

    public function compose(View $view)
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'endless-aisles')->first();

        $vendor_id = $getVendorId->vendor_id;

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'Endless Aisles';
            $insert_vendor['breadcrumb'] = 'endless-aisles';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }



        $synced_products = DB::table('vendor_endless as ve')->where('ve.status','synced')->count();
        $not_synced = DB::table('vendor_endless as ve')->where('ve.status','not-synced')->count();

        $total_api_products = DB::table('vendor_endless as ve')->count();

        $view->with('synced_products', !empty($synced_products) ? $synced_products : 0)
            ->with('total_api_products', !empty($total_api_products) ? $total_api_products : 0)
            ->with('not_synced_products', !empty($not_synced) ? $not_synced : 0);
    }
}
