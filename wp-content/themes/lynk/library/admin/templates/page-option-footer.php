<?php
global $jvbpd_query; ?>
<div id="postcustomstuff">
	<table id="list-table">
		<tbody id="the-list" data-wp-lists="list:meta">
			<tr>
				<td valign="middle" style="20%"><p><?php esc_html_e( "Layout Type", 'jvfrmtd' );?></p></td>
				<td valign="middle" style="80%">
					<table class="javo-post-header-meta">
						<tr>
							<td width="5%" valign="middle">
								<select name="jvbpd_hd[footer_container_type]">
									<?php
									foreach( $jvbpd_options[ 'footer_layout' ] as $label => $value )
										printf(
											"<option value='{$value}' %s>{$label}</option>"
											, selected( $value == $jvbpd_query->get( 'footer_container_type' ), true, false )
										);
									?>

								</select>
							</td>
							<td width="5%" valign="middle">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- /#postcustomstuff -->