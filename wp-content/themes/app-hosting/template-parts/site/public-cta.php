<?php
/**
 * Public call-to-action band reused across marketing templates.
 */

$contact_link = home_url( '/contact-us' );
$plans_link   = home_url( '/get-started' );
?>
<section class="dws-cta" aria-label="Launch with Domains &amp; Web Service">
    <div class="container dws-cta__container">
        <div class="dws-cta__copy">
            <p class="dws-eyebrow"><?php esc_html_e( 'Launch with confidence', 'app-hosting' ); ?></p>
            <h2><?php esc_html_e( 'Ready to put your next idea online?', 'app-hosting' ); ?></h2>
            <p><?php esc_html_e( 'Secure your domain, pick a managed cloud plan, and let our team keep your stack stable while you build.', 'app-hosting' ); ?></p>
        </div>
        <div class="dws-cta__actions">
            <a class="btn btn-primary btn-lg" href="<?php echo esc_url( $plans_link ); ?>"><?php esc_html_e( 'Explore hosting plans', 'app-hosting' ); ?></a>
            <a class="btn btn-outline-light btn-lg" href="<?php echo esc_url( $contact_link ); ?>"><?php esc_html_e( 'Chat with sales', 'app-hosting' ); ?></a>
        </div>
    </div>
</section>
