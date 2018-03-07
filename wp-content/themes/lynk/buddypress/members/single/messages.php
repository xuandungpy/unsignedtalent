<?php
/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

// Get current user id of the profile
 $user_info = get_userdata(bp_displayed_user_id());


?>

<div class="row item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'jvfrmtd' ); ?>" role="navigation">

	<div class="col-lg-2 col-md-2  col-sm-12 col-xs-12 inbox-panel">
		<div> <a href="<?php echo esc_url(home_url('members/'.$user_info->user_login.'/messages/compose/')); ?>" class="btn btn-primary btn-block"><?php _e( 'Compose', 'jvfrmtd' ); ?></a>
			<div class="list-group mail-list m-t-20">
				<a href="<?php echo esc_url(home_url('members/'.$user_info->user_login.'/messages/')); ?>" class="list-group-item active"><?php _e( 'Inbox', 'jvfrmtd' ); ?> <span class="label label-rouded label-primary pull-right counter"><?php bp_total_unread_messages_count() ?></span></a>
				<?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
				<a href="<?php echo esc_url(home_url('members/'.$user_info->user_login.'/messages/starred/')); ?>" class="list-group-item "><?php _e( 'Starred', 'jvfrmtd' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url(home_url('members/'.$user_info->user_login.'/messages/sentbox/')); ?>" class="list-group-item"><?php _e( 'Sent', 'jvfrmtd' ); ?></a>
				<a href="<?php echo esc_url(home_url('members/'.$user_info->user_login.'/messages/notices/')); ?>" class="list-group-item"><?php _e( 'Notice', 'jvfrmtd' ); ?></a>
			</div>
		</div>
	</div>
		<?php //bp_get_options_nav(); ?>

	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mail_listing">
		<div class="inbox-center">
			<?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>
				<div class="message-search"><?php bp_message_search_form(); ?></div>
			<?php endif; ?>
			<?php
			switch ( bp_current_action() ) :

				// Inbox/Sentbox
				case 'inbox'   :
				case 'sentbox' :

					/**
					 * Fires before the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_before_member_messages_content' ); ?>

					<?php if ( bp_is_messages_inbox() ) : ?>
						<h2 class="bp-screen-reader-text"><?php
							/* translators: accessibility text */
							_e( 'Messages inbox', 'jvfrmtd' );
						?></h2>
					<?php elseif ( bp_is_messages_sentbox() ) : ?>
						<h2 class="bp-screen-reader-text"><?php
							/* translators: accessibility text */
							_e( 'Sent Messages', 'jvfrmtd' );
						?></h2>
					<?php endif; ?>

					<div class="messages">
						<?php bp_get_template_part( 'members/single/messages/messages-loop' ); ?>
					</div><!-- .messages -->

					<?php

					/**
					 * Fires after the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_after_member_messages_content' );
					break;

				// Single Message View
				case 'view' :
					bp_get_template_part( 'members/single/messages/single' );
					break;

				// Compose
				case 'compose' :
					bp_get_template_part( 'members/single/messages/compose' );
					break;

				// Sitewide Notices
				case 'notices' :

					/**
					 * Fires before the member messages content for notices.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_before_member_messages_content' ); ?>

					<h2 class="bp-screen-reader-text"><?php
						/* translators: accessibility text */
						_e( 'Sitewide Notices', 'jvfrmtd' );
					?></h2>

					<div class="messages">
						<?php bp_get_template_part( 'members/single/messages/notices-loop' ); ?>
					</div><!-- .messages -->

					<?php

					/**
					 * Fires after the member messages content for inbox and sentbox.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_after_member_messages_content' );
					break;

				// Any other
				default :
					bp_get_template_part( 'members/single/plugins' );
					break;
			endswitch;
			?>

		</div> <!-- inbox-center -->
	</div> <!-- mail_listing -->
</div><!-- row .item-list-tabs -->
