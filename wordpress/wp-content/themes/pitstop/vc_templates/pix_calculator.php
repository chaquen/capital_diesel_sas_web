<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Pix_Calculator
 */
$shadows_arr = array();
$out = $calc_id = $form_id = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$args = array();

$out = '
    <section class="pix-calculator">
';

if($calc_id != 0 && $calc_id != ''){
    $args = array(
        'post_type' => 'pix-calculator-field',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-calculator',
                'field'    => 'slug',
                'terms'    => $calc_id
            )
        ),
        'posts_per_page' => -1,
        'order' => 'ASC',
    );
} else {
    $args = array(
        'post_type' => 'pix-calculator-field',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-calculator',
                'field'    => 'slug',
                'operator' => 'NOT EXISTS'
            )
        ),
        'posts_per_page' => -1,
        'order' => 'ASC',
    );
}

$wp_query = new WP_Query( $args );

if ( $wp_query->have_posts() ) {
    
    $out .= '
        <div class="pix-calculator-fields">
    ';

    $i = $offset = 0;
    while ( $wp_query->have_posts() ) :
        $wp_query->the_post();
        $i++;

        if($css_animation != '') {
            //$animate = 'class="';
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            //$animate .= '"';
            $animate_data .= ' data-animation="'.esc_attr($css_animation).'"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
            $animate_data .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
        }
        
        $post_slug = get_post_field( 'post_name', get_the_ID() );
        $field_type = get_post_meta( get_the_ID(), 'pix-field-type', true );
        $field_values = get_post_meta( get_the_ID(), 'pix-field-values', true );
        $description = get_the_excerpt(get_the_ID()) ? '<span>'.get_the_excerpt(get_the_ID()).'</span>' : '';
        
        $out_values = '';
        if(isset($field_values['title'])) {
            foreach ($field_values['title'] as $key => $title ) {
                $price = isset($field_values['price'][$key]) ? $field_values['price'][$key] : '';
                switch ($field_type) {
                    case 'select' :
                        $out_values .= '<option value="'.($title).'" data-price="'.esc_attr($price).'">'.($title).' - '.esc_attr($price).'</option>';
                        break;
        
                    case 'check' :
                        $out_values .= '<label><input name="'.esc_attr($post_slug).'" type="checkbox" class="pix-calc-value" value="'.($title).'" data-price="'.esc_attr($price).'">'.($title).' - '.esc_attr($price).'</label>';
                        break;
        
                    case 'radio' :
                        $out_values .= '<label><input name="'.esc_attr($post_slug).'" type="radio" class="pix-calc-value" value="'.($title).'" data-price="'.esc_attr($price).'">'.($title).' - '.esc_attr($price).'</label>';
                        break;
                }
            }
        }
        if($field_type == 'select'){
            $out_values = '
                <select name="'.esc_attr($post_slug).'" class="pix-calc-value">
                    <option value="" data-price="0">'.esc_html__('Select option','pitstop').'</option>
                    '.$out_values.'
                </select>';
        }
        
        $out .= '
            <div class="pix-calculator-field">
                <div class="pix-calc-title">
                    '.(get_the_title()).'
                    '.($description).'
                </div>
                <div class="pix-calc-values '.esc_attr($field_type).'">
                    ' . ($out_values) . '
                </div>
                <div class="pix-reset">
                    <a href="#">'.esc_html__('Reset', 'pitstop').'</a>
                </div>
            </div>';

    endwhile;

    $out .= '
            <div class="pix-calc-total">
                <div class="pix-calc-total-text">
                    '.esc_html__('Total:', 'pitstop').'
                </div>
                <div class="pix-calc-total-price">
                    <span>0</span>
                </div>
            </div>
            <div class="pix-calc-total-btn">
                <a class="pix-button">'.esc_html__('Send Result', 'pitstop').'</a>
            </div>
        </div>
    ';
}

if(isset($form_id) && $form_id > 0){
   $out .= '<div class="pix-form-container">'.do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]').'</div>';
}

$out .= '
    </section>';


wp_reset_postdata();

pixtheme_out($out);