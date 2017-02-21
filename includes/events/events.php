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

		add_filter( 'jetpack_relatedposts_filter_options', array( $this, 'suppress_related_posts' ) );
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

	/**
	 * Suppresses Jetpack Related Posts Module on Single Events
	 *
	 * @param  array $options An array of related posts options.
	 * @return array          Filtered array of options.
	 */
	public function suppress_related_posts( $options ) {
		if ( is_singular( 'tribe_events' ) ) {
			$options['enabled'] = false;
		}
		return $options;
	}
}
