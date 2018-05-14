<?php
/**
 * Bootstrap Theme
 *
 * @package understrap-child
 */

/**
 * Enqueue scripts and styles
 */
require get_stylesheet_directory() . '/includes/enqueue.php';

/**
 * Theme Setup
 */
require get_stylesheet_directory() . '/includes/setup.php';

/**
 * Load custom WordPress nav walker.
 */
require get_stylesheet_directory() . '/includes/navwalker.php';

/**
 * Init Widgets, Sidebars and Components.
 */
require get_stylesheet_directory() . '/includes/init.php';

/**
 * Template Tags
 */
require get_stylesheet_directory() . '/includes/template-tags.php';
