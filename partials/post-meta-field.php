<?php

/**
 * WooPDOC admin post meta box
 *
 * @since      1.0.0
 * @package    WooProductDescriptionOverCategory
 * @author     Octavian Popa <office@sprintsoft.ro>
 */

defined('WPINC') || exit;
?>
<style>
    .wooPDOC-taxonomy {
        min-width: auto;
        overflow: hidden;
    }
</style>
<div>
    <?php
    woocommerce_wp_select(
        array(
            'id'            => "wooPDOC{$loop}",
            'name'          => "wooPDOC_category[{$loop}]",
            'value'         => $variation->price_type,
            'label'         => __('Selecteaza Categoria', 'woocommerce'),
            'options'       => $categs_list,
            'desc_tip'      => true,
            'description'   => __('Selecteaza categoria a caror produse vrei sa modifici descrierea.', 'woocommerce'),
            'wrapper_class' => 'form-row form-row-full variation_price_type',
        )
    );
    ?>
</div>

<div class="toolbar toolbar-buttons">
    <button type="button" class="button woopdoc_save_to_all_products button-primary" data-post_id="<?php echo $post->ID; ?>"><?php esc_html_e('Salveaza pe toate produsele din categorie', 'woocommerce'); ?></button>
</div>
<?php wp_nonce_field('wooPDOC_data', 'wooPDOC_nonce'); ?>