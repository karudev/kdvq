$(document).ready(function() {

  var ha = $('.actu-bloc').height();
  
  var hn =  $('.newsletter-bloc').height();
  
  var h = 800;
  if(ha > 800){
      h = ha-100;
  }
   $('.newsletter-bloc').height(h)   ;
  
  
});
