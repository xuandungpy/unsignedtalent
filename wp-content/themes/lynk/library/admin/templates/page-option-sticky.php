<table class="widefat">
	<tr>
		<td colspan="2">
			<h2><?php esc_html_e("Sticky Options", 'jvfrmtd' );?></h2>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Sticky Navi on / off", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[header_sticky]">
							<?php
							foreach( $jvbpd_options['able_disable'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("header_sticky"), true, false ) );
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
		<td valign="middle"><p><?php esc_html_e("Sticky Header Menu Skin", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvbpd_hd[sticky_header_skin]">
							<?php
							foreach( $jvbpd_options['header_skin'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvbpd_query->get("sticky_header_skin"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown. ", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="alternate">
		<td valign="middle"><p><?php esc_html_e("Initial Sticky Header Background Color", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvbpd_hd[sticky_header_bg]" value="<?php echo esc_attr( $jvbpd_query->get("sticky_header_bg", null ));?>" class="wp_color_picker">
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
		<td valign="middle"><p><?php esc_html_e("Initial Sticky Header Transparency", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%">
						<select name="jvbpd_hd[sticky_header_opacity_as]" data-docking>
							<?php
							foreach( $jvbpd_options['default_able'] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvbpd_query->get("sticky_header_opacity_as"), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="25%">
						<?php
						if( false === ( $jvbpd_options['sticky_opacity'] = $jvbpd_query->get("sticky_header_opacity") ) )
						{
							$jvbpd_options['sticky_opacity'] = 1;
						} ?>
						<input type="text" name="jvbpd_hd[sticky_header_opacity]" value="<?php echo (float)$jvbpd_options['sticky_opacity'];?>">
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
</table>