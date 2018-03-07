<?php
global $jvbpd_query;
if( ! $get_jvbpd_opt_sidebar = get_post_meta( $post->ID, 'jvbpd_sidebar_type', true ) )
	$get_jvbpd_opt_sidebar = apply_filters( 'jvbpd_sidebar_position', 'full', $post->ID );
?>

<label class="jvbpd_pmb_option sidebar op_s_left <?php echo sanitize_html_class( $get_jvbpd_opt_sidebar == 'left'? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvbpd_opt_sidebar" value="left" type="radio" <?php checked($get_jvbpd_opt_sidebar == 'left');?>> <?php esc_html_e("Left",'jvfrmtd' ); ?></p>
</label>
<label class="jvbpd_pmb_option sidebar op_s_right <?php echo sanitize_html_class( $get_jvbpd_opt_sidebar == 'right'? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvbpd_opt_sidebar" value="right" type="radio" <?php checked($get_jvbpd_opt_sidebar == 'right');?>> <?php esc_html_e("Right",'jvfrmtd' ); ?></p>
</label>
<label class="jvbpd_pmb_option sidebar op_s_full <?php echo sanitize_html_class( $get_jvbpd_opt_sidebar == 'full' || $get_jvbpd_opt_sidebar == ''? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvbpd_opt_sidebar" value="full" type="radio" <?php checked( $get_jvbpd_opt_sidebar == 'full' || $get_jvbpd_opt_sidebar == '');?>> <?php esc_html_e("Fullwidth",'jvfrmtd' ); ?></p>
</label>

<?php

foreach(
	Array(
		'sidebar_left' => Array(
			'label' => esc_html__( "Left Sidebar", 'jvfrmtd' ),
			'note' => esc_html__( "It shows when there is at least one menu. otherwise, it doesn't show.", 'jvfrmtd' ),
		),
		'sidebar_member' => Array(
			'label' => esc_html__( "Member Sidebar", 'jvfrmtd' ),
			'note' => esc_html__( "It works when required plugins ('Core', 'BuddyPress') are actived. For groups, group component in BuddyPress needs to be actived.", 'jvfrmtd' ),
		),
	) as $strOptionName => $strOptionMeta
) {
	?>
	<h4><?php echo esc_html( $strOptionMeta[ 'label' ] ); ?></h4>
	<fieldset class="inner">
		<select name="jvbpd_hd[<?php echo esc_attr( $strOptionName ); ?>]">
			<?php
			foreach(
				Array(
					'' => esc_html__( "Default as theme settings", 'jvfrmtd' ),
					'enable' => esc_html__( "Enable", 'jvfrmtd' ),
					'disabled' => esc_html__( "Disabled", 'jvfrmtd' ),
				) as $strOption => $strOptionLabel
			) {
				printf(
					'<option value="%1$s"%3$s>%2$s</option>',
					$strOption, $strOptionLabel,
					selected( $strOption == $jvbpd_query->get( $strOptionName ), true, false )
				);
			} ?>
		</select>
		<?php printf( '<p><small>%1$s : %2$s</small></p>', esc_html__( "Note", 'jvfrmtd' ), $strOptionMeta[ 'note' ] ); ?>
	</fieldset>
	<?php
}