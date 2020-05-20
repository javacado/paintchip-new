<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The file that defines the woo category slider post type.
 *
 * @link       https://shapedplugin.com/
 * @since      1.1.0
 *
 * @package    Woo_Category_Slider
 * @subpackage Woo_Category_Slider/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */


/**
 * Custom post class to register the slider.
 */
class Woo_Category_Slider_Post_Type {

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.1.0
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since 1.0.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register Post Type for Category Slider
	 */
	public function register_post_type() {

		if ( post_type_exists( 'sp_wcslider' ) ) {
			return;
		}

		// Set the WordPress carousel post type labels.
		$labels = apply_filters(
			'woo_category_slider_post_type_labels',
			array(
				'name'               => esc_html__( 'All Category Sliders', 'woo-category-slider' ),
				'singular_name'      => esc_html__( 'Category Slider', 'woo-category-slider' ),
				'menu_name'          => esc_html__( 'Woo Cat Slider', 'woo-category-slider' ),
				'add_new'            => esc_html__( 'Add New', 'woo-category-slider' ),
				'add_new_item'       => esc_html__( 'Add New Slider', 'woo-category-slider' ),
				'edit'               => esc_html__( 'Edit', 'woo-category-slider' ),
				'edit_item'          => esc_html__( 'Edit Slider', 'woo-category-slider' ),
				'new_item'           => esc_html__( 'New Slider', 'woo-category-slider' ),
				'view'               => esc_html__( 'View Slider', 'woo-category-slider' ),
				'view_item'          => esc_html__( 'View Slider', 'woo-category-slider' ),
				'search_items'       => esc_html__( 'Search Slider', 'woo-category-slider' ),
				'not_found'          => esc_html__( 'No Category Slider Found', 'woo-category-slider' ),
				'not_found_in_trash' => esc_html__( 'No Category Slider Found in Trash', 'woo-category-slider' ),
				'parent'             => esc_html__( 'Parent Category Slider', 'woo-category-slider' ),
				'all_items'          => esc_html__( 'Manage Sliders', 'woo-category-slider' ),
			)
		);

		// Set the WordPress carousel post type arguments.
		$args = apply_filters(
			'woo_category_slider_post_type_args',
			array(
				'labels'              => $labels,
				'public'              => false,
				'has_archive'         => false,
				'publicaly_queryable' => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNy4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjEycHgiIGhlaWdodD0iNzkycHgiIHZpZXdCb3g9IjAgMCA2MTIgNzkyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MTIgNzkyIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjx0aXRsZT48L3RpdGxlPg0KPGcgaWQ9ImZvbGRlcl9maWx0ZXJfZmlsZV9mb2xkZXJfZG9jdW1lbnRfZm9ybWF0Ij4NCgk8cGF0aCBmaWxsPSIjOUZBNEE5IiBkPSJNNTUxLjA3MSwxOTIuNjA3SDI3NC42NmwtNzUuMjU1LTc1LjQ1OWMtMy44MzgtMy44MDctOS4wMzQtNS45My0xNC40NDEtNS44OThINjIuOTI5DQoJCWMtMzMuNjk5LDAtNjEuMDE4LDI3LjMxOS02MS4wMTgsNjEuMDE4djQ0Ny40NjRjMCwzMy42OTksMjcuMzE5LDYxLjAxOCw2MS4wMTgsNjEuMDE4aDQ4OC4xNDMNCgkJYzMzLjY5OSwwLDYxLjAxOC0yNy4zMTksNjEuMDE4LTYxLjAxOFYyNTMuNjI1QzYxMi4wODksMjE5LjkyNiw1ODQuNzcsMTkyLjYwNyw1NTEuMDcxLDE5Mi42MDd6IE04Mi4yNjgsMjMzLjI4NnY0MDYuNzg2SDYxLjkyOQ0KCQljLTExLjIzMywwLTIwLjMzOS05LjEwNy0yMC4zMzktMjAuMzM5VjE3Mi4yNjhjMC0xMS4yMzMsOS4xMDctMjAuMzM5LDIwLjMzOS0yMC4zMzloMTEzLjY5N2w0MC42NzksNDAuNjc5aC05My4zNTgNCgkJQzEwMC40OCwxOTIuNjA3LDgyLjI2OCwyMTAuODE5LDgyLjI2OCwyMzMuMjg2eiBNNTA5LjM5MywzMTQuNjQzaC0yMC4zMzl2NjEuMDE4Yy0wLjAyNyw0LjU4OC0xLjYwNCw5LjAzMi00LjQ3NCwxMi42MQ0KCQlsLTc2Ljg4Myw5Ni4yMDV2NTMuODk5Yy0wLjAyMyw3LjY1OS00LjM0NiwxNC42NTYtMTEuMTg3LDE4LjEwMmwtODEuMzU3LDQwLjY3OWMtMTAuMDMyLDUuMDU1LTIyLjI2MSwxLjAyMS0yNy4zMTYtOS4wMTENCgkJYy0xLjQyMS0yLjgyLTIuMTY2LTUuOTMzLTIuMTc2LTkuMDkxdi05NC41NzdsLTc2Ljg4Mi05Ni4yMDVjLTIuODcxLTMuNTc5LTQuNDQ4LTguMDIzLTQuNDc1LTEyLjYxMXYtNjEuMDE3aC0yMC4zMzkNCgkJYy0xMS4yMzMsMC0yMC4zMzktOS4xMDctMjAuMzM5LTIwLjMzOXM5LjEwNy0yMC4zMzksMjAuMzM5LTIwLjMzOWgzMjUuNDI5YzExLjIzMywwLDIwLjMzOSw5LjEwNywyMC4zMzksMjAuMzM5DQoJCVM1MjAuNjI1LDMxNC42NDMsNTA5LjM5MywzMTQuNjQzeiIvPg0KPC9nPg0KPHBhdGggZmlsbD0iI0NDMkI1RSIgZD0iTTY3Mi41LDIwMy41Ii8+DQo8L3N2Zz4NCg==',
				'hierarchical'        => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'menu_position'       => 56,
				'capability_type'     => 'post',
			)
		);

		register_post_type( 'sp_wcslider', $args );
	}
}
