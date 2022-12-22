jQuery(function ($) {

    'use strict';

    var xs = 360,
	    sm = 576,
	    md = 768,
	    lg = 992,
	    xl = 1200,
	    xx = 1360,
	    xxl = 1715,
	    xxxl = 2300;

	// Window width
	var w = $(window).width();

    $(window).ready(function () {
        var $preloader = $('#page-preloader');
        $preloader.delay(350).fadeOut(500);
    });
    
    // Remove scroll to top page from # click
	$('a[href="#"], a[href*="#pix"]').on('click', function (e) {
		e.preventDefault();
	});
    

    /* ============== Custom scrollbar =============== */
	window.isMobile = /iphone|ipod|ipad|android|blackberry|opera mini|opera mobi|skyfire|maemo|windows phone|palm|iemobile|symbian|symbianos|fennec/i.test(navigator.userAgent.toLowerCase());
	if (!window.isMobile) {
		$('[data-scrollbar], .cboxIframe').customScrollbar({
			hScroll: false,
			skin: 'default-skin',
			updateOnWindowResize: true,
			preventDefaultScroll: true,
			fixedThumbHeight: true
		});

		$('[data-scrollbar], .cboxIframe').bind('customScroll mousewheel DOMMouseScroll', function (e) {
			var scrollTo = null;
			if (e.type === 'mousewheel') {
				scrollTo = e.originalEvent.wheelDelta * -1;
			} else if (e.type === 'DOMMouseScroll') {
				scrollTo = 40 * e.originalEvent.detail;
			}
			if (scrollTo) {
				e.preventDefault();
				$(this).scrollTop(scrollTo + $(this).scrollTop());
			}
		});
	}

	/* =============================================== */


	// Menu
	$( "ul.nav li.pix-mega-menu:hover li:hover" ).each(function( index ){
		event.stopPropagation();
	});

	/* =========== Login / Register popup ============ */
	$('.pix-header-user-panel input:not([type=checkbox])').on('focus input', function (e) {
		$(this).parent('.form-group').addClass('edit');
	});

	$('.pix-header-user-panel input:not([type=checkbox])').on('blur', function (e) {
		if ($(this).prop('value') === '') {
			$(this).parent('.form-group').removeClass('edit');
		}
	});

	$('.pix-header-user-tabs a').on('click touch', function (e) {
		var target = $(this).attr('href');
		$(this).addClass('active').siblings().removeClass('active');
		$(target).addClass('active').siblings().removeClass('active');
		e.preventDefault();
	});
	/* =============================================== */


    /* ================= Second menu ================= */
	$('.pix__secondMenu > a').on('mouseover touchstart touch', function () {
		$(this).next().addClass('show');
	});

	$('.pix__secondMenu').on('mouseleave', function () {
		$(this).children('ul.show').stop().removeClass('show');
		$(this).children('.pix-section.show').stop().removeClass('show');
	});
	
	$(document).on('mouseover', '.pix__secondMenu .pix-section', function(){
        $(this).stop().addClass('show');
    });
	$(document).on('mouseleave', '.pix__secondMenu .pix-section.show', function(){
        $(this).stop().removeClass('show');
    });

	$('.pix__secondMenu > ul.show').on('mouseleave', function () {
		$(this).stop().removeClass('show');
	});

	$('.pix__secondMenu > ul > li:even > a').on('mouseover touchstart touch', function () {
		$(this).parent().addClass('active').siblings('.active').removeClass('active');
	});
	/* =============================================== */

 
 
 
	// Mobile menu
	$('.js-search-toggle').on('click', function(){
		$('.menu-mobile__header .navbar-brand').toggleClass('hide');
		$('.menu-mobile__header .js-mobile-toggle').toggleClass('hide');
		$('.menu-mobile__header:not(.pix-top-bar) .cart-container').toggleClass('hide');
		$('.menu-mobile__header .pix-header-mobile-icons').toggleClass('hide');
		$('.menu-mobile__header:not(.pix-top-bar) .pix-header-mobile-col-right').toggleClass('search');
		$('.js-search-toggle').next().toggleClass('show');
		if( $('.js-search-toggle').next().hasClass('show') ){
			$('.js-search-toggle + .search-container > .input-container').html(pix_js_vars.search_form);
            $('.js-search-toggle').removeClass('fas').addClass('far').removeClass('fa-search').addClass('fa-times-circle');
		} else {
            $('.js-search-toggle').removeClass('fa-times-circle').addClass('fa-search').removeClass('far').addClass('fas');
		}
	});

	
    // Mobile menu
    if($(window).width() <= 1000) {

        if ($('.menu-mobile').hasClass('sticky')) {
            if ($(window).scrollTop() > 0) {
                $('.menu-mobile.sticky').addClass('fixed');
            }
            $(window).scroll(function () {
                if ($(window).scrollTop() > 0) {
                    $('.menu-mobile.sticky').addClass('fixed');
                } else {
                    $('.menu-mobile.sticky').removeClass('fixed');
                }
            });
        }

        // Sticky on Up Scroll
        if ($('.menu-mobile').hasClass('sticky-up')) {

            var previousScroll = 0,
                headerOrgOffset = $('.menu-mobile.sticky-up').offset().top;

            $(window).scroll(function () {
                var currentScroll = $(this).scrollTop();
                //console.log(currentScroll + " and " + previousScroll + " and " + headerOrgOffset);
                if (currentScroll > headerOrgOffset) {
                    if (currentScroll > previousScroll) {
                        $('.menu-mobile.sticky-up').fadeOut();
                    } else {
                        $('.menu-mobile.sticky-up').fadeIn();
                        $('.menu-mobile.sticky-up').addClass('fixed');
                    }
                } else {
                    $('.menu-mobile.sticky-up').removeClass('fixed');
                }
                previousScroll = currentScroll;
            });
        }


        $('.js-mobile-toggle').on('click', function(){
            function fadeMenu(){
                $( '.menu-mobile__list:not(.pix-catalog)' ).toggleClass('show');
            }
            function fadeMenuCat(){
                $( ".menu-mobile__list.pix-catalog" ).toggleClass('show');
            }
            if( ( $(this).hasClass('pix-button') && $('.menu-mobile__list:not(.pix-catalog)').hasClass('show') ) || ( !$(this).hasClass('pix-button') && $('.menu-mobile__list.pix-catalog').hasClass('show') ) ){
                $('.menu-mobile__list:not(.pix-catalog)').toggle();
                $('.menu-mobile__list.pix-catalog').toggle();
                setTimeout(fadeMenu, 1);
                setTimeout(fadeMenuCat, 1);
            } else {
                $('body').toggleClass('pix-body-fixed');
                if($(this).hasClass('pix-button')){
                    $('.menu-mobile__list.pix-catalog').toggle();
                    setTimeout(fadeMenuCat, 1);
                } else {
                    $('.menu-mobile__list:not(.pix-catalog)').toggle();
                    setTimeout(fadeMenu, 1);
                }
            }

        });
        $(".pix-mobile-menu-container ul li a[href^='#']").on('click', function(event){
            $('.js-mobile-toggle').click();
        });
        $(document).on('click touch touchstart', '.pix-body-fixed .pix section, .pix-body-fixed .pix .home-template', function(){
            $('body').removeClass('pix-body-fixed');
            if($('.menu-mobile__list.pix-catalog').hasClass('show')){
                $('.menu-mobile__list.pix-catalog').toggle();
                $('.menu-mobile__list.pix-catalog').removeClass('show');
            } else if($('.menu-mobile__list:not(.pix-catalog)').hasClass('show')){
                $('.menu-mobile__list:not(.pix-catalog)').toggle();
                $('.menu-mobile__list:not(.pix-catalog)').removeClass('show');
            }
            $('.js-mobile-toggle').removeClass('is-active');
            
        });
        $('.pix-mobile-menu-container ul li:not(.js-mobile-menu)').on('click', function(event){
            event.stopPropagation();
        });
        $('.js-mobile-menu').on('click', function(event){
            event.stopPropagation();
            $('.mobile-submenu:first', this).slideToggle();
            $(this).toggleClass('purple');
        });
        $( '.menu-mobile__list:not(.pix-catalog) .js-mobile-menu' ).each(function( index ){
            $(this).append($( '<i class="fa fa-angle-down" aria-hidden="true">' ));
        });

    }
	



	$('#js-search-container>a').on('click', function(){
		$('.search-container > .input-container').html(pix_js_vars.search_form);
        $('.search-container').addClass('show');
        $('.menu-logo').addClass('hide');
        $('.pix-header-mobile-icons').addClass('hide');
        $('.pix-header nav').addClass('hide');
    });

	$('.pix-search-close').on('click', function(){
		$('.search-container').removeClass('show');
		$('.menu-logo').removeClass('hide');
		$('.pix-header-mobile-icons').removeClass('hide');
		$('.pix-header nav').removeClass('hide');
	});

	if( $('.pix-header.sticky').hasClass('pix-levels') ){
        if ( $(window).scrollTop() > 0 ){
            $('.pix-header.sticky').addClass('fixed');
        }
        $(window).scroll(function() {
            if ($(window).scrollTop() > 0){
                $('.pix-header.sticky').addClass('fixed');
            } else {
                $('.pix-header.sticky').removeClass('fixed');
            }
        });
        var classes = $('.pix-header .pix-header-menu').attr('class');
        var style = getComputedStyle(document.body);
        var height = style.getPropertyValue('--pix-header-height').replace ( /[^\d.]/g, '' );
        if ( $(window).scrollTop() > height ){
            $('.pix-header.sticky').addClass('fixed');
            $('.pix-header .pix-header-menu').removeClass().addClass('pix-header-menu');
        }
        $(window).scroll(function() {
            if ($(window).scrollTop() > height){
                $('.pix-header.sticky').addClass('fixed');
                $('.pix-header .pix-header-menu').removeClass().addClass('pix-header-menu');
            } else {
                $('.pix-header.sticky').removeClass('fixed');
                $('.pix-header .pix-header-menu').removeClass().addClass(classes);
            }
        });
    } else {
        if ( $(window).scrollTop() > 0 ){
            $('.pix-header.sticky').addClass('fixed');
            $('.pix-header-placeholder').addClass('fixed');
        }
        $(window).scroll(function() {
            if ($(window).scrollTop() > 0){
                $('.pix-header.sticky').addClass('fixed');
                $('.pix-header-placeholder').addClass('fixed');
            } else {
                $('.pix-header.sticky').removeClass('fixed');
                $('.pix-header-placeholder').removeClass('fixed');
            }
        });
    }

    // Sticky on Up Scroll
	if( $('.pix-header').hasClass('sticky-up') ) {

        var previousScroll = 0,
            headerOrgOffset = $('.pix-header.sticky-up').offset().top;

        $(window).scroll(function () {
            var currentScroll = $(this).scrollTop();
            
            if (currentScroll > headerOrgOffset) {
                if (currentScroll > previousScroll) {
                    $('.pix-header.sticky-up').fadeOut();
                } else {
                    $('.pix-header.sticky-up').fadeIn();
                    $('.pix-header.sticky-up').addClass('fixed');
                    $('.pix-header-placeholder').addClass('fixed');
                }
            } else {
                $('.pix-header.sticky-up').removeClass('fixed');
                $('.pix-header-placeholder').removeClass('fixed');
            }
            previousScroll = currentScroll;
        });
    }



    /* =================== Countdown ================= */
    function pix_countdown() {
        $('[data-countdown]').each(function () {
            var $this = $(this),
                finalDate = $(this).data('countdown');
        
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('%D days %H:%M:%S'));
            });
        
        });
    }
    pix_countdown();

	/* =============================================== */

    

    //init range slider
    function pixSliderRange() {
        var sliderRangeBox = $('.pix-range-box');

        sliderRangeBox.each(function () {
            var sliderRange = $(this).find('.pix-range-slider'),
                sliderMin = +sliderRange.attr('data-min'),
                sliderMax = +sliderRange.attr('data-max'),
                input_minVal = $(this).find('.pix-min'),
                input_maxVal = $(this).find('.pix-max');
            if( input_minVal.val() === '' ){
                input_minVal.val(sliderMin);
            }
            if( input_maxVal.val() === '' ){
                input_maxVal.val(sliderMax);
            }

            sliderRange.ionRangeSlider({
                onFinish: function (data) {
                    input_minVal.val(data.from);
                    input_maxVal.val(data.to);
                    input_minVal.change();
                }
            });

        });

    }
    pixSliderRange();

    
    // function getSelectValues(id) {
    //     let result = [];
    //     let collection = document.querySelectorAll("#" + id + " option");
    //     collection.forEach(function (x) {
    //         if (x.selected) {
    //             result.push(x.value);
    //         }
    //     });
    //     return result;
    // }
    
    


	/* =============== Product Icons ================= */
	$('a:has(i.pix-flaticon-statistics)').on('click', function () {
		var x = $(this).children();
		x.toggleClass('pix-flaticon-statistics pit-reload');
		setTimeout(function () {
			x.toggleClass('pix-flaticon-statistics pit-reload');
		}, 1000);
	});
	/* =============================================== */
    
	
	
	
	
    //-------------------------------------------

    //init isotope
    var $grid = $('.pix-isotope-items').isotope({
        // options
        itemSelector: '.pix-isotope-item',
        stagger: 30,
        transitionDuration: 0,
        stamp: '.pix-sidebar-filter',
        hiddenStyle: {
            opacity: 0,
            transform: 'scale(0.001)'
        },
        visibleStyle: {
            opacity: 1,
            transform: 'scale(1)'
        },
        masonry: {
            columnWidth: '.pix-isotope-item',
		    gutter: '.pix-gutter-sizer'
        },
        percentPosition: true
    });
    $grid.imagesLoaded().progress( function() {
        $grid.isotope('layout');
    });
    //isotope filter
    $('.pix-filter-head ul li a').on( 'click', function(event) {
        event.preventDefault();
        var $isotop_parent = $(this).closest('.pix-isotope');
        $isotop_parent.find('.pix-filter-head ul li').removeClass('active');
        $(this).parent('li').addClass('active');

        var filterValue = $(this).attr('data-filter');
        $isotop_parent.find('.pix-isotope-items').isotope({ filter: filterValue });
    });
    //-------------------------------------------





    //spinner
    var spinnerInput = $('.pix-spinner-input');
    $('.pix-spinner-plus').on('click', function () {
        var val = spinnerInput.val();
        val++;
        spinnerInput.val(val);
    });
    $('.pix-spinner-minus').on('click', function () {
        var val = spinnerInput.val();
        if(val <= 1){
            val = 1;
            spinnerInput.val(val);
        }else{
            val--;
            spinnerInput.val(val);
        }
    });
    spinnerInput.on('change', function () {
        var val = $(this).val();
        if(val <= 1){
            val = 1;
            $(this).val(val);
        }
    });
    //------------------------------------------------
    
    var pixGallerySwiper = [];
    $('.pix-gallery').each(function(i, el) {
        var options = {},
            $gallery_slider = $('.pix-gallery-slider', this),
            $gallery_filter = $gallery_slider.hasClass('pix-filter'),
            $margin = $gallery_slider.data('gap'),
            $count = $gallery_slider.data('col'),
            next = $(this).find('.swiper-button-next')[0],
            prev = $(this).find('.swiper-button-prev')[0],
            paging = $(this).find('.swiper-pagination')[0];
        
        $gallery_slider.attr('data-index', 'swg' + i);
        
        options.watchSlidesVisibility = true;
        options.watchOverflow = true;
        options.simulateTouch = true;
        
        if ($gallery_slider.data('nav') === 'nav') {
            options.navigation = {
                nextEl: next,
                prevEl: prev
            };
        } else if ($gallery_slider.data('nav') === 'dots') {
            options.pagination = {
                el: paging,
                clickable: true
            };
        }
        
        options.breakpoints = {
            0: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            768: {
                slidesPerView: 2,
                spaceBetween: $margin
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: $margin
            },
            2300: {
                slidesPerView: ($count + 1),
                spaceBetween: $margin
            }
        };
    
        pixGallerySwiper['swg' + i] = new Swiper($gallery_slider[0], options);

        if($gallery_filter) {
            
            $(".categories span").on("click", function() {
                var $item = $(this);
                var filter = $item.data('owl-filter');
                //var filter = $(this).html().toLowerCase();
                var slidesxcol;
                $(".categories span")
                $(".categories span").removeClass("active");
                $(this).addClass("active");
    
                if (filter == "all") {
                    $("[data-filter]").removeClass("non-swiper-slide").addClass("swiper-slide").show();
                    if ($(".swiper-slide").length > 6)
                        slidesxcol = 3;
                    else slidesxcol = 1;
                        swiper.destroy();
                    swiper = new Swiper('.swiper-container', {
                        pagination: '.swiper-pagination',
                        slidesPerView: 3,
                        slidesPerColumn: slidesxcol,
                        paginationClickable: true,
                        spaceBetween: 30
                    });
                } else {
                    $(".swiper-slide").not("[data-filter='" + filter + "']").addClass("non-swiper-slide").removeClass("swiper-slide").hide();
                    $("[data-filter='" + filter + "']").removeClass("non-swiper-slide").addClass("swiper-slide").attr("style", null).show();
                    console.log($(".swiper-slide").length)
                    if ($(".swiper-slide").length > 6)
                        slidesxcol = 3;
                    else slidesxcol = 1;
                        swiper.destroy();
                    swiper = new Swiper('.swiper-container', {
                        pagination: '.swiper-pagination',
                        slidesPerView: 3,
                        slidesPerColumn: slidesxcol,
                        paginationClickable: true,
                        spaceBetween: 30
                    });
                }
            });
            
            $('.owl-filter-bar', this).on('click', '.item', function () {

                var $item = $(this);
                var filter = $item.data('owl-filter')

                $item.addClass('pix-active').siblings().removeClass('pix-active');

                $gallery_slider.owlcarousel2_filter(filter);

            });
        }

    });
    //------------------------------------------------
    
    
    var $swiper = $('[data-swiper-options]'),
        pixSwiper = [];
    if ($swiper.length) {
        $swiper.each(function (i, el) {
            var options = $(this).data('swiper-options'),
                container = $(this).parent().parent(),
                parent = $(this).parent(),
                $slider = $(this),
                next = $(this).parent().parent().parent().find('.swiper-button-next')[0],
                prev = $(this).parent().parent().parent().find('.swiper-button-prev')[0],
                paging = $(this).parent().parent().parent().find('.swiper-pagination')[0];
        
            $(this).attr('data-index', 'sw' + i);
            if ($(window).width() <= sm) {
                options.slidesPerColumn = 1;
            }
            
            options.watchSlidesVisibility = true;
            options.watchOverflow = true;
            options.simulateTouch = false;
            if (options.navigation === true) {
                options.navigation = {
                    nextEl: next,
                    prevEl: prev
                };
            }
            if (options.pagination === true) {
                options.pagination = {
                    el: paging,
                    clickable: true
                };
            }
            if (options.autoplay === true) {
                options.autoplay = {
                    delay: options.autoplayDelay
                };
            }
            
            pixSwiper['sw' + i] = new Swiper($(this)[0], options);
        
            if (options.slidesPerColumn > 1) {
                var max = 0;
                $.each(pixSwiper['sw' + i].slides, function () {
                    max = $(this).height() > max ? $(this).height() : max;
                });
        
                $slider.height(2 * max);
                
                $('.pix-promo-item:first-of-type()', container).height(max);
                $('.pix-promo-item:last-of-type()', container).height(max);
            }
        
            pixSwiper['sw' + i].on('transitionStart', function () {
                if(!$slider.hasClass('pix-buttons-always-show')){
                    $slider.addClass('disable-hover');
                }
            });
            pixSwiper['sw' + i].on('transitionEnd', function () {
                if($slider.hasClass('disable-hover')){
                    $slider.removeClass('disable-hover');
                }
            });
        
            pixSwiper['sw' + i].on('resize', function (slider) {
                if (slider.params.slidesPerColumn > 1) {
                    var max = 0;
                    $.each(slider.slides, function () {
                        max = $(this).height() > max ? $(this).height() : max;
                    });
                    
                    $slider.height(2 * max);
                    
                    $('.pix-promo-item:first-of-type()', container).height(max);
                    $('.pix-promo-item:last-of-type()', container).height(max);
                }
            });
        
        });
    }
    

    //-------------------------------------------

    
    $('.pix-slider-filter').on('click', '.item', function() {
        var $item = $(this),
            $filter = $(this).data('ajax-filter'),
            $slider_container = $(this).closest('.pix-slider'),
            $slider = $('.pix-slider-items', $slider_container),
            $index = $slider.data('index'),
            $options = $slider.data('swiper-options'),
            $style = $slider.data('style'),
            $cnt = $slider.data('cnt'),
            $cats = $slider.data('cats'),
            $height = $slider.css('height');
        
        $slider.html('<div class="pix-loading"></div>');
        $slider.css('height', $height);
        $slider.css('background-clip', 'content-box');
        $slider.css('background-color', '#fff');
        
        $item.addClass('active').siblings().removeClass('active');
        
        var data = {
            action: 'pixtheme_slider_filter',
            label: $filter,
            cnt: $cnt,
            cats: $cats,
            style: $style,
            slider_nonce: pix_js_vars.slider_nonce
        };
        
		$.post(pix_js_vars.url, data, function (response) {
            pixSwiper[$index].destroy(true, false);
            $slider.html(response.data);
            $slider.css('background-clip', '');
            $slider.css('background-color', '');
            pixSwiper[$index] = new Swiper($slider[0], $options);
            pixSwiper[$index].on('transitionStart', function () {
                $slider.addClass('disable-hover');
            });
            pixSwiper[$index].on('transitionEnd', function () {
                $slider.removeClass('disable-hover');
            });
            pixSwiper[$index].on('resize', function (slider) {
                if(slider.params.slidesPerColumn > 1 ) {
                    var max = 0;
                    $.each(slider.slides, function () {
                        max = $(this).height() > max ? $(this).height() : max;
                    });
                    $slider.height(2*max);
                    $('.pix-promo-item:first-of-type()', $slider_container).height(max);
                    $('.pix-promo-item:last-of-type()', $slider_container).height(max);
                }
            });
            pix_countdown();
        });
    });
    

    /* ============= Product Img Slider ============== */

	//img hover slider
	function productImgSlider() {
		var productSlider = $('.pix-product-slider');
		var fullStack = false;

		productSlider.each(function () {
			var hoverBox = $(this).find('.pix-product-slider-hover'),
			    hoverDots = $(this).find('.pix-product-slider-dots'),
			    countImg = $(this).find('.pix-product-slider-box > img').length;

			if (countImg <= 1) {} else if (countImg < 6) {
				for (var i = 0; i < countImg; i++) {

					hoverBox.append('<span></span>');

					if (i === 0) {
						hoverDots.append('<span class="active"></span>');
					} else {
						hoverDots.append('<span></span>');
					}
				}
			} else {
				for (var j = 0; j < 6; j++) {
					if (j === 5) {
						fullStack = true;
						break;
					}

					hoverBox.append('<span></span>');

					if (j === 0) {
						hoverDots.append('<span class="active"></span>');
					} else {
						hoverDots.append('<span class=""></span>');
					}
				}
			}
		});

		$('.pix-product-slider-hover > span').hover(function () {
			var imgBoxes = $(this).parent().siblings('.pix-product-slider-box'),
			    hoverDots = $(this).parent().siblings('.pix-product-slider-dots'),
			    index = $(this).index();

			imgBoxes.find('img').eq(index).addClass('active').siblings().removeClass('active');
			hoverDots.children().eq(index).addClass('active').siblings().removeClass('active');

			if (index === 4 && fullStack) {
				imgBoxes.addClass('pix-full-stack');
			}
		}, function () {
			var imgBoxes = $(this).parent('.pix-product-slider');
			var hoverDots = $(this).parents('.pix-product-box-img').find('.pix-product-dots-boxes');
            if($(this).parent().hasClass('pix-first-hover-off')){
                imgBoxes.find('img').eq(0).addClass('active').siblings().removeClass('active');
				hoverDots.children().eq(0).addClass('active').siblings().removeClass('active');
            }
			imgBoxes.removeClass('pix-full-stack');
		});

		if (w <= md) {
			$('.pix-product-slider > a').on('click', function (e) {
				e.preventDefault();
			});
		}
	}

	productImgSlider();
	/* =============================================== */

    function pix_wishlist_compare(){
        $('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a').each(function(index, el) {
            if( !$(this).hasClass('pix-tooltip-show') ){
                $(this).addClass('pix-tooltip-show');
                var tooltip = '<span class="pix-tooltip"><span class="pix-tooltip-inner"><span class="pix-tooltip-text">Add to Wishlist</span><span class="pix-tooltip-arrow"></span></span></span>';
                $(this).append(tooltip);
            }
            if($(this).parent().parent().hasClass('exists')){
                $('.pix-tooltip-text', this).text('Remove from Wishlist');
            } else {
                $('.pix-tooltip-text', this).text('Add to Wishlist');
            }
        });
    }

    pix_wishlist_compare();
    $( document ).ajaxComplete(function() {
        pix_wishlist_compare();
    });


    /* ================== Tooltipe =================== */
	$('[data-toggle="tooltip"]').tooltip({
		offsetPopper: 10
	});
	/* =============================================== */

    $(document).on('click', 'a.pix-compare-btn:not(.remove)', function (e) {
        e.preventDefault();

        var button = $(this),
            parent = $(this).parent(),
            badge = $('.pix-header .pix-compare .badge'),
            badge_m = $('.menu-mobile .pix-compare .badge'),
            cnt = parseInt(badge.text()),
            data = {
                action: 'yith-woocompare-add-product',
                id: button.data('product_id'),
                context: 'frontend'
            };

        button.html('<span class="pix-loading m"></span>');

        $.ajax({
            type: 'post',
            url: pix_js_vars.wcajaxurl.toString().replace( '%%endpoint%%', 'yith-woocompare-add-product' ),
            data: data,
            dataType: 'json',
            success: function(response){
                button.addClass('remove');
                button.html('<i class="pix-flaticon-statistics"></i>');
                var tooltip = '<span class="pix-tooltip"><span class="pix-tooltip-inner"><span class="pix-tooltip-text">Remove from Compare</span><span class="pix-tooltip-arrow"></span></span></span>';
                button.append(tooltip);
                badge.text(cnt+1);
                badge_m.text(cnt+1);
            }
        });
    });

    $(document).on('click', 'a.pix-compare-btn.remove', function (e) {
        e.preventDefault();

        var button = $(this),
            parent = $(this).parent(),
            badge = $('.pix-header .pix-compare .badge'),
            badge_m = $('.menu-mobile .pix-compare .badge'),
            cnt = parseInt(badge.text()),
            data = {
                action: 'yith-woocompare-remove-product',
                id: button.data('product_id'),
                context: 'frontend'
            };

        button.html('<span class="pix-loading m"></span>');

        $.ajax({
            type: 'post',
            url: pix_js_vars.wcajaxurl.toString().replace( '%%endpoint%%', 'yith-woocompare-remove-product' ),
            data: data,
            dataType: 'html',
            success: function(response){
                button.removeClass('remove');
                button.html('<i class="pix-flaticon-statistics"></i>');
                var tooltip = '<span class="pix-tooltip"><span class="pix-tooltip-inner"><span class="pix-tooltip-text">Compare</span><span class="pix-tooltip-arrow"></span></span></span>';
                button.append(tooltip);
                badge.text(cnt-1);
                badge_m.text(cnt-1);
            }
        });
    });


	function fullWidthSection() {

        var windowWidth = $(window).width();
        var widthContainer = $('.home-template > .container, .portfolio-section  > .container , .page-content  > .container').width() + 30 ;
        var widthContainerBoxed = $('.container-fluid.pix-container-boxed').width();
        
        var fullWidthMargin = windowWidth - widthContainer;
        var fullWidthMarginHalf = fullWidthMargin / 2;

        $('.wpb_column.pix-col-content-right, .pix-section-title.pix-col-content-right').css('padding-left', fullWidthMarginHalf+15);
        $('.wpb_column.pix-col-content-right, .pix-section-title.pix-col-content-right').css('padding-right', '15px');

        $('.wpb_column.pix-col-content-left, .pix-section-title.pix-col-content-left').css('padding-right', fullWidthMarginHalf+15);
        $('.wpb_column.pix-col-content-left, .pix-section-title.pix-col-content-left').css('padding-left', '15px');

        $('.wpb_column.pix-col-content-center, .pix-section-title.pix-col-content-center').css('padding-right', fullWidthMarginHalf/2);
        $('.wpb_column.pix-col-content-center, .pix-section-title.pix-col-content-center').css('padding-left', fullWidthMarginHalf/2);
        
        if (windowWidth <= sm) {
            var $swiper = $('[data-swiper-options]');
            $swiper.height('auto');
        }
        
        var innerWidth = $('body').innerWidth(),
            padding = 160;
        if (windowWidth >= lg) {
            padding = 80;
        }
        if (windowWidth >= xl) {
            padding = 120;
        }
        if (windowWidth >= 1440) {
            padding = 160;
        }
        $('.pix__secondMenu > .pix-section').width(innerWidth - padding);
        
    }
    
    $(window).on('load', function(){
        fullWidthSection();
        var $swiper = $('[data-swiper-options]');
        if ($swiper.length) {
            $swiper.each(function() {
                var options = $(this).data('swiper-options'),
                    sw_index = $(this).attr('data-index'),
                    container = $(this).parent().parent();
                
                pixSwiper[sw_index].update();
                
            });
        }
    });
    $(window).resize(function() {
       fullWidthSection();
    });


    $(document).ready(function() {
		$('.pix-video-popup').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	});
    
    
    $(document).ready(function() {
		$('.pix-popup-gallery').magnificPopup({
            delegate: 'a',
			type: 'image',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			gallery:{
                enabled:true
            }
		});
	});



    var pix_video = document.querySelectorAll( ".pix-video.embed" );

    for (var i = 0; i < pix_video.length; i++) {

        if(pix_video[i].dataset.vendor == 'youtube') {

            var source = "https://img.youtube.com/vi/" + pix_video[i].dataset.embed;

            pix_video[i].addEventListener("click", function () {

                var iframe = document.createElement("iframe");

                iframe.setAttribute("frameborder", "0");
                iframe.setAttribute("allowfullscreen", "");
                iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");

                this.innerHTML = "";
                this.appendChild(iframe);
            });
        } else if(pix_video[i].dataset.vendor == 'vimeo') {

            pix_video[i].addEventListener("click", function () {

                var iframe = document.createElement("iframe");

                iframe.setAttribute("frameborder", "0");
                iframe.setAttribute("allowfullscreen", "");
                iframe.setAttribute("src", "https://player.vimeo.com/video" + this.dataset.embed + "?autoplay=1&autopause=1&title=1&byline=1&portrait=1");

                this.innerHTML = "";
                this.appendChild(iframe);
            });
        }
    };






    /////////////////////////////////////
	//  Chars Start
	/////////////////////////////////////

	function CharsStart() {
		$('.chart').easyPieChart({
            barColor: false,
            trackColor: false,
            scaleColor: false,
            scaleLength: false,
            lineCap: false,
            lineWidth: false,
            size: false,
            animate: 7000,

            onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
            }
		});
	}

	$('.chart').each(function() {
        CharsStart();
    });


	$(document).ready(function() {
		// Test for placeholder support
		$.support.placeholder = (function(){
			var i = document.createElement('input');
			return 'placeholder' in i;
		})();

		// Hide labels by default if placeholders are supported
		if($.support.placeholder) {
			$('.form-label').each(function(){
				$(this).addClass('js-hide-label');
			});

			// Code for adding/removing classes here
			$('.form-group').find('input, textarea').on('keyup blur focus', function(e){

				// Cache our selectors
				var $this = $(this),
					$parent = $this.parent().find("label");

					switch(e.type) {
						case 'keyup': {
							 $parent.toggleClass('js-hide-label', $this.val() === '');
						} break;
						case 'blur': {
							if( $this.val() === '' ) {
						        $parent.addClass('js-hide-label');
							} else {
								$parent.removeClass('js-hide-label').addClass('js-unhighlight-label');
							}
						} break;
						case 'focus': {
							if( $this.val() !== '' ) {
								$parent.removeClass('js-unhighlight-label');
							}
						} break;
							default: break;
						}

			});
		}
	});



    function mobile_table_change($table, $table_index){
        $('tr', $table).each(function() {
            var $parent = $(this).parent().prop('tagName');
            $('th, td', $(this)).each(function( index, value ) {
                if( index == $table_index ){
                    $(this).removeClass('pix-hide-mobile');
                    if($parent == 'THEAD' || $parent == 'TFOOT'){
                        $(this).attr('colspan', '2');
                    }
                } else if( index > 0 ) {
                    $(this).addClass('pix-hide-mobile');
                }
            });
        });
    }

	$('.pix-mobile-table-select').on('change', function () {
	    var $table_index = $(this).val(),
            $table = $(this).parent().find('table');

        mobile_table_change($table, $table_index);
    });

    if(screen.width <= 575){
        var $table = $('.pix-compare-table .pix-price-compare-table'),
            $table_index = $('.pix-compare-table .pix-mobile-table-select').val();
        mobile_table_change($table, $table_index);
    }



	// WooCommerce

    $('.pix-categories-item-links button').on('click', function () {
        var $list = $(this).parent().find('ul.pix-more-list');
        if($(this).hasClass('opened')){
            $(this).removeClass('opened');
            $list.removeClass('opened');
            $('i', this).removeClass('fa-times').addClass('fa-ellipsis-h');
        } else {
            $(this).addClass('opened');
            $list.addClass('opened');
            $('i', this).removeClass('fa-ellipsis-h').addClass('fa-times');
        }
    });



    //// Cart

    function pix_ajax_cart (id, qnt) {
		var data = {
            action: 'pixtheme_cart_change',
            cart_id: id,
            qnt: qnt,
            cart_nonce: pix_js_vars.cart_nonce
        };

		show_ajax_loader('.pix-header-cart');

		$.post(pix_js_vars.url, data, function (response) {
            $('.pix-header-cart').html(response.data);
            if( typeof($('.pix-header-cart-products-inner ul').data('count')) === 'undefined' ){
                if( !$('#cart').hasClass('empty') ){
                    $('#cart').addClass('empty');
                }
            } else {
                $('#cart .pix-cart.badge').html($('.pix-header-cart-products-inner ul').data('count'));
            }
            hide_ajax_loader('.pix-header-cart');
        });
    }

    function show_ajax_loader(parent_class){
        $(parent_class+' .pix-ajax-loader').addClass('show');
    }

    function hide_ajax_loader(parent_class){
        $(parent_class+' .pix-ajax-loader').removeClass('show');
    }

    $(document).on('click', '.pix-header-cart .pix-cart-delete:not(.cancel)', function(e){
        e.preventDefault();
        
        var cart_id = $(this).data('cart-id');
        pix_ajax_cart(cart_id, 0);
    });

    $(document).on('change', '.pix-header-cart input', function(){
        var parent = $(this).parent(),
            apply = parent.find('.pix-cart-apply'),
            cancel = parent.find('.pix-cart-delete');

        if($(this).data('val') !== $(this).val()){
            apply.removeClass('hide');
            cancel.addClass('cancel');
        } else {
            apply.addClass('hide');
            cancel.removeClass('cancel');
        }
    });

    $(document).on('click', '.pix-header-cart .pix-cart-apply', function(e){
        e.preventDefault();
        
        var parent = $(this).parent(),
            cart_id = $(this).data('cart-id'),
            qnt = parent.find('input').val();

        pix_ajax_cart(cart_id, qnt);
    });

    $(document).on('click', '.pix-header-cart .pix-cart-delete.cancel', function(e){
        e.preventDefault();
        
        var parent = $(this).parent(),
            apply = parent.find('.pix-cart-apply'),
            input = parent.find('input');

        input.val(input.data('val'));
        apply.addClass('hide');
        $(this).removeClass('cancel');
    });



	// Responsive

	if(screen.width <= 575){
		$('div[class*="vc_custom_"]:has(div.pix-video)').css('padding', '0 !important');
	}


    //fixed footer
    function fixedFooter() {
        var footerHeight = $('.pix-footer').outerHeight();
        $('.pix-wrapper').css('margin-bottom', footerHeight);
    }
    $(window).on('load', function () {
        fixedFooter();

        $(window).on('resize', function () {
            fixedFooter();
        });

    });
    //------------------------------------------------


    //init wow
    new WOW().init();
    //------------------------------------------------
    
	
    $('.product-categories li.cat-parent > i').on('click', function(){
        var $li = $(this).parent(),
            $ul = $(this).parent().parent();
        if( !$li.hasClass('open') && $ul.hasClass('product-categories') ){
            $('.product-categories > li.open').removeClass('open').children('ul').toggle(200);
        }
        if( !$li.hasClass('open') && $ul.hasClass('children') ){
            $ul.children('.open').removeClass('open').children('ul').toggle(200);
        }
        $li.toggleClass('open').children('ul').toggle(200);
    });

});
