<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Our_Green_Nation
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'our-green-nation' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php echo get_search_form(); ?>

			<div id="masonry" class="masonry"><div class="grid-sizer"></div>

			<?php
			if ( have_posts() ) : ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'components/post/content', 'search' );

				endwhile;

			else :

				get_template_part( 'components/post/content', 'none' );

			endif; ?>

			</div><!-- /.masonry -->

			<?php the_posts_navigation(); ?>

		</main>
	</section>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_sidebar();
get_footer();