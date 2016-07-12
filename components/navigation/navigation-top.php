<nav id="site-navigation" class="main-navigation" role="navigation">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php esc_html_e( 'Top Menu', 'ourgreennation' ); ?></button>
	<?php wp_nav_menu( array( 'theme_location' => 'top', 'menu_id' => 'top-menu', 'fallback_cb' => false ) ); ?>
</nav><!-- #site-navigation -->