$(function() {
    $('#new').click(function() {
        $('#account .modal-content').load(Routing.generate('admin_account_update'), function() {
            newAccount();
            addresses();
        });
    });
    update();

});
function newAccount() {

    $('form[name="account"]').submit(function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serializeArray(), function(json) {
            if (json.success) {
                $('#list').html(json.html);
                update();
                $('#account').modal('hide');
            } else {
                $('#form').html(json.form);
            // newAccount();
            }
        });
    });
}

function addresses() {

    add();
    $('#left label').eq(0).remove();
    $('#left label').eq(0).remove();
    add($('#right'));
    $('#right label').eq(0).remove();
    setTimeout(function() {
        $('#account_addresses_0_type').val('shipping');
        $('#account_addresses_1_type').val('billing');
    }, 1000);





    // $('#left label').eq(0).remove();

    // $('#right').append(html.html());
    // $('.control-label').remove();

}
function add(container) {
    var containerImage = $('#account_addresses');

    index = containerImage.children().length;
    html = $(containerImage.attr('data-prototype').replace(/__name__/g, index));

    if (container) {
        container.append(html);
    } else {
        containerImage.append(html);
    }



}
function update() {
    $('.update').click(function() {
        $('#account .modal-content').load(Routing.generate('admin_account_update', {user: $(this).attr('data-id')}), function() {
            newAccount();
        });
    });
}