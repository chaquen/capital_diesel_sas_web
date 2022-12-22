<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

global $WOOBE;
?>
<h4 style="margin-bottom: 2px;" class="woobe-documentation"><a href="https://bulk-editor.com/document/history/" target="_blank" class="button button-primary"><span class="icon-book"></span></a>&nbsp;<?php _e('History', 'woocommerce-bulk-editor') ?></h4>
<small style="font-style: italic;"><?php _e('Works for edit-operations and not work with delete-operations! Also does not work with all operations which are presented in "Variations Advanced Bulk Operations"', 'woocommerce-bulk-editor') ?></small><br />

<?php if ($WOOBE->show_notes) : ?>
    <span style="color: red;"><?php _e('In FREE version of the plugin it is possible to roll back 2 last operations.', 'woocommerce-bulk-editor') ?></span><br />
<?php endif; ?>

<br />
<div class="col-lg-6">
    <label for="woobe_history_pagination_number"><?php _e('Per page:', 'woocommerce-bulk-editor') ?></label>
    <select style="width: 50px;" id="woobe_history_pagination_number">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="-1"><?php _e('ALL', 'woocommerce-bulk-editor') ?></option>
    </select>
</div>
<div class="col-lg-6" style="text-align: right;">
    <a href="javascript: woobe_history_clear();void(0);" class="page-title-action"><?php _e('Clear the History', 'woocommerce-bulk-editor') ?></a>
</div>
<div style="clear: both;"></div>
<div class="col-lg-12 woobe_history_pagination_cont">

    <div class="col-lg-12 woobe_history_filters">
        <div class="col-lg-2">
            <select id="woobe_history_show_types">
                <option value="0"><?php _e('all', 'woocommerce-bulk-editor') ?></option>
                <option value="1"><?php _e('solo operations', 'woocommerce-bulk-editor') ?></option>
                <option value="2"><?php _e('bulk operations', 'woocommerce-bulk-editor') ?></option>
            </select>
        </div>
        <div class="col-lg-2" >
            <?php
            $opt_auth = array();
            $opt_auth[-1] = __('by Author', 'woocommerce-bulk-editor');
            $opt_auth = $opt_auth + WOOBE_HELPER::get_users();
            ?>
            <?php
            echo WOOBE_HELPER::draw_select(array(
                'options' => $opt_auth,
                'field' => '',
                'product_id' => "author",
                'class' => 'woobe_history_filter_author chosen-select',
                'name' => '',
                'field' => 'woobe_history_filter'
            ));
            ?>
        </div>
        <div class="col-lg-2" >
            <input type="text" onmouseover="woobe_init_calendar(this)" data-title="<?php _e('by date from', 'woocommerce-bulk-editor') ?>" data-val-id="woobe_history_filter_date_from" value="" class="woobe_calendar" placeholder="<?php _e('by date from', 'woocommerce-bulk-editor') ?>" />
            <input type="hidden" data-key="from" data-product-id="" id="woobe_history_filter_date_from" value=""  />            
            <a href="#" class="woobe_calendar_clear" data-val-id="woobe_history_filter_date_from" ><?php echo __('clear', 'woocommerce-bulk-editor') ?></a>
        </div>
        <div class="col-lg-2" >
            <input type="text" onmouseover="woobe_init_calendar(this)" data-title="<?php _e('by date to', 'woocommerce-bulk-editor') ?>" data-val-id="woobe_history_filter_date_to" value="" class="woobe_calendar" placeholder="<?php _e('by date to', 'woocommerce-bulk-editor') ?>" />
            <input type="hidden" data-key="from" data-product-id="" id="woobe_history_filter_date_to" value=""  />
            <a href="#" class="woobe_calendar_clear" data-val-id="woobe_history_filter_date_to"><?php echo __('clear', 'woocommerce-bulk-editor') ?></a>
        </div>
        <div class="col-lg-2" >
            <input type="text" id="woobe_history_filter_field" placeholder="<?php _e('by fields, use comma', 'woocommerce-bulk-editor') ?>" >
        </div>     
        <div class="col-lg-2" >
            <input type="button" id="woobe_history_filter_submit" class="button button-primary" value="<?php _e('Filter', 'woocommerce-bulk-editor') ?>">&nbsp;<input type="button" class="button button-primary" id="woobe_history_filter_reset" value="<?php _e('Reset', 'woocommerce-bulk-editor') ?>">
        </div>


    </div>
</div>    
<div style="clear: both;"></div>

<div id="woobe_history_list_container"></div>

<div id="woobe_history_pagination_container">
    <a href="#"class="woobe_history_pagination_prev" style="text-decoration: none;"><span class="dashicons dashicons-arrow-left-alt"></span><?php _e('Prev', 'woocommerce-bulk-editor') ?></a>
    <span class="woobe_history_pagination_current_count"></span><?php _e('of', 'woocommerce-bulk-editor') ?><span class="woobe_history_pagination_count"></span>
    <a href="#" class="woobe_history_pagination_next" style="text-decoration: none;"><?php _e('Next', 'woocommerce-bulk-editor') ?><span class="dashicons dashicons-arrow-right-alt"></span></a>
</div>

