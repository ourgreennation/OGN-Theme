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

			echo '<div class="one-third first">';

				the_post_thumbnail( 'large' );

			echo '</div>';

			echo '<div class="two-thirds">';

				the_title( '<h1 class="entry-title">', '</h1>' );

				echo '<div class="post-meta before-content">';
					$author_link = '<a href="' . get_author_posts_url( get_the_author_meta('ID') ) . '">' . get_the_author() . '</a>';
					echo '<span class="author">' . $author_link . '</span>';
				echo '</div><!--/.post-meta-->';

				the_content();

			echo '</div>';

			do_action( 'ogn_after_post' );

		endwhile; // End of the loop.
		?>

		</main>
	</div>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_footer();
