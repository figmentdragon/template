<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 */

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'themename_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since ThemeName 1.0
	 *
	 * @return void
	 */
	function themename_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ThemeName, use a find and replace
		 * to change 'themename' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'themename', get_template_directory() . '/languages' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		// Custom background color.
		add_theme_support(
			'custom-background',
			apply_filters(
				'themename_custom_background_args',
				array(
					'default-color' => 'd1e4dd',
					'default-image' => '',
				)
			)
		);
		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );
		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 250;
		$logo_height = 250;

		add_theme_support( 'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
				// Add support for experimental link color control.
		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );
		// Add support for custom units.
		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );
		/**
		 * Add support for essential widget image.
		 */
		add_theme_support( 'ew-newsletter-image' );
		add_theme_support( 'experimental-link-color' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5',
			array(
				'caption',
				'comment-form',
				'comment-list',
				'gallery',
				'navigation-widgets',
				'script',
				'search-form',
				'style',
			)
		);

		/**
		 * Add post-formats support.
		 */
		add_theme_support( 'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );
			add_image_size( 'themename-block-image', 606, 404, true ); // Ratio 3:2
			add_image_size( 'themename-single-post-page', 1920, 440, true );
			add_image_size( 'themename-slider', 1920, 1080, true ); // Ratio 16:9
			// Used in Portfolio
			add_image_size( 'themename-portfolio', 1920, 9999, true ); // Flexible Height
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
		/*
			 * Let WordPress manage the document title.
			 * This theme does not use a hard-coded <title> tag in the document head,
			 * WordPress will provide it for us.
			 */
		add_theme_support( 'title-tag' );

		register_nav_menus(
			array(
				'primary-nav' => esc_html__( 'Primary Menu', 'themename' ),
				'social-nav' => esc_html__( 'Social Menu', 'themename' ),
				'footer'  => esc_html__( 'Secondary-Menu', 'themename' ),
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
		if ( 127 > Theme_Name_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
			add_theme_support( 'dark-editor-style' );
		}

		$editor_stylesheet_path = './assets/css/style-editor.css';

		// Note, the is_IE global variable is defined by WordPress and is used
		// to detect if the current browser is internet explorer.
		global $is_IE;
		if ( $is_IE ) {
			$editor_stylesheet_path = './assets/css/ie-editor.css';
		}

		// Enqueue editor styles.
		add_editor_style( $editor_stylesheet_path );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', 'themename' ),
					'shortName' => esc_html_x( 'XS', 'Font size', 'themename' ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', 'themename' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'themename' ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'themename' ),
					'shortName' => esc_html_x( 'M', 'Font size', 'themename' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'themename' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'themename' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'themename' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'themename' ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'themename' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'themename' ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'themename' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'themename' ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

		// Editor color palette.
		$black     = '#000000';
		$dark_gray = '#28303D';
		$gray      = '#39414D';
		$green     = '#D1E4DD';
		$blue      = '#D1DFE4';
		$purple    = '#D1D1E4';
		$red       = '#E4D1D1';
		$orange    = '#E4DAD1';
		$yellow    = '#EEEADD';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', 'themename' ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Dark gray', 'themename' ),
					'slug'  => 'dark-gray',
					'color' => $dark_gray,
				),
				array(
					'name'  => esc_html__( 'Gray', 'themename' ),
					'slug'  => 'gray',
					'color' => $gray,
				),
				array(
					'name'  => esc_html__( 'Green', 'themename' ),
					'slug'  => 'green',
					'color' => $green,
				),
				array(
					'name'  => esc_html__( 'Blue', 'themename' ),
					'slug'  => 'blue',
					'color' => $blue,
				),
				array(
					'name'  => esc_html__( 'Purple', 'themename' ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Red', 'themename' ),
					'slug'  => 'red',
					'color' => $red,
				),
				array(
					'name'  => esc_html__( 'Orange', 'themename' ),
					'slug'  => 'orange',
					'color' => $orange,
				),
				array(
					'name'  => esc_html__( 'Yellow', 'themename' ),
					'slug'  => 'yellow',
					'color' => $yellow,
				),
				array(
					'name'  => esc_html__( 'White', 'themename' ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
		);

		add_theme_support( 'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Purple to yellow', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'purple-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to purple', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'yellow-to-purple',
				),
				array(
					'name'     => esc_html__( 'Green to yellow', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'green-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to green', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
					'slug'     => 'yellow-to-green',
				),
				array(
					'name'     => esc_html__( 'Red to yellow', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'red-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to red', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'yellow-to-red',
				),
				array(
					'name'     => esc_html__( 'Purple to red', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'purple-to-red',
				),
				array(
					'name'     => esc_html__( 'Red to purple', 'themename' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'red-to-purple',
				),
			)
		);

		/*
		* Adds starter content to highlight the theme on fresh sites.
		* This is done conditionally to avoid loading the starter content on every
		* page load, as it is a one-off operation only needed once in the customizer.
		*/
		if ( is_customize_preview() ) {
			require get_template_directory() . '/inc/starter-content.php';
			add_theme_support( 'starter-content', themename_get_starter_content() );
		}

		// Remove feed icon link from legacy RSS widget.
		add_filter( 'rss_widget_feed_link', '__return_false' );
	}
}
add_action( 'after_setup_theme', 'themename_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @since ThemeName 1.0
 *
 * @global int $content_width Content width.
 *
 * @return void
 */
function themename_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'themename_content_width', 940 );
}
add_action( 'after_setup_theme', 'themename_content_width', 0 );


function themename_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'themename_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_scripts() {
	// Note, the is_IE global variable is defined by WordPress and is used
	// to detect if the current browser is internet explorer.
	global $is_IE, $wp_scripts;
	if ( $is_IE ) {
		// If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
		wp_enqueue_style( 'themename-style', get_template_directory_uri() . '/assets/css/ie.css', array(), wp_get_theme()->get( 'Version' ) );
	} else {
		// If not IE, use the standard stylesheet.
		wp_enqueue_style( 'themename-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	}

	// RTL styles.
	wp_style_add_data( 'themename-style', 'rtl', 'replace' );

	// Print styles.
	wp_enqueue_style( 'themename-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );



	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), 'Version', true );

	wp_enqueue_script( 'themename-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), 'Version', true );








	wp_enqueue_style( 'themename-style', get_stylesheet_uri() );


	wp_register_script( 'fitty', get_template_directory_uri() . '/assets/js/fitty.min.js' );
	wp_enqueue_script( 'fitty' );

	// Register the IE11 polyfill file.
	wp_register_script(
		'themename-ie11-polyfills-asset',
		get_template_directory_uri() . '/assets/js/polyfills.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Register the IE11 polyfill loader.
	wp_register_script(
		'themename-ie11-polyfills',
		null,
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_add_inline_script(
		'themename-ie11-polyfills',
		wp_get_script_polyfill(
			$wp_scripts,
			array(
				'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'themename-ie11-polyfills-asset',
			)
		)
	);

	// Main navigation scripts.
	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script(
			'themename-primary-navigation-script',
			get_template_directory_uri() . '/assets/js/primary-navigation.js',
			array( 'themename-ie11-polyfills' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	// Responsive embeds script.
	wp_enqueue_script(
		'themename-responsive-embeds-script',
		get_template_directory_uri() . '/assets/js/responsive-embeds.js',
		array( 'themename-ie11-polyfills' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/js/source/' : 'assets/js/';

	// Load the html5 shiv.
	wp_enqueue_script( 'themename-html5',  get_theme_file_uri( $path . 'html5' . $min . '.js' ), array(), '3.7.3' );
	wp_script_add_data( 'themename-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'themename-skip-link-focus-fix', get_theme_file_uri( $path . 'skip-link-focus-fix' . $min . '.js' ), array(), '201800703', true );



	$deps[] = 'jquery';

	$enable_portfolio = get_theme_mod( 'themename_portfolio_option', 'disabled' );

	if ( themename_check_section( $enable_portfolio ) ) {
		$deps[] = 'jquery-masonry';
	}

	$enable_featured_content = get_theme_mod( 'themename_featured_content_option', 'disabled' );

	//Slider Scripts
	$enable_slider      = themename_check_section( get_theme_mod( 'themename_slider_option', 'disabled' ) );

	$enable_testimonial_slider      = themename_check_section( get_theme_mod( 'themename_testimonial_option', 'disabled' ) ) && get_theme_mod( 'themename_testimonial_slider', 1 );

	if ( $enable_slider || $enable_testimonial_slider ) {
		// Enqueue owl carousel css. Must load CSS before JS.
		wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'assets/css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
		wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'assets/css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );

		// Enqueue script
		wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );

		$deps[] = 'owl-carousel';

	}

	wp_enqueue_script( 'themename-script', get_theme_file_uri( $path . 'functions' . $min . '.js' ), $deps, '201800703', true );

	wp_localize_script( 'themename-script', 'themenameOptions', array(
		'screenReaderText' => array(
			'expand'   => esc_html__( 'expand child menu', 'themename' ),
			'collapse' => esc_html__( 'collapse child menu', 'themename' ),
			'icon'     => themename_get_svg( array(
					'icon'     => 'angle-down',
					'fallback' => true,
				)
			),
		),
		'iconNavPrev'     => themename_get_svg( array(
				'icon'     => 'angle-left',
				'fallback' => true,
			)
		),
		'iconNavNext'     => themename_get_svg( array(
				'icon'     => 'angle-right',
				'fallback' => true,
			)
		),
		'iconTestimonialNavPrev'     => '<span>' . esc_html__( 'PREV', 'themename' ) . '</span>',
		'iconTestimonialNavNext'     => '<span>' . esc_html__( 'NEXT', 'themename' ) . '</span>',
		'rtl' => is_rtl(),
		'dropdownIcon'     => themename_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
	) );
}

add_action( 'wp_enqueue_scripts', 'themename_scripts' );

/**
 * Enqueue block editor script.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_block_editor_script() {

	wp_enqueue_script( 'themename-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'themename_block_editor_script' );
/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since ThemeName 1.0
 *
 * @link https://git.io/vWdr2
 */
function themename_skip_link_focus_fix() {

	// If SCRIPT_DEBUG is defined and true, print the unminified file.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		echo '<script>';
		include get_template_directory() . '/assets/js/skip-link-focus-fix.js';
		echo '</script>';

	} else {
		// The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1);
		</script>
		<?php
	}
}
add_action( 'wp_print_footer_scripts', 'themename_skip_link_focus_fix' );

function themename_admin_scripts( $hook ) {
	$current_screen = get_current_screen();
	    if( $current_screen->id != "widgets" ) {

			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );

		    wp_enqueue_script('themename-admin', get_template_directory_uri() . '/assets/themename/js/admin.js', array('jquery'), '', 1);

		    $ajax_nonce = wp_create_nonce('themename_ajax_nonce');

			wp_localize_script(
		        'themename-admin',
		        'themename_admin',
		        array(
		            'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
		            'ajax_nonce' => $ajax_nonce,
		            'active' => esc_html__('Active','themename'),
			        'deactivate' => esc_html__('Deactivate','themename'),
		         )
		    );

		}
	if ( 'widgets.php' === $hook ) {
	    wp_enqueue_media();
		wp_enqueue_script( 'themename-custom-widgets', get_template_directory_uri() . '/assets/themename/js/widgets.js', array( 'jquery' ), '1.0.0', true );
	}
	wp_enqueue_style( 'themename-custom-admin-style', get_template_directory_uri() . '/assets/themename/css/wp-admin.css', array(), '1.0.0' );

}
add_action( 'admin_enqueue_scripts', 'themename_admin_scripts' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customize/customizer.php';


// SVG Icons class.
require get_template_directory() . '/classes/class-themename-svg-icons.php';
// Custom color classes.
require get_template_directory() . '/classes/class-themename-custom-colors.php';
new Theme_Name_Custom_Colors();
// Customizer additions.
require get_template_directory() . '/classes/class-themename-customize.php';
new Theme_Name_Customize();
// Dark Mode.
require_once get_template_directory() . '/classes/class-themename-dark-mode.php';
new Theme_Name_Dark_Mode();
/**
 * Load TGMPA
 */
require get_template_directory() . '/assets/libraries/TGM-Plugin/class-tgm-plugin-activation.php';


// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';
// Menu functions and filters.
require get_template_directory() . '/inc/menu-functions.php';
/**
 * SVG icons functions and filters
 */
require get_template_directory() . '/inc/icon-functions.php';
require get_template_directory() . '/inc/widgets/widget-social-icons.php';
require get_template_directory() . '/inc/widgets/widgets-init.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';


require get_template_directory() . '/inc/single-meta.php';
/**
 * Load Theme About Page
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/localized-variables.php';
require get_template_directory() . '/inc/hooks/blog-banner-slider.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';
// Block Styles.
require get_template_directory() . '/inc/block-styles.php';


/**
 * Load Theme About Page
 */
require get_template_directory() . '/inc/about.php';
require get_template_directory() . '/classes/about.php';


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function themename_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'themename',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'themename_register_required_plugins' );

/**
 * Checks if there are options already present from free version and adds it to the Pro theme options
 *
 * @since 1.0
 * @hook after_theme_switch
 */
function themename_setup_options( $old_theme_name ) {
	if ( $old_theme_name ) {
		$old_theme_slug = sanitize_title( $old_theme_name );
		$free_version_slug = array(
			'themename',
		);

		$pro_version_slug  = 'themename';

		$free_options = get_option( 'theme_mods_' . $old_theme_slug );

		// Perform action only if theme_mods_photoFocus free version exists.
		if ( in_array( $old_theme_slug, $free_version_slug ) && $free_options && '1' !== get_theme_mod( 'free_pro_migration' ) ) {
			$new_options = wp_parse_args( get_theme_mods(), $free_options );

			if ( update_option( 'theme_mods_' . $pro_version_slug, $free_options ) ) {
				// Set Migration Parameter to true so that this script does not run multiple times.
				set_theme_mod( 'free_pro_migration', '1' );
			}
		}
	}
}
add_action( 'after_switch_theme', 'themename_setup_options' );


/**
 * Enqueue scripts for the customizer preview.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_customize_preview_init() {
	wp_enqueue_script(
		'themename-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script(
		'themename-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'themename-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'themename_customize_preview_init' );

/**
 * Enqueue scripts for the customizer.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'themename-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'themename_customize_controls_enqueue_scripts' );

/**
 * Calculate classes for the main <html> element.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_the_html_classes() {
	/**
	 * Filters the classes for the main <html> element.
	 *
	 * @since ThemeName 1.0
	 *
	 * @param string The list of classes. Default empty string.
	 */
	$classes = apply_filters( 'themename_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

/**
 * Add "is-IE" class to body if the user is on Internet Explorer.
 *
 * @since ThemeName 1.0
 *
 * @return void
 */
function themename_add_ie_class() {
	?>
	<script>
	if ( -1 !== navigator.userAgent.indexOf( 'MSIE' ) || -1 !== navigator.appVersion.indexOf( 'Trident/' ) ) {
		document.body.classList.add( 'is-IE' );
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'themename_add_ie_class' );

if ( ! function_exists( 'wp_get_list_item_separator' ) ) :
	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	function wp_get_list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return __( ', ', 'themename' );
	}
endif;

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since themename 1.0
 *
 */
function themename_post_nav_background() {
    if ( ! is_single() ) {
        return;
    }

    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );
    $css      = '';

    if ( is_attachment() && 'attachment' == $previous->post_type ) {
        return;
    }

    if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
        $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
        $css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
    }

    if ( $next && has_post_thumbnail( $next->ID ) ) {
        $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
        $css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
    }

    wp_add_inline_style( 'themename-style', $css );
}
add_action( 'wp_enqueue_scripts', 'themename_post_nav_background' );


add_filter( 'walker_nav_menu_start_el', 'themename_add_description', 10, 2 );
function themename_add_description( $item_output, $item ) {
    $description = $item->post_content;
    if (('' !== $description) && (' ' !== $description) ) {
        return preg_replace( '/(<a.*)</', '$1' . '<span class="menu-description">' . $description . '</span><', $item_output) ;
    }
    else {
        return $item_output;
    };
}

add_filter('creativityarchitect_enable_demo_import_compatiblity','themename_demo_import_filter_apply');

if( !function_exists('themename_demo_import_filter_apply') ):

	function themename_demo_import_filter_apply(){

		return true;

	}

endif;
