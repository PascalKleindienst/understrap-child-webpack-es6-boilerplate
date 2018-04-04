<?php
/**
 * Add/Remove Scripts and Styles
 *
 * @package understrap-child
 */

// Removes the parent themes stylesheet and scripts from inc/enqueue.php.
add_action('wp_enqueue_scripts', function () {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}, 20);

// Enqueue the theme data.
add_action('wp_enqueue_scripts', function () {
	$theme = wp_get_theme();

	wp_enqueue_style( 'understrap-child-styles', get_stylesheet_directory_uri() . '/assets/styles.css', [], $theme->get( 'Version' ) );
	wp_enqueue_script( 'understrap-child-scripts', get_stylesheet_directory_uri() . '/assets/bundle.js', [], $theme->get( 'Version' ), true );
});
