<?php
/**
 * Main plugin class.
 *
 * @package Reusable_QR_Codes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main plugin class - handles core functionality.
 */
class RQRC_Plugin {

	/**
	 * Single instance of the class.
	 *
	 * @var RQRC_Plugin
	 */
	private static $instance = null;

	/**
	 * Get single instance of the class.
	 *
	 * @return RQRC_Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		// Add plugin action links.
		add_filter( 'plugin_action_links_' . RQRC_PLUGIN_BASENAME, array( $this, 'add_action_links' ) );
	}

	/**
	 * Add settings link to plugin actions.
	 *
	 * @param array $links Existing plugin action links.
	 * @return array Modified plugin action links.
	 */
	public function add_action_links( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'edit.php?post_type=rqrc_item&page=rqrc-settings' ) ),
			esc_html__( 'Settings', 'reusable-qr-codes' )
		);

		array_unshift( $links, $settings_link );

		return $links;
	}
}
