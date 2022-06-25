<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageHelper;
use App\Models\ImageModel;
use DB;
use Cart;
use App\Helpers\PaypalHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistrationMail;

class UserModel extends Model
{

    protected $table = 'users';


    public function addUser($data)
    {
        $response = [];
        $add_user_data = [];
        $add_user_data['name'] = $data['name'];
        $add_user_data['last_name'] = $data['last_name'];
        $add_user_data['user_name'] = $data['user_name'];
        $add_user_data['password'] = sha1($data['password']);
        $add_user_data['dateofbirth'] = $data['dateofbirth'];
        $add_user_data['gender'] = $data['gender'];
        $add_user_data['email'] = $data['email'];
        $add_user_data['role'] = $data['role'];
        $add_user_data['activation_hash'] = bcrypt(time() . $data['name'] . $data['email']);;
        $add_user_data['vendor_id'] = !empty($data['vendor']) ? $data['vendor'] : 0;
        $add_user_data['is_vendor'] = !empty($data['vendor']) ? 1 : 0;
        $response['data'] = [];
        DB::beginTransaction();

        // dd(DB::table($this->table)->insert($add_user_data));
        try {

            // Add data in User Table
            DB::table($this->table)->insert($add_user_data);
            $user_id = DB::getPdo()->lastInsertId();
            // dd($user_id);
            $objImgHelper = new ImageHelper();
            // dd($data['profile_image']);
            $images = $objImgHelper->uploadSingleImage($data['profile_image'], 'users', $data['user_name']);

            $objImageModel = new ImageModel();

            $res = $objImageModel->uploadUserImage($images, $user_id);


            $activation_url = url('/activation_user?hash=' . $add_user_data['activation_hash']);
            $details = [
                // 'name' => $add_user_data['name'] . ' ' . $add_user_data['last_name'],
                'activation_url' => $activation_url,
            ];

            Mail::to($add_user_data['email'])->send(new NewUserRegistrationMail($details));

            DB::commit();

            $response['status'] = 200;
            $response['message'] = 'User Added Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not Added, Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not Added, Pease Try Again';
        }

        return $response;
    }

    public function updateUser($data)
    {
        $response = [];
        $update_user_data = [];
        $update_user_data['name'] = $data['name'];
        $update_user_data['last_name'] = $data['last_name'];
        $update_user_data['password'] = sha1($data['password']);
        $update_user_data['dateofbirth'] = $data['dateofbirth'];
        $update_user_data['gender'] = $data['gender'];
        $update_user_data['role'] = $data['role'];
        $update_user_data['vendor_id'] = !empty($data['vendor']) ? $data['vendor'] : 0;
        $update_user_data['is_vendor'] = !empty($data['vendor']) ? 1 : 0;

        $response['data'] = [];
        DB::beginTransaction();

        try {

            // Add data in User Table
            DB::table($this->table)->where('user_id', request()->user_id)->update($update_user_data);
            $user_id = (int) request()->user_id;

            $user_data = DB::table('users')->where('user_id', request()->user_id)->first();


            // DB::enableQueryLog();
            DB::table('images')->where('object_type', 'user')->where('object_id', $user_id)->delete();
            DB::table('images_sizes')->where('object_type', 'user')->where('object_id', $user_id)->delete();

            // $query = DB::getQueryLog();


            $objImgHelper = new ImageHelper();
            $images = $objImgHelper->uploadSingleImage($data['profile_image'], 'users', $user_data->user_name);

            $objImageModel = new ImageModel();

            $res = $objImageModel->uploadUserImage($images, $user_id);

            DB::commit();

            $response['status'] = 200;
            $response['message'] = 'User Updated Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not update, Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not update, Pease Try Again';
        }

        return $response;
    }

    public function updateSelfUser($data)
    {

        $session_user_data = json_decode(session()->get('user_data'));
        $session_user_id = $session_user_data->user_id;
        $response = [];
        $update_user_data = [];
        $update_user_data['name'] = $data['name'];
        $update_user_data['last_name'] = $data['last_name'];
        $update_user_data['password'] = sha1($data['password']);
        $update_user_data['dateofbirth'] = $data['dateofbirth'];
        $update_user_data['gender'] = $data['gender'];

        $response['data'] = [];
        DB::beginTransaction();

        try {
            // Add data in User Table
            DB::table($this->table)->where('user_id', $session_user_id)->update($update_user_data);


            if (!empty($data['profile_image'])) {

                // DB::enableQueryLog();
                DB::table('images')->where('object_type', 'user')->where('object_id', $session_user_id)->delete();
                DB::table('images_sizes')->where('object_type', 'user')->where('object_id', $session_user_id)->delete();

                // $query = DB::getQueryLog();

                $objImgHelper = new ImageHelper();
                $images = $objImgHelper->uploadSingleImage($data['profile_image'], 'users', $session_user_data->user_name);

                $objImageModel = new ImageModel();

                $res = $objImageModel->uploadUserImage($images, $session_user_id);
            }


            DB::commit();

            $response['status'] = 200;
            $response['message'] = 'User Updated Successfully';
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not update, Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not update, Pease Try Again';
        }

        return $response;
    }


    public function addFrontUserAndCustomerAndOrders($data)
    {
        // dd($data);
        $user_data = json_decode(session()->get('user_data'));

        $response = [];

        $response['data'] = [];
        DB::beginTransaction();

        try {

            $user_id = $user_data->user_id;

            $cart_contents = Cart::getContent();
            $total_v_price = 0;
            foreach ($cart_contents  as $key => $item) {
                $explode = explode('_', $item['id']);
                $pro_id = $explode[0];
                $variation_id = $explode[1];
                $p_obj = DB::table('products as p')->where('p.product_id', $pro_id)->first();
                $pv_obj = DB::table('product_variations as pv')->where('pv.product_id', $pro_id)->where('pv.variation_id', $variation_id)->first();
                $total_q_price = $pv_obj->v_price * $item['quantity'];
                $total_v_price = $total_v_price +  $total_q_price;
            }

            $order_data = [];

            $order_data['user_id'] = $user_id;
            $order_data['total_qty'] = Cart::getTotalQuantity();
            $order_data['total_items'] = count(Cart::getContent());
            $order_data['total_price'] = Cart::getTotal() - (Cart::getTotal() * env('PETS_DISC'));
            $order_data['discount_amount'] = (Cart::getTotal() * env('PETS_DISC'));
            $order_data['discount_percent'] = 100 * env('PETS_DISC');
            $order_data['total_v_price'] = $total_v_price;
            $order_data['tax'] = ($data['tax_rate'] * $order_data['total_price']);
            $order_data['shipping_price'] = $data['shipping_rate'];
            // total_price + shipping_price + tax
            $order_data['final_amount'] = $order_data['total_price'] + $data['shipping_rate'] + $order_data['tax'];

            $add_order = DB::table('orders')->insert($order_data);

            $order_id = DB::getPdo()->lastInsertId();

            $order_items = [];

            $carts = Cart::getContent();

            $itr  = 0;
            foreach ($carts as $key => $cart) {
                $explode = explode('_', $cart['id']);
                $p_id = $explode[0];
                $variation_id = $explode[1];

                $p_obj = DB::table('products as p')->where('p.product_id', $p_id)->first();
                $pv_obj = DB::table('product_variations as pv')->where('pv.product_id', $p_id)->where('pv.variation_id', $variation_id)->first();
                $order_items[$itr]['order_id'] = (int) $order_id;
                $order_items[$itr]['product_id'] = (int) $p_id;
                $order_items[$itr]['variation_id'] = (int) $variation_id;
                $order_items[$itr]['product_title'] = $p_obj->title;
                $order_items[$itr]['p_qty'] = $cart->quantity;
                $order_items[$itr]['price'] = $cart->price;
                $order_items[$itr]['v_id'] = $p_obj->vendor_id;
                $order_items[$itr]['v_price'] = $pv_obj->v_price;
                $itr++;
            }
            DB::table('order_items')->insert($order_items);

            $add_customer_data = [];
            $add_customer_data['user_id'] = $user_id;
            $add_customer_data['shipping_first_name'] = $data['name'];
            $add_customer_data['shipping_last_name'] = $data['last_name'];
            $add_customer_data['shipping_country'] = $data['country'];
            $add_customer_data['shipping_email'] = $data['email'];
            $add_customer_data['shipping_city'] = $data['city'];
            $add_customer_data['address'] = $data['address'];
            $add_customer_data['notes'] = $data['notes'];
            $add_customer_data['contact_number'] = $data['contact_number'];
            $add_customer_data['notes'] = $data['notes'];
            $add_customer_data['shipping_company'] = $data['company'];
            $add_customer_data['order_id'] = $order_id;
            $add_customer_data['zipcode'] = $data['postcode'];
            $add_customer_data['shipping_state'] = $data['state'];

            DB::table('customer_shipping_details')->insert($add_customer_data);


            $obj_paypal = new PaypalHelper();

            $payment = $obj_paypal->sendPaymentToPaypal($order_data, $order_items, $order_id);

            DB::commit();
            $response['status'] = 200;
            $response['message'] = 'Your Order Successfully Placed';
            $response['approve_link'] = $payment->getApprovalLink();
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Pease Try Again';
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'Pease Try Again';
            return $response;
        }


        return $response;
    }

    public function addFronEndUser($data)
    {
        $response = [];
        $add_user_data = [];
        $add_user_data['name'] = $data['name'];
        $add_user_data['last_name'] = $data['last_name'];
        $add_user_data['user_name'] = 'customer'  . rand(0, 9999999);
        $add_user_data['password'] = sha1($data['password']);
        $add_user_data['gender'] = $data['gender'];
        $add_user_data['email'] = $data['email'];
        $add_user_data['activation_hash'] = bcrypt(time() . $data['name'] . $data['email']);
        $add_user_data['activation'] = 0;
        $add_user_data['role'] = 'customer';
        $response['data'] = [];
        DB::beginTransaction();

        try {

            // Add data in User Table
            DB::table($this->table)->insert($add_user_data);



            $response['status'] = 200;
            $response['message'] = 'User Added Successfully';

            $activation_url = url('/activation_user?hash=' . $add_user_data['activation_hash']);
            $details = [
                'name' => $add_user_data['name'] . ' ' . $add_user_data['last_name'],
                'activation_url' =>  $activation_url,
                'message' => "click here for activation your account. <a href='$activation_url'>Activate</a>, Your activation link will be expire after 24 hours",
            ];
            Mail::to($add_user_data['email'])->send(new NewUserRegistrationMail($details));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not Added, Pease Try Again';
        } catch (\Exception $e) {
            DB::rollBack();
            $response['status'] = 400;
            $response['message'] = 'User Not Added, Pease Try Again';
        }

        return $response;
    }


    public function getAllUsersInformation($params)
    {

        $results  = DB::table('users as u');

        $take = !empty($params['rows']) ? $params['rows'] : 20;

        $skip_val = !empty($params['page']) ? $params['page'] * $take : 0;

        $total_count = count($results->get()->toArray());
        $data = $results->skip($skip_val)
            ->take($take)
            ->get()
            ->toArray();

        $data = [
            'data' => !empty($data) ? $data : [],
            'total' => $total_count,
            'status' => !empty($data) ? 200 : 204,
            'message' => 'Successfully Fetch all Users Data'
        ];

        return json_decode(json_encode($data));
    }

    public function getUserDetailsById($user_id)
    {
        $user_details = DB::table('users as u')
            ->select('*')
            ->where('u.user_id', $user_id)
            ->first();


        return $user_details;
    }

    public function getUserImagesByUserId($user_id, $user)
    {

        $images = ImageModel::select('is.*')
            ->from('images as i')
            ->join('images_sizes as is', 'is.image_id', 'i.id')
            ->where('i.object_type', 'user')
            ->where('i.object_id', $user_id)
            ->get()->toArray();

        $userImages = [];
        if (!empty($images)) {
            foreach ($images as $key => $image) {
                $userImages[$image['size_number']] = url('/') . "/users/$user->user_name/" . $image['image_name'];
            }
        } else {
            $userImages['s'] = url('/users/no_user_image.png');
            $userImages['m'] = url('/users/no_user_image.png');
            $userImages['l'] = url('/users/no_user_image.png');
        }

        return json_decode(json_encode($userImages));
    }
}
