$(function () {
    $(".select-multiple").select2();
    $(".select-single").select2();

    $("#add_size").click(function () {
        var data = {};
        data.size = $('#all_sizes').val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: base_url + "/admin/products/add-size",
            method: "POST",
            data: data,
            success: function (res) {
                $('#error_message_size').html('');
                var result = JSON.parse(res);

                if (result.status == 404) {
                    $('#error_message_size').html(result.message);
                }
                if (result.status == 200) {
                    $(".panel-body").append(result.data);
                }
                $(".delete_this_size").click(function () {

                    var data = {};
                    data.delete_id = $(this).data('delete_id');
                    var obj_cur = $(this);
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: base_url + "/admin/products/remove-size",
                        method: "POST",
                        data: data,
                        success: function (res) {
                            obj_cur.parents('.parent-size-data').remove();

                        },
                    });
                });
            },
        });
    });

    $(".delete_this_size").click(function () {

        var data = {};
        data.delete_id = $(this).data('delete_id');
        var obj_cur = $(this);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: base_url + "/admin/products/remove-size",
            method: "POST",
            data: data,
            success: function (res) {
                obj_cur.parents('.parent-size-data').remove();

            },
        });


    });
});
