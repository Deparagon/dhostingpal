<?php
/**
 * Template Name: Domain Hosting Pal Home
 * Description: Home Page template full width.
 *
 */

get_header();

?>

<div class="row">
	<div class="col-md-12 col-xs-12 col-12">
		<div class="jombotron">
			
			 <h1>Hosting Apps, Laravel, Wordpress, Ecommerce in the most simple way</h1>
		</div>
	</div>

</div>

 <div class="row">
 	<div class="col-md-12 col-xs-12">
 		 <div class="stat_image"></div>
 	</div>
 </div>

 <div class="row">
 	<div class="col-sm-3 col-6">
 		<div class="feature-front-box">feature one</div>
 	</div>

 	<div class="col-sm-3 col-6">
 		<div class="feature-front-box">feature one</div>
 	</div>


 	<div class="col-sm-3 col-6">
 		<div class="feature-front-box">feature one</div>
 	</div>

 	<div class="col-sm-3 col-6">
 		<div class="feature-front-box">feature one</div>
 	</div>
 </div>

<?php
the_post();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php
        the_content();

wp_link_pages(
    array(
        'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'app-hosting') . '">',
        'after'    => '</nav>',
        'pagelink' => esc_html__('Page %', 'app-hosting'),
    )
);
edit_post_link(
    esc_attr__('Edit', 'app-hosting'),
    '<span class="edit-link">',
    '</span>'
);
?>
</div><!-- /#post-<?php the_ID(); ?> -->
<?php
// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()) {
    comments_template();
}

get_footer();
