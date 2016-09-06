<div class="site-menu-bar">
	<div class="site-menu">
		<div class="site-menu-inner">
			<div class="site-logo">
				<?php
				if ( function_exists( 'the_custom_logo' ) ) {

					the_custom_logo();

				} else {

					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif;

				}
				?>
			</div><!-- .site-logo -->
			<div class="site-menu-navigation">
				<?php
				get_search_form();
				// ourgreennation_get_login_button();
				wp_nav_menu( array( 'theme_location' => 'menu-bar', 'menu_id' => 'menu-bar-menu', 'menu_class' => 'site-navigation sm sm-clean', 'fallback_cb' => false ) );
				?>
			</div>
		</div>
	</div>
</div><!-- .site-menu-bar -->