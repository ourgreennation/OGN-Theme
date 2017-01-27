<?php
/**
 * Events Customizations
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Events
 */

namespace Lift\OGN\Theme;

/**
 * Class: Events
 *
 * Customizes the OGN Events Experience.
 *
 * @since  v1.2.0
 */
final class Events {

	/**
	 * Register Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'wp', array( $this, 'show_footer' ) );
	}

	/**
	 * Show Footer
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function show_footer() {
		if ( is_post_type_archive( 'tribe_events' ) ) {
			add_filter( 'onesocial_show_footer', '__return_true' );
		}
	}
}
