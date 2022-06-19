<?php

namespace App\Http\Controllers\Admin;

class HomePageController extends ViewComposingController
{
    public function getHomePage()
    {





        // $details = [
        //     'title' => 'asdasdasdasdasd',
        //     'body'  => 'kasjdhkashdkjhasjkdhkjashdkjhaksjdhkahskdjh'
        // ];

        // Mail::to('mister_saqib@rocketmail.com')->send(new TestMail($details));
        // die('email send');

        // $endpoint = "https://posservicestest.phillipspet.com/pos/CustomerCatalog/V2/15E17F3581D0409592ED456D206E2923/1/6000";
        // $client = new \GuzzleHttp\Client();

        // $response = $client->request('GET', $endpoint, ['query' => []]);

        // $message ='Your message';
        // $url = $endpoint;

        //    $ch = curl_init();
        //    curl_setopt($ch, CURLOPT_URL, $url);
        //    curl_setopt($ch, CURLOPT_POST, 0);
        //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //    $response = curl_exec ($ch);
        //    $err = curl_error($ch);  //if you need
        //    curl_close ($ch);
        // //    return $response;
        // $response = json_decode($response);

        // $data = [];
        // foreach ($response->Items as $key => $value) {
        //     $data[$value->VendorName] = $value->VendorName;
        // }
        // dd($data);
        // $obj_lee = new LeeMarPet();
        // $file = public_path('/LeeMarPet.xls');
        // $obj_lee->UploadSheet($file);

        // $provider = new ExpressCheckout;


        return $this->buildTemplate('home');
    }
}
