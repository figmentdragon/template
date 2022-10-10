<?php
/**
 * Implement theme metabox.
 *
 * @package themename
 */
if (!function_exists('themename_add_theme_meta_box')) :

    /**
     * Add the Meta Box
     *
     * @since 1.0.0
     */
    function themename_add_theme_meta_box()
    {

        $screens = array('post', 'page');

        foreach ($screens as $screen) {
            add_meta_box(
                'themename-theme-settings',
                esc_html__('Single Page/Post Layout Settings', 'themename'),
                'themename_render_theme_settings_metabox',
                $screen,
                'normal',
            	'high'

            );
        }

    }

endif;

add_action('add_meta_boxes', 'themename_add_theme_meta_box');


if ( ! function_exists( 'themename_render_theme_settings_metabox' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function themename_render_theme_settings_metabox( $post, $metabox ) {

		$post_id = $post->ID;
		$themename_post_meta_value = get_post_meta($post_id);

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'themename_meta_box_nonce' );
		// Fetch Options list.
		$page_layout = get_post_meta($post_id,'themename-meta-select-layout',true);
		$themename_meta_checkbox = get_post_meta($post_id,'themename-meta-checkbox',true);
	?>

	<div class="themename-tab-main">

        <div class="themename-metabox-tab">
            <ul>
                <li>
                    <a id="tab-general" class="tab-active" href="javascript:void(0)"><?php esc_html_e('Layout Settings', 'themename'); ?></a>
                </li>
            </ul>
        </div>

        <div class="themename-tab-content">

            <div id="tab-general-content" class="themename-content-wrap themename-tab-content-active">

                <div class="themename-meta-panels">

                    <div class="themename-opt-wrap themename-checkbox-wrap">

                        <input id="themename-meta-checkbox" name="themename-meta-checkbox" type="checkbox" <?php if ( $themename_meta_checkbox ) { ?> checked="checked" <?php } ?> />

                        <label for="themename-meta-checkbox"><?php esc_html_e('Check To Enable Featured Image On Single Page', 'themename'); ?></label>
                    </div>

                    <div class="themename-opt-wrap themename-opt-wrap-alt">

						<label><?php esc_html_e('Single Page/Post Layout', 'themename'); ?></label>

	                     <select name="themename-meta-select-layout" id="themename-meta-select-layout">
				            <option value="right-sidebar" <?php selected('right-sidebar',$page_layout);?>>
				            	<?php _e( 'Content - Primary Sidebar', 'themename' )?>
				            </option>
				            <option value="left-sidebar" <?php selected('left-sidebar',$page_layout);?>>
				            	<?php _e( 'Primary Sidebar - Content', 'themename' )?>
				            </option>
				            <option value="no-sidebar" <?php selected('no-sidebar',$page_layout);?>>
				            	<?php _e( 'No Sidebar', 'themename' )?>
				            </option>
			            </select>

			        </div>

                </div>
            </div>

        </div>
    </div>

    <?php
	}

endif;



if ( ! function_exists( 'themename_save_theme_settings_meta' ) ) :

	/**
	 * Save theme settings meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 */
	function themename_save_theme_settings_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['themename_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['themename_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return; }
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$themename_meta_checkbox =  isset( $_POST[ 'themename-meta-checkbox' ] ) ? esc_attr($_POST[ 'themename-meta-checkbox' ]) : '';
		update_post_meta($post_id, 'themename-meta-checkbox', sanitize_text_field($themename_meta_checkbox));

		$themename_meta_select_layout =  isset( $_POST[ 'themename-meta-select-layout' ] ) ? esc_attr($_POST[ 'themename-meta-select-layout' ]) : '';
		if(!empty($themename_meta_select_layout)){
			update_post_meta($post_id, 'themename-meta-select-layout', sanitize_text_field($themename_meta_select_layout));
		}
	}

endif;

add_action( 'save_post', 'themename_save_theme_settings_meta', 10, 3 );
