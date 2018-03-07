<?php
/**
 * BuddyPress - Members Messages Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the members messages loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_messages_loop' ); ?>

<?php if ( bp_has_message_threads( bp_ajax_querystring( 'messages' ) ) ) : ?>

	<h2 class="bp-screen-reader-text"><?php
		/* translators: accessibility text */
		_e( 'Starred messages', 'jvfrmtd' );
	?></h2>



	<?php

	/**
	 * Fires after the members messages pagination display.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_messages_pagination' ); ?>

	<?php

	/**
	 * Fires before the members messages threads.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_messages_threads' ); ?>

	<form action="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() ?>/bulk-manage/" method="post" id="messages-bulk-management">

		<table id="message-threads" class="messages-notices table table-striped">

			<thead>
				<tr>
					<th scope="col" class="thread-checkbox bulk-select-all">
						<div class="checkbox">
							<input type="checkbox" id="select-all-messages">
							<label for="select-all-messages" ></label>
						</div>
					</th>

					<th scope="col" colspan="2" class="thread-from">
						<div class="messages-options-nav">
							<?php bp_messages_bulk_management_dropdown(); ?>
						</div><!-- .messages-options-nav -->
					</th>
					<th scope="col" colspan="3" class="thread-date">
						<div class="pagination no-ajax" id="user-pag">

							<div class="pagination-links" id="messages-dir-pag">
								<?php bp_messages_pagination(); ?>
							</div>

							<div class="pag-count" id="messages-dir-count">
								<?php bp_messages_pagination_count(); ?>
							</div>
						</div><!-- .pagination -->
					</th>
				</tr>
			</thead>

			<tbody>

				<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

					<tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if ( bp_message_thread_has_unread() ) : ?> unread<?php else: ?> read<?php endif; ?>">
						<td class="bulk-select-check">
							<div class="checkbox">
								<input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php bp_message_thread_id(); ?>" class="message-check" value="<?php bp_message_thread_id(); ?>" />
								<label for="bp-message-thread-<?php bp_message_thread_id(); ?>"><span class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								_e( 'Select this message', 'jvfrmtd' );
							?></span></label>
							</div>
						</td>

						<?php if ( bp_is_active( 'messages', 'star' ) ) : ?>
							<td class="thread-star">
								<?php bp_the_message_star_action_link( array( 'thread_id' => bp_get_message_thread_id() ) ); ?>
							</td>
						<?php endif; ?>

						<?php if ( 'sentbox' != bp_current_action() ) : ?>
							<td class="thread-from">
								<?php bp_message_thread_avatar( array( 'width' => 25, 'height' => 25 ) ); ?>
								<span class="from"><?php _e( 'From:', 'jvfrmtd' ); ?></span> <?php bp_message_thread_from(); ?>
								<?php echo bp_get_message_thread_total_and_unread_count_number( bp_get_message_thread_id() ); ?>
							</td>
						<?php else: ?>
							<td class="thread-from">
								<?php bp_message_thread_avatar( array( 'width' => 25, 'height' => 25 ) ); ?>
								<span class="to"><?php _e( 'To:', 'jvfrmtd' ); ?></span> <?php bp_message_thread_to(); ?>
								<?php echo bp_get_message_thread_total_and_unread_count_number( bp_get_message_thread_id() ); ?>
							</td>
						<?php endif; ?>

						<td class="thread-info">
							<div>
								<a href="<?php bp_message_thread_view_link(); ?>" data-toggle="tooltip" data-container="body" title="<?php bp_message_thread_excerpt(); ?>"><?php bp_message_thread_subject(); ?></a>
								<div class="tooltip tooltip-top" role="tooltip">
								  <div class="tooltip-arrow"></div>
								  <div class="tooltip-inner thread-excerpt">
									<?php bp_message_thread_excerpt(); ?>
								  </div>
								</div>
							</div>
						</td>


						<?php

						/**
						 * Fires inside the messages box table row to add a new column.
						 *
						 * This is to primarily add a <td> cell to the message box table. Use the
						 * related 'bp_messages_inbox_list_header' hook to add a <th> header cell.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_messages_inbox_list_item' ); ?>

						<td class="thread-date">
							<span class="activity"><?php echo bp_message_thread_last_post_date(strtotime(get_the_date())); ?></span>
						</td>

						<td class="thread-options">
							<?php if ( bp_message_thread_has_unread() ) : ?>
								<a class="read" href="<?php bp_the_message_thread_mark_read_url();?>"><i class="jvbpd-icon1-envelope"></i></a>
							<?php else : ?>
								<a class="unread" href="<?php bp_the_message_thread_mark_unread_url();?>"><i class="jvbpd-icon3-read-message"></i></a>
							<?php endif; ?>
								<a class="delete" href="<?php bp_message_thread_delete_link(); ?>"><i class="jvbpd-icon3-trash"></i></a>
							<?php

							/**
							 * Fires after the thread options links for each message in the messages loop list.
							 *
							 * @since 2.5.0
							 */
							do_action( 'bp_messages_thread_options' ); ?>
						</td>
					</tr>

				<?php endwhile; ?>

			</tbody>

		</table><!-- #message-threads -->

		<?php wp_nonce_field( 'messages_bulk_nonce', 'messages_bulk_nonce' ); ?>
	</form>

	<?php

	/**
	 * Fires after the members messages threads.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_messages_threads' ); ?>

	<?php

	/**
	 * Fires and displays member messages options.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_messages_options' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, no messages were found.', 'jvfrmtd' ); ?></p>
	</div>

<?php endif;?>

<?php

/**
 * Fires after the members messages loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_messages_loop' ); ?>
