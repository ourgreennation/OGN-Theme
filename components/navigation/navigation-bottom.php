<nav id="footer-navigation" class="footer-navigation" role="navigation">
	<button class="menu-toggle" aria-controls="bottom-menu" aria-expanded="false"><?php esc_html_e( 'Bottom Menu', 'ourgreennation' ); ?></button>
	<?php wp_nav_menu( array( 'theme_location' => 'bottom', 'menu_id' => 'bottom-menu', 'fallback_cb' => false ) ); ?>
</nav><!-- #site-navigation -->