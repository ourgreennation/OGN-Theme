<?php
/**
 * Posts Customizations
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Posts
 */

namespace Lift\OGN\Theme;

/**
 * Class: Posts
 *
 * Customizes the OGN Posts Experience.
 *
 * @since  v1.2.0
 */
final class Posts {

	/**
	 * Register Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'wp', array( $this, 'fix_obm_share' ) );
		add_filter( 'comments_open', array( $this, 'page_comments' ) );
	}

	/**
	 * Fix OBM Share button
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function fix_obm_share() {
		if ( is_single() && class_exists( 'OBM_BP_Reshare' ) ) {
			remove_action( 'the_content', 'obm_bp_reshare_single_content', 25 );
			add_action( 'the_content', array( $this, 'obm_share_modified' ), 25 );
		}
	}

	/**
	 * OBM Share Modified
	 *
	 * @since  v1.2.0
	 * @param  string $content Post content.
	 * @return string          Post content with fixed share button if necessary
	 */
	public function obm_share_modified( $content ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		// Check if a user belongs to a group.
		$in_group = (bool) count( groups_get_user_groups( bp_loggedin_user_id() )['groups'] );

		// Check if a user has friends.
		$has_friends = (bool) friends_get_friend_count_for_user( bp_loggedin_user_id() );

		// If a user has friends or is in a group, re-add the reshare button.
		if ( $in_group ||  $has_friends ) {
			$reshare = obm_bp_reshare_get_reshare_container();

			// If a user has no friends, hide that button.
			if ( ! $has_friends ) {
				$element = '<li class="reshare-activity reshare-friend">';
				$hide = '<li class="reshare-activity reshare-friend" style="display:none;">';
				$reshare = str_replace( $element, $hide, $reshare );
			}

			// If a user isn't in a group, hide that button.
			if ( ! $in_group ) {
				$element = '<li class="reshare-activity reshare-group">';
				$hide = '<li class="reshare-activity reshare-group" style="display:none;">';
				$reshare = str_replace( $element, $hide, $reshare );
			}

			// Add reshare button, modified if a condition is met, otherwise as is.
			$content = $content . $reshare;
		}

		// Yield the content with a reshare button if a user can share to either a freind or group.
		return $content;
	}

	/**
	 * Page Comments
	 *
	 * @since  v1.2.0
	 * @param  bool         $is_open Whether the comments are open or closed.
	 * @param  int|\WP_Post $post    Post ID or WP_Post object.
	 * @return bool                  False if the current query is for a page. Otherwise returns
	 *                               the value it was passed.
	 */
	public function page_comments( $is_open, $post ) {
		if ( is_page( $post ) ) {
			return false;
		}
		return $is_open;
	}
}
