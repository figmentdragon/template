<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package themename
 */

if ( ! function_exists( 'themename_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function themename_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>
			<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'themename' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'themename_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function themename_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'themename' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'themename_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function themename_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'themename' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'themename' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'themename' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'themename' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'themename' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'themename' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'<i class="fa fa-pencil"></i></span>'
		);
	}
endif;

if ( ! function_exists( 'themename_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function themename_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if (!function_exists('themename_post_date')) :
    function themename_post_date()
    {


        // Hide category and tag text for pages.
        if ('post' === get_post_type()) { ?>

        	    <span class="post-date">
					<i class="fa fa-clock-o"></i>
        	        <?php
        	        $site_date_layout_option = esc_attr(themename_get_option('site_date_layout_option'));
        	        if ($site_date_layout_option == 'normal-format') {
        	          the_time(get_option('date_format'));
        	        } else {
        	          	echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('ago', 'themename');
        	        }

        	        ?>
        	</span>

            <?php }
    }
endif;

if (!function_exists('themename_post_author')) :

    function themename_post_author()
    {
        global $post;
        if ('post' == get_post_type($post->ID)):
            $author_id = $post->post_author;
            ?>

			<a href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
				<span class="author-image"><img src="<?php echo esc_url(get_avatar_url($author_id, array('size' => 150))); ?>"></span>
				<span class="author-caption"><?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?></span>
			</a>
        <?php
        endif;

    }
endif;

if (!function_exists('themename_post_categories')) :
    function themename_post_categories($separator = '&nbsp')
    {


        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {

            global $post;

            $post_categories = get_the_category($post->ID);
            if ($post_categories) {
                $output = '<ul class="cat-links">';
                foreach ($post_categories as $post_category) {
                    $output .= '<li>
                             <a  href="' . esc_url(get_category_link($post_category)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'themename'), $post_category->name)) . '">
                                 ' . esc_html($post_category->name) . '
                             </a>
                        </li>';
                }
                $output .= '</ul>';
                echo wp_kses_post($output);

            }
        }
    }
endif;

/**
 * Returns post format.
 *
 * @since  themename 1.0.0
 */
if (!function_exists('themename_post_format')):
    function themename_post_format($post_id)
    {
        $post_format = get_post_format($post_id);
        switch ($post_format) {
            case "image":
                $post_format = "<span class='post-format-icon'><i class='fa fa-image'></i></span>";
                break;
            case "video":
                $post_format = "<span class='post-format-icon'><i class='fa fa-video-camera'></i></span>";
                break;
            case "gallery":
                $post_format = "<span class='post-format-icon'><i class='fa fa-image'></i></span>";
                break;
            case "quote":
                $post_format = "<span class='post-format-icon'><i class='fa fa-quote-right'></i></span>";
                break;
           case "audio":
                $post_format = "<span class='post-format-icon'><i class='fa fa-volume-up'></i></span>";
                break;
            default:
                $post_format = "";
        }

        echo wp_kses_post($post_format);
    }
endif;

if ( ! function_exists( 'themename_author_bio' ) ) :
	/**
	 * Prints HTML with meta information for the author bio.
	 */
	function themename_author_bio() {
		if ( '' !== get_the_author_meta( 'description' ) ) {
			get_template_part( 'template-parts/biography' );
		}
	}
endif;

if ( ! function_exists( 'themename_by_line' ) ) :
	/**
	 * Prints HTML with meta information for the author bio.
	 */
	function themename_by_line() {
		$post_id = get_queried_object_id();
		$post_author_id = get_post_field( 'post_author', $post_id );

		$byline = '<span class="author vcard">';

		$byline .= '<a class="url fn n" href="' . esc_url( get_author_posts_url( $post_author_id ) ) . '">' . esc_html( get_the_author_meta( 'nickname', $post_author_id ) ) . '</a></span>';

		echo '<span class="byline">' .  esc_html__( 'Posted By ', 'themename' ) . $byline . '</span>';
	}
endif;

if ( ! function_exists( 'themename_entry_category_date' ) ) :
	/**
	 * Prints HTML with category and tags for current post.
	 *
	 * Create your own themename_entry_category_date() function to override in a child theme.
	 *
	 * @since 1.0
	 */
	function themename_entry_category_date() {
		$meta = '<div class="entry-meta">';

		$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'themename' ), '</span>' );

		if ( 'jetpack-portfolio' === get_post_type() ) {
			$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="screen-reader-text">Categories: </span>', 'Used before category names.', 'themename' ) ),
				$portfolio_categories_list
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'themename' ) );
		if ( $categories_list && themename_categorized_blog() ) {
			$meta .= sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="screen-reader-text">Categories: </span>', 'Used before category names.', 'themename' ) ),
				$categories_list
			);
		}

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$meta .= sprintf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( __( '<span class="date-label">Posted on </span>', 'themename' ) ),
			esc_url( get_permalink() ),
			$time_string
		);

		$meta .= '</div><!-- .entry-meta -->';

		return $meta;
	}
endif;

if ( ! function_exists( 'themename_categorized_blog' ) ) :
	/**
	 * Determines whether blog/site has more than one category.
	 *
	 * Create your own themename_categorized_blog() function to override in a child theme.
	 *
	 * @since 1.0
	 *
	 * @return bool True if there is more than one category, false otherwise.
	 */
	function themename_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'themename_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'themename_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so themename_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so themename_categorized_blog should return false.
			return false;
		}
	}
endif;

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action themename_footer
 *
 * @since 1.0
 */
function themename_footer_content() {
	$theme_data = wp_get_theme();

	$footer_content = sprintf( _x( 'Copyright &copy; %1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'themename' ), '[the-year]', '[site-link]', '[privacy-policy-link]' ) . '<span class="sep"> | </span>' . esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'themename' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>';

	if ( ! $footer_content ) {
		// Bail early if footer content is empty
		return;
	}

	$search  = array( '[the-year]', '[site-link]', '[privacy-policy-link]' );
	$replace = array( esc_attr( date_i18n( __( 'Y', 'themename' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link() : '' );

	$footer_content = str_replace( $search, $replace, $footer_content );

	echo '<div class="site-info">' . $footer_content . '</div><!-- .site-info -->';
}
add_action( 'themename_credits', 'themename_footer_content', 10 );

if ( ! function_exists( 'themename_single_image' ) ) :
	/**
	 * Display Single Page/Post Image
	 */
	function themename_single_image() {
		global $post, $wp_query;

		if ( is_attachment() ) {
			$parent = $post->post_parent;
			$metabox_feat_img = get_post_meta( $parent, 'themename-featured-image', true );
		} else {
			$metabox_feat_img = get_post_meta( $post->ID, 'themename-featured-image', true );
		}

		if ( empty( $metabox_feat_img ) || ! is_singular() ) {
			$metabox_feat_img = 'default';
		}

		$featured_image = 'disabled';

		if ( ( 'disabled' == $metabox_feat_img  || ! has_post_thumbnail() || ( 'default' == $metabox_feat_img && 'disabled' == $featured_image ) ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $metabox_feat_img ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $metabox_feat_img;
				$featured_image = $metabox_feat_img;
			}

			?>
			<figure class="entry-image <?php echo esc_attr( $class ); ?>">
                <?php the_post_thumbnail( $featured_image ); ?>
	        </figure>
	   	<?php
		}
	}
endif; // themename_single_image.

if ( ! function_exists( 'themename_archive_image' ) ) :
	/**
	 * Display Post Archive Image
	 */
	function themename_archive_image() {
		if ( ! has_post_thumbnail() ) {
			// Bail if there is no featured image.
			return;
		}

		themename_post_thumbnail();
	}
endif; // themename_archive_image.

if ( ! function_exists( 'themename_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function themename_comment( $comment, $args, $depth ) {
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'themename' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'themename' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div><!-- .comment-author -->

				<div class="comment-container">
					<header class="comment-meta">
						<?php printf( __( '%s <span class="says screen-reader-text">says:</span>', 'themename' ), sprintf( '<cite class="fn author-name">%s</cite>', get_comment_author_link() ) ); ?>

						<a class="comment-permalink entry-meta" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php echo themename_get_svg( array( 'icon' => 'clock-o' ) ); ?>
						<time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%s ago', 'themename' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
					<?php edit_comment_link( esc_html__( 'Edit', 'themename' ), '<span class="edit-link">', '</span>' ); ?>
					</header><!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'themename' ); ?></p>
					<?php endif; ?>

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>',
						) ) );
					?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
		<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>

		<?php
		endif;
	}
endif; // ends check for themename_comment()

if ( ! function_exists( 'themename_slider_entry_category' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own themename_entry_category_date() function to override in a child theme.
 *
 * @since 1.0
 */
function themename_slider_entry_category() {
	$meta = '<div class="entry-meta">';

	$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', '', '</span>' );

	if ( 'jetpack-portfolio' === get_post_type( ) ) {
		$meta .= sprintf( '<span class="cat-links">' .'<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			sprintf( _x( 'Categories', 'Used before category names.', 'themename' ) ),
			$portfolio_categories_list
		);
	}

	$categories_list = get_the_category_list( ' ' );
	if ( $categories_list && themename_categorized_blog( ) ) {
		$meta .= sprintf( '<span class="cat-links">' . '<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			sprintf( _x( 'Categories', 'Used before category names.', 'themename' ) ),
			$categories_list
		);
	}

	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}
endif;

if ( ! function_exists( 'themename_entry_date_author' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own themename_entry_category_date() function to override in a child theme.
 *
 * @since 1.0
 */
function themename_entry_date_author() {
	$meta = '<div class="entry-meta">';

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$meta .= sprintf( '<span class="posted-on screen-reader-text">%3$s' . '<span class="date-label screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%4$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'themename' ),
		esc_url( get_permalink() ),
		esc_html__( 'Posted on ', 'themename' ),
		$time_string
	);

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="author-label screen-reader-text">By </span>%s', 'themename' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	$meta .= sprintf( '<span class="byline">%1$s%2$s</span>',
		esc_html__( ' By ', 'themename' ),
		$byline
	 );


	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}
endif;

if ( ! function_exists( 'themename_entry_category' ) ) :
	/**
	 * Prints HTML with meta information for the category.
	 */
	function themename_entry_category( $echo = true ) {
		$output = '';

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ' ' );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'themename' ) ),
					$categories_list
				); // WPCS: XSS OK.
			}
		}

		if ( 'ect-service' === get_post_type() || 'featured-content' === get_post_type() || 'jetpack-portfolio' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$term_list = get_the_term_list( get_the_ID(), get_post_type() . '-type' );
			if ( $term_list ) {
				/* translators: 1: list of categories. */
				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'themename' ) ),
					$term_list
				); // WPCS: XSS OK.
			}
		}

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}
endif;

if ( ! function_exists( 'themename_events_cat_list' ) ) :
	/**
	 * Prints HTML with meta information for the categories
	 */
	function themename_events_cat_list( $echo = true ) {
		$icon = '';
		$output = '';

		if( get_theme_mod( 'themename_blog_meta_icon', 0 ) ) {
			$icon = '<i class="fa fa-folder-open" aria-hidden="true"></i>';
		}

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_category_list( esc_html__( ', ', 'themename' ) );
			if ( $categories_list ) :
				$output = '<span class="cat-links">' . $icon  .  $categories_list . '</span>';
			endif;
		}

		if ( ! $echo ) {
			return $output;
		}

		echo $output;
	}
endif;

if ( ! function_exists( 'themename_content_display' ) ) :
	/**
	 * Displays excerpt, content or nothing according to option.
	 */
	function themename_content_display( $show_content, $echo = true ) {
		$output = '';

		if ( $echo ) {
			if ( 'excerpt' === $show_content ) {
				?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
				<?php
			} elseif ( 'full-content' === $show_content ) {
				?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
			}

			return;
		} else {
			if ( 'excerpt' === $show_content ) {
				$output = '<div class="entry-summary"><p>'. get_the_excerpt() . '</p></div>';
			} elseif ( 'full-content' === $show_content ) {
				$output = '<div class="entry-content">'. get_the_content() . '</div>';
			}
		}

		return wp_kses_post( $output );
	}
endif;

if ( ! function_exists( 'themename_category_count_span' ) ) :
	/**
	 * Used to wrap post count in Categories widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function themename_category_count_span($links) {
		$links = str_replace('</a> (', '</a> <span class="counts">', $links);
		$links = str_replace(')', '</span>', $links);
		return $links;
	}
	add_filter( 'wp_list_categories', 'themename_category_count_span' );
endif;

if ( ! function_exists( 'themename_archives_count_span' ) ) :
	/**
	 * Used to wrap post count in Archives widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function themename_archives_count_span($links) {
		$links = str_replace('</a>&nbsp;(', '</a> <span class="counts">', $links);
		$links = str_replace(')', '</span>', $links);
		return $links;
	}
	add_filter( 'get_archives_link', 'themename_archives_count_span' );
endif;





if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
