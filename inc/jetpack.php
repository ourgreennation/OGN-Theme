<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Our_Green_Nation
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function ourgreennation_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' 		=> 'main',
		'render'    		=> 'ourgreennation_infinite_scroll_render',
		'footer'    		=> 'page',
		'posts_per_page'    => 20,
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus
	add_theme_support( 'jetpack-social-menu' );

	// Add theme support for site logos
	add_image_size( 'ourgreennation-logo', 200, 200 );
	add_theme_support( 'site-logo', array( 'size' => 'ourgreennation-logo' ) );

}
add_action( 'after_setup_theme', 'ourgreennation_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function ourgreennation_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    get_template_part( 'components/post/content', 'search' );
		else :
		    get_template_part( 'components/post/content', get_post_format() );
		endif;
	}
}

function ourgreennation_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}


/**
 * Remove Jetpack Related posts from under posts
 */
function ourgreennation_remove_jetpack_related() {
	$jprp = Jetpack_RelatedPosts::init();
	$callback = array( $jprp, 'filter_add_target_to_dom' );
	remove_filter( 'the_content', $callback, 40 );
}
// add_filter( 'wp', 'ourgreennation_remove_jetpack_related', 20 );

function jetpackme_related_posts_headline( $headline ) {
$headline = '';
return $headline;
}
// add_filter( 'jetpack_relatedposts_filter_headline', 'jetpackme_related_posts_headline' );


// Force posts to be public for related posts
function ourgreennation_fix_related() {
	if ( class_exists( 'Jetpack_Options' ) ) {
	    Jetpack_Options::update_option( 'public' , true);
}
}
add_action( 'init', 'ourgreennation_fix_related' );
