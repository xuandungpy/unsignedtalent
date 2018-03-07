<div class="jvbpd-header">
	<div class="container">
		<?php
		if( is_search() ) { ?>
			<?php
			if( have_posts() ) { ?>
				<h1 class="page-title">
					<?php
					printf( '<span>%s</span>', esc_html__( 'Search Results for : ', 'jvfrmtd' ) );
					printf( '%s', esc_html( get_search_query() ) ) ;?>
				</h1>
			<?php }else{ ?>
				<h1 class="page-title">
					<?php esc_html_e( "No result found", 'jvfrmtd' ) ?>
				</h1>
			<?php } ?>
		<?php }else{ ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<span class="jvbpd-breadcrumb">
				<?php
				if( function_exists( 'get_breadcrumb' ) ) {
					get_breadcrumb();
				} ?>
			</span>
		<?php } ?>
	</div>
</div>