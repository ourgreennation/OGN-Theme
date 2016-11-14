<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Our_Green_Nation
 */

?>

	</div>

	<div class="site-before-footer-wrap wrap">
		<div class="site-before-footer">

		<?php dynamic_sidebar( 'sidebar-before-footer' ); ?>

		</div>
	</div>

	<footer id="colophon" class="site-footer-wrap wrap" role="contentinfo">
		<div class="site-footer">
			<?php get_template_part( 'components/navigation/navigation', 'bottom' ); ?>
			<?php get_template_part( 'components/footer/site', 'info' ); ?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>
