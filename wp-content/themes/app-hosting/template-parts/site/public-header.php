<?php
/**
 * Public-facing header for marketing and blog surfaces.
 */

$logo_url      = get_template_directory_uri() . '/assets/media/logos/dws.png';
$home_link     = home_url( '/' );
$contact_link  = home_url( '/contact-us' );
$plans_link    = home_url( '/get-started' );
$portal_link   = wp_login_url();
$menu_classes  = 'dws-public-nav__menu list-unstyled mb-0';
$menu_exists   = has_nav_menu( 'main-menu' );
?>
<header class="dws-public-nav" role="banner">
    <div class="container d-flex align-items-center justify-content-between dws-public-nav__container">
        <a class="dws-public-nav__brand" href="<?php echo esc_url( $home_link ); ?>">
            <span class="dws-public-nav__logo-wrap">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="Domains &amp; Web Service" loading="lazy" />
            </span>
            <span class="dws-public-nav__text">Domains &amp; Web Service</span>
        </a>
        <button class="dws-public-nav__toggle" type="button" data-dws-nav-toggle aria-controls="dwsPublicMenu" aria-expanded="false">
            <span class="visually-hidden"><?php esc_html_e( 'Toggle navigation', 'app-hosting' ); ?></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="dws-public-nav__links" id="dwsPublicMenu">
            <?php
            if ( $menu_exists ) {
                wp_nav_menu(
                    array(
                        'theme_location' => 'main-menu',
                        'menu_class'     => $menu_classes,
                        'container'      => false,
                        'fallback_cb'    => '__return_false',
                    )
                );
            } else {
                echo '<ul class="' . esc_attr( $menu_classes ) . '">';
                echo '<li><a href="' . esc_url( home_url( '/solutions' ) ) . '">' . esc_html__( 'Solutions', 'app-hosting' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/pricing' ) ) . '">' . esc_html__( 'Pricing', 'app-hosting' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">' . esc_html__( 'Blog', 'app-hosting' ) . '</a></li>';
                echo '</ul>';
            }
            ?>
            <div class="dws-public-nav__actions">
                <a class="btn btn-primary" href="<?php echo esc_url( $plans_link ); ?>"><?php esc_html_e( 'View hosting plans', 'app-hosting' ); ?></a>
                <a class="btn btn-outline-light" href="<?php echo esc_url( $contact_link ); ?>"><?php esc_html_e( 'Talk to sales', 'app-hosting' ); ?></a>
                <a class="btn btn-light text-dark" href="<?php echo esc_url( $portal_link ); ?>"><?php esc_html_e( 'Customer portal', 'app-hosting' ); ?></a>
            </div>
        </div>
    </div>
</header>
<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.querySelector('[data-dws-nav-toggle]');
        var menu = document.getElementById('dwsPublicMenu');
        if (!toggle || !menu) {
            return;
        }
        toggle.addEventListener('click', function() {
            var expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            menu.classList.toggle('is-open');
            document.body.classList.toggle('dws-nav-open');
        });
    });
})();
</script>
