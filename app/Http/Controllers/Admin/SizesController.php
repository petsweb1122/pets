<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SizeModel;
use App\Models\SizeClothModel;
use Validator;

class SizesController extends ViewComposingController {

    public function getAddSizesPage() {
        return $this->buildTemplate('add_size');
    }

    public function addSize(Request $request) {

        $params = array();
        $errors = array();

        $params['value'] = $request->get('name');

        // $name_breadcrumb = str_replace(' ', '-', strtolower($request->get('name')));

        $rules = [
            'value' => 'required|string|unique:sizes'
        ];

        $messages = [
        ];

        $validation = Validator::make($params, $rules, $messages);
        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();

        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $insert = SizeModel::insert($params);

        $data['message'] = !empty($insert) ? 'Sucessfully Added' : 'Something Went Wrong';
        $data['status'] = !empty($insert) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function getAllSizesPage() {
        return $this->buildTemplate('sizes');
    }

    public function deleteSize($id) {

        $deleted = SizeModel::where('size_id', $id)->delete();
        $message = !empty($deleted) ? "<h3 class='text-success'>Successfully Deleted</h3>" : "<h3 class='text-danger'> Something went wrong!</h3>";

        return redirect()->back()->with(['delete_message' => $message]);
    }

    public function updateSize($id) {

        session(['update_id' => $id]);

        $size = SizeModel::where('size_id', $id)->first();

        if (!empty($size)) {
            $this->viewData['size'] = $size;
            return $this->buildTemplate('update_size');
        } else {
            return redirect()->back();
        }
    }

    public function submitUpdateSize(Request $request) {
        $id = session()->get('update_id');

        $params = array();
        $errors = array();

        $params['value'] = $request->get('name');

        $rules = [
            'value' => 'required|string|unique:sizes'
        ];
        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();
        $data['errors'] = $errors;


        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $update = SizeModel::where('size_id', $id)->update($params);


        $data['message'] = !empty($update) ? 'Sucessfully Updated' : 'Something Went Wrong';
        $data['status'] = !empty($update) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function getClothSizes(){

        $objClothSize = new SizeClothModel();

        $results = $objClothSize->getAllClothSizes();

        return json_encode($results);
    }

}
