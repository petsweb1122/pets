$(function () {
    $('#price_sort_filter').change(function () {


        window.location = $(this).find('option:selected').data('link');


    });
});
