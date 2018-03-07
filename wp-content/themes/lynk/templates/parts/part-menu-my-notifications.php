<?php
if( ! is_user_logged_in() ) {
	return;
}

$arrNotifications = jvbpd_bp()->getNewNotifications( get_current_user_id(), 0 );
$arrNotifyMessages = jvbpd_bp()->getNotifyMessages( $arrNotifications );
$intNotifyMessagesCount = sizeof( $arrNotifyMessages );

?>
<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	<i class="jvbpd-icon3-bell"></i>
	<div class="bedge" data-bp-notifications="count"><?php echo intVal( $intNotifyMessagesCount ); ?></div>
</a>
<ul class="dropdown-menu dropdown-listings drop-right triangle-arrow-right notifications-list" data-bp-notifications="list">

	<?php
	if( !empty( $arrNotifyMessages ) ) {
		foreach( $arrNotifyMessages as $strMessage ) {
			printf( '<li>%s</li>', $strMessage );
		}
	}else{
		printf( '<li class="not-found-notification"><a href="#">%s</a></li>', esc_html__( "No new notifications", 'jvfrmtd' ) );
	} ?>
</ul>