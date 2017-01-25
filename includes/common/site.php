<?php
/**
 * Site Wide Customizations
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Site
 */

namespace Lift\OGN\Theme;

/**
 * Class: Site
 *
 * Customizes the OGN Site Experience.
 *
 * @since  v1.2.0
 */
final class Site {

	/**
	 * Site Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'wp_head', 'hotjar' );
	}

	/**
	 * Hot Jar
	 *
	 * Prints Hot Jar heat map analytics script to the head to be called async
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function hotjar() {
		?>
		<!-- Hotjar Tracking Code for ourgreennation.net -->
		<script>
		(function(h,o,t,j,a,r){
		h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		h._hjSettings={hjid:399009,hjsv:5};
		a=o.getElementsByTagName('head')[0];
		r=o.createElement('script');r.async=1;
		r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		a.appendChild(r);
		})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
		<?php
	}
}
