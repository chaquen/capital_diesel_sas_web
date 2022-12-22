jQuery(function($) {

    'use strict';

    var filter_select = {};
    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 0.5 second for example
    var $search = $('.pix__search .form-control');

    //on keyup, start the countdown
    $search.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(pix_ajax_search, doneTypingInterval);
    });

    //on keydown, clear the countdown
    $search.on('keydown', function () {
        showAjaxSearchLoader();
        clearTimeout(typingTimer);
    });

    //user is "finished typing," do something
    function pix_ajax_search () {
		var data = {
            action: 'pix_search_ajax',
            search: $search.val(),
            nonce: pixAjax.nonce
        },
            $scrollbar = $('.pix__searchAjax[data-scrollbar]');

		$scrollbar.customScrollbar({'vScroll': false});

		$.post(pixAjax.url, data, function (response) {
            //console.log('AJAX response : ',response.data);
            $('.pix__searchAjax_inner').html(response.data);
            $scrollbar.customScrollbar({'vScroll': true});
            $scrollbar.customScrollbar('resize', true);
            hideAjaxSearchLoader();
        });
    }

    /* ============== Search ajax popup ============== */
	$('.pix__search .form-control').on('change input focus', function (e) {
	    if($(this).val() !== ''){
            $(this).next('.pix__searchAjax').addClass('show');
        }
	});

	$('.pix__search .form-control').on('blur', function (e) {
	    var $result = $(this).next('.pix__searchAjax');

        if (!$result.is(':hover')) {
            $result.removeClass('show');
        }
	});

	$('.pix__searchAjax').mouseenter(function() {
	    //
    })
    .mouseleave(function() {
        var $result = $(this);
        if(!$('.pix__search .form-control').is(':focus')) {
            $result.removeClass('show');
        }
    });
	/* =============================================== */

    function showAjaxSearchLoader(){
        $('.pix-ajax-loader').addClass('show');
    }

    function hideAjaxSearchLoader(){
        $('.pix-ajax-loader').removeClass('show');
    }




    /**
	 * @param state - (object) current object { name_of_param : value }
	 * @param title - (string) title
	 */
	function pix_change_url(state, title, href, step){
		title = title || '';
		href = href || false;
		step = step || '';
		var $category = $('#pix-product-category').val(),
            $url = window.location.href,
            currentState = {},
            qstring = '',
            url_str = '';
		
		if((history.state == null || history.state == '') && $url.includes('?')){
            var url_query = $url.split('?');
            $url = url_query[0];
            var $query_str = '?' + url_query[1];
            var query_args = url_query[1].split('&');
            $.each( query_args, function( key, val ) {
                var field_val = val.split('=');
                currentState[field_val[0]] = field_val[1];
            });
            history.pushState(currentState, title, $query_str);
        }

		var data = {
            action: 'pix_filter',
            href: href,
            url: $url,
            category: $category,
            nonce: pixAjax.nonce
        };
        
		//console.log(data.url);
        
		if( !href ){
		    currentState = history.state == null ? {} : history.state;
        } else {
		    qstring = $('.pix-filter-box .pix-button').data('href');
		    currentState = qstring === '' ? {} : JSON.parse(qstring);
        }
		
        $.extend( currentState, state );
        if($('#sort-purpose').val() != ''){
            var purpose = { 'purpose' : $('#sort-purpose').val() }
            $.extend( currentState, purpose );
        }
        $.each( currentState, function( key, val ) {
            if(val !== '') {
                url_str = url_str + "&" + key + "=" + val;
            }
		});
        url_str = url_str.replace('&','?');

        if( !href ){
            history.pushState(currentState, title, url_str);
        }

        $.extend( data, currentState );

        if( href ) {
            var page = $('.pix-filter-box .pix-button').data('page');
            $('.pix-filter-box .pix-button').data('href', JSON.stringify(currentState));
            $('.pix-filter-box .pix-button').attr('href', page + url_str);
        }

		return data;
	}

	function pix_change_filter_select(){

	    if ( $('.pix-filter-select-value').length ) {

            filter_select = jQuery.parseJSON($('.pix-filter-select-value').val());

            var filter_str = '';
            $.each( filter_select, function( key, val ) {
                filter_str = filter_str + '<span data-key="' + key + '">' + val.title + ': ' + val.value + '<a href="#"></a></span>';
            });

            $('.pix-filter-selected').html(filter_str);

        } else {
	        return false;
        }
    }
    pix_change_filter_select();


	$(document).on('click', '.pix-filter-selected a', function (e) {
        e.preventDefault();
        //showAjaxLoader();

        var parent = $(this).parent();

        $('.pix-filter[data-field="'+parent.data('key')+'"]').prop( "checked", false );
        $('.pix-filter[data-field="'+parent.data('key')+'"]').change();

        parent.remove();
        //console.log(data);

    });


	function goToByScroll(id){
	    $('html,body').animate({
	        scrollTop: $('#pix-sorting').offset().top - 110
	    }, 700);
	}

	function showAjaxLoader(){
		//goToByScroll();
		$('.pix-ajax-loader').addClass('ajax-loading');
	}

	function hideAjaxLoader(){
		// $('.pix-ajax-loader').removeClass('ajax-loading');
		// pageClick();
		$('#pix-filter-content + .woocommerce-pagination').remove();
	}
 
	function getSelectValue(id) {
        return document.getElementById(id).value;
    }
	
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
    
    // init vanillaSelectBox
    function pixVanillaSelectBox(pixMultiSelect, pixSelect) {
        var pixMultiSelectBox = $('.pix-filter-multi-select select'),
            pixSelectBox = $('.pix-filter-select select');
        //console.log();
        pixMultiSelectBox.each(function () {
            var id = $(this).attr('id'),
                placeholder = $(this).data('placeholder'),
                disabled = $(this).prop('disabled');

            pixMultiSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
            
            if(disabled) {
                pixMultiSelect[id].disable();
                pixMultiSelect[id].empty();
            }
        });

        pixSelectBox.each(function () {
            var id = $(this).attr('id'),
                placeholder = $(this).data('placeholder'),
                disabled = $(this).prop('disabled');

            pixSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });

            if(id === 'pix-model' || id === 'pix-restyle'){
                var val_str = (getSelectValues(id)).join(',');
                if( val_str === '' ) {
                    pixSelect[id].disable();
                }
            } else if(disabled) {
                pixSelect[id].disable();
                pixSelect[id].empty();
            }
        });

    }
    
    
    // init vanillaSelectBox
    var pixModelS = $('#pix-model'),
        pixRestyleS = $('#pix-restyle'),
        pixVersionS = $('#pix-version'),
        pixModel = '',
        pixRestyle = '',
        pixVersion = '',
        phModel = $('#pix-model').data('placeholder'),
        phRestyle = $('#pix-restyle').data('placeholder'),
        phVersion = $('#pix-version').data('placeholder'),
        pixMultiSelect = [],
        pixSelect = [];
	
	pixVanillaSelectBox(pixMultiSelect, pixSelect);
    
    function pixVanillaCarSelectBox() {
        
        if (pixModelS.length > 0) {
            pixModel = new vanillaSelectBox('#pix-model', {
                placeHolder: phModel,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
            pixModel.disable();
        }
    
        if (pixRestyleS.length > 0){
            pixRestyle = new vanillaSelectBox('#pix-restyle', {
                placeHolder: phRestyle,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
            pixRestyle.disable();
        }
    
        if (pixVersionS.length > 0){
            pixVersion = new vanillaSelectBox('#pix-version', {
                placeHolder: phVersion,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
            pixVersion.disable();
        }
        
    }
    pixVanillaCarSelectBox();
    
    function pixVanillaFillSelectBox(id, content) {
        
        var type = $('#' + id).data('type'),
            placeholder = $('#' + id).data('placeholder'),
            order = $('#' + id).data('order'),
            container = $('#' + id).closest('.pix__filterControls'),
            fields_arr = $('.pix-filter[data-order]', container);
        
        if(type === 'multi-select'){
            pixMultiSelect[id].destroy();
            $('#' + id).html(content);
            pixMultiSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
        } else if(type === 'select') {
            pixSelect[id].destroy();
            $('#' + id).html(content);
            pixSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                keepInlineStyles: false,
                search: pixAjax.select_search
            });
        }
        
        $.each( fields_arr, function( key, val ) {
                // console.log(val.id);
                // console.log(val.dataset.order);
            if( val.dataset.order > order ){
                var placeholder = val.dataset.placeholder;
                if( val.dataset.type === 'select' ){
                    pixSelect[val.id].destroy();
                    pixSelect[val.id] = new vanillaSelectBox('#' + val.id, {
                        placeHolder: placeholder,
                        keepInlineStyles: false,
                        search: pixAjax.select_search
                    });
                    pixSelect[val.id].disable();
                } else if ( val.dataset.type === 'multi-select' ){
                    pixMultiSelect[val.id].destroy();
                    pixMultiSelect[val.id] = new vanillaSelectBox('#' + val.id, {
                        placeHolder: placeholder,
                        keepInlineStyles: false,
                        search: pixAjax.select_search
                    });
                    pixMultiSelect[val.id].disable();
                } else {
                    val.innerHTML = '';
                    val.disabled = true;
                }
            }
        });
    }
    
    function pix_step_filter_reset(changed_field){

	    if ( changed_field.data('step') === 'on' ) {
         
	        var container = changed_field.closest('.pix__filterControls'),
                order = changed_field.data('order'),
                fields_arr = $('.pix-filter[data-order]', container),
                args = {};

            $.each( fields_arr, function( key, val ) {
                if( val.dataset.order > order ){
                    args[val.dataset.field] = '';
                    pix_change_url(args, 'filter', true);
                }
            });

        } else {
	        return false;
        }
    }
    

    $('#ajax-make').on( 'change', function (e) {
        e.preventDefault();
        
        pix_step_filter_reset($(this));
        
        var inc = 1;
        if (pixModelS.length > 0) {
            inc = 2;
        }
        if (pixModelS.length > 0 && pixRestyleS.length > 0) {
            inc = 3;
        }
        if (pixModelS.length > 0 && pixRestyleS.length > 0 && pixVersionS.length > 0) {
            inc = 4;
        }
        
        var make_val = $(this).val(),
            args = {},
            href = $(this).hasClass('pix-count'),
            container = $(this).closest('.pix-filter-box'),
            order = $(this).data('order'),
            next_id = $('.pix-filter[data-order="'+(order+inc)+'"]', container).attr('id'),
            next_type = $('.pix-filter[data-order="'+(order+inc)+'"]', container).data('type'),
            step = $(this).data('step'),
            response_model = '';
        args.make = '';
        pix_change_url(args, 'make', href);
        args.model = '';
        pix_change_url(args, 'model', href);
        args.restyle = '';
        pix_change_url(args, 'restyle', href);
        args.version = '';
        pix_change_url(args, 'version', href);
		var data = {
            action: 'pix_filter',
            nonce: pixAjax.nonce,
            make_model: make_val
        };
        //console.log(href);
        
        if (pixModelS.length > 0) {
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('#pix-model').html(response.data);
        
                pixModel = new vanillaSelectBox('#pix-model', {
                    placeHolder: phModel,
                    keepInlineStyles: false,
                    search: pixAjax.select_search
                });
        
                if (pixRestyle.length > 0) {
                    pixRestyle.disable();
                    pixRestyle.empty();
                }
        
                if (pixVersion.length > 0) {
                    pixVersion.disable();
                    pixVersion.empty();
                }
        
                response_model = response.data;
        
            });
        }

        //showAjaxLoader();
        if(make_val.length > 0) {
            args.make = make_val;
        } else {
            args.make = '';
        }
        data = pix_change_url(args, 'make', href);
        data.next_id = next_id;
        data.next_type = next_type;
        data.step_order = order;
        data.step = step;
        
		//console.log('AJAX data : ',data);
		if(href){
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                if(typeof response.data.count !== 'undefined'){
                    $('.pix-filter-box .pix-button span').text(response.data.count);
                    if(step === 'on' && response_model === '' ){
                        pixVanillaFillSelectBox(next_id, response.data.content);
                    }
                } else {
                    $('.pix-filter-box .pix-button span').text(response.data);
                }
            });
        } else {
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('#pix-filter-content').html(response.data);
                createImgSlider();
                hideAjaxLoader();
            });
        }
    });
	
	$('#pix-model').on( 'change', function (e) {
        e.preventDefault();
        
        pix_step_filter_reset($(this));
        
        var inc = 1;
        if (pixRestyleS.length > 0) {
            inc = 2;
        }
        if (pixVersionS.length > 0) {
            inc = 3;
        }
        
        var make_val = $(this).val(),
            args = {},
            href = $(this).hasClass('pix-count'),
            container = $(this).closest('.pix-filter-box'),
            order = $(this).data('order'),
            next_id = $('.pix-filter[data-order="'+(order+inc)+'"]', container).attr('id'),
            next_type = $('.pix-filter[data-order="'+(order+inc)+'"]', container).data('type'),
            step = $(this).data('step');
        args.model = '';
        pix_change_url(args, 'model', href);
        args.restyle = '';
        pix_change_url(args, 'restyle', href);
        args.version = '';
        pix_change_url(args, 'version', href);
		var data = {
            action: 'pix_filter',
            nonce: pixAjax.nonce,
            model_restyle: make_val
        };
        //console.log(make_val);
        $.get( pixAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            if(response.data !== '') {
                $('#pix-restyle').html(response.data);
    
                pixRestyle = new vanillaSelectBox('#pix-restyle', {
                    placeHolder: phRestyle,
                    keepInlineStyles: false,
                    search: pixAjax.select_search
                });
            
                if (pixVersionS.length > 0) {
                    pixVersion.disable();
                    pixVersion.empty();
                }
                
            }
        });

        //showAjaxLoader();
        if(make_val.length > 0) {
            args.model = make_val;
        } else {
            args.model = '';
        }
        data = pix_change_url(args, 'model', href);
        data.next_id = next_id;
        data.next_type = next_type;
        data.step_order = order;
        data.step = step;
        
		//console.log('AJAX data : ',data);
		if(href){
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                if(typeof response.data.count !== 'undefined'){
                    $('.pix-filter-box .pix-button span').text(response.data.count);
                    if(step === 'on' && response.data.count > 0 ){
                        pixVanillaFillSelectBox(next_id, response.data.content);
                    }
                } else if ( $.isNumeric( response.data ) ){
                    $('.pix-filter-box .pix-button span').text(response.data);
                } else if( response.data.includes("http") ) {
                    $('.pix-filter-box .pix-button span').text('1');
                    $('.pix-filter-box .pix-button').attr('href', response.data);
                }
            });
        } else {
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('#pix-filter-content').html(response.data);
                createImgSlider();
                hideAjaxLoader();
            });
        }
    });
	
	$('#pix-restyle').on( 'change', function (e) {
        e.preventDefault();
        
        pix_step_filter_reset($(this));
        
        var inc = 1;
        if (pixVersionS.length > 0) {
            inc = 2;
        }
        
        var make_val = $(this).val(),
            args = {},
            href = $(this).hasClass('pix-count'),
            container = $(this).closest('.pix-filter-box'),
            order = $(this).data('order'),
            next_id = $('.pix-filter[data-order="'+(order+inc)+'"]', container).attr('id'),
            next_type = $('.pix-filter[data-order="'+(order+inc)+'"]', container).data('type'),
            step = $(this).data('step');
        args.restyle = '';
        pix_change_url(args, 'restyle', href);
        args.version = '';
        pix_change_url(args, 'version', href);
		var data = {
            action: 'pix_filter',
            nonce: pixAjax.nonce,
            restyle_version: make_val
        };
        //console.log(make_val);
        $.get( pixAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            if(response.data !== '') {
                $('#pix-restyle').html(response.data);
    
                pixVersion = new vanillaSelectBox('#pix-version', {
                    placeHolder: phVersion,
                    keepInlineStyles: false,
                    search: pixAjax.select_search
                });
            }
        });

        //showAjaxLoader();
        if(make_val.length > 0) {
            args.restyle = make_val;
        } else {
            args.restyle = '';
        }
        data = pix_change_url(args, 'restyle', href);
        data.next_id = next_id;
        data.next_type = next_type;
        data.step_order = order;
        data.step = step;
        
		//console.log('AJAX data : ',data);
		if(href){
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                if(typeof response.data.count !== 'undefined'){
                    $('.pix-filter-box .pix-button span').text(response.data.count);
                    if(step === 'on' && response.data.count > 0 ){
                        pixVanillaFillSelectBox(next_id, response.data.content);
                    }
                } else if ( $.isNumeric( response.data ) ){
                    $('.pix-filter-box .pix-button span').text(response.data);
                } else if( response.data.includes("http") ) {
                    $('.pix-filter-box .pix-button span').text('1');
                    $('.pix-filter-box .pix-button').attr('href', response.data);
                }
            });
        } else {
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('#pix-filter-content').html(response.data);
                createImgSlider();
                hideAjaxLoader();
            });
        }
    });

	$(".pix-filter:not(#pix-make):not(#pix-model):not(#pix-restyle)").on( 'change', function (e) {
        //showAjaxLoader();
        e.preventDefault();
        
        pix_step_filter_reset($(this));
        
	    var args = {},
            args_str = '',
            title = $(this).data('title'),
            type = $(this).data('type'), // check - checkbox, number - input with int, text - input with string, select - select
	        field = $(this).data('field'),
	        href = $(this).hasClass('pix-count'),
            container = $(this).closest('.pix-filter-box'),
            order = $(this).data('order'),
            next_id = $('.pix-filter[data-order="'+(order+1)+'"]', container).attr('id'),
            next_type = $('.pix-filter[data-order="'+(order+1)+'"]', container).data('type'),
            step = $(this).data('step');
		//console.log('type : ',type);
		//console.log(href);
        if(type === 'check'){
			$("[name^='pa_"+field+"']").each(function(key,val) {
				if( $(this).prop( "checked" ) ){
					args_str = args_str + ',' + $(this).val();
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			} else{
                args[field] = '';
            }
				
        }
        if(type === 'number'){
            var pair_input = $(this).siblings('.pix-filter');
            if(pair_input.hasClass('pix-min')){
                args_str = pair_input.val() + ',' + $(this).val();
            } else if(pair_input.hasClass('pix-max')){
                args_str = $(this).val() + ',' + pair_input.val();
            } else {
                args_str = $(this).val();
            }
            //console.log(args_str);
			if(args_str.length > 0) {
				args[field] = args_str;
			} else {
                args[field] = '';
            }
        }
        if(type === 'select'){
	        args_str = getSelectValue($(this).attr('id'));
	        //console.log(args_str);
			if(args_str.length > 0) {
				args[field] = args_str;
			} else {
				if(field === 'model' || field === 'restyle'){
                    args_str = getSelectValue($(this).attr('id'));
                    args[field] = args_str;
				} else {
                    args[field] = '';
                }
            }
        }
        if(type === 'multi-select'){
	        args_str = (getSelectValues($(this).attr('id'))).join(',');
	        //console.log(args_str);
			if(args_str.length > 0) {
				args[field] = args_str;
			} else {
			    args[field] = '';
            }
        }
        
		//console.log('args data : ',args);
        var data = pix_change_url(args, 'filter', href);

        data.next_id = next_id;
        data.next_type = next_type;
        data.step_order = order;
        data.step = step;
        
		//console.log('AJAX data : ',data);
        if(href){
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                if(typeof response.data.count !== 'undefined'){
                    $('.pix-filter-box .pix-button span').text(response.data.count);
                    if(step === 'on' && response.data.count > 0 ){
                        pixVanillaFillSelectBox(next_id, response.data.content);
                    }
                } else {
                    $('.pix-filter-box .pix-button span').text(response.data);
                }
            });
        } else {
            $.get(pixAjax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('#pix-filter-content').html(response.data);
                createImgSlider();
                hideAjaxLoader();
            });
        }

    });

	$( '.pix-filter-segmented-button label' ).on( 'click', function(e) {
        var fid = $(this).attr('for');
        if($('#'+fid).prop('checked')){
            e.preventDefault();
            $('#'+fid).prop('checked', false).change();
        }
    });

    $(document).on('click', '.pix-pagination li a', function (e) {
        e.preventDefault();
        //showAjaxLoader();

        var state = {'paged': $(this).data('page')}
        var data = pix_change_url(state, 'paged');
        //console.log(data);

        $.get(pixAjax.url, data, function (response) {
            //console.log('AJAX response : ',response.data);
            $('#pixcars-listing').html(response.data);
            createImgSlider();
            hideAjaxLoader();
        });
    });

    // $('#pix-reset-button').on('click', function (e) {
    //     e.preventDefault();
	// 	window.location.href = $(this).data('href');
    // });



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
                    //console.dir(data);
                    input_minVal.val(data.from);
                    input_maxVal.val(data.to);
                    input_minVal.change();
                }
            });

        });


    }
    pixSliderRange();
    //-------------------------------------------




    //img hover slider
    function createImgSlider() {
        var productBox = $('.pix-product-box');
        var fullStack = false;

        productBox.each(function () {
            var hoverBoxes = $(this).find('.pix-product-hover-boxes');
            var hoverDots = $(this).find('.pix-product-dots-boxes');

            var countImg = $(this).find('.pix-product-show-boxes img').length;

            if(countImg <= 1){

            }else if(countImg < 6){
                for(var i = 0; i < countImg;i++){
                    hoverBoxes.append('<div class="pix-hover-box"></div>');

                    if(i === 0){
                        hoverDots.append('<div class="pix-dot-box pix-active"></div>');
                    }else{
                        hoverDots.append('<div class="pix-dot-box"></div>');
                    }
                }
            }else{
                for(var j = 0; j < 6;j++){
                    if(j === 5){
                        fullStack = true;
                        break;
                    }

                    hoverBoxes.append('<div class="pix-hover-box"></div>');

                    if(j === 0){
                        hoverDots.append('<div class="pix-dot-box pix-active"></div>');
                    }else{
                        hoverDots.append('<div class="pix-dot-box"></div>');
                    }
                }
            }
        });


        $('.pix-hover-box').hover(function () {
            var imgBoxes = $(this).parents('.pix-product-box-img').find('.pix-product-show-boxes');
            var hoverDots = $(this).parents('.pix-product-box-img').find('.pix-product-dots-boxes');

            var index = $(this).index();
            imgBoxes.find('img').css('opacity','0').css('visibility','hidden');
            imgBoxes.find('img').eq(index).css('opacity','1').css('visibility','visible');
            hoverDots.find('.pix-dot-box').removeClass('pix-active');
            hoverDots.find('.pix-dot-box').eq(index).addClass('pix-active');
            if(index === 4 && fullStack){
                imgBoxes.addClass('pix-full-stack');
            }
        }, function () {
            var imgBoxes = $(this).parents('.pix-product-box-img').find('.pix-product-show-boxes');
            imgBoxes.removeClass('pix-full-stack');
        })

        if (screen.width <= '768'){
            $('.pix-product-box-img a').on( 'click', function(e){
                e.preventDefault();
            });
        }
    }
    createImgSlider();
    //-------------------------------------------



    /* ================= Product popup =============== */

    $(document).on('click', '.pix__quickView', function () {

        var $productId = $(this).data('product-id');

        $.fancybox.open({
            src: pixAjax.url,
            type: 'ajax',
            opts: {
                ajax: {
                    settings: {
                        dataType: 'html',
                        type: "POST",
                        data: {
                            product_id: $productId,
                            action: 'pix_quick_view',
                            nonce_view: pixAjax.nonce_view,
                            fancybox: true,
                        },
                    }
                },
                afterLoad: function(instance, slide){
                    // Init Product image gallery, if neccesary
                    slide.$content.css('max-width', '90%').css('margin', '60px 0');
                    slide.$content.find( '.woocommerce-product-gallery' ).each( function() {
                        $( this ).wc_product_gallery();
                    } );
                    if($('.variations_form').length){
                        $('.variations_form').wc_variation_form();
                    }

                    // Init product tabs, if neccesary
                    slide.$content.find( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
                },
            }
        });

    });
	/* =============================================== */



    //toggle list/grid
    $('.pix-view-btn-1').on('click', function () {
        $('.pix-product-list').addClass('pix-hidden-list');
        setTimeout(function () {
            $('.pix-product-list').hide();
            $('.pix-product-grid').show();

            setTimeout(function () {
                $('.pix-product-grid').removeClass('pix-hidden-list');
            }, 10);
        }, 150);
    });
    $('.pix-view-btn-2').on('click', function () {
        $('.pix-product-grid').addClass('pix-hidden-list');
        setTimeout(function () {
            $('.pix-product-grid').hide();
            $('.pix-product-list').show();

            setTimeout(function () {
                $('.pix-product-list').removeClass('pix-hidden-list');
            }, 10);
        }, 150);
    });
    //------------------------------------------------


    


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




    $('#ajax-department').on( 'change', function (e) {
        e.preventDefault();

        $('.common-appointment-calendar').addClass('ajax-loading');

        var dep = $(this).val();
		var data = {
            action: 'pixcustom',
            nonce: pixcustomAjax.nonce,
			department: dep,
        };

        $.post( pixcustomAjax.url, data, function( response ){
            //console.log('AJAX response : ', response.data);
			$('.common-appointment-calendar').removeClass('ajax-loading');
            var prev_val = $('.booked_calendar_chooser').val();
            $('.booked_calendar_chooser').html(response.data);
            if(prev_val >= 0) {
				$('.booked_calendar_chooser').trigger('change');
			}

        });
    });


    var pixSwiper = [],
        i = 0;
    $('.pix__footerNewsList').each(function () {
    
		var options = {},
            // container = $(this).parent().parent(),
            // parent = $(this).parent(),
            // swiper = $(this),
            next = $(this).parent().find('.swiper-button-next')[0],
            prev = $(this).parent().find('.swiper-button-prev')[0];
        
        i++;
        $(this).attr('data-index', 'swf' + i);
        options.slidesPerView = 1;
        options.watchOverflow = true;
        options.watchSlidesVisibility = true;
        options.navigation = {
            nextEl: next,
            prevEl: prev
        };
        // if(options.pagination === true){
        //     options.pagination = {
        //         el: paging,
        //         clickable: true
        //     };
        // }
        // if(options.autoplay === true){
        //     options.autoplay = {
        //         delay: options.autoplayDelay
        //     };
        // }
        
        pixSwiper['swf'+i] = new Swiper($(this)[0], options);
        
	});
    
    $(window).on('load', function(){
        var $swiper = $('.pix__footerNewsList');
        if ($swiper.length) {
            $swiper.each(function() {
                var sw_index = $(this).attr('data-index');
                
                pixSwiper[sw_index].update();
                
            });
        }
    });


});