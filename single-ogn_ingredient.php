<?php
/**
 * The Template for displaying all single ingredients.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
get_header();
?>

<div id="primary" class="site-content">
	<header class="entry-header<?php echo $header_class; ?>">

		<div class="table">
			<div class="table-cell">

				<h1 class="entry-title"><?php the_title(); ?><?php if(function_exists('sap_edit_post_link')) sap_edit_post_link(); ?></h1>

			</div>
		</div>

	</header>
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'ingredient' ); ?>

			<?php
                $post_status = get_post_status(get_the_ID());
                if ( 'publish' == $post_status || 'private' == $post_status ) {
                    comments_template( '', true );
                } ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_footer();
