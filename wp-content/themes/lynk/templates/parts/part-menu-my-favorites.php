<ul class="nav header-content-wrapper pull-right member-info-wrap">
	<?php
	if( jvbpd_dashboard()->checkPermission( 'member' ) ) :
		if( function_exists( 'lv_directory_favorite' ) ) {
			$arrFavorites = lv_directory_favorite()->core->getFavorites( $objCurrentLoginUser->ID ); ?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class=" jvbpd-icon2-heart"></i>
					<?php if( 0 < sizeof( array_filter( $arrFavorites ) ) ) { ?>
						<div class="header-icon-notice"><span class="badge badge-info label-notice-num"><?php echo sizeof( array_filter( $arrFavorites ) ); ?></span></div>
					<?php } ?>
				</a>
				<ul class="dropdown-menu dropdown-favorites fade-inout drop-right triangle-arrow-right">
					<li>
						<div class="card listing-card narrow">
							<div class="card-header">
							<h4 class="card-title">
								<?php printf( esc_html__( "You have %s favorite listings", 'jvfrmtd' ), sizeof( array_filter( $arrFavorites ) ) ); ?>
							</h4>
						</div>
						<ul class="list-group list-group-flush">

							<?php
							$intCurrentFavoriteIndex =0;
							foreach( $arrFavorites as $arrFavoriteMeta ) {
								$objPost = isset( $arrFavoriteMeta[ 'post_id' ] ) ? get_post( $arrFavoriteMeta[ 'post_id' ] ) : null;
								if( empty( $objPost ) || 4 <= $intCurrentFavoriteIndex ) {
									continue;
								}
								$intCurrentFavoriteIndex++;
								jvbpd_core()->template->load_template(
									'dashboard/part-mypage-widget-favorites',
									'.php',
									array(
										'jvbpd_aricle_args' => (object) Array(
											'post' => $objPost,
											'date' => date( get_option( 'date_format' ), strtotime( $arrFavoriteMeta[ 'save_day' ] ) ),
											'real_date' => $arrFavoriteMeta[ 'save_day' ],
										),
									), false
								);
							} ?>

						</ul>
						<div class="card-footer text-center">
							<a class="text-center" href="<?php echo jvbpd_getUserPage( jvbpd_getDashboardUser()->ID, 'favorite' ); ?>"> <?php esc_html_e( "See all saved listings", 'jvfrmtd' ); ?><i class="fa fa-angle-right"></i> </a>
						</div>
					</div>
					</li>
				</ul>
				<!-- /.dropdown-favorites -->
			</li>
			<?php
		}
	endif; ?>

</ul>