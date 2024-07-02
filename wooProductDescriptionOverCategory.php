<?php

/**
 * Plugin Name: WooProductDescriptionOverCategory
 * Description:Load description from one product to all products from specific Category
 * Version: 1.0
 * Author: Octavian Popa
 * Author URI: http://www.sprintsoftteam.com
 *
 * Requires at least: 4.4
 *
 * WC requires at least: 2.6.0
 * 
 */



if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Define constants.
 */
define('WooPDOC_VERSION', '1.0.0');
define('WooPDOC_SLUG', 'wooProductDescriptionOverCategory');

add_action('add_meta_boxes', 'woopdoc_product_description', 100, 2);
add_action('wp_ajax_woopdoc_save_to_all_products', 'woopdoc_save_to_all_products');

function
woopdoc_product_description($post_type, $post)
{
    global $woocommerce, $post;
    // echo '<div class=" product_custom_field ">Hai ca mergem la piata</div>';
    add_meta_box(
        'woopdoc_meta_box',
        __('Generare descriere pe toate produsele din categorie', 'woocommerce'),
        'add_woopdoc_meta_box',
        'product',
        'normal',
        'high'
    );
}

function woopdoc_save_to_all_products()
{
    $data = [];

    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $category = get_term($category_id, 'product_cat');
    $data['message'] = 'Descrierea o fost salvata pe toate produsele din categoria: ' . $category->name;

    // get all product from category
    $products = wc_get_products([
        'category' => $category->slug
    ]);

    foreach ($products as $key => $product) {
        $product->set_description($description);
        $product->save();
    }

    wp_send_json($data);
}

//  Custom metabox content in admin product pages
function add_woopdoc_meta_box($post)
{

    $metadata = array(
        'view'         => '',
    );

    // $categs = get_terms();
    $categs =
        get_categories(array(
            'taxonomy'     => 'product_cat',
            'orderby'      => 'name',
            'pad_counts'   => false,
            'hierarchical' => 1,
            'hide_empty'   => true
        ));;
    $categs_list = ['Selecteaza o categorie'];
    foreach ($categs as $key => $categ) {
        $categs_list[$categ->term_id] = $categ->name;
    }

    ob_start();
    include __DIR__ . '/partials/post-meta-field.php';
    $metabox_output = ob_get_clean();
    echo apply_filters('wpdoc_metabox_output', $metabox_output, $post, $metadata);

    wp_register_script('woopdoc-admin', plugins_url("public/js/wooPDOC.js", __FILE__), array(), WooPDOC_VERSION, 'all');
    echo wp_enqueue_script('woopdoc-admin');

    wp_localize_script('woopdoc-admin', 'ajax_url', admin_url('admin-ajax.php'));
}
