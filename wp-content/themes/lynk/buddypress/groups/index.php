<?php
/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress-inner">

	<?php

	/**
	 * Fires before the display of the groups.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups' ); ?>

	<?php

	/**
	 * Fires before the display of the groups content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_content' ); ?>

	<div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Groups directory main navigation', 'jvfrmtd' ); ?>">
		<ul>
			<li class="selected" id="groups-all"><a href="<?php bp_groups_directory_permalink(); ?>"><?php printf( __( 'All Groups %s', 'jvfrmtd' ), '<span>' . bp_get_total_group_count() . '</span>' ); ?></a></li>

			<?php if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>
				<li id="groups-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>"><?php printf( __( 'My Groups %s', 'jvfrmtd' ), '<span>' . bp_get_total_group_count_for_user( bp_loggedin_user_id() ) . '</span>' ); ?></a></li>
			<?php endif; ?>

			<?php

			/**
			 * Fires inside the groups directory group filter input.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_groups_directory_group_filter' ); 

			/**
			 * Fires inside the groups directory group types.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_groups_directory_group_types' ); ?>
			
			<li id="groups-search-form" class="last">
				<?php /* Backward compatibility for inline search form. Use template part instead. */ ?>
				<?php if ( has_filter( 'bp_directory_groups_search_form' ) ) : ?>

					<div id="group-dir-search" class="dir-search" role="search">
						<?php bp_directory_groups_search_form(); ?>
					</div><!-- #group-dir-search -->

				<?php else: ?>

					<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>

				<?php endif; ?>
			</li>

			<li id="groups-order-select" class="last filter">
					<select id="groups-order-by">
						<option data-tokens="active" value="active"><?php _e( 'Last Active', 'jvfrmtd' ); ?></option>
						<option data-tokens="popular" value="popular"><?php _e( 'Most Members', 'jvfrmtd' ); ?></option>
						<option data-tokens="newest" value="newest"><?php _e( 'Newly Created', 'jvfrmtd' ); ?></option>
						<option data-tokens="alphabetical" value="alphabetical"><?php _e( 'Alphabetical', 'jvfrmtd' ); ?></option>
					</select>
					<?php

					/**
					 * Fires inside the groups directory group order options.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_groups_directory_order_options' ); ?>
				</select>
			</li>
		</ul>
	</div>
	<form action="" method="post" id="groups-directory-form" class="dir-form">

		<div id="template-notices" role="alert" aria-atomic="true">
			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
			do_action( 'template_notices' ); ?>

		</div>

		

		<h2 class="bp-screen-reader-text"><?php
			/* translators: accessibility text */
			_e( 'Groups directory', 'jvfrmtd' );
		?></h2>

		<div id="groups-dir-list" class="groups dir-list">
			<?php bp_get_template_part( 'groups/groups-loop' ); ?>
		</div><!-- #groups-dir-list -->

		<?php

		/**
		 * Fires and displays the group content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_groups_content' ); ?>

		<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

		<?php

		/**
		 * Fires after the display of the groups content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_directory_groups_content' ); ?>

	</form><!-- #groups-directory-form -->

	<?php

	/**
	 * Fires after the display of the groups.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_groups_page' );
