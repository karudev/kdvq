$(function() {

    $('#brand').change(function() {
        $('.catalog').hide();
        $('.brand_' + $(this).val()).show('fade');
    });
});