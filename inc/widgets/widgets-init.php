<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function themename_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Portfolio Widget Section', 'themename' ),
		'id'            => 'portfolio-sidebar',
		'description'   => esc_html__( 'Additional sidebar for Portfolio Template that appears on the right.', 'themename' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'themename' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Main sidebar that appears on the left.', 'themename' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar( array(
		'name'          => esc_html__( 'Content Sidebar', 'themename' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Additional sidebar for Single Page/Post that appears on the right.', 'themename' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'themename_widgets_init' );

require get_template_directory() . '/inc/widgets/widget-base-class.php';
require get_template_directory() . '/inc/widgets/widgets.php';
