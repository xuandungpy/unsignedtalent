<?php
global $jvbpd_query; ?>
<table class="widefat">
	<tr>
		<td valign="middle" width="30%"><p><?php esc_html_e("Page Background Color", 'jvfrmtd' );?></p></td>
		<td valign="middle" width="70%">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvbpd_hd[page_bg]" value="<?php echo esc_attr( $jvbpd_query->get("page_bg", null ) );?>" class="wp_color_picker">
					</td>
					<td valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'jvfrmtd' );?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e( "Page Layout Type", 'jvfrmtd' );?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<select name="jvbpd_hd[layout_style_boxed]">
							<option value=''><?php esc_html_e( "Default as theme settings", 'jvfrmtd' ); ?></option>
							<?php
							foreach( jvbpd_layout()->getPageLayoutTypes() as $value => $label )
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvbpd_query->get( 'layout_style_boxed' ), true, false )
								);
							?>

						</select>
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Page Background Image", 'jvfrmtd' ); ?></p></td>
		<td valign="middle">
			<div class="jv-uploader-wrap">
				<input type="text" name="jvbpd_hd[page_background_image]" value="<?php echo esc_attr( $jvbpd_query->get('page_background_image'));?>" >
				<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>" data-btn="<?php esc_html_e( "Select", 'jvfrmtd' ); ?>">
					<span class="dashicons dashicons-admin-appearance"></span>
					<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>
				</button>
				<button type="button" class="button remove">
					<?php esc_html_e( "Delete", 'jvfrmtd' );?>
				</button>
				<h4><?php esc_html_e("Preview",'jvfrmtd' ); ?></h4>
				<img src="<?php echo esc_attr( $jvbpd_query->get( 'page_background_image' ) );?>" style="max-width:500px;">
			</div>
		</td>
	</tr>
</table>