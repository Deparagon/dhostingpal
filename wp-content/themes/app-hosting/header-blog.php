<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <?php wp_head(); ?>

    <?php if ( is_single() ) : 
        // Generate JSON-LD for Blog Posting
        $post_id = get_the_ID();
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "BlogPosting",
            "headline" => get_the_title(),
            "image" => [ get_the_post_thumbnail_url($post_id, 'full') ],
            "datePublished" => get_the_date('c'),
            "dateModified" => get_post_modified_time('c'),
            "author" => [[
                "@type" => "Person",
                "name" => get_the_author(),
                "url" => get_author_posts_url(get_the_author_meta('ID'))
            ]]
        ];
    ?>
    <script type="application/ld+json">
        <?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    </script>
    <?php endif; ?>
</head>
<body <?php body_class('bg-gray-50 text-gray-900'); ?>>

<header class="bg-white border-b sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-600">Company<span class="text-gray-800">Blog</span></a>
        <div class="hidden md:flex space-x-8 font-medium">
            <a href="/" class="hover:text-blue-600 transition">Home</a>
            <a href="/blog" class="text-blue-600">Resources</a>
            <a href="/contact" class="hover:text-blue-600 transition">Contact</a>
        </div>
        <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Subscribe</button>
    </nav>
</header>