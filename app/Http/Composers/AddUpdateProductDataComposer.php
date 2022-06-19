<?php

namespace App\Http\Composers;

use Illuminate\View\View;

use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\VendorModel;
use App\Models\SizeModel;

class AddUpdateProductDataComposer
{

    public function compose(View $view)
    {

        $objCat = new CategoryModel();
        $objBrand = new BrandModel();
        $objVendor = new VendorModel();
        $objSize = new SizeModel();

        $categories = $objCat->getCategoryDropdowns();
        $brands = $objBrand->getBrandDropdowns();
        $vendors = $objVendor->getVendorDropdowns();
        $sizes = $objSize->getAllSizesForDropDown();

        $view->with('categories', $categories)
            ->with('brands', $brands)
            ->with('sizes', $sizes)
            ->with('vendors', $vendors);
    }
}
