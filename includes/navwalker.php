<?php
/**
 * Adapted from Edward McIntyre's wp_bootstrap_navwalker class.
 * Removed support for glyphicon and added support for Font Awesome.
 *
 * @package understrap-child
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (! class_exists ( 'understrap_child_navwalker' )) :
	require_once get_template_directory() . '/inc/bootstrap-wp-navwalker.php';
/**
 * Class WP_Bootstrap_Navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 4
 * navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class understrap_child_navwalker extends understrap_WP_Bootstrap_Navwalker {

	/**
	 * Open element.
	 *
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int    $depth Depth of menu item. Used for padding.
	 * @param mixed  $args Rest arguments.
	 * @param int    $id Element's ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li class="dropdown-divider" role="presentation">';
		} else if ( strcasecmp( $item->title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li class="dropdown-divider" role="presentation">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li class="dropdown-header" role="presentation">' . esc_html( $item->title );
		} else if ( strcasecmp( $item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li class="disabled" role="presentation"><a href="#">' . esc_html( $item->title ) . '</a>';
		} else {
			$class_names = $value = '';
			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[]   = 'nav-item menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			/*
			if ( $args->has_children )
			  $class_names .= ' dropdown';
			*/
			if ( $args->has_children && $depth === 0 ) {
				$class_names .= ' dropdown';
			} elseif ( $args->has_children && $depth > 0 ) {
				$class_names .= ' dropdown-submenu';
			}
			if ( in_array( 'current-menu-item', $classes ) ) {
				$class_names .= ' active';
			}
			// remove Font Awesome icon from classes array and save the icon
			// we will add the icon back in via a <span> below so it aligns with
			// the menu item
			if ( in_array( 'fa', $classes ) ) {
				$key         = array_search( 'fa', $classes );
				$icon        = $classes[ $key + 1 ];
				$class_names = str_replace( $classes[ $key + 1 ], '', $class_names );
				$class_names = str_replace( $classes[ $key ], '', $class_names );
			}

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
			$id          = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names . '>';
			$atts           = array();
			if ( empty( $item->attr_title ) ) { $atts['title'] = ! empty( $item->title ) ? strip_tags( $item->title ) : ''; } else { $atts['title'] = $item->attr_title; }
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			// If item has_children add atts to a.

			if ( $args->has_children && $depth === 0 ) {
				$atts['href']        = ! empty( $item->url ) ? $item->url : '#';
				$atts['data-toggle'] = 'dropdown';
				$atts['class']       = 'nav-link dropdown-toggle';
			} else {
				$atts['href']  = ! empty( $item->url ) ? $item->url : '';
				$atts['class'] = 'nav-link';
			}
			$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			// Font Awesome icons
			if ( ! empty( $icon ) ) {
				$item_output .= '<a' . $attributes . '><span class="fa ' . esc_attr( $icon ) . '"></span>&nbsp;';
			} else {
				$item_output .= '<a' . $attributes . '>';
			}
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title,
					$item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}

endif; /* End if class exists */
