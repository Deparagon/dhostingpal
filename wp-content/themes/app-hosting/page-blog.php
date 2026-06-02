<?php
/**
 * Template Name: Blog Index
 * Description: Front-facing blog landing page.
 */

get_header();

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'paged'               => $paged,
		'ignore_sticky_posts' => false,
	)
);
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-blog-index' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>
<main class="dws-public-main">
	<section class="dws-blog-hero">
		<div class="container">
			<p class="dws-eyebrow"><?php esc_html_e( 'Domains & Web Service field notes', 'app-hosting' ); ?></p>
			<h1><?php esc_html_e( 'Clear thinking for domains, hosting, and product launches.', 'app-hosting' ); ?></h1>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<div class="dws-hero-intro">
					<?php the_content(); ?>
				</div>
				<?php
			endwhile;
			?>
		</div>
	</section>

	<section class="dws-blog-feed container">
		<?php if ( $blog_query->have_posts() ) : ?>
			<div class="dws-post-grid">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					get_template_part( 'template-parts/blog/post-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<?php
			$pagination = paginate_links(
				array(
					'total'     => $blog_query->max_num_pages,
					'current'   => $paged,
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
