var key = 0;
$(function() {
   
    maj();
    newMail();
    accordeon();
    loadShopping();
     $("#tabs").tabs();
    
});
function maj() {
    $('.update').click(function() {
        $('#order .modal-body').html('');
        $.get(Routing.generate('order_update', {number: key, order: $(this).attr('data-id')}), function(json) {

            $('#order .modal-content').html(json.form);

            submitForm();
        });
    });
}
function submitForm() {
    $('form[name="order"]').submit(function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serializeArray(), function(json) {
            if (json.success) {
                $('#orders').html(json.html);
                $('#order').modal('hide');
                newMail();
                maj();
                accordeon();
                loadShopping();
                $("#tabs").tabs();
            } else {
                $('#order .modal-content').html(json.form);
                submitForm();
            }
        });
    });
}

function newMail() {
    $('.update-mail').click(function() {
        $('#mail .modal-body').html('');
        $.get(Routing.generate('mail_update', {number: key, order: $(this).attr('data-order-id')}), function(json) {

            $('#mail .modal-content').html(json);

            $('#mail_text').summernote({height: 300});



            submitMailForm();
        });
    });
}

function submitMailForm() {
    $('form[name="mail"]').submit(function(e) {
        e.preventDefault();

        $.post($(this).attr('action'), $(this).serializeArray(), function(json) {
            if (json.success) {
                $('#orders').html(json.html);
                $('#mail').modal('hide');
                newMail();
                maj();
                accordeon();
                loadShopping();
                $("#tabs").tabs();
            } else {
                $('#mail .modal-content').html(json);
                submitMailForm();
            }
        });
    });
}
function accordeon() {
    $('#orders h3').click(function() {
        var bool = true;
        var el = $('.details', $(this).parents('.order'));


        if (el.css('display') == 'block') {
            bool = false;
        }
        $('.details').hide();

        if (bool) {
            $('.details', $(this).parents('.order')).slideToggle();
            key = $('.details', $(this).parents('.order')).attr('data-key');
        }
    });
}

function loadShopping() {
    $('.load').click(function() {
        $('.alert').remove();
        $.post(Routing.generate('order_load_shoppingcart', {order: $(this).attr('data-order')}), function(json) {
            if(json.success){
                $('#main-content').prepend('<div class="alert alert-success">'+json.message+'</div>');
            }
        });
    });
}