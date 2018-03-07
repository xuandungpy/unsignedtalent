<?php
if( ! isset( $jvbpd_menu_args ) || ! class_exists( 'LynkBp_ShortcodeParse' ) ) {
	return;
}

jvbpd_header()->getOptions();

$arrShortcodeArgs = Array(
	'count' => 4,
	'filter_by' => 'category',
	'filter_style' => 'general',
	'loading_style' => 'circle',
	'pagination' => 'prevNext',

	// libaray/class-layout.php : add_menu_shortcode_atts > in_menu
	'in_menu' => true,
);

$arrShortcodeArgs[ 'post_title_font_color' ] = $arrShortcodeArgs[ 'post_describe_font_color' ] = $arrShortcodeArgs[ 'post_meta_font_color' ] = '#A7A7A7';

$intCustomTermID = false;
if( 'all' != $jvbpd_menu_args->term_id ) {
	$intCustomTermID = intVal( $jvbpd_menu_args->term_id );
	if( 0 < $intCustomTermID ) {
		$arrShortcodeArgs[ 'custom_filter_by_post' ] = true;
		$arrShortcodeArgs[ 'custom_filter' ] = $intCustomTermID;
	}
}

$objWideCateShortcode = new LynkBp_ShortcodeParse( $arrShortcodeArgs );
?>
	<div class="hidden-xs">
		<?php $objWideCateShortcode->sHeader(); ?>
			<div id="<?php echo esc_attr( $objWideCateShortcode->getID() ); ?>" class="shortcode-container no-flex-menu nav-active">
				<div class="shortcode-header">
					<div class="shortcode-nav">
						<?php $objWideCateShortcode->sFilter(); ?>
					</div>
				</div>
				<div class="row shortcode-output">
					<?php
					jvbpd_layout()->load_template(
						'parts/part-menu-wide-category-loop',
						Array(
							'objWideCateShortcode' => $objWideCateShortcode,
						)
					); ?>
				</div>
			</div>
		<?php $objWideCateShortcode->sFooter(); ?>
	</div>
</li>
<?php
$arrQueryArgs = Array( 'taxonomy' => 'category', 'hide_empty' => 'false', 'fields' => 'id=>name' );
if( $intCustomTermID ) {
	$arrQueryArgs[ 'include' ] = $intCustomTermID;
}
foreach( get_terms( $arrQueryArgs ) as $intTermID => $strTermName ) {
	?>
	<li class="sub-menu-item menu-item-depth-1 hidden-sm hidden-md hidden-lg">
		<a href="<?php echo get_term_link( $intTermID ); ?>" target="_self" class="menu-link sub-menu-link">
			<span class="menu-titles"><?php echo esc_html( $strTermName ); ?></span>
		</a>
	</li>
	<?php
} ?>
<li>