<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}



class PixThemeSettings_Taxonomy_Widget extends WP_Widget {

	// Widget setup.
	function __construct() {

		// Widget settings.
		$widget_ops = array(
			'classname' => 'pix-widget-taxonomy-category',
			'description' => esc_html__('Display Custom Categories', 'pixsettings')
		);

		// Create the widget.
		parent::__construct('PixThemeSettings_Taxonomy_Widget', esc_html__('Pix Taxonomy Categories', 'pixsettings') , $widget_ops);
	}

	// Display the widget on the screen.
	function widget($args, $instance) {
		global $post;
		extract($args);
		
		$permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
            'team_base'           => '',
            'team_category_base'          => '',
            'portfolio_base'               => '',
            'portfolio_category_base'         => '',
            'service_base'               => '',
            'service_category_base'         => '',
        ) );
		$permalinks_arr = array();
        $permalinks_arr['pix-team-cat'] = !isset($permalinks['team_category_base']) || empty($permalinks['team_category_base']) ? 'specialty' : $permalinks['team_category_base'];
        $permalinks_arr['pix-portfolio-cat'] = !isset($permalinks['portfolio_category_base']) || empty($permalinks['portfolio_category_base']) ? 'portfolio_category' : $permalinks['portfolio_category_base'];
        $permalinks_arr['pix-service-cat'] = !isset($permalinks['service_category_base']) || empty($permalinks['service_category_base']) ? 'departments' : $permalinks['service_category_base'];
		$title = apply_filters('widget_title', $instance['pix_title']);
		$pix_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$all_page = pixtheme_get_option('services_settings_page', '');
		if ( '' != $all_page ) {
			$all_services = get_the_permalink($all_page);
		} else {
		    $all_services = '';//get_bloginfo( 'url' ) . '/' . $permalinks_arr[$instance['pix_taxonomy']];
        }

		echo wp_kses_post($before_widget);
		if ($title) echo wp_kses_post($before_title . $title . $after_title);
  
		
		$args = array( 'taxonomy' => $instance['pix_taxonomy'], 'hide_empty' => '0');
		$categories = get_categories($args);
		echo '<div class="pix-categories"><ul>';
		echo '' == $all_services ? '' : '<li><a href="'. esc_url($all_services) .'">'. wp_kses_post($instance['pix_all_title']) .'</a></li>';

		foreach($categories as $category){
			$class = isset($pix_term->slug) && ($pix_term->slug == $category->slug) ? 'class="active"' : '';
			?>
			<li <?php echo wp_kses_post($class)?>><a href="<?php echo esc_url(get_category_link( $category->term_id )); ?>"><?php echo wp_kses_post($category->name); ?></a></li>
            <?php
		}
		echo '</ul></div>';
		echo wp_kses_post($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['pix_taxonomy'] = strip_tags($new_instance['pix_taxonomy']);
		$instance['pix_title'] = strip_tags($new_instance['pix_title']);
		$instance['pix_all_title'] = strip_tags($new_instance['pix_all_title']);
		return $instance;
	}

	function form($instance) {
	    global $pix_settings;
		$defaults = array(
            'pix_taxonomy' => '',
			'pix_title' => esc_html__('Categories', 'pixsettings'),
            'pix_all_title' => esc_html__('All', 'pixsettings'),
		);
		$pix_taxonomy_arr = array('' => esc_html__('Select Taxonomy Category', 'pixsettings'));
		if( $pix_settings->settings->get_setting('pix-team') == 'on' ){
            $pix_taxonomy_arr['pix-team-cat'] = esc_html__('Team Category', 'pixsettings');
        }
        if( $pix_settings->settings->get_setting('pix-portfolio') == 'on' ){
            $pix_taxonomy_arr['pix-portfolio-cat'] = esc_html__('Portfolio Category', 'pixsettings');
        }
        if( $pix_settings->settings->get_setting('pix-service') == 'on' ){
            $pix_taxonomy_arr['pix-service-cat'] = esc_html__('Services Category', 'pixsettings');
        }
		$instance = wp_parse_args((array)$instance, $defaults); ?>
        <p>
			<select id="<?php echo esc_attr($this->get_field_id('pix_taxonomy')); ?>" name="<?php echo esc_attr($this->get_field_name('pix_taxonomy')); ?>" class="widefat" >
            <?php
            foreach($pix_taxonomy_arr as $key => $val){
                if($instance['pix_taxonomy'] == $key){
                    echo '<option value="'.esc_attr($key).'" selected>'.wp_kses_post($val).'</option>';
                }else{
                    echo '<option value="'.esc_attr($key).'">'.wp_kses_post($val).'</option>';
                }
            }
            ?>
            </select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pix_title')); ?>"><?php esc_html_e('Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('pix_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('pix_title')); ?>" value="<?php echo esc_attr($instance['pix_title']); ?>" class="widefat" />
		</p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('pix_all_title')); ?>"><?php esc_html_e('All Items Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('pix_all_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('pix_all_title')); ?>" value="<?php echo esc_attr($instance['pix_all_title']); ?>" class="widefat" />
		</p>

	<?php
	}
}