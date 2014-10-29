function getTotalShoppingCart(){
    $('#total-shopping-cart').load(Routing.generate('front_shopping_cart_total'));
}

$('.navbar .dropdown').mouseover(function(){
    $(this).addClass('open');
});
$('.navbar .dropdown').mouseout(function(){
    $(this).removeClass('open');
});