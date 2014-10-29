$(function() {
     $('a[href^="#"]').click(function() {
      
            var id = $(this).attr("href");
            if($(id)){
            var offset = $(id).offset().top;
           
            $('html, body').animate({scrollTop: offset}, 'slow');
        }
            return false;
        });
        
     $('a.zoom').easyZoom();

    $('form').submit(function(e) {
        var form = $(this);
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serializeArray(), function(json) {
            if (json.success) {
                $('#alert').html('<div class="alert alert-success">' + json.message + '</div>');
                 $('select').val('');
                 $('#quantity').val(1);
             
                getTotalShoppingCart();
            } else {
                $('#alert').html('<div class="alert alert-danger">' + json.message + '</div>');
            }
        });
    });

    criterion();
});

function criterion() {
    $('select').change(function() {

        var params = {params: {
                size: $('#size').val(),
                material: $('#material').val(),
                color: $('#color').val()
            }};
        $.post(Routing.generate('product_criterion', {product: $('#product_id').val()}), params, function(json) {
            if (json.stock == 0) {
                $('#no-stock').show();
                $('#add-to-shopping-cart').hide();
            } else if (json.stock > 0) {
                $('#no-stock').hide();
                $('#add-to-shopping-cart').show();
            }
        });
    });
}