function menuResponsive(){

    var menu = jQuery("nav");
    menu.toggleClass("active");

    if(menu.hasClass("active")){
        jQuery("button.icon i").removeClass("fa-bars");
        jQuery("button.icon i").addClass("fa-times");
    }
    else{
        jQuery("button.icon i").addClass("fa-bars");
        jQuery("button.icon i").removeClass("fa-times");
    }
}


//Scroll to top button

// see http://stackoverflow.com/q/35950735/145346
jQuery(document).ready(function($) {

    var visible = false;
    //Check to see if the window is top if not then display button
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
        if (!visible && scrollTop > 100) {
            $(".scrollToTop").fadeIn();
            visible = true;
        } else if (visible && scrollTop <= 100) {
            $(".scrollToTop").fadeOut();
            visible = false;
        }
    });

    //Click event to scroll to top
    $(".scrollToTop").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });

});