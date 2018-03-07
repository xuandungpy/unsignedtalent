<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="api">
	<h2> <?php esc_html_e("APIs Settings", 'jvfrmtd' ); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Google API', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('Paste your Google Analytic tracking codes here.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Google Analystics Code', 'jvfrmtd' );?></h4>
		<fieldset>
			<textarea name="jvbpd_ts[analytics]" class="large-text code" rows="15"><?php echo stripslashes($jvbpd_tso->get('analytics', ''));?></textarea>
		</fieldset>
	</td></tr>
	</table>
</div>