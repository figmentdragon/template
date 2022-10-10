<?php
if (!function_exists('themename_blog_banner_slider')) :
    /**
     * Blog Banner Section
     *
     * @since ThemeName 1.0.0
     *
     *
     *
     */
    function themename_blog_banner_slider()
    {
        ?>
        <?php if (1 == themename_get_option('show_slider_on_blog')) { ?>
            <div class="blog-slider-section">

                <?php
                $themename_select_category_for_banner_section = esc_attr(themename_get_option('select_category_for_blog_slider'));
                $themename_number_of_home_banner_section = absint(themename_get_option('blog_page_slider_number'));
                $themename_blog_banner_slider_args = array(
                    'post_type' => 'post',
                    'cat' => absint($themename_select_category_for_banner_section),
                    'ignore_sticky_posts' => true,
                    'posts_per_page' => absint( $themename_number_of_home_banner_section ),
                ); ?>
                    <?php $twp_rtl_class = 'false';
                    if(is_rtl()){
                        $twp_rtl_class = 'true';
                    }?>
                        <div class="blog-slider"  data-slick='{"rtl": <?php echo esc_attr($twp_rtl_class); ?>}'>
                            <?php
                            $themename_blog_banner_slider_post_query = new WP_Query($themename_blog_banner_slider_args);
                            if ($themename_blog_banner_slider_post_query->have_posts()) :
                            while ($themename_blog_banner_slider_post_query->have_posts()) : $themename_blog_banner_slider_post_query->the_post();
                                if(has_post_thumbnail()){
                                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium-large' );
                                    $url = $thumb['0'];
                                }
                                else{
                                    $url = '';
                                }
                                ?>
                                <div class="wrapper">
                                    <div class="blog-post">
                                        <div class="image-section data-bg" data-background="<?php echo esc_url($url); ?>">
                                        </div>
                                        <div class="desc">
                                            <h3 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <div class="categories">
                                                <?php themename_post_categories(); ?>
                                            </div>
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;
                            endif;
                            wp_reset_postdata(); ?>

                        </div>
            </div>
        <?php } ?>

        <?php
    }
endif;
add_action('themename_action_blog_banner_slider', 'themename_blog_banner_slider', 10);
