<a class="dropdown-toggle header-userinfo" data-toggle="dropdown" href="#" aria-expanded="false">
	<i class="jvbpd-icon1-search"></i>
</a>
<ul class="dropdown-menu dropdown-userinfo drop-right triangle-arrow-right">
	<li class="header-nav-search">
		<?php
		$strSearchShortcodeName = 'lava_ajax_search_form';
		if( shortcode_exists( $strSearchShortcodeName ) ) {
			echo do_shortcode( '[' . $strSearchShortcodeName . ']' );
		} ?>
	</li>
</ul>