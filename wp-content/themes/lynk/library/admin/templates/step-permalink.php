<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Permalink has been setup properly.", 'jvfrmtd' ); ?>
</h4>
<?php else: ?>
<p>
	<div><?php esc_html_e( "Our theme is compatible with permalink structure. it's also good for SEO.", 'jvfrmtd' ); ?></div>
	<div><?php esc_html_e( "Please setup permalink to 'Post name'.", 'jvfrmtd' ); ?></div>
</p>
<p>
	<a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-primary">
		<?php esc_html_e( "Go Permalink Settings", 'jvfrmtd' ); ?>
	</a>
</p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Permalink Documentation", 'jvfrmtd' ); ?></h4>
<a href="<?php echo esc_url( apply_filters( 'jvbpd_doc_url', '' ) ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'jvfrmtd' ); ?></a>
<a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'jvfrmtd' ); ?></a>