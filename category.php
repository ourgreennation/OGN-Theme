<?php
/**
 * The template for displaying category pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Our_Green_Nation
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						$cat_args = array(
 							'hierarchical' => 1,
 							'depth'	=> 0,
 							'child_of' => get_query_var('cat'),
							);
						wp_dropdown_categories( $cat_args );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header>

				<div class="masonry">

					<div class="grid-sizer"></div>

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'components/post/content', get_post_format() );

					endwhile;
					?>

				</div>

				<?php

				the_posts_navigation();

			else :

				get_template_part( 'components/post/content', 'none' );
			endif;
			?>

		</main>
	</div>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_footer();