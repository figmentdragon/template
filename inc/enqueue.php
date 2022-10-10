<?php

/* - #ENQUEUE SCRIPTS & STYLES --------------- *\
 * -> All scripts & stylesheets organized and
 *    enqueued here

 * -> =Add Action
 * -> =Deregister
 * -> =Scripts & Styles ^Third Party & Vendors^
 * -> =Styles
 * -> =Scripts
 * -> =Conditional Scripts
 * -> =Admin & Editor Scripts & Styles
\* ------------------------------------------- */


add_action( 'wp_enqueue_scripts', 'themename_scripts_and_styles' );
add_action( 'wp_footer', 'deregister_scripts' );
add_action( 'wp_enqueue_styles', 'themename_styles' );
add_action( 'wp_enqueue_scripts', 'themename_scripts' );
add_action( 'wp_enqueue_scripts', 'themename_conditional_scripts' );
add_action( 'admin_enqueue_scripts', 'themename_admin_scripts' );

function deregister_scripts() {
  wp_deregister_script( 'wp-embed' );
}
function deregister_styles() {
  wp_dequeue_style( 'wp-block-library' );
}

function themename_fonts_url() { }

function themename_scripts_and_styles() {
  wp_enqueue_style('slick', get_template_directory_uri().'/assets/libraries/slick/css/slick.css');
	wp_enqueue_style('magnific', get_template_directory_uri().'/assets/libraries/magnific/css/magnific-popup.css');

	wp_enqueue_script( 'themename-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script('jquery-slick', get_template_directory_uri() . '/assets/libraries/slick/js/slick.min.js', array('jquery'), '', true);
	wp_enqueue_script('jquery-magnific', get_template_directory_uri() . '/assets/libraries/magnific/js/jquery.magnific-popup.min.js', array('jquery'), '', true);
	wp_enqueue_script('theiaStickySidebar', get_template_directory_uri() . '/assets/libraries/theiaStickySidebar/theia-sticky-sidebar.min.js', array('jquery'), '', true);
}

function themename_styles() { }

function themename_scripts() {
  wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script('masonry');
    $args = themename_get_localized_variables();

  wp_enqueue_script( 'themename-main-script', get_template_directory_uri() . '/assets/themename/js/main.js',  array( 'jquery', 'wp-mediaelement' ), '', true );
  wp_localize_script( 'themename-main-script', 'ThemeNameVal', $args );
}

function themename_conditional_scripts() {
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

}

/**
 * Enqueue admin scripts and styles.
 */
