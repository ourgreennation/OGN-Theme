<?php
/**
 * components functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Our_Green_Nation
 */

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
	 * to change 'ourgreennation' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ourgreennation', get_template_directory() . '/languages' );

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
		'top' => esc_html__( 'Top', 'ourgreennation' ),
		'bottom' => esc_html__( 'Bottom', 'ourgreennation' ),
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
		'aside',
		'audio',
		'gallery',
		'image',
		'link',
		'quote',
		'status',
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
		'name'          => esc_html__( 'Sidebar', 'ourgreennation' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'ourgreennation' ),
		'id'            => 'sidebar-footer',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home Popular Content', 'ourgreennation' ),
		'id'            => 'sidebar-home-popular-content',
		'description'   => 'If the Home Popular Content ',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'ourgreennation_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function ourgreennation_scripts() {

	// Loads our main stylesheet, replaces with RTL if necessary
	wp_enqueue_style( 'ourgreennation-style', get_stylesheet_uri() );
	wp_style_add_data( 'ourgreennation-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ourgreennation-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ourgreennation-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue Fonts
	// wp_enqueue_style( 'ourgreennation-league-gothic-font', get_template_directory_uri() . '/assets/fonts/league-gothic/stylesheet.css', false );
	wp_enqueue_style( 'ourgreennation-fonts', 'https://fonts.googleapis.com/css?family=Roboto|Slabo+27px' );
	// wp_enqueue_style( 'ourgreennation_fontawesome', get_template_directory_uri() . '/assets/fonts/fontawesome/font-awesome.min.css' );
	wp_enqueue_script( 'ourgreennation-fontawesome', 'https://use.fontawesome.com/40a13a40e7.js' );

	// Sticky Plugin
	wp_enqueue_script( 'ourgreennation-sticky', get_template_directory_uri() . '/assets/js/jquery.sticky.js', array('jquery'), '', true );

	// MeanMenu
	wp_enqueue_script( 'mean-menu', get_template_directory_uri() . '/assets/js/jquery.meanmenu.js', array('jquery'), '', true );

	// Fitvids.js for responsive video embeds
	wp_enqueue_script( 'ourgreennation-fitvids', get_template_directory_uri() . '/assets/js/fitvids.js', array(), '', true );

	// Flexslider for tiny galleries inside Masonry layouts
	wp_enqueue_script( 'ourgreennation-flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider.js', array('jquery'), '', true );

	// Checks for images having loaded into the page
	wp_enqueue_script( 'ourgreennation-imagesloaded', get_template_directory_uri() . '/assets/js/imagesLoaded.js', array(), '', true );

	// Enqueue Masonry
	wp_register_script( 'ourgreennation-jquery-masonry', get_template_directory_uri() . '/assets/js/jquery.masonry.js', array('jquery'), '', true );

	// Global styles for theme
	wp_enqueue_script( 'ourgreennation-global', get_template_directory_uri() . '/assets/js/global.js', array('jquery','ourgreennation-sticky','ourgreennation-flexslider','ourgreennation-fitvids','ourgreennation-jquery-masonry','ourgreennation-imagesloaded'), '', true);

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
