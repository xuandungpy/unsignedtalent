<!-- Left navbar-header -->
<div class="navbar-default sidebar vertical-sidebar left-sidebar fixed" role="navigation">
    <div class="sidebar-nav navbar-collapse collapse">
		<div class="sidebar-swicher-wrap">
			<a href="javascript:void(0)" class="dashboard-sidebar-switcher no-hover-effect"><i class=" jvbpd-icon2-arrow-right"></i></a>
		</div>
		<div class="left-sidebar-brand">
			<a class="left-brand" href="<?php echo home_url( '/' ); ?>">
				<span class="logo-img"><?php echo jvbpd_layout()->getLogo( array( 'type' => 'logo_url' ) ); ?></span>
				<span class="logo-small-img">
					<?php
					echo jvbpd_layout()->getLogo( array(
						'type' => 'logo_small_url',
					) ); ?>
				</span>
				<span class="hidden-xs hidden"><?php bloginfo( 'name' ); ?></span>
			</a>
		</div>
		<?php
		wp_nav_menu([
			'menu'            => 'sidebar_left',
			'theme_location'  => 'sidebar_left',
			'container'       => 'div',
			'container_id'    => 'jv-slidebar-left-container',
			'container_class' => 'sidebar-nav navbar-collapse collapse',
			'menu_id'         => 'jv-slidebar-left',
			'menu_class'      => 'nav jvbpd-nav',
			'echo'          => true,
			'depth'           => 3,
			'fallback_cb'     => 'jvnavwalker::fallback',
			'walker'          => new jvnavwalker()
		]); ?>
    </div>
</div>
<!-- Left navbar-header end -->