<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}// if direct access

/**
 * Functions
 */
class WPL_WCS_Functions {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		// Post thumbnails.
		add_image_size( 'wpl-wcs-cat-img', 360, 400, true );
		add_image_size( 'wpl-wcs-cat-img-two', 300, 170, true );
		add_action( 'in_admin_header', array( $this, 'wpl_wcs_admin_banner' ) );
		add_filter( 'screen_options_show_screen', array( $this, 'wpl_wcs_remove_screen_options' ), 10, 2 );
	}

	function wpl_wcs_admin_banner() {
		$screen = get_current_screen();
		if ( 'wpl_wcslider' == $screen->post_type ) { ?>
		<div class="wpl-wcs-framework wpl-wcs-banner-area">
			<div class="wpl-wcs-banner">
				<div class="wpl-wcs-logo"><img src="<?php echo WPL_WCS_URL . 'admin/assets/images/wcs-logo.png' ?>" alt="Category Slider for WooCommerce"></div>
				<div class="wpl-wcs-short-links">
					<a href="https://shapedplugin.com/support-forum/" target="_blank"><span><i class="fa fa-question"></i></span>Help</a>
				</div>
			</div>
		</div>
		<?php }
	}

	function wpl_wcs_remove_screen_options( $display_boolean, $wp_screen_object ) {
		$screen = get_current_screen();
		if ( 'wpl_wcslider' == $screen->post_type ) {
			$wp_screen_object->render_screen_layout();
			$wp_screen_object->render_per_page_options();
			return false;
		}
		return true;
	}

}

new WPL_WCS_Functions();
