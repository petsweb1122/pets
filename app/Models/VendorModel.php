<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VendorModel extends Model
{
    protected $table = 'vendors';

    public function getAllVendorsFullColums($params = [])
    {

        $vendor_results = DB::table($this->table);

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $vendors = $vendor_results
            ->skip($skip_val)
            ->take($take)
            ->get()
            ->toArray();

        return $vendors;
    }

    public function getVendorDropdowns()
    {
        $vendors = [];

        $results = DB::table($this->table)->get();

        foreach ($results as $vendor) {
            $vendors[$vendor->vendor_id] = $vendor->title;
        }

        return $vendors;
    }


    public function getAllVendorsCount()
    {
        return DB::table($this->table)->count();
    }
}
