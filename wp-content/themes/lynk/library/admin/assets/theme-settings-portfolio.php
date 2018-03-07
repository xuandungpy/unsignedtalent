<?php
$jvbpd_options = Array(
	'header_type' => apply_filters( 'jvbpd_options_header_types', Array() )
	, 'header_skin' => Array(
		esc_html__("Dark", 'jvfrmtd' )							=> ""
		, esc_html__("Light", 'jvfrmtd' )						=> "light"
	)
	, 'able_disable' => Array(
		esc_html__("Disable", 'jvfrmtd' )					=> "disabled"
		,esc_html__("Able", 'jvfrmtd' )							=> "enable"

	)
	, 'header_fullwidth' => Array(
		esc_html__("Center Left", 'jvfrmtd' )						=> "fixed"
		, esc_html__("Center Right", 'jvfrmtd' )			=> "fixed-right"
		, esc_html__("Wide", 'jvfrmtd' )						=> "full"
	)
	, 'header_relation' => Array(
		esc_html__("Transparency menu", 'jvfrmtd' )	=> "absolute"
		,esc_html__("Default menu", 'jvfrmtd' )				=> "relative"
	)
	, 'portfolio_detail_page_head_style' => Array(
		esc_html__("Featured image with Title", 'jvfrmtd' )	=> "featured_image"
		,esc_html__("Title on the top", 'jvfrmtd' )	=> "title_on_top"
		,esc_html__("Title upper content ", 'jvfrmtd' )				=> "title_upper_content"
	)

	, 'portfolio_detail_page_layout' => Array(
		esc_html__("Full Width - Content After", 'jvfrmtd' )					=> "fullwidth-content-after"
		,esc_html__("Full Width - Content Before", 'jvfrmtd' )					=> "fullwidth-content-before"
		,esc_html__("Right - Side Bar", 'jvfrmtd' )					=> "quick-view"

	)
); ?>

<div class="jvbpd_ts_tab javo-opts-group-tab hidden" tar="portfolio">
	<h2><?php esc_html_e("Portfolio Page Settings", 'jvfrmtd' ); ?> </h2>
	<table class="form-table">
	
	<tr><th>
		<?php esc_html_e( "Header / Menu", 'jvfrmtd' );?>
		<span class="description"></span>
	</th><td>		

		<h4><?php esc_html_e( "Detail Page Menu", 'jvfrmtd' ); ?></h4><hr>
		<fieldset class="inner">
			<dl>
				<dt><?php esc_html_e( "Navi Type", 'jvfrmtd' );?></dt>
				<dd>
					<select name="jvbpd_ts[hd][portfolio_header_relation]">
						<?php
						foreach( $jvbpd_options['header_relation'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvbpd_tso()->header->get("portfolio_header_relation"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'jvfrmtd' );?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Background Color", 'jvfrmtd' );?></dt>
				<dd>
					<input name="jvbpd_ts[portfolio_page_menu_bg_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get( 'portfolio_page_menu_bg_color' ) );?>" class="wp_color_picker" data-default-color="#000000">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Text Color", 'jvfrmtd' );?></dt>
				<dd>
					<input name="jvbpd_ts[portfolio_page_menu_text_color]" type="text" value="<?php echo esc_attr( $jvbpd_tso->get( 'portfolio_page_menu_text_color' ) );?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Initial Header Transparency", 'jvfrmtd' );?></dt>
				<dd>
					<input type="text" name="jvbpd_ts[hd][portfolio_header_opacity]" value="<?php echo esc_attr( jvbpd_tso()->header->get("portfolio_header_opacity", 0 ) );?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'jvfrmtd' );?></div>
				</dd>
			</dl>
		</fieldset>

		<h4><?php esc_html_e( "Header Style", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<dl>
				<dt><?php esc_html_e("Header type", 'jvfrmtd' ); ?></dt>
				<dd>
					<select name="jvbpd_ts[hd][portfolio_detail_page_head_style]">
						<?php
						foreach( $jvbpd_options['portfolio_detail_page_head_style'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvbpd_tso()->header->get("portfolio_detail_page_head_style"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'jvfrmtd' );?></div>					
				</dd>
			</dl>
		</fieldset>
	</td></tr>


	<tr>
		<th>
			<?php esc_html_e( "Default Style", 'jvfrmtd' );?>
			<span class="description"></span>
		</th>
		<td>		
		<h4><?php esc_html_e( "Setup Portfolio List Page", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<select name="jvbpd_ts[portfolio_list_page]">
				<?php
				if( $pages = get_posts( "post_type=page&post_status=publish&posts_per_page=-1&suppress_filters=0" ) )
				{
					printf( "<optgroup label=\"%s\">", esc_html__( "Select a page for portfolio list", 'jvfrmtd' ) );
					foreach( $pages as $post )
						printf(
							"<option value=\"{$post->ID}\" %s>{$post->post_title}</option>"
							, selected( $post->ID == $jvbpd_tso->get( 'portfolio_list_page', '' ), true, false )
						);
					echo "</optgroup>";
				} ?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Default Page Layout", 'jvfrmtd' ); ?></h4>
		<fieldset class="inner">
			<select name="jvbpd_ts[hd][portfolio_detail_page_layout]">
						<?php
						foreach( $jvbpd_options['portfolio_detail_page_layout'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvbpd_tso()->header->get("portfolio_detail_page_layout"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'jvfrmtd' );?></div>		
		</fieldset>
		</td>
	</tr>
	</table>
</div>