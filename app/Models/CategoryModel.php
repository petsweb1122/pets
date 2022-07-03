<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cache;

class CategoryModel extends Model
{

    protected $table = 'categories';

    public function getAllCategoriesForParentCategory()
    {

        $category_results = $this->select('category_id', 'title', 'parent_title', 'breadcrumb')
            ->orderBy('title', 'asc')
            ->get();

        $categories = array('');
        foreach ($category_results as $key => $category) {
            $title_cat_display = !empty($category->parent_title) ? $category->title .  '(' .  $category->parent_title . ')'  . ' --- ' . $category->breadcrumb : $category->title . ' --- ' . $category->breadcrumb;
            $categories[$category->category_id] = $title_cat_display;
        }

        return $categories;
    }

    public function getAllValidationCategories($type, $vendor_id)
    {


        $exp = ($type == 'unmapped') ? "=" : "!=";

        $category_results = DB::table('vendor_categories as vc')->select('vc.*')
            ->where('vc.vendor_id', $vendor_id)
            // ->where('vc.map_with', $exp, null)
            ->when($type == 'mapped', function ($q) {
                $q->join('vendor_categories_to_categories as vcc', 'vcc.vendor_cat_id', 'vc.id');
            })

            ->orderBy('category_name', 'asc')
            // ->groupBy('vc.id')
            ->get();

        $categories = array('');
        foreach ($category_results as $key => $category) {
            $title_cat_display =  $category->category_name;
            $categories[$category->id] = $title_cat_display;
        }

        return $categories;
    }

    public function getCurrentCategory($cat_id, $vendor_id)
    {

        $category = DB::table('vendor_categories as vc')
            ->leftJoin('categories as c', 'c.category_id', 'vc.map_with')
            ->select('vc.*', 'c.title as map_name', 'c.breadcrumb as map_bread')
            ->where('vc.vendor_id', $vendor_id)->where('vc.id', $cat_id)->first();

        return $category;
    }



    public function getAllCategoriesFullColums($params = [])
    {

        $category_results = DB::table($this->table);

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $categories = $category_results
            ->skip($skip_val)
            ->take($take)
            ->get()
            ->toArray();

        return $categories;
    }

    public function getAllValidationCategoriesFullColums($params = [], $type, $vendor_id)
    {

        // dd($type);
        $exp = ($type == 'unmapped') ? "=" : "!=";

        $category_results = DB::table("vendor_categories as vc");

        $take = !empty($params['rows']) ? $params['rows'] : 20;
        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $categories = $category_results
            ->when($type == 'mapped', function ($q) {
                $q->join('vendor_categories_to_categories as vcc', 'vcc.vendor_cat_id', 'vc.id')->leftJoin('categories as c', 'c.category_id', 'vcc.category_id')->select('vc.*' , 'c.title as map_with');
            })
            ->when($type == 'unmapped', function ($q) {
                $q->leftJoin('vendor_categories_to_categories as vcc', 'vcc.vendor_cat_id', 'vc.id')->leftJoin('categories as c', 'c.category_id', 'vcc.category_id')->select('vc.*' , 'c.title as map_with')->where('c.title'  , null);
            })
            ->where('vc.vendor_id', $vendor_id)
            ->skip($skip_val)
            ->take($take)
            ->get()
            ->toArray();

            return $categories;
    }

    public function getCategoryDropdowns()
    {
        $results = DB::table($this->table)->get();

        foreach ($results as $category) {
            $categories[$category->category_id] = $category->title;
        }
        return $categories;
    }

    public function getCategoriesByIds($ids = [])
    {
        $results = DB::table($this->table)->whereIn('category_id', $ids)->get()->toArray();

        return $results;
    }

    public function getSingleCategoryById($id)
    {
        $results = DB::table($this->table)->where('category_id', $id)->first();

        return $results;
    }

    public function getCategoriesByName($name)
    {
        $results = DB::table($this->table)->where('breadcrumb', $name)->first();

        return $results;
    }

    public function getShopByCategoryData()
    {
        $data = array();

        $results = DB::table($this->table)->where('cat_level', 1)->get()->toArray();

        foreach ($results as $key => $value) {
            if (!empty($value->image)) {
                $data[$key]['title'] = $value->title;
                $data[$key]['dir'] = str_replace('/', '', strtolower(str_replace(' ', '-', $value->title)));
                $data[$key]['image'] = $value->image;
                $data[$key]['breadcrumb'] = url('/' . $value->breadcrumb);
            }
        }

        return $data;
    }

    public function getLeftCatNavLinks()
    {
        $data = array();

        $top_levels = DB::table($this->table)->where('cat_level', 1)->get()->toArray();

        foreach ($top_levels as $key => $level1) {
            $data[$key]['title'] = $level1->title;
            $data[$key]['link'] = url('/' . $level1->breadcrumb);
            $data[$key]['childs'] = $this->getSecondLevelCat($level1->category_id);
        }
        return $data;
    }

    public function getTopNavLinks()
    {
        $data = array();

        $top_levels = DB::table($this->table)->where('cat_level', 1)->get()->toArray();

        foreach ($top_levels as $key => $level1) {
            $data[$key]['title'] = $level1->title;
            $data[$key]['link'] = url('/' . $level1->breadcrumb);
            $data[$key]['childs'] = $this->getSecondTopLevelCat($level1->category_id);
        }
        return $data;
    }
    public function getSecondTopLevelCat($cat_id)
    {

        $level2_data = array();

        $sec_levels = DB::table($this->table)->where('cat_1', $cat_id)->where('cat_level', 2)->get()->take(5)->toArray();
        foreach ($sec_levels as $key => $level2) {
            $level2_data[$key]['title'] = $level2->title;
            $level2_data[$key]['link'] = url('/' . $level2->breadcrumb);
        }

        return $level2_data;
    }
    public function getSecondLevelCat($cat_id)
    {

        $level2_data = array();

        $sec_levels = DB::table($this->table)->where('cat_1', $cat_id)->where('cat_level', 2)->get()->take(5)->toArray();
        foreach ($sec_levels as $key => $level2) {
            $level2_data[$key]['title'] = $level2->title;
            $level2_data[$key]['link'] = url('/' . $level2->breadcrumb);
            $level2_data[$key]['childs'] = $this->getThirdLevelCat($level2->category_id);
        }

        return $level2_data;
    }

    public function getThirdLevelCat($cat_id)
    {

        $level3_data = array();

        $third_levels = DB::table($this->table)->where('cat_2', $cat_id)->where('cat_level', 3)->get()->take(5)->toArray();
        foreach ($third_levels as $key => $level3) {
            $level3_data[$key]['title'] = $level3->title;
            $level3_data[$key]['link'] = url('/' . $level3->breadcrumb);
        }

        return $level3_data;
    }

    public function getCategoryIdAndLevelByTitle($cat_title)
    {

        $result = DB::table($this->table)->where('breadcrumb', $cat_title)->first();
        return $result;
    }
}
