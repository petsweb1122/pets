<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\ViewComposingController;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Validator;
use DB;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use App\Mail\UpdatePasswordMail;
use Illuminate\Support\Facades\Mail;

class UsersController extends ViewComposingController
{

    private $errors = array();

    public function getLogin()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('login');
    }

    public function getRegister()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('register');
    }

    public function getActivationLink(Request $request)
    {

        $getHash = DB::table('users')->where('activation_hash', $request->get('hash'))->where('activation', 0)->first();

        if (empty($getHash)) {
            die('Already Activated this account or Activation Link Expired');
        }

        DB::table('users')->where('user_id', $getHash->user_id)->update(['activation' => 1]);

        return redirect()->action('Front\UsersController@getLogin');
        // $date = Carbon::now();
        // //Get date and time
        // dd($date->timestamp());
        // dd($getHash);
    }

    public function postRegisterForm(Request $request,  UserModel $objUser)
    {
        $params = array();

        $params['name'] = $request->get('fname');
        $params['last_name'] = $request->get('last_name');
        $params['email'] = $request->get('email');
        $params['password'] = $request->get('password');
        $params['retype_password'] = $request->get('retype_password');
        $params['gender'] = $request->get('gender');


        $rules = [
            'name' => 'required|string',
            'last_name' => 'string|nullable',
            'email' => 'nullable|email|unique:users',
            'gender' => 'required',
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        $data = [];
        if (empty($this->errors)) {

            $response = $objUser->addFronEndUser($params);
            if ($response['status'] == 200) {
                return redirect()->action('Front\UsersController@getVerifyAccount');
            }
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function getPasswordReset(Request $request)
    {
        session(['password_reset_hash' => $request->reset]);
        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('password-reset');
    }

    public function postPasswordReset(Request $request)
    {

        $getHash = DB::table('users')->where('reset_activation', session()->get('password_reset_hash'))->where('email', $request->get('email'))->first();
        // dd($getHash);
        if (empty($getHash)) {
            die('Already Activated this account or Activation Link Expired');
        }

        $params = array();

        $params['email'] = $request->get('email');
        $params['password'] = $request->get('password');
        $params['retype_password'] = $request->get('password_confirmation');


        $rules = [
            'email' => 'nullable|email',
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());


        if (empty($this->errors)) {

            $update_data = [];
            $update_data['password']  = sha1($params['password']);
            $update_data['activation']  = 1;

            $update = DB::table('users')->where('email', $params['email'])->update($update_data);

            $details = [
                'message' => "Your password successfully updated",
            ];

            Mail::to($params['email'])->send(new UpdatePasswordMail($details));

            return redirect()->action('Front\UsersController@getLogin');
        } else {

            $data['message'] = '';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }
    }

    public function getPasswordResetEmail()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('password-reset-email');
    }

    public function postPasswordResetEmail(Request $request)
    {

        $params = array();

        $params['email'] = $request->get('email');
        $params['email'] = trim($params['email']);

        $rules = [
            'email' => 'nullable|email',
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        $check_email = DB::table('users')->where('email', $params['email'])->first();

        if (empty($check_email)) {
            $this->errors['email_wrong'] = 'Email not found, please enter correct email';
        }

        if (empty($this->errors)) {

            $data['message'] = 'Reset password link sent on your registered email!';

            $hash_resst = bcrypt(time() . 'pets' . $params['email']);

            $reset_url = url('/password-reset.html')  . '?reset=' . $hash_resst;
            DB::table('users')->where('email', $params['email'])->update(['reset_activation' => $hash_resst]);

            $details = [
                'reset_url' => $reset_url,
            ];

            Mail::to($params['email'])->send(new ResetPasswordMail($details));

            return redirect()->back()->with($data)->withInput($request->all());
        } else {

            $data['message'] = '';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }
    }

    public function getVerifyAccount()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('verify-account');
    }
}
