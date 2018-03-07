<?php
/**
 * BuddyPress - Groups Cover Image Header.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_header' );
$strContainerClass = 'enable' == jvbpd_tso()->get( 'bp_group_header_parallax', '' ) ? 'jv-parallax' : false;
$strContainerType = jvbpd_tso()->get('bp_group_navi_type', '' );
$strContainerClass .= ' ' . $strContainerType; ?>

<div id="cover-image-container" class="<?php echo esc_attr( $strContainerClass ); ?>" data-image="#header-cover-image" data-overlay=".bp-cover-overlay">
	<a id="header-cover-image" href="<?php echo esc_url( bp_get_group_permalink() ); ?>"></a>

	<div class="container item-header-cover-image-wrap">
	<div id="item-header-cover-image">
		<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
			<div id="item-header-avatar">
				<a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" data-jvbpd-tooltip="#group-avatar-content">
					<?php bp_group_avatar(); ?>
				</a>
			</div><!-- #item-header-avatar -->

			<script type="text/html" id="group-avatar-content">
				<div class="tooltip-wrap">
					<div class="tooltip-body">
						<h3 class="tooltip-title"><i class="fa fa-info-circle"></i>
							<?php esc_html_e( "Description", 'jvfrmtd' ); ?>
						</h3>
						<?php bp_group_description(); ?>
					</div>
					<div class="tooltip-footer">
						<i class="jvbpd-icon2-clock2"></i>
						<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>">
							<?php printf( __( 'active %s', 'jvfrmtd' ), bp_get_group_last_active() ); ?>
						</span>
					</div>
				</div>
			</script>

		<?php endif; ?>

		<div id="item-header-content">

			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<h2 class="user-nicename"><a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" title="<?php echo esc_attr( bp_get_group_name() ); ?>"><?php echo esc_attr( bp_get_group_name() ); ?></a></h2>
			<?php endif; ?>

			<div id="item-buttons"><?php

				/**
				 * Fires in the group header actions section.
				 *
				 * @since 1.2.6
				 */
				do_action( 'bp_group_header_actions' ); ?></div><!-- #item-buttons -->

			<?php

			/**
			 * Fires before the display of the group's header meta.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_group_header_meta' ); ?>

			<div id="item-meta">

				<?php

				/**
				 * Fires after the group header actions section.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_group_header_meta' ); ?>

				<div class="highlight"><?php bp_group_type(); ?></div>
				<?php bp_group_type_list(); ?>

			</div>
		</div><!-- #item-header-content -->

		<div id="item-actions">

			<?php if ( bp_group_is_visible() ) : ?>

				<h2><?php _e( 'Group Admins', 'jvfrmtd' ); ?></h2>

				<?php bp_group_list_admins();

				/**
				 * Fires after the display of the group's administrators.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_group_menu_admins' );

				if ( bp_group_has_moderators() ) :

					/**
					 * Fires before the display of the group's moderators, if there are any.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_before_group_menu_mods' ); ?>

					<h2><?php _e( 'Group Mods' , 'jvfrmtd' ); ?></h2>

					<?php bp_group_list_mods();

					/**
					 * Fires after the display of the group's moderators, if there are any.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_after_group_menu_mods' );

				endif;

			endif; ?>

		</div><!-- #item-actions -->

	</div><!-- #item-header-cover-image -->

	</div> <!-- container -->
	<div class="bp-cover-overlay"></div>
</div><!-- #cover-image-container -->
<div class="container <?php echo esc_attr( $strContainerType ); ?>">
	<div id="item-nav">
		<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Group primary navigation', 'jvfrmtd' ); ?>" role="navigation">
			<ul class="responsive-tabdrop">

				<?php bp_get_options_nav(); ?>

				<?php

				/**
				 * Fires after the display of group options navigation.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_group_options_nav' ); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->
	<div class="clear"></div>
</div>
<?php

/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_header' ); ?>

<div id="template-notices" role="alert" aria-atomic="true">
	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
	do_action( 'template_notices' ); ?>

</div>
