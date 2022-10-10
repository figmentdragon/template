<?php

/**
 * ThemeName About Page
 * @package ThemeName
 *
*/

if( !class_exists('Theme_Name_About_page') ):

	class Theme_Name_About_page{

		function __construct(){

			add_action('admin_menu', array($this, 'themename_backend_menu'),999);

		}

		// Add Backend Menu
        function themename_backend_menu(){

            add_theme_page(esc_html__( 'ThemeName Options','themename' ), esc_html__( 'ThemeName Options','themename' ), 'activate_plugins', 'themename-about', array($this, 'themename_main_page'));

        }

        // Settings Form
        function themename_main_page(){

            require get_template_directory() . '/classes/about-render.php';

        }

	}

	new Theme_Name_About_page();

endif;