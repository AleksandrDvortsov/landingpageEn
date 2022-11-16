"use strict";


// Get Doctors by departaments //
$(document).on('click', '.jsa_get_doctors', function() {

    var data = {};
    var dep_id = parseInt($(this).attr('data-dep-id'));
    data['dep_id'] = dep_id;
    data['task'] = 'get_doctors_by_departaments';

    $.ajax({
        type: "POST",
        url: amc_ajax,
        data: data,
        dataType: 'html',
        success: function (ajax_data)
        {
            $('#ajax_get_doctors_container').html(ajax_data);
        }
    });

    return false;

});
// Get Doctors by departaments End //


function get_department_doctors(dep_id)
{

    var data = {};
    data['dep_id'] = dep_id;
    data['task'] = 'get_department_doctors';
    $.ajax({
        type: "POST",
        url: amc_ajax,
        data: data,
        dataType: 'html',
        success: function (ajax_data)
        {
            $('#doctor_ajax_info').html(ajax_data);
            $('#doctor_ajax_info2').html(ajax_data);
            $(".selectmenu").selectmenu();
        }
    });

}


//===RevolutionSliderActiver===
function revolutionSliderActiver() {
    if ($('.rev_slider_wrapper #slider1').length) {
        $("#slider1").revolution({
            sliderType: "standard",
            sliderLayout: "auto",
            delay: 5000,
            startwidth: 1170,
            startheight: 750,

            navigationType: "bullet",
            navigationArrows: "0",
            navigationStyle: "preview4",

            dottedOverlay: 'yes',

            hideTimerBar: "off",
            onHoverStop: "off",
            navigation: {
                arrows: {enable: true}
            },
            gridwidth: [1170],
            gridheight: [750]
        });
    }
    ;
}


//====Main menu===
function mainmenu() {
    //Submenu Dropdown Toggle
    if ($('.main-menu li.dropdown ul').length) {
        $('.main-menu li.dropdown').append('<div class="dropdown-btn"></div>');

        //Dropdown Button
        $('.main-menu li.dropdown .dropdown-btn').click(function () {
            $(this).prev('ul').slideToggle(500);
        });
    }

}


//===Header Sticky===
function stickyHeader() {
    if ($('.stricky').length) {
        var strickyScrollPos = 100;
        if ($(window).scrollTop() > strickyScrollPos) {
            $('.stricky').addClass('stricky-fixed');
            $('.scroll-to-top').fadeIn(1500);
        } else if ($(this).scrollTop() <= strickyScrollPos) {
            $('.stricky').removeClass('stricky-fixed');
            $('.scroll-to-top').fadeOut(1500);
        }
    }
    ;
}


//===scoll to Top===
function scrollToTop() {
    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").click(function () {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

        });
    }
}


//=== Prealoder===
function prealoader() {
    $('.preloader').hide();
    /*
    if ($('.preloader').length) {
        $('.preloader').delay(1000).fadeOut(300);
    }
    */
}


//===Language switcher===
function languageSwitcher() {
    if ($("#polyglot-language-options").length) {
        $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
            effect: 'slide',
            animSpeed: 500,
            testMode: true,
            onChange: function (evt) {
                alert("The selected language is: " + evt.selectedItem);
            }

        });
    }
    ;
}


// Search Toggle Btn
function search() {
    if ($('.toggle-search').length) {
        $('.toggle-search').on('click', function () {
            $('.header-search').slideToggle(300);
        });

    }
}


//=== History Carousel ===
function madicalCarousel() {
    if ($('.pakets-medikal').length) {
        $('.pakets-medikal').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 700,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        })
    }
}


//=== Testimonial Carousel===
function testimonialCarousel() {
    if ($('.testimonial-carousel').length) {
        $('.testimonial-carousel').owlCarousel({
            dots: true,
            loop: true,
            margin: 30,
            nav: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 2
                },
                1100: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        });
    }
}


//=== Testimonial Carousel===
// function paketsMedikal() {
//     if ($('.pakets-medikal').length) {
        $('.pakets-medikal').owlCarousel({
            dots: false,
            loop: true,
            margin: 25,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            // autoplayHoverPause: false,
            // autoplay: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
               
                600: {
                    items: 1,
                    nav: false
                },
                800: {
                    items: 2,
                    nav: false
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
//     }
// }

      $('.grid').masonry({
  itemSelector: '.grid-item',
  fitWidth: true
  
});



$('.doktors-block').owlCarousel({
            dots: false,
            loop: true,
            margin: 25,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            // autoplayHoverPause: false,
            // autoplay: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 1,
                    nav: false
                },
                800: {
                    items: 2,
                    nav: false
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });




/*Custom Select La Pagina principla*/

$(".custom-select").each(function() {
  var classes = $(this).attr("class"),
      id      = $(this).attr("id"),
      name    = $(this).attr("name");
  var template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });
  template += '</div></div>';
  
  $(this).wrap('<div class="custom-select-wrapper"></div>');
  $(this).hide();
  $(this).after(template);
});
$(".custom-option:first-of-type").hover(function() {
  $(this).parents(".custom-options").addClass("option-hover");
}, function() {
  $(this).parents(".custom-options").removeClass("option-hover");
});
$(".custom-select-trigger").on("click", function() {
  $('html').one('click',function() {
    $(".custom-select").removeClass("opened");
  });
  $(this).parents(".custom-select").toggleClass("opened");
  event.stopPropagation();
});
$(".custom-option").on("click", function() {
  $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
  $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
  $(this).addClass("selection");
  $(this).parents(".custom-select").removeClass("opened");
  $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());

  //-------------Determine SELECT IDENTIFICATOR---------------------//
    var selected_indentificator = $(this).parents(".custom-select-wrapper").find("select").attr('id');
    if(selected_indentificator == 'sources')
    {
       var selected_value = parseInt($(this).data("value"));
        ajax_dinamic_packets(selected_value);
    }
    else
    if(selected_indentificator == 'doctor_sources')
    {
        var selected_value = parseInt($(this).data("value"));
        ajax_dinamic_doctors(selected_value);
    }


});


function doktors_block_owlCarousel() {
    $('.doktors-block').owlCarousel({
        dots: false,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
        ],
        // autoplayHoverPause: false,
        // autoplay: 6000,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            800: {
                items: 2
            },
            1024: {
                items: 3
            },
            1100: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
}
//=== History Carousel ===
function facilitiesCarousel() {
    if ($('.facilities-carousel').length) {
        $('.facilities-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 700,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                800: {
                    items: 1
                },
                1024: {
                    items: 1
                },
                1100: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }
}


//===Achivement Carousel===
function serviceCarousel() {
    if ($('.servicecarousel').length) {
        $('.servicecarousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplayHoverPause: false,
            autoplay: 10000,
            smartSpeed: 700,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        })
    }
}


//=== History Carousel ===
function certificatesCarousel() {
    if ($('.certificates').length) {
        $('.certificates').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 700,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        })
    }
}


//===Prettyphoto Lightbox===
function prettyPhoto() {
    $("a[data-rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'normal',
        slideshow: 3000,
        autoplay_slideshow: false,
        fullscreen: true,
        social_tools: false
    });
}


// ===Project===
function projectMasonaryLayout() {
    if ($('.masonary-layout').length) {
        $('.masonary-layout').isotope({
            layoutMode: 'masonry'
        });
    }

    if ($('.post-filter').length) {
        $('.post-filter li').children('span').click(function () {
            var Self = $(this);
            var selector = Self.parent().attr('data-filter');
            $('.post-filter li').children('span').parent().removeClass('active');
            Self.parent().addClass('active');


            $('.filter-layout').isotope({
                filter: selector,
                animationOptions: {
                    duration: 500,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    }

    if ($('.post-filter.has-dynamic-filter-counter').length) {
        // var allItem = $('.single-filter-item').length;

        var activeFilterItem = $('.post-filter.has-dynamic-filter-counter').find('li');

        activeFilterItem.each(function () {
            var filterElement = $(this).data('filter');
            console.log(filterElement);
            var count = $('.gallery-content').find(filterElement).length;

            $(this).children('span').append('<span class="count"><b>' + count + '</b></span>');
        });
    }
    ;
}


//===Brand Carousel===
function brandCarousel() {
    if ($('.brand').length) {
        $('.brand').owlCarousel({
            dots: false,
            loop: true,
            margin: 30,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1024: {
                    items: 4
                },
                1100: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        });
    }
}


//===Event Carousel===
function eventCarousel() {
    if ($('.event-carousel').length) {
        $('.event-carousel').owlCarousel({
            dots: false,
            loop: true,
            margin: 30,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            autoplayHoverPause: false,
            autoplay: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                800: {
                    items: 1
                },
                1024: {
                    items: 1
                },
                1100: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        });
    }
}


//=== Fact counter ===
function CounterNumberChanger() {
    var timer = $('.timer');
    if (timer.length) {
        timer.appear(function () {
            timer.countTo();
        })
    }

}


//=== Tool tip ===
function tooltip() {
    if ($('.tool_tip').length) {
        $('.tool_tip').tooltip();
    }
    ;
    $
}


//=== Accordion ===
function accordion() {
    if ($('.accordion-box').length) {
        $('.accordion-box .accord-btn').click(function () {
            if ($(this).hasClass('active') !== true) {
                $('.accordion-box .accord-btn').removeClass('active');
            }

            if ($(this).next('.accord-content').is(':visible')) {
                $(this).removeClass('active');
                $(this).next('.accord-content').slideUp(500);
            }

            else {
                $(this).addClass('active');
                $('.accordion-box .accord-content').slideUp(500);
                $(this).next('.accord-content').slideDown(500);
            }
        });
    }
}


//=== Cart Touch Spin ===
function cartTouchSpin() {
    if ($('.quantity-spinner').length) {
        $("input.quantity-spinner").TouchSpin({
            verticalbuttons: true
        });
    }
}


// Select menu
function selectDropdown() {
    if ($(".selectmenu").length) {
        $(".selectmenu").selectmenu();

        var changeSelectMenu = function (event, item) {
            $(this).trigger('change', item);
            get_department_doctors(parseInt(item.item.value))
        };
        $(".selectmenu").selectmenu({change: changeSelectMenu});
    }
    ;
}


//  Price Filter
function priceFilter() {
    if ($('.price-ranger').length) {
        $('.price-ranger #slider-range').slider({
            range: true,
            min: 10,
            max: 200,
            values: [11, 99],
            slide: function (event, ui) {
                $('.price-ranger .ranger-min-max-block .min').val('$' + ui.values[0]);
                $('.price-ranger .ranger-min-max-block .max').val('$' + ui.values[1]);
            }
        });
        $('.price-ranger .ranger-min-max-block .min').val('$' + $('.price-ranger #slider-range').slider('values', 0));
        $('.price-ranger .ranger-min-max-block .max').val('$' + $('.price-ranger #slider-range').slider('values', 1));
    }
    ;
}


// ===Date picker ===
function datepicker() {
    if ($('#datepicker').length) {
        $('#datepicker').datepicker();
    }

    if ($('#datepicker2').length) {
        $('#datepicker2').datepicker();
    }
    ;
}

/*
//=== Time picker===
function timepicker() {
    $('input[name="time"]').ptTimeSelect();
}
*/

//=== CountDownTimer===
function countDownTimer() {
    if ($('.time-countdown').length) {
        $('.time-countdown').each(function () {
            var Self = $(this);
            var countDate = Self.data('countdown-time'); // getting date

            Self.countdown(countDate, function (event) {
                $(this).html('<h2>' + event.strftime('%D : %H : %M : %S') + '</h2>');
            });
        });
    }
    ;
    if ($('.time-countdown-two').length) {
        $('.time-countdown-two').each(function () {
            var Self = $(this);
            var countDate = Self.data('countdown-time'); // getting date

            Self.countdown(countDate, function (event) {
                $(this).html('<li> <div class="box"> <span class="days">' + event.strftime('%D') + '</span> <span class="timeRef">days</span> </div> </li> <li> <div class="box"> <span class="hours">' + event.strftime('%H') + '</span> <span class="timeRef">hours</span> </div> </li> <li> <div class="box"> <span class="minutes">' + event.strftime('%M') + '</span> <span class="timeRef">minutes</span> </div> </li> <li> <div class="box"> <span class="seconds">' + event.strftime('%S') + '</span> <span class="timeRef">seconds</span> </div> </li>');
            });
        });
    }
    ;
}


//=== Contact Form Validation ===
if ($("#contact-form").length) {
    $("#contact-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function () {
                        $(form_result_div).fadeOut('slow')
                    }, 6000);
                }
            });
        }
    });
}


//=== Add comment Form Validation ===
if ($("#add-comment-form").length) {
    $("#add-comment-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function () {
                        $(form_result_div).fadeOut('slow')
                    }, 6000);
                }
            });
        }
    });
}


//=== Review Form Validation ===
if ($("#consultation-form").length) {
    $("#consultation-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function () {
                        $(form_result_div).fadeOut('slow')
                    }, 6000);
                }
            });
        }
    });
}


//=== Review Form Validation ===
if ($("#review-form").length) {
    $("#review-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function () {
                        $(form_result_div).fadeOut('slow')
                    }, 6000);
                }
            });
        }
    });
}


//=== Review Form Validation ===
if ($("#request-form").length) {
    $("#request-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            var form_result_div = '#form-result';
            $(form_result_div).remove();
            form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
            var form_btn_old_msg = form_btn.html();
            form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
            $(form).ajaxSubmit({
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'true') {
                        $(form).find('.form-control').val('');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);
                    $(form_result_div).html(data.message).fadeIn('slow');
                    setTimeout(function () {
                        $(form_result_div).fadeOut('slow')
                    }, 6000);
                }
            });
        }
    });
}


// Elements Animation
if ($('.wow').length) {
    var wow = new WOW({
        mobile: false
    });
    wow.init();
}


// Dom Ready Function
jQuery(document).ready(function () {
    (function ($) {
        // add your functions
        revolutionSliderActiver();
        mainmenu();
        scrollToTop();
        search();
        languageSwitcher();
        selectDropdown();
        CounterNumberChanger();
        accordion();
        datepicker();
        projectMasonaryLayout();
        priceFilter();
        countDownTimer();
        madicalCarousel();
        cartTouchSpin();
        facilitiesCarousel();
        testimonialCarousel();
        serviceCarousel();
        brandCarousel();
        prettyPhoto();
      //  timepicker();
        tooltip();
        certificatesCarousel();
        eventCarousel()


    })(jQuery);
});


// Scroll Function
jQuery(window).scroll(function () {
    (function ($) {
        stickyHeader()

    })(jQuery);
});


// Instance Of Fuction While Window Load event
jQuery(window).load(function () {
    (function ($) {
        prealoader();

    })(jQuery);
});


$('[data-fancybox="images"]').fancybox({
    margin: [44, 0, 22, 0],
    thumbs: {
        autoStart: true,
        axis: 'x'
    }
});



// Dom Ready Function
jQuery(document).ready(function () {
    (function ($) {
        // add your functions
        $('.usefull-links-text-info').parent('.single-footer-widget').addClass('no-height-fixed');



    })(jQuery);
});

$(function () {

    $("nav ul li").removeClass('current');
    var pgurl = window.location.href.substr(window.location.href
        .lastIndexOf("/") + 1);
    $("nav ul li a").each(function () {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).parent('li').addClass("current");
    });

 // CLICK TABS GALERY

 $('.item-tab').on('click', function(){

        $('.item-tab').removeClass('item-tab-active')
        $(this).addClass('item-tab-active')
        $('.main-project-area').removeClass('main-project-area-active')
        $('.main-project-area').eq($(this).index()).addClass('main-project-area-active')
    })

});



