jQuery(document).ready(function(){

    jQuery('.owl-carousel').owlCarousel({
        loop: false,
        margin:20,
        dots: false,
        nav:true,
        navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        slideBy: 3,
        responsive:{
            0:{
                items:1
            },
            1000:{
                items:3
            }
        }
    });
});