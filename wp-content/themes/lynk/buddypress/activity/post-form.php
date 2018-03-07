<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form" class="floating-labels">

	<?php

	/**
	 * Fires before the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_activity_post_form' ); ?>


	<div class="row">
		<div class="col-md-1">
			<div id="whats-new-avatar">
				<a href="<?php echo bp_loggedin_user_domain(); ?>">
					<?php bp_loggedin_user_avatar( 'width=' . bp_core_avatar_thumb_width() . '&height=' . bp_core_avatar_thumb_height() ); ?>
				</a>
			</div>
		</div>
		<div class="col-md-11">
			<div class="form-group">
				<textarea name="whats-new" class="form-control" rows="1" cols="40" id="whats-new" required="" <?php if ( bp_is_group() ) : ?>data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" <?php endif; ?>><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?></textarea>
				<span class="bar"></span>
				<label for="whats-new">
					<?php if ( bp_is_group() )
					printf( __( "What's new in %s, %s?", 'jvfrmtd' ), bp_get_group_name(), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
					else
					printf( __( "What's new, %s?", 'jvfrmtd' ), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
					?>						
					<?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?>
				</label>
			</div>				
		</div>
	</div>

		<div id="whats-new-options2">
			<?php do_action( 'bp_after_activity_post_form' ); ?>
			<div id="whats-new-submit">
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e( 'Post Update', 'jvfrmtd' ); ?>" />
			</div>

			<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() ) : ?>
				<div id="whats-new-post-in-box">
					
					<label for="whats-new-post-in" class=""><?php
						/* translators: accessibility text */
						_e( 'Post in:', 'jvfrmtd' );
					?></label>
					<select id="whats-new-post-in" name="whats-new-post-in">
						<option selected="selected" value="0"><?php _e( 'My Profile', 'jvfrmtd' ); ?></option>

						<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
							while ( bp_groups() ) : bp_the_group(); ?>

								<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

							<?php endwhile;
						endif; ?>

					</select>
				</div>
				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />

			<?php elseif ( bp_is_group_activity() ) : ?>

				<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
				<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

			<?php endif; ?>

			<?php
			/**
			 * Fires at the end of the activity post form markup.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_activity_post_form_options' ); ?>
		</div><!-- #whats-new-options -->

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
</form><!-- #whats-new-form -->
