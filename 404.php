<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 */
get_header();
?>

<div id="primary" class="site-content">

	<div id="content" role="main">

		<article id="post-0" class="post error404 no-results not-found">

			<header class="entry-header">
				<h1 class="entry-title"><?php _e( '404', 'onesocial' ); ?></h1>
				<p><?php _e( 'We’re sorry, We seem to have lost this page, but We don’t want to lose You.', 'onesocial' ); ?></p>
			</header>

			<div class="entry-content">

				<?php dynamic_sidebar( 'four-oh-four' ); ?>

			</div>

		</article>

	</div>

</div>

<?php
get_footer();