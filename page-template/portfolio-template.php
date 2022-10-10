<?php
/**
 * Template Name: Portfolio Page Template
 *
 * @subpackage themename
 * @since themename 1.0.0
 */

get_header(); ?>
<div class="site-content min-height">
	<?php if ( (is_active_sidebar( 'portfolio-template-sidebar' )) && (themename_get_option('enable_portfolio_widget_sidebar') == 1) ) { ?>
		<div class="portfolio-widget-section widget-area">
			<?php dynamic_sidebar( 'portfolio-template-sidebar' ); ?>
		</div>
	<?php } ?>
	<?php if ((themename_get_option('enable_portfolio_masonry_section') == 1) ) { ?>
		<div class="portfolio-gallery-section">
			<?php if (themename_get_option('enable_portfolio_page_title') == 1) { ?>
				<div class="title-section">
					<h2 class="section-title title-with-bar"><?php the_title(); ?> </h2>
				</div>
			<?php } ?>
			<?php $portfolio_masonary_col = 'masonary-gallery-with-space col-3-masonary';
			if ( (is_active_sidebar( 'portfolio-template-sidebar' )) && (themename_get_option('enable_portfolio_widget_sidebar') == 1) ) {
				$portfolio_masonary_col = 'masonary-gallery-no-space col-2-masonary';
			} ?>
			<div class="masonry-blocks <?php echo esc_attr($portfolio_masonary_col); ?> post-with-bg-image">
				<?php
					$args = array(
						'post_type' => 'post',
						'cat' => absint(themename_get_option('select_category_for_portfolio_section')),
						'ignore_sticky_posts' => true,
						'posts_per_page' => absint(themename_get_option('portfolio_section_post_number')),
					);
				?>
				<?php query_posts($args); ?>
					<?php if ( have_posts() ) : ?>

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							$themename_archive_classes = array(
								'gallery-post',
								'overlay-image-hover',
							);
							?>
							<?php
							if (has_post_thumbnail()) { ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class($themename_archive_classes); ?>>
									<a  class="post-thumbnail d-block" href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('medium_large'); ?>
										<span class="post-format-white">
											<?php echo esc_attr(themename_post_format(get_the_ID())); ?>
										</span>
									</a>
									<div class="desc">
										<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
										<div class="categories">
											<?php themename_post_categories(); ?>
										</div>
									</div>
								</article><!-- #post-<?php the_ID(); ?> -->
							<?php } ?>
						<?php
						endwhile;
						wp_reset_postdata();

					endif;
				?>
			</div>
		</div>
	<?php } ?>

<?php get_footer(); ?>
