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

// page active - improved logic
$(".main-navbar").find("a").removeClass("active");
$(".main-navbar").find("li").removeClass("active");

var current = window.location.pathname;
var found = false;

// First, try to find exact match for all links (including standalone items)
$(".main-navbar ul>li a, .main-navbar ul>li>a").each(function() {
    var link = $(this).attr("href");
    if (link && link === current) {
        $(this).addClass('active');
        $(this).closest('li').addClass('active');
        
        // Check if it's a submenu item
        var parentMenu = $(this).closest('.menu-content');
        if (parentMenu.length) {
            parentMenu.css('display', 'block');
            parentMenu.prev('.menu-title').addClass('active');
            parentMenu.prev('.menu-title').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
        }
        
        found = true;
        return false; // Break the loop
    }
});

// If no exact match found, try partial match (but exclude root path)
if (!found) {
    $(".main-navbar ul>li a, .main-navbar ul>li>a").each(function() {
        var link = $(this).attr("href");
        if (link && current.indexOf(link) !== -1 && link !== '/' && link.length > 1) {
            $(this).addClass('active');
            $(this).closest('li').addClass('active');
            
            // Check if it's a submenu item
            var parentMenu = $(this).closest('.menu-content');
            if (parentMenu.length) {
                parentMenu.css('display', 'block');
                parentMenu.prev('.menu-title').addClass('active');
                parentMenu.prev('.menu-title').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
            }
            
            return false; // Break the loop
        }
    });
}

// Save active menu state to localStorage
function saveActiveMenuState() {
    // Clear all previous states
    localStorage.removeItem('activeMenus');
    localStorage.removeItem('activeSubmenus');
    localStorage.removeItem('activeStandalone');
    
    var activeMenus = [];
    $('.menu-title.active').each(function() {
        var menuText = $(this).find('span').text().trim();
        if (menuText) {
            activeMenus.push(menuText);
        }
    });
    
    var activeSubmenus = [];
    $('.nav-submenu a.active').each(function() {
        activeSubmenus.push($(this).attr('href'));
    });
    
    // Save standalone menu items (like Profile)
    var activeStandalone = [];
    $('.nav-menu > li > a.active').each(function() {
        if (!$(this).hasClass('menu-title')) {
            activeStandalone.push($(this).attr('href'));
        }
    });
    
    // Only save if there are active items
    if (activeMenus.length > 0) {
        localStorage.setItem('activeMenus', JSON.stringify(activeMenus));
    }
    if (activeSubmenus.length > 0) {
        localStorage.setItem('activeSubmenus', JSON.stringify(activeSubmenus));
    }
    if (activeStandalone.length > 0) {
        localStorage.setItem('activeStandalone', JSON.stringify(activeStandalone));
    }
}

// Load active menu state from localStorage
function loadActiveMenuState() {
    try {
        // First, clear all active states
        $('.nav-menu > li > a').removeClass('active');
        $('.nav-menu > li').removeClass('active');
        $('.menu-title').removeClass('active');
        $('.nav-submenu a').removeClass('active');
        $('.menu-content').hide();
        $('.menu-title').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
        
        var activeMenus = JSON.parse(localStorage.getItem('activeMenus') || '[]');
        var activeSubmenus = JSON.parse(localStorage.getItem('activeSubmenus') || '[]');
        var activeStandalone = JSON.parse(localStorage.getItem('activeStandalone') || '[]');
        
        // Restore main menu states
        activeMenus.forEach(function(menuText) {
            $('.menu-title').each(function() {
                if ($(this).find('span').text().trim() === menuText) {
                    $(this).addClass('active');
                    $(this).next('.menu-content').css('display', 'block');
                    $(this).find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-down"></i></div>');
                }
            });
        });
        
        // Restore submenu states
        activeSubmenus.forEach(function(href) {
            $('.nav-submenu a[href="' + href + '"]').addClass('active');
        });
        
        // Restore standalone menu states (like Profile)
        activeStandalone.forEach(function(href) {
            $('.nav-menu > li > a[href="' + href + '"]').addClass('active');
            $('.nav-menu > li > a[href="' + href + '"]').closest('li').addClass('active');
        });
    } catch (e) {
        console.log('Error loading menu state:', e);
    }
}

// Save state when menu items are clicked
// Save state when menu items are clicked
$('.menu-title').on('click', function() {
// Clear standalone active states when dropdown is clicked
$('.nav-menu > li > a').not('.menu-title').removeClass('active');
setTimeout(saveActiveMenuState, 100);
});

$('.nav-submenu a').on('click', function() {
// Clear all active states
$('.nav-submenu a').removeClass('active');
$('.nav-menu > li > a').not('.menu-title').removeClass('active');
$('.nav-menu > li').not($(this).closest('li')).removeClass('active');
    
// Set current submenu item as active
$(this).addClass('active');
$(this).closest('li').addClass('active');
    
setTimeout(saveActiveMenuState, 100);
});

// Save state when standalone items are clicked (like Profile)
$('.nav-menu > li > a').not('.menu-title').on('click', function() {
    // Remove active class from all menu items
    $('.nav-menu > li > a').removeClass('active');
    $('.nav-menu > li').removeClass('active');
    $('.menu-title').removeClass('active');
    $('.nav-submenu a').removeClass('active');
    
    // Hide all dropdown menus
    $('.menu-content').slideUp(300);
    $('.menu-title').find('div').replaceWith('<div class="according-menu"><i class="fa fa-angle-right"></i></div>');
    
    // Set current item as active
    $(this).addClass('active');
    $(this).closest('li').addClass('active');
    
    setTimeout(saveActiveMenuState, 100);
});

// Load state on page load
$(document).ready(function() {
    loadActiveMenuState();
});

// Auto scroll to active element
if ($('a.nav-link.active').length) {
    $('.custom-scrollbar').animate({
        scrollTop: $('a.nav-link.active').offset().top - 500
    }, 1000);
}
