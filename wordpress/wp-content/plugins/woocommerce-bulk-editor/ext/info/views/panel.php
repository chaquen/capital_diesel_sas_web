<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

global $WOOBE;
?>
<h4><?php _e('Help', 'woocommerce-bulk-editor') ?></h4>

<b>
    <?php
    printf(esc_html__('The plugin has %s, %s, %s list. Also if you have troubles you can %s!', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                'href' => 'https://bulk-editor.com/documentation/',
                'title' => esc_html__('documentation', 'woocommerce-bulk-editor'),
                'target' => '_blank'
            )), WOOBE_HELPER::draw_link(array(
                'href' => 'https://bulk-editor.com/how-to-list/',
                'title' => esc_html__('FAQ', 'woocommerce-bulk-editor'),
                'target' => '_blank'
            )), WOOBE_HELPER::draw_link(array(
                'href' => 'https://bulk-editor.com/translations/',
                'title' => esc_html__('translations', 'woocommerce-bulk-editor'),
                'target' => '_blank'
            )), WOOBE_HELPER::draw_link(array(
                'href' => 'https://pluginus.net/support/forum/woobe-woocommerce-bulk-editor-professional/',
                'title' => '<b style="color: orange;">' . esc_html__('ask for support here', 'woocommerce-bulk-editor') . '</b>',
                'style' => 'text-decoration: none;',
                'target' => '_blank'
    )));
    ?>&nbsp;
    <?php if ($WOOBE->show_notes) : ?>
        <div style="height: 9px;"></div>
        <span style="color: red;"><?php
            printf(__('Current version of the plugin is FREE. See the difference between FREE and PREMIUM versions %s', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                        'href' => 'https://bulk-editor.com/downloads/',
                        'title' => __('here', 'woocommerce-bulk-editor'),
                        'target' => '_blank'
            )));
            ?></span>
    <?php endif; ?>
</b>

<hr />

<h4><?php _e('Some little hints', 'woocommerce-bulk-editor') ?>:</h4>

<ol>
    <li><?php _e('If to click on an empty space of the black wp-admin bar, it will get you back to the top of the page', 'woocommerce-bulk-editor') ?></li>


    <li><?php
        printf(__('Can I %s?', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                    'href' => 'https://bulk-editor.com/howto/can-i-select-products-and-add-15-to-their-regular-price/',
                    'title' => __('select products and add 15% to their regular price', 'woocommerce-bulk-editor'),
                    'target' => '_blank'
        )))
        ?>
    </li>

    <li><?php
        printf(__('How to %s by bulk operation', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                    'href' => 'https://bulk-editor.com/howto/how-to-remove-sale-prices-by-bulk-operation/',
                    'title' => __('remove sale prices', 'woocommerce-bulk-editor'),
                    'target' => '_blank',
                    'style' => 'color: red;'
        )))
        ?>
    </li>

    <li><?php
        printf(__('If your shop is on the Russian language you should install %s for the correct working of BEAR with Cyrillic', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                    'href' => 'https://ru.wordpress.org/plugins/cyr3lat/',
                    'title' => __('this plugin', 'woocommerce-bulk-editor'),
                    'target' => '_blank'
        )))
        ?>
    </li>


    <li><?php
        printf(__('How to set the same value for some products on the same time - %s', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                    'href' => 'https://bulk-editor.com/howto/how-to-set-the-same-value-for-some-products-on-the-same-time/',
                    'title' => __('binded editing', 'woocommerce-bulk-editor'),
                    'target' => '_blank'
        )))
        ?>
    </li>

    <li>
        <?php _e('Remember! "Sale price" can not be greater than "Regular price", never! So if "Regular price" is 0 - not possible to set "Sale price"!', 'woocommerce-bulk-editor') ?>
    </li>

    <li>
        <?php _e('Search by products slugs, which are in non-latin symbols does not work because in the data base they are keeps in the encoded format!', 'woocommerce-bulk-editor') ?>
    </li>


    <li>
        <?php _e('Click ID of the product in the products table to see it on the site front.', 'woocommerce-bulk-editor') ?>
    </li>


    <li>
        <?php _e('Use Enter keyboard button in the Products Editor for moving to the next products row cell with saving of changes while edit textinputs. Use arrow Up or arrow Down keyboard buttons in the Products Editor for moving to the next/previous products row without saving of changes.', 'woocommerce-bulk-editor') ?>
    </li>

    <li>
        <?php _e('To select range of products using checkboxes - select first product, press SHIFT key on your PC keyboard and click last product.', 'woocommerce-bulk-editor') ?>
    </li>

    <li><?php
        printf(__('If you have any ideas, you can suggest them on %s', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link(array(
                    'href' => 'https://pluginus.net/support/forum/woobe-woocommerce-bulk-editor-professional/',
                    'title' => __('the plugin forum', 'woocommerce-bulk-editor'),
                    'target' => '_blank'
        )))
        ?>
    </li>
</ol>


<hr />
<ul>
    <li style="padding: 7px; border: dashed 1px orange; border-radius: 3px; margin-bottom: 9px;">
        <?php
        printf(__('If you like BEAR %s about what you liked and what you want to see in future versions of the plugin', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link([
                    'href' => $WOOBE->show_notes ? 'https://wordpress.org/support/plugin/woo-bulk-editor/reviews/?filter=5#new-post' : 'https://codecanyon.net/downloads#item-21779835',
                    'target' => '_blank',
                    'title' => __('write us feedback please', 'woocommerce-bulk-editor'),
                    'class' => 'button button-primary',
                        //'style' => 'height: 21px; line-height: normal;'
        ]));
        ?>
    </li>
    <li style="padding: 7px; border: dashed 1px orange; border-radius: 3px; margin-bottom: 9px;">
        <?php
        printf(__('If you have an idea you can %s', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link([
                    'href' => 'https://pluginus.net/support/forum/woobe-woocommerce-bulk-editor-professional/',
                    'target' => '_blank',
                    'title' => __('share it with us here', 'woocommerce-bulk-editor'),
                    'class' => 'button button-primary',
                        //'style' => 'height: 21px; line-height: normal;'
        ]));
        ?>
    </li>
</ul>
<hr />

<h4><?php _e('Requirements', 'woocommerce-bulk-editor') ?>:</h4>
<ul>
    <li><?php _e('Recommended min RAM', 'woocommerce-bulk-editor') ?>: 256 MB</li>
    <li><?php _e('Minimal PHP version is', 'woocommerce-bulk-editor') ?>: PHP 5.4</li>
    <li><?php _e('Recommended PHP version', 'woocommerce-bulk-editor') ?>: 8.xx</li>
</ul><br />



<hr />
<h4><?php _e('Some useful plugins for your e-shop', 'woocommerce-bulk-editor') ?></h4>


<div class="col-lg-12">
    <a href="https://products-filter.com/" title="WOOF - WooCommerce Products Filter" target="_blank">
        <img width="150" src="<?php echo WOOBE_LINK ?>assets/images/woof_banner.png" alt="WOOF - WooCommerce Products Filter" />
    </a>

    <a href="https://currency-switcher.com/" title="WOOCS - WooCommerce Currency Switcher" target="_blank">
        <img width="150" src="<?php echo WOOBE_LINK ?>assets/images/woocs_banner.png" alt="WOOCS - WooCommerce Currency Switcher" />
    </a>

    <!-- <a href="https://alidropship.com/plugin/?via=4352" title="AliDropship is the best solution for drop shipping" target="_blank">
        <img width="150" src="<?php echo WOOBE_LINK ?>assets/images/drop-ship.jpg" alt="AliDropship is the best solution for drop shipping" />
    </a> -->
</div>

<div style="clear: both;"></div>


