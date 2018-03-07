<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="post-<?php bbp_reply_id(); ?>" class="bbp-reply-header">
	<div class="bbp-meta">
		<?php if ( bbp_is_single_user_replies() ) : ?>
			<span class="bbp-header">
				<?php esc_html_e( 'in reply to: ', 'jvfrmtd' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>
		<?php endif; ?>
	</div><!-- .bbp-meta -->
</div><!-- #post-<?php bbp_reply_id(); ?> -->

<div <?php bbp_reply_class(); ?>>
	<div class="bbp-reply-content">
		<div class="bbp-reply-author-info">
			<div class="bbp-reply-author">
			<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
			<?php bbp_reply_author_link( array( 'size'=>30, 'sep' => '', 'show_role' => true ) ); ?>
			<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>
			</div><!-- .bbp-reply-author -->
			<?php
			/** Get Reply Author id and My Cred Points / Rank / Logo **/
			$reply_author_id = get_post_field( 'post_author', bbp_get_reply_id() );
			?>
			<?php if( function_exists( 'mycred_get_users_rank' ) ) { ?>
			<div class="bbp-reply-author-rank"><i class="fa fa-trophy"></i>&nbsp;
			<?php echo mycred_get_users_rank( $reply_author_id); ?>
			</div>
			<?php echo mycred_get_users_rank( $reply_author_id, 'logo', 20); ?>
			<?php } ?>

			<?php if( function_exists( 'mycred_get_users_cred' ) ) { ?>
			<div class="mycred_author_points"><i class="fa fa-dot-circle-o"></i>&nbsp;<?php echo mycred_get_users_cred( $reply_author_id ); ?></div> <!-- mycred_author_points -->
			<?php } ?>
		</div><!-- .bbp-reply-author-info -->
		<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>
		<?php bbp_reply_admin_links(); ?>
		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
		<hr/>
		<?php do_action( 'bbp_theme_before_reply_content' ); ?>
		<?php bbp_reply_content(); ?>
		<?php do_action( 'bbp_theme_after_reply_content' ); ?>
		<hr/>
		<i class=" jvbpd-icon3-clock"></i> <span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>
		<?php if ( current_user_can( 'moderate', bbp_get_reply_id() ) ) : ?>
			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>
			<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>
			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>
		<?php endif; ?>

	</div><!-- .bbp-reply-content -->


</div><!-- .reply -->