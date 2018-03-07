<?php
/**
 * BuddyPress - Members Single Messages Compose
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<h2 class="bp-screen-reader-text"><?php
	/* translators: accessibility text */
	_e( 'Compose Message', 'jvfrmtd' );
?></h2>

<form action="<?php bp_messages_form_action('compose' ); ?>" method="post" id="send_message_form" class="" enctype="multipart/form-data">

	<?php

	/**
	 * Fires before the display of message compose content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_messages_compose_content' ); ?>
	<?php if ( bp_current_user_can( 'bp_moderate' ) ) : ?>
	<div class="form-group">
		<p><input type="checkbox" id="send-notice" name="send-notice" value="1" /> <?php _e( "This is a notice to all users.", 'jvfrmtd' ); ?></p>
	</div>
	<?php endif; ?>


	<div class="form-group">
	<ul class="first acfb-holder">
		<li>
			<?php bp_message_get_recipient_tabs(); ?>
			<label for="send-to-input"><?php _e("Send To (Username or Friend's Name)", 'jvfrmtd' ); ?></label>
			<input type="text" name="send-to-input" class="form-control send-to-input" id="send-to-input" />	
		</li>
	</ul>
	</div>

	

	<div class="form-group">
		<label for="subject"><?php _e( 'Subject', 'jvfrmtd' ); ?></label>
		<input type="text" name="subject" class="form-control" id="subject" value="<?php bp_messages_subject_value(); ?>" required>
	</div>


	<div class="form-group">
		<label for="message_content"><?php _e( 'Message', 'jvfrmtd' ); ?></label>
		<textarea name="content" class="form-control" rows="4" cols="40" id="message_content" required><?php bp_messages_content_value(); ?></textarea>
	</div>



	<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />

	<?php

	/**
	 * Fires after the display of message compose content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_messages_compose_content' ); ?>

	<div class="submit">
		<input type="submit" value="<?php esc_attr_e( "Send Message", 'jvfrmtd' ); ?>" name="send" id="send" />
	</div>

	<?php wp_nonce_field( 'messages_send_message' ); ?>
</form>