<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Our_Green_Nation
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

echo '<aside id="secondary" class="widget-area" role="complementary">';

	// We're going to have a few sidebars for specific page types not covered in the WP template hierarchy

	if( is_search() ) {
		dynamic_sidebar( 'sidebar-search' );
	} elseif( is_category() ) {
		dynamic_sidebar( 'sidebar-search' );
	} else {
		// For any other page
		dynamic_sidebar( 'sidebar-1' );
	}

echo '</aside>';
