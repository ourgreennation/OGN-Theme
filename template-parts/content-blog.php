<?php
/**
 * @package OneSocial Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/* post thumbnail */
	if ( has_post_thumbnail() ) { ?>
		<a class="entry-post-thumbnail<?php echo $thumb_class; ?>" href="<?php the_permalink(); ?>">

		<div class="masonry-title-overlay">
			<h3><?php the_title(); ?></h3>
		</div>

		<?php the_post_thumbnail('post-thumb'); ?>

		</a><?php
	} else { ?>
		<a class="no-entry-post-thumbnail" href="<?php the_permalink(); ?>">

			<h3><?php the_title(); ?></h3>

		</a><?php

	}
	?>

</article>