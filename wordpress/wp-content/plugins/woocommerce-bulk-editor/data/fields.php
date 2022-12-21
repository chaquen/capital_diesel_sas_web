<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function woobe_get_fields() {
    static $shipping_class = array();

    if ($shipping_class === array()) {
        $shipping_class[-1] = __('No shipping class', 'woocommerce-bulk-editor');
        $terms = get_terms(array(
            'taxonomy' => 'product_shipping_class',
            'hide_empty' => false,
        ));

        if (!empty($terms)) {
            foreach ($terms as $term) {
                $shipping_class[intval($term->term_id)] = $term->name;
            }
        }
    }

    //***

    $wc_get_product_types = wc_get_product_types();
    foreach ($wc_get_product_types as $key => $t) {
        $wc_get_product_types[$key] = trim(str_replace('product', '', $t));
    }

    //***

    static $users = array();

    if ($users === array()) {
        $users = WOOBE_HELPER::get_users();
    }
    //***

    return apply_filters('woobe_extend_fields', array(
        '__checker' => array(
            'show' => 1, //this is special checkbox only for functionality
            'title' => WOOBE_HELPER::draw_checkbox(array('class' => 'all_products_checker')),
            'desc' => __('Checkboxes for the products selection. Use SHIFT button on your keyboard to select multiple rows.', 'woocommerce-bulk-editor'),
            'field_type' => 'none',
            'type' => 'number',
            'editable' => FALSE,
            'edit_view' => 'checkbox',
            'order' => FALSE,
            'move' => FALSE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        ),
        'ID' => array(
            'show' => 1, //1 - enabled here by default
            'title' => 'ID',
            'field_type' => 'field',
            'type' => 'number',
            'editable' => FALSE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'move' => FALSE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        ),
        '_thumbnail_id' => array(
            'show' => 1,
            'title' => __('Thumbnail', 'woocommerce-bulk-editor'),
            'field_type' => 'meta',
            'type' => 'number',
            'editable' => true,
            'edit_view' => 'thumbnail',
            'order' => FALSE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'gallery' => array(
            'show' => 0,
            'title' => __('Gallery', 'woocommerce-bulk-editor'),
            'desc' => __('Select any images which relate to the product', 'woocommerce-bulk-editor'),
            'field_type' => 'gallery',
            'type' => 'textinput',
            'editable' => true,
            'edit_view' => 'gallery_popup_editor',
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'post_title' => array(
            'show' => 1,
            'title' => __('Title', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'direct' => TRUE,
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        //'allow_product_types' => array('simple', 'external', 'variable', 'grouped')
        ),
        'post_content' => array(
            'show' => 1,
            'title' => __('Description', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'popupeditor',
            'order' => FALSE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        ),
        'post_excerpt' => array(
            'show' => 1,
            'title' => __('Short Desc.', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'popupeditor',
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'post_name' => array(
            'show' => 0,
            'title' => __('Slug', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'urldecode',
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'product_type' => array(
            'show' => 1,
            'title' => __('Type', 'woocommerce-bulk-editor'),
            'field_type' => 'taxonomy',
            'taxonomy' => 'product_type',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => $wc_get_product_types,
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'shop_manager_visibility' => 1
        ),
        'post_status' => array(
            'show' => 1,
            'title' => __('Status', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => apply_filters('woobe_product_statuses', get_post_statuses()),
            'order' => FALSE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        //'prohibit_product_types' => array('variation'),
        //'css_classes' => 'not-for-variations'
        ),
        'catalog_visibility' => array(
            'show' => 0,
            'title' => __('Catalog Visibility', 'woocommerce-bulk-editor'),
            'desc' => __('This setting determines which shop pages products will be listed on', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => wc_get_product_visibility_options(),
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'featured' => array(
            'show' => 0,
            'title' => __('Featured', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'regular_price' => array(
            'show' => 1,
            'title' => __('Regular price', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_regular_price',
            'type' => 'number',
            'sanitize' => 'floatval',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('external', 'simple', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'sale_price' => array(
            'show' => 1,
            'title' => __('Sale price', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_sale_price',
            'type' => 'number',
            'sanitize' => 'floatval',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('external', 'simple', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'date_on_sale_from' => array(
            'show' => 0,
            'title' => __('Sale time from', 'woocommerce-bulk-editor'),
            'desc' => __('The sale will end at the beginning of the set date', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_sale_price_dates_from',
            'type' => 'timestamp', //timestamp, unix
            'set_day_end' => FALSE, //false: 00:00:00, true: 23:59:59 - disabled in the code
            'editable' => TRUE,
            'edit_view' => 'calendar',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('external', 'simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'date_on_sale_to' => array(
            'show' => 0,
            'title' => __('Sale time to', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_sale_price_dates_to',
            'type' => 'timestamp', //timestamp, unix
            'set_day_end' => TRUE, //sale will end at the beginning of the set date - disabled in the code
            'editable' => TRUE,
            'edit_view' => 'calendar',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('external', 'simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'downloadable' => array(
            'show' => 0,
            'title' => __('Downloadable', 'woocommerce-bulk-editor'),
            'desc' => __('Downloadable products give access to a file upon purchase.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_downloadable',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'download_files' => array(
            'show' => 0,
            'title' => __('Down.Files', 'woocommerce-bulk-editor'),
            'desc' => __('Downloadable files. Attention: maybe should be enabled Downloadable by logic!', 'woocommerce-bulk-editor'),
            'field_type' => 'downloads',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'downloads_popup_editor',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'download_limit' => array(
            'show' => 0,
            'title' => __('Download limit', 'woocommerce-bulk-editor'),
            'desc' => __('Leave blank for unlimited re-downloads.  Attention: maybe should be enabled Downloadable by logic!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'download_expiry' => array(
            'show' => 0,
            'title' => __('Download expiry', 'woocommerce-bulk-editor'),
            'desc' => __('Enter the number of days before a download link expires, or leave blank. Attention: maybe should be enabled Downloadable by logic!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'tax_status' => array(
            'show' => 0,
            'title' => __('Tax status', 'woocommerce-bulk-editor'),
            'desc' => __('Define whether or not the entire product is taxable, or just the cost of shipping it.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => FALSE,
            'edit_view' => 'select',
            'select_options' => array(//there is no special func to get this array (30-11-2017)
                'taxable' => __('Taxable', 'woocommerce'),
                'shipping' => __('Shipping only', 'woocommerce'),
                'none' => __('None', 'woocommerce'),
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'external', 'variable'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'tax_class' => array(
            'show' => 0,
            'title' => __('Tax class', 'woocommerce-bulk-editor'),
            'desc' => __('Choose a tax class for this product. Tax classes are used to apply different tax rates specific to certain types of product.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => wc_get_product_tax_class_options() + array('parent' => __('Same as parent', 'woocommerce-bulk-editor')),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'external', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'sku' => array(
            'show' => 1,
            'title' => __('SKU', 'woocommerce-bulk-editor'),
            'desc' => __('SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_sku',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        ),
        'manage_stock' => array(
            'show' => 1,
            'title' => __('Manage stock', 'woocommerce-bulk-editor'),
            'desc' => __('Enable stock management at product level. ATTENTION: if to set count of products in Stock quantity, Manage stock option automatically set as TRUE!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_manage_stock',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => true,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'stock_quantity' => array(
            'show' => 1,
            'title' => __('Stock quantity', 'woocommerce-bulk-editor'),
            'desc' => __('Stock quantity. If this is a variable product this value will be used to control stock for all variations, unless you define stock at variation level. ATTENTION: if to set count of products, Manage stock and Stock status options automatically set as TRUE!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_stock',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'stock_status' => array(
            'show' => 1,
            'title' => __('Stock status', 'woocommerce-bulk-editor'),
            'desc' => __('Controls whether or not the product is listed as in stock or out of stock on the frontend. Count products in stock can not be zero while activating!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_stock_status',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => wc_get_product_stock_status_options(),
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'grouped', 'variation'),
            'shop_manager_visibility' => 1
        ),
        'backorders' => array(
            'show' => 0,
            'title' => __('Allow backorders', 'woocommerce-bulk-editor'),
            'desc' => __('If managing stock, this controls whether or not backorders are allowed. If enabled, stock quantity can go below 0. Does Not work if the product Manage stock option is not activated!', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => wc_get_product_backorder_options(),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'sold_individually' => array(
            'show' => 0,
            'title' => __('Sold individually', 'woocommerce-bulk-editor'),
            'desc' => __('Enable this to only allow one of this item to be bought in a single order', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_sold_individually',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'weight' => array(
            'show' => 0,
            'title' => __('Weight', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_weight',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'floatval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'length' => array(
            'show' => 0,
            'title' => __('Length', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_length',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'floatval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'width' => array(
            'show' => 0,
            'title' => __('Width', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_width',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'floatval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'height' => array(
            'show' => 0,
            'title' => __('Height', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_height',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'floatval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'product_shipping_class' => array(
            'show' => 0,
            'title' => __('Shipping class', 'woocommerce-bulk-editor'),
            'desc' => __('Shipping classes are used by certain shipping methods to group similar products.', 'woocommerce-bulk-editor'),
            'field_type' => 'taxonomy',
            'taxonomy' => 'product_shipping_class',
            'type' => 'array',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => $shipping_class,
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable', 'variation'),
            'css_classes' => '',
            'shop_manager_visibility' => 1
        ),
        'upsell_ids' => array(
            'show' => 0,
            'title' => __('Upsells', 'woocommerce-bulk-editor'),
            'desc' => __('Upsells are products which you recommend instead of the currently viewed product, for example, products that are more profitable or better quality or more expensive.', 'woocommerce-bulk-editor'),
            'field_type' => 'upsells',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'upsells_popup_editor',
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'cross_sell_ids' => array(
            'show' => 0,
            'title' => __('Cross-sells', 'woocommerce-bulk-editor'),
            'desc' => __('Cross-sells are products which you promote in the cart, based on the current product.', 'woocommerce-bulk-editor'),
            'field_type' => 'cross_sells',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'cross_sells_popup_editor',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'grouped_ids' => array(
            'show' => 0,
            'title' => __('Grouped products', 'woocommerce-bulk-editor'),
            'desc' => __('This lets you choose which products are part of this group.', 'woocommerce-bulk-editor'),
            'field_type' => 'grouped',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'grouped_popup_editor',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('grouped'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'purchase_note' => array(
            'show' => 0,
            'title' => __('Purchase note', 'woocommerce-bulk-editor'),
            'desc' => __('Enter an optional note to send the customer after purchase.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'popupeditor',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variable'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'menu_order' => array(
            'show' => 0,
            'title' => __('Menu order', 'woocommerce-bulk-editor'),
            'desc' => __('Custom ordering position.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'number',
            'sanitize' => 'intval',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => TRUE,
            'direct' => TRUE,
            'shop_manager_visibility' => 1
        //'prohibit_product_types' => array('variation'),
        //'css_classes' => 'not-for-variations'
        ),
        'reviews_allowed' => array(
            'show' => 0,
            'title' => __('Reviews allowed', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'product_url' => array(
            'show' => 0,
            'title' => __('Product url', 'woocommerce-bulk-editor'),
            'desc' => __('External/Affiliate product: External URL to the product', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'url',
            'sanitize' => 'esc_url',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('external'), //for another product types will be not possible to edit value in this column
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'button_text' => array(
            'show' => 0,
            'title' => __('Aff.Button text', 'woocommerce-bulk-editor'),
            'desc' => __('External/Affiliate product: This text will be shown on the button linking to the external product', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('external'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'virtual' => array(
            'show' => 0,
            'title' => __('Virtual', 'woocommerce-bulk-editor'),
            'desc' => __('Virtual products are intangible and are not shipped.', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'switcher',
            'select_options' => array(
                'yes' => __('Yes', 'woocommerce-bulk-editor'), //true
                'no' => __('No', 'woocommerce-bulk-editor'), //false
            ),
            'order' => FALSE,
            'direct' => TRUE,
            'allow_product_types' => array('simple', 'variation'),
            'shop_manager_visibility' => 1,
            'css_classes' => '',
        ),
        'post_author' => array(
            'show' => 0,
            'title' => __('Author', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'select',
            'select_options' => $users,
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'attribute_visibility' => array(
            'show' => 0,
            'title' => __('Attribute visibility', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'string',
            'editable' => TRUE,
            'edit_view' => 'attr_visibility',
            'order' => FALSE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'total_sales' => array(
            'show' => 0,
            'title' => __('Total sales', 'woocommerce-bulk-editor'),
            'desc' => __('Total count of the product sales', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => 'total_sales',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => TRUE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'review_count' => array(
            'show' => 0,
            'title' => __('Review count', 'woocommerce-bulk-editor'),
            'desc' => __('How many times the products been reviewed by customers', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_wc_review_count',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => TRUE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'average_rating' => array(
            'show' => 0,
            'title' => __('Average rating', 'woocommerce-bulk-editor'),
            'desc' => __('Average rating of the product', 'woocommerce-bulk-editor'),
            'field_type' => 'prop',
            'meta_key' => '_wc_average_rating',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'floatval',
            'order' => TRUE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        /*
          'rating_counts' => array(
          'show' => 0,
          'title' => __('Rating counts', 'woocommerce-bulk-editor'),
          'desc' => __('Rating counts of the product. Attention: This is keeps in the DataBase as array! Use comma, for example: 5,5,3,4', 'woocommerce-bulk-editor'),
          'field_type' => 'prop',
          'type' => 'string',
          'editable' => TRUE,
          'direct'=>TRUE,
          'edit_view' => 'textinput',
          'sanitize' => 'array',
          'order' => FALSE
          ),
         */
        'post_date' => array(
            'show' => 0,
            'title' => __('Date Published', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'timestamp', //timestamp, unix
            'set_day_end' => FALSE, //false: 00:00:00, true: 23:59:59
            'editable' => TRUE,
            'edit_view' => 'calendar',
            'order' => TRUE,
            'direct' => TRUE,
            'prohibit_product_types' => array('variation'),
            'css_classes' => 'not-for-variations',
            'shop_manager_visibility' => 1
        ),
        'post_parent' => array(
            'show' => 0,
            'title' => __('Parent', 'woocommerce-bulk-editor'),
            'field_type' => 'field',
            'type' => 'number',
            'editable' => TRUE,
            'edit_view' => 'textinput',
            'sanitize' => 'intval',
            'order' => TRUE,
            'direct' => TRUE,
            'allow_product_types' => array('variation'),
            'shop_manager_visibility' => 1
        )
    ));
}
