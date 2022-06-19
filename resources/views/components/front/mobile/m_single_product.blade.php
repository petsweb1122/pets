<style>
    .single-product-content .product-description .badge {
        color: #fff;
    }

    .single-product-content {
        margin-top: 40px;
        margin-bottom: 10px;
    }

    .add-to-cart {
        width: 55%;
        float: right;
        max-width: 200px;
    }

    .single-product-footer {
        position: fixed;
        bottom: 0px;
        background: #0789c0;
        width: 100%;
        left: 0;
        text-align: center;
        padding: 10px;
        z-index: 999;
        zoom: .9;
    }

    /* Columns */
    .product-col {
        display: inline-block;
    }

    .single-product-content .left-column {
        width: 50%;
        position: relative;
        text-align: center;
    }

    .single-product-content .right-column {
        width: 40%;
        margin-top: 0px;
        vertical-align: top;
    }

    /* Left Column */
    .single-product-content .left-column img {
        width: auto;
        max-height: 250px;
        max-width: 280px;
    }

    /* Right Column */

    /* Product Description */
    .single-product-content .product-description {
        border-bottom: 1px solid #E1E8EE;
        margin-bottom: 4px;
    }

    .single-product-content .product-description span {
        font-size: 12px;
        font-weight: normal;
        color: #358ED7;
        text-decoration: none;
    }

    .single-product-content .category-label {
        color: #333 !important;
    }

    .product-description a {
        font-weight: normal;
        font-size: 12px;
    }

    .single-product-content .product-description span a {
        font-weight: normal;
    }

    .single-product-content .product-description h1 {
        font-weight: 300;
        font-size: 38px;
        color: #43484D;
        letter-spacing: -2px;
        margin: 0px auto 20px;
        line-height: 52px;
    }

    .single-product-content .shipping-note {
        font-size: 13px;
        font-weight: 300;
        color: #86939E;
        line-height: 24px;
    }


    /* Product Price */
    .single-product-content .product-price {
        display: flex;
        align-items: center;
    }

    .single-product-content .product-price span {
        font-size: 26px;
        font-weight: 600;
        color: #333;
        margin-right: 20px;
    }

    .single-product-content .product-description .instock {
        font-size: 14px;
        font-weight: 300;
        color: #4d8940;
    }

    .single-product-content .cart-btn {
        display: inline-block;
        background-color: #000;
        border-radius: 99px;
        font-size: 16px;
        color: #fff;
        text-decoration: none;
        padding: 9px 20px;
        transition: all .5s;
        box-shadow: 0px 0px 6px inset #000;
        width: 100%;
    }

    .single-product-content .cart-btn * {
        color: #fff;
        vertical-align: middle;
    }

    /* .single-product-content .cart-btn:hover {
        background-color: #64af3d;
    } */
    .single-product-content .cart-btn.active {
        background-color: #64af3d;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .single-product-content .product-description h1 {
            font-size: 24px;
            line-height: 32px;
            font-weight: normal;
        }
    }

    @media (min-width: 536px) {
        .single-product-content .left-column img {
            margin-top: 5px !important;
        }
    }

    @media (max-width: 535px) {
        .single-product-content .left-column img {
            max-width: 280px;
        }

        .single-product-content .right-column {
            width: 80%;
            margin: 20px auto;
            display: block;
        }

        .single-product-content .left-column {
            width: 100%;
            margin: 0px auto 20px;
            display: block;
            text-align: center;
            padding: 20px;
        }
    }

    /* -- quantity box -- */

    .product-col .quantity {
        display: inline-block;
        margin: 0px auto;
    }

    .product-col .quantity .input-text.qty {
        width: 46px;
        height: 41px;
        padding: 19px 5px;
        text-align: center;
        background-color: #ddd;
        border: 1px solid #eeeeee;
    }

    .product-col .quantity.buttons_added {
        text-align: left;
        position: relative;
        white-space: nowrap;
        vertical-align: top;
        float: left;
    }

    .product-col .quantity.buttons_added input {
        display: inline-block;
        margin: -3px;
        vertical-align: middle;
        box-shadow: 1px 1px 1px #777;
        min-width: 40px !important;
    }

    .product-col .quantity.buttons_added .minus,
    .product-col .quantity.buttons_added .plus {
        padding: 7px 10px 8px;
        height: 41px;
        background-color: #eee;
        border: 1px solid #efefef;
        cursor: pointer;
    }

    .product-col .quantity.buttons_added .minus {
        border-right: 0;
        border-radius: 99px 0 0 99px;
    }

    .product-col .quantity.buttons_added .plus {
        border-left: 0;
        border-radius: 0 99px 99px 0;
    }

    .product-col .quantity.buttons_added .minus:hover,
    .product-col .quantity.buttons_added .plus:hover {
        background: #ddd;
    }

    .product-col .quantity input::-webkit-outer-spin-button,
    .product-col .quantity input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        margin: 0;
    }

    .product-col .quantity.buttons_added .minus:focus,
    .product-col .quantity.buttons_added .plus:focus {
        outline: none;
    }

    /*
 CSS for the More Info Tabs
*/
    .tabset>input[type="radio"] {
        position: absolute;
        left: -200vw;
    }

    .tabset .tab-panel {
        display: none;
    }

    .tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
    .tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
    .tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
    .tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
    .tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
    .tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6) {
        display: block;
    }

    .tabset>label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
    }

    .tabset>label::after {
        content: "";
        position: absolute;
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset>label:hover,
    .tabset>input:focus+label {
        color: #06c;
    }

    .tabset>label:hover::after,
    .tabset>input:focus+label::after,
    .tabset>input:checked+label::after {
        background: #06c;
    }

    .tabset>input:checked+label {
        border-color: #ccc;
        border-bottom: 1px solid #fff;
        margin-bottom: -1px;
    }

    .tab-panel {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    .tabset {
        margin: 0px auto;
    }

    .shop_attributes {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    .shop_attributes th {
        border: 1px solid #aaa;
        padding: 10px 10px 10px 10px;
        width: 20%;
        text-align: left
    }

    .shop_attributes td {
        border: 1px solid #aaa;
        background-color: #eee;
        padding: 10px 10px 10px 10px;
    }

    .shop_attributes td p {
        margin: 0
    }



    @media (max-width: 535px) {

        .tabset>label {
            padding: 15px 6px 25px;
            font-weight: 300;
            font-size: 13px;
        }

        .single-product-content {
            margin-bottom: 0px;
        }

    }


    /* slider CSS */
    #promotional_slider {
        width: 100%;
        padding: 20px 30px;
        margin: 0 auto 0px;
        overflow: hidden;
        background: #FFF;
    }

    #promotional_slider a {
        position: relative;
    }

    #promotional_slider .view-product {
        position: absolute;
        /* top: 4px; */
        right: 0px;
        border: 1px solid #d20619;
        padding: 4px 4px 8px 12px;
        border-radius: 0px 0px 0px 99px;
        background: #d20619;
        opacity: .8
    }

    #promotional_slider .view-product * {
        color: #fff;
    }

    #promotional_slider .promotionalslider_wrapper {
        width: 100%;
        display: flex;
        /* slick initialized */
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow {
        font-size: 0;
        padding: 6px;
        -webkit-appearance: none;
        border: 0;
        background: #444;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
        outline: none;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-next {
        border-radius: 0 4px 4px 0;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-prev {
        border-radius: 4px 0 0 4px;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow:before {
        font-size: 18px;
        color: #FFF;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-next:before {
        content: "\226B";
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-prev:before {
        content: "\226A";
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow:hover {
        cursor: pointer;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-disabled {
        opacity: 0.5;
        background: #ccc;
    }

    #promotional_slider .promotionalslider_wrapper .slick-arrow.slick-disabled:hover {
        cursor: not-allowed;
    }

    #promotional_slider .promotionalslider_wrapper.slick-initialized {
        position: relative;
    }

    #promotional_slider .promotionalslider_wrapper.slick-initialized .slick-arrow {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        z-index: 9;
    }

    #promotional_slider .promotionalslider_wrapper.slick-initialized .slick-next {
        right: -25px;
    }

    #promotional_slider .promotionalslider_wrapper.slick-initialized .slick-prev {
        left: -25px;
    }

    #promotional_slider .promotionalslider_wrapper .promotionalslider_single {
        display: flex;
        width: 25%;
        flex: 0 0 25%;
        flex-direction: column;
        margin: 0 4px;
    }

    #promotional_slider .promotionalslider_wrapper .promotionalslider_single section {
        background: no-repeat center center/cover;
        width: 100%;
        height: 0;
        padding-top: 100%;
        background-size: 80%;
        border: 1px solid #eee;
        margin: 0;
    }

    #promotional_slider .promotionalslider_wrapper .promotionalslider_single p .related-product-title {
        color: #333;
        height: 20px;
        line-height: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 12px;
    }

    #promotional_slider .promotionalslider_wrapper .promotionalslider_single p {
        /*background-color: #0789c0; */
        color: #333;
        text-align: center;
        padding: 2px;
        text-transform: none;
        font-weight: normal;
        font-family: "Arial", sans-serif;
        font-size: 14px;
        margin-bottom: 0
    }

    #promotional_slider .promotionalslider_wrapper .promotionalslider_single p span {
        font-size: 18px;
        font-weight: 300;
        color: #d20619;
    }

    #promotional_slider .price-wrapper {
        text-align: center;
        padding-bottom: 10px;
    }

    .price-container {
        overflow: hidden;
    }

    .price-container .price-wrapper {
        border: 2px solid #cdcdcd;
        margin-right: 10px;
        padding: 20px 20px 10px 10px;
        text-align: center;
        position: relative;
    }

    .price-container .price-wrapper .size_box {
        position: absolute;
        right: 0;
        top: 0;
        left: 0;
        background: green;
        color: #fff;
    }

</style>


<!--div class="breadcrumb-main">
    <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="#" title="Home" ><i class="fa fa-home"></i> Home</a></li>
        <li class="breadcrumb-item"> title="Shop" href="#">Shop</a></li>
        <li class="breadcrumb-item"><a title="Dog" href="#">dog</a>
        </li>
        <li class="breadcrumb-item"><a title="Treats" href="#">treats</a>
        </li>
        <li class=" breadcrumb-item"><a title="Dry Food" href="#">dry food</a>
  </li>
    </ol>
</div-->

<div class="go-back">
    <a title="Go Back" action="action" onclick="window.history.go(-1); return false;"><svg aria-hidden="true"
            focusable="false" data-prefix="fal" data-icon="reply" role="img" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 576 512" class="svg-inline--fa fa-reply fa-w-18 fa-2x">
            <path fill="currentColor"
                d="M11.093 251.65l175.998 184C211.81 461.494 256 444.239 256 408v-87.84c154.425 1.812 219.063 16.728 181.19 151.091-8.341 29.518 25.447 52.232 49.68 34.51C520.16 481.421 576 426.17 576 331.19c0-171.087-154.548-201.035-320-203.02V40.016c0-36.27-44.216-53.466-68.91-27.65L11.093 196.35c-14.791 15.47-14.791 39.83 0 55.3zm23.127-33.18l176-184C215.149 29.31 224 32.738 224 40v120c157.114 0 320 11.18 320 171.19 0 74.4-40 122.17-76.02 148.51C519.313 297.707 395.396 288 224 288v120c0 7.26-8.847 10.69-13.78 5.53l-176-184a7.978 7.978 0 0 1 0-11.06z"
                class=""></path>
        </svg></a>
</div>

<div class="single-product-content">
    <!-- Left Column / Headphones Image -->
    <div class="left-column product-col">
        <img data-image="black" src="{{ !empty($product->image) ? $product->image : '' }}"
            alt="{{ $product->title }}">
    </div>


    <!-- Right Column -->
    <div class="right-column product-col">

        <!-- Product Description -->
        <div class="product-description">
            <h1>{{ $product->title }}</h1>
            <!-- Product Pricing -->

            <!-- Product Pricing -->
            <input type="hidden" name="" id="cart_size_value">
            <div class="price-container">
                @foreach ($product->variations as $item)
                    <div class="price-wrapper" style="float: left" data-size_id="{{ $item->size_id }}">
                        <span class="size_box">{{ $item->size_value }} lbs</span>
                        <div class="product-price">
                            <span>${{ number_format(number_format($item->s_price, 2) - number_format($item->s_price, 2) * env('PETS_DISC'), 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="price-wrapper">
                <span class="category-label">Category:</span>
                @foreach ($product->categories as $key => $category)
                    <a title="{{ $category->title }}"
                        href="{{ url("/$category->breadcrumb") }}">{{ $category->title }}</a>
                    {{ array_key_last($product->categories) == $key ? '' : ',' }}
                @endforeach
                </span>
            </div>
        </div>
        <p class="shipping-note"><sup>*</sup>Shipping time is 14 days.</p>

        <script data-require="jquery@3.1.1" data-semver="3.1.1"
                src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            function wcqib_refresh_quantity_increments() {
                jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                    var c = jQuery(b);
                    c.addClass("buttons_added"), c.children().first().before(
                        '<input type="button" value="-" class="minus" />'), c.children().last().after(
                        '<input type="button" value="+" class="plus" />')
                })
            }
            String.prototype.getDecimals || (String.prototype.getDecimals = function() {
                var a = this,
                    b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
            }), jQuery(document).ready(function() {
                wcqib_refresh_quantity_increments()
            }), jQuery(document).on("updated_wc_div", function() {
                wcqib_refresh_quantity_increments()
            }), jQuery(document).on("click", ".plus, .minus", function() {
                var a = jQuery(this).closest(".quantity").find(".qty"),
                    b = parseFloat(a.val()),
                    c = parseFloat(a.attr("max")),
                    d = parseFloat(a.attr("min")),
                    e = a.attr("step");
                b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d ||
                    (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this)
                    .is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d &&
                    b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger(
                        "change")
            });
        </script>
        <div class="single-product-footer">
            <div class="quantity buttons_added">
                <input type="button" value="-" class="minus">
                <input id="quantity_value" type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty"
                    class="input-text qty text" size="4" pattern="" inputmode="">
                <input type="button" value="+" class="plus">
            </div>
            <div class="add-to-cart">
                <span class="cart-btn add-to-bag" data-val="{{ $product->product_id }}"><i
                        class="fa fa-shopping-cart"></i> Add to cart</span>
            </div>
        </div>
    </div>
</div>




<div class="tabset content-area">
    <!-- Tab 1 -->
    <input type="radio" name="tabset" id="tab1" aria-controls="desc" checked>
    <label for="tab1">Description</label>
    <!-- Tab 2 -->
    <input type="radio" name="tabset" id="tab2" aria-controls="more-info">
    <label for="tab2">More info</label>

    <div class="tab-panels">
        <section id="desc" class="tab-panel">
            {!! !empty($product->description) ? $product->description : 'No Description' !!}
        </section>
        <section id="more-info" class="tab-panel">
            <h2>See details: </h2>
            <table class="shop_attributes">
                <tbody>
                    <tr>
                        <th>Item #</th>
                        <td>
                            <p>0-0-{{ $product->product_id }}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td>
                            <p> {{$product->brand_title}} </p>
                        </td>
                    </tr>
                    @foreach ($product->variations as $item)
                        <tr>
                            <th><b>Weight</b></th>
                            <td>
                                <p> <b>{{ $item->size_value }} </b> in pounds</p>
                            </td>
                        </tr>
                        <tr>
                            <th>UPC Code</th>
                            <td>
                                <p>{{ $item->variation_upc }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Length*width</th>
                            <td>
                                <p>{{ $item->product_size }}</p>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </section>
    </div>

</div>





<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css'>
<div id="promotional_slider">
    <h3>Related Products</h3>
    <div class="promotionalslider_wrapper">
        @foreach ($product_releateds as $r_product)
            <div class="promotionalslider_single">
                <a title="{{ $r_product->title }}"
                    href="{{ url("/$r_product->title_breadcrumb" . '_' . "$r_product->product_id.html") }}">
                    <span class="view-product">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="search-plus" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            class="svg-inline--fa fa-search-plus fa-w-14">
                            <path fill="currentColor"
                                d="M319.8 204v8c0 6.6-5.4 12-12 12h-84v84c0 6.6-5.4 12-12 12h-8c-6.6 0-12-5.4-12-12v-84h-84c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h84v-84c0-6.6 5.4-12 12-12h8c6.6 0 12 5.4 12 12v84h84c6.6 0 12 5.4 12 12zm188.5 293L497 508.3c-4.7 4.7-12.3 4.7-17 0l-129-129c-2.3-2.3-3.5-5.3-3.5-8.5v-8.5C310.6 395.7 261.7 416 208 416 93.8 416 1.5 324.9 0 210.7-1.5 93.7 93.7-1.5 210.7 0 324.9 1.5 416 93.8 416 208c0 53.7-20.3 102.6-53.7 139.5h8.5c3.2 0 6.2 1.3 8.5 3.5l129 129c4.7 4.7 4.7 12.3 0 17zM384 208c0-97.3-78.7-176-176-176S32 110.7 32 208s78.7 176 176 176 176-78.7 176-176z"
                                class=""></path>
                        </svg>
                    </span>
                    <section style="background-image: url({{ $r_product->image }}">
                    </section>
                    <p><span class="related-product-title">{{ $r_product->title }}</span></p>

                </a>
                <div class="price-wrapper">
                    <div class="product-price">
                        <span class="currency">US</span>
                        <span>${{ number_format(number_format($r_product->s_price, 2) - number_format($r_product->s_price, 2) * env('PETS_DISC'),2) }}</span>
                    </div>
                    <del>${{ number_format($r_product->s_price, 2) }}</del>
                    <span
                        class="badge badge-danger text-white discount-price">-{{ env('PETS_DISC') * 100 }}%</span><br>
                </div>
            </div>
        @endforeach
    </div>
</div>


<script src='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>
<script id="rendered-js">
    $(document).ready(function() {

        $('.promotionalslider_wrapper').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }]
        });




    });
</script>
