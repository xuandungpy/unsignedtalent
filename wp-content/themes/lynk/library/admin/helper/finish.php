<?php
$helper->wc_setup_ready_actions();
?>

<h1><?php esc_html_e( 'Your site is ready!', 'jvfrmtd' ); ?></h1>

<div class="jvbpd-wizard-next-steps">
	<div class="jvbpd-wizard-next-steps-first">
		<h2><?php esc_html_e( 'Vist Your site', 'jvfrmtd' ); ?></h2>
		<ul>
			<li class="setup-product"><a class="button button-primary button-large" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><?php esc_html_e( 'Visit Home Page', 'jvfrmtd' ); ?></a></li>
			<li class="setup-product"><a class="button button-large" href="<?php echo esc_url( admin_url( '/' ) ); ?>" target="_blank"><?php esc_html_e( 'Visit Dashboard', 'jvfrmtd' ); ?></a></li>
		</ul>
	</div>
	<div class="jvbpd-wizard-next-steps-last">
		<h2><?php _e( 'Learn more', 'jvfrmtd' ); ?></h2>
		<ul>
			<?php
			foreach(
				Array(
					Array(
						'comment' => esc_html__( "If there is any missing settings?", 'jvfrmtd' ),
						'link' => esc_url_raw( apply_filters( 'jvbpd_doc_url', '' ) . 'check-list-after-import/', 'jvfrmtd' ),
					),
					Array(
						'comment' => esc_html__( "Online Documentation", 'jvfrmtd' ),
						'link' => esc_url_raw( apply_filters( 'jvbpd_doc_url', '' ) ),
					),
					Array(
						'comment' => esc_html__( "Visit our support site", 'jvfrmtd' ),
						'link' => esc_url_raw( apply_filters( 'jvbpd_doc_url', '' ) ),
					),
				) as $arrSection
			){
				printf(
					'<li>%1$s( <a href="%2$s" target="_blank" title="%2$s" style="display:inline-block;">%3$s</a> )</li>',
					$arrSection[ 'comment' ], $arrSection[ 'link' ], esc_html__( "Detail", 'jvfrmtd' )
				);
			} ?>

		</ul>
	</div>
</div>