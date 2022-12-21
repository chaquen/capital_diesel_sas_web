/* customizer preview */

( function( wp, $ ) {
    wp.customize.bind('ready', function(){
        $.each($('.pix-google-font'), function(){

            var weight_id = $(this).data('weight-id'),
                weights = [],
                font_weights = $(this).find(':selected').data('weights');

            $('#'+weight_id).find('option').remove().end();
            if(typeof font_weights !== 'undefined' && font_weights.length > 0){
                weights = font_weights.split(",");
                $.each(weights, function(i, item){
                    var $selected = item == $('#'+weight_id).data('value') ? 'selected="selected"' : '';
                    $('#'+weight_id).append("<option value='" + item + "' " + $selected +">" + item + "</option>");
                });
            } else {
                $('#'+weight_id).append("<option value='400'>400</option>");
            }
        })
    });
} )( wp, jQuery );

jQuery(function($){

    "use strict";

    var customize = wp.customize;
    
    customize( 'pixtheme_decor_show', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_decor_img' ).container.hide();
            customize.control( 'pixtheme_decor_width' ).container.hide();
            customize.control( 'pixtheme_decor_height' ).container.hide();
        }

        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_decor_img' ).container.hide();
                customize.control( 'pixtheme_decor_width' ).container.hide();
                customize.control( 'pixtheme_decor_height' ).container.hide();
            } else {
                customize.control( 'pixtheme_decor_img' ).container.show();
                customize.control( 'pixtheme_decor_width' ).container.show();
                customize.control( 'pixtheme_decor_height' ).container.show();
            }
        } );
    } );

    customize( 'pixtheme_decor_img', function( value ) {
        var width = customize.control( 'pixtheme_decor_width' ).setting.get();
        if( value.get() ){
            var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = width;
            }
        }
        value.bind( function( to ) {
            if( to != '' ) {
                var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
                if( img[0] ){
                    img[0].width = width;
                }
            }
        } );
    } );

    customize( 'pixtheme_decor_width', function( value ) {
        value.bind( function( to ) {
            var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = to;
            }
        } );
    } );



    customize( 'pixtheme_general_settings_logo', function( value ) {
        var width = customize.control( 'pixtheme_general_settings_logo_width' ).setting.get();
        if( value.get() ){
            var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = width;
            }
        }
        value.bind( function( to ) {
            if( to != '' ) {
                var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
                if( img[0] ){
                    img[0].width = width;
                }
            }
        } );
    } );

    customize( 'pixtheme_general_settings_logo_width', function( value ) {
        value.bind( function( to ) {
            var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = to;
            }
        } );
    } );



    /// Header

    customize( 'pixtheme_header_bar', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_top_bar_background' ).container.hide();
            customize.control( 'pixtheme_top_bar_transparent' ).container.hide();
        }
        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_top_bar_background' ).container.hide();
                customize.control( 'pixtheme_top_bar_transparent' ).container.hide();
            } else {
                customize.control( 'pixtheme_top_bar_background' ).container.show();
                customize.control( 'pixtheme_top_bar_transparent' ).container.show();
            }
        } );
    } );

    function pix_info_sections_hide(){
        customize.control( 'pixtheme_header_info_icon_1' ).container.hide();
        customize.control( 'pixtheme_header_info_title_1' ).container.hide();
        customize.control( 'pixtheme_header_info_1' ).container.hide();
        customize.control( 'pixtheme_header_info_icon_2' ).container.hide();
        customize.control( 'pixtheme_header_info_title_2' ).container.hide();
        customize.control( 'pixtheme_header_info_2' ).container.hide();
        customize.control( 'pixtheme_header_info_icon_3' ).container.hide();
        customize.control( 'pixtheme_header_info_title_3' ).container.hide();
        customize.control( 'pixtheme_header_info_3' ).container.hide();
    }

    function pix_info_sections_toogle(val) {
        if( val == 'info_1' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_1' ).container.show();
            customize.control( 'pixtheme_header_info_title_1' ).container.show();
            customize.control( 'pixtheme_header_info_1' ).container.show();
        } else if( val == 'info_2' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_2' ).container.show();
            customize.control( 'pixtheme_header_info_title_2' ).container.show();
            customize.control( 'pixtheme_header_info_2' ).container.show();
        } else if( val == 'info_3' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_3' ).container.show();
            customize.control( 'pixtheme_header_info_title_3' ).container.show();
            customize.control( 'pixtheme_header_info_3' ).container.show();
        }
    }

    customize( 'pixtheme_header_info_segment', function( value ) {
        if( value.get() == '' ){
            pix_info_sections_hide();
        } else {
            pix_info_sections_toogle(value.get());
        }

        $('#customize-control-pixtheme_header_info_segment .pix-vc-segmented-button input[type=radio]').on('change', function(){
            var val = $(this).val();
            pix_info_sections_toogle(val);
        });

    } );


    customize( 'pixtheme_header_type', function( value ) {
        const header_arr = ['header3', 'header4', 'header5', 'header_catalog'];
        if( !header_arr.includes(value.get()) ){
            customize.control( 'pixtheme_header_background_bottom' ).container.hide();
            customize.control( 'pixtheme_header_transparent_bottom' ).container.hide();
            customize.control( 'pixtheme_header_info_segment' ).container.hide();
            customize.control( 'pixtheme_header_layout_bottom' ).container.hide();
            pix_info_sections_hide();
            if( value.get() == 'header1' ) {
                customize.control( 'pixtheme_header_menu_pos' ).container.show();
            }
        } else {
            customize.control( 'pixtheme_header_border' ).container.hide();
            customize.control( 'pixtheme_header_layout_bottom' ).container.show();
        }
        value.bind( function( to ) {
            if( !header_arr.includes(to) ) {
                customize.control( 'pixtheme_header_background_bottom' ).container.hide();
                customize.control( 'pixtheme_header_transparent_bottom' ).container.hide();
                customize.control( 'pixtheme_header_info_segment' ).container.hide();
                customize.control( 'pixtheme_header_menu_pos' ).container.hide();
                customize.control( 'pixtheme_header_layout_bottom' ).container.hide();
                customize.control( 'pixtheme_header_border' ).container.show();
                pix_info_sections_hide();
                if( to == 'header1' ) {
                    customize.control( 'pixtheme_header_menu_pos' ).container.show();
                }
            } else {
                customize.control( 'pixtheme_header_background_bottom' ).container.show();
                customize.control( 'pixtheme_header_transparent_bottom' ).container.show();
                customize.control( 'pixtheme_header_menu_pos' ).container.show();
                customize.control( 'pixtheme_header_layout_bottom' ).container.show();
                customize.control( 'pixtheme_header_border' ).container.hide();
                if( to == 'header4' ){
                    customize.control( 'pixtheme_header_info_segment' ).container.show();
                    pix_info_sections_toogle('info_1');
                }
            }
        } );
    } );

    customize( 'pixtheme_header_sticky', function( value ) {
        if( value.get() != '' ){
            customize.control( 'pixtheme_header_sticky_width' ).container.show();
        } else {
            customize.control( 'pixtheme_header_sticky_width' ).container.hide();
        }

        value.bind( function( to ) {
            if( to != '' ) {
                customize.control( 'pixtheme_header_sticky_width' ).container.show();
            } else {
                customize.control( 'pixtheme_header_sticky_width' ).container.hide();
            }
        });

    } );


    customize( 'pixtheme_header_background_bottom', function( value ) {
        if( value.get() != '' ){
            customize.control( 'pixtheme_header_transparent_bottom' ).container.show();
        } else {
            customize.control( 'pixtheme_header_transparent_bottom' ).container.hide();
        }

        value.bind( function( to ) {
            if( to != '' ) {
                customize.control( 'pixtheme_header_transparent_bottom' ).container.show();
            } else {
                customize.control( 'pixtheme_header_transparent_bottom' ).container.hide();
            }
        });

    } );



    customize( 'pixtheme_tab_position', function( value ) {
        var hide = customize.control( 'pixtheme_tab_hide' ).setting.get();
        if( value.get() == 'left_right' || value.get() == 'right_left' ){
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
        } else if (hide == '') {
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
        }
        value.bind( function( to ) {
            if( to == 'left_right' || to == 'right_left' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
            } else if (hide == '') {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
            }
        });
    });

    customize( 'pixtheme_tab_hide', function( value ) {
        var position = customize.control( 'pixtheme_tab_position' ).setting.get();
        if( value.get() != '' ){
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
        } else if( position != 'left_right' && position != 'right_left' ) {
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
        }
        value.bind( function( to ) {
            if( to != '' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
            } else if( position == 'left_right' && position == 'right_left' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
            }
        });
    });



    customize( 'pixtheme_buttons_shadow', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_buttons_shadow_h' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_v' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_blur' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_spread' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_color' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_opacity' ).container.hide();
        }

        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_buttons_shadow_h' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_v' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_blur' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_spread' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_color' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_opacity' ).container.hide();
            } else {
                customize.control( 'pixtheme_buttons_shadow_h' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_v' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_blur' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_spread' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_color' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_opacity' ).container.show();
            }
        } );
    } );



    /// Font Tags Settings

    var font_controls = [
        'family',
        'weight',
        'size',
        'line_height',
        'style',
        'color',
    ];

    function pix_font_tag_set(tag, item, val){
        var tag_values = {},
            values = customize.control( tag ).setting.get();
        tag_values = JSON.parse(values);
        tag_values[item] = val;
        customize.control( tag ).setting.set(JSON.stringify(tag_values));
    }

    function pix_font_tag_change(tag){
        var tag_values = JSON.parse(customize.control( tag ).setting.get());
        //console.log(tag_values);
        $.each(font_controls, function(i, font_control){
            customize.control( 'pixtheme_font_'+font_control ).setting.set(tag_values[font_control]);
            if( font_control == 'family' ){
                var ctrl = customize.control( 'pixtheme_font_'+font_control ).container.find( '.pix-google-font' );
                ctrl.attr('data-value', tag_values[font_control]);
            } else if( font_control == 'weight' ){
                var ctrl = customize.control( 'pixtheme_font_'+font_control ).container.find( '.pix-google-font-weight' );
                ctrl.attr('data-value', tag_values[font_control]);
            } else if(font_control == 'size' || font_control == 'line_height'){
                var ctrl = customize.control( 'pixtheme_font_'+font_control ).container.find( '.range-slider-single' ),
                    slider = ctrl.data('ionRangeSlider');
                slider.update({
                    from: tag_values[font_control]
                });
            }
        });
    }

    customize( 'pixtheme_fonts_tags', function( value ) {
        pix_font_tag_change('pixtheme_font_p');
        pix_change_selected_weights();
        value.bind( function( to ) {
            pix_font_tag_change(to);
        });
    });

    $.each(font_controls, function(i, font_control){
        customize( 'pixtheme_font_'+font_control, function( value ) {
            value.bind( function( to ) {
                var tag = customize.control('pixtheme_fonts_tags').setting.get();
                pix_font_tag_set(tag, font_control, to);
            } );
        });
    });






    /// Google Fonts Loader

    function pix_set_fonts(){
    	var font_families = [];
	    $.each($('.pix-google-font-str'), function(){
    		if($(this).val() != '') {
                font_families.push($(this).val());
            }
        });

    	$('#pix-fonts-embed').val(font_families.join('&family='));
    	$('#pix-fonts-embed').change();
	}

	function pix_change_selected_weights(){
        var weight_val = $('.pix-google-font-weight').data('value'),
            font_weights = [];
        font_weights = String($('.pix-google-font').find(':selected').data('weights')).split(';');

        $('.pix-google-font-weight').find('option').remove().end();
        if(font_weights[0] != ''){
            $.each(font_weights, function(i, item){
                $('.pix-google-font-weight').append("<option value='" + item + "'>" + item + "</option>");
            });
            $('.pix-google-font-weight').val(weight_val);
        } else {
            $('.pix-google-font-weight').append("<option value='400'>400</option>");
        }
	}

    $(document).on('change', '#pix-fonts-embed', function(){
		var font_families = $(this).val().split("&family=");
		$('.pix-google-font').find('option').remove().end();
	    $('.pix-google-font-wrapper').remove();
	    $.each(font_families, function(i, item){
	        var font_family = item.split(":");
	        var font_weights_str = '',
                font_weights = '';
            if(typeof font_family[1] !== 'undefined') {
                var font_weights_arr = font_family[1].split("@");
				font_weights_str = font_family[1];
				if(font_weights_arr[0] == 'wght'){
                    font_weights = font_weights_arr[1];
                } else if (font_weights_arr[0] == 'ital,wght'){
				    var weights_arr = [];
                    $.each(font_weights_arr[1].split(";"), function(j, weight){
                        var weight_arr = weight.split(',');
                        if( !weights_arr.includes(weight_arr[1]) ){
                            weights_arr.push(weight_arr[1]);
                        }
                        // if(weight_arr[0] == '0'){
                        //     font_weights = font_weights + weight_arr[1]+';';
                        // } else if(weight_arr[0] == '1'){
                        //     font_weights = font_weights + weight_arr[1]+'i;';
                        // }
                    });
                    font_weights = weights_arr.sort().join(';');
                }
			}
			var font_family_name = font_family[0].replace(/\+/g, ' ');
            var font_item = font_family_name;
            if(font_weights != ''){
                font_item = font_item + ': ' + font_weights;
            }
			var font_wrapper = '<div class="pix-google-font-wrapper" data-font="'+font_family_name+'"><label class="pix-customize-control-label">'+font_item+'</label><input type="hidden" class="pix-google-font-str" value="'+item+'" data-font-weights="'+font_weights+'"><button type="button" class="btn pix-wrapper-delete"><i class="fas fa-trash-alt"></i></button></div>';
			$('#pix-google-font-select').before(font_wrapper);
			$('.pix-google-font').append("<option value='" + font_family_name + "' data-weights='" + font_weights + "'>" + font_family_name + "</option>");
        });

		pix_change_selected_weights();
		$('#pix-google-font-select').addClass('close');
	});

	$(document).on('change', '.pix-google-font', function(){
		var weight_id = $(this).data('weight-id'),
            weight_val = $('#'+weight_id).data('value'),
            font_weights = [];
		console.log(weight_val);
		font_weights = String($(this).find(':selected').data('weights')).split(";");
		$('#'+weight_id).find('option').remove().end();
		if(font_weights[0] != ''){
		    $.each(font_weights, function(i, item){
		        if(item == weight_val){
		            $('#'+weight_id).append("<option value='" + item + "' selected>" + item + "</option>");
                } else {
		            $('#'+weight_id).append("<option value='" + item + "'>" + item + "</option>");
                }
            });
        } else {
		    $('#'+weight_id).append("<option value='400'>400</option>");
        }
    });

	$(document).on('change', '.pix-google-font-weight', function(){
	    $(this).attr('data-value', $(this).val());
    });

    $(document).on('click', '.pix-wrapper-delete', function(){
    	$(this).parent().remove();
		pix_set_fonts();
	});



});
