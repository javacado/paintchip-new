<?php
/**
 * Fired during plugin updates
 *
 * @link       https://shapedplugin.com/
 * @since      1.2.1
 *
 * @package    Woo_Category_Slider
 * @subpackage Woo_Category_Slider/includes
 */

// don't call the file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin updates.
 *
 * This class defines all code necessary to run during the plugin's updates.
 *
 * @since      1.2.1
 * @package    Woo_Category_Slider
 * @subpackage Woo_Category_Slider/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */
class Woo_Category_Slider_Updates {

	/**
	 * DB updates that need to be run
	 *
	 * @var array
	 */
	private static $updates = [
		'1.2.1' => 'updates/update-1.2.1.php',
	];

	/**
	 * Binding all events
	 *
	 * @since 1.2.1
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'do_updates' ) );
	}

	/**
	 * Check if need any update
	 *
	 * @since 1.2.1
	 *
	 * @return boolean
	 */
	public function is_needs_update() {
		$installed_version = get_option( 'woo_category_slider_version' );

		if ( false === $installed_version ) {
			update_option( 'woo_category_slider_version', '1.2.1' );
			update_option( 'woo_category_slider_db_version', '1.2.1' );
		}

		if ( version_compare( $installed_version, SP_WCS_VERSION, '<' ) ) {
			return true;
		}

		return false;
	}



	/**
	 * Do updates.
	 *
	 * @since 1.2.1
	 *
	 * @return void
	 */
	public function do_updates() {
		$this->perform_updates();
	}

	/**
	 * Perform all updates
	 *
	 * @since 1.2.1
	 *
	 * @return void
	 */
	public function perform_updates() {
		if ( ! $this->is_needs_update() ) {
			return;
		}

		$installed_version = get_option( 'woo_category_slider_version' );

		foreach ( self::$updates as $version => $path ) {
			if ( version_compare( $installed_version, $version, '<' ) ) {
				include $path;
				update_option( 'woo_category_slider_version', $version );
			}
		}

		update_option( 'woo_category_slider_version', SP_WCS_VERSION );

	}

}
new Woo_Category_Slider_Updates();
