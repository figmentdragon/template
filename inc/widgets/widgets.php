<?php
/**
 * Theme widgets.
 *
 * @package ThemeName
 */

if (!function_exists('themename_load_widgets')) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function themename_load_widgets()
    {

        // Slider Post widget.
        register_widget('ThemeName_slider_post_widget');

        // Recent Post widget.
        register_widget('ThemeName_sidebar_widget');

        // Social widget.
        register_widget('ThemeName_Social_widget');

        // Bio widget.
        register_widget('ThemeName_Bio_Post_widget');

    }
endif;
add_action('widgets_init', 'themename_load_widgets');


/*Slider Post widget*/
if (!class_exists('ThemeName_slider_post_widget')) :

    /**
     * Slider Post widget Class.
     *
     * @since 1.0.0
     */
    class ThemeName_slider_post_widget extends ThemeName_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'themename_slider_post_widget',
                'description' => __('Displays post form selected category as slider in any sidebars.', 'themename'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'post_category' => array(
                    'label' => __('Select Category:', 'themename'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'themename'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'themename'),
                    'type' => 'number',
                    'default' => 5,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
            );

            parent::__construct('themename-slider-post-sidebar-layout', __('ThemeName :- Slider Post', 'themename'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php global $post;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <?php $twp_rtl_class = 'false';
            if(is_rtl()){
                $twp_rtl_class = 'true';
            }?>
            <div class="widget-slider post-with-bg-image" data-slick='{"rtl": <?php echo esc_attr($twp_rtl_class); ?>}'>
            <?php foreach ($all_posts as $key => $post) : ?>
                <?php setup_postdata($post); ?>
                    <div class="widget-slider-wrapper">
                        <div class="gallery-post">
                            <?php if (has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium-large' );
                                $url = $thumb['0'];
                                } else {
                                    $url = '';
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail data-bg" data-background="<?php echo esc_url($url); ?>">
                            </a>
                            <div class="desc overlay-black">
                                <div class="categories">
                                    <?php themename_post_categories(); ?>
                                </div>
                                <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="author-meta author-meta-primary">
                                    <?php themename_post_date(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;


/*Recent Post widget*/
if (!class_exists('ThemeName_sidebar_widget')) :

    /**
     * Recent/Popular widget Class.
     *
     * @since 1.0.0
     */
    class ThemeName_sidebar_widget extends ThemeName_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'themename_popular_post_widget',
                'description' => __('Displays post form selected category specific for popular post in sidebars.', 'themename'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'themename'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'themename'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'themename'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'themename'),
                    'type' => 'number',
                    'default' => 5,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
            );

            parent::__construct('themename-popular-sidebar-layout', __('ThemeName :- Recent Post', 'themename'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php global $post;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <ul class="list-post-list">
            <?php foreach ($all_posts as $key => $post) : ?>
                <?php setup_postdata($post); ?>
                    <li class="list-post d-flex">
                        <div class="image-section">
                            <?php if (has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
                                $url = $thumb['0'];
                                } else {
                                    $url = '';
                            }
                            ?>
                            <a  href="<?php the_permalink(); ?>" class="data-bg image-hover" data-background="<?php echo esc_url($url); ?>">
                            </a>
                        </div>
                        <div class="desc">
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <div class="author-meta author-meta-primary">
                                <?php themename_post_date(); ?>
                            </div>
                        </div>
                    </li>
                <?php
                    endforeach;
                ?>
            </ul>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;


/*Social widget*/
if (!class_exists('ThemeName_Social_widget')) :

    /**
     * Social widget Class.
     *
     * @since 1.0.0
     */
    class ThemeName_Social_widget extends ThemeName_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'themename_social_widget',
                'description' => __('Displays Social share.', 'themename'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'themename'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
            );

            parent::__construct('themename-social-layout', __('ThemeName :- Social Widget', 'themename'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if ( ! empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <div class="social-widget-section">
                <?php
                    wp_nav_menu(
                        array('theme_location' => 'social-nav',
                            'link_before' => '<span>',
                            'link_after' => '</span>',
                            'menu_id' => 'social-menu',
                            'fallback_cb' => false,
                            'menu_class' => 'social-icons-rounded social-widget'
                        )); ?>
                <?php if ( ! has_nav_menu( 'social-nav' ) ) : ?>
                    <p>
                        <?php esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'themename' ); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;



/*Bio widget*/
if (!class_exists('ThemeName_Bio_Post_widget')) :

    /**
     * Bio widget Class.
     *
     * @since 1.0.0
     */
    class ThemeName_Bio_Post_widget extends ThemeName_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'themename_bio_widget',
                'description' => __('Displays bio details in post.', 'themename'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'themename'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'bio-name' => array(
                    'label' => __('Name:', 'themename'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'bio-sub-title' => array(
                    'label' => __('Position/Sub Title:', 'themename'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'quote' => array(
                    'label' => __('Quotation:', 'themename'),
                    'type'  => 'textarea',
                    'class' => 'widget-content widefat'
                ),
                'image_url' => array(
                    'label' => __('Bio Image:', 'themename'),
                    'type'  => 'image',
                ),
                'url-fb' => array(
                   'label' => __('Facebook URL:', 'themename'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-tw' => array(
                   'label' => __('Twitter URL:', 'themename'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-lt' => array(
                   'label' => __('Linkedin URL:', 'themename'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-ig' => array(
                   'label' => __('Instagram URL:', 'themename'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
            );

            parent::__construct('themename-bio-layout', __('ThemeName :- Bio Widget', 'themename'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if ( ! empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <!--cut from here-->
            <div class="bio-widget">
                <div class="basic-info d-flex">
                    <?php if ( ! empty( $params['image_url'] ) ) { ?>
                        <div class="image-section">
                            <div class="wrapper data-bg image-hover overlay-image-hover" data-background="<?php echo esc_url( $params['image_url'] ); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="title-with-social-icon">
                        <?php if ( ! empty( $params['bio-name'] ) ) { ?>
                            <h2><?php echo esc_html($params['bio-name'] );?></h2>
                        <?php } ?>

                        <?php if ( ! empty( $params['bio-sub-title'] ) ) { ?>
                            <h5><?php echo esc_html($params['bio-sub-title'] );?></h5>
                        <?php } ?>

                        <div class="bio-social-widget">
                            <?php if ( ! empty( $params['url-fb'] ) ) { ?>
                                <span><a href="<?php echo esc_url($params['url-fb']); ?>"><i class="fa fa-facebook"></i></a></span></span>
                            <?php } ?>
                            <?php if ( ! empty( $params['url-tw'] ) ) { ?>
                                <span><a href="<?php echo esc_url($params['url-tw']); ?>"><i class=" fa fa-twitter"></i></a></span>
                            <?php } ?>
                            <?php if ( ! empty( $params['url-lt'] ) ) { ?>
                                <span><a href="<?php echo esc_url($params['url-lt']); ?>"><i class=" fa fa-linkedin"></i></a></span>
                            <?php } ?>
                            <?php if ( ! empty( $params['url-ig'] ) ) { ?>
                                <span><a href="<?php echo esc_url($params['url-ig']); ?>"><i class=" fa fa-instagram"></i></a></span>
                            <?php } ?>
                        </div>
                    </div>
                </div><!--/basic-info-->


                <?php if ( ! empty( $params['quote'] ) ) { ?>
                    <div class="quote">
                        <p><?php echo wp_kses_post( $params['quote']); ?></p>
                    </div>
                <?php } ?>

            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;
