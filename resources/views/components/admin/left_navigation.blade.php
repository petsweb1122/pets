<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        @if ($user_data->role == 'super-admin')
            <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                <a title="Dashboard" href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="treeview  {{ Request::segment(2) == 'users' ? 'active' : '' }}">
                <a href="#" title="Users">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-users' ? 'active' : '' }}"><a
                            href="{{ url('admin/users/all-users') }}" title="All Users"><i
                                class="fa fa-user-circle"></i> All Users</a>
                    </li>
                    <li class="{{ Request::segment(3) == 'add-user' ? 'active' : '' }}"><a
                            href="{{ url('admin/users/add-user') }}" title="Add New User"><i
                                class="fa fa-user-plus"></i> Add New User</a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ Request::segment(2) == 'category' ? 'active' : '' }}">
                <a href="#" title="Categories">
                    <i class="fa fa-list"></i>
                    <span>Categories</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-categories' ? 'active' : '' }}"><a
                            title="All Categories" href="{{ url('admin/category/all-categories/') }}"><i
                                class="fa fa-list-alt"></i> All
                            Categories</a></li>
                    <li class="{{ Request::segment(3) == 'add-category' ? 'active' : '' }}"><a
                            title="Add New Category" href="{{ url('admin/category/add-category/') }}" title=""><i
                                class="fa fa-plus"></i> Add
                            Category</a></li>
                </ul>
            </li>

            <li class="treeview {{ Request::segment(2) == 'category-validation' ? 'active' : '' }}">
                <a href="#" title="Categories Validation">
                    <i class="fa fa-list"></i>
                    <span>Categories Validation</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($vendor_categories as $category)
                    <li class="{{ Request::segment(3) == "vendor-$category->vendor_id" ? 'active' : '' }}">
                        <a title="All Categories" href="{{ url("admin/category-validation/vendor-$category->vendor_id/") }}">
                            <i class="fa fa-list-alt"></i> {{$category->title}} ({{$category->count}})
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li class="treeview {{ Request::segment(2) == 'brand' ? 'active' : '' }}">
                <a href="#" title="Brand">
                    <i class="fa fa-building"></i>
                    <span>Brand</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-brands' ? 'active' : '' }}"><a
                            href="{{ url('admin/brand/all-brands/') }}" title="All Brands"><i
                                class="fa fa-building-o"></i> All
                            Brands</a>
                    </li>
                    <li class="{{ Request::segment(3) == 'add-brand' ? 'active' : '' }}"><a
                            href="{{ url('admin/brand/add-brand/') }}" title="Add New Brand"><i
                                class="fa fa-plus"></i> Add Brand</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ Request::segment(2) == 'vendor' ? 'active' : '' }}">
                <a href="#" title="Vendor">
                    <i class="fa fa-vcard"></i>
                    <span>Vendors</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-vendors' ? 'active' : '' }}"><a
                            href="{{ url('admin/vendor/all-vendors/') }}" title="All Vendors"><i
                                class="fa fa-user-o"></i> All
                            Vendors</a>
                    </li>
                    <li class="{{ Request::segment(3) == 'add-vendor' ? 'active' : '' }}"><a
                            href="{{ url('admin/vendor/add-vendor/') }}" title="Add New Vendor"><i
                                class="fa fa-plus"></i> Add
                            Vendor</a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="treeview {{ Request::segment(2) == 'customer-orders' ? 'active' : '' }}">
            <a href="#" title="Orders">
                <i class="fa fa-pie-chart"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if ($user_data->role == 'super-admin')
                    <li class="{{ Request::segment(3) == 'dashboard-customer-orders' ? 'active' : '' }}"><a
                            href="{{ url('admin/customer-orders/dashboard-customer-orders/') }}" title="Dashboard"><i
                                class="fa fa-user-circle"></i> Dashboard</a></li>
                @endif
                <li class="{{ Request::segment(3) == 'all-customer-orders' ? 'active' : '' }}"><a
                        href="{{ url('admin/customer-orders/all-customer-orders/') }}" title="All Orders"><i
                            class="fa fa-user-circle"></i> All Orders</a></li>
            </ul>
        </li>

        @if ($user_data->role == 'super-admin' || $user_data->role == 'vendor')
            <li class="treeview {{ Request::segment(2) == 'vendor-orders' ? 'active' : '' }}">
                <a href="#" title="Vendor Orders">
                    <i class="fa fa-line-chart"></i>
                    <span>Vendor Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'dashboard-vendor-orders' ? 'active' : '' }}"><a
                            href="{{ url('admin/vendor-orders/dashboard-vendor-orders/') }}"
                            title="All Vendor Orders"><i class="fa fa-bar-chart-o"></i> All Vendors Orders</a></li>
                </ul>
            </li>
        @endif
        <li class="treeview {{ Request::segment(2) == 'size' ? 'active' : '' }}">
            <a href="#">
                <i class="fa fa-product-hunt"></i>
                <span>Sizes</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ Request::segment(3) == 'all-sizes' ? 'active' : '' }}"><a
                        href="{{ url('admin/size/all-sizes/') }}"><i class="fa fa-user-circle"></i> All Sizes</a>
                </li>
                <li class="{{ Request::segment(3) == 'add-size' ? 'active' : '' }}"><a
                        href="{{ url('admin/size/add-size/') }}"><i class="fa fa-user-plus"></i> Add Size</a></li>
            </ul>
        </li>
        @if ($user_data->role == 'super-admin' || $user_data->role == 'developer' || $user_data->role == 'vendor')
            <li class="treeview {{ Request::segment(2) == 'products' ? 'active' : '' }}">
                <a href="#" title="Products">
                    <i class="fa fa-product-hunt"></i>
                    <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-products' ? 'active' : '' }}"><a
                            href="{{ url('admin/products/all-products/') }}" title="All Products"><i
                                class="fa fa-industry"></i> All
                            Products</a></li>
                    @if ($user_data->role == 'super-admin' || $user_data->role == 'developer')
                        <li class="{{ Request::segment(3) == 'add-variation-product' ? 'active' : '' }}">
                            <a href="{{ url('admin/products/add-variation-product/') }}"
                                title="Add Variation Products"><i class="fa fa-plus"></i>
                                Add Variation Products
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if ($user_data->role == 'super-admin' || $user_data->role == 'developer')
            <li class="treeview {{ Request::segment(2) == 'upload-products' ? 'active' : '' }}">
                <a href="#" title="Upload Products">
                    <i class="fa fa-upload"></i>
                    <span>Upload Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(3) == 'all-products' ? 'active' : '' }}"><a
                            href="{{ url('admin/upload-products/phillipspet-by-api/') }}"
                            title="Upload Phillipspet By Api"><i class="fa fa-upload"></i>
                            Upload Phillipspet By Api</a></li>
                    <li class="{{ Request::segment(3) == 'all-products' ? 'active' : '' }}"><a
                            href="{{ url('admin/upload-products/endless-by-api/') }}"
                            title="Upload Phillipspet By Api"><i class="fa fa-upload"></i>
                            Upload Endless Products By Api</a></li>
                    <li class="{{ Request::segment(3) == 'add-variation-product' ? 'active' : '' }}"><a
                            href="{{ url('admin/upload-products/leemarpet-by-sheet/') }}"
                            title="Upload LeeMarPet By Sheet"><i class="fa fa-upload"></i>
                            Upload LeeMarPet By Sheet</a></li>
                </ul>
            </li>
        @endif

    </ul>
</section>
<!-- /.sidebar -->
