<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Our_Green_Nation
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if( !is_home() && !is_front_page() && !bp_is_user() ){
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
		?>
	</header>
	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'our-green-nation' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-footer">
		<?php
			// edit_post_link(
			// 	sprintf(
			// 		/* translators: %s: Name of current post */
			// 		esc_html__( 'Edit %s', 'our-green-nation' ),
			// 		the_title( '<span class="screen-reader-text">"', '"</span>', false )
			// 	),
			// 	'<span class="edit-link">',
			// 	'</span>'
			// );
		?>
	</footer>
</article><!-- #post-## -->