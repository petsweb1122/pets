<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\CategoryModel;

class NavigationsDataComposer {

    public function compose(View $view) {

        $cat_obj = new CategoryModel();

        $top_navigations = $cat_obj->getTopNavLinks();

        $view->with('top_navigations', !empty( $top_navigations ) ?  $top_navigations : []);
    }

}
