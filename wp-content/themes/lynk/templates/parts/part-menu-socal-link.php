<?php
$social = Array('facebook','twitter', 'instagram', 'youtube','google', 'dribbble', 'pinterest', 'flickr', 'linkedin' );
?>

<div class="social-icons">
	<?php
	foreach($social as $sns){
		if('' != $social_link = jvbpd_tso()->get( $sns )){
			$social_name = $sns;
			printf('<a href="%s" data-toggle="tooltip" data-placement="bottom" title="" required="" data-original-title="%s" target="_blank"><i class="fa fa-%s"></i></a>'
				, esc_url($social_link)
				, ucfirst(strtolower($social_name))
				, $social_name);
		}
	}
	?>
</div>