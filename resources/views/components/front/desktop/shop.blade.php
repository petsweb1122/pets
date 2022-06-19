<style>
    /**************Shop CSS************/
    .shop-content {
        margin: 20px 20px 20px 50px;
        max-width: 100%;
        padding-top: 0px;
    }

    .sidenav {
        height: auto;
        width: 100%;
        max-width: 280px;
        position: relative;
        z-index: 1;
        top: 0;
        left: 0;
        overflow-x: hidden;
        overflow-y: hidden;
        padding-top: 4px;
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav li a {
        padding: 6px 8px 6px 0px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 300;
        color: #333;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
        border-bottom: 1px solid #ddd
    }

    .sidenav li:last-child a {
        border: none;
    }

    .sidenav li:hover a {
        border-left: 4px groove #0789c0;
        border-right: 4px groove #0789c0;
        padding-left: 4px;
        background: #f2f2f2
    }

    .sidenav li:active a {
        border-left: 4px groove #0789c0;
        border-right: 4px groove #0789c0;
        padding-left: 4px;
        background: #f2f2f2
    }

    .sidenav .glyphicon {
        float: right;
        padding: 6px 12px;
        cursor: pointer;
    }

    .sidenav .glyphicon:hover {
        color: #000
    }

    .sidenav .submenu {
        margin: 0;
        border-top: 0px solid #ddd;
        margin-left: 0px;
        border-left: 14px groove #0789c0;
    }

    .sidenav .submenu a {
        font-size: 13px;
        padding-left: 6px;
    }

    .sidenav .submenu a .active {
        background: #ddd;
        color: #fff;
        margin: 0;
        padding: 6px 8px 6px 10px;
    }

    .sidenav ul {

        padding: 0;
        list-style: none;
    }

    /* On mouse-over */
    .sidenav li a:hover {
        color: #333;
    }

    .sidenav .active {
        background-color: #0789c0;
        color: #fff;
    }

    .pagination {
        display: inline-block;
        margin-bottom: 10px;
    }

    .pagination a {
        color: #777;
        font-size: 13px;
        float: left;
        padding: 6px 12px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        padding: 6px 12px;
        cursor: text;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }

    .badge {
        display: inline-block;
        padding: .25em .4em;
        font-size: 75% !important;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        font-size: 12px;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .text-white {
        color: #fff !important;
    }

    .product-thumbnail {
        width: 278px;
        height: 220px;
        max-height: 220px;
        position: relative;
        background: #fff;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        vertical-align: middle;
        text-align: center;
        display: table-cell;
    }

    .product-thumbnail {
        text-align: center;
    }

    .product-thumbnail img {
        width: auto;
        max-width: 90%;
        max-height: 210px;
        margin: 0 auto;
        margin: 4px;
    }

    .product-title {
        color: #333;
        font-weight: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        /* height: 50px; */
        line-height: inherit;
    }

    .price-wrapper .price-discount {
        font-size: 14px;
    }

    .price-wrapper del {
        color: #ccc;
        font-size: 14px;
    }


    .price-wrapper p span {
        color: #d0011b;
        font-weight: 600;
        font-size: 18px;
    }

    .price-wrapper p .product-price {
        color: #333 !important;
    }

    .content .small-product {
        width: 23%;
        margin: .5%;
        margin-bottom: 14px;
        display: inline-block;
        background: #fff;

    }

    .content .small-product {
        border: 1px solid #eee;
        margin-bottom: 20px;
        border-color: #ccc;
    }

    .content .small-product:hover {
        box-shadow: 0px 0px 12px #aaa
    }

    .content .small-product .small-product-detail {
        font-weight: normal;
        padding: 0 5px 0px 5px;
        text-align: left;
        margin: 20px;
    }

    .content .small-product .quick-view {
        margin-top: 2px;
        position: relative;
        display: block;
        background-color: #81d742;
        color: #fff;
        width: 100%;
        padding: 8px;
        text-align: center;
        font-size: 14px;
        font-weight: normal
    }

    .shop-col {
        display: inline-block
    }

    .shop-sidebar {
        width: 20%;
        height: auto;
        vertical-align: top;
        margin: 0px;
        /* border-top: 2px solid #ddd; */
    }

    .shop-sidebar h4 {
        font-size: 18px;
        color: #555;
        margin-bottom: 4px;
    }


    .search-keyword .searchKeywordButton {
        min-width: 110px;
        width: 90%;
    }

    .shop-sidebar .filter-btn {
        /* margin-bottom:30px; */
        border: none;
        background-color: #81d742;
        display: inline-block;
        background-color: #7DC855;
        border-radius: 99px;
        font-size: 15px;
        color: #FFFFFF;
        width: 100%;
        text-decoration: none;
        padding: 12px 10px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
        padding: 10px 10px;
        transition: all .5s;
        box-shadow: 0px 0px 10px inset #4c883f;
        min-width: 100px;
        width: 90%;
        margin-top: 18px;
    }

    .filter-form {
        font-size: 12px;
    }

    .shop-listing {
        width: 78%;
        text-align: center;
    }

    .sort-products-right {
        text-align: right;
        margin: 4px;
    }

    .sort-products {
        display: inline-block
    }

    .sort-counting {
        float: left;
        margin-right: 10px;
    }

    .sort-dropdown {
        float: left;
        margin-right: 10px;
    }

    .sort-counting p {
        font-size: 12px;
        margin-right: 10px;
    }

    .sort-dropdown select {
        font-size: 12px;
        border: 1px solid #ccc;
        border-radius: 0
    }

    @media (max-width: 1150px) {
        .content .small-product {
            width: 31%;
        }
    }

    @media (max-width: 900px) {
        .shop-content {
            margin: 20px 10px 20px 30px;
        }

        .product-title a {
            font-size: 13px;
            line-height: 18px;
        }

        .price-wrapper p {
            line-height: 18px;
            color: #d0011b;
        }

        .price-wrapper .price-discount {
            font-size: 12px;
        }

        .price-wrapper del {
            font-size: 12px;
        }

        .price-wrapper span {
            font-size: 12px;
        }
    }

    @media (max-width: 850px) {

        .shop-sidebar {
            width: 30%
        }

        .shop-listing {
            width: 65%
        }

        .content .small-product {
            width: 46%;
        }

        .content .small-product .small-product-detail {
            padding: 0 5px 0px 5px;
            text-align: center;
            margin: 4px;
        }
    }

</style>


<div class="content shop-content">
    @if (!empty($breadCrumb))
        <div>
            <ol class="breadcrumb">You are here:&nbsp;&nbsp;&nbsp;
                @foreach ($breadCrumb as $key => $item)
                    @if (!empty($item['link']))
                        <li class="breadcrumb-item"><a title="Home" href="{{ $item['link'] }}">{!! $key == 0 ? '<i class="fa fa-home"></i>' : '' !!}
                                {{ $item['title'] }}</a></li>
                    @else
                        @php
                            $search_title = $item['title'];
                        @endphp
                        <li class="active breadcrumb-item">{{ $item['title'] }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    @endif
    <div class="shop-sidebar shop-col">
        <h2 class="text-center"><i class='fa fa-filter'></i>Filter products by</h2>
        <br>
        <form action="{{ url('/search.html') }}" method="GET" class="filter-form">
            <h4>Price:</h4>
            <div class="range-slider"><span>
                    <div class="input-box">
                        <span class="prefix">$</span>
                        <input class="range-slider-num" type="number" name="min_price"
                            value="{{ !empty(request()->get('min_price')) ? request()->get('min_price') : 0 }}"
                            min="0" max="1000" />
                    </div>
                    <div class="input-box">-
                    </div>
                    <div class="input-box">
                        <span class="prefix">$</span>
                        <input class="range-slider-num" type="number" name="max_price"
                            value="{{ !empty(request()->get('max_price')) ? request()->get('max_price') : 1000 }}"
                            min="0" max="1000" />
                </span>
            </div>
            <input class="range-slider-num"
                value="{{ !empty(request()->get('min_price')) ? request()->get('min_price') : 0 }}" min="0" max="1000"
                step="10" type="range" />
            <input class="range-slider-num"
                value="{{ !empty(request()->get('max_price')) ? request()->get('max_price') : 1000 }}" min="0"
                max="1000" step="10" type="range" />
    </div>
    <h4>Keyword:</h4>
    <div class="search-keyword">
        <input type="text" name="keyword" class="searchKeywordButton"
            value="{{ !empty(request()->get('keyword')) ? request()->get('keyword') : '' }}"
            placeholder="Enter Keyword">
    </div>

    <button type="submit" class="filter-btn">
        Filter Products <i class="fa fa-filter"></i>
    </button>
    </form>
    <br>
    <hr>

    <form action="{{ url('/search.html') }}" method="GET" class="filter-form">
        <h4>Search by UPC:</h4>
        <div class="search-keyword">
            <input type="text" name="upc" class="searchKeywordButton" placeholder="Enter UPC">
            <button type="submit" class="searchButton transparent-bg">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <div class="sidenav">
        <ul>
            <hr>
            <h4>Categories</h4>
            @foreach ($left_cat_navigations as $cat_nav)
                <li><a title="{{ $cat_nav['title'] }}"
                        href='{{ $cat_nav['link'] }}'>{{ $cat_nav['title'] }}</a>
                    @if (!empty($cat_nav['childs']))
                        <ul class="submenu">
                            @foreach ($cat_nav['childs'] as $child1)
                                <li><a title="{{ $child1['title'] }}"
                                        href='{{ $child1['link'] }}'>{{ $child1['title'] }}</a>
                                    <ul class="submenu">
                                        @foreach ($child1['childs'] as $child2)
                                            <li><a title="{{ $child2['title'] }}"
                                                    href='{{ $child2['link'] }}'>{{ $child2['title'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
    <script>
        $('.submenu').hide();

        $('.submenu').parents("li").prepend("<span class='glyphicon'>+</span>");

        $('.glyphicon').click(function() {
            $(this).closest('li').find('ul.submenu').first().slideToggle("slow");
        });
    </script>
</div>



<div class="shop-listing shop-col">

    <div class="sort-products-right">
        <div class="sort-products">
            <div class="sort-counting">
                <p>Showing {{ $paginations['showing']['of_before'] }} -
                    {{ $paginations['showing']['of_after'] }} of
                    {{ $paginations['showing']['total'] }}</p>
            </div>
            <div class="text-left sort-dropdown">
                <select class="form-control" id="price_sort_filter">
                    <option value="" data-link="{{ request()->url() }}" selected="selected">Sort by Option</option>
                    <option value="asc" {{ request()->get('sort') == 'asc' ? 'selected' : '' }}
                        data-link="{{ $link_sort_asc }}">Sort by price: Low
                        to high</option>
                    <option value="desc" {{ request()->get('sort') == 'desc' ? 'selected' : '' }}
                        data-link="{{ $link_sort_desc }}">Sort by price:
                        High to low</option>
                </select>
            </div>
        </div>
    </div>

    @if (!empty(count($product_results)))
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
                            <span class="">
                                <span class="currency-symbol">$</span>
                                {{ number_format(number_format($product->s_price, 2) - number_format($product->s_price, 2) * env('PETS_DISC'), 2) }}
                            </span>

                            @if (!empty(env('PETS_DISC')))
                                <del>${{ number_format($product->s_price, 2) }}</del><br>
                                <span
                                    class="badge badge-danger text-white discount-price">-{{ env('PETS_DISC') * 100 }}%
                                </span>
                            @endif

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
            <strong>No product found for you search</strong>
            <hr>
            <a title="Shop" href="{{ url('/shop.html') }}" name="go-shop" class="cart-btn"
                style="padding: 10px 50px;">
                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                    class="svg-inline--fa fa-shopping-bag fa-w-14">
                    <path fill="currentColor"
                        d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z"
                        class=""></path>
                </svg> View all Products
            </a>
        </p>
    @endif
</div>


<style>
    .input-box {
        display: contents;
        padding-left: 0.5rem;
        overflow: hidden;
    }

    .input-box .prefix {
        font-weight: 300;
        font-size: 14px;
        color: #999;
    }

    .input-box:focus-within {
        border-color: #777;
    }

    .range-slider {
        width: 90%;
        margin: 0px;
        text-align: left;
        position: relative;
        height: 4em;
    }

    .range-slider-num {
        width: 37px;
        min-width: 30px;
        padding: 2px !important;
        font-weight: bold;
    }

    .range-slider svg,
    .range-slider input[type=range] {
        position: absolute;
        left: 0;
        bottom: 0;
    }

    input[type=number] {
        border: 0px solid #ddd;
        text-align: left;
        font-size: 14px;
        -moz-appearance: textfield;
        padding: 10px 4px;
        background: transparent;
    }

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    input[type=number]:invalid,
    input[type=number]:out-of-range {
        border: 2px solid #ff6347;
    }

    input[type=range] {
        -webkit-appearance: none;
        width: 100%;
        border: 0;
        background: transparent;
        padding: 0
    }

    input[type=range]:focus {
        outline: none;
    }

    input[type=range]:focus::-webkit-slider-runnable-track {
        background: #0789c0;
    }

    input[type=range]:focus::-ms-fill-lower {
        background: #0789c0;
    }

    input[type=range]:focus::-ms-fill-upper {
        background: #0789c0;
    }

    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 5px;
        cursor: pointer;
        animate: 0.2s;
        background: #0789c0;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }

    input[type=range]::-webkit-slider-thumb {
        z-index: 2;
        position: relative;
        box-shadow: 0px 0px 2px #000;
        border: 8px inset #024662;
        height: 24px;
        width: 24px;
        border-radius: 25px 25px;
        background: #0789c0;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -12px;
    }

    input[type=range]::-moz-range-track {
        width: 100%;
        height: 5px;
        cursor: pointer;
        animate: 0.2s;
        background: #0789c0;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }

    input[type=range]::-moz-range-thumb {
        z-index: 2;
        position: relative;
        box-shadow: 0px 0px 0px #000;
        border: 1px solid #0789c0;
        height: 18px;
        width: 18px;
        border-radius: 25px;
        background: #a1d0ff;
        cursor: pointer;
    }

    input[type=range]::-ms-track {
        width: 100%;
        height: 5px;
        cursor: pointer;
        animate: 0.2s;
        background: transparent;
        border-color: transparent;
        color: transparent;
    }

    input[type=range]::-ms-fill-lower,
    input[type=range]::-ms-fill-upper {
        background: #0789c0;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }

    input[type=range]::-ms-thumb {
        z-index: 2;
        position: relative;
        box-shadow: 0px 0px 0px #000;
        border: 1px solid #0789c0;
        height: 18px;
        width: 18px;
        border-radius: 25px;
        background: #0789c0;
        cursor: pointer;
    }

</style>


<script id="rendered-js">
    (function() {

        var parent = document.querySelector(".range-slider");
        if (!parent) return;

        var
            rangeS = parent.querySelectorAll("input[type=range]"),
            numberS = parent.querySelectorAll("input[type=number]");

        rangeS.forEach(function(el) {
            el.oninput = function() {
                var slide1 = parseFloat(rangeS[0].value),
                    slide2 = parseFloat(rangeS[1].value);

                if (slide1 > slide2) {
                    [slide1, slide2] = [slide2, slide1];
                }

                numberS[0].value = slide1;
                numberS[1].value = slide2;
            };
        });

        numberS.forEach(function(el) {
            el.oninput = function() {
                var number1 = parseFloat(numberS[0].value),
                    number2 = parseFloat(numberS[1].value);

                if (number1 > number2) {
                    var tmp = number1;
                    numberS[0].value = number2;
                    numberS[1].value = tmp;
                }

                rangeS[0].value = number1;
                rangeS[1].value = number2;

            };
        });

    })();
</script>
