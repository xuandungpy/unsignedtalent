<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
?>
					</div><!-- /.container-fluid -->
				</div><!-- /#wrapper -->
			</div><!-- content-page-wrapper -->
		</div> <!-- / #page-style -->
		<?php

		get_template_part('library/header/right', 'sidebar');
		do_action( 'jvbpd_body_after', get_page_template_slug() );
		wp_footer(); ?>
	</body>
</html>