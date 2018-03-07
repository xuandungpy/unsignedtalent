<?php
/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_members_page' ); ?>

<div id="buddypress-inner">

	<?php

	/**
	 * Fires before the display of the members.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members' ); ?>

	<?php

	/**
	 * Fires before the display of the members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_content' ); ?>

	<?php
	/**
	 * Fires before the display of the members list tabs.
	 *
	 * @since 1.8.0
	 */
	do_action( 'bp_before_directory_members_tabs' ); ?>
	<div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Members directory main navigation', 'jvfrmtd' ); ?>" role="navigation">
		<ul>
			<li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php printf( __( 'All Members %s', 'jvfrmtd' ), '<span>' . bp_get_total_member_count() . '</span>' ); ?></a></li>

			<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
				<li id="members-personal"><a href="<?php echo esc_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ); ?>"><?php printf( __( 'My Friends %s', 'jvfrmtd' ), '<span>' . bp_get_total_friend_count( bp_loggedin_user_id() ) . '</span>' ); ?></a></li>
			<?php endif; ?>

			<?php

			/**
			 * Fires inside the members directory member types.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_members_directory_member_types' ); ?>

			<?php

			/**
			 * Fires inside the members directory member sub-types.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_members_directory_member_sub_types' ); ?>

			<li class="member-search-form pull-right">
				<?php /* Backward compatibility for inline search form. Use template part instead. */ ?>
				<?php if ( has_filter( 'bp_directory_members_search_form' ) ) : ?>

					<div id="members-dir-search" class="dir-search" role="search">
						<?php //bp_directory_members_search_form(); ?>
						<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>
					</div><!-- #members-dir-search -->
					
				<?php else: ?>

					<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>

				<?php endif; ?>
			</li>

			<li id="members-order-select" class="last filter">
				<select id="members-order-by">
					<option data-tokens="active" value="active"><?php _e( 'Last Active', 'jvfrmtd' ); ?></option>
					<option data-tokens="popular" value="popular"><?php _e( 'Most Members', 'jvfrmtd' ); ?></option>
					<option data-tokens="newest" value="newest"><?php _e( 'Newly Created', 'jvfrmtd' ); ?></option>
					<?php if ( bp_is_active( 'xprofile' ) ) : ?>
					<option data-tokens="alphabetical" value="alphabetical"><?php _e( 'Alphabetical', 'jvfrmtd' ); ?></option>
					<?php endif; ?>
					<?php
					/**
					 * Fires inside the members directory member order options.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_members_directory_order_options' ); ?>
				</select>
			</li>
		</ul>
	</div>
	<form action="" method="post" id="members-directory-form" class="dir-form">

		

		<h2 class="bp-screen-reader-text"><?php
			/* translators: accessibility text */
			_e( 'Members directory', 'jvfrmtd' );
		?></h2>

		<div id="members-dir-list" class="members dir-list">
			<?php bp_get_template_part( 'members/members-loop' ); ?>
		</div><!-- #members-dir-list -->

		<?php

		/**
		 * Fires and displays the members content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_members_content' ); ?>

		<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

		<?php

		/**
		 * Fires after the display of the members content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_directory_members_content' ); ?>

	</form><!-- #members-directory-form -->

	<?php

	/**
	 * Fires after the display of the members.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members' ); ?>

</div><!-- #buddypress-inner -->

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_members_page' );
