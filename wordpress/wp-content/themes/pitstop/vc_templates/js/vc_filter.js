!function ($) {

    function pix_change_vc_data( parent ){
		var data = {},
            select = [],
            input = $('input.pix-input-vc-filter'),
            dataJSON = '';
		if( parent.find('.pix-widget-option').length ){
            parent.find('.pix-widget-option').each(function (i) {
                var $row = '1';
                $(this).find('input[type="radio"].checked').each(function() {
                    $row = $(this).val();
                });
                select.push({
                    id : $(this).data('field'),
                    name : $(this).find('input[type="text"]').val(),
                    row : $row,
                    show : $(this).find('input[type="checkbox"]').prop('checked')
                });
            });
            //console.log(select);
        }
        dataJSON = JSON.stringify(select);
		input.val(dataJSON);
		//console.log(input.val());
        input.trigger( "change" );

	}

    var pix_update_vc_filter_order = function(e, ui) {
        pix_change_vc_data(ui.item.parent());
    },
    pix_vc_filter_sort = function() {
        $('.pix-widget-sortable').sortable({
            items: "> div:not(.fixed)",
            placeholder: "ui-state-highlight",
            forcePlaceholderSize: true,
            stop: pix_update_vc_filter_order
        }).disableSelection();
    }
    // $( document ).ajaxComplete(function() {
    //     pix_vc_filter_sort();
    // });
    pix_vc_filter_sort();


    $(document).on('change', '.pix-vc-filter .pix-widget-option .switch input', function() {
        var input = $(this).parent().parent().find('input[type="text"]'),
            select = $(this).parent().parent().find('select'),
            radio = $(this).parent().parent().find('input[type="radio"]');
        if( $(this).prop('checked') ){
            input.prop('disabled', false);
            select.prop('disabled', false);
            radio.each(function() {
                $(this).prop('disabled', false);
            });
        } else {
            input.prop('disabled', true);
            select.prop('disabled', true);
            radio.each(function() {
                $(this).prop('disabled', true);
            });
        }
        pix_change_vc_data($(this).parent().parent().parent());
    });

    $(document).on('change', '.pix-vc-filter .pix-widget-option input[type="text"]', function() {
        pix_change_vc_data($(this).parent().parent().parent());
    });

    $(document).on('change', '.pix-vc-filter .pix-widget-option input[type="radio"]', function() {
        pix_change_vc_data($(this).parent().parent().parent().parent());
    });

    $(document).on('change', '.pix-vc-filter .pix-segmented-button-field', function() {
            var $parent = $(this).parent(),
                $radio = $(this);
            $parent.find('.pix-segmented-button-field').each(function(){
                $(this).prop('checked', false);
                $(this).removeClass('checked');
            });
            $radio.prop('checked', true);
            $radio.addClass('checked');
    });


}(window.jQuery);
