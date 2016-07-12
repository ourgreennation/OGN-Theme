<?php
/**
 * The template for displaying image content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */

if( has_post_thumbnail() || ourgreennation_get_first_image() || ourgreennation_get_first_oembed() ):
	$post_class = 'vertical flip-container';
else:
	$post_class = '';
endif;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

		<div class="flipper">

			<div class="front">
				<?php ourgreennation_before_post(); ?>
			</div>

			<a class="back" href="<?php the_permalink(); ?>">
				<div class="vertical-center panel">
					<h3 class="entry-title"><?php the_title(); ?></h3>
					<?php if ( get_the_excerpt() ){ ?><div class="entry-summary"><?php the_excerpt(); ?></div><?php } ?>
				</div>
			</a>

		</div>

	</article><!--/.post-->
