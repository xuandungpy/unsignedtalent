<?php
/**
* The template for displaying Category pages
*
* Used to display archive-type pages for posts in a category.
*
* @link http://codex.wordpress.org/Template_Hierarchy
*
* @package WordPress
* @subpackage Javo
* @since Javo Themes 1.0
*/

$term_id					= get_queried_object_id();
$strModuleName		= get_option( 'jvbpd_term_' . $term_id . '_module' );
$intExcerptLength	= get_option( 'jvbpd_term_' . $term_id . '_module_length' );
$intExcerptColumns	= get_option( 'jvbpd_term_' . $term_id . '_module_columns' );
$hasModueClass		= class_exists( $strModuleName );
$htmlModuleLoop		= "<div class=\"col-md-12\">%s</div>";
if( $intExcerptColumns == 2 ) {
	$htmlModuleLoop		= "<div class=\"col-md-6\">%s</div>";
}elseif( $intExcerptColumns == 3 ) {
	$htmlModuleLoop		= "<div class=\"col-md-4\">%s</div>";
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
			<?php echo esc_html(single_cat_title( '', false )); ?>
			<span><?php esc_html_e( "Archive", 'jvfrmtd' );?></span>
			<i><?php echo wp_kses( category_description(), jvbpd_allow_tags() ); ?></i>
		</h3>
<?php if( jvbpd_layout()->getThemeType() != 'jvd-lp' ) : ?>
	</header><!-- .archive-header -->
</div>
<?php else : ?>
	</div>
</header>
<?php endif; ?>

<div class="container jv-archive-content-wrap">
	<div class="row">
		<div class="col-md-9 main-content-wrap">
			<section id="primary" class="site-content">
				<div id="content" role="main">
					<?php
					if ( have_posts() )	{
						echo "<div class=\"javo-shortcode row\">";
						while ( have_posts() ) : the_post();
							if( $hasModueClass ) {
								$objModule = new $strModuleName( $post,
									Array(
										'length_content'	=> $intExcerptLength,
										'no_lazy' => true
									)
								);
								printf( $htmlModuleLoop, $objModule->output() );
							}else{
								get_template_part( 'content', get_post_format() );
							}
						endwhile;
						echo "</div><!-- /.javo-shortcode --->";
						jvbpd_content_nav( 'nav-below' );
					}else{
						get_template_part( 'content', 'none' );
					} ?>
				</div><!-- #content -->
			</section><!-- #primary -->
		</div><!-- col-md-9 -->
		<?php get_sidebar(); ?>
	</div><!-- /.row -->
</div> <!-- contaniner -->
<?php
get_footer();