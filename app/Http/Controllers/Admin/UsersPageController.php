<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\ImageModel;
use Validator;
use Session;
use DB;


class UsersPageController extends ViewComposingController
{
    private $errors = array();

    public function getAddUsersPage()
    {
        $vendors = DB::table('vendors')->get();
        $vendor_data = ['' => 'Select a Vednor'];
        foreach ($vendors as $key => $vendor) {
            $vendor_data[$vendor->vendor_id] = $vendor->title;
        }
        $this->viewData['vendors'] = $vendor_data;
        return $this->buildTemplate('add_user');
    }

    public function addUser(Request $request, UserModel $objUser)
    {
        $params = array();

        $params['name'] = $request->get('first_name');
        $params['user_name'] = $request->get('user_name');
        $params['password'] = $request->get('password');
        $params['dateofbirth'] = $request->get('dob');
        $params['gender'] = $request->get('gender');
        $params['last_name'] = $request->get('last_name');
        $params['email'] = $request->get('email');
        $params['retype_password'] = $request->get('retype_password');
        $params['role'] = $request->get('role');
        $params['profile_image'] = $request->file('profile_image');
        $params['vendor'] = $request->get('vendor');

        $rules = [
            'name' => 'required|string',
            'last_name' => 'string|nullable',
            'email' => 'nullable|email|unique:users',
            'vendor' => 'nullable',
            'gender' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required',
            'retype_password' => 'required|same:password',
            'dateofbirth' => 'required|date',
            'role' => 'required',
            'profile_image' => 'required|mimes:jpeg,png'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        $data = [];
        if (empty($this->errors)) {
            $response = $objUser->addUser($params);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function getUserLogin()
    {
        return $this->buildTemplate('login');
    }

    public function checkUser(Request $request, UserModel $objUser)
    {

        $params = array();
        $data = array();

        $params['email'] = $request->get('email');
        $params['password'] = $request->get('password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        if (!empty($this->errors)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }
        $objImgModel = new ImageModel();

        $get_user = $objUser->where('email', $params['email'])->where('password', sha1($request->get('password')))->where('activation', 1)->first();

        if (empty($get_user)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = ['User Not Found / Check your email for account activation'];
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $user_image = $objImgModel->getUserImageByUserId($get_user);
        $get_user->image = $user_image;

        session(['user_data' => json_encode($get_user)]);

        return redirect()->action('Admin\HomePageController@getHomePage');
    }

    public function getLogout()
    {
        Session::forget('user_data');
        return redirect()->action('Front\UsersController@getLogin');
    }


    public function getUserProfile()
    {
        return $this->buildTemplate('user_profile');
    }


    public function getSelfUserProfile()
    {
        $user_data = json_decode(session()->get('user_data'));
        $user_id = $user_data->user_id;
        $user_obj = new UserModel();

        $user = $user_obj->getUserDetailsById($user_id);

        $user->image = $user_obj->getUserImagesByUserId($user_id, $user);
        // dd($user);
        if (empty($user)) {
            abort(404);
        }

        // dd($user);
        $this->viewData['user_update_data'] = $user;
        return $this->buildTemplate('user_self_profile');
    }


    public function getUserProfileForAdmin()
    {
        $user_id = request()->user_id;
        $user_obj = new UserModel();

        $user = $user_obj->getUserDetailsById($user_id);
        if (empty($user)) {
            abort(404);
        }

        $user->images = $user_obj->getUserImagesByUserId($user_id, $user);

        $this->viewData['user_data_show'] = $user;
        return $this->buildTemplate('user_profile_for_admin');
    }


    public function getAllUsers()
    {
        $this->viewData['action_model_url'] = 'users/delete';
        // dd('asd');
        return $this->buildTemplate('all_users');
    }

    public function getUpdateUserProfile(Request $request)
    {

        $user_id = request()->user_id;
        $user_obj = new UserModel();

        $user = $user_obj->getUserDetailsById($user_id);
        if (empty($user)) {
            abort(404);
        }

        $this->viewData['user_update_data'] = $user;

        $vendors = DB::table('vendors')->get();
        $vendor_data = ['' => 'Select a Vednor'];
        foreach ($vendors as $key => $vendor) {
            $vendor_data[$vendor->vendor_id] = $vendor->title;
        }
        $this->viewData['vendors'] = $vendor_data;


        return $this->buildTemplate('update_user');
    }

    public function updateUserProfile(Request $request, UserModel $objUser)
    {

        $params = array();

        $params['name'] = $request->get('first_name');
        $params['password'] = $request->get('password');
        $params['dateofbirth'] = $request->get('dob');
        $params['gender'] = $request->get('gender');
        $params['last_name'] = $request->get('last_name');
        $params['retype_password'] = $request->get('retype_password');
        $params['role'] = $request->get('role');
        $params['profile_image'] = $request->file('profile_image');
        $params['vendor'] = $request->get('vendor');


        $rules = [
            'name' => 'required|string',
            'last_name' => 'string|nullable',
            'gender' => 'required',
            'password' => 'required',
            'retype_password' => 'required|same:password',
            'dateofbirth' => 'required|date',
            'role' => 'required',
            'profile_image' => 'required|mimes:jpeg,png',
            'vendor' => 'nullable'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());
        // dd($this->errors);
        $data = [];
        if (empty($this->errors)) {
            $response = $objUser->updateUser($params);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function postSelfUserProfile(Request $request, UserModel $objUser)
    {
        $params = array();

        $params['name'] = $request->get('first_name');
        $params['password'] = $request->get('password');
        $params['dateofbirth'] = $request->get('dob');
        $params['gender'] = $request->get('gender');
        $params['last_name'] = $request->get('last_name');
        $params['retype_password'] = $request->get('retype_password');
        $params['profile_image'] = $request->file('profile_image');


        $rules = [
            'name' => 'required|string',
            'last_name' => 'string|nullable',
            'gender' => 'required',
            'password' => 'required',
            'retype_password' => 'required|same:password',
            'dateofbirth' => 'required|date',
            'profile_image' => 'nullable|mimes:jpeg,png'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        $data = [];
        if (empty($this->errors)) {
            $response = $objUser->updateSelfUser($params);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function userDelete(Request $request)
    {

        $errors = array();

        if (empty($request->get('message')) || strlen($request->get('message')) < 10) {
            $errors[] = 'Need Message and Maximum 10 char required!.';
        }

        if (empty($request->get('action_id'))) {
            $errors[] = 'User Id required!';
        }


        $user_data = DB::table('users')->where('user_id', $request->get('action_id'))->first();

        if (empty($user_data)) {
            $errors['empty'] = 'User id is not correct';
        }
        // dd($user_data->role);
        if (!empty($user_data) && $user_data->role == 'super-admin') {
            $errors['super'] = 'You can\'t delete the Super Admin';
        }



        if (!empty($errors)) {
            $data = [
                'errors' => $errors,
                'status' => 400,
                'message' => 'Validation Error!'
            ];
            return json_encode($data);
        }


        $insert_log = [];
        $insert_log['user_id'] = $user_data->user_id;
        $insert_log['name'] = $user_data->name;
        $insert_log['last_name'] = $user_data->last_name;
        $insert_log['email'] = $user_data->email;
        $insert_log['gender'] = $user_data->gender;
        $insert_log['user_name'] = $user_data->user_name;
        $insert_log['dateofbirth'] = $user_data->dateofbirth;
        $insert_log['role'] = $user_data->role;
        $insert_log['delete_message'] = $request->get('message');

        DB::table('users_delete_logs')->insert($insert_log);
        DB::table('users')->where('user_id', $user_data->user_id)->delete();


        return json_encode([
            'data' => [],
            'status' => 200,
            'message' => 'Successfully Action Perform!'
        ]);
    }
}
