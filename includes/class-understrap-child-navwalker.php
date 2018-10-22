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

if ( ! class_exists( 'understrap_child_navwalker' ) ) :
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
	/**
	 * Class WP_Bootstrap_Navwalker
	 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
	 * Description: A custom WordPress nav walker class to implement the Bootstrap 4
	 * navigation style in a custom theme using the WordPress built in menu manager.
	 * Version: 4.1.0
	 * Author: Edward McIntyre - @twittem
	 * License: GPL-2.0+
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	 */
	class Understrap_Child_Navwalker extends Understrap_WP_Bootstrap_Navwalker {

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
		 * @param int    $element Element's ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = [], $element = 0 ) {
			$indent  = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$output .= $this->special_element( $item, $depth );

			if ( $this->is_special( $item, $depth ) === false ) {
				// Get class names.
				$classes    = empty( $item->classes ) ? [] : (array) $item->classes;
				$classes[]  = 'nav-item menu-item-' . $item->ID;
				$classnames = $this->classnames( $item, $classes, $args, $depth );
				$icon       = '';

				// remove Font Awesome icon from classes array and save the icon
				// we will add the icon back in via a <span> below so it aligns with
				// the menu item.
				if ( in_array( 'fa', $classes, true ) ) {
					$key        = array_search( 'fa', $classes, true );
					$icon       = $classes[ $key + 1 ];
					$classnames = str_replace( $classes[ $key + 1 ], '', $classnames );
					$classnames = str_replace( $classes[ $key ], '', $classnames );
				}

				// Setup list element and add it to output.
				$classnames = $classnames ? ' class="' . esc_attr( $classnames ) . '"' : '';
				$element    = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
				$element    = $element ? ' id="' . esc_attr( $element ) . '"' : '';
				$output    .= $indent . '<li' . $element . ' ' . $classnames . '>';
				$attributes = $this->attributes( $item, $args, $depth );

				// Build Output.
				$content  = $args->before;
				$content .= $this->icons( $icon, $attributes );
				$content .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$content .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
				$content .= $args->after;
				$output  .= apply_filters( 'walker_nav_menu_start_el', $content, $item, $depth, $args );
			}
		}

		/**
		 * Checks if element is element is spcial, e.g. divider, header, or disabled.
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 *
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of the menu item.
		 * @return bool
		 */
		protected function is_special( $item, $depth ) {
			return ( strcasecmp( $item->attr_title, 'divider' ) === 0 && 1 === $depth ) || ( strcasecmp( $item->title, 'divider' ) === 0 && 1 === $depth ) ||
				( strcasecmp( $item->attr_title, 'dropdown-header' ) === 0 && 1 === $depth ) || strcasecmp( $item->attr_title, 'disabled' ) === 0;
		}

		/**
		 * Add special element like divider, header, or disabled.
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 *
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of the menu item.
		 * @return string
		 */
		protected function special_element( $item, $depth ) {
			$output = '';

			if ( strcasecmp( $item->attr_title, 'divider' ) === 0 && 1 === $depth ) {
				$output .= $indent . '<li class="dropdown-divider" role="presentation">';
			} elseif ( strcasecmp( $item->title, 'divider' ) === 0 && 1 === $depth ) {
				$output .= $indent . '<li class="dropdown-divider" role="presentation">';
			} elseif ( strcasecmp( $item->attr_title, 'dropdown-header' ) === 0 && 1 === $depth ) {
				$output .= $indent . '<li class="dropdown-header" role="presentation">' . esc_html( $item->title );
			} elseif ( strcasecmp( $item->attr_title, 'disabled' ) === 0 ) {
				$output .= $indent . '<li class="disabled" role="presentation"><a href="#">' . esc_html( $item->title ) . '</a>';
			}

			return $output;
		}

		/**
		 * Add Font-Awesome Icon if needed
		 *
		 * @param string|null $icon        FA icon class.
		 * @param string      $attributes  anchor attributes.
		 * @return string
		 */
		protected function icons( $icon, $attributes ) {
			if ( ! empty( $icon ) ) {
				return '<a' . $attributes . '><span class="fa ' . esc_attr( $icon ) . '"></span>&nbsp;';
			}
			return '<a' . $attributes . '>';
		}

		/**
		 * Get classnames for element
		 *
		 * @param object $item     Menu item data object.
		 * @param object $classes  Menu item classes.
		 * @param mixed  $args     Rest args.
		 * @param int    $depth    Depth of the menu item.
		 * @return string
		 */
		protected function classnames( $item, $classes, $args, $depth ) {
			// Default names.
			$names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			// Dropdown names.
			if ( $args->has_children && 0 === $depth ) {
				$names .= ' dropdown';
			} elseif ( $args->has_children && $depth > 0 ) {
				$names .= ' dropdown-submenu';
			}

			// Active name.
			if ( in_array( 'current-menu-item', $classes, true ) ) {
				$names .= ' active';
			}

			return $names;
		}

		/**
		 * Setup attributes.
		 *
		 * @param object $item     Menu item data object.
		 * @param mixed  $args     Rest args.
		 * @param int    $depth    Depth of the menu item.
		 * @return string
		 */
		protected function attributes( $item, $args, $depth ) {
			$atts  = [];
			$value = '';

			// Attribute title.
			$atts['title'] = $item->attr_title;
			if ( empty( $item->attr_title ) ) {
				$atts['title'] = ! empty( $item->title ) ? strip_tags( $item->title ) : '';
			}

			$atts['target'] = $this->get_property( $item, 'target', '' );
			$atts['rel']    = $this->get_property( $item, 'xfn', '' );

			// If item has_children add atts to a.
			$atts['href']  = $this->get_property( $item, 'url', '' );
			$atts['class'] = 'nav-link';
			if ( $args->has_children && 0 === $depth ) {
				$atts['href']        = $this->get_property( $item, 'url', '#' );
				$atts['data-toggle'] = 'dropdown';
				$atts['class']       = 'nav-link dropdown-toggle';
			}

			// run filter.
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			// Build attribute string.
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			return $attributes;
		}

		/**
		 * Return property of object or a default value.
		 *
		 * @param object $object Object.
		 * @param string $property Property to test.
		 * @param mixed  $default Default value.
		 * @return mixed
		 */
		protected function get_property( $object, $property, $default = null ) {
			return ! empty( $object->{$property} ) ? $object->{$property} : $default;
		}
	}

endif; /* End if class exists */
