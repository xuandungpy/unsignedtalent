<?php
/**
 *
 *
 */
$intPostAuthor	= new WP_User( get_the_author_meta( 'ID' ) ); ?>
<div class="author-info entry-author">
	<div class="author-avatar round-images"><?php echo get_avatar( $intPostAuthor->ID, 80 ); ?></div>
		<div class="author-description">
		<h4><span class="author-heading"><?php esc_html_e( "Author: ",'jvfrmtd' ); ?></span>&nbsp;<?php echo $intPostAuthor->display_name; ?></h4>
		<p class="author-bio"></p>
	</div>
</div>