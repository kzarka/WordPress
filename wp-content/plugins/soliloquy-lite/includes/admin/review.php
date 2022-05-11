<?php
/**
 * Review Class.
 *
 * @since 2.5.0
 * @package SoliloquyWP Lite
 * @author SoliloquyWP Team <support@soliloquywp.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Soliloquy Review
 *
 * @since 2.5.0
 */
class Soliloquy_Review {

	/**
	 * Holds the class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 2.5.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the review slug.
	 *
	 * @since 2.5.0
	 *
	 * @var string
	 */
	public $hook;

	/**
	 * Holds the base class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public $base;

	/**
	 * API Username.
	 *
	 * @since 2.5.0
	 *
	 * @var bool|string
	 */
	public $user = false;


	/**
	 * Primary class constructor.
	 *
	 * @since 2.5.0
	 */
	public function __construct() {

		$this->base = Soliloquy_Lite::get_instance();

		add_action( 'admin_notices', array( $this, 'review' ) );
		add_action( 'wp_ajax_soliloquy_dismiss_review', array( $this, 'dismiss_review' ) );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );

	}

	/**
	 * When user is on a Envira related admin page, display footer text
	 * that graciously asks them to rate us.
	 *
	 * @since
	 * @param string $text Text String to filter.
	 * @return string
	 */
	public function admin_footer( $text ) {
		global $current_screen;
		if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, 'soliloquy' ) !== false ) {
			$url = 'https://wordpress.org/support/plugin/soliloquy-lite/reviews/?filter=5#new-post';
			/* translators: %s: url*/
			$text = sprintf( __( 'Please rate <strong>Soliloquy</strong> <a href="%1$s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%2$s" target="_blank">WordPress.org</a> to help us spread the word. Thank you from the Soliloquy team!', 'soliloquy' ), $url, $url );
		}
		return $text;
	}

	/**
	 * Add admin notices as needed for reviews.
	 *
	 * @since 1.1.6.1
	 */
	public function review() {

	}

	/**
	 * Dismiss the review nag
	 *
	 * @since 1.1.6.1
	 */
	public function dismiss_review() {

		$review = get_option( 'soliloquy_review' );
		if ( ! $review ) {
			$review = array();
		}

		$review['time']      = time();
		$review['dismissed'] = true;

		update_option( 'soliloquy_review', $review );
		die();
	}

	/**
	 * Singleton Instance.
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Soliloquy_Review ) ) {
			self::$instance = new Soliloquy_Review();
		}

		return self::$instance;

	}
}

$soliloquy_review = Soliloquy_Review::get_instance();
