<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SizeModel extends Model {

    protected $table = 'sizes';

    public function getAllSizesFullColums($params = []) {

        $size_results = DB::table($this->table);

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $sizes = $size_results
                ->skip($skip_val)
                ->take($take)
                ->get()
                ->toArray();

        return $sizes;
    }

    public function getAllSizesCount() {
        return DB::table($this->table)->count();
    }

    public function getAllSizesForDropDown() {
        $sizes = ['' => 'Select Size'];
        $results = DB::table($this->table)->get();

        foreach ($results as $size) {
            $sizes[$size->value] = $size->value;
        }

        return $sizes;
    }

    public function getAllSizes() {
        $sizes = [];
        $results = DB::table($this->table)->get();

        return $results;
    }

}
