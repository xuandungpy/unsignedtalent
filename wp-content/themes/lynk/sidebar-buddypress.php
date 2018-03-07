<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

// Get global post object

// Variable initialize
$jvbpd_sidebar_lr	= 'right';
$jvbpd_sidebar_id	= apply_filters( 'jvbpd_sidebar_id', 'jv-bp-sidebar', get_post() );

if( ! is_archive() || ! is_search() ) :
	if( $strSidebarType = get_post_meta( get_the_ID(), 'jvbpd_sidebar_type', true ) )
		$jvbpd_sidebar_lr	= $strSidebarType;
endif; ?>

<div class="col-md-3 sidebar-<?php echo sanitize_html_class( $jvbpd_sidebar_lr );?>">
	<div class="row">
		<div class="col-lg-12 sidebar-inner">
			<?php
			if( is_active_sidebar( $jvbpd_sidebar_id ) )
				dynamic_sidebar( $jvbpd_sidebar_id );
			?>
		</div> <!-- pp-sidebar inner -->
	</div> <!-- new row -->
</div><!-- Side bar -->