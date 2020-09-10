jQuery(document).ready(function($){
     $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: false,
      //asNavFor: '.slider-nav',
      autoplay:true,
      autoplaySpeed: 8000,
      dots: true
    });
});