
$(document).ready(function() {
    
    
    $("#sliderZonas").owlCarousel({
        items: 6,
        itemsDesktop: [1199, 6],
        itemsDesktopSmall: [980, 5],
        itemsMobile: [600, 2],
        pagination: true,
        autoPlay: true,       
    });   
    

    $('#myCarousel').carousel({
        interval: 4000
    })

    $('.carousel .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < 2; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });
});



