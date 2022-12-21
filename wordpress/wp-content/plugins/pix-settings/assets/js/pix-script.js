jQuery(document).ready(function($){


    // $('.pix-mega-menu > .row .pix-masonry-catalog').masonry({
    //   // options
    //     percentPosition: true,
    //     itemSelector: 'div',
    //     columnWidth: 25
    // });
    //
    // $('.pix-masonry-catalog p a').on('click', function () {
    //     var $p_parent = $(this).parent(),
    //         $container = $(this).parent().parent(),
    //         $a_hide = $('a.hide', $p_parent);
    //
    //     // $(this).addClass('hide');
    //     // $a_hide.removeClass('hide');
    //     $('a', $p_parent).toggleClass('hide');
    //     if($container.hasClass('pix-more')){
    //         $container.removeClass('pix-more');
    //     } else {
    //         $container.addClass('pix-more');
    //     }
    // });



    // init vanillaSelectBox
    function pixVanillaSelectBox() {
        var pixMultiSelectBox = $('select.pix-multi-select'),
            pixMultiSelect = [];

        pixMultiSelectBox.each(function () {
            var id = $(this).attr('id'),
                placeholder = $(this).data('placeholder');

            pixMultiSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                keepInlineStyles: false,
                search: false
            });
        });
    }
    pixVanillaSelectBox();

    function getSelectValues(id) {
        let result = [];
        let collection = document.querySelectorAll("#" + id + " option");
        collection.forEach(function (x) {
            if (x.selected) {
                result.push(x.value);
            }
        });
        return result;
    }

    function getSelectTotal(id) {
        var total = 0;
        let collection = document.querySelectorAll("#" + id + " option");
        collection.forEach(function (x) {
            if (x.selected) {
                total = total + parseFloat(x.dataset.price);
            }
        });
        return total;
    }

    function pix_calc_get_total($parent){
        var $total = 0,
            $out = '';
        $('.pix-calc-value', $parent).each(function() {
            if($(this).is('.pix-multi-select')){
                var str = (getSelectValues($(this).attr('id'))).join(','),
                    sum = getSelectTotal($(this).attr('id'));
                // console.log(str);
                // console.log(sum);
                $total = $total + parseFloat(sum);
                $out = $out + $(this).attr('data-title') + ': ' + str + ' - ' + sum + "\n";
            } else if($(this).is('select')){
                $total = $total + parseFloat($(this).find(':selected').attr('data-price'));
                $out = $out + $(this).attr('data-title') + ': ' + $(this).val() + ' - ' + $(this).find(':selected').attr('data-price') + "\n";
            } else {
                if($(this).prop('checked')){
                    $total = $total + parseFloat($(this).attr('data-price'));
                    $out = $out + $(this).attr('data-title') + ': ' + $(this).val() + ' - ' + $(this).attr('data-price') + "\n";
                }
            }
        });

        $('.pix-calc-total-price span', $parent).html($total);

        if($('.pix-form-container', $parent).length){
            $out = $out + $total;
            $('.pix-form-container .pix-calculator-data', $parent).html($out);
        }
    }

    $('.pix-calc-value').on('change', function () {
        pix_calc_get_total($(this).closest('.pix-calculator'));
    });

    $('.pix-calc-total-btn a').on('click', function () {
        if ( $( '.pix-form-container' ).first().is( ":hidden" ) ) {
            $( '.pix-form-container' ).slideDown( 700 );
        } else {
            $( '.pix-form-container' ).slideUp( 700 );
        }
    });

    $('.pix-reset a').on('click', function () {
        var $parent = $(this).closest('.pix-calculator-fields'),
            $fields = $(this).closest('.pix-calculator-field');

        $('.pix-calc-value', $fields).each(function() {
            if($(this).is('select')){
                $(this).prop('selectedIndex', 0);
            } else {
                $(this).prop('checked', false);
            }
        });

        pix_calc_get_total($parent);
    });


    $('img.pix-svg-fill, .pix-theme-tone-dark .pix-single-info .pix-single-list ul li span img').each(function(){
        var $img = $(this),
            imgID = $img.attr('id'),
            imgClass = $img.attr('class'),
            imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Check if the viewport is set, else we gonna set it if we can.
            if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });
    
    $('.pix-content-header-controls > a').on('click', function(){
        if( !$(this).hasClass('active') ){
            $('.pix-content-header-controls > a').removeClass('active');
            $(this).addClass('active');
            if( $(this).hasClass('pix-tiles-mode') ){
                $('.pix-products').removeClass('pix-listing');
            } else if( $(this).hasClass('pix-listing-mode') ) {
                $('.pix-products').addClass('pix-listing');
            }
        }
    });


});