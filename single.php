<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Our_Green_Nation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			the_title( '<h1 class="entry-title">', '</h1>' );

			if( function_exists( 'get_field' ) && get_field( 'hook' ) ) {
				echo '<h3>' . get_field( 'hook' ) . '</h3>';
			}

			echo '<div class="post-meta before-content">';
				if( is_multi_author() ){
					$author_link = '<a href="' . get_author_posts_url( get_the_author_meta('ID') ) . '">' . get_the_author() . '</a>';
					echo '<span class="author">' . sprintf( __('Posted by %s on %s','our-green-nation' ), $author_link, get_the_date() ) . '</span>';
				} else {
					echo '<span class="author">' . get_the_date() . '</span>';
				}
			echo '</div><!--/.post-meta-->';

			the_post_thumbnail( 'large' );

			the_content();

			// the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			do_action( 'ogn_after_post' );

		endwhile; // End of the loop.
		?>

		</main>
	</div>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_footer();
