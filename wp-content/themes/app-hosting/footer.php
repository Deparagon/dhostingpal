

                                         <!--  THIS IS THE CONTENT MAIN -->

		<?php if ( ! empty( $GLOBALS['dws_public_footer'] ) ) : ?>
			<?php
			$site_name   = get_bloginfo( 'name' );
			$description = get_bloginfo( 'description' );
			$home_link   = home_url( '/' );
			$portal_link = wp_login_url();
			$menu_class  = 'dws-public-footer__menu';
			?>
			<footer class="dws-public-footer" role="contentinfo">
				<div class="container">
					<div class="dws-public-footer__grid">
						<div>
							<a class="dws-public-footer__brand" href="<?php echo esc_url( $home_link ); ?>"><?php echo esc_html( $site_name ); ?></a>
							<?php if ( $description ) : ?>
								<p><?php echo esc_html( $description ); ?></p>
							<?php endif; ?>
						</div>
						<nav aria-label="<?php esc_attr_e( 'Footer links', 'app-hosting' ); ?>">
							<?php
							if ( has_nav_menu( 'footer-menu' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'footer-menu',
										'menu_class'     => $menu_class,
										'container'      => false,
										'fallback_cb'    => '__return_false',
										'depth'          => 1,
									)
								);
							} else {
								?>
								<ul class="<?php echo esc_attr( $menu_class ); ?>">
									<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'app-hosting' ); ?></a></li>
									<li><a href="<?php echo esc_url( home_url( '/support' ) ); ?>"><?php esc_html_e( 'Support', 'app-hosting' ); ?></a></li>
									<?php if ( get_privacy_policy_url() ) : ?>
										<li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy', 'app-hosting' ); ?></a></li>
									<?php endif; ?>
									<li><a href="<?php echo esc_url( $portal_link ); ?>"><?php esc_html_e( 'Customer portal', 'app-hosting' ); ?></a></li>
								</ul>
								<?php
							}
							?>
						</nav>
					</div>
					<div class="dws-public-footer__bottom">
						&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( $site_name ); ?>. <?php esc_html_e( 'All rights reserved.', 'app-hosting' ); ?>
					</div>
				</div>
			</footer>
		<?php endif; ?>
         
        <?php include_once dirname(__FILE__).'/modal.php'; ?>

        <script>var hostUrl = "<?php echo get_template_directory_uri();?>/assets/";</script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/global/plugins.bundle.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Vendors Javascript(used for this page only)-->
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
        <!--end::Vendors Javascript-->
        <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/custom/landing.js"></script>
       
    <?php
     if (function_exists('getCurrentPageFileName')) {
         $filename = getCurrentPageFileName();
         if (isset($filename) && $filename =='login.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/login.js"></script>
          <?php
         } elseif (isset($filename) && $filename=='signup.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/signup.js"></script>
       <?php
         } elseif (isset($filename) && $filename=='getstarted.php') { ?>
          <script src="<?php echo get_template_directory_uri();?>/assets/js/order.js"></script>
       <?php
         }
     }


        wp_footer();
        ?>
</body>
</html>
