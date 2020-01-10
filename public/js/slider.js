
$(document).ready(function() {
    
    $("#sliderProductos").owlCarousel({
        items : 4,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,4],
        itemsMobile : [600,3],
        pagination:true,
        autoPlay:true,        
    });
    
    $("#sliderZonas").owlCarousel({
        items: 6,
        itemsDesktop: [1199, 6],
        itemsDesktopSmall: [980, 5],
        itemsMobile: [600, 2],
        pagination: true,
        autoPlay: true,       
    });
    $('.carousel-main').owlCarousel({
        items: 3,
        loop: true,
        autoplay: false,
        autoplayTimeout: 1500,
        margin: 10,
        nav: true,
        dots: false,
        navText: ['<span class="fas fa-chevron-left fa-2x"></span>', '<span class="fas fa-chevron-right fa-2x"></span>']
    });
});



