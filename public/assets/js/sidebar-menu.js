$(".toggle-nav").click(function () {
    $('.nav-menu').css("left", "0px");
});
$(".mobile-back").click(function () {
    $('.nav-menu').css("left", "-410px");
});

$(".page-wrapper").attr("class", "page-wrapper " + localStorage.getItem("page-wrapper"));
$(".page-body-wrapper").attr("class", "page-body-wrapper " + localStorage.getItem("page-body-wrapper"));

if (localStorage.getItem("page-wrapper") === null) {
    $(".page-wrapper").addClass("compact-wrapper");
}

// Close dropdown when clicking outside with smooth animation
$(document).on('click', function(e) {
    if (!$(e.target).closest('.main-nav, .toggle-sidebar').length) { // تغيير المستهدفات لضمان عدم إغلاق عند النقر على الشريط الجانبي نفسه
        $('.menu-content').slideUp(300);
        $('.menu-title').removeClass('active');
        $('.menu-title').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
    }
});

// left sidebar and horizontal menu
if ($('#pageWrapper').hasClass('compact-wrapper')) {
    jQuery('.submenu-title').append('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
    jQuery('.submenu-title').click(function () {
        jQuery('.submenu-title').not(this).removeClass('active'); // إزالة active من الآخرين
        jQuery('.submenu-title').not(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>'); // تغيير الأيقونات للآخرين
        jQuery('.submenu-content').not(jQuery(this).next()).slideUp(300); // إغلاق الآخرين

        if (jQuery(this).next().is(':hidden') == true) {
            jQuery(this).addClass('active');
            jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
            jQuery(this).next().slideDown(300);
        } else {
            jQuery(this).removeClass('active'); // إزالة active عند الإغلاق
            jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
            jQuery(this).next().slideUp(300);
        }
    });
    jQuery('.submenu-content').hide();

    jQuery('.menu-title').append('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
    jQuery('.menu-title').click(function (e) {
        e.stopPropagation(); // منع انتشار النقر
        jQuery('.menu-title').not(this).removeClass('active');
        jQuery('.menu-title').not(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
        jQuery('.menu-content').not(jQuery(this).next()).stop(true, true).slideUp(300); // توحيد السرعة إلى 300 وإضافة stop

        var $menuContent = jQuery(this).next();
        // $menuContent.css('transition', 'all 0.2s ease-in-out'); // **تم حذف هذا السطر** - سبب محتمل لمشكلة السلاسة

        if ($menuContent.is(':hidden')) {
            jQuery(this).addClass('active');
            jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
            $menuContent.css('display', 'block').hide().slideDown(300); // تغيير إلى 'block' بدلاً من 'flex' إذا كان هذا هو السلوك الافتراضي لـ slideDown
        } else {
            jQuery(this).removeClass('active'); // إزالة active عند الإغلاق
            jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
            $menuContent.slideUp(300);
        }
    });
    jQuery('.menu-content').hide();
} else if ($('#pageWrapper').hasClass('horizontal-wrapper')) {
    var contentwidth = jQuery(window).width();
    if ((contentwidth) < '992') {
        $('#pageWrapper').removeClass('horizontal-wrapper').addClass('compact-wrapper');
        $('.page-body-wrapper').removeClass('horizontal-menu').addClass('sidebar-icon');
        jQuery('.submenu-title').append('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
        jQuery('.submenu-title').click(function () {
            jQuery('.submenu-title').not(this).removeClass('active'); // إزالة active من الآخرين
            jQuery('.submenu-title').not(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>'); // تغيير الأيقونات للآخرين
            jQuery('.submenu-content').not(jQuery(this).next()).slideUp(300); // إغلاق الآخرين

            if (jQuery(this).next().is(':hidden') == true) {
                jQuery(this).addClass('active');
                jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
                jQuery(this).next().slideDown(300);
            } else {
                jQuery(this).removeClass('active'); // إزالة active عند الإغلاق
                jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
                jQuery(this).next().slideUp(300);
            }
        });
        jQuery('.submenu-content').hide();

        jQuery('.menu-title').append('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
        jQuery('.menu-title').click(function (e) {
            e.stopPropagation();
            jQuery('.menu-title').not(this).removeClass('active');
            jQuery('.menu-title').not(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
            jQuery('.menu-content').not(jQuery(this).next()).stop(true, true).slideUp(300); // توحيد السرعة وإضافة stop
            
            var $menuContent = jQuery(this).next();
            // $menuContent.css('transition', 'all 0.2s ease-in-out'); // **تم حذف هذا السطر**

            if ($menuContent.is(':hidden')) {
                jQuery(this).addClass('active');
                jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
                $menuContent.css('display', 'block').hide().slideDown(300); // تغيير إلى 'block' وتوحيد السرعة
            } else {
                jQuery(this).removeClass('active'); // إزالة active عند الإغلاق
                jQuery(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
                $menuContent.slideUp(300); // توحيد السرعة
            }
        });
        jQuery('.menu-content').hide();
    }
}

// toggle sidebar
$('.toggle-sidebar').click(function() {
    $('.main-nav').toggleClass('close_icon');
    $('.page-main-header').toggleClass('close_icon');
});


//responsive sidebar
var $window = $(window);
var widthwindow = $window.width();
(function($) {
"use strict";
if(widthwindow+17 <= 993) {
    $('.toggle-sidebar').attr('checked', false);
    $('.main-nav').addClass("close_icon");
    $('.page-main-header').addClass("close_icon");
}
})(jQuery);


$( window ).resize(function() {
var widthwindaw = $window.width();

if(widthwindaw+17 <= 991){
    $('.toggle-sidebar').attr('checked', false);
    $('.main-nav').addClass("close_icon");
    $('.page-main-header').addClass("close_icon");
}else{
    $('.toggle-sidebar').attr('checked', false);
    $('.main-nav').removeClass("close_icon");
    $('.page-main-header').removeClass("close_icon");
}

if(widthwindow >= 768) {
    $('.toggle-sidebar').click(function() {
        $('.main-nav').toggleClass('close_icon');
        $('.page-main-header').toggleClass('close_icon');
    });
}
});

// horizontal arrowss
var view = $("#mainnav");
var move = "500px";
var leftsideLimit = -500; // تم تعديل تعريف المتغير

// get wrapper width
var getMenuWrapperSize = function () {
    return $('.sidebar-wrapper').innerWidth();
}
var menuWrapperSize = getMenuWrapperSize();

if ((menuWrapperSize) >= '1660') {
    var sliderLimit = -3000;
} else if ((menuWrapperSize) >= '1440') {
    var sliderLimit = -3600;
} else {
    var sliderLimit = -4200;
}

$("#left-arrow").addClass("disabled");
$("#right-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition >= sliderLimit) {
        $("#left-arrow").removeClass("disabled");
        view.stop(false, true).animate({
            marginLeft: "-=" + move
        }, {
            duration: 400
        });
        if (currentPosition == sliderLimit) {
            $(this).addClass("disabled");
            console.log("sliderLimit", sliderLimit);
        }
    }
});

$("#left-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition < 0) {
        view.stop(false, true).animate({
            marginLeft: "+=" + move
        }, {
            duration: 400
        });
        $("#right-arrow").removeClass("disabled");
        $("#left-arrow").removeClass("disabled");
        if (currentPosition >= leftsideLimit) {
            $(this).addClass("disabled");
        }
    }
});

// page active
$( ".main-navbar" ).find( "a" ).removeClass("active");
$( ".main-navbar" ).find( "li" ).removeClass("active");

var current = window.location.pathname;
$(".main-navbar ul>li a").filter(function() {
    var link = $(this).attr("href");
    if(link){
        if (current.indexOf(link) != -1) {
            $(this).parents().children('a').addClass('active');
            $(this).parents().parents().children('ul').css('display', 'block');
            $(this).addClass('active');
            $(this).parent().parent().parent().children('a').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
            $(this).parent().parent().parent().parent().parent().children('a').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
            return false;
        }
    }
});

$('.custom-scrollbar').animate({
    scrollTop: $('a.nav-link.menu-title.active').offset().top - 500
}, 1000);