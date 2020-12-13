<?php
/**
 * Explore Admin Class.
 *
 * @author  ThemeGrill
 * @package Explore
 * @since   1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Explore_Admin' ) ) :

	/**
	 * Explore_Admin Class.
	 */
	class Explore_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'explore-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), EXPLORE_THEME_VERSION );

			wp_enqueue_script( 'explore-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), EXPLORE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&explore-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'explore' ),
				'nonce'    => wp_create_nonce( 'explore_demo_import_nonce' ),
			);

			wp_localize_script( 'explore-plugin-install-helper', 'exploreRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Explore_Admin();
