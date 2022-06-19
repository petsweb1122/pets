$(function () {

    $('.add-to-bag').click(function (event) {
        var data = {};
        let p_id = $(this).data('val');
        let qty = $('#quantity_value').val();
        $(this).parents('.add-to-bag').find('.error').html('');
        add_bag_obj = $(this).parents('.add-to-bag');

        if ($('.price-container .price-wrapper').hasClass('active')) {
            let size_id = $(".price-container .price-wrapper.active").data("size_id");
            data.size_id = size_id;
        }

        data.p_id = p_id;
        data.quantity = qty;

        if (typeof data.size_id != 'undefined') {
            $('.loader-ajax-card').show();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: base_url + "/cart/add-to-cart",
                method: "POST",
                data: data,
                success: function (res) {
                    let result = JSON.parse(res);
                    $('.loader-ajax-card').hide();
                    if (result.status == 404) {
                        add_bag_obj.find('.error').html(result.error);
                        return true;
                    }
                    $('.product-added-msg').removeClass('hide');
                    let carts = result.data;
                    let cart_count = Object.keys(carts).length;
                    var html_cart = '';
                    let image_data = result.image_data;
                    var total = 0;
                    $.each(carts, function (key, cart) {
                        var p_id = cart.id;
                        html_cart += "<div class='container-single-cart'>";
                        html_cart += "<span class='remove-cart-item'   data-key'" + p_id + "' onclick='deleteCartItem(this)'><i class='fa fa-trash-alt'></i></span>";
                        html_cart += "<span><img src='" + cart.attributes.image + "'></span>";
                        html_cart += "<span class='cart-item-name'>";
                        html_cart += "<a href='' class='cart-product-name'>" + cart.name + "</a><br>";
                        html_cart += "<span class='cart-price'>$" + cart.price + " </span>";
                        html_cart += "<span class='cart-qty'>(Qty: " + cart.quantity + ")</span>";
                        html_cart += "<span class='weight-lbs'> " + cart.attributes.weight + "lbs</span>";
                        html_cart += "<span class='cart-price-total'>$" + cart.price * cart.quantity + "</span>";
                        html_cart += "</span'>";
                        html_cart += "</div>";
                        total = total + (cart.price * cart.quantity);
                    });

                    $('#add_to_cart_ajax').html(html_cart);
                    $('#top_bar_sub_total').html('$' + total);
                    setTimeout(function () {
                        $('.product-added-msg').addClass('hide');
                    }, 2000);

                }
            });
        } else {

        }

    });

    $('.price-container .price-wrapper').click(function () {
        $('.price-container .price-wrapper').removeClass('active');
        $(this).addClass('active');
    });



});
