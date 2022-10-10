<?php
/**
 * Primary Menu Template
 *
 * @package themename
 */
?>
<div class="search-inside-wrapper">
	<div id="search-content" class="search-content">
		<div class="search-container">
			<?php 
			$unique_id   = esc_attr( uniqid( 'search-form-' ) );
			$search_text = get_theme_mod( 'themename_search_text', esc_html__( 'Search', 'themename' ) );
			
			get_search_form(); ?>

			<button class="close-submit"><?php echo themename_get_svg( array( 'icon' => 'close' ) ); ?></button>

		</div>
	</div>
</div><!-- .menu-inside-wrapper -->

