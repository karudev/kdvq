$(function() {


    $('#grid').masonry({
        itemSelector: '.box'
    });

    $('#date').change(function() {
        $('.tri-month').removeClass('active');
        $('#grid').load(Routing.generate('front_actus_show', {year: $(this).val()}), function() {

            $('#grid').masonry({
                itemSelector: '.box'
            });
        });
    });

    $('.tri-month').click(function() {
        $('.tri-month').removeClass('active');
        $(this).addClass('active');

        $('#grid').load(Routing.generate('front_actus_show', {year: $('#date').val(),month: $('#date').val()+$(this).attr('data-id')}), function() {

            $('#grid').masonry({
                itemSelector: '.box'
            });
        });
    });

});