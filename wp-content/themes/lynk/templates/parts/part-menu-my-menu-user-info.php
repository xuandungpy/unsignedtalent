<?php
if( is_user_logged_in() ) {
	$objCurrentUser = wp_get_current_user();
	$arrUserActions = Array(
		'display_name' => Array(
			'label' => $objCurrentUser->display_name,
		),
		'edit_profile' => Array(
			'href' => is_multisite() ? get_dashboard_url( $objCurrentUser->ID, 'profile.php' ) : get_edit_profile_url( $objCurrentUser->ID ),
			'label' => esc_html__( "Edit my profile", 'jvfrmtd' ),
		),
		'logout' => Array(
			'href' => wp_logout_url(),
			'label' => esc_html__( "Logout", 'jvfrmtd' ),
		),
	); ?>

	<div class="user-info-in-nav-wrap">
		<div class="user-info-avatar">
			<?php echo get_avatar( $objCurrentUser->ID, 64 ); ?>
		</div>
		<ul class="user-info-item-group">
			<?php
			$strLinkTemplate = '<li class="user-info-item %1$s"><a href="%3$s" target="_self"><span>%2$s</span></a></li>';
			$strLabelTemplate = '<li class="user-info-item %1$s"><span>%2$s</span></li>';
			foreach( $arrUserActions as $strSection => $arrInfoMeta ) {
				printf(
					( isset( $arrInfoMeta[ 'href' ] ) ? $strLinkTemplate : $strLabelTemplate ),
					$strSection,
					$arrInfoMeta[ 'label' ],
					( isset( $arrInfoMeta[ 'href' ] ) ? $arrInfoMeta[ 'href' ] : '' )
				);
			} ?>
		</ul>
	</div>
	<?php
}