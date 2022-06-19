function getAction(obj) {

    var data = {};
    data.message = $('#action_message').val();
    data.action = $('#action').val();
    data.action_id = $('#action_id').val();


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url + '/admin/'+ $(obj).data('url_sagment'),
        method: 'POST',
        data: data,
        success: function (res) {

            var result = JSON.parse(res);

            if (result.status == 200) {
                $('.action-modal-message').addClass('label-success').html(result.message);
                window.location.reload();
            } else if (result.status == 400) {
                var html = '';
                $.each(result.errors, function (k, v) {
                    html += "<li>" + v + "</li>";
                });
                $('.action-modal-errors').addClass('text-danger').html(html);
                $('.action-modal-message').addClass('label-danger').html(result.message);
            }
        }
    }
    );
}

function updateActionValues(obj, action) {
    $('#action').val(action)
    $('#action_id').val($(obj).data('id'))

}
