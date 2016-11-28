<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Our_Green_Nation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				// Hide content and load page builder scripts if selected for this page
				if( function_exists( 'get_field' ) && get_field( 'use_page_builder' ) ) {

					get_template_part( 'components/page/content', 'page-builder' );

				} else {

					get_template_part( 'components/page/content', 'page' );

				}

				// No Comments on pages
				// // If comments are open or we have at least one comment, load up the comment template.
				// if ( comments_open() || get_comments_number() ) :
				// 	comments_template();
				// endif;

			endwhile; // End of the loop.
			?>

		</main>
	</div>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_footer();