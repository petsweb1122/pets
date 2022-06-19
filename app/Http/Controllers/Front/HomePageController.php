<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Validator;
use App\Mail\CustomerContactUsMail;
use App\Mail\CustomerContactUsToAdminMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Front\ViewComposingController;

class HomePageController extends ViewComposingController
{
    private $errors = array();

    public function getHomePage()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('home');
    }

    public function getAbout()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('about-us');
    }

    public function getContact()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('contact-us');
    }

    public function postContactForm(Request $request)
    {
        // dd($request->all());
        $params = array();

        $params['first_name'] = $request->get('first_name');
        $params['last_name'] = $request->get('last_name');
        $params['email'] = $request->get('email');
        $params['purpose'] = $request->get('purpose');
        $params['message'] = $request->get('message');


        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'string|nullable',
            'email' => 'nullable|email',
            'purpose' => 'required',
            'message' => 'required|min:15'
        ];

        $messages = [];

        $validation = Validator::make($params, $rules, $messages);
        $this->errors = array_merge($this->errors, $validation->messages()->all());
        $data = [];
        if (empty($this->errors)) {

            Mail::to('evslearnings@gmail.com')->send(new CustomerContactUsToAdminMail($params));
            Mail::to($params['email'])->send(new CustomerContactUsMail($params));


            $data['message'] = 'Email Succesfully Sent!';
        } else {

            $data['message'] = 'Validation Error!';
            $data['error'] = true;
            $data['errors'] = $this->errors;
            return redirect()->back()->with($data)->withInput($request->all());
        }

        return redirect()->back()->with($data);
    }

    public function getFaqs()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('faqs');
    }

    public function getCovidFaqs()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('covid-faqs');
    }

    public function getTermsConditions()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('terms-and-conditions');
    }

    public function getPrivacyPolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('privacy-policy');
    }

    public function getReturnPolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('return-policy');
    }

    public function getAnimalTorturePolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('anti-animal-cruelty-and-torture-policy');
    }

    public function getHumanRightsAct()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('human-rights-act');
    }

    public function getHumanRightsPolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('human-rights-policy');
    }

    public function getModernSlaveryPolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('modern-slavery-policy');
    }

    public function getAntiDiscriminatoryPolicy()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('anti-discriminatory-policy');
    }

    public function getCaliforniaCode()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('california-transparency-of-supplier-code');
    }

    public function getPetCare()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('pet-care');
    }

    public function getPetTravel()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('pet-travel');
    }

    public function getPetInsurance()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('pet-insurance');
    }

    public function getPolicies()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('policies');
    }

    public function getOrderComplete()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('order-complete');
    }

    public function getOrderStatus()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('order-status');
    }

    public function getNotFound()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('not-found');
    }

    public function getProduct()
    {

        $this->viewData['seo_title'] = "";
        $this->viewData['seo_description'] = "";
        return $this->buildTemplate('single-product');
    }
}
