<?php

namespace App\Http\Controllers\Admin;

use App\Imports\LeeMarPet;
use App\Imports\PhillipsPet;
use App\Imports\EndlessImporter;
use DB;
use Illuminate\Http\Request;
use App\Models\PhilipsPetModel;
use App\Models\EndlessModel;
use Exception;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class UploadProductsController extends ViewComposingController
{
    // public function getHomePage()
    // {

    //     return $this->buildTemplate('home');
    // }


    public function getPhillipsPetByApiPage()
    {
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'phillipspet')->first();

        $vendor_id = $getVendorId->vendor_id;

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'PhillipsPet';
            $insert_vendor['breadcrumb'] = 'phillipspet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $count = DB::table('vendor_categories as vc')->where('vc.vendor_id', $vendor_id)->where('vc.map_with', null)->count();
        $this->viewData['categories_mapped'] = ($count > 0) ? null : true;
        return $this->buildTemplate('phillips_api');
    }

    public function getEndlessByApiPage()
    {
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'endless-aisles')->first();

        $vendor_id = !empty($getVendorId->vendor_id) ? $getVendorId->vendor_id : '';
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'Endless Aisles';
            $insert_vendor['breadcrumb'] = 'endless-aisles';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $count = DB::table('vendor_categories as vc')->where('vc.vendor_id', $vendor_id)->where('vc.map_with', null)->count();

        $this->viewData['categories_mapped'] = ($count > 0) ? null : true;
        return $this->buildTemplate('endless_api');
    }

    public function getLeeMarPetBySheetPage()
    {
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'leemarpet')->first();

        $vendor_id = $getVendorId->vendor_id;

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'PhillipsPet';
            $insert_vendor['breadcrumb'] = 'phillipspet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $count = DB::table('vendor_categories as vc')->where('vc.vendor_id', $vendor_id)->where('vc.map_with', null)->count();
        $this->viewData['categories_mapped'] = ($count > 0) ? null : true;
        return $this->buildTemplate('leemarpet_sheet');
    }

    public function syncLeeMarPetBySheet(Request $request, $upload_numbers)
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'leemarpet')->first();

        $vendor_id = $getVendorId->vendor_id;
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'LeeMarPet';
            $insert_vendor['breadcrumb'] = 'leemarpet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $obj_lee = new LeeMarPet();
        $obj_lee->getSyncUploadPendingSheetRows($vendor_id, $upload_numbers);
        return redirect()->back();
    }

    public function uploadLeeMarPetBySheet(Request $request)
    {
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'leemarpet')->first();
        $vendor_id = $getVendorId->vendor_id;
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'LeeMarPet';
            $insert_vendor['breadcrumb'] = 'leemarpet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }
        $params = array();
        // dd($request->all());
        $params['upload_sheet'] = $request->file('upload_sheet');

        $rules = [
            'upload_sheet' => 'required'
        ];

        $messages = [];
        $validation = Validator::make($params, $rules, $messages);

        if (!empty($validation->messages()->all())) {
            return redirect()->back()->with(['errors' => 'Document required']);
        }


        $obj_lee = new LeeMarPet();
        $file = $request->file('upload_sheet');
        $obj_lee->UploadSheet($file, $vendor_id);
        return redirect()->back();
    }

    public function fetchdPhillipsPetByApiPage()
    {
        // dd('asd');
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'phillipspet')->first();
        // dd($getVendorId);
        $vendor_id = $getVendorId->vendor_id;
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'PhillipsPet';
            $insert_vendor['breadcrumb'] = 'phillipspet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $start = 1;
        $end = 9000;

        $endpoint = env('PHILLIPSPET_URL') . env('PHILLIPSPET_KEY') . "/$start/$end";
        // dd($endpoint);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        // $err = curl_error($ch);
        curl_close($ch);

        $response = json_decode($response);
        $items = $response->Items;

        // dd($items);
        foreach (array_chunk($items, 1000) as $items_c) {
            $data = array();
            $itr = 0;
            foreach ($items_c as $key => $item) {

                if (!empty($item->UPC1)) {

                    $get_products = PhilipsPetModel::where('upc1', $item->UPC1);
                } else if (!empty($item->UPC2)) {
                    $get_products = PhilipsPetModel::where('upc2', $item->UPC2);
                }

                if (empty($get_products->count()) && (!empty($item->UPC1) || !empty($item->UPC2))) {

                    $data[$itr]['case_qty'] = !empty($item->CaseQty) ? $item->CaseQty : '';
                    $data[$itr]['cat1'] = !empty($item->Cat1) ? $item->Cat1 : '';
                    $data[$itr]['cat2'] = !empty($item->Cat2) ? $item->Cat2 : '';
                    $data[$itr]['cat3'] = !empty($item->Cat3) ? $item->Cat3 : '';
                    $data[$itr]['in_stock'] = !empty($item->InStock) ? $item->InStock : NULL;
                    $data[$itr]['part_number'] = !empty($item->PartNumber) ? $item->PartNumber : '';
                    $data[$itr]['price_1'] = !empty($item->Price1)  ? $item->Price1 : '';
                    $data[$itr]['price_2'] = !empty($item->Price2)  ? $item->Price2 : '';
                    $data[$itr]['primary_animal'] = !empty($item->PrimaryAnimal) ? $item->PrimaryAnimal : '';
                    $data[$itr]['promo_end_date'] = !empty($item->PromoEndDate) ? $item->PromoEndDate : '';
                    $data[$itr]['promo_price_1'] = !empty($item->PromoPrice1) ? $item->PromoPrice1 : '';
                    $data[$itr]['promo_price_2'] = !empty($item->PromoPrice2)  ? $item->PromoPrice2 : '';
                    $data[$itr]['short_desc'] = !empty($item->ShortDesc) ? $item->ShortDesc : '';
                    $data[$itr]['uom1'] = !empty($item->UOM1) ? $item->UOM1 : '';
                    $data[$itr]['uom2'] = !empty($item->UOM2) ? $item->UOM2 : '';
                    $data[$itr]['upc1'] = !empty($item->UPC1) ? $item->UPC1 : '';
                    $data[$itr]['upc2'] = !empty($item->UPC2) ? $item->UPC2 : '';
                    $data[$itr]['vendor_name'] = !empty($item->VendorName) ? $item->VendorName : '';
                    $data[$itr]['weight_1'] = !empty($item->Weight1) ?  $item->Weight1 : '';
                    $data[$itr]['weight_2'] = !empty($item->Weight2) ? $item->Weight2 : '';
                }

                $itr++;
            }

            try {
                PhilipsPetModel::insert($data);
            } catch (Exception $ex) {
                dd($ex);
            }
        }







        $data = array();
        $itr = 0;

        foreach ($items as $key => $item) {


            if (empty($item->UPC1) && empty($item->UPC2)) {
                $get_p_number = PhilipsPetModel::where('part_number', $item->PartNumber)->count();
                if (empty($get_p_number)) {
                    $data[$itr]['case_qty'] = !empty($item->CaseQty) ? $item->CaseQty : '';
                    $data[$itr]['cat1'] = !empty($item->Cat1) ? $item->Cat1 : '';
                    $data[$itr]['cat2'] = !empty($item->Cat2) ? $item->Cat2 : '';
                    $data[$itr]['cat3'] = !empty($item->Cat3) ? $item->Cat3 : '';
                    $data[$itr]['in_stock'] = !empty($item->InStock) ? $item->InStock : NULL;
                    $data[$itr]['part_number'] = !empty($item->PartNumber) ? $item->PartNumber : '';
                    $data[$itr]['price_1'] = !empty($item->Price1)  ? $item->Price1 : '';
                    $data[$itr]['price_2'] = !empty($item->Price2)  ? $item->Price2 : '';
                    $data[$itr]['primary_animal'] = !empty($item->PrimaryAnimal) ? $item->PrimaryAnimal : '';
                    $data[$itr]['promo_end_date'] = !empty($item->PromoEndDate) ? $item->PromoEndDate : '';
                    $data[$itr]['promo_price_1'] = !empty($item->PromoPrice1) ? $item->PromoPrice1 : '';
                    $data[$itr]['promo_price_2'] = !empty($item->PromoPrice2)  ? $item->PromoPrice2 : '';
                    $data[$itr]['short_desc'] = !empty($item->ShortDesc) ? $item->ShortDesc : '';
                    $data[$itr]['uom1'] = !empty($item->UOM1) ? $item->UOM1 : '';
                    $data[$itr]['uom2'] = !empty($item->UOM2) ? $item->UOM2 : '';
                    $data[$itr]['upc1'] = !empty($item->UPC1) ? $item->UPC1 : '';
                    $data[$itr]['upc2'] = !empty($item->UPC2) ? $item->UPC2 : '';
                    $data[$itr]['vendor_name'] = !empty($item->VendorName) ? $item->VendorName : '';
                    $data[$itr]['weight_1'] = !empty($item->Weight1) ?  $item->Weight1 : '';
                    $data[$itr]['weight_2'] = !empty($item->Weight2) ? $item->Weight2 : '';
                }
            }

            $itr++;
        }

        PhilipsPetModel::insert($data);



        return redirect()->back();
    }

    public function uploadPhillipsPetByApiPage()
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'phillipspet')->first();

        $vendor_id = $getVendorId->vendor_id;

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'PhillipsPet';
            $insert_vendor['breadcrumb'] = 'phillipspet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $items = PhilipsPetModel::where('status', 'not_sync');

        $objImport = new PhillipsPet();

        $result = $objImport->uploadProductsByApi($items->get(), $vendor_id);

        return redirect()->back();
    }

    public function syncLeemarpetCategories(Request $request)
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'leemarpet')->first();

        $vendor_id = $getVendorId->vendor_id;
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'LeeMarPet';
            $insert_vendor['breadcrumb'] = 'leemarpet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $obj_lee = new LeeMarPet();
        $obj_lee->getSyncLeemarpetCategories($vendor_id);
        return redirect()->back();
    }

    public function syncPhillipsPetCategoriesByApiPage()
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'phillipspet')->first();

        $vendor_id = $getVendorId->vendor_id;

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'PhillipsPet';
            $insert_vendor['breadcrumb'] = 'phillipspet';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $items = PhilipsPetModel::where('status', 'not_sync');

        $objImport = new PhillipsPet();
        // dd($items->get());
        $result = $objImport->uploadProductsCategoriesByApi($items->get(), $vendor_id);

        return redirect()->back();
    }

    public function syncEndlessCategories()
    {
        // dd('asd');
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'endless-aisles')->first();
        // dd($getVendorId);
        $vendor_id = !empty($getVendorId->vendor_id) ? $getVendorId->vendor_id : '';
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'Endless Aisles';
            $insert_vendor['breadcrumb'] = 'endless-aisles';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $objImport = new EndlessImporter();

        $result = $objImport->uploadEndlessCategories( $vendor_id);

        return redirect()->back();
    }

    public function fetchdEndlessByApiPage()
    {
        // dd('asd');
        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'endless-aisles')->first();
        // dd($getVendorId);
        $vendor_id = !empty($getVendorId->vendor_id) ? $getVendorId->vendor_id : '';
        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'Endless Aisles';
            $insert_vendor['breadcrumb'] = 'endless-aisles';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        // dd($vendor_id);
        $per_page = 5;

        // $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=4543";
        // $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=243";
        // $endpoint = "https://app-qa.endlessaisles.io/api/products?per_page=$per_page";
        $endpoint = "https://app-qa.endlessaisles.io/api/orders";
        // dd($endpoint);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'X-EA-REQUEST-TOKEN: 95687a6609f66954f5a48556ea868317'
            // 'X-EA-REQUEST-TOKEN: 75509131ad521fde9f074c911039c31d'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        // $err = curl_error($ch);
        curl_close($ch);
        $response = json_decode($response);

        $items = $response->data;

        dd($items);
        foreach (array_chunk($items, 1000) as $items_c) {
            $data = array();
            $itr = 0;
            foreach ($items_c as $key => $item) {

                $data[$itr]['product_id'] = !empty($item->id) ? $item->id : '';
                $data[$itr]['title'] = !empty($item->title) ? $item->title : '';
                $data[$itr]['brand'] = !empty($item->brand) ? $item->brand : '';
                $data[$itr]['description'] = !empty($item->description) ? $item->description : '';
                $data[$itr]['ingredients'] = !empty($item->ingredients) ? $item->ingredients : '';
                $data[$itr]['analysis'] = !empty($item->analysis) ? json_encode($item->analysis) : '';
                $data[$itr]['image_url'] = !empty($item->image_url) ? $item->image_url : '';
                $data[$itr]['additional_image_urls'] = !empty($item->additional_image_urls) ? json_encode($item->additional_image_urls) : '';
                $data[$itr]['metadata'] = !empty($item->metadata) ? json_encode($item->metadata) : '';
                $data[$itr]['sizes'] = !empty($item->sizes) ? json_encode($item->sizes) : '';
                $data[$itr]['status'] =  'not-synced';


                $itr++;
            }


            try {
                // dd($data);
                EndlessModel::insert($data);
            } catch (Exception $ex) {
                dd($ex);
            }
        }


        return redirect()->back();
    }

    public function uploadEndlessByApiPage()
    {

        $getVendorId = DB::table('vendors as v')->where('v.breadcrumb', 'endless-aisles')->first();

        $vendor_id = $getVendorId->vendor_id;
        // dd($vendor_id);

        if (empty($getVendorId->vendor_id)) {
            $insert_vendor = [];
            $insert_vendor['title'] = 'Endless Aisles';
            $insert_vendor['breadcrumb'] = 'endless-aisles';
            DB::table('vendors')->insert($insert_vendor);
            $vendor_id = DB::getPdo()->lastInsertId();
        }

        $items = EndlessModel::where('status', 'not-synced')->take(20);
        // dd($items);

        $objImport = new EndlessImporter();

        $result = $objImport->uploadProductsByApi($items->get(), $vendor_id);

        return redirect()->back();
    }
}
