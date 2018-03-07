<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0
 */

do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>
<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) :
if( class_exists( 'lynkBp_ShortcodeParse' ) ) { ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="group-dir-count-top">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-top">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_list' );

	
	$objShortcode = new lynkBp_ShortcodeParse(
		array(
			'display_category_tag' => 'hide',
		)
	);
	$objShortcode->sHeader(); ?>
	<div class="mm shortcode-container no-flex-menu" id="<?php echo esc_attr( $objShortcode->getID() ); ?>">
		<ul class="grid effect-2" id="group-loop-animation">
			<div class="loading-image hidden"></div>
			<?php while ( bp_groups() ) : bp_the_group();
			// Get the Cover Image
			$group_cover_image_url = bp_attachments_get_attachment('url', array(
				'object_dir' => 'groups',
				'item_id' => bp_get_group_id(),
			));

			if($group_cover_image_url == "") {
				$group_cover_image_css="no-background";
			}else {
				$group_cover_image_css="";
			} ?>
			<li class="shortcode-output">

				<?php
				$strModule = 'moduleBpGrid';
				if( class_exists( $strModule ) ) {
					$objContent = new stdClass;
					$objContent->ID = $objContent->post_status = $objContent->post_content = $objContent->post_type = null;
					$objContent->post_author = bp_get_group_id();
					$objContent->post_title = bp_get_group_name();
					$objArticle = new $strModule( $objContent, Array( 'hide_meta' => true ) );

					$objArticle->permalink = bp_get_group_permalink();
					$objArticle->title = $objArticle->get_title();
					$objArticle->avatar = bp_get_group_avatar('type=thumb&width=50&height=50&class="avatar img-circle author-img card-profile-img rounded-circle"');

					add_filter( 'jvbpd_module_css', 'jvbpd_add_group_loop_class', 10, 2 );
					add_action( 'jvbpd_module_hover_content', 'jvbpd_add_group_loop_action', 10, 2 );
					add_filter( 'jvbpd_module_thumbnail_src', 'jvbpd_bp_group_thumbnail', 10, 2 );
					add_filter( 'jvbpd_no_image', 'jvbpd_bp_module_no_image', 10 );
					echo $objArticle->output();
					remove_filter( 'jvbpd_module_css', 'jvbpd_add_group_loop_class', 10, 2 );
					remove_action( 'jvbpd_module_hover_content', 'jvbpd_add_group_loop_action', 10, 2 );
					remove_filter( 'jvbpd_module_thumbnail_src', 'jvbpd_bp_group_thumbnail', 10, 2 );
					remove_filter( 'jvbpd_no_image', 'jvbpd_bp_module_no_image', 10 );
				} ?>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
	$objShortcode->sFooter();	

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">
			<?php bp_groups_pagination_count(); ?>
		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">
			<?php bp_groups_pagination_links(); ?>
		</div>

	</div>

<?php
}else{
	printf(
		'<div>%s</div>',
		esc_html__( "You must activate 'core' (required plugin) to work properly. please activate the plugin.", 'jvfrmtd' )
	);
}
else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'jvfrmtd' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_groups_loop' );