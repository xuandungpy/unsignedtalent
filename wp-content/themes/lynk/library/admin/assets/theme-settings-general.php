<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="general">
<!-- Themes setting > General -->
	<h2><?php esc_html_e("General", 'jvfrmtd' );?></h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e("Page Layout Setting",'jvfrmtd' ); ?>
	</th><td>
		<h4><?php esc_html_e('Page Layout Width', 'jvfrmtd' );?></h4>
		<fieldset class="inner">

			<?php
			foreach( jvbpd_layout()->getPageLayoutTypes() as $strOption => $strOptionLabel ) {
				printf(
					'<label style="padding:0 15px 0;"><input type="radio" name="jvbpd_ts[layout_style_boxed]" value="%1$s" %3$s> %2$s</label>',
					$strOption, $strOptionLabel, checked( $strOption == jvbpd_tso()->get( 'layout_style_boxed', 'wide-0' ), true, false )
				);
			} ?>

		</fieldset>

		<h4><?php esc_html_e("Background Image",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvbpd_ts[page_background_image]" value="<?php echo esc_attr( $jvbpd_tso->get('page_background_image'));?>" tar="g405">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="g405">
				<input class="fileuploadcancel button" tar="g405" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('page_background_image'));?>" tar="g405">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Blank Image Settings",'jvfrmtd' ); ?>
		<span class='description'>
			<?php esc_html_e("Blank (or white) images are shown when no images are available. The preferred dimensions are 300x300.", 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Blank Image",'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvbpd_ts[no_image]" value="<?php echo esc_attr( $jvbpd_tso->get('no_image', JVBPD_IMG_DIR.'/no-image.png'));?>" tar="g404">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'jvfrmtd' );?>" tar="g404">
				<input class="fileuploadcancel button" tar="g404" value="<?php esc_attr_e('Delete', 'jvfrmtd' );?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'jvfrmtd' ); ?><br>
				<img src="<?php echo esc_attr( $jvbpd_tso->get('no_image', JVBPD_IMG_DIR.'/no-image.png'));?>" tar="g404">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Login Settings",'jvfrmtd' ); ?>
		<span class='description'>
			<?php esc_html_e("The page to redirect users to after a successful login.", 'jvfrmtd' );?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Redirect to",'jvfrmtd' ); ?> :</h4>
		<fieldset class="inner">
			<select name="jvbpd_ts[login_redirect]">
				<?php
				foreach(
					Array(
						'' => esc_html__('Profile Page (Default)', 'jvfrmtd' ),
						'home' => esc_html__('Main Page', 'jvfrmtd' ),
						'current' => esc_html__('Current Page', 'jvfrmtd' ),
						'admin' => esc_html__('WordPress Profile Page', 'jvfrmtd' )
					) as $key => $text){
					printf(
						'<option value="%1$s" %2$s>%3$s</option>',
						$key,
						selected( jvbpd_tso()->get( 'login_redirect' ) == $key, true, false ),
						$text
					);
				} ?>
			</select>
		</fieldset>


		<h4><?php esc_html_e( "User Agreement",'jvfrmtd' ); ?> :</h4>
		<fieldset class="inner">
			<select name="jvbpd_ts[agree_register]">
				<option value=""><?php esc_html_e( "Disable", 'jvfrmtd' );?></option>
				<?php
				if( $pages = get_posts( "post_type=page&post_status=publish&posts_per_page=-1&suppress_filters=0" ) )
				{
					printf( "<optgroup label=\"%s\">", esc_html__( "Select a page for user agreement", 'jvfrmtd' ) );
					foreach( $pages as $post )
						printf(
							"<option value=\"{$post->ID}\" %s>{$post->post_title}</option>"
							, selected( $post->ID == $jvbpd_tso->get( 'agree_register', '' ), true, false )
						);
					echo "</optgroup>";
				} ?>
			</select>
		</fieldset>

	</td></tr>
	<tr><th>
		<?php esc_html_e("Color Settings",'jvfrmtd' ); ?>
		<span class="description">
			<?php esc_html_e("Choose colors to match your theme.", 'jvfrmtd' );?>
		</span>
	</th><td>

		<h4><?php esc_html_e( "Background Color", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[page_bg]" type="text" value="<?php echo esc_attr( jvbpd_tso()->get( 'page_bg', '#eeeff2' )  );?>" class="wp_color_picker" data-default-color="#FFFFFF">
		</fieldset>

		<h4><?php esc_html_e("Primary Color Selection", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[total_button_color]" type="text" value="<?php echo esc_attr( jvbpd_tso()->get( 'total_button_color' )  );?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

		<h4><?php esc_html_e( "Primary Font Color Selection", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[primary_font_color]" type="text" value="<?php echo esc_attr( jvbpd_tso()->get( 'primary_font_color' ) );?>" class="wp_color_picker" data-default-color="#fff">
		</fieldset>

		<h4><?php esc_html_e("Border Color Setup", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<label><input type="radio" name="jvbpd_ts[total_button_border_use]" value="use" <?php checked($jvbpd_tso->get('total_button_border_use') == "use");?>><?php esc_html_e('Use', 'jvfrmtd' );?></label>
			<label><input type="radio" name="jvbpd_ts[total_button_border_use]" value="" <?php checked($jvbpd_tso->get('total_button_border_use')== "");?>><?php esc_html_e('Not Use', 'jvfrmtd' );?></label>
		</fieldset>

		<h4><?php esc_html_e("Border Color Selection", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<input name="jvbpd_ts[total_button_border_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get( 'total_button_border_color' ) );?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

	</td></tr><tr><th>

		<?php esc_html_e('Miscellaneous Settings','jvfrmtd' ); ?>
		<span class='description'>
			<?php esc_html_e('Other settings', 'jvfrmtd' );?>
		</span>
	</th><td>

		<h4><?php esc_html_e('Preloader', 'jvfrmtd' );?></h4>
		<fieldset class="inner">
			<select name="jvbpd_ts[preloader]">
				<?php
				foreach(
					Array(
						'' => esc_html__( "Disabled", 'jvfrmtd' ),
						'enable' => esc_html__( "Enable", 'jvfrmtd' ),
					) as $strPreLoaderKey => $strPreLoaderLabel
				) {
					printf(
						'<option value="%1$s"%3$s>%2$s</option>',
						$strPreLoaderKey, $strPreLoaderLabel,
						selected( $strPreLoaderKey == jvbpd_tso()->get( 'preloader', false ), true, false )
					);
				} ?>
			</select>

		</fieldset>

		<h4><?php esc_html_e('Fixed Contact-Us Button (on Right-Bottom)', 'jvfrmtd' );?></h4>
		<fieldset class="inner">

			<label>
				<input type="radio" name="jvbpd_ts[scroll_rb_contact_us]" value="use" <?php checked( 'use' == $jvbpd_tso->get('scroll_rb_contact_us') );?>>
				<?php esc_html_e( "Enable", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[scroll_rb_contact_us]" value="" <?php checked( '' == $jvbpd_tso->get('scroll_rb_contact_us') );?>>
				<?php esc_html_e( "Disable", 'jvfrmtd' );?>
			</label>

		</fieldset>

		<h4><?php esc_html_e( "Use Lazy Loading Images", 'jvfrmtd' );?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvbpd_ts[lazyload]" value="" <?php checked( '' == $jvbpd_tso->get('lazyload') );?>>
				<?php esc_html_e( "Enable", 'jvfrmtd' );?>
			</label>
			<label>
				<input type="radio" name="jvbpd_ts[lazyload]" value="disable" <?php checked( 'disable' == $jvbpd_tso->get('lazyload') );?>>
				<?php esc_html_e( "Disable", 'jvfrmtd' );?>
			</label>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e("The contact form floating on all pages",'jvfrmtd' ); ?>
	</th><td>
		<h4><?php esc_html_e('This form is for Contact Modal', 'jvfrmtd' );?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[modal_contact_type]" value='' <?php checked( '' == $jvbpd_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "None", 'jvfrmtd' );?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[modal_contact_type]" value='contactform' <?php checked( 'contactform' == $jvbpd_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "Contact Form", 'jvfrmtd' );?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[modal_contact_type]" value='ninjaform' <?php checked( 'ninjaform' == $jvbpd_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "Ninja Form", 'jvfrmtd' );?>
			</label>

		</fieldset>
		<fieldset class="inner">
			<label>
				<?php esc_html_e('Contact Form ID', 'jvfrmtd' );?><br>
				<input type="text" name="jvbpd_ts[modal_contact_form_id]" value="<?php echo esc_attr( $jvbpd_tso->get('modal_contact_form_id' ) );?>">
			</label>
			<p><?php esc_html_e('To create a Contact Form ID, please go to the Contact Form Menu.', 'jvfrmtd' );?></p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Plugins Settings",'jvfrmtd' ); ?>
	</th><td>

		<h4><?php esc_html_e( "Auto generation for css files from less files", 'jvfrmtd' );?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[wp_less]" value='' <?php checked( '' == jvbpd_tso()->get( 'wp_less' ) );?>>
				<?php esc_html_e( "Disable ( Default )", 'jvfrmtd' );?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[wp_less]" value='enable' <?php checked( 'enable' == jvbpd_tso()->get( 'wp_less' ) );?>>
				<?php esc_html_e( "Enable", 'jvfrmtd' );?>
			</label>

			<div class="description"><?php esc_html_e( "(Recommended : disable - it's already included necessary css files )", 'jvfrmtd' );?></div>

		</fieldset>

		<h4><?php esc_html_e( "Module Excerpt", 'jvfrmtd' );?></h4>

		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[core_module_excerpt]" value='' <?php checked( '' == jvbpd_tso()->get('core_module_excerpt') );?>>
				<?php esc_html_e( "wp_trim_words ( Default )", 'jvfrmtd' );?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvbpd_ts[core_module_excerpt]" value='mb_substr' <?php checked( 'mb_substr' == jvbpd_tso()->get('core_module_excerpt') );?>>
				<?php esc_html_e( "mb_substr", 'jvfrmtd' );?>
			</label>
			<div class="description"><?php esc_html_e( "(mb_subsr is for a few languages - excerpt length. ex. Chinese)", 'jvfrmtd' );?></div>

		</fieldset>
	</td></tr>
	</table>
</div>