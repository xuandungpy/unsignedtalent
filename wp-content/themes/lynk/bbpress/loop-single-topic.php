<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
	<li class="bbp-topic-author">
		<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

		<span class="bbp-topic-started-by"><?php echo bbp_get_topic_author_link( array( 'size' => '40' ) ); ?></span>

		<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>
	</li>
	<li class="bbp-topic-title">

		<?php if ( bbp_is_user_home() ) : ?>

			<?php if ( bbp_is_favorites() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

			<?php elseif ( bbp_is_subscriptions() ) : ?>

				<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<?php bbp_topic_pagination(); ?>

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<p class="bbp-topic-meta">
			<span class="bbp-topic-freshness">

				<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

				<?php bbp_topic_freshness_link(); ?>

				<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

			</span>
			<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

			<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>
			
			<span class="bbp-topic-voice-count"><i class="jvbpd-icon-mic"></i><?php bbp_topic_voice_count(); ?></span>
			
			<span></span>
			<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

				<span class="bbp-topic-started-in"><?php printf( esc_html__( 'in: %1$s', 'jvfrmtd' ), '<a href="' . bbp_get_forum_permalink( bbp_get_topic_forum_id() ) . '">' . bbp_get_forum_title( bbp_get_topic_forum_id() ) . '</a>' ); ?></span>
				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>

		</p>

		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		<?php bbp_topic_row_actions(); ?>

	</li>

	<li class="bbp-topic-reply-count"><div><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?><p><?php _e('Answers','jvfrmtd' ); ?></p></div></li>
	
</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
