<?php
/**
 * Setup theme
 * @package understrap-child
 */

 /**
 * Load Translation files from your child theme instead of the parent theme
 */
add_action('after_setup_theme', function() {
	load_child_theme_textdomain('ucweb', get_stylesheet_directory() . '/languages');
});

/**
 * Replace the excerpt "Read More" text by a link
 */
add_filter('wp_trim_excerpt', function($post_excerpt) {
    return $post_excerpt . ' <a class="read-more-link" href="' . get_permalink(get_the_ID()) . '">&raquo; ' . __('Read More', 'ucweb') . '</a>';
});

/**
 * Remove parent templates
 */
add_filter('theme_page_templates', function ($templates) {
    unset($templates['page-templates/blank.php']);
    unset($templates['page-templates/both-sidebarspage.php']);
    unset($templates['page-templates/empty.php']);
    unset($templates['page-templates/fullwidthpage.php']);
    unset($templates['page-templates/left-sidebarpage.php']);
    unset($templates['page-templates/vertical-one-page.php']);
    return $templates;
});
