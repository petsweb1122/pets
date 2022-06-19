<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Models\ProductModel;
use App\Helpers\ImageHelper;
use App\Models\ImageModel;
use DB;
use App\Helpers\ProductSizeHelper;

class ProductsController extends ViewComposingController
{

    private $errors = array();

    public function getAddProductPage(ProductSizeHelper $obj_size_helper)
    {

        // $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=4543";
        // $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=243";
        $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=10";
        // dd($endpoint);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'X-EA-REQUEST-TOKEN: 75509131ad521fde9f074c911039c31d'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        // $err = curl_error($ch);
        curl_close($ch);
        dd(json_decode($response));
        // // session(['add_sizes' => json_encode([])]);

        $sizes = json_decode(session()->get('add_sizes'));
        // dd($sizes);
        if (!empty($sizes)) {
            $sizes_data = [];
            foreach ($sizes as $size) {
                $size_obj = DB::table('sizes as s')->where('s.size_id', $size)->first();
                $sizes_data[$size_obj->size_id] = $obj_size_helper->getSizeHtml($size_obj);
            }

            session(['size_results' => $sizes_data]);
        }




        return $this->buildTemplate('add_product');
    }

    public function getEditProductPage()
    {
        $product_id = (int) request()->product_id;
        // dd(session()->all());
        $product = DB::table('products as p')->where('p.product_id', $product_id)->count();

        if (empty($product)) {
            abort(404);
        }
        return $this->buildTemplate('edit_product');
    }

    public function getAllProducts()
    {
        return $this->buildTemplate('products');
    }

    public function getProductImageUploads()
    {
        return $this->buildTemplate('upload_product_image');
    }

    public function removeProductImage(Request $request, $product_id, $image_number, ProductModel $objProduct, ImageHelper $objImageHelper)
    {

        $product = $objProduct->getSingleProductById($product_id);
        $objImageHelper->removeImageByProductObjAndImageNumber($product, $image_number);

        return redirect()->back();
    }

    public function uploadProductImages(Request $request, $product_id, ProductModel $objProduct, ImageHelper $objImageHelper)
    {

        $product = $objProduct->getSingleProductById($product_id);

        $objImageModel = new ImageModel();
        $already_color_images = [];
        // dd($product);
        $all_images = $objImageModel->getImagesAgainstProductId($product_id,  's');
        // dd( $all_images );
        foreach ($all_images as $key => $image) {
            $already_color_images[$image['object_id']] = $image['object_id'];
        }
        // dd( $already_color_images);
        $rules = [
            'product_images' => 'required|array',
            'product_images.*' => 'mimes:jpeg,png'
        ];
        $messages = [
            'product_images.*.mimes' => 'Only JPG,PNG images Allowed',
        ];
        $params  = [
            'product_images' => $request->file('product_images')
        ];
        $data = [];

        // dd($params);
        if (!empty($params) && !empty($rules)) {

            $validation = Validator::make($params, $rules, $messages);

            if (!empty($validation->messages()->all())) {
                $data['message'] = 'Validation Error!';
                $data['error'] = true;
                $data['errors'] = $validation->messages()->all();
                return redirect()->back()->with($data);
            }

            $upload_images = $objImageHelper->uploadTwoLayerMultipleImages($params, 'products', $product);
            $objImageModel = new ImageModel();

            $response = $objImageModel->uploadProductImages($upload_images, $product->product_id);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
            return redirect()->back()->with($data);
        } else {
            $data['message'] =  'Please Select an Image';
            return redirect()->back()->with($data);
        }
    }

    public function addVariationProduct(Request $request, ProductModel $objProduct, ProductSizeHelper $obj_size_helper)
    {
        $sizes = json_decode(session()->get('add_sizes'));

        $product_title_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "!", "=", "/", ".", '"', "&", "'", ",", "#"), '-', $request->get('title')));
        $product_title_breadcrumb = str_replace(['---', '--', '--', "+-"], '-', $product_title_breadcrumb);
        $title_breadcrumb = rtrim($product_title_breadcrumb, '-');

        $params_data = [];

        $params = [
            'title' => $request->get('title'),
            'title_breadcrumb' => $title_breadcrumb,
            'description' => $request->get('description'),
            'ingredients' => $request->get('ingredients'),
            'status' => $request->get('status'),
            'all_categories' => $request->get('all_categories'),
            'all_brands' => $request->get('all_brands'),
            'all_vendors' => $request->get('all_vendors'),
            'sizes' => $sizes,
        ];

        $rules = [
            'title' => 'required|string',
            'title_breadcrumb' => 'required',
            'description' => 'required',
            'ingredients' => 'nullable',
            'status' => 'required',
            'all_categories' => 'required',
            'all_brands' => 'required',
            'all_vendors' => 'required',
            'sizes' => 'required',
        ];


        $params_data = $params;

        if (!empty($sizes)) {

            foreach ($sizes as $size) {

                $temp_params = [];

                $temp_params["size_" . $size . "_sku"]  = $request->get("size_" . $size . "_sku");
                $temp_params["size_" . $size . "_upc"]  = $request->get("size_" . $size . "_upc");
                $temp_params["size_" . $size . "_qty"]  = $request->get("size_" . $size . "_qty");
                $temp_params["size_" . $size . "_mfn"]  = $request->get("size_" . $size . "_mfn");
                $temp_params["size_" . $size . "_vprice"]  = $request->get("size_" . $size . "_vprice");
                $temp_params["size_" . $size . "_sprice"]  = $request->get("size_" . $size . "_sprice");
                $temp_params["size_" . $size . "_rprice"]  = $request->get("size_" . $size . "_rprice");
                $temp_params["size_" . $size . "_sale"]  = $request->get("size_" . $size . "_sale");
                $temp_params["size_" . $size . "_length"]  = $request->get("size_" . $size . "_length");
                $temp_params["size_" . $size . "_width"]  = $request->get("size_" . $size . "_width");
                $temp_params["size_" . $size . "_height"]  = $request->get("size_" . $size . "_height");
                $temp_params["size_" . $size . "_product_size"]  = $request->get("size_" . $size . "_product_size");
                $temp_params["size_" . $size . "_discount_percent"]  = $request->get("size_" . $size . "_discount_percent");
                $temp_params["size_" . $size . "_discount_price"]  = $request->get("size_" . $size . "_discount_price");
                $temp_params["size_" . $size . "_discount_apply_on"]  = $request->get("size_" . $size . "_discount_apply_on");


                $params = array_merge($params, $temp_params);

                $rules["size_" . $size . "_sku"]  = "nullable";
                $rules["size_" . $size . "_upc"]  = "required";
                $rules["size_" . $size . "_qty"]  = "required";
                $rules["size_" . $size . "_mfn"]  = "nullable";
                $rules["size_" . $size . "_vprice"]  = "required";
                $rules["size_" . $size . "_sprice"]  = "required";
                $rules["size_" . $size . "_rprice"]  = "nullable";
                $rules["size_" . $size . "_sale"]  = "nullable";
                $rules["size_" . $size . "_length"]  = "nullable";
                $rules["size_" . $size . "_width"]  = "nullable";
                $rules["size_" . $size . "_height"]  = "nullable";
                $rules["size_" . $size . "_product_size"]  = "nullable";
                $rules["size_" . $size . "_discount_percent"]  = "nullable";
                $rules["size_" . $size . "_discount_price"]  = "nullable";
                $rules["size_" . $size . "_discount_apply_on"]  = "nullable";

                $params_data['variation_sizes'][$size] = $temp_params;
            }
        }


        $messages = [
            'title_breadcrumb.unique' => 'Product Already Exists'
        ];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        // dd($params_data);
        $data = [];
        if (empty($this->errors)) {
            $response =  $objProduct->addProduct($params_data);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            if (!empty($sizes)) {
                $sizes_data = [];
                foreach ($sizes as $size) {
                    $size_obj = DB::table('sizes as s')->where('s.size_id', $size)->first();
                    $sizes_data[$size_obj->size_id] = $obj_size_helper->getSizeHtml($size_obj);
                }

                $data['size_results'] = $sizes_data;
            }

            return redirect()->back()->with($data)->withInput($request->all());
        }
        return redirect()->back()->with($data);
    }

    public function updateProductPage(Request $request, ProductModel $objProduct, ProductSizeHelper $obj_size_helper)
    {

        $data = [];

        $product_obj = DB::table('products as p')->where('p.product_id', $request->product_id)->first();

        if (empty($request->product_id) || empty($product_obj)) {
            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = ['Your Product Id is wrong!'];
            return redirect()->back()->with($data)->withInput($request->all());
        }

        $sizes = json_decode(session()->get('add_sizes'));

        $product_title_breadcrumb = strtolower(str_replace(array("\r\n", "\r", " ", "!", "=", "/", ".", '"', "&", "'", ",", "#"), '-', $request->get('title')));
        $product_title_breadcrumb = str_replace(['---', '--', '--', "+-"], '-', $product_title_breadcrumb);
        $title_breadcrumb = rtrim($product_title_breadcrumb, '-');

        $params = [
            'title' => $request->get('title'),
            'title_breadcrumb' => $title_breadcrumb,
            'description' => $request->get('description'),
            'ingredients' => $request->get('ingredients'),
            'status' => $request->get('status'),
            'all_categories' => $request->get('all_categories'),
            'all_brands' => $request->get('all_brands'),
            'all_vendors' => $request->get('all_vendors'),
            'sizes' => $sizes,
        ];

        $rules = [
            'title' => 'required|string',
            'title_breadcrumb' => 'required',
            'description' => 'required',
            'ingredients' => 'nullable',
            'status' => 'required',
            'all_categories' => 'required',
            'all_brands' => 'required',
            'all_vendors' => 'required',
            'sizes' => 'required',
        ];


        $params_data = $params;

        if (!empty($sizes)) {

            foreach ($sizes as $size) {

                $temp_params = [];

                $temp_params["size_" . $size . "_sku"]  = $request->get("size_" . $size . "_sku");
                $temp_params["size_" . $size . "_upc"]  = $request->get("size_" . $size . "_upc");
                $temp_params["size_" . $size . "_qty"]  = $request->get("size_" . $size . "_qty");
                $temp_params["size_" . $size . "_mfn"]  = $request->get("size_" . $size . "_mfn");
                $temp_params["size_" . $size . "_vprice"]  = $request->get("size_" . $size . "_vprice");
                $temp_params["size_" . $size . "_sprice"]  = $request->get("size_" . $size . "_sprice");
                $temp_params["size_" . $size . "_rprice"]  = $request->get("size_" . $size . "_rprice");
                $temp_params["size_" . $size . "_sale"]  = $request->get("size_" . $size . "_sale");
                $temp_params["size_" . $size . "_length"]  = $request->get("size_" . $size . "_length");
                $temp_params["size_" . $size . "_width"]  = $request->get("size_" . $size . "_width");
                $temp_params["size_" . $size . "_height"]  = $request->get("size_" . $size . "_height");
                $temp_params["size_" . $size . "_product_size"]  = $request->get("size_" . $size . "_product_size");
                $temp_params["size_" . $size . "_discount_percent"]  = $request->get("size_" . $size . "_discount_percent");
                $temp_params["size_" . $size . "_discount_price"]  = $request->get("size_" . $size . "_discount_price");
                $temp_params["size_" . $size . "_discount_apply_on"]  = $request->get("size_" . $size . "_discount_apply_on");


                $params = array_merge($params, $temp_params);

                $rules["size_" . $size . "_sku"]  = "nullable";
                $rules["size_" . $size . "_upc"]  = "required";
                $rules["size_" . $size . "_qty"]  = "required";
                $rules["size_" . $size . "_mfn"]  = "nullable";
                $rules["size_" . $size . "_vprice"]  = "required";
                $rules["size_" . $size . "_sprice"]  = "required";
                $rules["size_" . $size . "_rprice"]  = "nullable";
                $rules["size_" . $size . "_sale"]  = "nullable";
                $rules["size_" . $size . "_length"]  = "nullable";
                $rules["size_" . $size . "_width"]  = "nullable";
                $rules["size_" . $size . "_height"]  = "nullable";
                $rules["size_" . $size . "_product_size"]  = "nullable";
                $rules["size_" . $size . "_discount_percent"]  = "nullable";
                $rules["size_" . $size . "_discount_price"]  = "nullable";
                $rules["size_" . $size . "_discount_apply_on"]  = "nullable";

                $params_data['variation_sizes'][$size] = $temp_params;
            }
        }

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);

        $this->errors = array_merge($this->errors, $validation->messages()->all());
        // dd($this->errors);



        // dd($params_data);

        if (empty($this->errors)) {
            $response =  $objProduct->updateProduct($params_data, $product_obj);
            $data['message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;

            if (!empty($sizes)) {
                $sizes_data = [];
                foreach ($sizes as $size) {
                    $size_obj = DB::table('sizes as s')->where('s.size_id', $size)->first();
                    $sizes_data[$size_obj->size_id] = $obj_size_helper->getSizeHtml($size_obj);
                }

                $data['size_results'] = $sizes_data;
                // dd($data);
            }

            return redirect()->back()->with($data)->withInput($request->all());
        }
        return redirect()->back()->with($data);
    }

    public function deleteProduct(Request $request, $product_id)
    {
        $objProduct = new ProductModel();
        $response = $objProduct->deleteProductById($product_id);

        $data['delete_message'] = ($response['status'] == 200) ? $response['message'] : 'Something went wrong!';

        return redirect()->back()->with($data);
    }

    public function addProductSize(Request $request)
    {

        $ses_data = !empty(session()->get('add_sizes')) ? json_decode(session()->get('add_sizes'), 1) : [];

        $data = [];

        $params = [
            'size' => $request->get('size'),
        ];

        $rules = [
            'size' => 'required',
        ];


        $validation = Validator::make($params, $rules, []);

        $this->errors = array_merge($this->errors, $validation->messages()->all());

        if (!empty($this->errors)) {
            $data['status'] = 404;
            $data['message'] = 'Select a Size';
            $data['data'] = [];
            return json_encode($data);
        }


        $size = $request->get('size');

        $find_size = DB::table('sizes as s')->where('s.value', $size)->first();

        if (empty($find_size)) {
            $data['status'] = 404;
            $data['message'] = 'Select a  Valid Size';
            $data['data'] = [];
            return json_encode($data);
        }

        if (in_array($find_size->size_id, $ses_data)) {
            $data['status'] = 404;
            $data['message'] = 'Already Added this Size';
            $data['data'] = [];
            return json_encode($data);
        }

        $ses_data[$find_size->size_id] = $find_size->size_id;

        session(['add_sizes' => json_encode($ses_data)]);

        $obj_psize_hel = new ProductSizeHelper();

        $html = $obj_psize_hel->getSizeHtml($find_size);

        $data['status'] = 200;
        $data['message'] = 'Successfully Create Size ' . $find_size->value;
        $data['data'] = $html;

        return json_encode($data);
    }



    public function removeProductSize(Request $request)
    {

        $sizes = json_decode(session()->get('add_sizes'), 1);
        $sizes_results = session()->get('size_results');

        unset($sizes[$request->get('delete_id')]);
        unset($sizes_results[$request->get('delete_id')]);

        session(['add_sizes' => json_encode($sizes)]);
        session(['size_results' => $sizes_results]);
    }

    protected function register(Request $request)
    {
        $data = $request->validate([
            'phone_number' => 'required',
        ]);
        $number = $request->input('phone_number');
        $output = preg_replace('/[^0-9]/', '', $number);
        $phone_format = '+' . $output;
        $check_duplicate_record = User::where('phone_number', $phone_format)->count();

        if (empty($check_duplicate_record)) {
            return \App::call('App\Http\Controllers\Auth\RegisterController@message');
        } else {
            return $this->create($phone_format);
        }
    }


    protected function create($phone_format)
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        // dd($twilio);
        try {
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($phone_format, "sms");
        } catch (\Throwable $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
