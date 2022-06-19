$(function () {

    $('.add-to-bag').click(function (event) {
        let p_id = $(this).data('val');
        let qty = $('#quantity_value').val();
        $(this).parents('.add-to-bag').find('.error').html('');
        add_bag_obj = $(this).parents('.add-to-bag');
        var data = {};
        data.p_id = p_id;
        data.quantity = qty;
        $('.single-product-content .cart-btn').addClass('active');
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

                let carts = result.data;
                let cart_count = Object.keys(carts).length;

                $('#cart_count_shopping').html(cart_count);
                setTimeout(function(){
                    $('.single-product-content .cart-btn').removeClass('active');
                 }, 1000);

            }
        });
    });
});
