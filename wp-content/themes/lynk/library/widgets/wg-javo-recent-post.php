<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvbpd_Recent_Posts_widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Recent posts with thumbnails widget.', 'jvfrmtd' ),
		);
		parent::__construct( 'jvbpd_recent_posts', esc_html__('[JAVO] Recent posts','jvfrmtd' ), $widget_ops );
	}

	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$jvbpd_query = new jvbpd_array( $instance );
		$jvbpd_this_post_type = $jvbpd_query->get( 'post_type', 'post' );
		$jvbpd_this_post_excerpt_limit = intVal( $jvbpd_query->get( 'excerpt_length', 20 ) );
		$jvbpd_this_widget_title = apply_filters( 'widget_title', $jvbpd_query->get( 'title', null) );

		$jvbpd_this_posts_args	= Array(
			'post_type' => $jvbpd_this_post_type,
			'posts_per_page' => intVal( $jvbpd_query->get( 'post_count', 3 ) ),
			'post_status' => 'publish',
			'post__not_in' => get_option( 'sticky_posts' ),
			'meta_query' => Array(),
		);

		if( false !== ( $category = $jvbpd_query->get( 'category', false ) ) ) {
			// $category => '1,2,3'  ',' <- Separator
			$arrTerms = array_filter( explode( ',', $category ) );
			if( !empty( $arrTerms ) ) {
				$arrTerms = array_map( 'intVal', $arrTerms );
				$jvbpd_this_posts_args[ 'tax_query' ][] = Array(
					'taxonomy' => 'category',
					'fields' => 'term_id',
					'terms' => $arrTerms,
				);
			}
		}

		// Exclude Sticky Posts
		if( 'post' === $jvbpd_this_post_type )
			$jvbpd_this_posts_args['post__not_in'] = get_option( 'sticky_posts' );

		if( 'post' == $jvbpd_this_post_type && $jvbpd_query->get( 'featured_item' ) == 'use' )
			$jvbpd_this_posts_args[ 'meta_query' ][] = Array(
				'key' => '_featured_item',
				'value' => '1'
			);

		$jvbpd_this_posts = new WP_Query( $jvbpd_this_posts_args );

		ob_start();
		echo $before_widget;
		echo $before_title.$jvbpd_this_widget_title.$after_title;
		?>
		<div class="widget_posts_wrap type-<?php echo sanitize_html_class( $jvbpd_this_post_type ); ?>">
			<?php
			if( $jvbpd_this_posts->have_posts() )
			{
				while( $jvbpd_this_posts->have_posts() )
				{
					$jvbpd_this_posts->the_post();
					$jvbpd_this_permalink	= get_permalink();
					?>
					<div class="latest-posts posts row">
						<div class="col-md-12">
							<span class='thumb'>
								<a href="<?php echo esc_url( $jvbpd_this_permalink ); ?>">
									<?php
									if( has_post_thumbnail() ) {
										$thumbnail_id = get_post_thumbnail_id();
										$thumbnail_url = wp_get_attachment_image_src($thumbnail_id, Array( 80, 80 ) );
										echo '<div class="jv-recent-posts-thumbnail" style="background-image:url('.$thumbnail_url[0].');"></div>';
									} else {
										printf('<img src="%s" width="80" height="80" class="wp-post-image" alt="no image">', jvbpd_tso()->get('no_image')!='' ?  jvbpd_tso()->get('no_image') : jvbpd_IMG_DIR.'/blank-image.png');
									} ?>
								</a>
							</span>
							<?php
							printf('<h3><a href="%s">%s</a></h3><a href="%s"><div class="jv-post-des">%s</div></a>'
								, $jvbpd_this_permalink
								, wp_trim_words( get_the_title(), 20)
								, $jvbpd_this_permalink
								, $this->getContents( get_the_excerpt(), $jvbpd_this_post_excerpt_limit, get_post(), $instance )
							); ?>
						</div><!-- /.col-md-12 -->
					</div><!-- /.row -->
					<?php
				}
			}else{
				esc_html_e('Not Found Posts.', 'jvfrmtd' );
			} ?>
		</div><!-- /.widget_posts_wrap -->
		<?php
		 wp_reset_postdata();
		echo $after_widget;
		ob_end_flush();
	}

	public function getContents( $strExcerpt='', $intLength=20, $post=false, $instance=null ){
		$strTrimExcerpt = wp_trim_words( strip_tags( $strExcerpt ), $intLength );
		$strExcerpt = apply_filters( 'jvbpd_recent_posts_widget_excerpt', $strTrimExcerpt, $intLength=20, $post, $instance );
		return $strExcerpt;
	}

	function form( $instance ) {
		$jvbpd_query = new jvbpd_array( $instance );
		$post_types = apply_filters('jvbpd_shortcodes_post_type_addition', Array( 'post' ) );

		ob_start();

		foreach(
			Array(
				'title' => Array( 'label' => esc_html__( "Title", 'jvfrmtd' ), 'default' => '', ),
				'excerpt_length' => Array( 'label' => esc_html__( "Excerpt Length", 'jvfrmtd' ), 'default' => '20', ),
				'category' => Array(
					'label' => esc_html__( "Category", 'jvfrmtd' ),
					'desc' => esc_html__( "If there is no value, all posts are shown. If there is a value, posts included in the corresponding category are displayed. (Multiple values separated by a comma(,))", 'jvfrmtd' ),
					'default' => '',
				),
			) as $strFieldID => $arrFieldMeta
		) {
			printf(
				'<p><label for="%1$s">%3$s : <input type="text" id="%1$s" class="widefat" name="%2$s" value="%4$s"></label></p>',
				esc_attr( $this->get_field_id( $strFieldID ) ),
				esc_attr( $this->get_field_name( $strFieldID ) ),
				$arrFieldMeta[ 'label' ],
				$jvbpd_query->get( $strFieldID, $arrFieldMeta[ 'default' ] )
			);
			if( isset( $arrFieldMeta[ 'desc' ] ) ) {
				printf( '<div><small>%s</small></div>', $arrFieldMeta[ 'desc' ] );
			}
		} ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>"><?php esc_html_e( 'Limit:', 'jvfrmtd' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'post_count' ); ?>" id="<?php echo $this->get_field_id( 'post_count' ); ?>">
				<?php for ( $i=1; $i<=20; $i++ ) { ?>
					<option <?php selected( (int)$jvbpd_query->get('post_count', 3) , $i ) ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Choose the Post Type: ' , 'jvfrmtd' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php
				if( !empty( $post_types ) ) foreach ( $post_types as $post_type )
					printf(
						"<option value=\"%s\" %s>%s</option>"
						, esc_attr( $post_type )
						, selected( $jvbpd_query->get( 'post_type', 'post' ) == $post_type, true, false )
						, esc_html( $post_type )
					); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'featured_item' ) ); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id( 'featured_item' ); ?>" name="<?php echo $this->get_field_name( 'featured_item' ); ?>" value="use" <?php checked( 'use' == $jvbpd_query->get('featured_item' ) ); ?>>
				<?php esc_html_e( 'Show only featured items: ' , 'jvfrmtd' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'describe_type' ) ); ?>"><?php esc_html_e( 'Description Type: ' , 'jvfrmtd' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'describe_type' ); ?>" name="<?php echo $this->get_field_name( 'describe_type' ); ?>">
				<?php
				$arrDescribeType = apply_filters( 'jvbpd_recent_posts_widget_describe_type_options', Array( '' => esc_html__( 'Post Excerpt', 'jvfrmtd' ) ) );
				if( ! empty( $arrDescribeType ) ) : foreach( $arrDescribeType as $strOption => $strLabel ){
					printf(
						"<option value=\"%s\" %s>%s</option>",
						esc_attr( $strOption ),
						selected( $jvbpd_query->get( 'describe_type', '' ) == $strOption, true, false ),
						esc_html( $strLabel )
					);
				} endif; ?>
			</select>
		</p>
		<?php
		ob_end_flush();
	}
}
/**
* Register widget.

* @since 1.0
*/
add_action( 'widgets_init', create_function( '', 'register_widget( "jvbpd_Recent_Posts_widget" );' ) );