<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="logo">

<!-- Themes setting > Logo -->
	<h2><?php esc_html_e("Logo", 'jvfrmtd' );?></h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e("Header Logo Settings",'jvfrmtd' ); ?>
		<span class='description'>
			<?php esc_html_e("Uploaded logos will be displayed on the header in their appropriate locations.", 'jvfrmtd' );?>
		</span>
	</th>
	<td>

		<h4><?php esc_html_e("Main Logo ( Dark / Default )",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[logo_url]" value="<?php echo esc_attr( $jvbpd_tso->get('logo_url') );?>" tar="logo_dark">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="logo_dark">
			<input class="fileuploadcancel button" tar="logo_dark" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('logo_url') );?>" tar="logo_dark">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Main Logo ( Light )",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[logo_light_url]" value="<?php echo esc_attr( $jvbpd_tso->get('logo_light_url') );?>" tar="logo_light">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="logo_light">
			<input class="fileuploadcancel button" tar="logo_light" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('logo_light_url') );?>" tar="logo_light">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Small Logo ( Simple )",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[logo_small_url]" value="<?php echo esc_attr( $jvbpd_tso->get('logo_small_url') );?>" tar="logo_small">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="logo_small">
			<input class="fileuploadcancel button" tar="logo_small" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('logo_small_url') );?>" tar="logo_small">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Mobile Logo",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[mobile_logo_url]" value="<?php echo esc_attr( $jvbpd_tso->get('mobile_logo_url') );?>" tar="mobile_logo">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="mobile_logo">
			<input class="fileuploadcancel button" tar="mobile_logo" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get( 'mobile_logo_url' ) );?>" tar="mobile_logo">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Retina Logo",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvbpd_ts[retina_logo_url]" value="<?php echo esc_attr( $jvbpd_tso->get( 'retina_logo_url' ) );?>" tar="g02">
				<input type="button" class="button button-primary fileupload" value="<?php esc_html_e('Select Image', 'jvfrmtd' );?>" tar="g02">
				<input class="fileuploadcancel button" tar="g02" value="<?php esc_html_e('Delete', 'jvfrmtd' );?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get( 'retina_logo_url' ) );?>" tar="g02">
			</p>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e("Footer Logo Settings",'jvfrmtd' ); ?>
		<span class='description'>
			<?php esc_html_e("Uploaded logos will be displayed on the footer in their appropriate locations.", 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Logo",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvbpd_ts[bottom_logo_url]" value="<?php echo esc_attr( $jvbpd_tso->get( 'bottom_logo_url' ) );?>" tar="g03">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="g03">
				<input class="fileuploadcancel button" tar="g03" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get( 'bottom_logo_url' ) );?>" tar="g03">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Retina Logo",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvbpd_ts[bottom_retina_logo_url]" value="<?php echo esc_attr( $jvbpd_tso->get( 'bottom_logo_url' ) );?>" tar="g04">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="g04">
				<input class="fileuploadcancel button" tar="g04" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get( 'bottom_retina_logo_url' ) );?>" tar="g04">
			</p>
		</fieldset>
	</td></tr>
	</table>
</div>