<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Static front page (Main page) has been setup properly", 'jvfrmtd' ); ?>
</h4>
<?php else: ?>
<p>
<?php esc_html_e( "This is for your front page ( main page ). you may need to select a page for your front page. ex) Home", 'jvfrmtd' ); ?>
</p>
<p><a href="<?php echo admin_url( 'options-reading.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go to Reading Settings", 'jvfrmtd' ); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Static Page Documentation", 'jvfrmtd' ); ?></h4>
<a href="<?php echo esc_url( apply_filters( 'jvbpd_doc_url', '' ) ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'jvfrmtd' ); ?></a>
<a href="<?php echo admin_url( 'options-reading.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go to Reading Settings", 'jvfrmtd' ); ?></a>