<?php
/**
 * The template for displaying vieo content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php ourgreennation_before_post(); ?>

	<div class="panel">

			<i class="fa fa-<?php echo get_post_format(); ?>" aria-hidden="true"></i>

			<?php if( get_the_title() ){ ?>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php } ?>

		<?php ourgreennation_post_excerpt( 20 ); ?>

	</div>

  </article><!--/.post-->