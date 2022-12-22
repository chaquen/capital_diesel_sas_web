<?php

$cat_layout = 'blog';
$cat_width = 'post';
if( in_array(get_post_type(), array('pix-team', 'pix-portfolio', 'pix-service')) ){
    $cat_layout = $cat_width = str_replace('pix-', '', get_post_type()).'-cat';
}

$pix_layout = pixtheme_get_layout($cat_layout);
$pix_width_class = pixtheme_get_layout_width( $cat_width );

$blog_class = 'pix-blog-'.pixtheme_get_setting('pix-blog-style', 'classic');
?>

<?php get_header(); ?>

<section class="blog blog-content-section" id="main">
	<div class="<?php echo esc_attr($pix_width_class)?>">
	    <div class="row sidebar-type-<?php echo esc_attr($pix_layout['layout']); ?>">
	        <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
	        <div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">
	            
                <?php
                    if( $cat_layout == 'blog' ){
                        if ( have_posts() ) {
                            ?>
                        <section class="<?php echo esc_attr($blog_class) ?>">
                            <?php
                            the_post();
                            rewind_posts();
                            get_template_part('loop', 'archive');
                            ?>
                        </section>
                            <?php
                        }
                        
                        the_posts_pagination( array(
                            'prev_text'          => '<i class="icon-arrow-left"></i>',
                            'next_text'          => '<i class="icon-arrow-right"></i>',
                            'screen_reader_text' => '&nbsp;',
                        ) );
                    } else {
                        $pix_all_page = get_post_type().'-page';
                        $pix_all_page_id = pixtheme_get_setting($pix_all_page, '0');
                        if( $pix_all_page_id != 0 ){
                            if(function_exists('icl_object_id')) {
                                $pix_all_page_id = icl_object_id ($pix_all_page_id, 'page', true);
                            }
                            pixtheme_get_section_content($pix_all_page_id);
                        } else {
                            get_template_part( 'templates/archive/'.get_post_type() );
                        }
                        
                    }
                ?>
				
	        </div>
	        <?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
	    </div>
	</div>
</section>

<?php get_footer(); ?>