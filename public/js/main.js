
$(window).on("scroll", function() {
    if($(window).scrollTop() > 20){
        
       
        $('.navbar').css("background-color","#24445c");
        
    }
    else {
    
    $('.navbar').css("background-color","transparent");
        
    }
});
