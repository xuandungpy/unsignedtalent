<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

if( ! defined( 'ABSPATH' ) ) {
	die( -1 );
}
get_header();
do_action( 'jvbpd_single_page_before' ); ?>

<div class="container">
	<?php
	switch( apply_filters( 'jvbpd_sidebar_position', 'full', get_the_ID() ) ) {
		case "left":
			?>
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
</div> <!-- container -->
<?php
do_action( 'jvbpd_single_page_after' );
get_footer();