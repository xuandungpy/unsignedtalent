<?php
if( ! isset( $objWideCateShortcode ) || ! class_exists( 'module2' ) ) {
	return;
}

$objPosts = $objWideCateShortcode->get_post();
foreach( $objPosts as $ojbPost ) {
	$objModule = new module2(
		$ojbPost,
		array(
			'length_title' => 15,
			'length_content' => 8,
		)
	);
	?>
	<div class="col">
		<?php echo $objModule->output(); ?>
	</div>
<?php
}
$objWideCateShortcode->sParams();
$objWideCateShortcode->pagination(); ?>