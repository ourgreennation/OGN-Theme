<?php
/**
 * Groups Customizations
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Groups
 */

namespace Lift\OGN\Theme;

/**
 * Class: Groups
 *
 * Customizes the OGN Groups Experience.
 *
 * @since  v1.2.0
 */
final class Groups {

	/**
	 * Register Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'wp', array( $this, 'force_login_to_view_groups' ) );
	}

	/**
	 * Force Users to be Logged In to View Groups
	 *
	 * @uses  is_user_logged_in()
	 * @uses  is_buddypress()
	 * @uses  bp_is_groups_component()
	 * @uses  wp_safe_redirect()
	 * @uses  wp_login_url()
	 * @uses  get_permalink()
	 * @uses  get_queried_object_id()
	 * 
	 * @since  v1.2.0
	 * @return void
	 */
	public function force_login_to_view_groups() {
		if ( ! is_user_logged_in() && is_buddypress() && bp_is_groups_component() ) {
			wp_safe_redirect( wp_login_url( get_permalink( get_queried_object_id() ) ) );
			exit;
		}
	}
}