<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="custom">
	<h2> <?php esc_html_e("Javo Customization Settings", 'jvfrmtd' ); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e( "CSS Stylesheet", 'jvfrmtd' );?>
		<span class="description"><?php esc_html_e('Please Add Your Custom CSS Code Here.', 'jvfrmtd' );?></span>
	</th><td>
		<h4><?php esc_html_e('Code:', 'jvfrmtd' );?></h4>
		<?php esc_html_e( '<style type="text/css">', 'jvfrmtd' );?>
		<fieldset>
			<textarea name="jvbpd_ts[custom_css]" class='large-text code' rows='15'><?php echo stripslashes( $jvbpd_tso->get( 'custom_css', '' ) );?></textarea>
		</fieldset>
		<?php esc_html_e( '</style>', 'jvfrmtd' );?>
	</td></tr><tr><th>
		<?php esc_html_e('Custom Script', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e(' If you have additional script, please add here.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Code:', 'jvfrmtd' );?></h4>
		<?php esc_html_e( '<script type="text/javascript">', 'jvfrmtd' );?>
		<fieldset>
			<textarea name="jvbpd_ts[custom_js]" class="large-text code" rows="15"><?php echo stripslashes( $jvbpd_tso->get('custom_js', ''));?></textarea>
		</fieldset>
		<?php esc_html_e( '</script>', 'jvfrmtd' );?>
		<div><?php esc_html_e('(Note : Please make sure that your scripts are NOT conflict with our own script or ajax core)', 'jvfrmtd' );?></div>
	</td></tr>
	</table>
</div>