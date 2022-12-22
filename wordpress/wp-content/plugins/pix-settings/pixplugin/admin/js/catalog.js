/**
 * Javascript functions for MultiToggle component
 */

jQuery(document).ready(function ($) {

	'use strict';

	function pix_change_input_val(){
	    var $input = $('.pix-catalog input.pix-hidden-text').val();

    }

    $('.pix-catalog ul input[type="checkbox"]').on('change', function () {

        var $input = $('.pix-catalog input.pix-hidden-text'),
            $str = $('.pix-catalog input.pix-hidden-text').val();

        if($(this).prop('checked')) {
            $str = $str + $(this).attr("name") + ',';
        } else {
            $str = $str.replace($(this).attr("name") + ',', '');
        }

        $input.val($str);

    });

});
