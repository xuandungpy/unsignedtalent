<div class="card-deck-wrapper">
	<div class="card-deck">

		<?php
		foreach(
			Array(
				(object) Array(
					'icon' => 'jvbpd-icon1-basket',
					'label' => esc_html__( "My Published Listings", 'jvfrmtd' ),
					'url' => jvbpd_getUserPage(jvbpd_getDashboardUser()->ID, 'item-published' ),
					'count' => intVal( jvlynkCore()->var_instance->getUserListingCount( jvbpd_getDashboardUser()->ID, Array( 'publish' ) ) ),
				),
				(object) Array(
					'icon' => 'Defaults-truck user',
					'label' => esc_html__( "My Pending Listings", 'jvfrmtd' ),
					'url' => jvbpd_getUserPage(jvbpd_getDashboardUser()->ID, 'item-pending' ),
					'count' => intVal( jvlynkCore()->var_instance->getUserListingCount( jvbpd_getDashboardUser()->ID, Array( 'pending' ) ) ),
				),
				(object) Array(
					'icon' => 'Defaults-trash gear',
					'label' => esc_html__( "My Expired Listings", 'jvfrmtd' ),
					'url' => jvbpd_getUserPage(jvbpd_getDashboardUser()->ID, 'item-expired' ),
					'count' => intVal( jvlynkCore()->var_instance->getUserListingCount( jvbpd_getDashboardUser()->ID, Array( 'expire' ) ) ),
				),
				(object) Array(
					'icon' => 'Defaults-calendar gear',
					'label' => esc_html__( "My Events", 'jvfrmtd' ),
					'url' => jvbpd_getUserPage(jvbpd_getDashboardUser()->ID, 'events' ),
					'count' => intVal( jvlynkCore()->var_instance->getUserEventsCount( jvbpd_getDashboardUser()->ID ) ),
					'visible' => function_exists( 'Lava_EventConnector' ) && function_exists( 'tribe_get_events' )
				),
			) as $objItem
		) {
			if( isset( $objItem->visible ) && false === $objItem->visible ) {
				continue;
			}
			printf(
				'<div class="card block-status mb-4 text-center"><div class="card-block"><a href="%4$s"><h4 class="card-title">%1$s</h4>
				<p><span class="counter">%2$s</span></p></a><div class="shadow-icon"><i class="%3$s"></i></div></div></div>',
				$objItem->label, $objItem->count, $objItem->icon, $objItem->url
			);

		} ?>

	</div>
</div>


<?php if( class_exists( 'Post_Views_Counter' ) ) { ?>
	<!-- /.row -->
	<div class="card-deck">
		<div class="card mb-4 chartjs narrow">
			<?php
			$arrCharItems = array_filter( (array) get_user_meta( get_current_user_id(), '_mypage_chart_items', true ) );
			jvbpd_layout()->load_template(
				'chart-template', Array(
					'jvbpd_aricle_args' => (object) Array(
						'label' => esc_html__( "Listing Views ( 6 Months )", 'jvfrmtd' ),
						'values' =>$arrCharItems,
						'limit_month' => 6,
						'count_type' => 2,
						'graph_type' => 'line',
					),
				)
			); ?>
		</div>
		<div class="card mb-4 chartjs narrow">
			<?php
			$arrCharItems = array_filter( (array) get_user_meta( get_current_user_id(), '_mypage_chart_events', true ) );
			jvbpd_layout()->load_template(
				'chart-template', Array(
					'jvbpd_aricle_args' => (object) Array(
						'label' => esc_html__( "Event Views ( 6 Months )", 'jvfrmtd' ),
						'values' =>$arrCharItems,
						'limit_month' => 6,
						'count_type' => 2,
						'graph_type' => 'line',
					),
				)
			); ?>
		</div>
	</div>
<?php } ?>


<div class="card-deck">
	<div class="card mb-4 listing-card">
		<div class="card-header">
			<h4 class="card-title"><?php esc_html_e( "Recent Reviews", 'jvfrmtd' ); ?></h4>
		</div>
		<ul class="list-group list-group-flush">
			<?php
			if( function_exists( 'jvbpd_core' ) && method_exists( jvbpd_core()->template, 'load_template' ) ) {
				jvbpd_core()->template->load_template( 'dashboard/part-review-received-content', '.php' );
			} ?>
		</ul>
	</div> <!-- .card -->
	<div class="card mb-4 listing-card">
		<div class="card-header">
			<h4 class="card-title"><?php esc_html_e( "Recent Events", 'jvfrmtd' ); ?></h4>
		</div>
			<?php
				if( function_exists( 'jvbpd_core' ) && method_exists( jvbpd_core()->template, 'load_template' ) ) {
				jvbpd_core()->template->load_template( 'dashboard/part-my-events-content', '.php' );
			} ?>
	</div> <!-- .card -->
</div>