<?php
/**
 * The template used for displaying hero content.
 *
 * @package Our_Green_Nation
 */
?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="ourgreennation-hero">
		<?php the_post_thumbnail( 'ourgreennation-hero' ); ?>
	</div>
<?php endif; ?>
