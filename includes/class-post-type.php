<?php
/**
 * Custom Post Type registration.
 *
 * @package Reusable_QR_Codes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Handles custom post type registration.
 */
class RQRC_Post_Type {

	/**
	 * Single instance of the class.
	 *
	 * @var RQRC_Post_Type
	 */
	private static $instance = null;

	/**
	 * Get single instance of the class.
	 *
	 * @return RQRC_Post_Type
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
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
	}

	/**
	 * Register the rqrc_item custom post type.
	 */
	public static function register_post_type() {
		$labels = array(
			'name'                  => _x( 'QR Codes', 'Post type general name', 'reusable-qr-codes' ),
			'singular_name'         => _x( 'QR Code', 'Post type singular name', 'reusable-qr-codes' ),
			'menu_name'             => _x( 'QR Codes', 'Admin Menu text', 'reusable-qr-codes' ),
			'name_admin_bar'        => _x( 'QR Code', 'Add New on Toolbar', 'reusable-qr-codes' ),
			'add_new'               => __( 'Add New', 'reusable-qr-codes' ),
			'add_new_item'          => __( 'Add New QR Code', 'reusable-qr-codes' ),
			'new_item'              => __( 'New QR Code', 'reusable-qr-codes' ),
			'edit_item'             => __( 'Edit QR Code', 'reusable-qr-codes' ),
			'view_item'             => __( 'View QR Code', 'reusable-qr-codes' ),
			'all_items'             => __( 'All QR Codes', 'reusable-qr-codes' ),
			'search_items'          => __( 'Search QR Codes', 'reusable-qr-codes' ),
			'parent_item_colon'     => __( 'Parent QR Codes:', 'reusable-qr-codes' ),
			'not_found'             => __( 'No QR codes found.', 'reusable-qr-codes' ),
			'not_found_in_trash'    => __( 'No QR codes found in Trash.', 'reusable-qr-codes' ),
			'featured_image'        => _x( 'QR Code Image', 'Overrides the "Featured Image" phrase', 'reusable-qr-codes' ),
			'set_featured_image'    => _x( 'Set QR code image', 'Overrides the "Set featured image" phrase', 'reusable-qr-codes' ),
			'remove_featured_image' => _x( 'Remove QR code image', 'Overrides the "Remove featured image" phrase', 'reusable-qr-codes' ),
			'use_featured_image'    => _x( 'Use as QR code image', 'Overrides the "Use as featured image" phrase', 'reusable-qr-codes' ),
			'archives'              => _x( 'QR Code archives', 'The post type archive label used in nav menus', 'reusable-qr-codes' ),
			'insert_into_item'      => _x( 'Insert into QR code', 'Overrides the "Insert into post" phrase', 'reusable-qr-codes' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this QR code', 'Overrides the "Uploaded to this post" phrase', 'reusable-qr-codes' ),
			'filter_items_list'     => _x( 'Filter QR codes list', 'Screen reader text for the filter links', 'reusable-qr-codes' ),
			'items_list_navigation' => _x( 'QR codes list navigation', 'Screen reader text for the pagination', 'reusable-qr-codes' ),
			'items_list'            => _x( 'QR codes list', 'Screen reader text for the items list', 'reusable-qr-codes' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'rqrc' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-smartphone',
			'supports'           => array( 'title' ),
			'show_in_rest'       => false,
		);

		register_post_type( 'rqrc_item', $args );
	}

	/**
	 * Custom update messages for the post type.
	 *
	 * @param array $messages Existing post update messages.
	 * @return array Modified post update messages.
	 */
	public function updated_messages( $messages ) {
		global $post;

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only display of WordPress core revision parameter.
		$messages['rqrc_item'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'QR Code updated successfully.', 'reusable-qr-codes' ),
			2  => __( 'Field updated.', 'reusable-qr-codes' ),
			3  => __( 'Field deleted.', 'reusable-qr-codes' ),
			4  => __( 'QR Code updated.', 'reusable-qr-codes' ),
			5  => isset( $_GET['revision'] ) ? sprintf(
				/* translators: %s: Revision date */
				__( 'QR Code restored to revision from %s.', 'reusable-qr-codes' ),
				wp_post_revision_title( absint( $_GET['revision'] ), false )
			) : false,
			6  => __( 'QR Code published successfully. Your QR code is now ready to use!', 'reusable-qr-codes' ),
			7  => __( 'QR Code saved.', 'reusable-qr-codes' ),
			8  => __( 'QR Code submitted.', 'reusable-qr-codes' ),
			9  => isset( $post->post_date ) ? sprintf(
				/* translators: %s: Scheduled date */
				__( 'QR Code scheduled for: <strong>%s</strong>', 'reusable-qr-codes' ),
				date_i18n( __( 'M j, Y @ g:i a', 'reusable-qr-codes' ), strtotime( $post->post_date ) )
			) : false,
			10 => __( 'QR Code draft updated.', 'reusable-qr-codes' ),
		);
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		return $messages;
	}
}
