<?php
$objCurrentLoginUser = new WP_User( get_current_user_id() );

$strSubmitLink = apply_filters( 'jvbpd_core_submit_page_link', home_url( '/' ) );
$jvbpd_user_avatar_meta = jvbpd_dashboard()->getOwnerAvatar( $objCurrentLoginUser->ID, Array( 36, 36 ), Array(
	'class' => 'img-circle',
) );
$jvbpd_user_background	= wp_get_attachment_image_src(get_user_meta($objCurrentLoginUser->ID, 'mypage_header', true), 'jvbpd-avatar' );

$isEventActivate = function_exists( 'Lava_EventConnector' ) && function_exists( 'tribe_get_events' );
$boolUseTopNavBarInHeader = apply_filters( 'jvbpd_display_navi_in_header', true );
 ?>
<div id="wrapper">
	<!-- Navigation -->
	<?php if( apply_filters( 'jvbpd_display_header', true ) ) : ?>
	<nav <?php jvbpd_layout()->getNavClass(); ?>>
		<?php if( jvbpd_header()->getTopbarAllow() ) { ?>
			<div class="navbar-default horizon sidebar top-bar">
				<div class="container clearfix">
					<div class="pull-left">
						<?php
						wp_nav_menu( array(
							'menu'            => 'topbar_left',
							'theme_location'  => 'topbar_left',
							'container'       => 'div',
							'container_id'    => 'jv-topbar-left-container',
							'container_class' => 'sidebar-nav navbar-collapse',
							'menu_id'         => 'jv-topbar-left',
							'menu_class'      => 'nav navbar-nav jvbpd-nav',
							'echo'          => true,
							'depth'           => 3,
							'fallback_cb'     => 'jvnavwalker::fallback',
							'walker'          => new jvnavwalker()
						) ); ?>
					</div>
					<div class="pull-right">
						<?php
						wp_nav_menu( array(
							'menu'            => 'topbar_right',
							'theme_location'  => 'topbar_right',
							'container'       => 'div',
							'container_id'    => 'jv-topbar-right-container',
							'container_class' => 'sidebar-nav navbar-collapse',
							'menu_id'         => 'jv-topbar-right',
							'menu_class'      => 'nav navbar-nav jvbpd-nav',
							'echo'          => true,
							'depth'           => 3,
							'fallback_cb'     => 'jvnavwalker::fallback',
							'walker'          => new jvnavwalker()
						) ); ?>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if( apply_filters( 'jvbpd_middle_header_display', false ) ) : ?>
			<div class="middle-header">
				<div class="container">
					<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>">
						<span class="logo-img"><?php echo jvbpd_layout()->getLogo(); ?></span>
					</a>
					<?php
					if( shortcode_exists( 'lava_ajax_search_form' ) ){
						echo do_shortcode( '[lava_ajax_search_form]' );
					} ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="navbar-header">
			<div class="container header-navs-container clearfix">
				<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>">
					<span class="logo-img hidden-xs"><?php echo jvbpd_layout()->getLogo(); ?></span>
					<span class="mobile-logo logo-img hidden-sm hidden-md hidden-lg"><?php echo jvbpd_layout()->getLogo( Array( 'type' => 'mobile_logo_url' ) ); ?></span>
					<span class="hidden-xs"><?php echo jvbpd_layout()->getSiteShortLabel(); ?></span>
				</a>
				<?php
				$objMenu = wp_nav_menu( Array( 'theme_location' => 'top_nav_menu_left', 'fallback_cb' => '__return_false', 'echo' => false ) );
				if( !empty( $objMenu ) ) {
					?>
					<a href="javascript:void(0)" class="dashboard-topbar-switcher navbar-toggle hidden-sm hidden-md hidden-lg" data-toggle="collapse" data-target=".sidebar.primary-nav .sidebar-nav"><span class="jvbpd-icon2-paragraph"></span></a>
					<?php
				} ?>
				<div class="pull-left show-dashboard-style small-logo-wrap">
					<a href="<?php echo home_url( '/' ); ?>">
						<?php
						echo jvbpd_layout()->getLogo( array(
							'type' => 'logo_small_url',
							'class' => 'img-circle',
						) ); ?>
					</a>
				</div>
				<?php
				if( shortcode_exists( 'lava_ajax_search_form' ) ){
					?>
					<div class="pull-left show-dashboard-style dashboard-search-wrap">
						<?php echo do_shortcode( '[lava_ajax_search_form]' ); ?>
					</div>
				<?php } ?>

				<div class="top-ad pull-right">
					<a href="#"><?php echo jvbpd_layout()->getBannerImage(); ?></a>
				</div><!-- top-ad -->

				<?php

				do_action( 'jvbpd_top_nav_menu_center' );
				if( $boolUseTopNavBarInHeader ) : ?>
					<ul class="nav header-content-wrapper pull-left top-menu-wrap">
						<li>
							<div class="container clearfix" id="navigation-bar">
								<div class="navbar-default horizon sidebar primary-nav navbar-toggleable-md" role="navigation">
									<?php
									wp_nav_menu([
										'menu'            => 'top_nav_menu_left',
										'theme_location'  => 'top_nav_menu_left',
										'container'       => 'div',
										'container_id'    => 'jv-nav-menu-left-container',
										'container_class' => 'sidebar-nav navbar-collapse collapse',
										'menu_id'         => 'jv-nav-menu-left',
										'menu_class'      => 'nav navbar-nav jvbpd-nav',
										'echo'          => true,
										'depth'           => 3,
										'fallback_cb'     => 'jvnavwalker::fallback',
										'walker'          => new jvnavwalker()
									]); ?>
								</div>
							</div> <!--  container -->
						</li>
					</ul>
				<?php
				endif; ?>
				<div class="nav header-content-wrapper pull-right top-nav-menu-right-wrap">
					<?php
					wp_nav_menu( array(
						'menu'            => 'top_nav_menu_right',
						'theme_location'  => 'top_nav_menu_right',
						'container'       => 'div',
						'container_id'    => 'jv-nav-menu-right-container',
						'container_class' => 'sidebar-nav navbar-collapse',
						'menu_id'         => 'jv-nav-menu-right',
						'menu_class'      => 'nav navbar-nav jvbpd-nav',
						'echo'          => true,
						'depth'           => 3,
						'fallback_cb'     => 'jvnavwalker::fallback',
						'walker'          => new jvnavwalker()
					) ); ?>
				</div>
				<?php if( !jvbpd_dashboard()->checkPermission( 'logged_user' ) ) { ?>
					<ul class="nav header-content-wrapper pull-right header-search-wrap hidden-xs hidden">
						<?php echo '<li><a data-toggle="modal" data-target="#login_panel"><i class="jvbpd-icon2-user2"></i></a></li>'; ?>
					</ul>
				<?php } ?>
			</div><!-- /. container -->
		</div> <!-- /.navbar-header -->
		<?php do_action( 'jvbpd_header_container_after' ); ?>
	</nav>
	<?php endif; ?>