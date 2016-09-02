<?php
/**
 * The template for displaying quote content. Used within any masonry/archive/index template.
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php ourgreennation_before_post(); ?>

	    <a class="frame" href="<?php the_permalink(); ?>">

	    	<?php the_content(); ?>

	    </a>

	</article><!--/.post-->