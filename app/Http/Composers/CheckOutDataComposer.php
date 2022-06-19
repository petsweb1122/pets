<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use DB;

class CheckOutDataComposer {

    public function compose(View $view) {

        $states  = DB::table('shipping_taxes as t')->groupBy('t.regin_name')->get()->toArray();

        $state_names = array();

        foreach ($states as $key => $state) {
            $state_names[str_replace(' ', '-', $state->regin_name)] = $state->regin_name . ' -  ' . $state->state_name ;
        }

        $view->with('state_names', $state_names);

    }

}
