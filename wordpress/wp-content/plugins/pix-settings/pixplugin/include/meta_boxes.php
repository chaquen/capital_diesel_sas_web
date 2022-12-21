<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


function pix_meta_boxes() {
 
	add_meta_box( 'pix_calcfields_details', esc_html__( 'Field Details', 'pixsettings' ), 'pix_calcfields_details', 'pix-calculator-field', 'normal', 'high' );
	add_meta_box( 'pix_banner_details', esc_html__( 'Banner Details', 'pixsettings' ), 'pix_banner_details', 'pix-banner', 'normal', 'high' );
	
	function pix_field_default_hidden_meta_boxes( $hidden, $screen ) {
        $post_type = $screen->post_type;
        if( in_array($post_type, ['pix-calculator-field', 'pix-banner']) ){
            $hidden = array(
                'slugdiv',
                'mymetabox_revslider_0'
            );
            return $hidden;
        }
        return $hidden;
    }
    add_action( 'default_hidden_meta_boxes', 'pix_field_default_hidden_meta_boxes', 10, 2 );
	
}


function pix_get_value( $key ) {
	return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
}

function pix_banner_details() {
 
	?>
    
    <div class="pix-fields-form">
        <div class="pix-form-group">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Title', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <input name="pix-banner-title" class="pix-form-control" value="<?php echo pix_get_value('pix-banner-title') ?>" />
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Top Text', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <input name="pix-banner-subtext" class="pix-form-control" value="<?php echo pix_get_value('pix-banner-subtext') ?>" />
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Countdown', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <input name="pix-banner-countdown" type="datetime-local" class="pix-form-control" value="<?php echo esc_attr(get_post_meta( get_the_ID(), 'pix-banner-countdown', true )) ?>" />
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Link', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <input name="pix-banner-link" class="pix-form-control" value="<?php echo esc_url(get_post_meta( get_the_ID(), 'pix-banner-link', true )) ?>" />
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Text Tone', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <select name="pix-banner-color" class="pix-form-control">
                    <option value="" <?php selected( pix_get_value('pix-banner-color'), '' ); ?> ><?php esc_html_e('Light', 'pixsettings') ?></option>
                    <option value="text-dark" <?php selected( pix_get_value('pix-banner-color'), 'text-dark' ); ?> ><?php esc_html_e('Dark', 'pixsettings') ?></option>
                </select>
            </div>
        </div>
    </div>
    
    <?php
}

function pix_calcfields_details() {
    
    $field_values = get_post_meta( get_the_ID(), 'pix-field-values', true );
    $i = 0;
    
	?>
	
    <input name="pix-fields-meta" type="hidden" value="save">
    
    <div class="pix-fields-form">
        <div class="pix-form-group">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Field Type', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <select name="pix-field-type" class="pix-form-control">
                    <option value="select" <?php selected( pix_get_value('pix-field-type'), 'select' ); ?> ><?php esc_html_e('Select', 'pixsettings') ?></option>
                    <option value="multiselect" <?php selected( pix_get_value('pix-field-type'), 'multiselect' ); ?> ><?php esc_html_e('Multi Select', 'pixsettings') ?></option>
                    <option value="check" <?php selected( pix_get_value('pix-field-type'), 'check' ); ?> ><?php esc_html_e('Checkbox', 'pixsettings') ?></option>
                    <option value="radio" <?php selected( pix_get_value('pix-field-type'), 'radio' ); ?> ><?php esc_html_e('Radiobutton', 'pixsettings') ?></option>
                </select>
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Values', 'pixsettings') ?>
            </label>
            <div class="pix-values">
                <div class="pix-content header">
                    <span><?php esc_html_e('Title', 'pixsettings') ?></span>
                    <span><?php esc_html_e('Price', 'pixsettings') ?></span>
                </div>
                
                <div class="pix-content-dynamic">
                <?php
                    if(isset($field_values['title']) ) {
                    
                        foreach ($field_values['title'] as $key => $val) {
                            $i++;
                            $del_btn = $i>1 ? '<a href="#" class="pix-delete-value"><i class="far fa-trash-alt"></i></a>' : '';
                            $price = isset($field_values['price'][$key]) ? $field_values['price'][$key] : '';
                            if(trim($val) != '' || $price != '') {
                                ?>
                                <div class="pix-content value">
                                    <input name="pix-calc-field[title][]" type="text"
                                           value="<?php echo wp_kses_post($val); ?>" class="pix-form-control">
                                    <div class="pix-input-wrapper">
                                        <input name="pix-calc-field[price][]" type="number" class="pix-form-control"
                                               value="<?php echo esc_attr($price); ?>"/>
                                    </div>
                                    <?php echo wp_kses_post($del_btn); ?>
                                </div>
                                <?php
                            }
                        }
                        
                    } else {
                ?>
                    <div class="pix-content value">
                        <input name="pix-calc-field[title][]" type="text" value="" class="pix-form-control">
                        <div class="pix-input-wrapper">
                            <input name="pix-calc-field[price][]" type="number" class="pix-form-control" value="" />
                        </div>
                    </div>
                <?php
                    }
                ?>
                </div>
                
                <a class="pix-add-field-button" href="#">
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    
    <?php
}


function save_pix_meta_boxes( $post_id ) {
	
 
	if (isset($_POST['pix-banner-title'])) {
        update_post_meta($post_id, 'pix-banner-title', $_POST['pix-banner-title']);
    }
	if (isset($_POST['pix-banner-subtext'])) {
        update_post_meta($post_id, 'pix-banner-subtext', $_POST['pix-banner-subtext']);
    }
	if (isset($_POST['pix-banner-countdown'])) {
        update_post_meta($post_id, 'pix-banner-countdown', $_POST['pix-banner-countdown']);
    }
	if (isset($_POST['pix-banner-link'])) {
        update_post_meta($post_id, 'pix-banner-link', $_POST['pix-banner-link']);
    }
	if (isset($_POST['pix-banner-color'])) {
        update_post_meta($post_id, 'pix-banner-color', $_POST['pix-banner-color']);
    }
    
	if( isset( $_POST['pix-fields-meta'] ) && $_POST['pix-fields-meta'] == 'save' ) {
	    update_post_meta( $post_id, 'pix-field-values', $_POST['pix-calc-field'] );
	}

    if (isset($_POST['pix-field-type'])) {
        update_post_meta($post_id, 'pix-field-type', $_POST['pix-field-type']);
    }


}
add_action( 'save_post', 'save_pix_meta_boxes' );

add_filter( 'paginate_links', function( $link ) {
    return filter_input( INPUT_GET, 'action' ) ? remove_query_arg( array( 'action', 'href', 'url', 'category', 'nonce' ), $link ) : $link;
} );


?>