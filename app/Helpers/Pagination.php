<?php

namespace App\Helpers;

class Pagination
{

    public static function getPaginationLinks($total_results = '', $current_page = '', $link, $limit)
    {
        $data = array();

        $total_pages = ceil($total_results / $limit);
        $data['total_pages'] = (int) $total_pages;

        $start = ($current_page > 3) ? $current_page - 2 : 1;
        $end = ($current_page > 3) ? $current_page + 2 : 5;

        $end = ($end <= $total_pages) ? $end : $total_pages;


        for ($a = $start; $a <= $end; $a++) {
            $data['pagination_links'][$a]['link'] = ($current_page == $a) ? '#' : $link . "?page=$a";
            $data['pagination_links'][$a]['text'] = $a;
            $data['pagination_links'][$a]['class'] = ($current_page == $a) ? 'active' : '';
        }


        $prev_number = $current_page - 1;
        $next_number = $current_page + 1;

        $data['prev'] = !empty($prev_number) ? $link . "?page=" . $prev_number : 0;
        $data['next'] = ($next_number <= $total_pages) ? $link . "?page=" . $next_number : 0;


        $data['total'] = $total_results;
        $data['page'] = $current_page;
        $data['first_link'] = $link . "?page=1";
        $data['last_link'] = $link . "?page=" . $data['total_pages'];
        return $data;
    }

    public static function getFrontPaginationLinks($total_results = '', $current_page = '', $link, $limit)
    {
        $data = array();

        $query_path = '';

        if (!empty(request()->query())) {
            $query_params = request()->query();
            $itr = 0;
            // dd($query_params);
            foreach ($query_params as $key => $query) {
                if ($key != 'page') {
                    if ($itr > 0) {
                        $query_path .= "&$key=$query";
                    } else {
                        $query_path .= "?$key=$query";
                    }
                    $itr++;
                }
            }
        }

        $total_pages = ceil($total_results / $limit);
        $data['total_pages'] = (int) $total_pages;

        $start = ($current_page > 3) ? $current_page - 2 : 1;
        $end = ($current_page > 3) ? $current_page + 2 : 5;

        $end = ($end <= $total_pages) ? $end : $total_pages;
        // dd($query_path);
        $query_opt = $query_path;
        $query_opt .= empty($query_path) ? '?page' : '&page';
        for ($a = $start; $a <= $end; $a++) {
            $data['pagination_links'][$a]['link'] = ($current_page == $a) ? '#' : $link . "$query_opt=$a";
            $data['pagination_links'][$a]['text'] = $a;
            $data['pagination_links'][$a]['class'] = ($current_page == $a) ? 'active' : '';
        }


        $prev_number = $current_page - 1;
        $next_number = $current_page + 1;

        $data['prev'] = !empty($prev_number) ? $link . "$query_opt=" . $prev_number : 0;
        $data['next'] = ($next_number <= $total_pages) ? $link . "$query_opt=" . $next_number : 0;


        $data['total'] = $total_results;
        $data['page'] = $current_page;
        $data['first_link'] = $link . "$query_opt=1";
        $data['last_link'] = $link . "$query_opt=" . $data['total_pages'];

        $current_p = (int) $current_page;
        $data['showing']['total'] = $total_results;
        $data['showing']['of_before'] = ($limit * $current_p) - $limit + 1;
        $data['showing']['of_after'] = ($total_results <= $limit) ? $total_results : $limit * $current_p;

        return $data;
    }
}
