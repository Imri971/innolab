
$(window).on("scroll", function() {
    if($(window).scrollTop() > 20){
        
       
        $('.navbar').css("background-color","#24445c");
        $('.nav-link').css("color","#fff");
        $('.navUser__a').css("color", "#fff");
        
    }
    else {
    
    $('.navbar').css("background-color","transparent");
    $('.nav-link').css("color","#F0C300");
    $('.navUser__a').css("color", "#F0C300");
        
    }
});

