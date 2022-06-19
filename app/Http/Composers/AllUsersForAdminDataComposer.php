<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\UserModel;
use App\Helpers\Pagination;

class AllUsersForAdminDataComposer
{

    public function compose(View $view)
    {

        $user_wrap = new UserModel();
//
        // dd('UserModel');
        $page = !empty(request()->get('page')) ? request()->get('page') : 1;
        $page_param = $page - 1;


        $params = array(
            'page' => $page_param,
            'rows' => 30
        );

        $response = $user_wrap->getAllUsersInformation($params);
        $start_sno = ($params['page'] * $params['rows']);

        $paginations = Pagination::getPaginationLinks($response->total, $page, request()->url(), $params['rows']);
        $users = !empty($response->data) ? $response->data : [];


        $view->with('users', !empty($users) ? $users : []);
        $view->with('start_sno', !empty($start_sno) ? $start_sno : 0);
        $view->with('pagination', !empty($paginations) && !empty($users) ? $paginations : []);
    }
}
