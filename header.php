<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 */
$blog_info    = get_bloginfo( 'name' );
$description	= get_bloginfo( 'description' );

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php themename_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'themename' ); ?></a>

<?php the_header_image_tag(); ?>
	<header id="masthead" class="site-header">

		<div id="nameplate">
			<h1 class="site-title">
				<?php echo $blog_info; ?>
			</h1>

			<h4 class ="site-description">
				<?php echo $description ?>
			</h4>
		</div>

		<div id="navigation">
			<div class="menu-icon" id="menu-icon">
				<button id="primary-mobile-menu" class="button" role="button" aria-controls="primary-menu-list" aria-expanded="false">
					<span class="dropdown-icon open">
						<?php esc_html_e( 'Menu', 'themename' ); ?>
						<?php echo themename_get_icon_svg( 'ui', 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</span>
					<span></span>
					<span></span>
					<span class="dropdown-icon close">
						<?php esc_html_e( 'Close', 'themename' ); ?>
						<?php echo themename_get_icon_svg( 'ui', 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</span>
				</button>
			</div>

			<!-- Navigation -->
			<div class="main-menu">
				<nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'themename' ); ?>">
					<?php if (has_nav_menu('Primary Menu')) {
							wp_nav_menu(
								array(
									'theme_location'  => 'primary-nav',
									'menu_class'      => 'menu-wrapper',
									'menu_id'         => 'primary-menu',
									'container_class' => 'primary-menu-container',
									'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
									'menu_class'      => 'menu-list'
								));
						}
					?>
				</nav>
			</div>
			<!-- Socials -->
			<div class="socials">
				<?php if (has_nav_menu('Social-Menu')) {
					wp_nav_menu(
						array(
							'theme_location' => 'social-nav',
							'menu_id'        => 'social-menu',
							'menu_class'     => 'social-menu',
							'container_class' => 'socials',
						) );
					}
					?>
			</div>
			<?php $themename_search = absint(get_theme_mod( 'themename-search-icon', 1 )); ?>
			<?php if($themename_search == 1) { ?>
				<div class="search-box">
					<?php get_search_form();?>
				</div>
			<?php } ?>
		</div>
		<!-- End Socials -->

		<?php
				$short_description = themename_get_option('short_description_details');
				$button_text = themename_get_option('button_text');
				$button_url_link = themename_get_option('button_url_link');
		?>
		<?php if (!empty($short_description)) { ?>
			<caption>
				<p><?php echo esc_html($short_description); ?></p>
			</caption>
		<?php } ?>
		<?php if (!empty($button_text)) { ?>
			<div class="btn-section">
				<a href="<?php echo esc_url($button_url_link); ?>" class="border-btn border-btn-white"><?php echo esc_html($button_text); ?>
				</a>
			</div>
		<?php } ?>

		<div class="copyright">
			<p>
				<?php
						$themename_copyright_text = get_theme_mod( 'themename-copyright-text', __( 'ThemeName @ 2022', 'themename' ) ); ?>
					<span class="copyright">
						<?php echo esc_html($themename_copyright_text); ?>
					</span>
				<?php
						/* translators: 1: Theme name, 2: Theme author. */
						printf( esc_html__( 'By %1$s : %2$s.', 'themename' ), '', '<a href="https://www.creativityarchitect.com/">Creativity Architect</a>' );
						?>
			</p>
		</div>
		<div class="close-block">
			<a href="javascript:void(0)">
				<div class="button-close"></div>
			</a>
		</div>


	</header>

		<div id="content" class="site-content">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
