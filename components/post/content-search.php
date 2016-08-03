<?php
/**
 * The template for displaying quote content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if( has_post_thumbnail( $post->ID ) ) { ?>

			<div class="one-fourth first">
				<a class="post-image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $post->ID ); ?></a>
			</div>

			<div class="three-fourths">
				<?php if( get_the_title() ){ ?>
				<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php } ?>

				<?php the_excerpt(); ?>
			</div>

		<?php } else { ?>

			<?php if( get_the_title() ){ ?>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php } ?>

			<?php the_excerpt(); ?>

		<?php } ?>

	</article><!--/.post-->
