<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Menu has been setup properly.", 'jvfrmtd' ); ?>
</h4>
<?php else: ?>
<p>
	<div><?php esc_html_e( "You have not added any menus.", 'jvfrmtd' ); ?></div>
	<div><?php esc_html_e( "Please setup menus", 'jvfrmtd' ); ?> <a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php esc_html_e( "here", 'jvfrmtd' ); ?></a>.</div>
</p>
<p><a href="<?php echo admin_url( 'nav-menus.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go Menu Settings", 'jvfrmtd' ); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Menu Setting Documentation", 'jvfrmtd' ); ?></h4>
<a href="<?php echo esc_url( apply_filters( 'jvbpd_doc_url', '' ) ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'jvfrmtd' ); ?></a>
<a href="<?php echo admin_url( 'nav-menus.php' ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'jvfrmtd' ); ?></a>