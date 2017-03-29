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
		add_action( 'bp_before_account_details_fields', array( $this, 'link_to_login' ), 10 );
		add_filter( 'bp_get_the_profile_field_options_checkbox', array( $this, 'disable_profile_pledges' ), 10, 5 );
		add_action( 'bp_before_account_details_fields', array( $this, 'username_hint' ), 15 );
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

	/**
	 * Disable Profile Pledges
	 *
	 * @since  v1.2.0
	 * @param  string    $html     Field markup.
	 * @param  \stdClass $obj      Option markup.
	 * @param  int       $field_id Field ID.
	 * @param  string    $selected Selected text.
	 * @param  int       $key      Key in field loop.
	 * @return string           HTML
	 */
	public function disable_profile_pledges( $html, $obj, $field_id, $selected, $key ) {
		if ( ! bp_is_user_profile_edit() || ! property_exists( $obj, 'name' ) || 'option' !== $obj->type ) {
			return $html;
		}

		// Conditions on which to act.
		$conditions = array(
			strpos( $obj->name, 'Member Pledge' ),
			strpos( $obj->name, 'Privacy Policy' ),
			);
		ob_start();
		?>
		<script>
			window.disablePledgeField = window.disablePledgeField || function(e) {
				e.target.checked = true;
			}
		</script>
		<?php
		// If conditions are met and we are agreeing, disable the checkbox if it's checked.
		if ( false !== strpos( $obj->name, 'I agree' ) && ! empty( array_filter( $conditions ) ) ) {
			$html = sprintf( '<label for="%3$s" class="option-label"><input %1$s type="checkbox" name="%2$s" id="%3$s" value="%4$s">%5$s</label>',
				( ! $selected ) ? $selected : $selected . ' onChange="window.disablePledgeField(event)"',
				esc_attr( "field_{$field_id}[]" ),
				esc_attr( "field_{$obj->id}_{$key}" ),
				esc_attr( stripslashes( $obj->name ) ),
				esc_html( stripslashes( $obj->name ) )
			) . ob_get_clean();
		}

		return $html;
	}

	/**
	 * Username Hint
	 *
	 * Instructs registree to use their real name in the username and name fields for ease
	 * of use and finding friends.
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function username_hint() {
		?>
		<p class="register--username__input-hint">
			To promote authenticity and optimum community functionality, please enter your real name for both username and name fields.
		</p>
		<?php
	}
}
