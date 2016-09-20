<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Our_Green_Nation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		// if( !is_home() && !is_front_page() ){
		// 	the_title( '<h1 class="entry-title">', '</h1>' );
		// }
		?>
	</header>
	<div class="entry-content">
		<?php

		ourgreennation_page_content();

		?>
	</div>
	<footer class="entry-footer">
		<?php
			// edit_post_link(
			// 	sprintf(
			// 		/* translators: %s: Name of current post */
			// 		esc_html__( 'Edit %s', 'our-green-nation' ),
			// 		the_title( '<span class="screen-reader-text">"', '"</span>', false )
			// 	),
			// 	'<span class="edit-link">',
			// 	'</span>'
			// );
		?>
	</footer>
</article><!-- #post-## -->



<?php
// Scripts for specific page builder settings
add_action( 'wp_footer', 'ourgreennation_page_content_scripts' );
function ourgreennation_page_content_scripts() {

	// check if the flexible content field has rows of data
	if( have_rows('content_area') ):

	     // loop through the rows of data
	    while ( have_rows('content_area') ) : the_row();

	        if( get_row_layout() == 'general_content' ): // General Content Layout

	        elseif( get_row_layout() == 'full_width_background_content' ): // Content and Primary Sidebar

	        elseif( get_row_layout() == 'image_content' ): // Half Image, Half Content Layout

	        elseif( get_row_layout() == 'popular_articles' ): // Popular Articles

	        elseif( get_row_layout() == 'recent_articles' ): // Recent Articles

	        elseif( get_row_layout() == 'upcoming_events' ): // Slider of Upcoming Events

	        	// Owl Carousel scripts and styles
				wp_enqueue_script( 'ourgreennation-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery') );
				wp_enqueue_style( 'ourgreennation-owl-carousel-style', get_template_directory_uri() . '/assets/css/owl.carousel.min.css' );
				wp_enqueue_style( 'ourgreennation-owl-carousel-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css' );

				?>
				<script>
				(function( $ ) {

				  "use strict";

				  $(function() {
				      var owl = $("#events-carousel");

					  owl.owlCarousel({
					      items : 4, // 4 items above 1000px browser width
					      itemsDesktop : [1000,4], // 4 items between 1000px and 901px
					      itemsDesktopSmall : [960,3], // 3 items betweem 960px and 721px
					      itemsTablet: [720,2], // 2 items between 720 and 601
					      itemsMobile : [600,1], // 1 item between 600 and 0
					      dots: false,
					      nav: true,
					      margin: 20,
					      stagePadding: 20,
					      loop: true,
					      navText: [ '<span class="fa fa-chevron-left">', '<span class="fa fa-chevron-right">' ],
					  });
				  });

				}(jQuery));
				</script>
				<?php

	        elseif( get_row_layout() == 'buddypress_groups' ): // Slider of Upcoming Events

	        	// Owl Carousel scripts and styles
				wp_enqueue_script( 'ourgreennation-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery') );
				wp_enqueue_style( 'ourgreennation-owl-carousel-style', get_template_directory_uri() . '/assets/css/owl.carousel.min.css' );
				wp_enqueue_style( 'ourgreennation-owl-carousel-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css' );

				?>
				<script>
				(function( $ ) {

				  "use strict";

				  $(function() {
				      var owl = $("#buddypress-carousel");

					  owl.owlCarousel({
					      items : 4, // 4 items above 1000px browser width
					      itemsDesktop : [1000,4], // 4 items between 1000px and 901px
					      itemsDesktopSmall : [960,3], // 3 items betweem 960px and 721px
					      itemsTablet: [720,3], // 2 items between 720 and 601
					      itemsMobile : [600,2], // 1 item between 600 and 0
					      dots: false,
					      nav: true,
					      margin: 20,
					      stagePadding: 20,
					      loop: true,
					      navText: [ '<span class="fa fa-chevron-left">', '<span class="fa fa-chevron-right">' ],
					  });

					  // Custom Navigation Events
					  $(".next").click(function(){
					    owl.trigger('owl.next');
					  })
					  $(".prev").click(function(){
					    owl.trigger('owl.prev');
					  })
				  });

				}(jQuery));
				</script>
				<?php

	        elseif( get_row_layout() == 'home_popular_content' ): // Home Popular Content

	        elseif( get_row_layout() == 'content_carousel' ): // Slider of Client Images
				?>
				<script>
				(function( $ ) {

				  "use strict";

				  $(function() {
				      var owl = $("#owl-carousel");

					  owl.owlCarousel({
					      items : 4, // 4 items above 1000px browser width
					      itemsDesktop : [1000,4], // 4 items between 1000px and 901px
					      itemsDesktopSmall : [960,3], // 3 items betweem 960px and 721px
					      itemsTablet: [720,2], // 2 items between 720 and 601
					      itemsMobile : [600,1], // 1 item between 600 and 0
					      dots: false,
					      nav: false,
					      rewind: true,
					      infinite: true,
					      // navText: [ '<span class="fa fa-angle-left">', '<span class="fa fa-angle-right">' ],
					  });

					  // Custom Navigation Events
					  $(".next").click(function(){
					    owl.trigger('owl.next');
					  })
					  $(".prev").click(function(){
					    owl.trigger('owl.prev');
					  })
				  });

				}(jQuery));
				</script>
				<?php
	        endif; // Section Blocks

	    endwhile;

	else :

	    // no layouts found

	endif;

}




function ourgreennation_page_content() {

	// check if the flexible content field has rows of data
	if( have_rows('content_area') ):

	     // loop through the rows of data
	    while ( have_rows('content_area') ) : the_row();



	        if( get_row_layout() == 'general_content' ): // General Content Layout

	        	echo '<section class="general-content single-column" style="background-color:' . get_sub_field( 'background_color' ) . ';"><div class="wrap">';
	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}
	        		echo get_sub_field( 'content' );
	        	echo '</div></section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'full_width_background_content' ): // Full-Width Background Content Layout

	        	// Get background image to display
	        	$bg_img = get_sub_field( 'background_image' );
	        	$bg_img_url = $bg_img['url'];

	        	echo '<section class="single-column full-background" style="background-image: url(' . $bg_img_url . ');">';
		        	echo '<div class="full-background-overlay" style="background-color:' . get_sub_field( 'background_color' ) . ';"></div>';
		        	echo '<div class="wrap">';

		        		if( get_sub_field( 'headline' ) ) {
	                        echo '<h3 style="color:' . get_sub_field( 'headline_color' ) . ';">' . get_sub_field( 'headline' ) . '</h3>';
	                        // echo '<div class="headline-border" style="background-color: #FFFFFF"></div>';
	                    }

	                    if( get_sub_field( 'subheadline' ) ) {
	                        echo '<h4 style="color:' . get_sub_field( 'subheadline_color' ) . ';">' . get_sub_field( 'subheadline' ) . '</h4>';
	                    }

	                    if( get_sub_field( 'cta_button_link' ) && get_sub_field( 'cta_button_text' ) ) {
	                    	echo '<p><a class="button" href="' . get_sub_field( 'cta_button_link' ) . '" />' . get_sub_field( 'cta_button_text' ) . '</a></p>';
						}

		        	echo '</div>';
	        	echo '</section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'full_width_background_video' ): // Full-Width Background Video Layout

	        	// Get background image to display
	        	$bg_img = get_sub_field( 'background_image' );
	        	$bg_img_url = $bg_img['url'];

	        	echo '<section class="single-column full-background background-video">';

                    if( get_sub_field( 'background_video' ) ) {
                        echo '<div class="background-video-container">' . get_sub_field( 'background_video' ) . '</div>';
                    }

		        	// echo '<div class="full-background-overlay" style="background-color:' . get_sub_field( 'background_color' ) . ';"></div>';
		        	echo '<div class="wrap">';

		        		if( get_sub_field( 'headline' ) ) {
	                        echo '<h3 style="color:' . get_sub_field( 'headline_color' ) . ';">' . get_sub_field( 'headline' ) . '</h3>';
	                        // echo '<div class="headline-border" style="background-color: #FFFFFF"></div>';
	                    }

	                    if( get_sub_field( 'subheadline' ) ) {
	                        echo '<h4 style="color:' . get_sub_field( 'subheadline_color' ) . ';">' . get_sub_field( 'subheadline' ) . '</h4>';
	                    }

	                    if( get_sub_field( 'cta_button_link' ) && get_sub_field( 'cta_button_text' ) ) {
	                    	echo '<p><a class="button" href="' . get_sub_field( 'cta_button_link' ) . '" />' . get_sub_field( 'cta_button_text' ) . '</a></p>';
						}

		        	echo '</div>';
	        	echo '</section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'image_content' ): // Half Image, Half Content Layout

	        	// Get background image to display on half of image/content layout
	        	$bg_img = get_sub_field( 'background_image' );
	        	$bg_img_url = $bg_img['url'];
				$bg_img_w = $bg_img['width'];
				$bg_img_h = $bg_img['height'];

				// Determine positioning of image
	        	if( get_sub_field( 'image_position') == 'Left' ) {
	        		$first = 'first';
					$position = 'left: 0;';
				} elseif( get_sub_field( 'image_position') == 'Right' ) {
					$first = '';
					$position = 'right: 0;';
				}

	        	echo '<section class="image-content single-column" style="background-color:' . get_sub_field( 'background_color' ) . '">';

		        	echo '<div class="wrap">';
						echo '<div class="image-background" style="background-image: url(' . $bg_img_url. '); ' . $position . '"></div>';

		        		echo '<div class="one-half ' . $first . '">&nbsp;</div>';
		        		echo '<div class="one-half">';
		        			if( get_sub_field( 'content_headline' ) ) {
				        		echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
				        		// echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
				        	}
			        		echo get_sub_field( 'content' );
		        		echo '</div>';
		        	echo '</div>';
	        	echo '</section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'popular_articles' ): // Popular Articles Layout

	        	echo '<section class="popular-articles single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
		        		echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
		        		// echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
		        	}

	        		ourgreennation_content_popular_articles();

	        	echo '</div></section>';





	        elseif( get_row_layout() == 'recent_articles' ): // Recent Articles Layout

	        	echo '<section class="recent-articles single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			// echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
					}

	        		ourgreennation_content_recent_articles();

	        	echo '</div></section>';





	        elseif( get_row_layout() == 'upcoming_events' ): // Slider of Upcoming Events


	        	// Get background image to display
	        	$bg_img = get_sub_field( 'background_image' );
	        	$bg_img_url = $bg_img['url'];

	        	echo '<section class="single-column upcoming-events" style="background-image: url(' . $bg_img_url . ');">';
		        	echo '<div class="full-background-overlay" style="background-color:' . get_sub_field( 'background_color' ) . ';"></div>';
		        	echo '<div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			// echo '<div class="headline_border" style="color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}

	        		if( get_sub_field( 'subheadline' ) ) {
	        			echo '<h3 class="subheadline" style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'subheadline' ) . '</h3>';
	        		}

	        		echo get_sub_field( 'content' );

	        		ourgreennation_upcoming_events_carousel();

	        		echo '<a href="/events/" class="button button-green home-section-button">View More</a>';

	        		echo '</div>';
	        	echo '</section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'home_popular_content' ): // Home Popular Articles Content

	        	echo '<section class="home-popular-content single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		echo '<div class="two-thirds first">';

		        		if( get_sub_field( 'content_headline' ) ) {
			        		echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
			        		// echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
			        	}

		        		ourgreennation_no_masonry_articles();

	        		echo '</div>';

	        		echo '<div class="one-third">';

	        			dynamic_sidebar( 'sidebar-home-popular-content' );

	        		echo '</div>';

	        	echo '</div></section>';





	        elseif( get_row_layout() == 'content_carousel' ): // Slider of Client Images

	        	echo '<section class="single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2>' . get_sub_field( 'content_headline' ) . '</h2>';
	        			// echo '<div class="headline_border" style="color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}

	        		echo get_sub_field( 'content' );

	        		ourgreennation_content_carousel();

	        	echo '</div></section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;




	        elseif( get_row_layout() == 'buddypress_groups' ): // Slider of Popular BuddyPress Groups

	        	echo '<section class="single-column buddypress-groups" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			// echo '<div class="headline_border" style="color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}

	        		if( get_sub_field( 'subheadline' ) ) {
	        			echo '<h3 class="subheadline" style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'subheadline' ) . '</h3>';
	        		}

	        		ourgreennation_buddypress_carousel();

	        		echo '<a href="/groups/" class="button button-green home-section-button">View More</a>';

	        	echo '</div></section>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;



	        endif; // Section Blocks

	    endwhile;

	else :

	    // no layouts found

	endif;

}