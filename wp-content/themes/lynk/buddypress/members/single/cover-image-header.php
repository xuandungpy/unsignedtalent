<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' );
$strContainerClass = 'enable' == jvbpd_tso()->get( 'bp_profile_header_parallax', '' ) ? 'jv-parallax' : false;
$strContainerType = jvbpd_tso()->get('bp_profile_navi_type', '' );
$strContainerClass .= ' ' . $strContainerType; ?>

 <div id="cover-image-container" class="<?php echo esc_attr( $strContainerClass ); ?>" data-image="#header-cover-image" data-overlay=".bp-cover-overlay">
	<a id="header-cover-image" href="<?php bp_displayed_user_link(); ?>"></a>
	<div class="container item-header-cover-image-wrap">
	<div id="item-header-cover-image">
		<div id="item-header-avatar">
			<a href="<?php bp_displayed_user_link(); ?>" data-jvbpd-tooltip="#member-avatar-content">
				<?php bp_displayed_user_avatar( 'type=full' ); ?>
			</a>
		</div><!-- #item-header-avatar -->

		<script type="text/html" id="member-avatar-content">
			<div class="tooltip-wrap">
				<div class="tooltip-body">
					<h3 class="tooltip-title"><i class="fa fa-info-circle"></i>
						<?php esc_html_e( "Description", 'jvfrmtd' ); ?>
					</h3>
					<?php if ( bp_is_active( 'activity' ) ) : ?>
						<p id="latest-update">
							<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="tooltip-footer">
					<i class="jvbpd-icon2-clock2"></i>
					<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_user_last_activity( bp_displayed_user_id() ) ); ?>">
						<?php bp_last_activity( bp_displayed_user_id() ); ?>
					</span>
				</div>
			</div>
		</script>

		<div id="item-header-content">
			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
			<?php endif; ?>

			<div id="item-buttons"><?php

				/**
				 * Fires in the member header actions section.
				 *
				 * @since 1.2.6
				 */
				do_action( 'bp_member_header_actions' ); ?></div><!-- #item-buttons -->

			<?php

			/**
			 * Fires before the display of the member's header meta.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_member_header_meta' ); ?>

			<div id="item-meta">

				<?php

				 /**
				  * Fires after the group header actions section.
				  *
				  * If you'd like to show specific profile fields here use:
				  * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
				  *
				  * @since 1.2.0
				  */
				 do_action( 'bp_profile_header_meta' );

				 ?>

			</div><!-- #item-meta -->
		</div><!-- #item-header-content -->

	</div><!-- #item-header-cover-image -->


	</div> <!-- container -->
	<div class="bp-cover-overlay"></div>
</div><!-- #cover-image-container -->
<div class="container <?php echo esc_attr( $strContainerType ); ?>">
	<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Member primary navigation', 'jvfrmtd' ); ?>" role="navigation">
					<ul class="responsive-tabdrop">

						<?php
						if ( ( jvbpd_layout()->getThemeType() == 'jvd-lp' && !bp_is_my_profile() ) || jvbpd_layout()->getThemeType() == 'jvd-lk' ) {
							bp_get_displayed_user_nav();
						}?>

						<?php

						/**
						 * Fires after the display of member options navigation.
						 *
						 * @since 1.2.4
						 */
						do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->
			<div class="clear"></div>
</div> <!-- container -->

<?php

/**
 * Fires after the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_header' ); ?>

<div id="template-notices" role="alert" aria-atomic="true" class="container text-center">
	<?php
	/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
	do_action( 'template_notices' ); ?>

</div>
