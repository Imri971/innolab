
$(window).on("scroll", function() {
    if($(window).scrollTop() > 50){
        
       
        $('.navbar').css("background-color","#24445c");
        
    }
    else {
    
    $('.navbar').css("background-color","transparent");
        
    }
});
