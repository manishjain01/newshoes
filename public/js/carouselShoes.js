$(document).ready(function(){

$('.carousel1 .carousel-item').each(function(){
            var next = $(this).next();
            if (!next.length) {
            next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i=0;i<2;i++) {
                next=next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }

                next.children(':first-child').clone().appendTo($(this));
              }
            });
    
    
    
     $('#recipeCarousel ,  #recipeCarousel2').carousel({
            interval: 3000
        
        });
    
});