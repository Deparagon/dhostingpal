<?php
/**
 * Template Name: Page (Default)
 * Description: Page template with Sidebar on the left side.
 *
 */

get_header();

require_once(dirname(__FILE__).'/after_header.php');

the_post();

the_content();

require_once(dirname(__FILE__).'/before_footer.php');

get_footer();
