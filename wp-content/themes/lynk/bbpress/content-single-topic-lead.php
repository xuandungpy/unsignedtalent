<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
?>
<div class="container-inner">
	<?php do_action( 'bbp_template_before_lead_topic' ); ?>
	<div id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">
		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

			<h2 class="single_topic_title"><?php single_post_title(); ?></h2>
			<div class="bbp_topic_author_info">
				<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>
				<?php bbp_topic_author_link( array( 'show_role' => true, 'size' => 32 ) ); ?>
				<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>
			</div><!-- bbp_topic_author_info -->

			<?php
			$arrThisTopicMeta = Array();
			if( function_exists( 'bbp_get_topic_reply_count' ) ) {
				$arrThisTopicMeta[] = sprintf( "<i class='%1\$s'></i> " . esc_html__( "%2\$s Replies", 'jvfrmtd' ), 'jvbpd-icon3-comment2', bbp_get_topic_reply_count() );
			}
			if( function_exists( 'bbp_get_topic_voice_count' ) ) {
				$arrThisTopicMeta[] = sprintf( "<i class='%1\$s'></i> " . esc_html__( "%2\$s Voices", 'jvfrmtd' ), 'jvbpd-icon3-volume2', bbp_get_topic_voice_count() );
			}
			if( function_exists( 'bbp_get_topic_freshness_link' ) ) {
				$arrThisTopicMeta[] = sprintf( "<i class='%1\$s'></i> %2\$s", 'jvbpd-icon3-clock', bbp_get_topic_freshness_link() );
			}
			if( function_exists( 'pvc_get_post_views' ) ) {
				$arrThisTopicMeta[] = sprintf( "<i class='%1\$s'></i> " . esc_html__( "%2\$s Views", 'jvfrmtd' ), 'jvbpd-icon3-pie-chart', pvc_get_post_views() );
			} ?>

			<ul class="bbp_topic_meta text-center"><li><?php echo join( '</li><li>', $arrThisTopicMeta ); ?></li></ul> <!-- bbp_topic_meta -->


			<div class="bbp-topic-content">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<?php bbp_topic_content(); ?>

				<?php bbp_topic_tag_list(); ?>

				<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

				<?php //do_action( 'bbp_theme_before_topic_admin_links' ); ?>

				<?php bbp_topic_admin_links(); ?>

				<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>

				<span class="bbp-topic-post-date"><?php bbp_topic_post_date(); ?></span>
				<div class="bbp-topic-author">
					<?php if ( bbp_is_user_keymaster() ) : ?>

						<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

						<div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

						<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

					<?php endif; ?>
				</div><!-- .bbp-topic-author -->

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>

			</div><!-- .bbp-topic-content -->

		</div><!-- #post-<?php bbp_topic_id(); ?> -->
	</div> <!-- bbp-lead-topic -->

<?php do_action( 'bbp_template_after_lead_topic' ); ?>
</div> <!-- container-inner -->
<?php


bbp_list_forums(array (
        'before' => '<tr>',
        'after' => '</tr>',
        'link_before' => '<td>',
        'link_after' => '</td>',
        'separator' => '',
));
 add_filter( 'bbp_before_list_forums_parse_args', 'your_filter_name' );
?>