<?php
/**
 * Plugin Name: Category Listing for WooCommerce
 *
 * @author  AlexanderJuulJ <contact@alexanderjuulj.com>
 * @license GPL-2.0-or-later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Plugin URI: https://wc-catlisting.alexanderjuulj.com
 * Description: Creates a separate listing for your categories and subcategories on archive pages, so you do not mix products with categories.
 * Version: 1.0.1
 * Requires at least: 5.0
 * Requires PHP: 5.4
 * Author: Alexander Juul Jakobsen
 * Author URI: https://alexanderjuulj.com
 * Text Domain: category-listing-for-woocommerce
 * Domain Path: /languages
 * WC requires at least: 3.0.0
 * WC tested up to: 3.7.0
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if (defined('ABSPATH') === false) {
    exit;
}

/*
 * Create a function to show a title above the categories
 */

if (function_exists('clwc_add_category_title') === false) {

    function clwc_add_category_title($args=[])
    {
            $idofparent = get_queried_object_id();
            $args       = [ 'parent' => $idofparent ];
        
            $terms = get_terms('product_cat', $args);
        
        if (empty($terms) === false) {
            // Adding a simple h2 to divide the content with headlines.
            echo '<h2 class="category-listing-headline">';
                _e('Categories', 'category-listing-for-woocommerce');
            echo '</h2>';
        }//end if
        
    }//end clwc_add_category_title()

}

add_action('woocommerce_before_shop_loop', 'clwc_add_category_title', 39);

/*
 * Create a function to show categories on archive pages
 */

if (function_exists('category_listing_for_woocommerce') === false) {


    function category_listing_for_woocommerce($args=[])
    {
            $idofparent = get_queried_object_id();
            $args       = [ 'parent' => $idofparent ];

            $terms = get_terms('product_cat', $args);

        if (empty($terms) === false) {
            // Using an un-ordered list to show the categories.
            echo '<ul class="category-listing">';
            // Foreach spitting out a list element every time we have a category.
            foreach ($terms as $term) {
                echo '<li class="single-category-listing">';
                    // Spitting out the URL and putting the category slug as class for the a tag.
                    echo '<a href="'.esc_url(get_term_link($term)).'" class="'.$term->slug.'">';

                        // WooCommerce Category Thumbnail.
                        woocommerce_subcategory_thumbnail($term);

                        // Displaying the category name.
                        echo '<h2>'.$term->name.'</h2>';
                    echo '</a>';
                echo '</li>';
            }

                echo '</ul>';
        }//end if

    }//end category_listing_for_woocommerce()


}//end if

add_action('woocommerce_before_shop_loop', 'category_listing_for_woocommerce', 40);

/*
 * Create a function to show a title above the products
 */

if (function_exists('clwc_add_product_title') === false) {


    function clwc_add_product_title($args=[])
    {
        echo '<h2 class="product-listing-headline">';
            _e('Products', 'category-listing-for-woocommerce');
        echo '</h2>';

    }//end clwc_add_product_title()


}

add_action('woocommerce_before_shop_loop', 'clwc_add_product_title', 41);

/*
 * Create a function to register and enqueue styles for the plugin
 */

if (function_exists('category_listing_for_woocommerce_styles') === false) {


    function category_listing_for_woocommerce_styles()
    {
        // Register stylesheet.
        wp_register_style('category_listing_for_woocommerce_css', plugins_url('public/css/style.css', __FILE__));
        // Enqueue Stylesheet.
        wp_enqueue_style('category_listing_for_woocommerce_css');

    }//end category_listing_for_woocommerce_styles()


}

add_action('wp_enqueue_scripts', 'category_listing_for_woocommerce_styles');

/*
 * Load the plugin textdomain
 */

if (function_exists('category_listing_for_woocommerce_textdomain') === false) {


    function category_listing_for_woocommerce_textdomain()
    {
        load_plugin_textdomain('category-listing-for-woocommerce', false, basename(dirname(__FILE__)).'/languages');

    }//end category_listing_for_woocommerce_textdomain()


}

add_action('plugins_loaded', 'category_listing_for_woocommerce_textdomain');
