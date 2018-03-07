<?php
if( $strBannerLink = jvbpd_tso()->get( 'footer-banner', false ) ) :
	$strOutputLink = esc_url( $strBannerLink );
?>
	<div class="row footer-top-banner-row">
		<div class="container">
			<a href="<?php echo esc_attr( $strOutputLink ); ?>" target="_brank">
				<img src="<?php echo esc_attr( jvbpd_tso()->get( 'footer-banner' ) ); ?>" style="width:<?php echo esc_attr( jvbpd_tso()->get('footer-banner-width' ) ); ?>px; height:<?php echo esc_attr( jvbpd_tso()->get('footer-banner-height' ) ); ?>px;">
			</a>
		</div>
	</div> <!--footer-top-banner-row -->
<?php endif; ?>