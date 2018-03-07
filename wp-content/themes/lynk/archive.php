<?php
/**
 * The template for displaying Archive pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

$jvbpd_query				= new jvbpd_array( $_GET );
$jvbpd_this_terms_object	= get_queried_object();
$jvbpd_this_taxonomy		= isset( $jvbpd_this_terms_object->taxonomy ) ? $jvbpd_this_terms_object->taxonomy : null;
$jvbpd_this_term			= get_queried_object_id();

$jvbpd_ts_default_primary_type = '';
// Enqueues
{
	add_action( 'wp_enqueue_scripts', 'jvbpd_archive_page_enq' );
	function jvbpd_archive_page_enq()
	{
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jQuery-flex-Slider' );
	}
}
get_header(); ?>
<?php if( jvbpd_layout()->getThemeType() != 'jvd-lp' ) : ?>
<div class="container">
	<header class="archive-header">
<?php else : ?>
<header class="archive-header">
	<div class="container">	
<?php endif; ?>

	<h3 class="archive-title">
		<?php
		if ( is_day() ) :
			printf( wp_kses( __( 'Daily Archives: %s', 'jvfrmtd' ), jvbpd_allow_tags()), '<span>' . get_the_date() . '</span>' );
		elseif ( is_month() ) :
			printf( wp_kses( __( 'Monthly Archives: %s', 'jvfrmtd' ), jvbpd_allow_tags()), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'jvfrmtd' ) ) . '</span>' );
		elseif ( is_year() ) :
			printf( wp_kses( __( 'Yearly Archives: %s', 'jvfrmtd' ), jvbpd_allow_tags()), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'jvfrmtd' ) ) . '</span>' );
		elseif( is_author() ) :
			printf( "%s <span>%s</span><i></i>",
				esc_html( get_userdata( get_queried_object_id() )->display_name ),
				esc_html__( "Author", 'jvfrmtd' )
			);
		else:
			printf(
				wp_kses(
					__('%s <span>Archive</span>', 'jvfrmtd' ),
					Array( 'span' => Array() )
				),
				strtoupper( $jvbpd_this_terms_object->name )
			); ?>			
		<?php
		endif; ?>
	</h3>
	<span class="jvbpd-breadcrumb">Home > Post > Markup</span>
<?php if( jvbpd_layout()->getThemeType() != 'jvd-lp' ) : ?>
	</header>
</div>
<?php else : ?>
	</div>
</header>
<?php endif; ?>
	

<!-- Main Container -->
<div class="container archive-main-container">
	<div class="row">
		<div class="col-md-9 main-content-wrap">
			<div class="javo-output padding-top-10 javo-archive-list-wrap">
				<!-- Items List -->
				<div class="javo-archive-items-content row">
				
					<?php
					$jvbpd_this_term_all_item = Array();
					if( have_posts() ){
						while( have_posts() ){
							the_post();
							get_template_part( 'content', get_post_format() );
						}; // End While
					}else{
						get_template_part( 'content', 'none' );
					}; // End If				
					?>
				</div><!-- /.javo-archive-items-content -->
				<?php jvbpd_archive_nav(); ?>			
			</div><!-- /.javo-output -->
		</div><!-- /.col-md-9 -->

		<?php get_sidebar(); ?>
	</div><!-- /.row -->
</div><!-- /.container -->
<?php
get_footer();