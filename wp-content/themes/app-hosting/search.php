<?php
/**
 * Search results template.
 */

get_header();
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-blog-archive', 'dws-search-results' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>
<main class="dws-public-main">
	<section class="dws-blog-hero dws-blog-hero--compact">
		<div class="container">
			<p class="dws-eyebrow"><?php esc_html_e( 'Search', 'app-hosting' ); ?></p>
			<h1><?php printf( esc_html__( 'Search results for: %s', 'app-hosting' ), esc_html( get_search_query() ) ); ?></h1>
		</div>
	</section>

	<section class="dws-blog-feed container">
		<?php if ( have_posts() ) : ?>
			<div class="dws-post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/blog/post-card' );
				endwhile;
				?>
			</div>
			<div class="dws-pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => esc_html__( 'Newer', 'app-hosting' ),
						'next_text' => esc_html__( 'Older', 'app-hosting' ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</section>
	<?php get_template_part( 'template-parts/site/public-cta' ); ?>
</main>
<?php $GLOBALS['dws_public_footer'] = true; ?>
<?php get_footer(); ?>
