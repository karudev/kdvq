$(function() {
   
    $('#brand').change(function(){
        $('.press').hide();
        $('.brand_'+$(this).val()).show('fade');
    });
});