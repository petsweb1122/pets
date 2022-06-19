<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\VendorModel;
use Validator;

class VendorsController extends ViewComposingController
{
    public function getAddVendorsPage() {
        return $this->buildTemplate('add_vendor');
    }

     public function addVendor(Request $request) {

        $params = array();
        $errors = array();


        $params['title'] = $request->get('title');

        $title_breadcrumb = str_replace(' ', '-', strtolower($request->get('title')));
        $params['breadcrumb'] = $title_breadcrumb;

        $rules = [
            'title' => 'required|string',
            'breadcrumb' => 'unique:brands'
        ];
        $messages = [
            'breadcrumb.unique' => 'Title Already Exists'
        ];
        $validation = Validator::make($params, $rules, $messages);

        $errors = array_merge($validation->messages()->all(), $errors);

        $data = array();


        if (!empty($errors)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $insert = VendorModel::insert($params);

        $data['message'] = !empty($insert) ? 'Sucessfully Added' : 'Something Went Wrong';
        $data['status'] = !empty($insert) ? 200 : 204;

        return redirect()->back()->with($data);
    }

    public function getAllVendorsPage() {
        return $this->buildTemplate('vendors');
    }


    public function deleteVendor($id) {

        $deleted = VendorModel::where('vendor_id', $id)->delete();
            $message = !empty($deleted) ? "<h3 class='text-success'>Successfully Deleted</h3>" : "<h3 class='text-danger'> Something went wrong!</h3>";

        return redirect()->back()->with(['delete_message' => $message]);
    }


    public function updateVendors($id) {

        session(['update_id' => $id]);

        $vendor = VendorModel::where('vendor_id', $id)->first();

        if (!empty($vendor)) {
            $this->viewData['vendor'] = $vendor;
            return $this->buildTemplate('update_vendor');
        } else {
            return redirect()->back();
        }
    }

    public function submitUpdateVendor(Request $request) {
        $vendor_id = session()->get('update_id');

        $params = array();
        $errors = array();

        $params['title'] = $request->get('title');


        $title_breadcrumb = str_replace(' ', '-', strtolower($request->get('title')));

        $params['breadcrumb'] = $title_breadcrumb;


        $rules = [
            'title' => 'required|string',
            'breadcrumb' => 'required|unique:brands'
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
            $data['error'] = true;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $update = VendorModel::where('vendor_id',$vendor_id)->update($params);


        $data['message'] = !empty($update) ? 'Sucessfully Updated' : 'Something Went Wrong';
        $data['status'] = !empty($update) ? 200 : 204;

        return redirect()->back()->with($data);
    }

}
