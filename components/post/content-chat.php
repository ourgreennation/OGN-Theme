<?php
/**
 * The template for displaying chat content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php ourgreennation_before_post(); ?>

		<div class="panel">

			<?php if( get_the_title() ){ ?>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php } ?>

			<h4 class="entry-author"><?php the_author_posts_link(); ?></h4>

			<?php the_content(); ?>

		</div>

	</article><!--/.post-->