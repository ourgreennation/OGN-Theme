<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Our_Green_Nation
 */

// if ( ! is_active_sidebar( 'sidebar-1' ) ) {
// 	return;
// }

echo '<aside id="secondary" class="widget-area" role="complementary">';

	// We're going to have a few sidebars for specific page types not covered in the WP template hierarchy

	if( is_search() ) {
		// If we're on a search page
		dynamic_sidebar( 'sidebar-search' );
	} elseif( bp_is_group() || bp_is_user_groups() || bp_is_groups_component() ) {
		// If we're on a BuddyPress group page
		dynamic_sidebar( 'sidebar-buddypress-group' );
	} elseif( bp_is_user_profile() || bp_is_member() ) {
		// If we're on a BuddyPress profile page
		dynamic_sidebar( 'sidebar-buddypress-profile' );
	} elseif( bp_is_user_activity() ) {
		// If we're on a BuddyPress activity page
		dynamic_sidebar( 'sidebar-buddypress-activity' );
	} elseif( tribe_is_event() ) {
		// If we're on a BuddyPress activity page
		dynamic_sidebar( 'sidebar-events' );
	} else {
		// For any other page
		dynamic_sidebar( 'sidebar-1' );
	}

echo '</aside>';
