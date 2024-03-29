<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */

// Pull Masonry from the core of WordPress
wp_enqueue_script( 'masonry' );

get_header();
?>

<section id="primary" class="site-content">
	<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><span><?php echo single_cat_title( '', false ); ?></span></h1>

				<?php if ( category_description() ) : // Show an optional category description ?>
					<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->

			<div id="masonry">

			<?php
			/**
			 * Loop Iteration
			 *
			 * @var integer
			 */
			$iter = 0;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'grid' );

				// Every 7th post, insert an advertisment served via AdButler.
				if ( ( ++$iter %7 ) === 0 ) {
					get_template_part( 'template-parts/content', 'advertisement' );
				}

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

<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<?php //get_sidebar(); ?>
<?php endif; ?>

<?php get_footer();