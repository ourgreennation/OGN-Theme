<?php
/**
 * The template for displaying image content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

		<?php ourgreennation_before_post(); ?>

		<h3 class="entry-title"><?php the_title(); ?></h3>
		<?php if ( get_the_excerpt() ){ ?><div class="entry-summary"><?php the_excerpt(); ?></div><?php } ?>

	</article><!--/.post-->
