<?php
/**
 * Functions and filters related to the menus.
 *
 * Makes the default WordPress navigation use an HTML structure similar
 * to the Navigation block.
 *
 * @link https://make.wordpress.org/themes/2020/07/06/printing-navigation-block-html-from-a-legacy-menu-in-themes/
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since ThemeName 1.0
 */

/**
 * Add a button to top-level menu items that has sub-menus.
 * An icon is added using CSS depending on the value of aria-expanded.
 *
 * @since ThemeName 1.0
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 */
function themename_add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="themenameExpandSubMenu(this)">';
		$output .= '<span class="icon-plus">' . themename_get_icon_svg( 'ui', 'plus', 18 ) . '</span>';
		$output .= '<span class="icon-minus">' . themename_get_icon_svg( 'ui', 'minus', 18 ) . '</span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', 'themename' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'themename_add_sub_menu_toggle', 10, 4 );

/**
 * Detects the social network from a URL and returns the SVG code for its icon.
 *
 * @since ThemeName 1.0
 *
 * @param string $uri  Social link.
 * @param int    $size The icon size in pixels.
 * @return string
 */
function themename_get_social_link_svg( $uri, $size = 24 ) {
	return Theme_Name_SVG_Icons::get_social_link_svg( $uri, $size );
}


/**
 * Filters the arguments for a single nav menu item.
 *
 * @since ThemeName 1.0
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return stdClass
 */
function themename_add_menu_description_args( $args, $item, $depth ) {
	if ( '</span>' !== $args->link_after ) {
		$args->link_after = '';
	}

	if ( 0 === $depth && isset( $item->description ) && $item->description ) {
		// The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
		$args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
	}

	return $args;
}
add_filter( 'nav_menu_item_args', 'themename_add_menu_description_args', 10, 3 );
