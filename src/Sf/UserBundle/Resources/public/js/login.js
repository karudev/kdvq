$(function(){
   registration();
});

function registration(){
     $('form[name="registration"]').submit(function(e){
         var form = $(this);
      e.preventDefault();
      $.post($(this).attr('action'),$(this).serializeArray(),function(json){
          if(json.success){
              window.location.href = json.redirect;
          }else{
            $(form,'#registration').html(json.form);
          //  registration();
          }
      });
    });
}