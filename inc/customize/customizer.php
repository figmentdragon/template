<?php
/**
 * ThemeName Theme Customizer.
 *
 * @package themename
 */

 //customizer core option
 require get_template_directory() . '/inc/customize/core/customizer-core.php';

 //customizer
 require get_template_directory() . '/inc/customize/core/default.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function themename_customize_register( $wp_customize ) {

	// Load custom controls.
	require get_template_directory() . '/inc/customize/core/control.php';

	// Load customize sanitize.
	require get_template_directory() . '/inc/customize/core/sanitize.php';

	// Load customize callback.
	require get_template_directory() . '/inc/customize/core/callback.php';


	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_video' )->transport          = 'refresh';
	$wp_customize->get_setting( 'external_header_video' )->transport = 'refresh';
	$wp_customize->get_setting( 'header_image' )->transport 		 = 'refresh';

	/*option panel for page-template details*/
	require get_template_directory() . '/inc/customize/page-template.php';

	/*theme option panel details*/
	require get_template_directory() . '/inc/customize/theme-option.php';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
        'container_inclusive' => false,
				'render_callback' => 'themename_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
        'selector' => '.site-description',
  			'container_inclusive' => false,
				'render_callback' => 'themename_customize_partial_blogdescription',
			)
		);
	}


	// Important Links.
	$wp_customize->add_section( 'themename_important_links', array(
		'priority'      => 999,
		'title'         => esc_html__( 'Important Links', 'themename' ),
	) );
	// Has dummy Sanitizaition function as it contains no value to be sanitized.
	themename_register_option( $wp_customize, array(
			'name'              => 'themename_important_links',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'ThemeName_Important_Links_Control',
			'label'             => esc_html__( 'Important Links', 'themename' ),
			'section'           => 'themename_important_links',
			'type'              => 'themename_important_links',
		)
	);
	// Important Links End.

  /*Main custom panel for theme settings*/
  $wp_customize->add_panel(
    'themename_panel',
    array(
      'priority'   => 10,
      'capability' => 'edit_theme_options',
      'title'      => __( 'Theme Options', 'themename' ),
    )
  );

  /*Header Options*/
  $wp_customize->add_section(
    'header_section',
    array(
      'title' => __( 'Header Options', 'themename' ),
      'panel' => 'themename_panel',
    )
  );

  /*Search Icon*/
  $wp_customize->add_setting(
    'themename-search-icon',
    array(
      'capability'        => 'edit_theme_options',
      'transport'         => 'refresh',
      'default'           => 1,
      'sanitize_callback' => 'themename_sanitize_checkbox',
    )
  );

  $wp_customize->add_control(
    'themename-search-icon',
    array(
      'label'       => __( 'Show Search Icon', 'themename' ),
      'description' => __( 'Checked to show the search icon.', 'themename' ),
      'section'     => 'header_section',
      'type'        => 'checkbox',
    )
  );

  /*Preloader Options*/
  $wp_customize->add_section(
    'preloader_option',
    array(
      'title' => __( 'Preloader Options', 'themename' ),
      'panel' => 'themename_panel',
    )
  );

  /*Search Icon*/
  $wp_customize->add_setting(
    'themename-preloader',
    array(
      'capability'        => 'edit_theme_options',
      'transport'         => 'refresh',
      'default'           => 0,
      'sanitize_callback' => 'themename_sanitize_checkbox',
    )
  );

  $wp_customize->add_control(
    'themename-preloader',
    array(
      'label'       => __( 'Enable Preloader', 'themename' ),
      'description' => __( 'Checked to enable preloader.', 'themename' ),
      'section'     => 'preloader_option',
      'type'        => 'checkbox',
    )
  );

  /*Footer Options*/
  $wp_customize->add_section(
    'copyright_option',
    array(
      'title' => __( 'Copyright Options', 'themename' ),
      'panel' => 'themename_panel',
    )
  );


  /*Copyright Text*/
  $wp_customize->add_setting(
    'themename-copyright-text',
    array(
      'capability'        => 'edit_theme_options',
      'transport'         => 'refresh',
      'default'           => __( '© 2022', 'themename' ),
      'sanitize_callback' => 'sanitize_text_field',
    )
  );

  $wp_customize->add_control(
    'themename-copyright-text',
    array(
      'label'       => __( 'Copyright Text', 'themename' ),
      'description' => __( 'Enter your copyright text here.', 'themename' ),
      'section'     => 'copyright_option',
      'type'        => 'text',
    )
  );
}
add_action( 'customize_register', 'themename_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function themename_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function themename_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function themename_customize_preview_js() {
	wp_enqueue_script( 'themename-customizer', get_template_directory_uri() . '/assets/js/source/customizer.js', array( 'customize-preview' ), THEMENAME_VERSION, true );
}
add_action( 'customize_preview_init', 'themename_customize_preview_js' );

function themename_customizer_css() {
	wp_enqueue_script('themename_customize_admin_js', get_template_directory_uri().'/assets/themename/js/customizer-admin.js', array('customize-controls'));

	wp_enqueue_style( 'themename_customize_controls', get_template_directory_uri() . '/assets/themename/css/customizer-control.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'themename_customizer_css',0 );

/**
 * Include Custom Controls
 */
require get_template_directory() . '/inc/customize/custom-controls.php';

/**
 * Include Header Media Options
 */
require get_template_directory() . '/inc/customize/header-media.php';

/**
 * Include Theme Options
 */
require get_template_directory() . '/inc/customize/theme-options.php';

/**
 * Include Hero Content
 */
require get_template_directory() . '/inc/customize/hero-content.php';

/**
 * Include Featured Slider
 */
require get_template_directory() . '/inc/customize/featured-slider.php';

/**
 * Include Featured Content
 */
require get_template_directory() . '/inc/customize/featured-content.php';

/**
 * Include Testimonial
 */
require get_template_directory() . '/inc/customize/testimonial.php';

/**
 * Include Portfolio
 */
require get_template_directory() . '/inc/customize/portfolio.php';

/**
 * Include Customizer Helper Functions
 */
require get_template_directory() . '/inc/customize/helpers.php';

/**
 * Include Sanitization functions
 */
require get_template_directory() . '/inc/customize/sanitize-functions.php';

/**
 * Include Service
 */
require get_template_directory() . '/inc/customize/service.php';

/**
 * Include Reset Button
 */
require get_template_directory() . '/inc/customize/reset.php';

/**
 * Upgrade to Pro Button
 */
require get_template_directory() . '/inc/customize/upgrade-button/class-customize.php';
