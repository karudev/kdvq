$(document).ready(function() {

    var realizations = [];
    $('.vegas').each(function() {
        realizations.push({src: $(this).data('bg'), fade: 1000});
        $(this).find(".player").height($(this).height());
        $(this).hide();
    });


    $.vegas('slideshow', {
        delay: 10000,
        backgrounds: realizations,
        walk: function(step) {
            $('.vegas .brand').fadeOut("slow");
            $('.vegas').fadeOut("slow");
            $('.vegas.' + step).fadeIn("slow");
            $('.vegas.' + step+' .brand').fadeIn("slow");
            /* $('.navigation .point.active').removeClass("active");
             var point = step +1;
             $('.navigation .point#'+point).addClass("active");
             */
        }
    })('overlay', {
        src: $('.carrousel').attr('data-overlay')
    });

    /*$('.navigation .point').click(function(){
     var point = parseInt($(this).attr('id'))-1;
     $.vegas('jump', point);
     });*/

    // $.vegas('pause');
});
