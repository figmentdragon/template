<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since ThemeName 1.0
	 *
	 * @return void
	 */
	function themename_register_block_styles() {
		// Columns: Overlap.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'themename-columns-overlap',
				'label' => esc_html__( 'Overlap', 'themename' ),
			)
		);

		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'themename-border',
				'label' => esc_html__( 'Borders', 'themename' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'themename-border',
				'label' => esc_html__( 'Borders', 'themename' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'themename-border',
				'label' => esc_html__( 'Borders', 'themename' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'themename-image-frame',
				'label' => esc_html__( 'Frame', 'themename' ),
			)
		);

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'themename-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'themename' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'themename-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'themename' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'themename-border',
				'label' => esc_html__( 'Borders', 'themename' ),
			)
		);

		// Separator: Thick.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'themename-separator-thick',
				'label' => esc_html__( 'Thick', 'themename' ),
			)
		);

		// Social icons: Dark gray color.
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'themename-social-icons-color',
				'label' => esc_html__( 'Dark gray', 'themename' ),
			)
		);
	}
	add_action( 'init', 'themename_register_block_styles' );
}
