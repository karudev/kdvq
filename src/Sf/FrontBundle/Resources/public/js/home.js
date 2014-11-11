$(document).ready(function() {

    var ha = $('.actu-bloc').height();

    var hn = $('.newsletter-bloc').height();

    var h = 800;
    if (ha > 800) {
        h = ha - 300;
    }
    $('.newsletter-bloc').css('min-height', h);


    if($('.vegas_0').length > 0){
    $('.categories').css({'background': 'url(' + $('.vegas_0').attr('data-bg') + ') no-repeat', 'background-size': 'cover'});
    slide(1);
}



});

function slide(number) {
    
   
    setTimeout(function() {
        
        $('.categories').fadeTo( "slow",0.6).css({'background': 'url(' + $('.vegas_' + number).attr('data-bg') + ') no-repeat', 'background-size': '100%'}).fadeTo( "slow",1);
        
        // console.debug(number + 1);
        
        if ($('.vegas').length > (number + 1)){
           
            slide(number + 1);
            
        }
        else {
          
            slide(0);
             
        }
    }, 10000);
   
}




