<?php
/**
 * Our Green Nation Theme Customizer.
 *
 * @package Our_Green_Nation
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ourgreennation_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ourgreennation_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ourgreennation_customize_preview_js() {
	wp_enqueue_script( 'ourgreennation_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20160807', true );
}
add_action( 'customize_preview_init', 'ourgreennation_customize_preview_js' );



/**
 * Registers all the customizer options.
 */

function ourgreennation_register_customizer_settings(){

	global $wp_customize;

	/**
	* Add editable title to front page portfolio grid
	*/
	$wp_customize->add_setting( 'header_image_scale', array(
		'default' 	=> 'cover',
		'sanitize_callback' => 'ourgreennation_sanitize_image_scale',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_scale', array(
		'label'  			=> __( 'Header Image Style', 'our-green-nation' ),
		'section' 			=> 'header_image',
		'settings' 			=> 'header_image_scale',
		'type'				=> 'radio',
		'priority'  		=> 100,
		'sanitize_callback' => 'ourgreennation_sanitize_image_scale',
		'choices'			=> array(
			'cover'				=> __( 'Cover header area with image at all times', 'our-green-nation' ),
			'100% auto'			=> __( 'Force image to same width as browser', 'our-green-nation' ),
			'auto 100%'			=> __( 'Force image to same height as header area', 'our-green-nation' ),
			),
	) ) );



	$wp_customize->add_section('theme_layout' , array(
	    'title'     => __('Theme Layout', 'our-green-nation'),
	    'priority'  => 100
	));


	/**
	* Add single post/page width to customizer
	*/
	$wp_customize->add_setting( 'ourgreennation_default_layout', array(
		'default' 	=> 'content-sidebar',
		'sanitize_callback' => 'ourgreennation_sanitize_default_layout',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ourgreennation_default_layout', array(
		'label'  			=> __( 'Post/Page Default Layout', 'our-green-nation' ),
		'section' 			=> 'theme_layout',
		'settings' 			=> 'ourgreennation_default_layout',
		'type'				=> 'radio',
		'priority'  		=> 100,
		'sanitize_callback' => 'ourgreennation_sanitize_default_layout',
		'choices'			=> array(
			'content-sidebar'		=> __( 'Content/Sidebar', 'our-green-nation' ),
			'sidebar-content'		=> __( 'Sidebar/Content', 'our-green-nation' ),
			'full-width'			=> __( 'Full Width', 'our-green-nation' ),
			),
	) ) );

	// /**
	// * Add homepage masonry column width to customizer
	// */
	// $wp_customize->add_setting( 'masonry_home_column_width', array(
	// 	'default' 	=> '3-col',
	// 	'sanitize_callback' => 'ourgreennation_sanitize_home_column_width',
	// ) );

	// $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'masonry_home_column_width', array(
	// 	'label'  			=> __( 'Masonry Columns on Homepage', 'our-green-nation' ),
	// 	'section' 			=> 'theme_layout',
	// 	'settings' 			=> 'masonry_home_column_width',
	// 	'type'				=> 'radio',
	// 	'priority'  		=> 100,
	// 	'sanitize_callback' => 'ourgreennation_sanitize_home_column_width',
	// 	'choices'			=> array(
	// 		'2-col'			=> __( '2 Columns', 'our-green-nation' ),
	// 		'3-col'			=> __( '3 Columns', 'our-green-nation' ),
	// 		'4-col'			=> __( '4 Columns', 'our-green-nation' ),
	// 		),
	// ) ) );

	// /**
	// * Add archive masonry column width to customizer
	// */

	// $wp_customize->add_setting( 'masonry_archive_column_width', array(
	// 	'default' 	=> '2-col',
	// 	'sanitize_callback' => 'ourgreennation_sanitize_archive_column_width',
	// ) );

	// $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'masonry_archive_column_width', array(
	// 	'label'  			=> __( 'Masonry Columns on Archive Pages', 'our-green-nation' ),
	// 	'section' 			=> 'theme_layout',
	// 	'settings' 			=> 'masonry_archive_column_width',
	// 	'type'				=> 'radio',
	// 	'priority'  		=> 100,
	// 	'sanitize_callback' => 'ourgreennation_sanitize_archive_column_width',
	// 	'choices'			=> array(
	// 		'2-col'			=> __( '2 Columns', 'our-green-nation' ),
	// 		'3-col'			=> __( '3 Columns', 'our-green-nation' ),
	// 		'4-col'			=> __( '4 Columns', 'our-green-nation' ),
	// 		),
	// ) ) );




	/**
	* Add accent color to ourgreennation theme.
	*/
	$wp_customize->add_setting( 'ourgreennation_accent_color', array(
		'default' 	        => '#789d4a',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ourgreennation_accent_color', array(
		'label'  			=> __( 'Accent Color', 'our-green-nation' ),
		'section' 			=> 'colors',
		'settings' 			=> 'ourgreennation_accent_color',
		'type'				=> 'color',
		'priority'  		=> 100,
	) ) );

	$wp_customize->add_section('post_page_section' , array(
		'title'     => __('Individual Post Page', 'our-green-nation'),
		'priority'  => 100
	));

	$wp_customize->add_setting('hide_author_info', array(
	    'default'    => false,
	    'sanitize_callback' => 'ourgreennation_sanitize_hide_author_info'
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_author_info', array(
		'label'     => __('Hide Author Info (If checked, this hides the author image, name, and bio box at the end of posts)', 'our-green-nation'),
		'section'   => 'post_page_section',
		'settings'  => 'hide_author_info',
		'type'      => 'checkbox',
	) ) );

}
add_action( 'customize_register', 'ourgreennation_register_customizer_settings' );


/**
 * Sanitize the show author info value.
 *
 */
function ourgreennation_sanitize_hide_author_info( $value ) {
		if ( ! is_bool( $value ) )
				$value = false;

    return $value;
}

/**
 * Sanitize the image scale value.
 *
 */
function ourgreennation_sanitize_image_scale( $value ) {
    if ( ! in_array( $value, array( 'cover', '100% auto', 'auto 100%' ) ) )
        $value = 'cover';

    return $value;
}

/**
 * Sanitize the image scale value.
 *
 */
function ourgreennation_sanitize_default_layout( $value ) {
    if ( ! in_array( $value, array( 'content-sidebar', 'sidebar-content', 'full-width' ) ) )
        $value = 'content-sidebar';

    return $value;
}

// /**
//  * Sanitize the width of home columns
//  *
//  */
// function ourgreennation_sanitize_home_column_width( $value ) {
//     if ( ! in_array( $value, array( '2-col', '3-col', '4-col' ) ) )
//         $value = '3-col';

//     return $value;
// }

// /**
//  * Sanitize the width of archive columns
//  *
//  */
// function ourgreennation_sanitize_archive_column_width( $value ) {
//     if ( ! in_array( $value, array( '2-col', '3-col', '4-col' ) ) )
//         $value = '2-col';

//     return $value;
// }

/**
 * Output custom styles based on customizer options.
 *
 */
function ourgreennation_add_header_styles(){
?>
<style id="ourgreennation-custom-header-styles" type="text/css">
#header{
	background-size: <?php echo get_theme_mod( 'header_image_scale', 'cover' ); ?> !important;
}
</style>
<?php
}
add_action( 'wp_head', 'ourgreennation_add_header_styles' );


// /**
//  * Calculate percent width of homepage column from customizer
//  *
//  */
// function ourgreennation_filter_home_column_width(){
// 	$column_width = esc_attr( get_theme_mod( 'masonry_home_column_width', '3-col' ) );

// 	if ( $column_width === '2-col' ) {
// 		$column_width = 50;
// 	} elseif ( $column_width === '3-col' ) {
// 		$column_width = 33;
// 	} elseif ( $column_width === '4-col' ) {
// 		$column_width = 25;
// 	}

// 	return $column_width . "%";
// }
// add_filter( 'ourgreennation_home_item_width', 'ourgreennation_filter_home_column_width' );


// /**
//  * Calculate percent width of archive column from customizer
//  *
//  */
// function ourgreennation_filter_archive_column_width(){
// 	$column_width = esc_attr( get_theme_mod( 'masonry_archive_column_width', '2-col' ) );

// 	if ( $column_width === '2-col' ) {
// 		$column_width = 50;
// 	} elseif ( $column_width === '3-col' ) {
// 		$column_width = 33;
// 	} elseif ( $column_width === '4-col' ) {
// 		$column_width = 25;
// 	}

// 	return $column_width . "%";
// }
// add_filter( 'ourgreennation_archive_item_width', 'ourgreennation_filter_archive_column_width' );



// /**
//  * enqueue masonry width styles
//  *
//  */
// function ourgreennation_column_styles(){
// 	$home_column_width = apply_filters( 'ourgreennation_home_item_width', '33%' );

// 	$archive_column_width = apply_filters( 'ourgreennation_archive_item_width', '50%' );

// 	$custom_css = "
// 	.home .masonry .hentry{
// 		width: {$home_column_width};
// 	}
// 	.archive .masonry .hentry{
// 		width: {$archive_column_width};
// 	}";
// 	wp_add_inline_style( 'ourgreennation-style', $custom_css );
// }
// add_action( 'wp_enqueue_scripts', 'ourgreennation_column_styles', 999 );


function ourgreennation_footer_styles(){
	$background_color = get_theme_mod( 'background_color' );

	$custom_css = "
	body #infinite-footer .container{
		background-color: #{$background_color};
	}";
	wp_add_inline_style( 'ourgreennation-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ourgreennation_footer_styles', 999 );


function ourgreennation_accent_color_styles(){
	$accent_color = get_theme_mod( 'ourgreennation_accent_color', '#b2d234' );

	$custom_css = '

a,
a:visited,
a:hover,
.post-meta .hashtag:hover,
.post-meta .hashtag a:hover,
.masonry .panel .entry-title a:hover,
.masonry .format-quote:hover,
.masonry .format-quote a:hover,
#access .menu .social-links a:hover,
#access .menu ul li .sub-menu li a:hover,
#access .menu ul li .children li a:hover,
#access .mobile-menu a,
.widget-zone > ul > li li a,
.widget_calendar #calendar_wrap #wp-calendar tbody tr td a,
.widget_calendar #calendar_wrap #wp-calendar tfoot td a:hover,
.widget_rss ul li a:hover,
#footer a:hover,
.flexslider:hover .flex-next:hover,
.flexslider:hover .flex-prev:hover,
.mean-container .mean-nav ul li a.mean-expand:hover{
	color: '. $accent_color .';

}
input[type="submit"],
input[type="reset"],
button,
.back,
.page-links a:hover,
.custom-background .archive-header:before,
.custom-background .author .author-info:before,
.author .custom-background .author-info:before,
.custom-background .archive-header:after,
.custom-background .author .author-info:after,
.author .custom-background .author-info:after,
.author .author-info:before,
.author .author-info:after,
#access .menu ul li a:hover,
#access .menu ul li .sub-menu,
#access .menu ul li .children,
#access .menu ul li .sub-menu li a,
#access .menu ul li .children li a,
#access .mobile-menu .menu-link.open,
#access .mobile-menu .menu-link:hover,
#comments .pingback .edit-link a,
#comments .tweetback .edit-link a,
.widget_calendar #calendar_wrap #wp-calendar caption,
#footer .menu a:hover,
.flex-direction-nav a,
.mean-container .mean-bar,
.mean-container .mean-nav ul li a.mean-expand,
span.category a{
	background-color: '. $accent_color .';
	color: ' . ourgreennation_color_contrast($accent_color) . ';
}
.masonry .panel .entry-title a,
.masonry .panel .entry-title a:visited,
#access .menu,
#access .mobile-menu .menu-link,
#footer a{
	border-color: '. $accent_color .';
}
input[type="submit"]:hover,
input[type="reset"]:hover,
button:hover,
span.category a:hover {
	background-color: #222;
	color: ' . ourgreennation_color_contrast('#222') . ';
}
a:hover{
	color: #222;
}
	';
	wp_add_inline_style( 'ourgreennation-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ourgreennation_accent_color_styles', 999 );


function ourgreennation_color_contrast($hexcolor, $dark = '#000000', $light = '#FFFFFF'){
    return (hexdec($hexcolor) > 0xffffff/2) ? $dark : $light;
}

