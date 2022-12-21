( function( $ ) {

        'use strict';

        var LamiraProductsFilterHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-extended-product-container' ),
                height = $element.height();

            $element.each( function() {
                var container = $(this),
                    productsContainer = container.find( '.topproducts' ),
                    productsContainerInner = container.find( '.swiper-wrapper' ),
                    productCategoriesLinks = container.find( '.pix-product-categories-container' ),
                    productFilterLinks = container.find( '.pix-product-filter-container' );

                container.on( 'click', '.pix-product-categories-container a', function( e )  {
                    e.preventDefault();

                    var currentQuery = productsContainer.attr( 'data-query' );
                    var currentTermId = $( this ).attr( 'data-term-id' );
                    var productType = productFilterLinks.find( '.active' ).attr( 'data-product-type' );
                    var currentTaxonomy = productsContainer.attr( 'data-taxonomy' );

                    $( this ).parent( 'li' ).siblings().children( 'a' ).removeClass('active');
                    $( this ).addClass( 'active' );

                    var data = {
                        action: 'add_products',
                        query: currentQuery,
                        termid: currentTermId,
                        taxonomy: currentTaxonomy,
                        type: productType
                    };

                    $.post( lamiraAjax.url, data, function( response ) {
                        container.css( 'height', height );
                        productsContainer.addClass( 'loading' );
                        productsContainerInner.html( response );
                        container.imagesLoaded( function() {
                            container.LamiraSwiper();
                        });
                        lamiraWoo.initQuickViewButton();
                        setTimeout( function() {
                            productsContainer.removeClass( 'loading' );
                            container.removeAttr( 'style' );
                        }, 1000 );
                    });
                });

                container.on( 'click', '.pix-product-filter-container a', function( e )  {
                    e.preventDefault();

                    var currentQuery = productsContainer.attr( 'data-query' );
                    var currentTermId = productCategoriesLinks.find( '.active' ).attr( 'data-term-id' );
                    var productType = $( this ).attr( 'data-product-type' );
                    var currentTaxonomy = productsContainer.attr( 'data-taxonomy' );

                    $( this ).siblings().removeClass('active');
                    $( this ).addClass( 'active' );

                    var data = {
                        action: 'add_products',
                        query: currentQuery,
                        termid: currentTermId,
                        taxonomy: currentTaxonomy,
                        type: productType
                    };

                    $.post( lamiraAjax.url, data, function( response ) {
                        container.css( 'height', height );
                        productsContainer.addClass( 'loading' );
                        productsContainerInner.html( response );
                        container.imagesLoaded( function() {
                            container.LamiraSwiper();
                        });
                        lamiraWoo.initQuickViewButton();
                        setTimeout( function() {
                            productsContainer.removeClass( 'loading' );
                            container.removeAttr( 'style' );
                        }, 1000 );
                    });
                });

            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/lamira-products-extended-carousel.default', LamiraProductsFilterHandler );
        } );
    }

)( jQuery );
