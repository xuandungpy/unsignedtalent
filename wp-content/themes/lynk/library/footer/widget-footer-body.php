<?php
$intFooterColumns = jvbpd_tso()->get( 'footer_sidebar_columns', 'column3' ) == 'column4' ? 4 : 3;
$arrFooterClasses = Array( 'container', 'footer-sidebar-wrap' );
$arrFooterClasses[] = 'columns-' . $intFooterColumns;
?>

<div class="footer-background-wrap">
	<footer class="footer-wrap">
		<div class="<?php echo join( ' ', $arrFooterClasses ); ?>">
			<div class="row">
				<?php
				for( $intCurWidget=1; $intCurWidget <= $intFooterColumns; $intCurWidget++ ) {
					$strItemColumnClasses = $intFooterColumns == 4 ? 'col-md-3 col-sm-6 col-xs-12' : 'col-md-4';
					$strItemSidebarName = 'sidebar-foot' . $intCurWidget;
					echo '<div class="' . $strItemColumnClasses . '">';
					if( is_active_sidebar( $strItemSidebarName ) ) {
						dynamic_sidebar( $strItemSidebarName );
					}
					echo '</div>';
				} ?>
			</div> <!-- row -->
			<?php if($jvbpd_tso->get('footer_info_use') == 'active'){ ?>

			<div class="jv-footer-separator"></div>

			<div class="row jv-footer-info">
				<div class="col-sm-3 jv-footer-info-logo-wrap">
					<div class="jv-footer-logo-text-title">
						<?php esc_html_e( "Contact", 'jvfrmtd' ); ?>
					</div>
					<div class="jv-footer-info-logo">
						<?php
						printf('<p class="contact_us_detail"><a href="%s"><img src="%s" data-at2x="%s" alt="javo-footer-info-logo"></a></p>'
							, get_site_url()
							, ($jvbpd_tso->get( 'bottom_logo_url' ) != "" ?  $jvbpd_tso->get('bottom_logo_url') : JVBPD_IMG_DIR."/jv-logo1.png")
							, ($jvbpd_tso->get( 'bottom_retina_logo_url' ) != "" ?  $jvbpd_tso->get('bottom_retina_logo_url') : "")
						); ?>
					</div>

					<?php if($jvbpd_tso->get( 'email' )!=='') ?><div class="jv-footer-info-email"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo  esc_attr($jvbpd_tso->get( 'email' )); ?>"><?php echo esc_html($jvbpd_tso->get( 'email' )); ?></a></div>
					<?php if($jvbpd_tso->get("working_hours")!=='') ?><div class="jv-footer-info-working-hour"><i class="fa fa-clock-o"></i> <?php echo esc_html($jvbpd_tso->get("working_hours")); ?></div>

					<?php if($jvbpd_tso->get('footer_social_use') == 'active'){ ?>
					<div class="jv-footer-info-social-icon-wrap">
						<?php
							if($jvbpd_tso->get( 'facebook' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-facebook'></i></a></div>", esc_html($jvbpd_tso->get("facebook")) );
							if($jvbpd_tso->get( 'twitter' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-twitter'></i></a></div>", esc_html($jvbpd_tso->get("twitter")) );
							if($jvbpd_tso->get( 'google' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-google-plus'></i></a></div>", esc_html($jvbpd_tso->get("google")) );
							if($jvbpd_tso->get( 'dribbble' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-dribbble'></i></a></div>", esc_html($jvbpd_tso->get("dribbble")) );
							if($jvbpd_tso->get( 'pinterest' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-pinterest'></i></a></div>", esc_html($jvbpd_tso->get("pinterest")) );
							if($jvbpd_tso->get( 'instagram' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-instagram'></i></a></div>", esc_html($jvbpd_tso->get("instagram")) );
						} ?>
					</div>
				</div>

				<div class="col-sm-6 jv-footer-info-text-wrap">
					<div class="jv-footer-info-text-title">
						<?php echo wp_kses( ( $jvbpd_tso->get('footer_info_text_title') !== '' ? esc_html($jvbpd_tso->get('footer_info_text_title')) : ''), jvbpd_nav_menus() ); ?>
					</div>

					<div class="jv-footer-info-text">
						<?php echo wp_kses( ( $jvbpd_tso->get('footer_text') !== '' ?  stripslashes($jvbpd_tso->get('footer_text', '')) : ''), jvbpd_nav_menus() ); ?>
					</div>
				</div>

				<div class="col-sm-3 jv-footer-info-image-wrap">
					<div class="jv-footer-info-image-title">
						<?php echo wp_kses( ( $jvbpd_tso->get('footer_info_image_title') !== '' ? esc_html($jvbpd_tso->get('footer_info_image_title')) : '' ), jvbpd_nav_menus() ); ?>
					</div>
					<?php if(esc_html($jvbpd_tso->get('footer_info_image_url')) != ''){ ?>
					<div class="jv-footer-info-image">
						<img src="<?php echo esc_url_raw($jvbpd_tso->get('footer_info_image_url')) ; ?>" alt="javo-footer-info-image">
					</div>
					<?php } ?>
				</div>
			</div><!-- row jv-footer-info -->
			<?php } ?>

			<?php if( has_nav_menu( 'footer_menu' ) ){ ?>
			<div class="pull-left">
				<div class="row footer-copyright">
						<?php echo stripslashes($jvbpd_tso->get('copyright', null));?>
				</div> <!-- footer-copyright -->
			</div>
			<div class="pull-right">
				<?php
				if( has_nav_menu( 'footer_menu' ) ) {
					wp_nav_menu( array(
						'menu_class'		=> 'list-unstyled',
						'theme_location'	=> "footer_menu",
						'depth'				=> 1,
						'container'			=> false,
						'fallback_cb'		=> "wp_page_menu",
						'walker'			=> new jvnavwalker()
					) );
				} ?>
			</div>
			<?php }else{ ?>

				<?php
				if( jvbpd_layout()->getThemeType() == 'jvd-lk' ) {
					?>
					<div class="row footer-copyright">
						<?php
						$jvbpd_defaultCopyright = sprintf( __( "Copyright&copy;&nbsp; <b>%s</b>", 'lynk' ), get_bloginfo( 'name' ) );
						echo stripslashes( $jvbpd_tso->get('copyright', $jvbpd_defaultCopyright));?>
					</div> <!-- footer-copyright -->
					<?php
				}else{
					?>
					<div class="jvbpd-footer-bottom-wrap">
						<div class="row jvbpd-footer-bottom-logo">
							<?php
								printf('<a href="%s"><img src="%s" data-at2x="%s" alt="javo-footer-info-logo"></a>'
									, get_site_url()
									, ($jvbpd_tso->get( 'bottom_logo_url' ) != "" ?  $jvbpd_tso->get('bottom_logo_url') : JVBPD_IMG_DIR."/logo-white.png")
									, ($jvbpd_tso->get( 'bottom_retina_logo_url' ) != "" ?  $jvbpd_tso->get('bottom_retina_logo_url') : "")
								);
							?>
						</div>

						<div class="row footer-copyright">
							<?php
							$jvbpd_defaultCopyright = sprintf( __( "Copyright&copy;&nbsp; <b>%s</b>", 'jvfrmtd' ), get_bloginfo( 'name' ) );
							echo stripslashes( $jvbpd_tso->get('copyright', $jvbpd_defaultCopyright));?>
						</div> <!-- footer-copyright -->

						<div class="row jvbpd-footer-bottom-social">
							<?php get_template_part('templates/parts/part', 'menu-socal-link'); ?>
						</div>
					</div><!-- jvbpd-footer-bottom-wrap -->
					<?php
					}
				} ?>
		</div> <!-- container -->
	</footer>
</div>