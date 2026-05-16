<?php
/**
 * Template Name: Domain Hosting Pal Home
 * Description: Public home page for domains, hosting, and managed web services.
 */

get_header();

$asset_uri     = get_template_directory_uri();
$hero_image    = $asset_uri . '/assets/media/auth/bg1.jpg';
$plans_link    = home_url( '/get-started' );
$domain_link   = home_url( '/register-domain' );
$signup_link   = home_url( '/sign-up' );
$login_link    = wp_login_url();
$blog_link     = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog' );
$support_link  = home_url( '/support' );
$contact_link  = home_url( '/contact-us' );
$recent_posts  = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-home' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>

<main class="dws-public-main">
	<section class="dws-home-hero" style="background-image: linear-gradient(90deg, rgba(6, 20, 44, 0.92), rgba(6, 20, 44, 0.72)), url('<?php echo esc_url( $hero_image ); ?>');">
		<div class="container dws-home-hero__inner">
			<div class="dws-home-hero__copy">
				<p class="dws-eyebrow"><?php esc_html_e( 'Domains, hosting, and managed web services', 'app-hosting' ); ?></p>
				<h1><?php esc_html_e( 'Launch dependable websites without wrestling the infrastructure.', 'app-hosting' ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Find a domain, choose managed hosting, and let our team help you bring WordPress, Laravel, commerce, and custom applications online with fewer moving parts.', 'app-hosting' ); ?></p>
				<form class="dws-domain-search" action="<?php echo esc_url( $plans_link ); ?>" method="get">
					<label class="screen-reader-text" for="dws-domain-search"><?php esc_html_e( 'Search for a domain name', 'app-hosting' ); ?></label>
					<input id="dws-domain-search" type="search" name="domain" placeholder="<?php esc_attr_e( 'Search yourdomain.com', 'app-hosting' ); ?>" />
					<button class="btn btn-primary btn-lg" type="submit"><?php esc_html_e( 'Check availability', 'app-hosting' ); ?></button>
				</form>
				<div class="dws-home-hero__actions">
					<a class="btn btn-light btn-lg text-dark" href="<?php echo esc_url( $plans_link ); ?>"><?php esc_html_e( 'View hosting plans', 'app-hosting' ); ?></a>
					<a class="btn btn-outline-light btn-lg" href="<?php echo esc_url( $domain_link ); ?>"><?php esc_html_e( 'Register domain only', 'app-hosting' ); ?></a>
				</div>
			</div>
			<div class="dws-hero-panel" aria-label="<?php esc_attr_e( 'Service overview', 'app-hosting' ); ?>">
				<div class="dws-hero-panel__status">
					<span></span>
					<?php esc_html_e( 'Managed launch flow', 'app-hosting' ); ?>
				</div>
				<div class="dws-hero-panel__metric">
					<strong><?php esc_html_e( 'Domain', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'Search, register, and prepare DNS', 'app-hosting' ); ?></span>
				</div>
				<div class="dws-hero-panel__metric">
					<strong><?php esc_html_e( 'Hosting', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'WordPress, Laravel, ecommerce, and app stacks', 'app-hosting' ); ?></span>
				</div>
				<div class="dws-hero-panel__metric">
					<strong><?php esc_html_e( 'Support', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'Human setup help while automation grows', 'app-hosting' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<section class="dws-service-band">
		<div class="container">
			<div class="dws-section-heading">
				<p class="dws-eyebrow"><?php esc_html_e( 'What we help with', 'app-hosting' ); ?></p>
				<h2><?php esc_html_e( 'A practical hosting partner for growing teams.', 'app-hosting' ); ?></h2>
			</div>
			<div class="dws-service-grid">
				<a class="dws-service-card" href="<?php echo esc_url( $domain_link ); ?>">
					<span class="dws-service-card__icon">.com</span>
					<h3><?php esc_html_e( 'Domain registration', 'app-hosting' ); ?></h3>
					<p><?php esc_html_e( 'Search, register, transfer, and manage domains with a support team that understands local business needs.', 'app-hosting' ); ?></p>
				</a>
				<a class="dws-service-card" href="<?php echo esc_url( $plans_link ); ?>">
					<span class="dws-service-card__icon">WP</span>
					<h3><?php esc_html_e( 'Managed hosting', 'app-hosting' ); ?></h3>
					<p><?php esc_html_e( 'Choose a hosting plan for WordPress, Laravel, ecommerce, landing pages, and client portals.', 'app-hosting' ); ?></p>
				</a>
				<a class="dws-service-card" href="<?php echo esc_url( $support_link ); ?>">
					<span class="dws-service-card__icon">24</span>
					<h3><?php esc_html_e( 'Setup support', 'app-hosting' ); ?></h3>
					<p><?php esc_html_e( 'We help with migrations, DNS, SSL, mail routing, and launch readiness while the platform matures.', 'app-hosting' ); ?></p>
				</a>
			</div>
		</div>
	</section>

	<section class="dws-flow-section">
		<div class="container dws-flow-grid">
			<div>
				<p class="dws-eyebrow"><?php esc_html_e( 'How orders work today', 'app-hosting' ); ?></p>
				<h2><?php esc_html_e( 'Simple online ordering, careful human provisioning.', 'app-hosting' ); ?></h2>
				<p><?php esc_html_e( 'The platform is being built toward deeper automation. For now, customers can begin the order journey online while our team confirms domains, hosting choices, and setup details before provisioning.', 'app-hosting' ); ?></p>
			</div>
			<ol class="dws-flow-list">
				<li>
					<strong><?php esc_html_e( 'Create an account', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'Keep domains, invoices, and support requests under one customer profile.', 'app-hosting' ); ?></span>
					<a href="<?php echo esc_url( $signup_link ); ?>"><?php esc_html_e( 'Create account', 'app-hosting' ); ?></a>
				</li>
				<li>
					<strong><?php esc_html_e( 'Choose domain and hosting', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'Start with a new domain, transfer an existing domain, or order hosting for a current project.', 'app-hosting' ); ?></span>
					<a href="<?php echo esc_url( $plans_link ); ?>"><?php esc_html_e( 'Start an order', 'app-hosting' ); ?></a>
				</li>
				<li>
					<strong><?php esc_html_e( 'Track and get support', 'app-hosting' ); ?></strong>
					<span><?php esc_html_e( 'Use the portal to follow your services and reach support when your setup needs attention.', 'app-hosting' ); ?></span>
					<a href="<?php echo esc_url( $login_link ); ?>"><?php esc_html_e( 'Log in', 'app-hosting' ); ?></a>
				</li>
			</ol>
		</div>
	</section>

	<?php if ( $recent_posts->have_posts() ) : ?>
		<section class="dws-home-blog">
			<div class="container">
				<div class="dws-section-heading dws-section-heading--split">
					<div>
						<p class="dws-eyebrow"><?php esc_html_e( 'Latest from the blog', 'app-hosting' ); ?></p>
						<h2><?php esc_html_e( 'Helpful notes for people building online.', 'app-hosting' ); ?></h2>
					</div>
					<a class="dws-link-arrow" href="<?php echo esc_url( $blog_link ); ?>"><?php esc_html_e( 'Visit blog', 'app-hosting' ); ?> <span aria-hidden="true">&rarr;</span></a>
				</div>
				<div class="dws-post-grid">
					<?php
					while ( $recent_posts->have_posts() ) :
						$recent_posts->the_post();
						get_template_part( 'template-parts/blog/post-card', null, array( 'variant' => 'compact' ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="dws-trust-band">
		<div class="container dws-trust-grid">
			<div>
				<strong><?php esc_html_e( 'Domains & Web Service', 'app-hosting' ); ?></strong>
				<span><?php esc_html_e( 'A focused technology company for domains, hosting, and web operations.', 'app-hosting' ); ?></span>
			</div>
			<a class="btn btn-primary btn-lg" href="<?php echo esc_url( $contact_link ); ?>"><?php esc_html_e( 'Talk to us', 'app-hosting' ); ?></a>
		</div>
	</section>
</main>

<?php $GLOBALS['dws_public_footer'] = true; ?>
<?php get_footer(); ?>
