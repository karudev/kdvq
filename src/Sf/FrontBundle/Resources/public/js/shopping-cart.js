var xhr = false;
$(function() {
    updateQuantity();
    remove();
    cgv();
    upShop();
});
function updateQuantity() {


    $('.quantity').keyup(function() {
        $('#achat').attr('disabled', true);
        if (xhr) {
            xhr.abort();
        }
        xhr = $.post(Routing.generate('front_shopping_cart_update', {product: $(this).attr('data-id'), quantity: $(this).val()}), {token: $('#tok').val()}, function(json) {
            if (json.success) {
                $('.shopping-cart').html(json.html);
                updateQuantity();
                remove();
                cgv();
                upShop();
                getTotalShoppingCart();
            }
        });
    });
}
function remove() {
    $('.remove').click(function() {
        $.post(Routing.generate('front_shopping_cart_remove', {product: $(this).attr('data-id')}), function(json) {
            if (json.success) {
                $('.shopping-cart').html(json.html);
                updateQuantity();
                remove();
                cgv();
                upShop();
                getTotalShoppingCart();
            }
        });
    });

}

function cgv() {
    $('#cgv').click(function() {
        if ($(this).is(':checked') == false) {
            $('#achat').attr('disabled', true);
        } else {
            $('#achat').removeAttr('disabled');
        }
    });
}

function upShop() {
    $('#shop').change(function() {
        $.post(Routing.generate('front_shopping_cart_show'), {shop: $(this).val(),token: $('#tok').val()}, function(html) {
            $('.shopping-cart').html(html);
           updateQuantity();
                remove();
                cgv();
                upShop();
                getTotalShoppingCart();
        });
    });
}