<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */

do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) :
if( class_exists( 'lynkBp_ShortcodeParse' ) ) { ?>
	<div id="pag-top" class="pagination">
		<div class="pag-count" id="member-dir-count-top">
			<?php bp_members_pagination_count(); ?>
		</div>
		<div class="pagination-links" id="member-dir-pag-top">
			<?php bp_members_pagination_links(); ?>
		</div>
	</div>
	<?php
	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' );
	$objShortcode = new lynkBp_ShortcodeParse(
		array(
			'display_category_tag' => 'hide',
		)
	);
	$objShortcode->sHeader(); ?>
	<div class="mm shortcode-container no-flex-menu" id="<?php echo esc_attr( $objShortcode->getID() ); ?>">
	<!--<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all"> -->
		<ul class="grid effect-3" id="members-loop-animation">
			<div class="loading-image hidden"></div>
			<?php while ( bp_members() ) : bp_the_member(); ?>
			<?php // Get the Cover Image
			$member_cover_image_url = bp_attachments_get_attachment('url', array(
			  'object_dir' => 'members',
			  'item_id' => bp_get_member_user_id(),
			));

			if($member_cover_image_url == "") {
				$group_cover_image_css="no-background";
			}else {
				$group_cover_image_css="";
			}

			$avatar_args = array(
				'type'   => 'thumb',
				'width'  => false,
				'height' => false,
				'class'  => 'avatar img-circle author-img card-profile-img rounded-circle',
				'id'     => false
			); ?>

			<li class="shortcode-output">

				<?php
				$strModule = 'moduleBpGrid';
				if( class_exists( $strModule ) ) {
					$objContent = new stdClass;
					$objContent->ID = $objContent->post_status = $objContent->post_content = $objContent->post_type = null;
					$objContent->post_author = bp_get_member_user_id();
					$objContent->post_title = bp_get_member_name();
					$objArticle = new $strModule( $objContent, Array( 'hide_meta' => true ) );

					$objArticle->permalink = bp_get_member_permalink();
					$objArticle->title = $objArticle->get_title();
					$objArticle->avatar = bp_get_member_avatar( $avatar_args );

					add_filter( 'jvbpd_module_css', 'jvbpd_add_member_loop_class', 10, 2 );
					add_action( 'jvbpd_module_hover_content', 'jvbpd_add_member_loop_action', 10, 2 );
					add_filter( 'jvbpd_module_thumbnail_src', 'jvbpd_bp_member_thumbnail', 10, 2 );
					add_filter( 'jvbpd_no_image', 'jvbpd_bp_module_no_image', 10 );
					echo $objArticle->output();
					remove_filter( 'jvbpd_module_css', 'jvbpd_add_member_loop_class', 10, 2 );
					remove_action( 'jvbpd_module_hover_content', 'jvbpd_add_member_loop_action', 10, 2 );
					remove_filter( 'jvbpd_module_thumbnail_src', 'jvbpd_bp_member_thumbnail', 10, 2 );
					remove_filter( 'jvbpd_no_image', 'jvbpd_bp_module_no_image', 10 );
				} ?>
			</li>
			<?php endwhile; ?>
		</ul>
	</div><!-- mm -->

	<?php

	$objShortcode->sFooter();

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php
}else{
	printf(
		'<div>%s</div>',
		esc_html__( "You must activate 'Core' (required plugin) to work properly. please activate the plugin.", 'jvfrmtd' )
	);
}
else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'jvfrmtd' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' );