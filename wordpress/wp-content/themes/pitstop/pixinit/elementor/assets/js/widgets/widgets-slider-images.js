( function( $ ) {

        'use strict';

        var w = $( window ).width();

        var LamiraSliderImagesHandler = function( $scope, $ ) {
            var $element = $scope.find( '.productCard2__slider' );

            $element.each( function() {
                var imgBox = $( this ).children( '.productCard2__images' ),
                    hoverBox = imgBox.children( '.productCard2__hover' ),
                    hoverDots = imgBox.next( '.productCard2__dots' ),
                    countImg = imgBox.children( 'span' ).length;

                if ( countImg <= 1 ) {
                } else if ( countImg < 6 ) {
                    for( var i = 0; i < countImg; i++ ) {

                        hoverBox.append('<i></i>');

                        if ( i === 0 ) {
                            hoverDots.append( '<span class="active"></span>' );
                        } else {
                            hoverDots.append( '<span></span>' );
                        }
                    }
                } else {
                    for( var j = 0; j < 6; j++ ) {
                        if ( j === 5 ) {
                            break;
                        }

                        hoverBox.append( '<i></i>' );

                        if ( j === 0 ) {
                            hoverDots.append( '<span class="active"></span>' );
                        } else {
                            hoverDots.append( '<span class=""></span>' );
                        }
                    }
                }

                hoverBox.children().on( 'touch touchstart mouseover', function () {
                    var index = $( this ).index();
                    imgBox.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                });

                hoverDots.children().on( 'touch touchstart mouseover', function () {
                    var index = $(this).index();
                    imgBox.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                });

                if ( w <= 768 ) {
                    imgBox.on( 'click touch touchstart', function( e ) {
                        e.preventDefault();
                    });
                }
            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-vcard-carousel.default', LamiraSliderImagesHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-hcard-carousel.default', LamiraSliderImagesHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-double-block-carousel.default', LamiraSliderImagesHandler );
        } );
    }

)( jQuery );
