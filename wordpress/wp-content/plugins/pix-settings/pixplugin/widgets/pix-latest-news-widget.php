<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}



class PixThemeSettings_Latest_News extends WP_Widget {

	// Widget setup.
	function __construct() {
		// Create the widget.
		parent::__construct('pixtheme_latest_news', esc_html__('Latest News', 'pixsettings') , array( 'description' => esc_html__('Display Latest News', 'pixsettings'), ));
	}

	// Display the widget on the screen.
	function widget($args, $instance) {
		global $post;
		extract($args);
		$title = apply_filters('widget_title', $instance['news_title']);
		$style = isset( $instance['news_style'] ) ? $instance['news_style'] : 'list';
		$count = isset( $instance['news_count'] ) ? $instance['news_count'] : '2';
		$all_title = isset( $instance['news_all_title'] ) ? $instance['news_all_title'] : '';
		$all_page = isset( $instance['news_page'] ) ? $instance['news_page'] : '';

		$args_posts = array(
            'ignore_sticky_posts' => true,
            'showposts' => $count,
        );

        $wp_query = new WP_Query( $args_posts );
        if ($wp_query->have_posts()):

            echo wp_kses($before_widget, 'post');
		    if ($title) echo wp_kses($before_title . $title . $after_title, 'post');

            $author = $date = $data_news = '';
            while ($wp_query->have_posts()) :
                $wp_query->the_post();
                if( pixtheme_get_option('blog_show_date', '1') ){
                    $date = '<span class="time"><a href="'.esc_url(get_the_permalink()).'"><time>'.get_the_date().'</time></a></span>';
                }
                if( pixtheme_get_setting('pix-blog-author', 'on') == 'on' ){
                    $author = '<span class="author">'.get_the_author_posts_link().'</span>';
                }
                $thumbnail = get_the_post_thumbnail( get_the_ID() ) != '' ? get_the_post_thumbnail( get_the_ID(), 'medium' ) : '';
                //'<a href="'.esc_url(get_the_permalink()).'">'.wp_kses_post($thumbnail).'</a>';
                if($style == 'carousel'){
                    $data_news .= '
                    <div class="pix__footerNewsItem swiper-slide">
                        <a href="'.esc_url(get_the_permalink()).'">'.wp_kses($thumbnail, 'post').'</a>
                        <h6><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title(). '</a></h6>
                        
                    </div>';
                    // <div class="pix__footerNewsItem-date">' . $date . $author . '</div> ^
                } else {
                    echo '
                    <div class="side-menu__item-news">
                        <div class="news-image">
                            ' . wp_kses($date, 'post') . '
                        </div>
                        <div class="news-text">
                            <a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a>
                        </div>
                    </div>';
                }

            endwhile;
            
            if($style == 'carousel'){
                echo '
                <div class="pix-container">
                    <div class="pix__footerNewsBtn pix-nav small">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    <div class="pix__footerNewsList">
                        <div class="swiper-wrapper">
                            '.$data_news.'
                        </div>
                    </div>
                </div>';
            }

            if($all_title){
                echo '<a class="side-menu__item-all_news" href="'.esc_url($all_page).'">'.wp_kses($all_title, 'post').'</a>';
            }

            echo wp_kses($after_widget, 'post');

        endif;

        wp_reset_query();

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['news_title'] = strip_tags($new_instance['news_title']);
		$instance['news_style'] = strip_tags($new_instance['news_style']);
		$instance['news_count'] = strip_tags($new_instance['news_count']);
		$instance['news_all_title'] = strip_tags($new_instance['news_all_title']);
		$instance['news_page'] = strip_tags($new_instance['news_page']);
		return $instance;
	}

	function form($instance) {
	    $guid = '';
	    $blog_page  = get_page_by_title( 'Blog' );
	    if($blog_page)
	        $guid = $blog_page->guid;
		$defaults = array(
			'news_title' => esc_html__('Latest News', 'pixsettings'),
            'news_style' => 'list',
            'news_count' => '2',
            'news_all_title' => esc_html__('all', 'pixsettings'),
            'news_page' => esc_url($guid),
		);
		$instance = wp_parse_args((array)$instance, $defaults); ?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('news_title')); ?>"><?php esc_html_e('Title', 'pixsettings'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('news_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_title')); ?>" value="<?php echo esc_attr($instance['news_title']); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('news_style')); ?>"><?php esc_html_e('Style', 'pixsettings'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('news_style')); ?>" name="<?php echo esc_attr($this->get_field_name('news_style')); ?>" class="widefat" >
                <option value="list" <?php selected($instance['news_style'], 'list') ?>><?php esc_html_e('List', 'pixsettings'); ?></option>
                <option value="carousel" <?php selected($instance['news_style'], 'carousel') ?>><?php esc_html_e('Carousel', 'pixsettings'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('news_count')); ?>"><?php esc_html_e('Count', 'pixsettings'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('news_count')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_count')); ?>" value="<?php echo esc_attr($instance['news_count']); ?>" class="widefat" />
        </p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('news_all_title')); ?>"><?php esc_html_e('All Button Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('news_all_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_all_title')); ?>" value="<?php echo esc_attr($instance['news_all_title']); ?>" class="widefat" />
		</p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('news_page')); ?>"><?php esc_html_e('All Button Url', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('news_page')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_page')); ?>" value="<?php echo esc_url($instance['news_page']); ?>" class="widefat" />
		</p>

	<?php
	}
}
