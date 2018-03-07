<?php

if( ! function_exists( 'jvbpd_theme_default_support' ) ) :
	add_action( 'after_setup_theme', 'jvbpd_theme_default_support', 8);
	function jvbpd_theme_default_support()
	{
		global
			$jvbpd_tso
			, $wp_taxonomies;

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'header-footer-elementor' );

		if( JVBPD_CUSTOM_HEADER )
			add_theme_support( 'custom-header', array( 'header-text'=> false ) );
		add_theme_support( 'custom-background', array(
			'default-color'					=> '',
			'default-image'				=> '',
			'default-repeat'				=> '',
			'default-position-x'			=> '',
			'wp-head-callback'			=> '_custom_background_cb',
			'admin-head-callback'		=> '',
			'admin-preview-callback'	=> ''
		) );

		// Image size define
		add_image_size( 'jvbpd-tiny'				, 80, 80, true );     	// for img on widget
		add_image_size( 'jvbpd-avatar'			, 250, 250, true);  		// User Picture size
		add_image_size( 'jvbpd-box'				, 288, 266, true );   	// for blog
		add_image_size( 'jvbpd-map-thumbnail'	, 150, 165, true ); 			// Map thumbnail size
		add_image_size( 'jvbpd-box-v'			, 400, 219, true );  		// for long width blog
		add_image_size( 'jvbpd-large'			, 500, 400, true );  		// extra large
		add_image_size( 'jvbpd-medium'			, 650, 500, true );  			// the bigest blog
		add_image_size( 'jvbpd-huge'				, 720, 367, true );  	// the bigest blog
		add_image_size( 'jvbpd-item-detail'		, 823, 420, true );  	// type2 detail page
		set_post_thumbnail_size( 132, 133, true );

		$GLOBALS[ 'jvbpd_allow_tags' ] = jvbpd_allow_tags();
		$GLOBALS[ 'jvbpd_single_post_type' ] = jvbpd_single_post_type();
	}
endif;

if( !function_exists( 'jvbpd_allow_tags' ) ) : function jvbpd_allow_tags(){
	return Array(
		'a' => Array(
			'href' => Array(),
			'title' => Array(),
		),
		'b' => Array(),
		'p' => Array(),
		'em' => Array(),
		'strong' => Array(),
		'img' => Array(),
		'span' => Array(),
		'div' => Array(),
	);
} endif;

if( !function_exists( 'jvbpd_single_post_type' ) ) : function jvbpd_single_post_type(){
	return 1;
} endif;

/**
 * Register Navigation Menus
 */

if ( ! function_exists( 'jvbpd_nav_menus' ) ) :
	// Register wp_nav_menus
	function jvbpd_nav_menus() {
		register_nav_menus( array(
			'topbar_left' => esc_html__( 'Top Bar - Left', 'jvfrmtd' ),
			'topbar_right' => esc_html__( 'Top Bar - Right', 'jvfrmtd' ),
			'my_menu_nav' => esc_html__( 'My menu nav', 'jvfrmtd' ),
			'top_nav_menu_left' => esc_html__( 'Top Nav Menu - Left', 'jvfrmtd' ),
			'top_nav_menu_right' => esc_html__( 'Top Nav Menu - Right', 'jvfrmtd' ),
			'sidebar_left' => esc_html__( 'Sidebar - Left', 'jvfrmtd' ),
			'sidebar_right' => esc_html__( 'Sidebar - Right', 'jvfrmtd' ),
		) );
	}
	add_action( 'init', 'jvbpd_nav_menus' );
endif;

if( ! function_exists( 'jvbpd_bpLoginRedirect' ) ) {
	function jvbpd_bpLoginRedirect( $url, $request=Array(), $user=Array() ) {
		global $bp;

		if( is_wp_error( $user ) ){
			return $url;
		}

		if( function_exists( 'bp_core_get_user_domain' ) ) {
			$url = bp_core_get_user_domain( $user->ID );
		}
		return $url;
	}
	add_filter( 'login_redirect', 'jvbpd_bpLoginRedirect', 20, 3 );
}

add_action( 'widgets_init', 'jvbpd_register_sidebars' );

function jvbpd_register_sidebars(){
	$jvbpd_sidebars = Array(
		Array(
			'name'			=> esc_html__( 'Default Sidebar', 'jvfrmtd' ),
			'id'			=> 'sidebar-1',
			'description'	=> esc_html__( 'Widgets in this area will be shown on the default pages.', 'jvfrmtd' ),
			'before_widget'	=> '<div class="widget widgets-wraps default-sidebar">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widgettitle_wrap"><h2 class="widgettitle">',
			'after_title'	=> '</h2></div>',
		),

		Array(
			'name'			=> esc_html__( 'Buddypress Sidebar', 'jvfrmtd' ),
			'id'			=> 'bp-sidebar',
			'description'	=> esc_html__( 'Widgets in this area will be shown on the default pages.', 'jvfrmtd' ),
			'before_widget'	=> '<div id="%1$s" class="widget widgets bp-sidebar clearfix %2$s">',
			'before_widget'	=> '<div class="widget widgets-wraps">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widgettitle_wrap"><h2 class="widgettitle">',
			'after_title'	=> '</h2></div>',
		),

		Array(
			'name'			=> esc_html__( 'BBpress Sidebar', 'jvfrmtd' ),
			'id'			=> 'bb-sidebar',
			'description'	=> esc_html__( 'Widgets in this area will be shown on the default pages.', 'jvfrmtd' ),
			'before_widget'	=> '<div id="%1$s" class="widget widgets clearfix %2$s">',
			'before_widget'	=> '<div class="widget widgets-wraps bb-sidebar">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widgettitle_wrap"><h2 class="widgettitle">',
			'after_title'	=> '</h2></div>',
		),

		Array(
			'name'			=> esc_html__( 'Woocommerce Sidebar', 'jvfrmtd' ),
			'id'			=> 'woo-sidebar',
			'description'	=> esc_html__( 'Widgets in this area will be shown on the default pages.', 'jvfrmtd' ),
			'before_widget'	=> '<div id="%1$s" class="widget widgets bp-sidebar clearfix %2$s">',
			'before_widget'	=> '<div class="widget widgets-wraps">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="widgettitle_wrap"><h2 class="widgettitle">',
			'after_title'	=> '</h2></div>',
		),

	);

	$intFooterColumns = jvbpd_tso()->get( 'footer_sidebar_columns', 'column3' ) == 'column4' ? 4 : 3;

	for( $intCurWidget=1; $intCurWidget <= $intFooterColumns; $intCurWidget++ ) {
		$jvbpd_sidebars[] = Array(
			'name' => sprintf( esc_html__( 'Footer Sidebar%s', 'jvfrmtd' ), $intCurWidget ),
			'id' => 'sidebar-foot' . $intCurWidget,
			'description' => esc_html__( 'Widgets in this area will be shown on the footer side.', 'jvfrmtd' ),
			'before_widget' => '<div class="widget widgets-wraps">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widgettitle_wrap col-md-12"><h2 class="widgettitle"><span>',
			'after_title' => '</span></h2></div>',
		);
	}

	$jvbpd_sidebars = apply_filters( 'jvbpd_default_sidebars', $jvbpd_sidebars );
	if( !empty( $jvbpd_sidebars ) ) {
		foreach( $jvbpd_sidebars as $sidebar )
			register_sidebar( $sidebar );
	}

}


// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;


function jvbpd_setup() {
	/*
	 * Makes Javo Themes available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Javo Themes, use a find and replace
	 * to change 'jvfrmtd' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jvfrmtd', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'link', 'quote', 'video', 'audio', 'gallery' ) );
}
add_action( 'after_setup_theme', 'jvbpd_setup' );

if( ! function_exists( 'jvbpd_start_wizard' ) ) {
	function jvbpd_start_wizard() {
		if( get_option( 'jvbpd_wizard_setup_visit' ) == 'yes' ) {
			return;
		}

		wp_safe_redirect( esc_url( add_query_arg( Array( 'page' => 'jvbpd-core' ), admin_url( 'themes.php' ) ) ) );
		update_option( 'jvbpd_wizard_setup_visit', 'yes' );
		die;
	}
	add_action( 'after_setup_theme', 'jvbpd_start_wizard' );
}

if( ! function_exists( 'jvbpd_remove_theme_options' ) ) {
	function jvbpd_remove_theme_options() {
		delete_option( 'jvbpd_wizard_setup_visit' );
	}
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvbpd_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Loads the Internet Explorer specific stylesheet.
	$wp_styles->add_data( 'javothemes-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'jvbpd_scripts_styles' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Javo Themes 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function jvbpd_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'jvfrmtd' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'jvbpd_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Javo Themes 1.0
 */
function jvbpd_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'jvbpd_page_menu_args' );

if ( ! function_exists( 'jvbpd_archive_nav' ) ) :
/**
 * Displays navigation to next/previous archives when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvbpd_archive_nav() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	?>
	<div class="jvbpd_pagination">
		<?php
		echo paginate_links( array(
			'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) )
			, 'format'		=> '?paged=%#%'
			, 'current'		=> max( 1, get_query_var('paged') )
			, 'total'		=> $wp_query->max_num_pages
		) ); ?>
	</div><!-- jvbpd_pagination -->
	<?php
}
endif;


if ( ! function_exists( 'jvbpd_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvbpd_content_nav() {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav class="navigation jv-single-post-pager">
			<ul class="pager">
				<li class="next"><?php next_posts_link( wp_kses(__( 'Older posts <i class="fa fa-angle-left"></i>', 'jvfrmtd' ), jvbpd_allow_tags()) ); ?></li>
				<li class="previous"><?php previous_posts_link( wp_kses(__( '<i class="fa fa-angle-right"></i> Newer posts', 'jvfrmtd' ), jvbpd_allow_tags()) ); ?></li>
			</ul><!-- /.pager -->
		</nav>
	<?php endif;
}
endif;

if ( ! function_exists( 'jvbpd_post_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvbpd_post_nav( $args=Array() ) {
	global $post;

	$arrOptions		= shortcode_atts(
		Array(
			'type'				=> 'general',
			'post_thumbnail'	=> false,
			'thumbnail_size'	=> 'jvbpd-tiny',
			'post_title'		=> true,
			'prevClass'			=> 'fa fa-chevron-left',
			'nextClass'			=> 'fa fa-chevron-right',
		), $args
	);

	$strLinkFormat	= '<a href="%s" class="%s">';
	$strIconFormat	= '<i class="%s"></i>';

	switch( $arrOptions[ 'type' ] ) :

		case 'reavl':
		?>
			<nav class="nav-reveal">
				<?php
				if( $objPrevPost = get_previous_post( true ) ){
					printf( $strLinkFormat, get_permalink( $objPrevPost->ID ), 'prev' );
						echo '<span class="icon-wrap">';
							printf( $strIconFormat, $arrOptions[ 'prevClass' ] );
						echo '</span>';
						echo '<div class="nav-contents">';
							if( $arrOptions[ 'post_title' ] )
								printf( '<h3>%s</h3>', esc_html( $objPrevPost->post_title ) );
							if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objPrevPost->ID ) )
								echo get_the_post_thumbnail( $objPrevPost->ID, $arrOptions[ 'thumbnail_size' ] );
						echo '</div>';
					printf( '</a>' );
				}
				if( $objNextPost = get_next_post( true ) ){
					printf( $strLinkFormat, get_permalink( $objNextPost->ID ), 'next' );
						echo '<span class="icon-wrap">';
							printf( $strIconFormat, $arrOptions[ 'nextClass' ] );
						echo '</span>';
						echo '<div class="nav-contents">';
							if( $arrOptions[ 'post_title' ] )
								printf( '<h3>%s</h3>', esc_html( $objNextPost->post_title ) );
							if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objNextPost->ID ) )
								echo get_the_post_thumbnail( $objNextPost->ID, $arrOptions[ 'thumbnail_size' ] );
						echo '</div>';
					printf( '</a>' );
				} ?>
			</nav>
		<?php
		break;
		case 'general':
		default:
		?>
			<nav class="navigation jv-single-post-pager">
				<div class="pager row">
					<div class="col-4 pull-left previous" data-ss="<?php echo esc_attr( $arrOptions[ 'post_thumbnail' ] );?>">
							<?php
							if( $objPrevPost	= get_previous_post( true ) ){
								printf( $strLinkFormat, get_permalink( $objPrevPost->ID ), 'prev' );
									printf( $strIconFormat, $arrOptions[ 'prevClass' ] );
								printf( '</a>' );
							} ?>
					</div>
					<?php
					$intBlogListPageID = jvbpd_tso()->get( 'blog_list_page_id', 0 );
					if( ( get_post( $intBlogListPageID ) instanceof WP_Post ) && is_singular( 'post' ) ) {
						printf( '<div class="col-4"><a href="%s"><i class="fa fa-th-large"></i></a></div>', get_permalink( $intBlogListPageID ) );
					} ?>
					<div class="col-4 pull-right next">
							<?php
							if( $objNextPost	= get_next_post( true ) ){
								printf( $strLinkFormat, get_permalink( $objNextPost->ID ), 'next' );
									printf( $strIconFormat, $arrOptions[ 'nextClass' ] );
								printf( '</a>' );
							} ?>
					</div>
				</ul><!-- /.pager -->
			</nav>
		<?php
	endswitch;
}
endif;

if ( ! function_exists( 'jvbpd_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own jvbpd_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvbpd_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class( 'jv-single-post-comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'jvfrmtd' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'jvfrmtd' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
			// Proceed with normal comments.
			global $post;
			?>
			<li <?php comment_class( 'jv-single-post-comment-item' ); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment media">
					<div class="media-left">
						<?php echo get_avatar( $comment, 75 ); ?>
					</div>
					<div class="media-body">
						<div class="comment-author">
							<?php
							echo join( "\n", Array(
								'<div class="author-meta pull-left">',
								sprintf( '<b class="fn">%s</b>', get_comment_author_link() ),
								sprintf( '<small>%s at %s</small>', esc_html__('Posted at','jvfrmtd' ).' '.get_comment_date(), get_comment_time() ),
								sprintf( '<span>%s</span>',
									get_comment_reply_link(
										Array_merge( $args,
											Array(
												'reply_text'	=> esc_html__( 'Reply', 'jvfrmtd' ),
												'after'			=> ' <span>&darr;</span>',
												'depth'			=> $depth,
												'max_depth'	=> $args['max_depth']
											)
										)
									)
								),
								'</div>',
								'<div class="btn-edit pull-right">',
								sprintf( "<a href=\"%s\">%s</a>", get_edit_comment_link( get_comment_ID() ), esc_html__( "Edit", 'jvfrmtd' ) ),
								'</div>',
							) ); ?>
						</div><!-- /.comment-author -->
						<div class="comment-content">
							<?php comment_text(); ?>
						</div><!-- /.comment-content -->
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'jvfrmtd' ); ?></p>
						<?php endif; ?>

					</div>
				</div>
			<?php
			break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'jvbpd_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own jvbpd_entry_meta() to override in a child theme.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvbpd_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( esc_html__( ', ', 'jvfrmtd' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', esc_html__( ', ', 'jvfrmtd' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf('%s %s', 'jvfrmtd' ), esc_html__('View all posts by', 'jvfrmtd' ), get_the_author() ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = sprintf('%s : %%1$s  %s: %%2$s %s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Category', 'jvfrmtd' ), esc_html__('Tags', 'jvfrmtd' ), esc_html__('Date', 'jvfrmtd' ), esc_html__('by', 'jvfrmtd' ));
	} elseif ( $categories_list ) {
		$utility_text = sprintf('%s %%1$s %s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Category', 'jvfrmtd' ), esc_html__('Date', 'jvfrmtd' ), esc_html__('by', 'jvfrmtd' ));
	} else {
		$utility_text = sprintf('%s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Date', 'jvfrmtd' ), esc_html__('by', 'jvfrmtd' ));
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Javo Themes 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function jvbpd_body_class( $classes ) {

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'javothemes-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'jvbpd_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvbpd_content_width() {
	if ( is_page_template( 'templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'jvbpd_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Javo Themes 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function jvbpd_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'jvbpd_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
 add_action( 'customize_preview_init', 'jvbpd_customize_preview_js' );
function jvbpd_customize_preview_js() {
	wp_enqueue_script( 'javothemes-customizer', get_template_directory_uri() . '/assets/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}



// Recommendation for permalink
if ( '' == get_option( 'permalink_structure' ) ) {
    function wpse157069_permalink_warning() {
		printf( "
			<div id=\"permalink_warning\" class=\"error\">
				<p>
					We strongly recommend adding a
					<a href=\"%s\">permalink structure (Post Name)</a>
					to your site when using Javo Themes.
				</p>
			</div>"
			, esc_url( admin_url( 'options-permalink.php' ) )
		);
    }
    add_action( 'admin_footer', 'wpse157069_permalink_warning' );
}

//restrict authors to only being able to view media that they've uploaded
function ik_eyes_only( $wp_query ) {
	//are we looking at the Media Library or the Posts list?
	if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false
	|| strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
		//user level 5 converts to Editor
		if ( !current_user_can( 'manage_options' ) ) {
			//restrict the query to current user
			global $current_user;
			$wp_query->set( 'author', $current_user->id );
		}
	}
}

//filter media library & posts list for authors
add_filter('parse_query', 'ik_eyes_only' );