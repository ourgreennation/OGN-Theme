<?php
/**
 * @package OneSocial Child Theme
 * The parent theme functions are located at /onesocial/buddyboss-inc/theme-functions.php
 * This file registers extra menu items in the BuddyPress Admin bar area.
 */

/**
 *
 * ogn_admin_bb_menu_bar_activity_sitewide_activity
 * Add Site-wide Activity Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return VOID
 *
 */
function ogn_admin_bb_menu_bar_activity_sitewide_activity() {
    global $wp_admin_bar, $bp;

    if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
        return;
    }

    $activity_domain = bp_get_root_domain() . '/' . bp_get_activity_root_slug();
    $item_link = trailingslashit( $activity_domain );

    // add submenu item
    $wp_admin_bar->add_menu( array(
        'parent' => 'my-account-activity',
        'id'     => 'wp-admin-bar-my-activity-site-wide-activity',
        'title'  => __( 'Site-wide Activity', 'ogn' ),
        'href'   => trailingslashit( $item_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-activity-site-wide-activity' )
    ) );

}


/**
 *
 * ogn_admin_bb_menu_bar_community_directory
 * Add Community Directory Menu Item & sub menu items to User Admin Bar for admin and contributors only.
 *
 * @return VOID
 *
 */
function ogn_admin_bb_menu_bar_community_directory() {
    global $wp_admin_bar, $bp;

    if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
        return;
    }

    $community_directory_domain = bp_get_root_domain() . '/' . bp_get_members_root_slug();
    $item_link = trailingslashit( $community_directory_domain );
    $members_link = bp_get_root_domain() . '/' . bp_get_members_root_slug() . '/members';
    $contributors_link = bp_get_root_domain() . '/' . bp_get_members_root_slug() . '/contributors';

    $wp_admin_bar->add_menu( array(
        'parent'  => $bp->my_account_menu_id,
        'id'      => 'wp-admin-bar-my-account-community-directory',
        'title'   => __( 'Community Directory', 'ogn' ),
        'href'    => trailingslashit( $item_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-community-directory' )
    ) );

    // Members sub menu item
    $wp_admin_bar->add_menu( array(
        'parent' => 'wp-admin-bar-my-account-community-directory',
        'id'     => 'wp-admin-bar-my-account-community-directory-members',
        'title'  => __( 'Members', 'ogn' ),
        'href'   => trailingslashit( $members_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-my-account-community-directory-members' )
    ) );

    // Contributors sub menu item
    $wp_admin_bar->add_menu( array(
        'parent' => 'wp-admin-bar-my-account-community-directory',
        'id'     => 'wp-admin-bar-my-account-community-directory-contributors',
        'title'  => __( 'Contributors', 'ogn' ),
        'href'   => trailingslashit( $contributors_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-my-account-community-directory-contributors' )
    ) );

}


/**
 *
 * ogn_admin_bb_menu_bar_groups_all_groups
 * Add All Groups Center Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return VOID
 *
 */
function ogn_admin_bb_menu_bar_groups_all_groups() {
    global $wp_admin_bar, $bp;

    if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
        return;
    }

    $groups_domain = bp_get_root_domain() . '/' . bp_get_groups_root_slug();
    $item_link = trailingslashit( $groups_domain );

    // add submenu item
    $wp_admin_bar->add_menu( array(
        'parent' => 'my-account-groups',
        'id'     => 'wp-admin-bar-my-account-groups-all-groups',
        'title'  => __( 'All Groups', 'ogn' ),
        'href'   => trailingslashit( $item_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-all-groups' )
    ) );

}


/**
 *
 * ogn_admin_bb_menu_bar_events
 * Add Events Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return VOID
 *
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
        'meta'    => array( 'class' => 'wp-admin-bar-events' )
    ) );

}


/**
 *
 * ogn_admin_bb_menu_bar_solutions_center
 * Add Solutions Center Menu Item to User Admin Bar for admin and contributors only.
 *
 * @return VOID
 *
 */
function ogn_admin_bb_menu_bar_solutions_center() {
    global $wp_admin_bar, $bp;

    if ( ! bp_use_wp_admin_bar() || defined( 'DOING_AJAX' ) ) {
        return;
    }

    $item_link = trailingslashit( home_url() . '/solution-center' );

    $wp_admin_bar->add_menu( array(
        'parent'  => $bp->my_account_menu_id,
        'id'      => 'wp-admin-bar-my-account-solution-center',
        'title'   => __( 'Solution Center', 'ogn' ),
        'href'    => trailingslashit( $item_link ),
        'meta'    => array( 'class' => 'wp-admin-bar-solution-center' )
    ) );

}

if ( current_user_can( 'manage_options' ) || current_user_can( 'edit_others_posts' ) ) {

    add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_activity_sitewide_activity', 1 );
    //Commented out until we clean up URL.
    // @TODO Add ability to target links to contributors.
    //add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_community_directory', 41 );
    add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_groups_all_groups', 1 );
    add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_events', 71 );
    add_action( 'bp_setup_admin_bar', 'ogn_admin_bb_menu_bar_solutions_center', 72 );

}
