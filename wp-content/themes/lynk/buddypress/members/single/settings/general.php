<?php
/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_before_member_settings_template' ); ?>

<h2 class="bp-screen-reader-text"><?php
	/* translators: accessibility text */
	_e( 'Account settings', 'jvfrmtd' );
?></h2>


<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="floating-labels" id="settings-form">

	<?php if ( !is_super_admin() ) : ?>
		<label for="pwd"><?php _e( 'Current Password <span>(required to update email or change current password)</span>', 'jvfrmtd' ); ?></label>
		<input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Password Lost and Found', 'jvfrmtd' ); ?>"><?php _e( 'Lost your password?', 'jvfrmtd' ); ?></a>
	<?php endif; ?>

	<div class="form-group">
		<input type="email" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="form-control" <?php bp_form_field_attributes( 'email' ); ?> required=""><span class="highlight"></span> <span class="bar"></span>
		<label for="email"><?php _e( 'Account Email', 'jvfrmtd' ); ?></label>
	</div>

	<div class="form-group">
		<input type="password" name="pass1" id="pass1" value="" class="form-control password-entry" data-toggle="tooltip" data-placement="bottom" title="" required="" data-original-title="<?php _e( 'Leave blank for no change', 'jvfrmtd' ); ?>"  <?php bp_form_field_attributes( 'passw' ); ?>><span class="highlight"></span> <span class="bar"></span>
        <label for="pass1"><?php _e( 'New Password', 'jvfrmtd' ); ?></label>
	</div>

	<label for="pass2" class="bp-screen-reader-text"><?php
		/* translators: accessibility text */
		_e( 'Repeat New Password', 'jvfrmtd' );
	?></label>

	<div class="form-group">
		<input type="password" name="pass2" id="pass2" value="" class="form-control password-entry-confirm" data-toggle="tooltip" data-placement="bottom" title="" required="" data-original-title="<?php _e( 'Repeat New Password', 'jvfrmtd' ); ?>"  <?php bp_form_field_attributes( 'passw' ); ?>><span class="highlight"></span> <span class="bar"></span>
        <label for="pass2"><?php _e( 'Repeat New Password', 'jvfrmtd' ); ?></label>
	</div>


	<?php

	/**
	 * Fires before the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes', 'jvfrmtd' ); ?>" id="submit" class="auto" />
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>



<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_after_member_settings_template' ); ?>
