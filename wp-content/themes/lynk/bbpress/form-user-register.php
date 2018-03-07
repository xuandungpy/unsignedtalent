<?php

/**
 * User Registration Form
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
	<fieldset class="bbp-form">
		<legend><?php esc_html_e( 'Create an Account', 'jvfrmtd' ); ?></legend>

		<?php do_action( 'bbp_template_before_register_fields' ); ?>

		<div class="bbp-template-notice">
			<ul>
				<li><?php esc_html_e( 'Your username must be unique, and cannot be changed later.',                        'jvfrmtd' ); ?></li>
				<li><?php esc_html_e( 'We use your email address to email you a secure password and verify your account.', 'jvfrmtd' ); ?></li>
			</ul>
		</div>

		<div class="bbp-username">
			<label for="user_login"><?php esc_html_e( 'Username', 'jvfrmtd' ); ?>: </label>
			<input type="text" name="user_login" value="<?php bbp_sanitize_val( 'user_login' ); ?>" size="20" id="user_login" />
		</div>

		<div class="bbp-email">
			<label for="user_email"><?php esc_html_e( 'Email', 'jvfrmtd' ); ?>: </label>
			<input type="text" name="user_email" value="<?php bbp_sanitize_val( 'user_email' ); ?>" size="20" id="user_email" />
		</div>

		<?php do_action( 'register_form' ); ?>

		<div class="bbp-submit-wrapper">

			<button type="submit" name="user-submit" class="button submit user-submit"><?php esc_html_e( 'Register', 'jvfrmtd' ); ?></button>

			<?php bbp_user_register_fields(); ?>

		</div>

		<?php do_action( 'bbp_template_after_register_fields' ); ?>

	</fieldset>
</form>
