<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

if( ! defined( 'ABSPATH' ) )
	die( -1 );

$jvbpd_author = new WP_User( get_the_author_meta( 'ID', $post->post_author ) );

get_header();

function jvbpd_single_post_content(){
	global $post;
	do_action( 'jvbpd_post_content_before' );
	while ( have_posts() ) : the_post();
		get_template_part(
			apply_filters(
				'jvbpd_single_template'
				, ( false !== get_post_format() ? 'content-' : 'content' ) . get_post_format()
				, get_the_ID()
			)
		);
	endwhile;
	do_action( 'jvbpd_post_content_after' );

	// Only  Post type for "post"
	comments_template( '', true );
}

do_action( 'jvbpd_single_page_before' ); ?>

<div class="container jv-single-post-content-wrap">
	<div class="row">
		<?php
		switch( apply_filters( 'jvbpd_sidebar_position', 'full', get_the_ID() ) ) :
			case 'full' :
				echo '<div class="col-md-12 main-content-wrap">';
					jvbpd_single_post_content();
				echo '</div>';
			break;
			case 'left' :
				get_sidebar();
				echo '<div class="col-md-9 main-content-wrap">';
					jvbpd_single_post_content();
				echo '</div>';
			break;

			case 'right' :
			default :
				echo '<div class="col-md-9 main-content-wrap">';
					jvbpd_single_post_content();
				echo '</div>';
				wp_reset_postdata();
				get_sidebar();
		endswitch; ?>
	</div>
</div> <!-- container -->

<?php
do_action( 'jvbpd_single_page_after' );
get_footer();