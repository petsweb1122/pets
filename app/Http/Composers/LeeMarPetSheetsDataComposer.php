<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class LeeMarPetSheetsDataComposer
{

    public function compose(View $view)
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'leemarpet')->first();

        $vendor_id = $getVendorId->vendor_id;
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'LeeMarPet';
            $insert_vendor['breadcrumb'] = 'leemarpet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $synced_products = DB::table('products as p')->where('p.vendor_id', $vendor_id)->count();

        // $obj_log = DB::table('upload_product_logs as upl')->where('upl.vendor_id',$vendor_id)->where('upl.uploaded_by', 'By Sheets')->first();
        $count_unsynced = DB::table('vendor_leemarpets as vl')->where('vl.status','not_sync')->count();
        $total_products = DB::table('vendor_leemarpets as vl')->count();

        $not_synced = $count_unsynced - $synced_products;

        $view->with('synced_products', !empty($synced_products) ? $synced_products : 0)
            ->with('total_api_products', !empty($total_products) ? $total_products : 0)
            ->with('not_synced_products', !empty($count_unsynced) ? $count_unsynced : 0);
    }
}
