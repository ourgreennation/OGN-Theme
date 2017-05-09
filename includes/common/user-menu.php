<?php
/**
 * User Menu
 *
 * This file registers extra menu items in the BuddyPress Admin bar area.
 * The parent theme functions are located at /onesocial/buddyboss-inc/theme-functions.php
 *
 * @package OneSocial Child Theme
 */

/**
 * Add Dashboard Links
 *
 * Add Dashboard Menu Items to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_dash() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$wp_admin_bar->add_menu( array(
		'parent'  => $bp->my_account_menu_id,
		'id'      => 'wp-admin-bar-my-account-dash',
		'title'   => __( 'Dashboard', 'ogn' ),
		'href'    => trailingslashit( admin_url() ),
		'meta'    => array(
			'class' => 'wp-admin-bar-dashboard menupop',
		),
	) );

	$wp_admin_bar->add_menu( array(
		'parent'  => 'wp-admin-bar-my-account-dash',
		'id'      => 'wp-admin-bar-my-account-dash-sub',
		'title'   => __( 'Access Dashboard', 'ogn' ),
		'href'    => trailingslashit( admin_url() ),
		'meta'    => array(
			'class' => 'wp-admin-bar-dashboard',
		),
	) );

	if ( current_user_can( 'manage_options' ) ) :
		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-options',
			'title'  => __( 'OneSocial Options', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'admin.php?page=onesocial_options' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-my-account-dash-options',
			),
		) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-customize',
			'title'  => __( 'Customize', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'customize.php' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-activity-site-wide-activity',
			),
		) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-widgets',
			'title'  => __( 'Widgets', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'widgets.php' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-activity-site-wide-activity',
			),
		) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-menus',
			'title'  => __( 'Menus', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'nav-menus.php' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-activity-site-wide-activity',
			),
		) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-plugins',
			'title'  => __( 'Plugins', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'plugins.php' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-activity-site-wide-activity',
			),
		) );

		$wp_admin_bar->add_menu( array(
			'parent' => 'wp-admin-bar-my-account-dash',
			'id'     => 'wp-admin-bar-my-account-dash-themes',
			'title'  => __( 'Themes', 'ogn' ),
			'href'   => trailingslashit( admin_url( 'themes.php' ) ),
			'meta'    => array(
				'class' => 'wp-admin-bar-activity-site-wide-activity',
			),
		) );
	endif;
}

/**
 * Add Sitewide Activity
 *
 * Add Site-wide Activity Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_activity_sitewide_activity() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$activity_domain = bp_get_root_domain() . '/' . bp_get_activity_root_slug();
	$item_link = trailingslashit( $activity_domain );

	// add submenu item.
	$wp_admin_bar->add_menu( array(
		'parent' => 'my-account-activity',
		'id'     => 'wp-admin-bar-my-activity-site-wide-activity',
		'title'  => __( 'Site-wide Activity', 'ogn' ),
		'href'   => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-activity-site-wide-activity',
		),
	) );

}


/**
 * Add Community Directory
 *
 * Add Community Directory Menu Item & sub menu items to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_community_directory() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$community_directory_domain = bp_get_root_domain() . '/' . bp_get_members_root_slug();
	$item_link = trailingslashit( $community_directory_domain );
	$members_link = bp_get_root_domain() . '/' . bp_get_members_root_slug();
	$contributors_link = bp_get_root_domain() . '/' . bp_get_members_root_slug() . '/contributors';

	$wp_admin_bar->add_menu( array(
		'parent'  => $bp->my_account_menu_id,
		'id'      => 'wp-admin-bar-my-account-community-directory',
		'title'   => __( 'Community<br /> Directory', 'ogn' ),
		'href'    => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-community-directory',
		),
	) );

	// Members sub menu item.
	$wp_admin_bar->add_menu( array(
		'parent' => 'wp-admin-bar-my-account-community-directory',
		'id'     => 'wp-admin-bar-my-account-community-directory-members',
		'title'  => __( 'Members', 'ogn' ),
		'href'   => trailingslashit( $members_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-my-account-community-directory-members',
		),
	) );

}


/**
 * Add Groups Center
 *
 * Add All Groups Center Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_groups_all_groups() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$groups_domain = bp_get_root_domain() . '/' . bp_get_groups_root_slug();
	$item_link = trailingslashit( $groups_domain );

	// add submenu item.
	$wp_admin_bar->add_menu( array(
		'parent' => 'my-account-groups',
		'id'     => 'wp-admin-bar-my-account-groups-all-groups',
		'title'  => __( 'All Groups', 'ogn' ),
		'href'   => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-all-groups',
		),
	) );

}


/**
 * Add Events
 *
 * Add Events Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_events() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$item_link = trailingslashit( home_url() . '/events' );

	$wp_admin_bar->add_menu( array(
		'parent'  => $bp->my_account_menu_id,
		'id'      => 'wp-admin-bar-my-account-events',
		'title'   => __( 'Events', 'ogn' ),
		'href'    => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-events menupop',
		),
	) );

	$wp_admin_bar->add_menu( array(
		'parent'  => 'wp-admin-bar-my-account-events',
		'id'      => 'wp-admin-bar-my-account-events-sub',
		'title'   => __( 'Find Events', 'ogn' ),
		'href'    => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-events',
		),
	) );

}


/**
 * Add Solutions Center
 *
 * Add Solutions Center Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return void
 */
function ogn_admin_bb_menu_bar_solutions_center() {
	global $wp_admin_bar, $bp;

	if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$item_link = trailingslashit( home_url() . '/solutions-center' );

	$wp_admin_bar->add_menu( array(
		'parent'  => $bp->my_account_menu_id,
		'id'      => 'wp-admin-bar-my-account-solution-center',
		'title'   => __( 'Solution Center', 'ogn' ),
		'href'    => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-solution-center menupop',
		),
	) );

	$wp_admin_bar->add_menu( array(
		'parent'  => 'wp-admin-bar-my-account-solution-center',
		'id'      => 'wp-admin-bar-my-account-solution-center-sub',
		'title'   => __( 'Find Services', 'ogn' ),
		'href'    => trailingslashit( $item_link ),
		'meta'    => array(
			'class' => 'wp-admin-bar-solution-center',
		),
	) );

}


add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_activity_sitewide_activity', 3 );
add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_community_directory', 61 );
add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_groups_all_groups', 1 );
add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_events', 71 );
add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_solutions_center', 72 );
add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_dash', 5 );
