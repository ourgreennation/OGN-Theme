<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Our_Green_Nation
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php ourgreennation_before_post(); ?>

		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="post-content">
				<?php the_content(); ?>
		</div><!--/.post-content-->

		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'ourgreennation' ), 'after' => '</div>' ) ); ?>

	  <?php
	  if( comments_open() ) {
	  	comments_template();
	  }
	  ?>
	</article><!--/.post-->