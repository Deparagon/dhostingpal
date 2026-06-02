<?php
/**
 * Generic blog card component.
 *
 * @param array $args {
 *     Optional. Arguments to control appearance.
 *     @type string $variant Variant name: featured|standard|compact.
 * }
 */

$variant       = isset( $args['variant'] ) ? $args['variant'] : 'standard';
$variant       = in_array( $variant, array( 'featured', 'compact', 'standard' ), true ) ? $variant : 'standard';
$card_classes  = array( 'dws-post-card', 'dws-post-card--' . $variant );
$reading_time  = dws_estimated_read_time();
$excerpt_limit = ( 'featured' === $variant ) ? 54 : ( 'compact' === $variant ? 24 : 36 );
$excerpt       = dws_safe_excerpt( null, $excerpt_limit );
$has_thumb     = has_post_thumbnail();
?>
<article <?php post_class( implode( ' ', $card_classes ) ); ?>>
    <?php if ( $has_thumb ) : ?>
        <a class="dws-post-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
            <?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'class' => 'img-fluid' ) ); ?>
        </a>
    <?php endif; ?>
    <div class="dws-post-card__body">
        <div class="dws-post-card__eyebrow">
            <div class="dws-pill-row">
                <?php echo dws_render_category_badges(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <span class="dws-post-card__meta"><?php echo esc_html( get_the_date() ); ?> &middot; <?php echo esc_html( $reading_time ); ?> <?php esc_html_e( 'min read', 'app-hosting' ); ?></span>
        </div>
        <h3 class="dws-post-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if ( $excerpt ) : ?>
            <p class="dws-post-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
        <?php endif; ?>
        <div class="dws-post-card__footer">
            <div class="dws-post-card__author">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', get_the_author(), array( 'class' => 'rounded-circle' ) ); ?>
                <div>
                    <span><?php the_author(); ?></span>
                    <small><?php echo esc_html( get_the_author_meta( 'title' ) ? get_the_author_meta( 'title' ) : __( 'Domains & Web Service Team', 'app-hosting' ) ); ?></small>
                </div>
            </div>
            <a class="dws-link-arrow" href="<?php the_permalink(); ?>">
                <?php esc_html_e( 'Read article', 'app-hosting' ); ?>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</article>
