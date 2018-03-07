<?php
/**
 * Output the search form markup.
 *
 * @since 2.7.0
 */
?>

<div class="dir-search-wrap">
	<div id="<?php echo esc_attr( bp_current_component() ); ?>-dir-search" class="dir-search" role="search" style="position:relative;display:inline-block;">
		<form action="" method="get" id="search-<?php echo esc_attr( bp_current_component() ); ?>-form" class="app-search hidden-xs">
			<label for="<?php bp_search_input_name(); ?>" class="bp-screen-reader-text"><?php bp_search_placeholder(); ?></label>
			<input type="text" name="<?php echo esc_attr( bp_core_get_component_search_query_arg() ); ?>" id="<?php bp_search_input_name(); ?>" placeholder="<?php bp_search_placeholder(); ?>" class="form-control"> 
			<button type="submit" id="<?php echo esc_attr( bp_get_search_input_name() ); ?>_submit" name="<?php bp_search_input_name(); ?>_submit">
				<i class="fa fa-search"></i>
			</button>
		</form>
	</div>
</div>