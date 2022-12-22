<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function woobe_get_total_settings($data) {
    return array(
        'per_page' => array(
            'title' => __('Default products count per page', 'woocommerce-bulk-editor'),
            'desc' => sprintf(__('How many rows of products show per page in tab Products. Max possible value is 100! To set more - read %s please', 'woocommerce-bulk-editor'), WOOBE_HELPER::draw_link([
                        'href' => 'https://bulk-editor.com/howto/set-more-rows-of-products-per-page/',
                        'title' => __('this article', 'woocommerce-bulk-editor'),
                        'target' => '_blank'
            ])),
            'value' => '',
            'type' => 'number'
        ),
        'default_sort_by' => array(
            'title' => __('Default sort by', 'woocommerce-bulk-editor'),
            'desc' => __('Select column by which products sorting is going after plugin page loaded', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'select',
            'select_options' => $data['default_sort_by']
        ),
        'default_sort' => array(
            'title' => __('Default sort', 'woocommerce-bulk-editor'),
            'desc' => __('Select sort direction for Default sort by column above', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'select',
            'select_options' => array(
                'desc' => array('title' => 'DESC'),
                'asc' => array('title' => 'ASC')
            )
        ),
        'show_admin_bar_menu_btn' => array(
            'title' => __('Show button in admin bar', 'woocommerce-bulk-editor'),
            'desc' => __('Show Bulk Editor button in admin bar for quick access to the products editor', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'select',
            'select_options' => array(
                1 => array('title' => __('Yes', 'woocommerce-bulk-editor')),
                0 => array('title' => __('No', 'woocommerce-bulk-editor')),
            )
        ),
        'show_thumbnail_preview' => array(
            'title' => __('Show thumbnail preview', 'woocommerce-bulk-editor'),
            'desc' => __('Show bigger thumbnail preview on mouse over', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'select',
            'select_options' => array(
                1 => array('title' => __('Yes', 'woocommerce-bulk-editor')),
                0 => array('title' => __('No', 'woocommerce-bulk-editor')),
            )
        ),
        'load_switchers' => array(
            'title' => __('Load beauty switchers', 'woocommerce-bulk-editor'),
            'desc' => __('Load beauty switchers instead of checkboxes in the products table.', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'select',
            'select_options' => array(
                1 => array('title' => __('Yes', 'woocommerce-bulk-editor')),
                0 => array('title' => __('No', 'woocommerce-bulk-editor')),
            )
        ),
        'autocomplete_max_elem_count' => array(
            'title' => __('Autocomplete max count', 'woocommerce-bulk-editor'),
            'desc' => __('How many products display in the autocomplete drop-downs. Uses in up-sells, cross-sells and grouped popups.', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'number'
        ),
        'quick_search_fieds' => array(
            'title' => __('Add fields to the quick search', 'woocommerce-bulk-editor'),
            'desc' => __('Adds more fields to quick search fields drop-down on the tools panel. Works only for text fields. Syntax: post_name:Product slug,post_content: Content', 'woocommerce-bulk-editor'),
            'value' => '',
            'type' => 'text'
        ),
     
    );
}
