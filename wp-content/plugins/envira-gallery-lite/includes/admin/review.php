<?php
/**
 * Review class.
 *
 * @since 1.1.4.5
 *
 * @package envira
 * @author  Devin Vinson
 */
class Envira_Lite_Review {

	/**
	 * Holds the class object.
	 *
	 * @since 1.1.4.5
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.1.4.5
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the review slug.
	 *
	 * @since 1.1.4.5
	 *
	 * @var string
	 */
	public $hook;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.1.4.5
	 *
	 * @var object
	 */
	public $base;

	/**
	 * API Username.
	 *
	 * @since 1.1.4.5
	 *
	 * @var bool|string
	 */
	public $user = false;


	/**
	 * Primary class constructor.
	 *
	 * @since 1.1.4.5
	 */
	public function __construct() {

		$this->base = Envira_Gallery_Lite::get_instance();

		add_action( 'admin_notices', array( $this, 'review' ) );
		add_action( 'wp_ajax_envira_dismiss_review', array( $this, 'dismiss_review' ) );
        add_filter( 'admin_footer_text',     array( $this, 'admin_footer'   ), 1, 2 );

	}

	/**
	 * When user is on a Envira related admin page, display footer text
	 * that graciously asks them to rate us.
	 *
	 * @since
	 * @param string $text
	 * @return string
	 */
	public function admin_footer( $text ) {
		return '';
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

		$review = get_option( 'envira_gallery_review' );
		if ( ! $review ) {
			$review = array();
		}

		$review['time']      = time();
		$review['dismissed'] = true;

		update_option( 'envira_gallery_review', $review );
		die;
	}


	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Envira_Lite_Review ) ) {
			self::$instance = new Envira_Lite_Review();
		}

		return self::$instance;

	}
}

$envira_lite_review = Envira_Lite_Review::get_instance();