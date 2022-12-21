( function( $ ) {

        'use strict';

        var LamiraCountdownHandler = function( $scope, $ ) {
            var $element = $scope.find( '[data-countdown]' );

            $element.each( function() {
                var $this = $( this ), finalDate = $( this ).data( 'countdown' );

                $this.countdown( finalDate, function( event ) {
                    $this.html( event.strftime( '' +
                        '<div id="days"><span class="time">%D</span><span class="label">days</span></div>' +
                        '<div id="hours"><span class="time">%H</span><span class="label">hours</span></div>' +
                        '<div id="minutes"><span class="time">%M</span><span class="label">minutes</span></div>' +
                        '<div id="seconds"><span class="time">%S</span><span class="label">seconds</span></div>')) ;
                });
            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-vcard-carousel.default', LamiraCountdownHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-hcard-carousel.default', LamiraCountdownHandler );
        } );
    }

)( jQuery );
