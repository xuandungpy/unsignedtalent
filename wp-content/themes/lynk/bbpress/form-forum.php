<?php

/**
 * New/Edit Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( bbp_is_forum_edit() ) : ?>

<div id="bbpress-forums" class="bbpress-wrapper">

	<?php bbp_breadcrumb(); ?>

	<?php bbp_single_forum_description( array( 'forum_id' => bbp_get_forum_id() ) ); ?>

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_forum_form() ) : ?>

	<div id="new-forum-<?php bbp_forum_id(); ?>" class="bbp-forum-form">

		<form id="new-post" name="new-post" method="post" action="<?php bbp_forum_permalink(); ?>">

			<?php do_action( 'bbp_theme_before_forum_form' ); ?>

			<fieldset class="bbp-form">
				<legend>

					<?php
						if ( bbp_is_forum_edit() ) :
							printf( esc_html__( 'Now Editing &ldquo;%s&rdquo;', 'jvfrmtd' ), bbp_get_forum_title() );
						else :
							bbp_is_single_forum()
								? printf( esc_html__( 'Create New Forum in &ldquo;%s&rdquo;', 'jvfrmtd' ), bbp_get_forum_title() )
								: esc_html_e( 'Create New Forum', 'jvfrmtd' );
						endif;
					?>

				</legend>

				<?php do_action( 'bbp_theme_before_forum_form_notices' ); ?>

				<?php if ( ! bbp_is_forum_edit() && bbp_is_forum_closed() ) : ?>

					<div class="bbp-template-notice">
						<ul>
							<li><?php esc_html_e( 'This forum is closed to new content, however your posting capabilities still allow you to post.', 'jvfrmtd' ); ?></li>
						</ul>
					</div>

				<?php endif; ?>

				<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

					<div class="bbp-template-notice">
						<ul>
							<li><?php esc_html_e( 'Your account has the ability to post unrestricted HTML content.', 'jvfrmtd' ); ?></li>
						</ul>
					</div>

				<?php endif; ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<div>

					<?php do_action( 'bbp_theme_before_forum_form_title' ); ?>

					<p>
						<label for="bbp_forum_title"><?php printf( esc_html__( 'Forum Name (Maximum Length: %d):', 'jvfrmtd' ), bbp_get_title_max_length() ); ?></label><br />
						<input type="text" id="bbp_forum_title" value="<?php bbp_form_forum_title(); ?>" size="40" name="bbp_forum_title" maxlength="<?php bbp_title_max_length(); ?>" />
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_title' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_content' ); ?>

					<?php bbp_the_content( array( 'context' => 'forum' ) ); ?>

					<?php do_action( 'bbp_theme_after_forum_form_content' ); ?>

					<?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

						<p class="form-allowed-tags">
							<label><?php esc_html_e( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:','jvfrmtd' ); ?></label><br />
							<code><?php bbp_allowed_tags(); ?></code>
						</p>

					<?php endif; ?>

					<?php
					// T2-6 bbp_allow_forum_mods()
					if ( function_exists( 'bbp_allow_forum_mods' ) && bbp_allow_forum_mods() && current_user_can( 'assign_moderators' ) ) : ?>

						<?php do_action( 'bbp_theme_before_forum_form_mods' ); ?>

						<p>
							<label for="bbp_moderators"><?php esc_html_e( 'Forum Moderators:', 'jvfrmtd' ); ?></label><br />
							<input type="text" value="<?php bbp_form_forum_moderators(); ?>" size="40" name="bbp_moderators" id="bbp_moderators" />
						</p>

						<?php do_action( 'bbp_theme_after_forum_form_mods' ); ?>

					<?php endif; ?>

					<?php do_action( 'bbp_theme_before_forum_form_type' ); ?>

					<p>
						<label for="bbp_forum_type"><?php esc_html_e( 'Forum Type:', 'jvfrmtd' ); ?></label><br />
						<?php bbp_form_forum_type_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_type' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_status' ); ?>

					<p>
						<label for="bbp_forum_status"><?php esc_html_e( 'Status:', 'jvfrmtd' ); ?></label><br />
						<?php bbp_form_forum_status_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_status' ); ?>

					<?php do_action( 'bbp_theme_before_forum_visibility_status' ); ?>

					<p>
						<label for="bbp_forum_visibility"><?php esc_html_e( 'Visibility:', 'jvfrmtd' ); ?></label><br />
						<?php bbp_form_forum_visibility_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_visibility_status' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_parent' ); ?>

					<p>
						<label for="bbp_forum_parent_id"><?php esc_html_e( 'Parent Forum:', 'jvfrmtd' ); ?></label><br />

						<?php
							bbp_dropdown( array(
								'select_id' => 'bbp_forum_parent_id',
								'show_none' => esc_html__( '&mdash; No parent &mdash;', 'jvfrmtd' ),
								'selected'  => bbp_get_form_forum_parent(),
								'exclude'   => bbp_get_forum_id()
							) );
						?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_parent' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_submit_wrapper' ); ?>

					<div class="bbp-submit-wrapper">

						<?php do_action( 'bbp_theme_before_forum_form_submit_button' ); ?>

						<button type="submit" id="bbp_forum_submit" name="bbp_forum_submit" class="button submit"><?php esc_html_e( 'Submit', 'jvfrmtd' ); ?></button>

						<?php do_action( 'bbp_theme_after_forum_form_submit_button' ); ?>

					</div>

					<?php do_action( 'bbp_theme_after_forum_form_submit_wrapper' ); ?>

				</div>

				<?php bbp_forum_form_fields(); ?>

			</fieldset>

			<?php do_action( 'bbp_theme_after_forum_form' ); ?>

		</form>
	</div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

	<div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
		<div class="bbp-template-notice">
			<ul>
				<li><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new content.', 'jvfrmtd' ), bbp_get_forum_title() ); ?></li>
			</ul>
		</div>
	</div>

<?php else : ?>

	<div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
		<div class="bbp-template-notice">
			<ul>
				<li><?php is_user_logged_in()
					? esc_html_e( 'You cannot create new forums.',               'jvfrmtd' )
					: esc_html_e( 'You must be logged in to create new forums.', 'jvfrmtd' );
				?></li>
			</ul>
		</div>
	</div>

<?php endif; ?>

<?php if ( bbp_is_forum_edit() ) : ?>

</div>

<?php endif;
