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


/*
 * CUSTOM LOGIN
 */
// Custom login stylesheet, loads only on login page
add_action( 'login_enqueue_scripts', 'ourgreennation_login_css' );
function ourgreennation_login_css() {
	echo '<link rel="stylesheet" id="custom_wp_admin_css"  href="' . get_stylesheet_directory_uri() . '/assets/css/login.css" type="text/css" media="all" />';
}

// Change login link from wordpress.org to the site url
add_filter( 'login_headerurl', 'ourgreennation_login_url' );
function ourgreennation_login_url() { return get_bloginfo( 'url' ); }

// Change alt text on logo to site title
add_filter( 'login_headertitle', 'ourgreennation_login_title' );
function ourgreennation_login_title() { return get_option( 'blogname' ); }


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

		// if( is_home() || is_front_page() ) {
		// 	$width  = apply_filters( 'ourgreennation_home_item_width', '33%' );
		// } else {
		// 	$width  = apply_filters( 'ourgreennation_archive_item_width', '50%' );
		// }
	 	$width  = apply_filters( 'ourgreennation_item_width', '380' );
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

	$target_width = apply_filters( 'ourgreennation_item_width', 380 );

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

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

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

	if( has_post_thumbnail( $post->ID ) ) {
		// return 'we have a thumbnail';
		return '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID ) . '</a>';
	}

	if( isset( $media_html ) ):
		$resized_html = preg_replace_callback( ourgreennation_height_width_regex(), "ourgreennation_modify_height_width_atts", $media_html );
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
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'our-green-nation' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous Artcile', 'our-green-nation' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next Article', 'our-green-nation' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older Articles', 'our-green-nation' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer Articles <span class="meta-nav">&rarr;</span>', 'our-green-nation' ) ); ?></div>
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


// Upcoming Events Owl Slider Display
// Note: section relies on The Events Calendar Pro
function ourgreennation_upcoming_events_carousel() {

    // WP_Query arguments
    $event_args = array (
        'post_type'  				=> 'tribe_events',
        'cache_results' 			=> true,
        'update_post_meta_cache' 	=> true,
        'update_post_term_cache' 	=> true,
        'ignore_sticky_posts'   	=> true,
        'posts_per_page'         	=> get_sub_field( 'number_of_events' ),
    );

    // The Query
    $event_query = new WP_Query( $event_args );

    if( $event_query->have_posts() ):

        echo '<div class="carousel">';
            echo '<div id="events-carousel" class="owl-carousel owl-theme">';

	            while( $event_query->have_posts() ) : $event_query->the_post();

					echo '<article id="item">';

						echo '<a class="frame" href="' . get_the_permalink() . '">';

							if( has_post_thumbnail() ) {
								echo get_the_post_thumbnail();
							} else {
								echo '<div class="no-event-image"><i class="fa fa-calendar"></i></div>';
							}

							echo '<div class="panel">';
								echo '<h3 class="entry-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';

								// echo '<div class="list-date">';
								// 	echo '<span class="list-dayname">' . tribe_get_start_date( null, true, 'M' ) . '</span>';
								// 	echo '<span class="list-daynumber">' . tribe_get_start_date( null, true, 'j' ) . '</span>';
								// echo '</div>';

								echo '<h3 class="event-start-date">' . tribe_get_start_date( null, true, 'M j g:i a' ) . '</h3>';
								echo '<h4 class="event-venue">' . tribe_get_venue() . '</h4>';
								// echo '<p class="event-full-address">' . tribe_get_full_address() . '</p>';
							echo '</div>';

						echo '</a>';

					echo '</article>';

	                wp_reset_postdata();

	            endwhile;

            	wp_reset_query();


            echo '</div>';
            // echo '<div class="customNavigation"><a class="btn prev fa fa-arrow-left"></a><a class="btn next fa fa-arrow-right"></a></div>';
        echo '</div>';

    endif;

}


// Popular Groups Owl Slider Display
// Note: section relies on BuddyPress
function ourgreennation_buddypress_carousel() {

	$group_args = array(
		'type'	=> 'popular',
		'max'	=> get_sub_field( 'number_of_groups' ),
		);

	if ( bp_has_groups( $group_args ) ) :


        echo '<div class="carousel">';
            echo '<div id="buddypress-carousel" class="owl-carousel owl-theme">';

			while ( bp_groups() ) : bp_the_group();
			?>
			    <article>
			        <div class="item-avatar">
			            <a href="<?php bp_group_permalink() ?>"><?php bp_group_avatar( '' ) ?></a>
			        </div>

			        <div class="panel">
			            <div class="entry-title"><a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a></div>
			            <div class="item-desc"><?php bp_group_description_excerpt() ?></div>

			            <?php // do_action( 'bp_directory_groups_item' ) ?>

			            <div class="meta">
			            	<?php bp_group_join_button() ?>
			                <?php bp_group_member_count() ?>
			            </div>

			            <?php // do_action( 'bp_directory_groups_actions' ) ?>
			        </div>
			    </article>
			<?php
			endwhile;

            echo '</div>';
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

       	echo '<div class="popular-articles-inner">';

            while( $popular_query->have_posts() ) : $popular_query->the_post();

            	echo '<article id="post-' . get_the_id() . '"><a href="' . get_the_permalink() . '">';

	            	if( has_post_thumbnail() ) {

		            	echo '<div class="one-fourth first">';
		            		the_post_thumbnail( 'thumbnail' );
		            	echo '</div>';

		            	echo '<div class="three-fourths">';
			            	the_title( '<h3 class="entry-title">', '</h3>' );
			            	the_excerpt();
		            	echo '</div>';

		            } else {

		            	the_title( '<h3 class="entry-title">', '</h3>' );
		            	the_excerpt();

		            }

            	echo '</a></article>';

            endwhile;

            wp_reset_query();

       	echo '</div>';

    endif;

}


// Popular Articles Display
function ourgreennation_content_popular_articles() {

	// Get number of columns for masonry
	$columns = get_sub_field( 'number_of_columns' );

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

    	// If we're not doing the home content/sidebar popular post layout
    	if( !get_field( 'home_popular_content' ) ) {
        	echo "<div class='popular-articles-inner {$columns} masonry'><div class='grid-sizer'></div>";
		}
            while( $popular_query->have_posts() ) : $popular_query->the_post();

               	get_template_part( 'components/post/content', get_post_format() );

                wp_reset_postdata();

            endwhile;

            wp_reset_query();

    	// If we're not doing the home content/sidebar popular post layout
        if( !get_field( 'home_popular_content' ) ) {
        	echo '</div>';
        }

    endif;

}


// Recent Articles Display
function ourgreennation_content_recent_articles() {

	// Get number of columns for masonry
	$columns = get_sub_field( 'number_of_columns' );

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

        echo "<div class='recent-articles-inner {$columns} masonry'><div class='grid-sizer'></div>";

            while( $recent_query->have_posts() ) : $recent_query->the_post();

               	get_template_part( 'components/post/content', get_post_format() );

                wp_reset_postdata();

            endwhile;

            wp_reset_query();

        echo '</div>';

    endif;

}



// Excerpt maker to limit strings by word count
function ourgreennation_string_limit_words( $string, $word_limit, $more = '&nbsp;&hellip;' ) {

    $words = explode( ' ', $string, ( $word_limit + 1 ) );
    if ( count( $words ) > $word_limit ) {
        array_pop( $words );
        $excerpt = implode( ' ', $words );
    } else {
        $excerpt = implode( ' ', $words );
    }

    $excerpt .= $more;

    return $excerpt;

}


// Create excerpts for posts with string limiter and HTML stripping
function ourgreennation_get_post_excerpt( $word_limit, $more = '&nbsp;&hellip;' ) {

	// Get the string that we'll be working with from the post content
	$string = ourgreennation_string_limit_words( get_the_content(), $word_limit, $more );

	// Strip HTML and slashes
	$post_excerpt = wp_strip_all_tags( wp_unslash( $string ) );

	return $post_excerpt;

}

// Echo ourgreennation_get_post_excerpt()
function ourgreennation_post_excerpt( $word_limit, $more = '&nbsp;&hellip;' ) {
	echo ourgreennation_get_post_excerpt( $word_limit, $more );
}


// Display tags below individual posts
function ourgreennation_display_single_post_tags( $content ) {

	if( is_single() ) {
		$tags_content = '';
		$posttags = get_the_tags();
		if( $posttags ) {
			$tags_content .= '<div class="post-tags">';
				foreach( $posttags as $tag ) {
					$tags_content .= '<a href="' . get_tag_link( $tag->term_id ) . '">#' . $tag->name . '</a>';
				}
			$tags_content .= '</div>';
		}

	return $content . $tags_content;

	}

	return $content;
}
add_filter( 'the_content', 'ourgreennation_display_single_post_tags', 15 );



// Hacky way to get "View More" at end of widgets that don't include it
function ourgreennation_widget_view_more_links($params) {

	if( is_active_widget( '', '', 'bp_groups_widget' ) ) {
		if( $params[0]['widget_name'] === '(BuddyPress) Groups' ) {
    		$params[0]['after_widget'] = '<p class="buddypress-groups-widget-link"><a href="' . get_site_url() . '/groups/" rel="bookmark">View More…</a></p></section>' ;
    	}
    	// var_dump($params);
	}
    return $params;
}
add_filter( 'dynamic_sidebar_params', 'ourgreennation_widget_view_more_links' );


// add_filter( 'bp_get_displayed_user_nav_user-friends', 'ourgreennation_change_friends_menu_link', 10, 2 );
function ourgreennation_change_friends_menu_link( $html, $nav_item ) {
    $args[0] = ( '<li id="' . $user_nav_item->css_id . '-personal-li" ' . $selected . '><a id="user-' . $user_nav_item->css_id . '" href="' . $link . '">My ' . $user_nav_item->name . '</a></li>' );
    return $args;
}


// Update profile page tab text
function ourgreennation_rename_profile_tabs() {

	buddypress()->members->nav->edit_nav( array( 'name' => __( 'My Friends', 'textdomain' ) ), 'friends' );
	buddypress()->members->nav->edit_nav( array( 'name' => __( 'My Groups', 'textdomain' ) ), 'groups' );

}
add_action( 'bp_actions', 'ourgreennation_rename_profile_tabs' );


/*
 * Moves the front-end ticket purchase form, accepts WP action/hook and optional hook priority
 *
 * @param $ticket_location_action WP Action/hook to display the ticket form at
 * @param $ticket_location_priority Priority for the WP Action
 */
function tribe_etp_move_tickets_purchase_form ( $ticket_location_action = '', $ticket_location_priority = 10 ) {
    if ( ! class_exists( 'Tribe__Tickets__Tickets') ) return;
    $etp_classes = array(
        'Easy_Digital_Downloads' =>     'Tribe__Tickets_Plus__Commerce__EDD__Main',
        'ShoppVersion' =>               'Tribe__Tickets_Plus__Commerce__Shopp__Main',
        'WP_eCommerce' =>               'Tribe__Tickets_Plus__Commerce__WPEC__Main',
        'Woocommerce' =>                'Tribe__Tickets_Plus__Commerce__WooCommerce__Main',
        'Tribe__Tickets__Tickets' =>    'Tribe__Tickets__RSVP',
    );
    foreach ( $etp_classes as  $ecommerce_class => $ticket_class) {
        if ( ! class_exists( $ecommerce_class ) || ! class_exists( $ticket_class ) ) continue;
        $form_display_function = array( $ticket_class::get_instance(), 'front_end_tickets_form' );
        if ( has_action ( 'tribe_events_single_event_after_the_meta', $form_display_function ) ) {
            remove_action( 'tribe_events_single_event_after_the_meta', $form_display_function, 5 );
            // add_action( $ticket_location_action, $form_display_function, $ticket_location_priority );
        }
    }
}
tribe_etp_move_tickets_purchase_form();



// Display ticket form below contnet
function ourgreennation_rsvp_tickets_placement( $content ) {

	if( class_exists( 'Tribe__Tickets__Tickets' ) ) {

		ob_start();
		$ticket_class = Tribe__Tickets__RSVP::get_instance();
		$ticket_content = $ticket_class->front_end_tickets_form( $content );
		$out = ob_get_clean();

	}

	return $content . $out;
}
add_filter( 'the_content', 'ourgreennation_rsvp_tickets_placement', 12 );


