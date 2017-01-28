<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OneSocial Theme
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

<section id="primary" class="site-content">

	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .archive-header -->

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

	</div><!-- #content -->

</section><!-- #primary -->

<?php
get_footer();
