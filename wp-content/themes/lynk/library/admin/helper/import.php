<h1><?php esc_html_e( 'Import', 'jvfrmtd' ); ?></h1>

<?php
if( method_exists( jvlynkCore()->import, 'lynk_generate_import_page' ) ) {
	jvlynkCore()->import->lynk_generate_import_page();
} ?>

<p class="jvbpd-wizard-actions step">
	<a href="<?php echo esc_url( $helper->get_next_step_link() ); ?>" class="button button-primary button-next button-large button-next"><?php esc_html_e( 'Next', 'jvfrmtd' ); ?></a>
</p>