<?php
/**
 * @package OneSocial Child Theme
 * The parent theme functions are located at /onesocial/buddyboss-inc/theme-functions.php
 * Add your own functions in this file.
 */

/**
 * Sets up theme defaults
 *
 * @since OneSocial Child Theme 1.0.0
 */
function onesocial_child_theme_setup()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   * Read more at: http://www.buddyboss.com/tutorials/language-translations/
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'onesocial', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'onesocial' instances in all child theme files to 'onesocial_child_theme'.
  // load_theme_textdomain( 'onesocial_child_theme', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'onesocial_child_theme_setup' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since OneSocial Child Theme  1.0.0
 */
function onesocial_child_theme_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  /*
   * Styles
   */
  wp_enqueue_style( 'onesocial-child-custom', get_stylesheet_directory_uri().'/css/custom.css' );

  wp_dequeue_script( 'onesocial-load-ajax-posts' );
  wp_enqueue_script( 'onesocial-child-load-ajax-posts', get_stylesheet_directory_uri() . '/js/load-posts.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'onesocial_child_theme_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Common Customizations
require_once get_stylesheet_directory() . '/includes/common/class-site.php';
require_once get_stylesheet_directory() . '/includes/common/class-widgets.php';
require_once get_stylesheet_directory() . '/includes/common/class-register.php';
require_once get_stylesheet_directory() . '/includes/common/user-menu.php';
$site = new Lift\OGN\Theme\Site;
$site->register_hooks();
$widgets = new Lift\OGN\Theme\Widgets;
$widgets->register_widgets();
$register = new Lift\OGN\Theme\Register;
$register->register_hooks();

// Groups Customizations
if ( ! is_admin() ) {
  require_once get_stylesheet_directory() . '/includes/groups/class-groups.php';
  $groups = new Lift\OGN\Theme\Groups;
  $groups->register_hooks();
}

// Single Posts Customizations
if ( ! is_admin() ) {
  require_once get_stylesheet_directory() . '/includes/posts/class-posts.php';
  $posts = new Lift\OGN\Theme\Posts;
  $posts->register_hooks();
}

// Events Customizations
if ( ! is_admin() ) {
  require_once get_stylesheet_directory() . '/includes/events/class-events.php';
  $posts = new Lift\OGN\Theme\Events;
  $posts->register_hooks();
}

// Removes ASYNC if put in functions.php
remove_action( 'wp_dashboard_setup', 'register_aj_dashboard_widget' );

/**
 * BuddyPress tweaks.
 */

/**
 * Remove the default BP Reactions hook and add our own.
 *
 * @return void
 */
function wds_ogn_update_bp_reactions_hooks() {
  // Remove the default action.
  remove_action( 'bp_before_activity_entry_comments', 'bp_reactions_container' );

  // Add our own action to move the markup around.
  add_action( 'bp_get_activity_action', 'wds_ogn_bp_reactions_container', 99999, 1 );
}
add_action( 'init', 'wds_ogn_update_bp_reactions_hooks' );

/**
 * Appends the BP Reactions content to the activity actions.
 *
 * @param  string $action Current markup for the action.
 * @return string         Modified markup for actions.
 */
function wds_ogn_bp_reactions_container( $action ) {
  // Bail early if the BP Reactions helper doesn't exist.
  if ( ! function_exists( 'bp_reactions_container' ) ) {
    return $action;
  }

  // Append the BP Reactions markup.
  ob_start();
  bp_reactions_container();
  return $action . ob_get_clean();
}
