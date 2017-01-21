<?php
/**
 * Register Customizations
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Register
 */

namespace Lift\OGN\Theme;

/**
 * Class: Register
 *
 * Customizes the OGN Register Experience.
 *
 * @since  v1.2.0
 */
final class Register {

	/**
	 * Register Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_hooks() {
		remove_action( 'bp_before_account_details_fields', 'wsl_render_auth_widget_in_wp_login_form' );
		add_action( 'bp_before_account_details_fields', array( $this, 'link_to_login' ) );
	}

	/**
	 * Render Link to Login
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function link_to_login() {
		?>
		<div class="ogn-register--before-fields">
			<a href="<?php echo esc_url( wp_login_url() ); ?>" class="button ogn-register--login-link">
				Members Log In Here
			</a>
		</div>
		<?php
	}
}
