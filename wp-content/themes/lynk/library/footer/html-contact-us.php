<?php
if( $jvbpd_tso->get('scroll_rb_contact_us', '') == 'use'):?>
	<div class="javo-quick-contact-us-content">
		<?php
		$jvbpd_quick_contact_shortcode = '';

		switch( $jvbpd_tso->get( 'modal_contact_type' ) ) {
			case 'contactform'	: $jvbpd_quick_contact_shortcode = '[contact-form-7 id=%s title="%s"]'; break;
			case 'ninjaform'	: $jvbpd_quick_contact_shortcode = '[ninja_forms id=%s title="%s"]'; break;
		}

		if(
			(int) $jvbpd_tso->get( 'modal_contact_form_id' , 0 ) > 0 &&
			false !== $jvbpd_tso->get( 'modal_contact_type', false)
		){
			$jvbpd_contact_form_shortcode = sprintf(
				$jvbpd_quick_contact_shortcode
				, $jvbpd_tso->get( 'modal_contact_form_id' )
				, esc_html__( 'Javo Contact Form', 'jvfrmtd' )
			);

			echo do_shortcode( $jvbpd_contact_form_shortcode );
		}else{
			?>
			<div class="alert alert-light-gray">
				<strong><?php esc_html_e('Please create a form with contact 7 or Ninja form and add.', 'jvfrmtd' );?></strong>
				<p><?php esc_html_e('Theme Settings > General > Contact Form Modal Settings', 'jvfrmtd' );?></p>
			</div>
			<?php
		} ?>
	</div>
<?php
endif;

if( is_user_logged_in() )
	printf('<input type="hidden" class="javo-this-logged-in" value="use">');