<?php
global $jvbpd_query; ?>
<table class="widefat">

	<tr>
		<td valign="middle"><?php esc_html_e( "Topbar", 'jvfrmtd' );?></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<select name="jvbpd_hd[topbar]" data-show-field='<?php echo json_encode( Array( 'enable' => Array( '#topbar_height_field', '#topbar_bg_color_field', '#topbar_text_color_field', '#topbar_logo_field' ) ) ); ?>'>
							<?php
							foreach( $jvbpd_options[ 'able_disable' ] as $label => $value )
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvbpd_query->get( 'topbar' ), true, false )
								);
							?>
						</select>
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr id="topbar_height_field" class="hidden">
		<td valign="middle"><?php esc_html_e( "Topbar Height", 'jvfrmtd' );?></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<input type="number" name="jvbpd_hd[topbar_height]" value="<?php echo esc_attr( $jvbpd_query->get( 'topbar_height', '0' ));?>">
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr id="topbar_bg_color_field" class="hidden">
		<td valign="middle"><?php esc_html_e( "Topbar Background Color", 'jvfrmtd' );?></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<input type="text" name="jvbpd_hd[topbar_bg_color]" value="<?php echo esc_attr( $jvbpd_query->get( 'topbar_bg_color' ));?>" class="wp_color_picker" data-default-color="#ffffff">
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr id="topbar_text_color_field" class="hidden">
		<td valign="middle"><?php esc_html_e( "Topbar Text Color", 'jvfrmtd' );?></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<input type="text" name="jvbpd_hd[topbar_text_color]" value="<?php echo esc_attr( $jvbpd_query->get( 'topbar_text_color' ));?>" class="wp_color_picker">
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr id="topbar_logo_field" class="hidden">
		<td valign="middle"><p><?php esc_html_e("Topbar Logo", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<div class="jv-uploader-wrap" style="padding-left:12px;">
				<input type="text" name="jvbpd_hd[topbar_logo]" value="<?php echo esc_attr( $jvbpd_query->get('topbar_logo'));?>" >
				<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>" data-btn="<?php esc_html_e( "Select", 'jvfrmtd' ); ?>">
					<span class="dashicons dashicons-admin-appearance"></span>
					<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>
				</button>
				<button type="button" class="button remove">
					<?php esc_html_e( "Delete", 'jvfrmtd' );?>
				</button>
				<h4><?php esc_html_e("Preview",'jvfrmtd' ); ?></h4>
				<img src="<?php echo esc_attr( $jvbpd_query->get( 'topbar_logo' ) );?>" style="max-width:500px;">
			</div>
		</td>
	</tr>





	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Type", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">

						<select name="jvbpd_hd[header_type]" data-docking data-show-field='<?php echo json_encode( Array( 'jv-nav-row-2' => Array( '#header_banner_field' ) ) ); ?>'>
							<?php
							foreach( $jvbpd_options[ 'header_type' ] as $label => $value ) {
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvbpd_query->get( 'header_type' ), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Type", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[header_relation]">
							<?php
							foreach( $jvbpd_options['header_relation'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("header_relation"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'jvfrmtd' );?></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr id="header_banner_field" class="hidden">
		<td valign="middle"><p><?php esc_html_e("Header Banner", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<div class="jv-uploader-wrap" style="padding-left:12px;">
				<input type="text" name="jvbpd_hd[header_banner]" value="<?php echo esc_attr( $jvbpd_query->get('header_banner'));?>" >
				<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>" data-btn="<?php esc_html_e( "Select", 'jvfrmtd' ); ?>">
					<span class="dashicons dashicons-admin-appearance"></span>
					<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>
				</button>
				<button type="button" class="button remove">
					<?php esc_html_e( "Delete", 'jvfrmtd' );?>
				</button>
				<h4><?php esc_html_e("Preview",'jvfrmtd' ); ?></h4>
				<img src="<?php echo esc_attr( $jvbpd_query->get( 'header_banner' ) );?>" style="max-width:500px;">
			</div>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e( "Logo", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<div class="jv-uploader-wrap" style="padding-left:12px;">
							<input type="text" name="jvbpd_hd[header_logo]" value="<?php echo esc_attr( $jvbpd_query->get('header_logo'));?>" >
							<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Logo", 'jvfrmtd' ); ?>" data-btn="<?php esc_html_e( "Select", 'jvfrmtd' ); ?>">
								<span class="dashicons dashicons-admin-appearance"></span>
								<?php esc_html_e( "Select Logo", 'jvfrmtd' ); ?>
							</button>
							<button type="button" class="button remove">
								<?php esc_html_e( "Delete", 'jvfrmtd' );?>
							</button>
							<h4><?php esc_html_e( "Preview",'jvfrmtd' ); ?></h4>
							<img src="<?php echo esc_attr( $jvbpd_query->get( 'header_logo' ) );?>" style="max-widht:30%;">
						</div>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e( "A custom logo for this page", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Menu Skin", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[header_skin]">
							<?php
							foreach( $jvbpd_options['header_skin'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("header_skin"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown.", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="alternate">
		<td valign="middle"><p><?php esc_html_e("Initial Header Background Color", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvbpd_hd[header_bg]" value="<?php echo esc_attr( $jvbpd_query->get("header_bg", null));?>" class="wp_color_picker">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Initial Header Transparency", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%" valign="middle">
						<select name="jvbpd_hd[header_opacity_as]" data-docking>
							<?php
							foreach( $jvbpd_options[ 'default_able' ] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>",
									selected( $value == $jvbpd_query->get( 'header_opacity_as' ), true, false )
								);
							} ?>
						</select>
					</td>
					<td width="25%" valign="middle">
						<?php
						if( false === ( $jvbpd_options['opacity'] = $jvbpd_query->get( 'header_opacity', false ) ) ) {
								$jvbpd_options['opacity'] = 0;
						} ?>
						<input type="text" name="jvbpd_hd[header_opacity]" value="<?php echo (float)$jvbpd_options['opacity'];?>">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Height", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%" valign="middle">
						<select name="jvbpd_hd[header_size_as]" data-docking>
							<?php
							foreach( $jvbpd_options['default_able'] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvbpd_query->get( 'header_size_as' ), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="25%" valign="middle">
						<input type="text" name="jvbpd_hd[header_size]" value="<?php echo intVal( $jvbpd_query->get( 'header_size', 40  ) );?>">
					</td>
					<td width="50%" valign="middle">
						<small class="description"><?php esc_html_e( "Pixcel", 'jvfrmtd' ); ?></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Shadow", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[header_shadow]">
							<?php
							foreach( $jvbpd_options['able_disable'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("header_shadow"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Position", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[header_fullwidth]">
							<?php
							foreach( $jvbpd_options['header_fullwidth'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("header_fullwidth"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>