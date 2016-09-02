<?php
/**
 * The template for displaying aside content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<a class="frame" href="<?php the_permalink(); ?>">

			<div class="panel">
				<?php the_content(); ?>
			</div>

		</a>

	</article><!--/.post-->