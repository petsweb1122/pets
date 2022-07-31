<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ViewComposingController;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Helpers\ImageHelper;
use Validator;
use Cache;
use Faker\Provider\Image;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends ViewComposingController
{

    public function getAllCategoriesPage()
    {
        return $this->buildTemplate('categories');
    }

    public function getAddCategoryPage()
    {
        return $this->buildTemplate('add_category');
    }

    public function addCategory(Request $request)
    {

        $params = array();
        $errors = array();

        $params['title'] = $request->get('title');
        $params['cat_image'] = $request->file('cat_image');
        $params['cat_level'] = 1;

        $title_breadcrumb = str_replace(' ', '-', strtolower($request->get('title')));


        if (!empty($request->get('parent_category'))) {
            $parentObj = CategoryModel::where(
                'category_id',
                $request->get('parent_category')
            )->first();

            if (empty($parentObj)) {
                $errors['category_not_found'] = 'Parent Category is not correct please select again';
            } else {
                for ($i = 1; $i < $parentObj->cat_level; $i++) {
                    $cate = $parentObj->{'cat_' . $i};
                    $cate = (int) $cate;
                    $params["cat_$i"] =  $cate;
                }
                $params["cat_$parentObj->cat_level"] = $parentObj->category_id;
                $params['cat_level'] = $parentObj->cat_level + 1;
                $params['parent_id'] = $parentObj->category_id;
                $params['parent_title'] = $parentObj->title;
                $params['parent_breadcrumb'] = $parentObj->breadcrumb;
                $title_breadcrumb = $parentObj->breadcrumb . '-' . $title_breadcrumb;
            }
        }

        $params['breadcrumb'] = $title_breadcrumb;


        $rules = [
            'title' => 'required|string',
            'breadcrumb' => 'unique:categories',
            'parent_title' => 'nullable',
            'parent_breadcrumb' => 'nullable',
            'cat_image' => 'nullable|mimes:jpeg,png',
        ];
        $messages = [
            'breadcrumb.unique' => 'Title Already Exists'
        ];
        $validation = Validator::make($params, $rules, $messages);

        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();
        $data['errors'] = $errors;


        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            return redirect()->back()->with($data)->withInput($request->all());
        }

        if (!empty($params['cat_image'])) {
            $image_helper = new ImageHelper();
            $cat_image_name = $image_helper->uploadImageAndReturnUrl($params['cat_image'], 'category', strtolower($params['title']), 'm');


            $params['image'] = $cat_image_name;
        }
        unset($params['cat_image']);

        $insert_cate = CategoryModel::insert($params);
        $categories_dropdown = [];
        $results = CategoryModel::get();

        foreach ($results as $category) {
            $categories_dropdown[$category->category_id] = $category->title;
        }
        Cache::put('categories', $categories_dropdown, 86400); // One Day

        $data['message'] = !empty($insert_cate) ? 'Sucessfully Added' : 'Something Went Wrong';
        $data['status'] = !empty($insert_cate) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function updateCategory($id)
    {

        session(['update_id' => $id]);
        //        session(['userData' => $response->data]);

        $category = CategoryModel::where('category_id', $id)->first();

        if (!empty($category)) {
            $this->viewData['category'] = $category;
            return $this->buildTemplate('update_category');
        } else {
            return redirect()->back();
        }
    }

    public function submitUpdateCategory(Request $request)
    {
        $category_id = session()->get('update_id');

        $params = array();
        $errors = array();


        $params['title'] = $request->get('title');
        $params['cat_level'] = 1;
        $params['cat_1'] = 0;
        $params['cat_2'] = 0;
        $params['cat_3'] = 0;
        $params['cat_4'] = 0;
        $params['cat_5'] = 0;
        $params['cat_6'] = 0;
        $params['cat_7'] = 0;
        $params['cat_8'] = 0;
        $params['cat_9'] = 0;
        $params['cat_10'] = 0;

        $title_breadcrumb = str_replace(' ', '-', strtolower($request->get('title')));


        if (!empty($request->get('parent_category'))) {
            $parentObj = CategoryModel::where(
                'category_id',
                $request->get('parent_category')
            )->first();

            if (empty($parentObj)) {
                $errors['category_not_found'] = 'Parent Category is not correct please select again';
            } else {
                for ($i = 1; $i < $parentObj->cat_level; $i++) {
                    $cate = $parentObj->{'cat_' . $i};
                    $cate = (int) $cate;
                    $params["cat_$i"] =  $cate;
                }
                $params["cat_$parentObj->cat_level"] = $parentObj->category_id;
                $params['cat_level'] = $parentObj->cat_level + 1;
                $params['parent_id'] = $parentObj->category_id;
                $params['parent_title'] = $parentObj->title;
                $params['parent_breadcrumb'] = $parentObj->breadcrumb;
                $title_breadcrumb = $parentObj->breadcrumb . '-' . $title_breadcrumb;
            }
        } else {
            $params['parent_id'] = null;
            $params['parent_title'] = null;
            $params['parent_breadcrumb'] = null;
        }

        $chk_title_bread = CategoryModel::where(
            'category_id',
            $request->get('parent_category')
        )
            ->where('breadcrumb', $title_breadcrumb)->first();

        if (!empty($chk_title_bread)) {
            $errors['duplicate'] = 'Title Already Exists';
        }

        $params['breadcrumb'] = $title_breadcrumb;
        $params['cat_image'] = $request->file('cat_image');


        $rules = [
            'title' => 'required|string',
            'breadcrumb' => 'required',
            'parent_title' => 'nullable',
            'parent_breadcrumb' => 'nullable',
            'cat_image' => 'nullable|mimes:jpeg,png',
        ];
        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();
        $data['errors'] = $errors;


        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            return redirect()->back()->with($data)->withInput($request->all());
        }

        if (!empty($params['cat_image'])) {
            $image_helper = new ImageHelper();
            $cat_image_name = $image_helper->uploadImageAndReturnUrl($params['cat_image'], 'category', strtolower($params['title']), 'm');


            $params['image'] = $cat_image_name;
        }
        unset($params['cat_image']);
        $update_cate = CategoryModel::where('category_id', $category_id)->update($params);


        $data['message'] = !empty($update_cate) ? 'Sucessfully Updated' : 'Something Went Wrong';
        $data['status'] = !empty($update_cate) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function deleteCategory($id)
    {

        $getChild = CategoryModel::where('parent_id', $id)->first();
        if (!empty($getChild)) {
            $message = "<h3 class='text-danger'> Child are exists against this category: <b>$getChild->parent_title</b></h3>";
        } else {
            $deleted = CategoryModel::where('category_id', $id)->delete();
            $message = !empty($deleted) ? "<h3 class='text-success'> Categry Successfully Deleted</h3>" : "<h3 class='text-danger'> Something went wrong!</h3>";
        }

        return redirect()->back()->with(['delete_message' => $message]);
    }

    public function getAllVendorCategoriesValidationPage(Request $request, $vendor_id)
    {

        return $this->buildTemplate('category_validation');
    }

    public function getAllVendorMappedUnMappedCategoriesPage(Request $request, $show_type, $vendor_id)
    {
        return $this->buildTemplate('all_validate_categories');
    }

    public function getAllVendorUnMappedCategoriesPage(Request $request, $vendor_id, $cat_id)
    {
        return $this->buildTemplate('single_validate_category');
    }

    public function postVendorMapCategory(Request $request, $vendor_id, $cat_id)
    {

        $params = array();
        $errors = array();

        $rules = [
            'parent_category' => 'required|array',
        ];
        $messages = [
            'parent_category.required' => 'Select Map Category'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();
        $data['errors'] = $errors;


        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $params = [];
        foreach ($request->parent_category as $key => $cid) {
            $params[$key]['vendor_cat_id']  = $cat_id;
            $params[$key]['category_id']  = $cid;
        }

        // $update_cate = DB::table('vendor_categories')->where('id', $cat_id)->where('vendor_id', $vendor_id)->update(['map_with' => $request->parent_category]);
        $insert_cate = DB::table('vendor_categories_to_categories')->insert($params);


        $data['message'] = !empty($insert_cate) ? 'Sucessfully Mapped' : 'Something Went Wrong';
        $data['status'] = !empty($insert_cate) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function addVendorMapCategory(Request $request, $vendor_id, $cat_id)
    {

        $params = array();
        $errors = array();

        $vendor_cate = DB::table('vendor_categories')->where('id', $cat_id)->where('vendor_id', $vendor_id)->first();


        $get_cat = DB::table('categories as c')->where('c.breadcrumb', $vendor_cate->category_breadcrumb)->first();

        if (empty($get_cat)) {
            $get_cat = DB::table('categories as c')->where('c.title', $vendor_cate->category_name)->first();
        }

        if (empty($get_cat)) {
            $add_cat = [];
            $add_cat['title'] = $vendor_cate->category_name;
            $add_cat['breadcrumb'] = $vendor_cate->category_breadcrumb;
            $add_cat['cat_level'] = 1;


            $add_category = DB::table('categories')->insert($add_cat);
        }

        $data['action_message'] = !empty($add_category) ? 'Sucessfully Add the Category' : 'Already Added';
        $data['status'] = !empty($add_category) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function syncVendorMapCategory(Request $request, $vendor_id, $cat_id)
    {

        $params = array();
        $errors = array();

        $vendor_cate = DB::table('vendor_categories')->where('id', $cat_id)->where('vendor_id', $vendor_id)->first();


        $get_cat = DB::table('categories as c')->where('c.breadcrumb', $vendor_cate->category_breadcrumb)->first();
        // dd($get_cat);

        if (empty($get_cat)) {
            $get_cat = DB::table('categories as c')->where('c.title', $vendor_cate->category_name)->first();
        }

        if (empty($get_cat)) {

            $add_cat = [];
            $add_cat['title'] = $vendor_cate->category_name ;
            $add_cat['breadcrumb'] = $vendor_cate->category_breadcrumb ;
            $add_cat['cat_level'] = 1;


            $add_category = DB::table('categories')->insert($add_cat);
            $sync_cat_id = DB::getPdo()->lastInsertId();
            $update_cate = DB::table('vendor_categories')->where('id', $cat_id)->where('vendor_id', $vendor_id)->update(['map_with' => $sync_cat_id]);
            $data['action_message'] = !empty($update_cate) ? 'Category Added and Sucessfully Sync the Category' : 'Some Thing Went Wrong';
            $data['status'] = !empty($update_cate) ? 200 : 204;
        }

        if (!empty($get_cat)) {

            $update_cate = DB::table('vendor_categories')->where('id', $cat_id)->where('vendor_id', $vendor_id)->update(['map_with' => $get_cat->category_id]);
            $data['action_message'] = !empty($update_cate) ? 'Sucessfully Sync the Category' : 'Some Thing Went Wrong';
            $data['status'] = !empty($update_cate) ? 200 : 204;

        }



        return redirect()->back()->with($data);
    }


    public function syncVendorCategoriesToCategories(Request $request , $vendor_id){

        $theArrays = Excel::toArray([], $request->file('upload_categories'));
        unset($theArrays[0][0]);
        foreach ($theArrays[0] as $key => $row) {
            //First Level Category
            if(!empty($row[6])){
                $params = [];

                $bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[6]));
                $bread = str_replace('--', '-', $bread);

                $check_cat = DB::table('categories as c')->where('c.breadcrumb' , $bread)->count();
                if(empty($check_cat)){
                    $params['title'] = $row[6];
                    $params['breadcrumb'] = $bread;
                    $params['cat_level'] = 1;


                    CategoryModel::insert($params);
                }
            }

            //Second Level Category
            if(!empty($row[7])){

                $params = [];
                $bread1 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[6]));
                $bread1 = str_replace('--', '-', $bread1);
                $bread1 = str_replace('--', '-', $bread1);

                $cur_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[7]));
                $cur_bread = str_replace('--', '-', $cur_bread);
                $cur_bread = str_replace('--', '-', $cur_bread);

                $full_bread = $bread1 . '-' . $cur_bread;

                $parent_obj = DB::table('categories as c')->where('c.breadcrumb' , $bread1)->first();

                $check_cat = DB::table('categories as c')->where('c.breadcrumb' , $full_bread)->count();

                if(empty($check_cat)){
                    $params['title'] = $row[7];
                    $params['breadcrumb'] = $full_bread;
                    $params['parent_id'] = $parent_obj->category_id;
                    $params['parent_title'] = $parent_obj->title;
                    $params['parent_breadcrumb'] = $parent_obj->breadcrumb;
                    $params["cat_1"] =  $parent_obj->category_id;
                    $params['cat_level'] = 2;

                    CategoryModel::insert($params);
                }
            }

            //Third Level Category
            if(!empty($row[8])){

                $params = [];
                $bread1 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[6]));
                $bread1 = str_replace('--', '-', $bread1);
                $bread1 = str_replace('--', '-', $bread1);

                $bread2 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[7]));
                $bread2 = str_replace('--', '-', $bread2);
                $bread2 = str_replace('--', '-', $bread2);

                $cur_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[8]));
                $cur_bread = str_replace('--', '-', $cur_bread);
                $cur_bread = str_replace('--', '-', $cur_bread);

                $full_bread = $bread1 . '-' . $bread2 . '-' . $cur_bread;

                $parent_obj = DB::table('categories as c')->where('c.breadcrumb' , $bread1 . '-' . $bread2)->first();
                $check_cat = DB::table('categories as c')->where('c.breadcrumb' , $full_bread)->count();
                if(empty($check_cat)){
                    $params['title'] = $row[8];
                    $params['breadcrumb'] = $full_bread;
                    $params['parent_id'] = $parent_obj->category_id;
                    $params['parent_title'] = $parent_obj->title;
                    $params['parent_breadcrumb'] = $parent_obj->breadcrumb;
                    $params["cat_1"] =  $parent_obj->cat_1;
                    $params["cat_2"] =  $parent_obj->category_id;
                    $params['cat_level'] = 3;

                    CategoryModel::insert($params);
                }
            }

            //Third Level Category
            if(!empty($row[9])){

                $params = [];
                $bread1 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[6]));
                $bread1 = str_replace('--', '-', $bread1);
                $bread1 = str_replace('--', '-', $bread1);

                $bread2 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[7]));
                $bread2 = str_replace('--', '-', $bread2);
                $bread2 = str_replace('--', '-', $bread2);

                $bread3 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[8]));
                $bread3 = str_replace('--', '-', $bread3);
                $bread3 = str_replace('--', '-', $bread3);

                $cur_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[9]));
                $cur_bread = str_replace('--', '-', $cur_bread);
                $cur_bread = str_replace('--', '-', $cur_bread);

                $full_bread = $bread1 . '-' . $bread2 . '-' . $bread3 . '-'  . $cur_bread;

                $parent_obj = DB::table('categories as c')->where('c.breadcrumb' , $bread1 . '-' . $bread2 . '-' . $bread3)->first();
                $check_cat = DB::table('categories as c')->where('c.breadcrumb' , $full_bread)->count();
                if(empty($check_cat)){
                    $params['title'] = $row[9];
                    $params['breadcrumb'] = $full_bread;
                    $params['parent_id'] = $parent_obj->category_id;
                    $params['parent_title'] = $parent_obj->title;
                    $params['parent_breadcrumb'] = $parent_obj->breadcrumb;
                    $params["cat_1"] =  $parent_obj->cat_1;
                    $params["cat_2"] =  $parent_obj->cat_2;
                    $params["cat_3"] =  $parent_obj->category_id;
                    $params['cat_level'] = 4;
                    CategoryModel::insert($params);
                }
            }


            $bread1 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[6]));
            $bread1 = str_replace('--', '-', $bread1);
            $bread1 = str_replace('--', '-', $bread1);

            $bread2 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[7]));
            $bread2 = str_replace('--', '-', $bread2);
            $bread2 = str_replace('--', '-', $bread2);

            $bread3 = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[8]));
            $bread3 = str_replace('--', '-', $bread3);
            $bread3 = str_replace('--', '-', $bread3);

            $cur_bread = strtolower(str_replace(array('--', ' ', '/', ',',  '.', '"', '\'', '&'), '-', $row[9]));
            $cur_bread = str_replace('--', '-', $cur_bread);
            $cur_bread = str_replace('--', '-', $cur_bread);

            $full_bread = $bread1 . (!empty($bread2) ? '-' . $bread2 : '') . (!empty($bread3) ?  '-' .  $bread3 : '' ) . (!empty($cur_bread) ?  '-'  .  $cur_bread : '');

            // dd($row);
        $vendor_category = DB::table('vendor_categories as vc')->where('vc.category_breadcrumb' , $row[5])->where('vc.vendor_id', $vendor_id );
        $vendor_category_obj = $vendor_category->first();

            if(!empty($vendor_category->count())){

                $pet_cat = DB::table('categories as c')->where('c.breadcrumb' , $full_bread)->first();

                // dd($pet_cat->category_id, $vendor_category_obj->id);

                $map_category = DB::table('vendor_categories_to_categories as mc')->where('mc.vendor_cat_id', $vendor_category_obj->id)->where('mc.category_id', $pet_cat->category_id);

                if(empty($map_category->count())){
                    $map_data = [];
                    $map_data['vendor_cat_id'] = $vendor_category_obj->id;
                    $map_data['category_id'] = $pet_cat->category_id;

                    DB::table('vendor_categories_to_categories')->insert($map_data);

                }

            }

        }

    }
}
