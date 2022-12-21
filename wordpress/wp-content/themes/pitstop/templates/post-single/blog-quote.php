<?php
	global $post;
	// get meta options/values
	$pixtheme_content = get_post_meta($post->ID, 'pix_post_quote_content', 1);
	$pixtheme_source = get_post_meta($post->ID, 'pix_post_quote_source', 1) == '' ? '' : '<div class="blog-quote-source">'.(get_post_meta($post->ID, 'pix_post_quote_source', 1)).'</div>';

	if($pixtheme_content != '') :
?>

	<blockquote>
        <?php echo wp_kses($pixtheme_content, 'post'); ?>
        <?php echo wp_kses($pixtheme_source, 'post')?>
    </blockquote>
	
<?php endif; ?>

