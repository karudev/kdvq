$(function() {


    $('#grid').masonry({
        itemSelector: '.box'
    });

    $('#date').change(function() {

        $('#grid').load(Routing.generate('front_actus_show', {year: $(this).val()}), function() {

            $('#grid').masonry({
                itemSelector: '.box'
            });
        });
    });

});