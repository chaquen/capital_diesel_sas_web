<?php
/*** Single Portfolio Custom template. */

?>

<div class="col-xl-9 pix-portfolio-info-col">
    <div class="pix-portfolio-info">
        <div class="service-page-item-image">
            <?php the_post_thumbnail( get_the_ID(), 'medium', array('class' => 'img-responsive') ); ?>
        </div>
        <div class="service-page__list">
            <h2><?php the_title(); ?></h2>
            <?php
            $field_1 = get_post_meta(get_the_ID(), 'pix_field_1', 1) == '' ? '' : '<li><i class="icon-user"></i>'.esc_html__('Specialty', 'pitstop').'<span>'.get_post_meta(get_the_ID(), 'pix_field_1', 1).'</span></li>';
            $field_2 = get_post_meta(get_the_ID(), 'pix_field_2', 1) == '' ? '' : '<li><i class="icon-graduation"></i>'.esc_html__('Graduation', 'pitstop').'<span>'.get_post_meta(get_the_ID(), 'pix_field_2', 1).'</span></li>';
            $field_3 = get_post_meta(get_the_ID(), 'pix_field_3', 1) == '' ? '' : '<li><i class="icon-clock"></i>'.esc_html__('Length of Work', 'pitstop').'<span>'.get_post_meta(get_the_ID(), 'pix_field_3', 1).'</span></li>';
            $field_4 = get_post_meta(get_the_ID(), 'pix_field_4', 1) == '' ? '' : '<li><i class="icon-briefcase"></i>'.esc_html__('Work Place', 'pitstop').'<span>'.get_post_meta(get_the_ID(), 'pix_field_4', 1).'</span></li>';
            ?>
            <ul>
                <?php echo wp_kses($field_1, 'post') ?>
                <?php echo wp_kses($field_2, 'post') ?>
                <?php echo wp_kses($field_3, 'post') ?>
                <?php echo wp_kses($field_4, 'post') ?>
            </ul>
        </div>
    </div>
</div>
<div class="col-lg-8 pix-portfolio-content-col">
    <div class="service-page-content">
        <?php the_content(); ?>
    </div>
</div>
