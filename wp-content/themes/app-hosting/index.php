<?php
/**
 * Main blog index template.
 */

get_header();
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-blog-index' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>
<main class="dws-public-main">
	<?php
	$page_id       = get_option( 'page_for_posts' );
	$intro_content = $page_id ? apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) ) : '';
	?>
	<section class="dws-blog-hero">
		<div class="container">
			<p class="dws-eyebrow"><?php esc_html_e( 'Domains & Web Service field notes', 'app-hosting' ); ?></p>
			<h1><?php esc_html_e( 'Clear thinking for domains, hosting, and product launches.', 'app-hosting' ); ?></h1>
			<?php if ( $intro_content ) : ?>
				<div class="dws-hero-intro">
					<?php echo wp_kses_post( $intro_content ); ?>
				</div>
			<?php else : ?>
				<p class="lead"><?php esc_html_e( 'Practical guidance on domains, hosting, DNS, uptime, WordPress, Laravel, ecommerce, and the infrastructure decisions behind modern websites.', 'app-hosting' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
	$blog_categories = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'name',
		)
	);
	if ( $blog_categories ) :
		?>
		<section class="dws-chip-section">
			<div class="container dws-chip-row">
				<?php foreach ( $blog_categories as $category ) : ?>
					<a class="dws-chip" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
	<section class="dws-blog-feed container">
		<?php if ( have_posts() ) : ?>
			<?php
			$rendered_featured = false;
			$grid_open         = false;
			while ( have_posts() ) :
				the_post();
				if ( ! $rendered_featured && ! is_paged() ) :
					?>
					<div class="dws-blog-featured">
						<?php get_template_part( 'template-parts/blog/post-card', null, array( 'variant' => 'featured' ) ); ?>
					</div>
					<div class="dws-post-grid">
					<?php
					$rendered_featured = true;
					$grid_open         = true;
					continue;
				endif;

				if ( ! $grid_open ) {
					echo '<div class="dws-post-grid">';
					$grid_open = true;
				}

				get_template_part( 'template-parts/blog/post-card' );
			endwhile;
			if ( $grid_open ) {
				echo '</div>';
			}
			?>
			<?php
			$pagination = get_the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => esc_html__( 'Newer', 'app-hosting' ),
					'next_text' => esc_html__( 'Older', 'app-hosting' ),
				)
			);
			if ( $pagination ) :
				?>
				<div class="dws-pagination">
					<?php echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</section>
	<?php get_template_part( 'template-parts/site/public-cta' ); ?>
</main>
<?php $GLOBALS['dws_public_footer'] = true; ?>
<?php get_footer(); ?>
