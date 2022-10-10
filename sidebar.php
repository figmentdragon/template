<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package themename
 */
?>
<div id="secondary">

	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div><!-- #secondary -->
