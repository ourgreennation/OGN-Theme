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
		add_action( 'wp_head', array( $this, 'hotjar' ) );
		add_action( 'pre_get_posts', array( $this, 'search_pages' ) );
		add_action( 'wp', array( $this, 'custom_post_types_header' ) );
		add_action( 'wp', array( $this, 'redirect_anons_to_login' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_wpurp_styles' ), 999 );
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
		<!-- Hotjar Tracking Code for https://ourgreennation.org/ -->
		<script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:446128,hjsv:5};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
		<?php
	}

	/**
	 * Include Pages in WordPress Core Search
	 *
	 * @since  v1.2.0
	 * @param  \WP_Query $query WP_Query object.
	 * @return \WP_Query        WP_Query object.
	 */
	public function search_pages( \WP_Query $query ) {
		if ( ! is_admin() && $query->is_search ) {
			$query->set( 'post_type', array( 'post', 'page', 'tribe_events' ) );
		}

		return $query;
	}

	/**
	 * Ingredients Header
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function custom_post_types_header() {
		if ( is_singular( 'ogn_ingredient' ) || is_singular( 'ogn_book' ) ) {
			add_filter( 'onesocial_single_header', '__return_false' );
		}
	}

	/**
	 * Redirects anonymous site users to login
	 *
	 * Only redirects if they are on a single post page, or attempting to view a profile.
	 *
	 * @return void
	 */
	public function redirect_anons_to_login() {
		if ( ! is_user_logged_in() && ( is_single() || bp_is_user() ) ) {
			wp_safe_redirect( wp_login_url( get_permalink( get_queried_object_id() ) ) );
			exit;
		}
	}

	/**
	 * Dequeue WP Ultimate Recipe Styles that are unnecessary
	 *
	 * @return void
	 */
	public function dequeue_wpurp_styles() {
		wp_dequeue_style( 'wpurp_style1-css' );
		wp_dequeue_style( 'wpurp_style1' );
		wp_dequeue_style( 'font-awesome' );
	}
}
