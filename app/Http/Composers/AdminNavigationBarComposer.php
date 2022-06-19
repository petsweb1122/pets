<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class AdminNavigationBarComposer
{

    public function compose(View $view)
    {

        $vendor_categories = DB::table('vendor_categories as vc')
        ->join('vendors as v', 'v.vendor_id', 'vc.vendor_id')
        ->select('vc.vendor_id' , 'v.title' , DB::raw('count(pets_vc.vendor_id) as `count`'))
        ->groupBy('vc.vendor_id')->get();

        $userData = json_decode(session()->get('user_data'));

        view()->share('user_data', $userData);
        view()->share('vendor_categories', $vendor_categories);
    }
}
