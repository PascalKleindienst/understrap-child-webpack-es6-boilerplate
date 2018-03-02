<?php

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('understrap-styles');
    wp_deregister_style('understrap-styles');

    wp_dequeue_script('understrap-scripts');
    wp_deregister_script('understrap-scripts');    
}, 20);

/**
 * Enqueue the theme data
 */
add_action('wp_enqueue_scripts', function () {
    $theme = wp_get_theme();
    
    wp_enqueue_style('stadtwerke-styles', get_stylesheet_directory_uri() . '/assets/style.css', [], $theme->get('Version'));
    wp_enqueue_script('stadtwerke-scripts', get_stylesheet_directory_uri() . '/assets/bundle.js', [], $theme->get('Version'), true);
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

/**
 * Replace the excerpt "Read More" text by a link
 */
add_filter('wp_trim_excerpt', function($post_excerpt) {
    return $post_excerpt . ' <a class="read-more-link" href="' . get_permalink(get_the_ID()) . '">&raquo; ' . __('Read More', 'ucweb') . '</a>';
});

/**
 * Load Translation files from your child theme instead of the parent theme
 */
add_action('after_setup_theme', function() {
	load_child_theme_textdomain('ucweb', get_stylesheet_directory() . '/languages');
});