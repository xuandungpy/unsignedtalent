<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="footer">
	<h2> <?php esc_html_e("Footer Settings", 'jvfrmtd' ); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Color Settings', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('You can change colors on footer area.', 'jvfrmtd' );?>
		</span>
	</th><td>

		<h4><?php esc_html_e('Footer Background Color','jvfrmtd' );?></h4>
		<fieldset class="inner" id="jv-theme-settings-footer-middle-bg-color">
			<input name="jvbpd_ts[footer_middle_background_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('footer_middle_background_color','#323131'));?>" class="wp_color_picker" data-default-color="#333333">
		</fieldset>

		<h4><?php esc_html_e('Footer Title Color','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_title_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('footer_title_color','#ffffff'));?>" class="wp_color_picker" data-default-color="#ffffff">
		</fieldset>

		<h4><?php esc_html_e('Footer Title Underline Color','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_title_underline_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('footer_title_underline_color','#ffffff'));?>" class="wp_color_picker" data-default-color="footer_title_underline_color">
			<input type="checkbox" name="jvbpd_ts[show_footer_title_underline]" value="disabled" <?php checked($jvbpd_tso->get('show_footer_title_underline') == 'disabled' );?>>
			<?php esc_html_e( "Disabled", 'jvfrmtd' );?>
		</fieldset>

		<h4><?php esc_html_e('Footer Content Color','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_content_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('footer_content_color','#999999'));?>" class="wp_color_picker" data-default-color="#999999">
		</fieldset>

	<h4><?php esc_html_e('Footer Content Link Hover Color','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_content_link_hover_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('footer_content_link_hover_color','#ffffff'));?>" class="wp_color_picker" data-default-color="ffffff">
	</fieldset>

	</td></tr>

	<tr><th>
		<?php esc_html_e( 'Footer Layout Option', 'jvfrmtd' );?>
		<span class="description"></span>
	</th><td>

		<h4><?php esc_html_e( 'Footer Type','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[footer_container_type]" value="" <?php checked($jvbpd_tso->get('footer_container_type') == '' );?>>
				<?php esc_html_e( "Wide", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_container_type]" value="active" <?php checked($jvbpd_tso->get('footer_container_type')== "active");?>>
				<?php esc_html_e( "Boxed", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_container_type]" value="disable-footer" <?php checked($jvbpd_tso->get('footer_container_type')== "disable-footer");?>>
				<?php esc_html_e( "Disabled", 'jvfrmtd' );?>
			</label>
		</fieldset>
		
		<h4><?php esc_html_e( 'Footer Sticky','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[footer_sticky]" value="enable" <?php checked($jvbpd_tso->get('footer_sticky') == 'enable' );?>>
				<?php esc_html_e( "Enabled", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_sticky]" value="" <?php checked($jvbpd_tso->get('footer_sticky')== "");?>>
				<?php esc_html_e( "Disabled", 'jvfrmtd' );?>
			</label>
		</fieldset>

		<h4><?php esc_html_e( 'Footer Sidebar Columns','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<?php
			foreach(
				Array(
					'' => esc_html__( "3 Columns (default)", 'jvfrmtd' ),
					'column4' => esc_html__( "4 Columns", 'jvfrmtd' ),
				) as $strColumns => $strLabel
			) printf(
				'<label><input type="radio" name="jvbpd_ts[footer_sidebar_columns]" value="%1$s"%2$s>%3$s</label>' . ' ',
				$strColumns,
				checked( $strColumns == jvbpd_tso()->get('footer_sidebar_columns'), true, false ),
				$strLabel
			); ?>
		</fieldset>

	</td></tr>

	<tr><th>
		<?php esc_html_e( 'Footer Infomation', 'jvfrmtd' );?>
	</th><td>

		<h4><?php esc_html_e( 'Show Footer Information','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[footer_info_use]" value="active" <?php checked($jvbpd_tso->get('footer_info_use') == 'active' );?>>
				<?php esc_html_e( "Enabled", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_info_use]" value="" <?php checked($jvbpd_tso->get('footer_info_use')== "");?>>
				<?php esc_html_e( "Disabled", 'jvfrmtd' );?>
			</label>
		</fieldset>

		<h4><?php esc_html_e( 'Social Icons','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[footer_social_use]" value="active" <?php checked($jvbpd_tso->get('footer_social_use') == 'active' );?>>
				<?php esc_html_e( "Enabled", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_social_use]" value="" <?php checked($jvbpd_tso->get('footer_social_use')== "");?>>
				<?php esc_html_e( "Disabled", 'jvfrmtd' );?>
			</label>
		</fieldset>

		<h4><?php esc_html_e( 'Footer bottom - Middle Area Title','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_info_text_title]" value="<?php echo esc_attr( $jvbpd_tso->get('footer_info_text_title'));?>">
		</fieldset>

		<h4><?php esc_html_e( 'Footer bottom - Middle Text','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<textarea name="jvbpd_ts[footer_text]" class="large-text code" rows="10"><?php echo stripslashes($jvbpd_tso->get('footer_text', ''));?></textarea>
		</fieldset>



		<h4><?php esc_html_e( 'Footer Bottom - Right Title','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_info_image_title]" value="<?php echo esc_attr( $jvbpd_tso->get('footer_info_image_title'));?>">
		</fieldset>

		<h4><?php esc_html_e( 'Footer Bottom - Right','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[footer_info_image_url]" value="<?php echo esc_attr( $jvbpd_tso->get('footer_info_image_url'));?>" tar="footer_info_image">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="footer_info_image">
			<input class="fileuploadcancel button" tar="footer_image" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('footer_info_image_url'));?>" tar="footer_info_image" style="max-width:60%;">
			</p>
		</fieldset>

	</td></tr>

	<tr><th>
		<?php esc_html_e('Footer Background Option', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('You can add a background image on footer area.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Background status','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[footer_background_image_use]" value="use" <?php checked($jvbpd_tso->get('footer_background_image_use') == "use");?>><?php esc_html_e('Enable', 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[footer_background_image_use]" value="" <?php checked($jvbpd_tso->get('footer_background_image_use')== "");?>><?php esc_html_e('Disable', 'jvfrmtd' );?>
			</label>
		</fieldset>
		<h4><?php esc_html_e('Image Upload','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input type="text" name="jvbpd_ts[footer_background_image_url]" value="<?php echo esc_attr( $jvbpd_tso->get('footer_background_image_url'));?>" tar="footer_image">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="footer_image">
			<input class="fileuploadcancel button" tar="footer_image" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('footer_background_image_url'));?>" tar="footer_image" style="max-width:60%;">
			</p>
		</fieldset>
		<h4><?php esc_html_e('Background Size','jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<?php
			$footer_background_size = Array(
				'contain'			=> esc_html__('Contain', 'jvfrmtd' )
				, 'cover'		=> esc_html__('Cover', 'jvfrmtd' )
			);
			?>
			<select name="jvbpd_ts[footer_background_size]">
				<option value=""><?php esc_html_e('Select', 'jvfrmtd' );?></option>
				<?php
				foreach($footer_background_size as $size=> $text){
					printf('<option value="%s" %s>%s</option>', $size
						,( $jvbpd_tso->get('footer_background_size')!='' && $jvbpd_tso->get('footer_background_size') == $size? " selected": "")
						, $text);
				} ?>
			</select>
		</fieldset>
		<h4><?php esc_html_e('Background Repeat','jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<?php
			$footer_background_repeat = Array(
				'repeat'			=> esc_html__('Repeat X, Y', 'jvfrmtd' )
				, 'repeat-x'		=> esc_html__('Repeat-X', 'jvfrmtd' )
				, 'repeat-y'		=> esc_html__('Repeat-Y', 'jvfrmtd' )
				, 'no-repeat'		=> esc_html__('No-Repeat', 'jvfrmtd' )
			);
			?>
			<select name="jvbpd_ts[footer_background_repeat]">
				<option value=""><?php esc_html_e('Select', 'jvfrmtd' );?></option>
				<?php
				foreach($footer_background_repeat as $repeat=> $text){
					printf('<option value="%s" %s>%s</option>', $repeat
						,( $jvbpd_tso->get('footer_background_repeat')!='' && $jvbpd_tso->get('footer_background_repeat') == $repeat? " selected": "")
						, $text);
				} ?>
			</select>
		</fieldset>
		<h4><?php esc_html_e('Opacity (0.1 ~ 1)','jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[footer_background_opacity]" value="<?php echo esc_attr( $jvbpd_tso->get('footer_background_opacity'));?>">
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e('Copyright Information', 'jvfrmtd' );?>
		<span class="description">
			<?php esc_html_e('Type your copyright information. It will be displayed on footer.', 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Copyright Color','jvfrmtd' );?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[copyright_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get('copyright_color','#ffffff'));?>" class="wp_color_picker" data-default-color="ffffff">
		</fieldset>

		<h4><?php esc_html_e('Display Text or HTML', 'jvfrmtd' );?></h4>
		<fieldset>
			<textarea name="jvbpd_ts[copyright]" class="large-text code" rows="15"><?php echo stripslashes($jvbpd_tso->get('copyright', ''));?></textarea>
		</fieldset>
	</td></tr>
	</table>
</div>