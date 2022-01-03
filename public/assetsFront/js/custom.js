
$(document).ready(function () {
    $(".mytoggle .fa").click(function () {
        $(".blackappend").fadeIn();
        $(".navbar-collapse.collapse").animate({left: "0"});
    });
    $(".basmat-logo .fa").click(function () {
        $(".navbar-collapse").animate({left: "-100%"});
        $(".blackappend").fadeOut();
    });

    $(".blackappend").click(function () {
        $(this).fadeOut();
        $(".navbar-collapse").animate({left: "-100%"});
    });
});


/*---------------------
 
 TOP Menu Stick Start
 
 --------------------- */

var windows = $(window);

var sticky = $('#sticker');



windows.on('scroll', function () {

    var scroll = windows.scrollTop();

    if (scroll < 50) {

        sticky.removeClass('stick');

    } else {

        sticky.addClass('stick');

    }

});


/*---------------------
 
 
 /*TESTIMONIAL START*/

$('.carousel.vertical').on('slid.bs.carousel', function (e) {

    $('.thumbimg').removeClass('activeImg');

    $('.thumbimg').each(function () {

        let attrVal = $(this).attr('data-id')

        if (attrVal === e.relatedTarget.id)
            $(this).addClass('activeImg');

    });

});

/*TESTIMONIAL END*/


/*Item Slider Start*/
$("#blogslider").on("slide.bs.carousel", function (e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 3;
    var totalItems = $(".blog-slider").length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $(".blog-slider")
                        .eq(i)
                        .appendTo(".slider-carousel-inner");
            } else {
                $(".blog-slider")
                        .eq(0)
                        .appendTo(".slider-carousel-inner");
            }
        }
    }
});


/*Item Slider End*/

/*Item Slider Start*/
$("#addressslider").on("slide.bs.carousel", function (e) {
    interval: false
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 1;
    var totalItems = $(".address-item").length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $(".address-item")
                        .eq(i)
                        .appendTo(".address-inner");
            } else {
                $(".address-item")
                        .eq(0)
                        .appendTo(".address-inner");
            }
        }
    }
});


/*Item Slider End*/


$('#addressslider').on('slid.bs.carousel', '', function () {
    var $this = $(this);

    $this.children('.carousel-control-prev').show();
    $this.children('.carousel-control-next').show();

    if ($('.address-inner .address-item:first').hasClass('active')) {
        $this.children('.carousel-control-prev').hide();
    } else if ($('.address-inner .address-item:nth-child(3)').hasClass('active')) {
        $this.children('.carousel-control-next').hide();
    }

});

$(document).ready(function () {
    $('#addressslider').carousel({
        pause: true,
        interval: false,
    });
});







