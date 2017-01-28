<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */

// Pull Masonry from the core of WordPress
wp_enqueue_script( 'masonry' );

get_header();

?>

<script type="text/javascript">
jQuery(window).load(function() {
	var container = document.querySelector('#masonry');
	var msnry = new Masonry( container, {
		itemSelector : '.hentry',
		columnWidth  : '.hentry',
		gutter       : 20,
		isFitWidth   : true,
	});

});
</script>

<div id="primary" class="site-content">

	<header class="page-header dir-header">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'onesocial' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header>

	<div id="content" role="main" class="search-content-wrap">

		<section class="search-content">

			<?php if ( have_posts() ) : ?>

			<div id="masonry">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'grid' );

			endwhile;
			?>

			</div>

			<div class="pagination-below">
				<?php buddyboss_pagination(); ?>
			</div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</section>

	</div>

</div>

<?php

get_footer();
