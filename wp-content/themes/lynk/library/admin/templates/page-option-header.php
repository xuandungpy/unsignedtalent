<?php
global $jvbpd_query;
$jvbpd_fancy_dft_opt						= Array(
	'repeat'							=> Array(
		esc_html__("no-repeat", 'jvfrmtd' )		=> 'no-repeat'
		, esc_html__("repeat-x", 'jvfrmtd' )		=> 'repeat-x'
		, esc_html__("repeat-y", 'jvfrmtd' )		=> 'repeat-y'
	)
	, 'background-position-x'			=> Array(
		esc_html__("Left", 'jvfrmtd' )			=> 'left'
		, esc_html__("Center", 'jvfrmtd' )		=> 'center'
		, esc_html__("Right", 'jvfrmtd' )		=> 'right'
	)
	, 'background-position-y'			=> Array(
		esc_html__("top", 'jvfrmtd' )			=> 'top'
		, esc_html__("Center", 'jvfrmtd' )		=> 'center'
		, esc_html__("Bottom", 'jvfrmtd' )		=> 'bottom'
	)
);

// Fancy Option
$get_jvbpd_opt_fancy			= get_post_meta( $post->ID, 'jvbpd_header_fancy_type', true );
$jvbpd_fancy_opts				= get_post_meta( $post->ID, 'jvbpd_fancy_options', true );
$jvbpd_fancy						= new jvbpd_array( $jvbpd_fancy_opts );

// Slide Option
$jvbpd_slider						= maybe_unserialize( get_post_meta( $post->ID, 'jvbpd_slider_options', true ) );
$get_jvbpd_opt_slider			= maybe_unserialize( get_post_meta( $post->ID, 'jvbpd_slider_type', true ) );

$strOutputSliderLists			= Array();

if( class_exists( 'RevSlider' ) ) :
	$objSlideRevolution		= new RevSlider;
	$valCurrentSlider			= !empty( $jvbpd_slider[ 'rev_slider' ] ) ? $jvbpd_slider[ 'rev_slider' ] : null;
	$arrSliderItems				= ( Array ) $objSlideRevolution->getArrSliders();
	$strOutputSliderLists[]	='<select name="jvbpd_slide[rev_slider]">';
	$strOutputSliderLists[]	= sprintf( "<option value=''>%s</option>", esc_html__( "Select Slider", 'jvfrmtd' ) );
	if( !empty( $arrSliderItems ) ) : foreach( $arrSliderItems as $slider ) {
		$strOutputSliderLists[] = sprintf(
			'<option value="%s"%s>%s</option>',
			$slider->getAlias(),
			selected( $slider->getAlias() == $valCurrentSlider, true, false ),
			$slider->getTitle()
		);
	} else:
		$strOutputSliderLists[]	= sprintf( "<optgroup label=\"%s\"></optgroup>", esc_html__( "Empty Slider", 'jvfrmtd' ) );
	endif;
	$strOutputSliderLists[]	='</select>';
else:
	$strOutputSliderLists[]	= sprintf(
		'<label>%s</label>',
		esc_html__( "Please install revolition slider plugin or create slide item." , 'jvfrmtd' )
	);
endif;


$jvbpd_pageHeaderOptions	= Array(
	'op_h_title_show'				=> Array(
		'value'							=> 'default',
		'label'							=> esc_html__( "Show page title", 'jvfrmtd' ),
	),
	'op_h_title_hide'					=> Array(
		'value'							=> 'notitle',
		'label'							=> esc_html__( "Hide page title", 'jvfrmtd' ),
	),
	'op_h_title_fancy'				=> Array(
		'value'							=> 'fancy',
		'label'							=> esc_html__( "Fancy Header", 'jvfrmtd' ),
	),
	'op_h_title_slide'				=> Array(
		'value'							=> 'slider',
		'label'							=> esc_html__( "Slide Show", 'jvfrmtd' ),
	),
);


if( !$get_jvbpd_opt_header = get_post_meta( $post->ID, 'jvbpd_header_type', true ) )
	$get_jvbpd_opt_header = 'default';

if( !empty( $jvbpd_pageHeaderOptions )) : foreach( $jvbpd_pageHeaderOptions as $key => $meta ) {
	$strIsTrue		= $get_jvbpd_opt_header == $meta[ 'value' ];
	$strIsActive		= $strIsTrue ? ' active' : false;

	echo join( "\n",
		Array(
			"<label class=\"jvbpd_pmb_option header {$key}{$strIsActive}\">",
				'<span class="ico_img"></span>',
				sprintf( "<p><input type=\"radio\" name=\"jvbpd_opt_header\" value=\"%s\" %s>%s</p>",
					$meta[ 'value' ],
					checked( $strIsTrue, true, false ),
					$meta[ 'label' ]
				),
			'</label>',
		)
	);

} endif; ?>

<div id="jvbpd_post_header_fancy">
	<div class="">
		<label class="jvbpd_pmb_option fancy op_f_left active">
			<span class="ico_img"></span>
			<p><input name="jvbpd_opt_fancy" type="radio" value="left" checked="checked"> <?php esc_html_e("Title left",'jvfrmtd' ); ?></p>
		</label>
		<label class="jvbpd_pmb_option fancy op_f_center">
			<span class="ico_img"></span>
			<p><input name="jvbpd_opt_fancy" type="radio" value="center"> <?php esc_html_e("Title center",'jvfrmtd' ); ?></p>
		</label>
		<label class="jvbpd_pmb_option fancy op_f_right">
			<span class="ico_img"></span>
			<p><input name="jvbpd_opt_fancy" type="radio" value="right"> <?php esc_html_e("Title right",'jvfrmtd' ); ?></p>
		</label>
	</div>
	<hr>
	<div class="jvbpd_pmb_field">
		<dl>
			<dt><label for="jvbpd_fancy_field_title"><?php esc_html_e("Title",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[title]" id="jvbpd_fancy_field_title" type="text" value="<?php echo esc_attr($jvbpd_fancy->get('title') );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_title_size"><?php esc_html_e("Title Size",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[title_size]" id="jvbpd_fancy_field_title_size" type="text" value="<?php echo esc_attr( $jvbpd_fancy->get('title_size', 17) );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_title_color"><?php esc_html_e("Title Color",'jvfrmtd' ); ?></label></dt>
			<dd>
				<input name="jvbpd_fancy[title_color]" type="text" value="<?php echo esc_attr( $jvbpd_fancy->get('title_color', '#000000') );?>" id="jvbpd_fancy_field_title_color" class="wp_color_picker" data-default-color="#000000">
			</dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_subtitle"><?php esc_html_e("Subtitle",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[subtitle]" id="jvbpd_fancy_field_subtitle" type="text" value="<?php echo esc_attr( $jvbpd_fancy->get('subtitle') );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_subtitle_size"><?php esc_html_e("Subtitle Size",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[subtitle_size]" id="jvbpd_fancy_field_subtitle_size" type="text" value="<?php echo esc_attr( $jvbpd_fancy->get('subtitle_size', 12) );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_subtitle_color"><?php esc_html_e("Subtitle color",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[subtitle_color]" value="<?php echo esc_attr( $jvbpd_fancy->get('subtitle_color', '#000000') );?>" id="jvbpd_fancy_field_subtitle_color" type="text" class="wp_color_picker" data-default-color="#000000"></dd>
		</dl>
		<hr>
		<dl>
			<dt><label for="jvbpd_fancy_field_bg_color"><?php esc_html_e("Background color",'jvfrmtd' ); ?></label></dt>
			<dd><input name="jvbpd_fancy[bg_color]" value="<?php echo esc_attr( $jvbpd_fancy->get('bg_color', '#FFFFFF') );?>" id="jvbpd_fancy_field_bg_color" type="text" class="wp_color_picker" data-default-color="#ffffff"></dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_bg_image"><?php esc_html_e("Background Image",'jvfrmtd' ); ?></label></dt>
			<dd>
				<div class="jv-uploader-wrap">
					<input type="text" name="jvbpd_fancy[bg_image]" value="<?php echo esc_attr( $jvbpd_fancy->get('bg_image'));?>" >
					<button type="button" class="button button-primary upload" data-title="<?php esc_attr_e( "Select Background Image", 'jvfrmtd' ); ?>" data-btn="<?php esc_attr_e( "Select", 'jvfrmtd' ); ?>">
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php esc_html_e( "Select Background Image", 'jvfrmtd' ); ?>
					</button>
					<button type="button" class="button remove">
						<?php esc_html_e( "Delete", 'jvfrmtd' );?>
					</button>
					<h4><?php esc_html_e("Preview",'jvfrmtd' ); ?></h4>
					<img src="<?php echo esc_attr( $jvbpd_fancy->get( 'bg_image' ) );?>" style="max-width:500px;">
				</div>
			</dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_position_x"><?php esc_html_e("Position X",'jvfrmtd' ); ?></label></dt>
			<dd>
				<select name="jvbpd_fancy[bg_position_x]" id="jvbpd_fancy_field_position_x">
					<?php
					foreach( $jvbpd_fancy_dft_opt['background-position-x'] as $label => $value ) {
						echo "<option value=\"{$value}\"".selected( $value == $jvbpd_fancy->get('bg_position_x') ).">{$label}</option>";
					} ?>
				</select>
			</dd>
		</dl>
		<dl>
			<dt><label for="jvbpd_fancy_field_position_y"><?php esc_html_e("Position Y",'jvfrmtd' ); ?></label></dt>
			<dd>
				<select name="jvbpd_fancy[bg_position_y]" id="jvbpd_fancy_field_position_y">
				<?php
					foreach( $jvbpd_fancy_dft_opt['background-position-y'] as $label => $value ) {
						echo "<option value=\"{$value}\"".selected( $value == $jvbpd_fancy->get('bg_position_y') ).">{$label}</option>";
					} ?>
				</select>
			</dd>
		</dl>
		<hr>
		<dl>
			<dt><label for="jvbpd_fancy_field_fullscreen"><?php esc_html_e("Height(pixel)",'jvfrmtd' ); ?> </label></dt
			>
			<dd><input name="jvbpd_fancy[height]" id="jvbpd_fancy_field_fullscreen" value="<?php echo (int)$jvbpd_fancy->get('height', 150);?>" type="text"></dd>
		</dl>

	</div>
</div><!-- /#jvbpd_post_header_fancy -->

<div id="jvbpd_post_header_slide">
	<div class="">
		<label class="jvbpd_pmb_option slider op_d_rev active">
			<span class="ico_img"></span>
			<p><input name="jvbpd_opt_slider" type="radio" value="rev" checked="checked"> <?php esc_html_e("Revolution",'jvfrmtd' ); ?></p>
		</label>
	</div>

	<!-- section  -->
	<div class="jvbpd_pmb_tabs slider jvbpd_pmb_field">
		<div class="jvbpd_pmb_tab active" tab="rev">
			<dl>
				<dt><label><?php esc_html_e("Choose slider",'jvfrmtd' ); ?></label></dt>
				<dd><?php echo join( "\n", $strOutputSliderLists ); ?></dd>
			</dl>
		</div>
	</div>
</div><!-- /#jvbpd_post_header_slide -->