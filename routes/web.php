<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::group(['middleware' => ['checkuser']], function () {


    /*
    * Front Pages Links
    */

    Route::get('/checkout.html', 'Front\ShoppingCartController@getCheckout');
    Route::get('/paypal_execution.html', 'Front\ShoppingCartController@getPaypalExecution');
    Route::get('/paypal_cencel.html', 'Front\ShoppingCartController@getPaypalCencelInformation');
    Route::post('/checkout.html', 'Front\ShoppingCartController@postCheckoutDetails');
    Route::post('/get-tax', 'Front\ShoppingCartController@getTax');

    Route::get('/order-complete/{order_id?}', 'Front\ShoppingCartController@getOrderComplete');



    /*
    * Admin Links
    */
    Route::get('/user/logout', 'Admin\UsersPageController@getLogout');

    Route::group(['middleware' => ['dash_access:super-admin']], function () {
        Route::get('/admin/dashboard', 'Admin\HomePageController@getHomePage');
    });

    // Route::group(['middleware' => ['check_customer_order']], function () {
    Route::get('/admin/customer-orders/all-customer-orders', 'Admin\OrdersController@getAllOrders');
    Route::get('/admin/customer-orders/order-view/{id}', 'Admin\OrdersController@getViewOrder');
    // });





    Route::get('/admin/users/profile-update', 'Admin\UsersPageController@getSelfUserProfile');
    Route::post('/admin/users/profile-update', 'Admin\UsersPageController@postSelfUserProfile');




    Route::group(['middleware' => ['user_level:super-admin']], function () {

        Route::get('/admin/customer-orders/dashboard-customer-orders', 'Admin\OrdersController@getCustomerOrderDashboard');
        Route::post('/admin/vendors/send-to-vendors', 'Admin\OrdersController@sendToVendors');


        Route::post('/admin/products/add-size', 'Admin\ProductsController@addProductSize');
        Route::post('/admin/products/remove-size', 'Admin\ProductsController@removeProductSize');
        /*
        *  Admin Brands Routes
        */
        Route::get('/admin/brand/add-brand', 'Admin\BrandsController@getAddBrandsPage');
        Route::post('/admin/brand/add-brand', 'Admin\BrandsController@addBrand');
        Route::get('/admin/brand/all-brands', 'Admin\BrandsController@getAllBrandsPage');
        Route::get('/admin/brand/delete/{id}', 'Admin\BrandsController@deleteBrand');
        Route::get('/admin/brand/edit/{id}', 'Admin\BrandsController@updateBrand');
        Route::post('/admin/brand/update-brand', 'Admin\BrandsController@submitUpdateBrand');


        /*
        *  Admin Vendor Routes
        */
        Route::get('/admin/vendor/add-vendor', 'Admin\VendorsController@getAddVendorsPage');
        Route::post('/admin/vendor/add-vendor', 'Admin\VendorsController@addVendor');
        Route::get('/admin/vendor/all-vendors', 'Admin\VendorsController@getAllVendorsPage');
        Route::get('/admin/vendor/delete/{id}', 'Admin\VendorsController@deleteVendor');
        Route::get('/admin/vendor/edit/{id}', 'Admin\VendorsController@updateVendors');
        Route::post('/admin/vendor/update-vendor', 'Admin\VendorsController@submitUpdateVendor');


        /*
        *  Admin Sizes Routes
        */

        Route::get('/admin/size/add-size', 'Admin\SizesController@getAddSizesPage');
        Route::post('/admin/size/add-size', 'Admin\SizesController@addSize');
        Route::get('/admin/size/all-sizes', 'Admin\SizesController@getAllSizesPage');
        Route::get('/admin/size/delete/{id}', 'Admin\SizesController@deleteSize');
        Route::get('/admin/size/edit/{id}', 'Admin\SizesController@updateSize');
        Route::post('/admin/size/update-size', 'Admin\SizesController@submitUpdateSize');

        /*
        *  Admin Categories Routes
        */
        Route::get('/admin/category/all-categories', 'Admin\CategoriesController@getAllCategoriesPage');
        Route::get('/admin/category/add-category', 'Admin\CategoriesController@getAddCategoryPage');
        Route::post('/admin/category/add-category', 'Admin\CategoriesController@addCategory');
        Route::get('/admin/category/delete/{id}', 'Admin\CategoriesController@deleteCategory');
        Route::get('/admin/category/edit/{id}', 'Admin\CategoriesController@updateCategory');
        Route::post('/admin/category/update-category', 'Admin\CategoriesController@submitUpdateCategory');

        /*
        *  Admin Categories Validation Routes
        */
        Route::get('/admin/category-validation/vendor-{vendor_id}', 'Admin\CategoriesController@getAllVendorCategoriesValidationPage');
        Route::get('/admin/category-validation/all-{show_type}-{vendor_id}', 'Admin\CategoriesController@getAllVendorMappedUnMappedCategoriesPage');
        Route::get('/admin/category-validation/all-vendor-category-{vendor_id}/{cat_id}', 'Admin\CategoriesController@getAllVendorUnMappedCategoriesPage');
        Route::post('/admin/category-validation/all-vendor-category-{vendor_id}/{cat_id}', 'Admin\CategoriesController@postVendorMapCategory');
        Route::get('/admin/category-validation/add-vendor-category-{vendor_id}/{cat_id}', 'Admin\CategoriesController@addVendorMapCategory');
        Route::get('/admin/category-validation/sync-vendor-category-{vendor_id}/{cat_id}', 'Admin\CategoriesController@syncVendorMapCategory');




        /*
        *  Admin User Routes
        */
        Route::get('/admin/users/add-user', 'Admin\UsersPageController@getAddUsersPage');
        Route::post('/admin/users/add-user', 'Admin\UsersPageController@addUser');
        Route::get('/admin/users/all-users', 'Admin\UsersPageController@getAllUsers');
        Route::get('/admin/users/{user_id}/details', 'Admin\UsersPageController@getUserProfileForAdmin');
        Route::get('/admin/users/{user_id}/update', 'Admin\UsersPageController@getUpdateUserProfile');
        Route::post('/admin/users/{user_id}/update', 'Admin\UsersPageController@updateUserProfile');
        // Route::get('/admin/users/{user_id}/action', 'Admin\UsersPageController@getUserAction');
        Route::post('/admin/users/delete/', 'Admin\UsersPageController@userDelete');


        /*
        *  Order Update Call
        */
        Route::post('/admin/orders/update-order', 'Admin\OrdersController@updateOrder');
    });

    Route::group(['middleware' => ['user_level:super-admin,vendor']], function () {


        Route::get('/admin/vendor-orders/dashboard-vendor-orders', 'Admin\OrdersController@getVendorsOrderDashboard');

        Route::group(['middleware' => ['check_vendor']], function () {
            Route::get('/admin/vendor-orders/all-vendor-orders/{vendor_id}', 'Admin\OrdersController@getAllVendorOrders');
            Route::get('/admin/vendor-orders/vendor/{vendor_id}/order/{order_id}', 'Admin\OrdersController@getViewVendorOrder');

            Route::post('/admin/vendor-orders/{vendor_id}/update-order/{order_id}', 'Admin\OrdersController@updateVendorOrder');
        });
    });

    Route::group(['middleware' => ['user_level:super-admin,developer,vendor']], function () {
        Route::get('/admin/products/all-products', 'Admin\ProductsController@getAllProducts');
    });

    Route::group(['middleware' => ['user_level:super-admin,developer']], function () {
        /*
        *  Admin Product Routes
        */
        Route::get('/admin/products/add-variation-product', 'Admin\ProductsController@getAddProductPage');
        Route::post('/admin/products/add-variation-product', 'Admin\ProductsController@addVariationProduct');
        Route::get('/admin/products/{product_id}', 'Admin\ProductsController@getSingleProductDetails');
        Route::get('/admin/products/{product_id}/upload-image/', 'Admin\ProductsController@getProductImageUploads');
        Route::post('/admin/products/{product_id}/upload-image/', 'Admin\ProductsController@uploadProductImages');
        Route::get('/admin/products/{product_id}/remove-image/{image_number}/', 'Admin\ProductsController@removeProductImage');
        Route::get('/admin/products/edit/{product_id}/', 'Admin\ProductsController@getEditProductPage');
        Route::post('/admin/products/edit/{product_id}/', 'Admin\ProductsController@updateProductPage');
        Route::get('/admin/products/delete/{product_id}/', 'Admin\ProductsController@deleteProduct');


        /*
        *  Admin: Upload Product Using Api and Sheets
        */
        Route::get('/admin/upload-products/phillipspet-by-api/', 'Admin\UploadProductsController@getPhillipsPetByApiPage');
        Route::get('/admin/upload-products/leemarpet-by-sheet/', 'Admin\UploadProductsController@getLeeMarPetBySheetPage');
        Route::get('/admin/upload-products/endless-by-api/', 'Admin\UploadProductsController@getEndlessByApiPage');

        Route::post('/admin/upload-products/phillipspet-by-api/', 'Admin\UploadProductsController@uploadPhillipsPetByApiPage');
        Route::post('/admin/upload-products/sync-phillipspet-categories-by-api/', 'Admin\UploadProductsController@syncPhillipsPetCategoriesByApiPage');
        Route::post('/admin/upload-products/fetch-phillipspet-by-api/', 'Admin\UploadProductsController@fetchdPhillipsPetByApiPage');

        Route::post('/admin/sync-leemarpet-categories/', 'Admin\UploadProductsController@syncLeemarpetCategories');
        Route::post('/admin/sync-upload-products/sync-leemarpet-by-sheet/{upload_numbers}', 'Admin\UploadProductsController@syncLeeMarPetBySheet');
        Route::post('/admin/upload-products/leemarpet-by-sheet/', 'Admin\UploadProductsController@uploadLeeMarPetBySheet');

        Route::post('/admin/upload-products/fetch-endless-by-api/', 'Admin\UploadProductsController@fetchdEndlessByApiPage');
        Route::post('/admin/sync-endless-categories/', 'Admin\UploadProductsController@syncEndlessCategories');
        Route::post('/admin/upload-products/endless-by-api/', 'Admin\UploadProductsController@uploadEndlessByApiPage');
    });
});

Route::group(['middleware' => ['user_not_login']], function () {
    Route::post('/admin/login', 'Admin\UsersPageController@checkUser');
    Route::get('/admin/login', 'Front\UsersController@getLogin');
    Route::get('/activation_user', 'Front\UsersController@getActivationLink');
    Route::get('/register.html', 'Front\UsersController@getRegister');
    Route::post('/register.html', 'Front\UsersController@postRegisterForm');
    Route::get('/verify-account.html', 'Front\UsersController@getVerifyAccount');
    Route::get('/password-reset.html', 'Front\UsersController@getPasswordReset');
    Route::post('/password-reset.html', 'Front\UsersController@postPasswordReset');
    Route::get('/password-reset-email.html', 'Front\UsersController@getPasswordResetEmail');
    Route::post('/password-reset-email.html', 'Front\UsersController@postPasswordResetEmail');
});




/*
 * Front Pages Links
 */



Route::get('/', 'Front\HomePageController@getHomePage');
Route::get('/about-us.html', 'Front\HomePageController@getAbout');
Route::get('/contact-us.html', 'Front\HomePageController@getContact');
Route::post('/contact-us.html', 'Front\HomePageController@postContactForm');
Route::get('/faqs.html', 'Front\HomePageController@getFaqs');
Route::get('/covid-faqs.html', 'Front\HomePageController@getCovidFaqs');
Route::get('/terms-and-conditions.html', 'Front\HomePageController@getTermsConditions');
Route::get('/privacy-policy.html', 'Front\HomePageController@getPrivacyPolicy');
Route::get('/return-policy.html', 'Front\HomePageController@getReturnPolicy');
Route::get('/anti-animal-cruelty-and-torture-policy.html', 'Front\HomePageController@getAnimalTorturePolicy');
Route::get('/human-rights-act.html', 'Front\HomePageController@getHumanRightsAct');
Route::get('/human-rights-policy.html', 'Front\HomePageController@getHumanRightsPolicy');
Route::get('/modern-slavery-policy.html', 'Front\HomePageController@getModernSlaveryPolicy');
Route::get('/anti-discriminatory-policy.html', 'Front\HomePageController@getAntiDiscriminatoryPolicy');
Route::get('/california-transparency-of-supplier-code.html', 'Front\HomePageController@getCaliforniaCode');
Route::get('/pet-care.html', 'Front\HomePageController@getPetCare');
Route::get('/pet-insurance.html', 'Front\HomePageController@getPetInsurance');
Route::get('/pet-travel.html', 'Front\HomePageController@getPetTravel');
Route::get('/policies.html', 'Front\HomePageController@getPolicies');
Route::get('/not-found.html', 'Front\HomePageController@getNotFound');

Route::get('/product.html', 'Front\HomePageController@getProduct');
Route::get('/shop.html', 'Front\SearchPageController@getShop');
Route::get('/search.html', 'Front\SearchPageController@getShop');
Route::get('/view-cart.html', 'Front\ShoppingCartController@getCart');

Route::post('/cart/add-to-cart', 'CartController@addToCart');
Route::post('/cart/delete-to-cart', 'CartController@deleteToCart');
Route::get('/cart/delete-cart-data/{cart_key}', 'CartController@deleteToCartByGet');
Route::post('/cart/update-cart', 'CartController@updateCartData');

Route::get('/{bread}_{product_id}.html', 'Front\ProductsController@getSingleProductDetails');
Route::get('/{cat_title}/', 'Front\SearchPageController@getSearchPage');
