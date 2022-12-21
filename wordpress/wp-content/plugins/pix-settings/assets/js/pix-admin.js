jQuery(document).ready(function($)
{

    $(document).on('click', 'a[href="#"]', function(e){
        e.preventDefault();
    });
    
    function pixVanillaSelectBox() {
        var pixMultiSelectBox = $('.pix-multi-select'),
            pixMultiSelect = [];
        
        console.log(pixMultiSelectBox);
        
        pixMultiSelectBox.each(function () {
            var id = $(this).attr('id'),
                placeholder = $(this).data('placeholder');

            pixMultiSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                search: true
            });
        });
    }
    //pixVanillaSelectBox();
    
    function formatCategories (state) {
        if (!state.id) {
            return state.text;
        }
        return state.text.replace(/\u00a0/g, '');
    };
    
    $(document).ready(function() {
        $('.pix-multi-select').select2({
            theme: 'bootstrap4',
            closeOnSelect: false,
            templateSelection: formatCategories,
        });
    });
    

    $('.pix-add-field-button').on('click', function() {
        var $container = $(this).parent().find('.pix-content-dynamic');

        $container.append('<div class="pix-content value"><input name="pix-calc-field[title][]" type="text" value="" class="pix-form-control"><div class="pix-input-wrapper"><input name="pix-calc-field[price][]" type="number" class="pix-form-control" value=""/></div><a href="#" class="pix-delete-value"><i class="far fa-trash-alt"></i></a></div>');
    });

    $(document).on('click', '.pix-delete-value', function() {
        console.log('delete');
        $(this).parent().remove();
    });



});