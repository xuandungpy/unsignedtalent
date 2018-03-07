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
?>

<div class="col-md-3 sidebar-<?php echo sanitize_html_class( apply_filters( 'jvbpd_sidebar_position', 'right', get_the_ID() ) );?>">
	<div class="row">
		<div class="col-lg-12 sidebar-inner">
			<?php
			$jvbpd_sidebar_id = apply_filters( 'jvbpd_sidebar_id', 'sidebar-1', get_post() );
			if( is_active_sidebar( $jvbpd_sidebar_id ) ) {
				dynamic_sidebar( $jvbpd_sidebar_id );
			} ?>
		</div> <!-- pp-sidebar inner -->
	</div> <!-- new row -->
</div><!-- Side bar -->