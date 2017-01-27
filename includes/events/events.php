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
		add_action( 'wp', array( $this, 'fix_sidebar_placement' ) );
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

	/**
	 * Fix Sidebar Placement on Single Events
	 * 
	 * @return void
	 */
	public function fix_sidebar_placement() {
		if ( ! is_singular( 'tribe_events' ) ) {
			return;
		}
		add_filter( 'body_class', function( array $classes ) {
			$classes[] = 'sidebar-left';
			return $classes;
		});
	}
}
