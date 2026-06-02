<footer class="bg-gray-900 text-gray-400 py-12 mt-20">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1 md:col-span-2">
            <h3 class="text-white text-xl font-bold mb-4 text-blue-500">Company Name</h3>
            <p class="max-w-xs mb-6">Building the future of digital experiences through innovation and shared knowledge.</p>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4">Categories</h4>
            <ul class="space-y-2 text-sm">
                <?php wp_list_categories(['title_li' => '', 'number' => 5]); ?>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-4">Connect</h4>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white transition">Twitter</a>
                <a href="#" class="hover:text-white transition">LinkedIn</a>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-6 mt-12 pt-8 border-t border-gray-800 text-center text-xs">
        &copy; <?php echo date('Y'); ?> Company Name. All rights reserved.
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
