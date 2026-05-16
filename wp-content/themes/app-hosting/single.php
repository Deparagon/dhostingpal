<?php
/**
 * Single blog post template.
 */

get_header();
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-single-post' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>

<main class="dws-public-main">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			$reading_time = dws_estimated_read_time();
			?>
			<article <?php post_class( 'dws-article' ); ?>>
				<header class="dws-article-hero">
					<div class="container">
						<div class="dws-pill-row">
							<?php echo dws_render_category_badges(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h1><?php the_title(); ?></h1>
						<div class="dws-article-meta">
							<span><?php esc_html_e( 'By', 'app-hosting' ); ?> <?php the_author_posts_link(); ?></span>
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<span><?php echo esc_html( $reading_time ); ?> <?php esc_html_e( 'min read', 'app-hosting' ); ?></span>
						</div>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="container dws-article-featured-image">
						<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid', 'loading' => 'eager' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="container dws-article-layout">
					<aside class="dws-article-aside" aria-label="<?php esc_attr_e( 'Article details', 'app-hosting' ); ?>">
						<div class="dws-author-card">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', get_the_author(), array( 'class' => 'rounded-circle' ) ); ?>
							<strong><?php the_author(); ?></strong>
							<span><?php echo esc_html( get_the_author_meta( 'description' ) ? get_the_author_meta( 'description' ) : __( 'Domains & Web Service Team', 'app-hosting' ) ); ?></span>
						</div>
						<?php
						$post_tags = get_the_tags();
						if ( $post_tags ) :
							?>
							<div class="dws-tag-list">
								<strong><?php esc_html_e( 'Tagged', 'app-hosting' ); ?></strong>
								<div class="dws-tag-badges">
									<?php foreach ( $post_tags as $post_tag ) : ?>
										<a class="dws-tag-badge" href="<?php echo esc_url( get_tag_link( $post_tag ) ); ?>"><?php echo esc_html( $post_tag->name ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</aside>

					<div class="dws-article-content">
						<?php
						the_content();
						wp_link_pages(
							array(
								'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'app-hosting' ) . '">',
								'after'    => '</nav>',
								'pagelink' => esc_html__( 'Page %', 'app-hosting' ),
							)
						);
						?>
					</div>
				</div>

				<footer class="container dws-post-navigation">
					<?php
					the_post_navigation(
						array(
							'prev_text' => '<span>' . esc_html__( 'Previous', 'app-hosting' ) . '</span><strong>%title</strong>',
							'next_text' => '<span>' . esc_html__( 'Next', 'app-hosting' ) . '</span><strong>%title</strong>',
						)
					);
					?>
				</footer>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<section class="container dws-comments">
						<?php comments_template(); ?>
					</section>
				<?php endif; ?>
			</article>
			<?php
		endwhile;
		?>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/site/public-cta' ); ?>
</main>

<?php $GLOBALS['dws_public_footer'] = true; ?>
<?php get_footer(); ?>
