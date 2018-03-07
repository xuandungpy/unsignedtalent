<?php
// Get Theme Settings Default Values.
ob_start();
load_template( JVBPD_ADM_DIR . '/assets/default.txt' );
$jvbpd_theme_setting_default_values = ob_get_clean(); ?>

<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="import">
	<h2> <?php esc_html_e("Theme Settings Default Values", 'jvfrmtd' ); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Import', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('Please paste your previously saved theme settings values into the adjacent box. This may help you restore any backed-up theme settings.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Please paste your saved source into the box below.', 'jvfrmtd' );?></h4>
		<fieldset>
			<textarea class="large-text code javo-ts-import-field" rows="15"></textarea>
		</fieldset>
		<a class="button button-primary javo-btn-ts-import"><?php esc_html_e('Import options', 'jvfrmtd' );?></a>
	</td></tr><tr><th>
		<?php esc_html_e('Export', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('Please copy and save the text in the adjacent box as a restore point for your preferred theme settings.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Please select and copy the source from the box below.', 'jvfrmtd' );?></h4>
		<fieldset>
			<textarea class="large-text code jv-export-textarea" rows="5"><?php echo maybe_serialize( jvbpd_get_theme_settings::getAll() );?></textarea>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e('Reset options', 'jvfrmtd' );?>
		<span class="description">
			<?php
			printf('<strong class="alert">%s</strong> %s'
				, esc_html__('Warning:', 'jvfrmtd' )
				, esc_html__('All values will be removed.', 'jvfrmtd' )
			);?>
		</span>
	</th><td>
		<textarea data-javo-ts-default-value class="hidden"><?php echo esc_textarea( $jvbpd_theme_setting_default_values );?></textarea>
		<a class="button button-primary javo-btn-ts-reset default"><?php esc_html_e('RESET DEFAULT OPTIONS', 'jvfrmtd' );?></a>
		<a class="button button-primary javo-btn-ts-reset"><?php esc_html_e('RESET OPTIONS', 'jvfrmtd' );?></a>
	</td></tr>
	</table>
</div>