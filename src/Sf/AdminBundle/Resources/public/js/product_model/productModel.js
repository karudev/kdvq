$(document).ready(function() {

    $('.del').click(function() {
        var number = $(this).attr('data-number');
        $('#number').val(number);
        $('#productId').val($(this).attr('data-productId'));
    });
    $('form').submit(function(e) {
        e.preventDefault();
        $.post(Routing.generate('admin_product_model_delete'), $('form').serializeArray(), function(json) {
          if(json.productId)
            window.location.href = Routing.generate('admin_product_model_expose', {product: json.productId});
        });
    });





});