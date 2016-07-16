<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Our_Green_Nation
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ourgreennation_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if( get_field( 'use_page_builder' ) ) {
		$classes[] = 'page-builder';
	}

	return $classes;
}
add_filter( 'body_class', 'ourgreennation_body_classes' );



/**
 * Creates link to login page
 */
function ourgreennation_get_login_button() {

	echo '<a href="#" class="login-link">Login</a>';

}


/**
 * Attaches featured media to ourgreennation_before_post hook
 *
 * @uses ourgreennation_get_featured_media()
 */
function ourgreennation_attach_media_to_posts(){
	echo ourgreennation_get_featured_media();
}

add_action('ourgreennation_before_post','ourgreennation_attach_media_to_posts');

/**
 * Grab the first shortcode from a post matching specified name.
 *
 * Because sometimes we want to display embedded media on masonry pages.
 *
 * @global $post WordPress post object
 * @param string $shortcode_name Accepts any valid shortcode name.
 *
 * @return $oembed_html HTML for first embedded object
 */
function ourgreennation_get_shortcode($shortcode_name = 'video') {
	global $post;

	$pattern = get_shortcode_regex();

	preg_match('/'.$pattern.'/s', $post->post_content, $matches);

	if (is_array($matches) && isset($matches[2]) && $matches[2] == $shortcode_name) {
		$shortcode = $matches[0];
		return do_shortcode($shortcode);
	}
}

/**
 * Checks for a YouTube embed that isn't playing nicely
 *
 * Embeds a YouTube video when Jetpack is active since we
 * are not able to do it ourselves.
 *
 * @global $post WordPress post object
 *
 * @return string $oembed HTML embed code
 */
function ourgreennation_embed_youtube_video( $oembed ){
	global $post;

	$yt_regex = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

	if( $oembed == '' && get_post_format() == 'video' ){

		preg_match_all($yt_regex, $post->post_content, $matches);

		$width  = apply_filters('ourgreennation_item_width',300);
		$height = ($width / 9 * 6);

		if( !empty( $matches[1][0] ) ){
			$oembed = '<iframe id="player" type="text/html" width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $matches[1][0] . '?enablejsapi=1&origin=' . esc_url( get_home_url('/') ) . '" frameborder="0"></iframe>';
		}
	}

	return $oembed;
}

add_filter('oembed_html','ourgreennation_embed_youtube_video');

/**
 * Checks for an Instagram embed that isn't playing nicely
 *
 * Replaces the default oembed markup with a simple img element
 * so that our Instagram posts won't break.
 *
 * @global $post WordPress post object
 *
 * @return string $oembed HTML embed code
 */
function ourgreennation_replace_instagram_html( $oembed ){
	global $post;

	$insta_regex = "#(?:http://)instagr(?:am.com|.am)/p/(.*?)/#i";

	if( $oembed == '' ){

		preg_match_all($insta_regex, $post->post_content, $matches);

		if( !empty( $matches[1][0] ) ){
			$oembed = '<a href="' . get_permalink( get_the_ID() ) . '"><img src="http://instagr.am/p/' . $matches[1][0] . '/media/"></a>';
		}
	}
	return $oembed;
}

add_filter('oembed_html','ourgreennation_replace_instagram_html');
/**
 * Grab the first oembed object from post.
 *
 * Because sometimes we want to display embedded media on masonry pages.
 *
 * @return $oembed_html HTML for first embedded object
 */
function ourgreennation_get_first_oembed() {

    $meta = get_post_custom( get_the_ID() );

	$html = '';

    foreach ($meta as $key => $value){
        if (false !== strpos($key, 'oembed')){

			if( ! is_singular() ) { // are we on a single post/page?

				// Grab the HTML we need to extract height and width from
				$oembed_html = $value[0];

				//echo "String: $string\n\n";
				$html = $oembed_html;

			    return apply_filters('oembed_html',$html);
			    break;

			}
        }
    }
}

/**
 * Returns a regular expression that captures the height and width of any element inside
 */

function ourgreennation_height_width_regex(){
	return "/(width|height)=('|\")(\d+)('|\")([^>]+)(width|height)=('|\")(\d+)('|\")/";
}

/**
 * Parse the HTML and return a new height/width attributes for oembed objects.
 *
 * Because sometimes we want to display embedded media on masonry pages.
 *
 * @return $size_atts Size attributes for embedded media
 */
function ourgreennation_modify_height_width_atts($matches) {

	$key1 = $matches[1];
	$val1 = $matches[3];
	$key2 = $matches[6];
	$val2 = $matches[8];

	$init_width = 0;
	$init_height = 0;

	$target_width = apply_filters( 'ourgreennation_item_width', 300 );

	if(strtolower($key1) == 'width') {
		$init_width = $val1;
		$init_height = $val2;
	} else {
		$init_width = $val2;
		$init_height = $val1;
	}

	$size_atts = 'width="'. $target_width .'px"' . $matches[5] . ' height="' . ($target_width * $init_height) / $init_width . 'px"';

	return $size_atts;

}

/**
 * Returns first image from post content
 *
 * Scans the post content for an <img> element and returns
 * the first match.
 *
 * @return $first_img First matched image URL
 */
function ourgreennation_get_first_image() {
	global $post, $posts;

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', is_single() && $post->post_content, $matches);

	if( isset( $matches[1][0] ) ){
		$first_img = $matches[1][0];
		return $first_img;
	} else {
		return false;
	}

}

/**
 * Get the featured media for post
 *
 * Checks for featured image, then displays media based on
 */
function ourgreennation_get_featured_media(){
	global $post;

	$post_format = get_post_format($post);

	if( $post_format !== 'ourgreennation' ):

		$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
		$embeds = get_media_embedded_in_content( $content );

		if( ! empty( $embeds ) ):
			$media = $embeds[0];
		endif;

		if( isset( $media ) ):
			$media_html = $media;
		endif;

		if( ! isset( $media_html ) ):
			$media_html = ourgreennation_get_first_oembed();
		endif;

	elseif( $post_format === 'ourgreennation' ):
		$media_html = ourgreennation_get_shortcode( 'ourgreennation' );
	endif;

	if( get_the_post_thumbnail( get_the_ID() ) )
		return '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), ourgreennation_get_grid_column_width() ) . '</a>';

	if( isset( $media_html ) ):
		$resized_html = preg_replace_callback(ourgreennation_height_width_regex(), "ourgreennation_modify_height_width_atts", $media_html);
		return $resized_html;
	endif;

	return '<a href="' . get_permalink() . '"><img src="' . ourgreennation_get_first_image() . '" alt=""></a>';

}


/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @return string The Link format URL.
 */
function ourgreennation_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : esc_url( apply_filters( 'the_permalink', get_permalink() ) );
}


if ( ! function_exists( 'ourgreennation_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable.
 */
function ourgreennation_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'ourgreennation' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'ourgreennation' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'ourgreennation' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'ourgreennation' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'ourgreennation' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // ourgreennation_content_nav


// Owl Slider Display
function ourgreennation_content_carousel() {

    if( have_rows('carousel') ) :

        echo '<div class="carousel">';
            echo '<div id="owl-carousel" class="owl-carousel owl-theme">';

            while( have_rows('carousel') ) : the_row();

                echo '<div class="item">';

                    $carousel_image = get_sub_field( 'carousel_image' );

                    if( !empty( $carousel_image ) ):

                        echo '<img src="' . $carousel_image['url'] . '" alt="' . $carousel_image['alt'] . '" />';

                    endif;

                echo '</div>';

            endwhile;

            echo '</div>';
            // echo '<div class="customNavigation"><a class="btn prev fa fa-arrow-left"></a><a class="btn next fa fa-arrow-right"></a></div>';
        echo '</div>';

    endif;

}


// Popular Articles Display
function ourgreennation_no_masonry_articles() {

    // WP_Query arguments
    $popular_args = array (
        'post_type'  				=> 'post',
        'cat'						=> get_sub_field( 'popular_category' ),
        'order'   					=> 'ASC',
        'orderby'       			=> 'date',
        'cache_results' 			=> true,
        'update_post_meta_cache' 	=> true,
        'update_post_term_cache' 	=> true,
        'ignore_sticky_posts'   	=> true,
        'posts_per_page'         	=> get_sub_field( 'number_of_articles' ),
    );

    // The Query
    $popular_query = new WP_Query( $popular_args );

    if( $popular_query->have_posts() ):

    	if( !get_field( 'home_popular_content' ) ) {
        	echo '<div class="popular-articles-inner"><div class="grid-sizer"></div>';
		}
            while( $popular_query->have_posts() ) : $popular_query->the_post();

               	get_template_part( 'components/post/content', get_post_format() );

                wp_reset_postdata();

            endwhile;

            wp_reset_query();

        if( !get_field( 'home_popular_content' ) ) {
        	echo '</div>';
        }

    endif;

}


// Popular Articles Display
function ourgreennation_content_popular_articles() {

    // WP_Query arguments
    $popular_args = array (
        'post_type'  				=> 'post',
        'cat'						=> get_sub_field( 'popular_category' ),
        'order'   					=> 'ASC',
        'orderby'       			=> 'date',
        'cache_results' 			=> true,
        'update_post_meta_cache' 	=> true,
        'update_post_term_cache' 	=> true,
        'ignore_sticky_posts'   	=> true,
        'posts_per_page'         	=> get_sub_field( 'number_of_articles' ),
    );

    // The Query
    $popular_query = new WP_Query( $popular_args );

    if( $popular_query->have_posts() ):

    	if( !get_field( 'home_popular_content' ) ) {
        	echo '<div class="popular-articles-inner masonry"><div class="grid-sizer"></div>';
		}
            while( $popular_query->have_posts() ) : $popular_query->the_post();

               	get_template_part( 'components/post/content', get_post_format() );

                wp_reset_postdata();

            endwhile;

            wp_reset_query();

        if( !get_field( 'home_popular_content' ) ) {
        	echo '</div>';
        }

    endif;

}


// Popular Articles Display
function ourgreennation_content_recent_articles() {

    // WP_Query arguments
    $recent_args = array (
        'post_type'  				=> 'post',
        'cache_results' 			=> true,
        'update_post_meta_cache' 	=> true,
        'update_post_term_cache' 	=> true,
        'ignore_sticky_posts'   	=> true,
        'posts_per_page'         	=> get_sub_field( 'number_of_articles' ),
    );

    // The Query
    $recent_query = new WP_Query( $recent_args );

    if( $recent_query->have_posts() ):

        echo '<div class="recent-articles-inner masonry"><div class="grid-sizer"></div>';

            while( $recent_query->have_posts() ) : $recent_query->the_post();

               	get_template_part( 'components/post/content', get_post_format() );

                wp_reset_postdata();

            endwhile;

            wp_reset_query();

        echo '</div>';

    endif;

}



/* TODO: Regex some stuff! */
function fix_content_regex() {
	// find strings that match <p style="text-align:center;"> + Any characters + </p>
	// /(<p style="text-align:center;">).*(<\/p>)/g

	// find strings that match <li style="text-align:left;"> + Any characters + </li>
	// /(<li style="text-align:left;">).*(<\/li>)/g
}


