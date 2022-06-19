<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            [
                'components/admin/add_category',
                'components/admin/all_categories',
                'components/admin/update_category',
            ],
            \App\Http\Composers\CategoriesDataComposer::class
        );
        View::composer(
            [
                'components/admin/all_brands',
            ],
            \App\Http\Composers\BrandsDataComposer::class
        );
        View::composer(
            [
                'components/admin/all_vendors',
            ],
            \App\Http\Composers\VendorsDataComposer::class
        );
        View::composer(
            [
                'components/admin/add_product',
                'components/admin/edit_product',
            ],
            \App\Http\Composers\AddUpdateProductDataComposer::class
        );
        View::composer(
            [
                'components/admin/edit_product',
            ],
            \App\Http\Composers\SingleProductDataComposer::class
        );
        View::composer(
            [
                'components/admin/all_products',
            ],
            \App\Http\Composers\AllProductsDataComposer::class
        );
        View::composer(
            [
                'components/admin/upload_product_image',
            ],
            \App\Http\Composers\UploadProductImagesDataComposer::class
        );
        View::composer(
            [
                'components/admin/phillips_api',
            ],
            \App\Http\Composers\PhillipsPetApiDataComposer::class
        );
        View::composer(
            [
                'components/admin/endless_api',
            ],
            \App\Http\Composers\EndlessApiDataComposer::class
        );
        View::composer(
            [
                'components/admin/all_sizes',
            ],
            \App\Http\Composers\SizesDataComposer::class
        );
        View::composer(
            [
                'components/admin/leemarpet_sheet',
            ],
            \App\Http\Composers\LeeMarPetSheetsDataComposer::class
        );
        View::composer(
            [
                'components/admin/dashboard',
            ],
            \App\Http\Composers\DashboardDataComposer::class
        );
        View::composer(
            [
                'components/admin/customer_order_dashboard',
            ],
            \App\Http\Composers\CustomerOrdersDashboardDataComposer::class
        );
        View::composer(
            [
                'components/admin/vendor_order_dashboard',
            ],
            \App\Http\Composers\VendorOrdersDashboardDataComposer::class
        );
        View::composer(
            [
                'components/admin/navigation_bar',
                'components/admin/left_navigation'
            ],
            \App\Http\Composers\AdminNavigationBarComposer::class
        );
        View::composer(
            [
                'components/admin/all_orders',
            ],
            \App\Http\Composers\OrdersDataComposer::class
        );

        View::composer(
            [
                'components/admin/vendor_all_orders',
            ],
            \App\Http\Composers\VendorOrdersDataComposer::class
        );

        View::composer(
            [
                'components/admin/all_users_for_admin',
            ],
            \App\Http\Composers\AllUsersForAdminDataComposer::class
        );

        View::composer(
            [
                'components/admin/user_profile',
            ],
            \App\Http\Composers\UserProfileDataComposer::class
        );

        View::composer(
            [
                'components/admin/categories_validation',
                'components/admin/all_validate_categories',
            ],
            \App\Http\Composers\CategoryValidationDataComposer::class
        );
        View::composer(
            [
                'components/admin/single_validate_category',
            ],
            \App\Http\Composers\SingleCategoryValidationDataComposer::class
        );







        View::composer(
            [
                'components/front/desktop/shop_by_category',
                'components/front/mobile/m_shop_by_category',
            ],
            \App\Http\Composers\ShopByCategoryDataComposer::class
        );

        // View::composer(
        //     [
        //         'components/front/desktop/navigation'
        //     ],
        //     \App\Http\Composers\NavigationsDataComposer::class
        // );

        View::composer(
            [
                'components/front/desktop/shop',
                'components/front/mobile/m_shop',
                'components/front/desktop/single_product'
            ],
            \App\Http\Composers\BreadCrumbDataComposer::class
        );

        View::composer(
            [
                'components/front/desktop/shop',
                'components/front/mobile/m_shop',
                'components/front/mobile/m_search_categories_panel',
                'components/front/desktop/navigation'
            ],
            \App\Http\Composers\ShopDataComposer::class
        );

        View::composer(
            [
                'components/front/desktop/checkout',
                'components/front/mobile/m_checkout',
            ],
            \App\Http\Composers\CheckOutDataComposer::class
        );

        View::composer(
            [
                'components/front/desktop/top_bar',
                'components/front/mobile/m_top_bar',
                'components/front/desktop/cart',
                'components/front/mobile/m_cart',
                'components/front/desktop/checkout',
                'components/front/mobile/m_checkout',
            ],
            \App\Http\Composers\TopBarDataComposer::class
        );

    }
}
