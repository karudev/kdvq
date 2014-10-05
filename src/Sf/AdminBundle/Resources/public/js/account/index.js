$(function(){
   address();
   $('#billing').click(function(){
      $('.billing').show(); 
   });
});

function address(){
     $('form[name="address"]').submit(function(e){
      e.preventDefault();
      $.post($(this).attr('action'),$(this).serializeArray(),function(json){
          if(json.success){
              window.location.href = json.redirect;
          }else{
            $('.'+json.type).html(json.form);
            address();
          }
      });
    });
}