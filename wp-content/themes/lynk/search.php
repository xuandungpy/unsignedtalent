<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
$jvbpd_get_query = new jvbpd_array( $_GET );
{
	add_action( 'wp_enqueue_scripts', 'jvbpd_search_page_enq' );
	function jvbpd_search_page_enq() {
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jQuery-chosen-autocomplete' );
	}
}
get_header(); ?>

<div class="container search-main-container clearfix">
	<div class="row">
		<div class="col-md-9 main-content-wrap">
			<?php if( have_posts() ) { ?>
				<div class="javo-output">
					<?php
					while( have_posts() ) {
						the_post();
						get_template_part( 'content', get_post_format() );
					} // End While
					?>
					<?php jvbpd_content_nav(); ?>
				</div>
			<?php }else{ ?>
				<div class="error-page-wrap">
					<div class="row">
						<div class="col-md-12">
							<div class="error-template">
								<div class="error-details">
									<p><?php esc_html_e( "Please try again", 'jvfrmtd' ) ?></p>
								</div>
								<div class="error-actions">
									<?php get_search_form(); ?>
								</div>
							</div><!-- /.error-template -->
						</div>
					</div>
				</div>
			<?php } ?>
		</div><!-- col-md-9 -->
		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer(); ?>