<?php
/**
 * The template for displaying link content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<a class="post-image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $post->ID ); ?></a>

		<div class="panel">

			<?php if( get_the_title() ){ ?>
			<h3 class="entry-title"><a href="<?php echo ourgreennation_get_link_url(); ?>"><?php the_title(); ?></a></h3>
			<?php } ?>

			<h4 class="entry-author"><?php the_author_posts_link(); ?></h4>

			<?php ourgreennation_post_excerpt( 20 ); ?>

		</div>

	</article><!--/.post-->