<style>
    .shop-listing {
        padding: 20px;
        text-align: center;
        zoom: .8
    }

    .small-product {
        width: 24%;
        display: inline-block;
        padding: 5px;
        vertical-align: top;
        background: #fff;
        border: 1px solid #eee;
        margin-bottom: 3px;
        text-align: -webkit-center;
    }

    .small-product .product-thumbnail {
        max-height: 150px;
        display: table-cell;
        vertical-align: middle;
        height: 150px !important;
    }

    .small-product .product-thumbnail img {
        width: 90%;
        max-height: 98%;
    }

    .sort-products-box {
        margin-bottom: 6px;
    }

    .sort-products {
        background: #fff;
        /*margin-left:-20px;
    margin-right:-20px;*/
        text-align: center;
        width: 100%;
        margin-top: 4px;
        box-shadow: 0px 0px 1px #ddd;
    }

    .sort-products p {
        margin: 0px;
    }

    .shop-helper {
        background: #eee;
        margin-left: -20px;
        margin-right: -20px;
        text-align: center;
        position: fixed;
        width: 100%;
        bottom: 0;
    }

    .shop-helper span {
        width: 23.8%;
        display: inline-block;
        background: #f2f2f2;
        font-size: 10px;
        margin: 0;
        padding: 4px;
        color: #333;
    }

    .shop-helper span svg {
        font-size: 20px;
    }

    .shop-helper span * {
        color: #333;
    }

    .price-wrapper p span {
        color: #d0011b;
    }

    .small-product .quick-view {
        display: inline-block;
        background-color: #7DC855;
        border-radius: 99px;
        font-size: 12px;
        color: #FFFFFF;
        text-decoration: none;
        padding: 4px 20px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
        cursor: pointer;
        font-weight: normal
    }

    .small-product .quick-view * {
        color: #fff;
    }

    .small-product .product-title {
        color: #333;
        height: 37px;
        line-height: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pagination {
        display: inline-block;
        margin-bottom: 10px;
    }

    .pagination a {
        color: #777;
        font-size: 13px;
        padding: 6px 12px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a.active {
        background-color: #4CAF50;
        padding: 6px 12px;
        cursor: text;
    }

    .pagination a.active span {
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    @media (max-width: 600px) {
        .small-product {
            width: 32%;
        }
    }

    @media (max-width: 450px) {
        .small-product {
            width: 48%;
        }
    }

</style>



<!--div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" title="Home"><i class="fa fa-home"></i>Home</a></li>
        <li class="breadcrumb-item"><a href="#" title="Shop">Shop</a></li>
        <li class="breadcrumb-item"><a href="#" title="Dog">dog</a>
        </li>
        <li class="breadcrumb-item"><a href="#" title="Treats">treats</a>
        </li>
        <li class="active breadcrumb-item">dry food</li>
    </ol>
</div-->






<div class="content">

    <div class="shop-listing shop-col">
        <div class="sort-products-box">
            <div class="shop-helper">
                <span><a href="{{ url('/') }}" title="Home">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="home" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                            class="svg-inline--fa fa-home fa-w-18">
                            <path fill="currentColor"
                                d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"
                                class=""></path>
                        </svg><br>Home
                </span></a>
                <span class="categories-panel-filter">
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="list-ul" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-list-ul fa-w-16">
                        <g class="fa-group">
                            <path fill="currentColor"
                                d="M496 384H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"
                                class="fa-secondary"></path>
                            <path fill="currentColor"
                                d="M48 48a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48z"
                                class="fa-primary"></path>
                        </g>
                    </svg><br>Categories
                </span>
                <span class="filter-button">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="filter" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="svg-inline--fa fa-filter fa-w-16">
                        <path fill="currentColor"
                            d="M479.968 0H32.038C3.613 0-10.729 34.487 9.41 54.627L192 237.255V424a31.996 31.996 0 0 0 10.928 24.082l64 55.983c20.438 17.883 53.072 3.68 53.072-24.082V237.255L502.595 54.627C522.695 34.528 508.45 0 479.968 0zM288 224v256l-64-56V224L32 32h448L288 224z"
                            class=""></path>
                    </svg><br>Filters
                </span>
                <span>
                    @if (request()->get('sort') == 'asc')
                        <a href="{{ $link_sort_desc }}" title="sort low to high">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort-amount-up-alt"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="svg-inline--fa fa-sort-amount-up-alt fa-w-16 fa-2x">
                                <path fill="currentColor"
                                    d="M240 96h64a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm0 128h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm256 192H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-256-64h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zM16 160h48v304a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V160h48c14.21 0 21.39-17.24 11.31-27.31l-80-96a16 16 0 0 0-22.62 0l-80 96C-5.35 142.74 1.78 160 16 160z"
                                    class=""></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ $link_sort_asc }}" title="sort high to low">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="sort-amount-down-alt"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="svg-inline--fa fa-sort-amount-down-alt fa-w-16">
                                <path fill="currentColor"
                                    d="M264 320h176a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8H264a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8zm0-192h48a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8h-48a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8zm0 96h112a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8H264a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8zm240 160H264a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h240a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-305.07-12.44a11.93 11.93 0 0 0-16.91-.09l-54 52.67V40a8 8 0 0 0-8-8H104a8 8 0 0 0-8 8v383.92l-53.94-52.35a12 12 0 0 0-16.92 0l-5.64 5.66a12 12 0 0 0 0 17l84.06 82.3a11.94 11.94 0 0 0 16.87 0l84-82.32a12 12 0 0 0 .09-17z"
                                    class=""></path>
                            </svg>
                        </a>
                    @endif

                    <br>Sort
                </span>
            </div>
        @if (!empty(count($product_results)))

            <div class="sort-products">
                <div class="sort-counting">
                    <p>Showing {{ $paginations['showing']['of_before'] }} -
                        {{ $paginations['showing']['of_after'] }} of
                        {{ $paginations['showing']['total'] }}</p>
                </div>
            </div>
        </div>

        @foreach ($product_results as $product)
            <div class="small-product">
                <div class="product-thumbnail">
                    @if (!empty($product->image))
                        <img src="{{ $product->image }}" alt="{{ $product->title }}">
                    @else
                        <img src="{{ url('/img/no_image.png') }}" alt="{{ $product->title }}">
                    @endif
                </div>
                <a class="quick-view" title="{{ $product->title }}"
                    href="{{ url("/$product->title_breadcrumb" . '_' . "$product->product_id.html") }}">
                    <i class="fa fa-search"></i> View Detail
                </a>
                <div class="small-product-detail">
                    <div class="title-wrapper">
                        <p class="product-title">
                            {{ $product->title }}
                        </p>
                    </div>
                    <div class="price-wrapper">
                        <p class="">
                            <span class="product-price">US</span>
                            <span class=""><span
                                    class="currency-symbol">$</span>{{ number_format(number_format($product->s_price, 2) - number_format($product->s_price, 2) * env('PETS_DISC'), 2) }}</span><br>
                            <del>${{ number_format($product->s_price, 2) }}</del>
                            <span
                                class="badge badge-danger text-white discount-price">-{{ env('PETS_DISC') * 100 }}%</span>

                        </p>
                    </div>
                </div>
            </div>
        @endforeach


        <hr>
        <div class="pagination">
            <p>Showing {{ $paginations['page'] }} of {{ $paginations['total_pages'] }} pages</p>
            @if ($paginations['page'] > 1)
                <a title="Previous" href="{{ $paginations['prev'] }}">&laquo;</a>
            @endif
            @if (!empty($paginations['pagination_links']))
                @foreach ($paginations['pagination_links'] as $link)
                    @if ($link['text'] == $paginations['page'])
                        <a title="{{ $link['text'] }}" class="active"><span>{{ $link['text'] }}</span></a>
                    @else
                        <a title="{{ $link['text'] }}" href="{{ $link['link'] }}">{{ $link['text'] }}</a>
                    @endif
                @endforeach
            @endif

            @if ($paginations['total_pages'] != $paginations['page'])
                <a title="Next" href="{{ $paginations['next'] }}">&raquo;</a>
            @endif
        </div>
        @else
        <p>     
            <strong>No product found for you search</strong><hr>                    
            <a title="Shop" href="{{ url('/shop.html') }}" name="go-shop" class="cart-btn" style="padding: 10px 50px;">                        
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            class="svg-inline--fa fa-shopping-bag fa-w-14">
                            <path fill="currentColor"
                                d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z"
                                class=""></path>
                        </svg>  View all Products
                    </a>
        </p>
    @endif
    </div>
</div>
