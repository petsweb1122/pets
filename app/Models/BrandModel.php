<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BrandModel extends Model
{
    protected $table = 'brands';

    public function getAllbrandsFullColums($params = []) {

        $brand_results = DB::table($this->table);

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $brands = $brand_results
                ->skip($skip_val)
                ->take($take)
                ->get()
                ->toArray();

        return $brands;
    }

    public function getBrandDropdowns()
    {
        $brands = [];

            $results = DB::table($this->table)->get();

            foreach ($results as $brand) {
                $brands[$brand->brand_id] = $brand->title;
            }

        return $brands;
    }

    public function getAllBrandsCount(){
        return DB::table($this->table)->count();
    }
}
