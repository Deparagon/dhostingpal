<?php
/**
 * Default public page template.
 */

get_header();
?>
<body <?php body_class( array( 'dws-public-shell', 'dws-standard-page' ) ); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/public-header' ); ?>

<main class="dws-public-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'dws-page' ); ?>>
				<header class="dws-page-hero">
					<div class="container">
						<p class="dws-eyebrow"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
						<h1><?php the_title(); ?></h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</div>
				</header>
				<div class="container dws-page-content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'app-hosting' ) . '">',
							'after'    => '</nav>',
							'pagelink' => esc_html__( 'Page %', 'app-hosting' ),
						)
					);
					edit_post_link(
						esc_attr__( 'Edit', 'app-hosting' ),
						'<span class="edit-link">',
						'</span>'
					);
					?>
				</div>
			</article>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<section class="container dws-comments">
					<?php comments_template(); ?>
				</section>
			<?php endif; ?>
			<?php
		endwhile;
	endif;
	?>
	<?php get_template_part( 'template-parts/site/public-cta' ); ?>
</main>

<?php get_footer(); ?>
