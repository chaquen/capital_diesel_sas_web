<?php
/**
 * Elementor emoji one area control.
 *
 * A control for displaying a textarea with the ability to add emojis.
 *
 * @since 1.0.0
 */
class Radio_Images_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'radio_images';
	}

	public function enqueue() {
        wp_enqueue_style( 'radio_images' , get_template_directory_uri() . '/templates_el/controls/css/radio_images.css' );
        wp_enqueue_script( 'radio_images', get_template_directory_uri() . '/templates_el/controls/js/radio_images.js', ['jquery'], '' );
	}
 
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'radio_images_options' => [],
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper pix-el-radio-images">
                <# _.each( data.options, function( option_title, option_value ) {
                    var value = data.controlValue;
                    if ( typeof value == 'string' ) {
                        var checked = ( option_value === value ) ? 'checked' : '';
                    } else if ( null !== value ) {
                        var value = _.values( value );
                        var checked = ( -1 !== value.indexOf( option_value ) ) ? 'checked' : '';
                    }
				#>
                <div class="radio-image-item">
                    <input id="pixid-{{ option_value }}" name="pix-radio-images-{{ data.name }}" value="{{ option_value }}" type="radio" class="pix-radio-images-field" {{ checked }}>
                    <label class="el_checkbox-label" for="pixid-{{ option_value }}"> <img src="<?php echo esc_url(get_template_directory_uri() . '/images/elements/') ?>{{ option_title }}" ></label>
                </div>
                <# } ); #>
                <input id="<?php echo esc_attr( $control_uid ); ?>" type="text" name="{{ data.name }}'" class="pix-input-el-radio-images hidden-field-value" value=""/>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

}