<?php
/**
 * Customizer callback functions for latest-blog slider.
 *
 * @package ThemeName
 */

/*select page for latest blog slider*/
if ( ! function_exists( 'themename_show_slider_on_blog' ) ) :

	/**
	 * Check if slider section page/post is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function themename_show_slider_on_blog( $control ) {

		if ( 1 == $control->manager->get_setting( 'show_slider_on_blog' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

/*select post layout for latest blog section*/
if ( ! function_exists( 'themename_enable_blog_layout_switch' ) ) :

	/**
	 * Check if slider section page/post is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function themename_enable_blog_layout_switch( $control ) {

		if ( 1 == $control->manager->get_setting( 'enable_blog_layout_switch' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

