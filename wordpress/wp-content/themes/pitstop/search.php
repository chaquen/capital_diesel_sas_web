<?php
/*** The template for displaying search results pages. ***/
    
$pix_layout = pixtheme_get_layout('blog', get_the_ID());
$pix_width_class = pixtheme_get_layout_width( 'page' );

$blog_class = 'pix-blog-'.pixtheme_get_setting('pix-blog-style', 'classic');
?>

<?php get_header();?>

<section class="blog" id="pageContent">
    <div class="<?php echo esc_attr($pix_width_class)?>">
        <div class="row sidebar-type-<?php echo esc_attr($pix_layout['layout']); ?>">
            <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

            <div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">

            <?php if ( have_posts() ) : ?>

                <section class="<?php echo esc_attr($blog_class) ?>">

                <?php get_template_part( 'loop', 'search' );?>
                
                </section>

                <?php
                    the_posts_pagination( array(
                        'prev_text'          => '<i class="icon-arrow-left"></i>',
                        'next_text'          => '<i class="icon-arrow-right"></i>',
                        'screen_reader_text' => '&nbsp;',
                    ) );
                ?>

            <?php else : ?>
                <div id="post-0" class="blog-article post no-results not-found">
                    <h2><?php esc_html_e( 'Nothing Found', 'pitstop' ); ?></h2>
                    <div class="entry-content">
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'pitstop' ); ?></p>
                     </div><!-- .entry-content -->
                </div><!-- #post-0 -->
            <?php endif; ?>

            </div>

            <?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
			
            
            