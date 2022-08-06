<div class="single-product-content">

    <!-- Left Column / Headphones Image -->
    <div class="left-column product-col">
        <img data-image="black" src="{{ !empty($product->image) ? $product->image : '' }}"
            alt="{{ $product->title }}">
    </div>


    <!-- Right Column -->
    <div class="right-column product-col">
        <div>
            <ol class="breadcrumb">You are here:&nbsp;&nbsp;&nbsp;
                @foreach ($breadCrumb_details as $key => $item)
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

        <!-- Product Description -->
        <div class="product-description">
            <h1>{{ $product->title }}</h1>
            <span class="category-label">Category:</span>
            <span>
                @foreach ($product->categories as $key => $category)
                    <a title="{{ $category->title }}"
                        href="{{ url("/$category->breadcrumb") }}">{{ $category->parent_title }}&nbsp;{{ $category->title }}</a>
                    {{ array_key_last($product->categories) == $key ? '' : ',' }}
                @endforeach
            </span>
        </div>

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
        <div class="quantity buttons_added">
            <input type="button" value="-" class="minus">
            <input id="quantity_value" type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty"
                class="input-text qty text" size="4" pattern="" inputmode="">
            <input type="button" value="+" class="plus">
        </div>
        <div class="product-price">
            <span class="cart-btn add-to-bag" data-val="{{ $product->product_id }}"><i
                    class="fa fa-shopping-cart"></i> Add to cart</span>
        </div>
        <span class="hide bg-success text-success product-added-msg"><i class="far fa-check-circle"
                style="font-size: 24px;"></i> Product added to cart successfully!</span>
    </div>
</div>




<div class="tabset">
    <!-- Tab 1 -->
    <input type="radio" name="tabset" id="tab1" aria-controls="desc" checked>
    <label for="tab1">Description</label>
    <!-- Tab 2 -->
    <input type="radio" name="tabset" id="tab2" aria-controls="more-info">
    <label for="tab2">More info</label>
    <!-- Tab 3 -->
    {{-- <input type="radio" name="tabset" id="tab3" aria-controls="reviws">
    <label for="tab3">Reviews</label> --}}
    <div class="tab-panels">
        <section id="desc" class="tab-panel">
            {!! !empty($product->description) ? html_entity_decode($product->description ): 'No Description' !!}
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


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
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
