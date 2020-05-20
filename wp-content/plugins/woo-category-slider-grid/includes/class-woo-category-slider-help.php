<?php
/**
 * The plugin help page.
 *
 * @link       https://shapedplugin.com/
 * @since      1.1.0
 *
 * @package    Woo_Category_Slider
 * @subpackage Woo_Category_Slider/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */
class Woo_Category_Slider_Help {

	/**
	 * Add SubMenu Page
	 */
	public function help_page() {
		add_submenu_page( 'edit.php?post_type=sp_wcslider', __( 'Category Slider for WooCommerce Help', 'woo-category-slider' ), __( 'Help', 'woo-category-slider' ), 'manage_options', 'wcsp_help', array( $this, 'help_page_callback' ) );
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		?>
		<div class="wrap about-wrap sp-wcsp-help">
			<h1><?php _e( 'Welcome to Category Slider for WooCommerce!', 'woo-category-slider' ); ?></h1>
			<p class="about-text">
			<?php
			_e( 'Thank you for installing Category Slider for WooCommerce! You\'re now running the most popular WooCommerce Category Slider plugin. This video will help you get started with the plugin.', 'woo-category-slider' );
			?>
				</p>
			<div class="wp-badge"></div>

			<hr>

			<div class="headline-feature feature-video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/U0IrQbAADm8" frameborder="0" allowfullscreen></iframe>
			</div>

			<hr>

			<div class="feature-section three-col">
				<div class="col">
					<div class="sp-wcsp-feature sp-wcsp-text-center">
						<i class="sp-wcsp-font fa fa-life-ring"></i>
						<h3>Need any Assistance?</h3>
						<p>Our Expert Support Team is always ready to help you out promptly.</p>
						<a href="https://shapedplugin.com/support-forum/" target="_blank" class="button button-primary">Contact Support</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wcsp-feature sp-wcsp-text-center">
						<i class="sp-wcsp-font fa fa-file-text" aria-hidden="true"></i>
						<h3>Looking for Documentation?</h3>
						<p>We have detailed documentation on every aspect of Category Slider for WooCommerce.</p>
						<a href="https://shapedplugin.com/docs/docs/woocommerce-category-slider/" target="_blank" class="button button-primary">Documentation</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wcsp-feature sp-wcsp-text-center">
						<i class="sp-wcsp-font fa fa-thumbs-up" aria-hidden="true"></i>
						<h3>Like This Plugin?</h3>
						<p>If you like Category Slider for WooCommerce, please leave us a 5 star rating.</p>
						<a href="https://wordpress.org/support/plugin/woo-category-slider-grid/reviews/?filter=5#new-post" target="_blank" class="button button-primary">Rate the Plugin</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}
