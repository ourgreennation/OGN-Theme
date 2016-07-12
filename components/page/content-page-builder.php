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
		if( !is_home() && !is_front_page() ){
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
		?>
	</header>
	<div class="entry-content">
		<?php

		ourgreennation_page_content();

		?>
	</div>
	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'ourgreennation' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
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
					      nav: true,
					      rewind: true,
					      navText: [ '<span class="fa fa-angle-left">', '<span class="fa fa-angle-right">' ],
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

	        	echo '<div class="single-column" style="background-color:' . get_sub_field( 'background_color' ) . ';"><div class="wrap">';
	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}
	        		echo get_sub_field( 'content' );
	        	echo '</div></div>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'full_width_background_content' ): // Full-Width Background Content Layout

	        	// Get background image to display
	        	$bg_img = get_sub_field( 'background_image' );
	        	$bg_img_url = $bg_img['url'];

	        	echo '<div class="single-column full-background" style="background-color:' . get_sub_field( 'background_color' ) . '; background-image: url(' . $bg_img_url . ');"><div class="wrap">';

	        		if( get_sub_field( 'headline' ) ) {
                        echo '<h3>' . get_sub_field( 'headline' ) . '</h3>';
                        echo '<div class="headline-border" style="background-color: #FFFFFF"></div>';
                    }

                    if( get_sub_field( 'subheadline' ) ) {
                        echo '<h4>' . get_sub_field( 'subheadline' ) . '</h4>';
                    }

                    echo '<p><a class="button slide-button" href="' . get_sub_field( 'cta_button_link' ) . '" />' . get_sub_field( 'cta_button_text' ) . '</a></p>';

	        	echo '</div></div>';

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

	        	echo '<div class="image-content single-column" style="background-color:' . get_sub_field( 'background_color' ) . '">';

		        	echo '<div class="wrap">';
						echo '<div class="image-background" style="background-image: url(' . $bg_img_url. '); ' . $position . '"></div>';

		        		echo '<div class="one-half ' . $first . '">&nbsp;</div>';
		        		echo '<div class="one-half">';
		        			if( get_sub_field( 'content_headline' ) ) {
				        		echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
				        		echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
				        	}
			        		echo get_sub_field( 'content' );
		        		echo '</div>';
		        	echo '</div>';
	        	echo '</div>';

	        	$block_arrow = get_sub_field( 'block_arrow' );
	        	if( $block_arrow ) :
	        		echo '<div class="block-arrow" style="border-top: 40px solid ' . get_sub_field( 'background_color' ) . '"></div>';
	        	endif;





	        elseif( get_row_layout() == 'popular_articles' ): // Popular Articles Layout

	        	echo '<div class="popular-articles single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
		        		echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
		        		echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
		        	}

	        		ourgreennation_content_popular_articles();

	        	echo '</div></div>';





	        elseif( get_row_layout() == 'recent_articles' ): // Recent Articles Layout

	        	echo '<div class="recent-articles single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2 style="color: ' . get_sub_field( 'headline_underline_color' ) . '">' . get_sub_field( 'content_headline' ) . '</h2>';
	        			echo '<div class="headline-border" style="background-color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
					}

	        		ourgreennation_content_recent_articles();

	        	echo '</div></div>';





	        elseif( get_row_layout() == 'content_carousel' ): // Slider of Client Images

	        	echo '<div class="single-column" style="background-color:' . get_sub_field( 'background_color' ) . '"><div class="wrap">';

	        		if( get_sub_field( 'content_headline' ) ) {
	        			echo '<h2>' . get_sub_field( 'content_headline' ) . '</h2>';
	        			echo '<div class="headline_border" style="color: ' . get_sub_field( 'headline_underline_color' ) . '"></div>';
	        		}

	        		echo get_sub_field( 'content' );

	        		ourgreennation_content_carousel();

	        	echo '</div></div>';

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