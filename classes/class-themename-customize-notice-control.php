<?php
/**
 * Customize API: Theme_Name_Customize_Notice_Control class
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since ThemeName 1.0
 */

/**
 * Customize Notice Control class.
 *
 * @since ThemeName 1.0
 *
 * @see WP_Customize_Control
 */
class Theme_Name_Customize_Notice_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since ThemeName 1.0
	 *
	 * @var string
	 */
	public $type = 'themename-notice';

	/**
	 * Renders the control content.
	 *
	 * This simply prints the notice we need.
	 *
	 * @since ThemeName 1.0
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'To access the Dark Mode settings, select a light background color.', 'themename' ); ?></p>
			<p><a href="<?php echo esc_url( __( 'https://wordpress.org/support/article/themename/#dark-mode-support', 'themename' ) ); ?>">
				<?php esc_html_e( 'Learn more about Dark Mode.', 'themename' ); ?>
			</a></p>
		</div>
		<?php
	}
}
