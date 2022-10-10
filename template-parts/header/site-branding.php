<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 */

$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = ( true === get_theme_mod( 'display_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';

?>

<div class="site-logo">
	<?php the_custom_logo(); ?>
</div>

<div id="nameplate" class="site-branding">

	<h1 class="<?php echo esc_attr( $header_class ); ?>">
		<?php echo esc_html( $blog_info ); ?>
	</h1>
	<h4 class="site-description">
		<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</h4>
</div>

<!-- .site-branding -->
