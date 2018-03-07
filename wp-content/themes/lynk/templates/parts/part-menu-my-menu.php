<?php
if( jvbpd_dashboard()->checkPermission( 'logged_user' ) ) :
$objCurrentLoginUser = new WP_User( get_current_user_id() );
$jvbpd_user_avatar_meta = jvbpd_dashboard()->getOwnerAvatar( $objCurrentLoginUser->ID, Array( 36, 36 ), Array(
	'class' => 'img-circle',
) ); ?>
<a class="dropdown-toggle header-userinfo" data-toggle="dropdown" href="#" aria-expanded="false">
	<?php
	if( function_exists( 'bp_loggedin_user_avatar' ) ){
		echo bp_loggedin_user_avatar();
	} ?>
</a>
<ul class="dropdown-menu dropdown-userinfo drop-right triangle-arrow-right">
	<li class="my-menu-logged-user-info">
		<?php jvbpd_layout()->load_template( 'parts/part-menu-my-menu-user-info' ); ?>
	</li>
	<li class="my-menu-navs">
		<?php
		wp_nav_menu( array(
			'menu'            => 'my_menu_nav',
			'theme_location'  => 'my_menu_nav',
			'container'       => 'div',
			'container_id'    => 'jv-nav',
			'container_class' => 'sidebar-nav navbar-collapse',
			'menu_id'         => 'nav-wrap',
			'menu_class'      => 'adminbar-wrap',
			'echo'			  => true,
			'depth'           => 3,
			'fallback_cb'     => 'jvnavwalker::fallback',
			'walker'          => new jvnavwalker()
		) ); ?>
	</li>
</ul>
<?php
else:
	printf(
		'<a href="javascript:" data-toggle="modal" data-target="%1$s" title="%3$s"><i class="%2$s"></i></a>',
		'#login_panel', 'jvbpd-icon-user', esc_html__( "Login", 'jvfrmtd' )
	);
endif;