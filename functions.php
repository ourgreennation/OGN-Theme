<?php
/**
 * components functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Our_Green_Nation
 */


// Define our constants
define ( 'OGN_IMG_DIR', get_template_directory_uri() . '/assets/img/' );

if ( ! function_exists( 'ourgreennation_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the aftercomponentsetup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ourgreennation_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'our-green-nation' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'our-green-nation', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Enable support for custom logo
	 *
	 * @link https://make.wordpress.org/core/2016/03/10/custom-logo/
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top' => esc_html__( 'Top', 'our-green-nation' ),
		'bottom' => esc_html__( 'Bottom', 'our-green-nation' ),
		'menu-bar' => esc_html__( 'Menu Bar', 'our-green-nation' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'audio',
		'image',
		'quote',
		'video',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ourgreennation_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add support for social links
	add_theme_support( 'social-links', array(
		'facebook',
		'twitter',
		'linkedin',
		'google_plus',
		'tumblr',
	) );

	// Add support for BuddyPress
	// add_theme_support( 'buddypress' );

}
endif;
add_action( 'after_setup_theme', 'ourgreennation_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ourgreennation_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'ourgreennation_content_width', 820 );

}
add_action( 'after_setup_theme', 'ourgreennation_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ourgreennation_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-1',
		'description'   => 'General page and post sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Before Footer', 'our-green-nation' ),
		'id'            => 'sidebar-before-footer',
		'description'   => 'Widgets that appear above footer menu and footer widgets, below content',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'our-green-nation' ),
		'id'            => 'sidebar-footer',
		'description'   => 'Footer that appears below footer menu',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home Popular Content', 'our-green-nation' ),
		'id'            => 'sidebar-home-popular-content',
		'description'   => 'Displayed if the Home Popular Content block is being used',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Cateories Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-category',
		'description'   => 'Displayed on category pages',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Search Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-search',
		'description'   => 'Displayed on the Search page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Events Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-events',
		'description'   => 'Displayed on the Events page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'BuddyPress - Activity Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-buddypress-activity',
		'description'   => 'Displayed on the BuddyPress Activity page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'BuddyPress - Profile Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-buddypress-profile',
		'description'   => 'Displayed on the BuddyPress Profile page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'BuddyPress - Group Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-buddypress-group',
		'description'   => 'Displayed on the BuddyPress Group page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'BuddyPress - Members Sidebar', 'our-green-nation' ),
		'id'            => 'sidebar-buddypress-members',
		'description'   => 'Displayed on the BuddyPress Members page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'ourgreennation_widgets_init' );

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');


/**
 * Enqueue scripts and styles.
 */
function ourgreennation_scripts() {

	// Loads our main stylesheet, replaces with RTL if necessary
	wp_enqueue_style( 'ourgreennation-style', get_stylesheet_uri() );
	wp_style_add_data( 'ourgreennation-style', 'rtl', 'replace' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue Fonts
	// wp_enqueue_style( 'ourgreennation-league-gothic-font', get_template_directory_uri() . '/assets/fonts/league-gothic/stylesheet.css', false );
	wp_enqueue_style( 'ourgreennation-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600|Source+Serif+Pro:400' );
	wp_enqueue_style( 'ourgreennation_fontawesome', get_template_directory_uri() . '/assets/fonts/fontawesome/css/font-awesome.min.css' );
	// wp_enqueue_script( 'ourgreennation-fontawesome', 'https://use.fontawesome.com/40a13a40e7.js' );

	// Minified scripts for theme
	// imagesLoaded.js, fitvids.js, masonry.js, smartmenus.js
	wp_enqueue_script( 'ourgreennation-scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery') );

	// Global styles for theme
	wp_enqueue_script( 'ourgreennation-global', get_template_directory_uri() . '/assets/js/global.js', array('jquery', 'ourgreennation-scripts'), '', true );
	wp_enqueue_style( 'ourgreennation-tribe-pro', get_template_directory_uri() . '/assets/css/tribe-events-pro-full.min.css' );

}
add_action( 'wp_enqueue_scripts', 'ourgreennation_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function ourgreennation_admin_scripts() {

	wp_enqueue_style( 'ourgreennation-admin-style', get_template_directory_uri() . '/assets/css/admin.css' );

}
add_action( 'admin_enqueue_scripts', 'ourgreennation_admin_scripts' );



/**
 * Misc Theme Functionality
 */
function ourgreennation_xprofile_cover_image( $settings = array() ) {
	$settings['default_cover'] = get_stylesheet_directory_uri() . '/assets/img/wood_cover.jpg';

	return $settings;
}
add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'ourgreennation_xprofile_cover_image', 10, 1 );
add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'ourgreennation_xprofile_cover_image', 10, 1 );

// Add Toolbar Menus
function ourgreennation_solutions_center_toolbar() {
	global $wp_admin_bar;

	$args = array(
		'id'     => 'solutions-center',
		'title'  => __( '<span class="dashicons dashicons-admin-tools"></span> Solutions Center', 'our-green-nation' ),
		'href'   => get_site_url() . '/solutions-center/',
		'parent' => 'top-secondary',
	);
	$wp_admin_bar->add_menu( $args );

}
add_action( 'wp_before_admin_bar_render', 'ourgreennation_solutions_center_toolbar', 999 );



/**
 * Custom header for this theme.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Page Layout builders
 */
require get_template_directory() . '/inc/layout-structures.php';


/**
 * Load Temporary Functions
 */
require get_template_directory() . '/inc/temporary.php';






// Defer Javascripts
// Defer jQuery Parsing using the HTML5 defer property
function defer_parsing_of_js ( $url ) {
	if ( FALSE === strpos( $url, '.js' ) ) return $url;
	if ( strpos( $url, 'jquery.js' ) ) return $url;
	return "$url' defer ";
}
add_filter( 'clean_url', 'defer_parsing_of_js', 20, 1 );


function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


