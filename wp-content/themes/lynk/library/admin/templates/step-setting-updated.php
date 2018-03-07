<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Initial theme settings have been setup properly.", 'jvfrmtd' ); ?>
</h4>
<?php else: ?>
<p>
	<div><?php esc_html_e( "You have not setup any options on theme settings." ,'jvfrmtd' ); ?></div>
	<div><?php esc_html_e( "These will setup your logos, layouts, header options, colors.", 'jvfrmtd' ); ?></div>
</p>
<p><a href="<?php echo esc_url( add_query_arg( Array( 'page' => 'javo-theme-settings' ), admin_url( 'admin.php' ) ) ); ?>" class="button button-primary"><?php esc_html_e( "Go to Theme Settings Page", 'jvfrmtd' ); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Theme Settings Documentation", 'jvfrmtd' ); ?></h4>
<a href="<?php echo esc_url( apply_filters( 'jvbpd_doc_url', '' ) ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'jvfrmtd' ); ?></a>
<a href="<?php echo esc_url( add_query_arg( Array( 'page' => 'javo-theme-settings' ), admin_url( 'admin.php' ) ) ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'jvfrmtd' ); ?></a>