<?php
/**
 * Template for displaying search forms
 *
 * @package WordPress
 * @subpackage Listopia
 * @since Twenty Sixteen 1.0
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php echo _x( 'Search for:', 'label', 'jvfrmtd' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php echo esc_attr_x( 'Type and Hit Enter &hellip;', 'placeholder', 'jvfrmtd' ); ?>">
		<button type="submit" id="searchsubmit">
			<span class=""><i class="fa fa-search"></i></span>
		</button>
	</div>
</form>