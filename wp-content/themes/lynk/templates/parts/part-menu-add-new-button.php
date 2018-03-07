<?php
$isEventActivate = function_exists( 'Lava_EventConnector' ) && function_exists( 'tribe_get_events' );
$intBuddypressPage = jvbpd_tso()->get( 'bp_permalink', 0 );
$intLavaBPPostPage = jvbpd_tso()->get( 'lvbpp_permalink', 0 );
?>
	<!-- Add New Button -->
	<div class="btn btn-group hidden-xs hidden-sm">
		<button type="button" class="btn btn-sm btn-primary pull-right btn-rounded dropdown-toggle admin-color-setting" data-toggle="dropdown" aria-expanded="true">
			<i class="fa fa-plus"></i>
			<span class="hidden-sm hidden-xs"><?php echo strtoupper( esc_html__( "New", 'jvfrmtd' ) ); ?></span>
			<i class="fa fa-angle-down"></i>
		</button>
		<ul class="dropdown-menu drop-right triangle-arrow-right" role="menu">
			<?php if( 0 < intVal( $intBuddypressPage ) ) { ?>
				<li><a href="<?php echo get_permalink( $intBuddypressPage ); ?>"><i class="jvbpd-icon-basic_sheet_pencil"></i> <?php _e('Forum','jvfrmtd' ); ?></a></li>
			<?php } ?>

			<?php if( 0 < intVal( $intLavaBPPostPage ) ) { ?>
				<li><a href="<?php echo get_permalink( $intLavaBPPostPage ); ?>"><i class="jvbpd-icon-basic_sheet_pencil"></i> <?php _e('Post','jvfrmtd' ); ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<!-- Add New button end -->
<?php
//endif;