( function($) {

        'use strict';

        var w = $( window ).width();

        var LamiraSwiperHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-swiper-widget' );

            $element.LamiraSwiper();
        };

        var LamiraSwiperHcardsHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-swiper-widget' );

            $element.LamiraSwiper();
            $element.find( '.lastchanceProducts' ).on( 'breakpoint', function( event, swiper, breakpoint ) {
                $( this ).find( '.productCard2__slider' ).each( function () {
                    var imgBox = $( this ).children( '.productCard2__images' ),
                        hoverBox = imgBox.children( '.productCard2__hover' ),
                        hoverDots = imgBox.next( '.productCard2__dots' ),
                        countImg = imgBox.children( 'span' ).length;

                    hoverBox.children().on( 'touch touchstart mouseover', function () {
                        var index = $( this ).index();
                        imgBox.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                        hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    });

                    hoverDots.children().on( 'touch touchstart mouseover', function () {
                        var index = $( this ).index();
                        imgBox.children().eq( index).addClass( 'active' ).siblings().removeClass( 'active' );
                        hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    });

                    if ( w <= 768 ) {
                        imgBox.on( 'click touch touchstart', function( e ) {
                            e.preventDefault();
                        });
                    }
                });
            });
        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-logos-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-product-categories-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-posts-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-extended-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-vcard-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-hcard-carousel.default', LamiraSwiperHcardsHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-double-block-carousel.default', LamiraSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-team-double-block-carousel.default', LamiraSwiperHandler );
        } );

} )( jQuery );
