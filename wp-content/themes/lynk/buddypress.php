<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

if( ! defined( 'ABSPATH' ) )
	die( -1 );

get_header();
do_action( 'jvbpd_single_page_before' ); ?>

<div class="container" <?php if( bp_current_component() ){ echo "id='buddypress'";} ?>>

	<?php
	if( jvbpd_layout()->getThemeType() == 'jvd-lp' && bp_is_my_profile() ){
		?>
		<div class="row jvbp_is_my_profile">
			<div class="bp-my-menu">
				<?php bp_get_displayed_user_nav(); ?>
			</div>
			<div class="bp-my-content">
	<?php } ?>


	<?php if (bp_current_component() || bp_is_single_item() ) { ?>
	<?php if (bp_is_user()){  // is bp single item pages. ?>
	<div id="item-header" role="complementary">
		<?php
		/*** If the cover image feature is enabled, use a specific header */
		if ( bp_displayed_user_use_cover_image_header() ) :
			bp_get_template_part( 'members/single/cover-image-header' );
		else :
			bp_get_template_part( 'members/single/member-header' );
		endif;
		?>
	</div><!-- #item-header -->

	<?php } elseif (bp_is_group()){  // is bp single item pages. ?>
	<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>
	<div id="item-header" role="complementary">
		<?php
		/**
		 * If the cover image feature is enabled, use a specific header
		 */
		if ( bp_group_use_cover_image_header() ) :
			bp_get_template_part( 'groups/single/cover-image-header' );
		else :
			bp_get_template_part( 'groups/single/group-header' );
		endif;
		?>
	</div><!-- #item-header -->
	<?php endwhile; endif; ?>

	<?php } ?>
	<?php } ?>


	<?php
	switch( apply_filters( 'jvbpd_sidebar_position', 'full', get_the_ID() ) ) {
		case "left":
			?>
			<div class="container">
				<div class="row">
					<?php get_sidebar();?>
					<div class="col-md-9 main-content-wrap">
						<?php
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'page' );
							if ( comments_open() || get_comments_number() )
								comments_template();
						endwhile;
						?>
					</div>
				</div>
			</div>
			<?php
		break;
		case "full":
			?>
			<div class="row">
				<div class="col-md-12 main-content-wrap">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'page' );
						if ( comments_open() || get_comments_number() )
							comments_template();
					endwhile;
					?>
				</div>

			</div>
			<?php
		break;
		case "right":
		default:
			?>
			<div class="container">
				<div class="row">
					<div class="col-md-9 main-content-wrap">
						<?php
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'page' );
							if ( comments_open() || get_comments_number() )
								comments_template();
						endwhile;
						?>
					</div>
					<?php
					wp_reset_postdata();
					get_sidebar();?>
				</div>
			</div>
		<?php
	}; ?>


	<?php
	if ( jvbpd_layout()->getThemeType() == 'jvd-lp' && bp_is_my_profile()) {
		?>
			</div> <!-- bp-my-content -->
		</div> <!-- row -->
	<?php } ?>

</div> <!-- container -->
<?php
do_action( 'jvbpd_single_page_after' );
get_footer();