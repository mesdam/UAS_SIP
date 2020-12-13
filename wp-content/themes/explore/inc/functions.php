<?php
/**
 * Explore functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package    ThemeGrill
 * @subpackage Explore
 * @since      Explore 1.0
 */

/****************************************************************************************/

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'explore_fonts_url' ) ) {
	// Using google font
	// creating the function for adding the google font url
	function explore_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';
		// applying the translators for the Google Fonts used
		/* Translators: If there are characters in your language that are not
		 * supported by PT Sans, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		if ( 'off' !== _x( 'on', 'PT Sans font: on or off', 'explore' ) ) {
			$fonts[] = 'PT Sans';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'cyrillic'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (cyrillic)', 'explore' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}

		// Ready to enqueue Google Font
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
}
// completion of enqueue for the google font

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'explore_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function explore_scripts_styles_method() {
	// defining the script to load the minified version of js and css file if 'SCRIPT_DEBUG' is set to true
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/**
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'explore_style', get_stylesheet_uri() );

	// use of enqueued google fonts
	wp_enqueue_style( 'explore-google-fonts', explore_fonts_url(), array(), null );

	if ( get_theme_mod( 'explore_color_skin', 'light' ) == 'dark' ) {
		wp_enqueue_style( 'explore_dark_style', EXPLORE_CSS_URL . '/dark' . $suffix . '.css' );
	}

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Enqueue Slider setup js file.
	 */
	if ( is_front_page() && get_theme_mod( 'explore_activate_slider', '0' ) == '1' ) {
		wp_enqueue_script( 'explore-bxslider', EXPLORE_JS_URL . '/jquery.bxslider/jquery.bxslider' . $suffix . '.js', array( 'jquery' ), '4.1.2', true );
	}

	// enqueueing stickyjs for sticky primary menu
	if ( get_theme_mod( 'explore_sticky_menu_activate', '1' ) == 1 ) {
		wp_enqueue_script( 'explore-stickyjs', EXPLORE_JS_URL . '/stickyjs/jquery.sticky' . $suffix . '.js', array( 'jquery' ), false, true );
	}

	// enqueueing fitvids for responsive videos
	wp_enqueue_script( 'explore-fitvids', EXPLORE_JS_URL . '/fitvids/jquery.fitvids' . $suffix . '.js', array( 'jquery' ), false, true );

	// enqueueing navigation file
	wp_enqueue_script( 'explore-navigation', EXPLORE_JS_URL . '/navigation' . $suffix . '.js', array( 'jquery' ), false, true );

	// Skip link focus fix JS enqueue.
	wp_enqueue_script( 'explore-skip-link-focus-fix', EXPLORE_JS_URL . '/skip-link-focus-fix.js', array(), false, true );

	// enqueueing explore theme custom js file
	wp_enqueue_script( 'explore-custom', EXPLORE_JS_URL . '/explore-custom' . $suffix . '.js', array( 'jquery' ) );

	// enqueueing fontawesome icons
	wp_enqueue_style( 'explore-fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.4.0' );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.7.3', false );
	wp_script_add_data( 'html5shiv', 'conditional', 'lte IE 8' );

}

/****************************************************************************************/

/**
 * Enqueuing js for image uploader in service alternate widget
 */
add_action( 'admin_enqueue_scripts', 'explore_service_widget_alternate' );

function explore_service_widget_alternate( $hook ) {
	// defining the script to load the minified version of js and css file if 'SCRIPT_DEBUG' is set to true
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	if ( $hook == 'widgets.php' || $hook == 'customize.php' ) {
		// enqueueing the image upload script
		wp_enqueue_media();
		wp_enqueue_script( 'explore_service_widget_alternate', get_template_directory_uri() . '/js/image_uploader' . $suffix . '.js', false, '1.0', true );
	}

}

/****************************************************************************************/

add_filter( 'excerpt_length', 'explore_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function explore_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_more', 'explore_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function explore_continue_reading() {
	return '';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function explore_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
		'size' => 'medium',
	), $atts );

	$out['size'] = $atts['size'];

	return $out;

}

add_filter( 'shortcode_atts_gallery', 'explore_gallery_atts', 10, 3 );

/****************************************************************************************/

if ( ! function_exists( 'explore_sidebar_layout' ) ) :
	/**
	 * Select and show sidebar based on post meta and customizer default settings
	 */
	function explore_sidebar_layout() {
		global $post;

		$layout = get_theme_mod( 'explore_default_layout', 'both_sidebar' );

		// Get Layout meta for posts
		if ( $post ) {
			$layout_meta = get_post_meta( $post->ID, 'explore_page_layout', true );
		}

		// Home page if Posts page is assigned
		if ( is_home() && ! ( is_front_page() ) ) {
			$queried_id  = get_option( 'page_for_posts' );
			$layout_meta = get_post_meta( $queried_id, 'explore_page_layout', true );

			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		} elseif ( is_page() ) {
			$layout = get_theme_mod( 'explore_pages_default_layout', 'both_sidebar' );
			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		} elseif ( is_single() ) {
			$layout = get_theme_mod( 'explore_single_posts_default_layout', 'both_sidebar' );
			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		}

		return $layout;
	}
endif;

/****************************************************************************************/

add_filter( 'body_class', 'explore_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function explore_body_class( $classes ) {
	global $post;

	if ( $post ) {
		$layout_meta = get_post_meta( $post->ID, 'explore_page_layout', true );
	}

	if ( is_home() ) {
		$queried_id  = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'explore_page_layout', true );
	}

	if ( empty( $layout_meta ) || is_archive() || is_search() ) {
		$layout_meta = 'default_layout';
	}
	$explore_default_layout = get_theme_mod( 'explore_default_layout', 'both_sidebar' );

	$explore_default_page_layout = get_theme_mod( 'explore_pages_default_layout', 'both_sidebar' );
	$explore_default_post_layout = get_theme_mod( 'explore_single_posts_default_layout', 'both_sidebar' );

	if ( $layout_meta == 'default_layout' ) {
		if ( is_page() ) {
			$classes[] = $explore_default_page_layout;
		} elseif ( is_single() ) {
			$classes[] = $explore_default_post_layout;
		} else {
			$classes[] = $explore_default_layout;
		}
	} else {
		$classes[] = $layout_meta;
	}

	if ( is_home() || is_archive() ) {
		if ( get_theme_mod( 'explore_archive_display_type', 'blog_medium' ) == 'blog_medium_alternate' ) {
			$classes[] = 'blog-alternate-medium';
		}
		if ( get_theme_mod( 'explore_archive_display_type', 'blog_medium' ) == 'blog_medium' ) {
			$classes[] = 'blog-medium';
		}
	}

	if ( get_theme_mod( 'explore_site_layout', 'wide_layout' ) == 'wide_layout' ) {
		$classes[] = 'wide';
	} elseif ( get_theme_mod( 'explore_site_layout', 'wide_layout' ) == 'boxed_layout' ) {
		$classes[] = 'boxed';
	} else {
		$classes[] = '';
	}
	if ( get_theme_mod( 'explore_new_menu', '0' ) == 1 ) {
		$classes[] = 'better-responsive-menu';
	}

	return $classes;
}

/****************************************************************************************/

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function explore_darkcolor( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( - 255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color  = hexdec( $color ); // Convert to decimal
		$color  = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

/****************************************************************************************/

add_action( 'wp_head', 'explore_custom_css', 100 );
/**
 * Hooks the Custom Internal CSS to head section
 */
function explore_custom_css() {
	$primary_color        = get_theme_mod( 'explore_primary_color', '#4cb0c6' );
	$primary_dark         = explore_darkcolor( $primary_color, - 50 );
	$explore_internal_css = '';
	if ( $primary_color != '#4cb0c6' ) {
		$explore_internal_css = ' #controllers a.active,#controllers a:hover,.comments-area .comment-author-link span,.explore-button,.fa.header-widget-controller,.pagination span,.post .entry-meta .read-more-link,.social-links i.fa:hover,a#scroll-up,button,input[type=reset],input[type=button],input[type=submit]{background-color:' . $primary_color . '}#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,#content .comments-area article header cite a:hover,#controllers a.active,#controllers a:hover,#featured-wide-slider .slider-title-head .entry-title a:hover,#site-title a:hover,#wp-calendar #today,.comment .comment-reply-link:hover,.comments-area .comment-author-link a:hover,.footer-widgets-area a:hover,.main-navigation a:hover,.main-navigation li.menu-item-has-children:hover>a:after,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item a:after,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a,.more-link,.nav-next a:hover,.nav-previous a:hover,.next a:hover,.page .entry-title a:hover,.pagination a span:hover,.post .entry-meta a:hover,.post .entry-title a:hover,.previous a:hover,.read-more,.services-page-title a:hover,.single #content .tags a:hover,.slide-next i,.slide-prev i,.social-links i.fa,.type-page .entry-meta a:hover,a,.better-responsive-menu .menu li:hover .sub-toggle .fa{color:' . $primary_color . '}blockquote{border-left:3px solid ' . $primary_color . '}#header-text-nav-container{border-top:2px solid ' . $primary_color . '}.social-links i.fa{border:1px solid ' . $primary_color . '}#featured-wide-slider .slider-read-more-button a.slider-first-button,#featured-wide-slider .slider-read-more-button a.slider-second-button:hover{border:2px solid ' . $primary_color . ';background-color:' . $primary_color . '}a.slide-next,a.slide-prev{border:2px solid ' . $primary_color . '}.breadcrumb a,.tg-one-fourth .widget-title a:hover,.tg-one-half .widget-title a:hover,.tg-one-third .widget-title a:hover{color:' . $primary_color . '}.pagination a span:hover{border-color:' . $primary_color . '}.header-widgets-wrapper,.widget-title span{border-bottom:2px solid ' . $primary_color . '}@media screen and (max-width: 767px){.better-responsive-menu .menu li .sub-toggle, .better-responsive-menu .menu li ul li .sub-toggle {background-color:' . $primary_color . '}.better-responsive-menu .menu li .sub-toggle:hover { background-color:' . $primary_dark . '}.menu-toggle:before{color:' . $primary_color . '}}';
	}

	if ( ! empty( $explore_internal_css ) ) {
		?>
		<style type="text/css"><?php echo $explore_internal_css; ?></style>
		<?php
	}

	$explore_custom_css = get_theme_mod( 'explore_custom_css' );
	if ( $explore_custom_css && ! function_exists( 'wp_update_custom_css_post' ) ) {
		?>
		<style type="text/css"><?php echo $explore_custom_css; ?></style>
		<?php
	}
}

/**************************************************************************************/

if ( ! function_exists( 'explore_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable
	 */
	function explore_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

		?>
		<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
			<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'explore' ); ?></h3>

			<?php if ( is_single() ) : // navigation links for single posts ?>

				<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'explore' ) . '</span> %title' ); ?>
				<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'explore' ) . '</span>' ); ?>

			<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

				<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'explore' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'explore' ) ); ?></div>
				<?php endif; ?>

			<?php endif; ?>

		</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
		<?php
	}
endif; // explore_content_nav

/**************************************************************************************/

if ( ! function_exists( 'explore_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function explore_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'explore' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'explore' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
						echo get_avatar( $comment, 74 );
						printf( '<div class="comment-author-link">%1$s%2$s</div>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'explore' ) . '</span>' : ''
						);
						printf( '<div class="comment-date-time">%1$s</div>',
							sprintf( __( '%1$s at %2$s', 'explore' ), get_comment_date(), get_comment_time() )
						);
						printf( __( '<a class="comment-permalink" href="%1$s">Permalink</a>', 'explore' ), esc_url( get_comment_link( $comment->comment_ID ) ) );
						edit_comment_link();
						?>
					</header><!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'explore' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => __( 'Reply', 'explore' ),
							'after'      => '',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						) ) ); ?>
					</section><!-- .comment-content -->

				</article><!-- #comment-## -->
				<?php
				break;
		endswitch; // end comment_type check
	}
endif;

/**************************************************************************************/

add_action( 'explore_footer_copyright', 'explore_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'explore_footer_copyright' ) ) :
	function explore_footer_copyright() {
		$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';

		$wp_link = '<a href="' . esc_url( 'https://wordpress.org' ) . '" target="_blank" title="' . esc_attr__( 'WordPress', 'explore' ) . '"><span>' . __( 'WordPress', 'explore' ) . '</span></a>';

		$tg_link = '<a href="' . esc_url( 'https://themegrill.com/themes/explore' ) . '" target="_blank" title="' . esc_attr__( 'ThemeGrill', 'explore' ) . '" rel="author"><span>' . __( 'ThemeGrill', 'explore' ) . '</span></a>';

		$default_footer_value = sprintf( __( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'explore' ), date( 'Y' ), $site_link ) . '<br>' . sprintf( __( 'Powered by %s.', 'explore' ), $wp_link ) . ' ' . sprintf( __( 'Theme: %1$s by %2$s.', 'explore' ), 'Explore', $tg_link );

		$explore_footer_copyright = '<div class="copyright">' . $default_footer_value . '</div>';
		echo $explore_footer_copyright;
	}
endif;

/**************************************************************************************/

if ( ! function_exists( 'explore_posts_listing_display_type_select' ) ) :
	/**
	 * Function to select the posts listing display type
	 */
	function explore_posts_listing_display_type_select() {
		if ( is_home() || is_archive() ) {
			if ( get_theme_mod( 'explore_archive_display_type', 'blog_medium' ) == 'blog_large' ) {
				$format = 'blog-image-large';
			} elseif ( get_theme_mod( 'explore_archive_display_type', 'blog_medium' ) == 'blog_medium' || get_theme_mod( 'explore_archive_display_type', 'blog_large' ) == 'blog_medium_alternate' ) {
				$format = 'blog-image-medium';
			} elseif ( get_theme_mod( 'explore_archive_display_type', 'blog_medium' ) == 'blog_full_content' ) {
				$format = 'blog-full-content';
			}
		} elseif ( is_front_page() && ! is_home() ) {
			$format = 'page';
		} else {
			$format = get_post_format();
		}

		return $format;
	}
endif;

/****************************************************************************************/

/*
 * Creating Social Menu
 */

if ( ! function_exists( 'explore_social_menu' ) ) {
	function explore_social_menu() {
		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => 'menu-social',
					'container_class' => 'explore-social-menu',
					'depth'           => 1,
					'fallback_cb'     => false,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
				)
			);
		}
	}
}

/****************************************************************************************/

/*
 * Display the related posts
 */
if ( ! function_exists( 'explore_related_posts_function' ) ) {

	function explore_related_posts_function() {
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => 3,
		);
		// Related by categories
		if ( get_theme_mod( 'explore_related_posts', 'categories' ) == 'categories' ) {

			$cats = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $cats ) {
				$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
				$args['category__in'] = $cats;
			} else {
				$args['cat'] = $cats;
			}
		}
		// Related by tags
		if ( get_theme_mod( 'explore_related_posts', 'categories' ) == 'tags' ) {

			$tags = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $tags ) {
				$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
				$args['tag__in'] = $tags;
			} else {
				$args['tag_slug__in'] = explode( ',', $tags );
			}
			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query;

		return $query;
	}

}

/****************************************************************************************/

/*
 * Creating responsive video for posts/pages
 */
if ( ! function_exists( 'explore_responsive_video' ) ) :
	function explore_responsive_video( $html, $url, $attr, $post_ID ) {
		return '<div class="fitvids-video">' . $html . '</div>';
	}

	add_filter( 'embed_oembed_html', 'explore_responsive_video', 10, 4 );
endif;

/****************************************************************************************/

/*
 * Function to call the meta left side of the posts
 */
if ( ! function_exists( 'explore_beside_entry_meta' ) ) :
	function explore_beside_entry_meta() { ?>
		<div class="blog-date-comment-wrapper">
			<i class="fa fa-calendar-o"></i>
			<div class="date-day"><?php the_time( 'j' ); ?></div>
			<div class="date-month"><span><?php the_time( 'M' ); ?></span></div>
			<div class="date-year"><?php the_time( 'Y' ); ?></div>

			<?php
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
			}
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);
			printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>', 'explore' ),
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				$time_string
			);
			?>

			<?php if ( ! post_password_required() && comments_open() ) { ?>
				<div class="comments-link"><?php comments_popup_link( __( '0 <i class="fa fa-comment"></i>', 'explore' ), __( '1 <i class="fa fa-comment"></i>', 'explore' ), __( '% <i class="fa fa-comments"></i>', 'explore' ) ); ?></div>
			<?php } ?>

			<?php edit_post_link( '<i class="fa fa-pencil"></i>&nbsp;' . __( 'Edit', 'explore' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	<?php }
endif;

/****************************************************************************************/

add_filter( 'the_content', 'explore_add_mod_hatom_data' );
// Adding the support for the entry-title tag for Google Rich Snippets
function explore_add_mod_hatom_data( $content ) {
	$title = get_the_title();
	if ( is_single() ) {
		$content .= '<div class="extra-hatom-entry-title"><span class="entry-title">' . $title . '</span></div>';
	}

	return $content;
}

/****************************************************************************************/

/*
 * Function to call the meta of the posts
 */
if ( ! function_exists( 'explore_entry_meta' ) ) :
	function explore_entry_meta() {
		if ( 'post' == get_post_type() ) : ?>
			<footer class="entry-meta-bar clearfix">
				<div class="entry-meta clearfix">
					<span class="by-author author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
					<span class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
					<?php if ( has_category() ) { ?>
						<span class="category"><?php the_category( ', ' ); ?></span>
					<?php } ?>
					<?php if ( comments_open() ) { ?>
						<span class="comments"><?php comments_popup_link( __( 'No Comments', 'explore' ), __( '1 Comment', 'explore' ), __( '% Comments', 'explore' ), '', __( 'Comments Off', 'explore' ) ); ?></span>
					<?php } ?>
					<?php edit_post_link( __( 'Edit', 'explore' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
			</footer>
		<?php endif;
	}
endif;

/**
 * Making the theme Woocommrece compatible
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action( 'woocommerce_before_main_content', 'explore_wrapper_start', 10 );
add_action( 'woocommerce_before_main_content', 'explore_inner_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'explore_inner_wrapper_end', 10 );
add_action( 'woocommerce_sidebar', 'explore_wrapper_end', 10 );

function explore_wrapper_start() {
	echo '<div class="inner-wrap">';
}

function explore_inner_wrapper_start() {
	echo '<div id="primary"><div id="content" class="clearfix">';
}

function explore_inner_wrapper_end() {
	echo '</div>';
	$layout = explore_sidebar_layout();
	if ( $layout == "both_sidebar" ) {
		get_sidebar( 'left' );
	}
	echo '</div>';
}

function explore_wrapper_end() {
	$layout = explore_sidebar_layout();
	if ( $layout != "no_sidebar_full_width" && $layout != "no_sidebar_content_centered" ) {
		get_sidebar();
	}
	echo '</div>';
}

// Displays the site logo
if ( ! function_exists( 'explore_the_custom_logo' ) ) {
	/**
	 * Displays the optional custom logo.
	 */
	function explore_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
}

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function explore_custom_css_migrate() {

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'explore_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'explore_custom_css' );
			}
		}
	}
}

add_action( 'after_setup_theme', 'explore_custom_css_migrate' );

if ( ! function_exists( 'explore_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function explore_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'explore_pingback_header' );

/**
 * Compare user's current version of plugin.
 */
if ( ! function_exists( 'explore_plugin_version_compare' ) ) {
	function explore_plugin_version_compare( $plugin_slug, $version_to_compare ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$installed_plugins = get_plugins();

		// Plugin not installed.
		if ( ! isset( $installed_plugins[ $plugin_slug ] ) ) {
			return false;
		}

		$tdi_user_version = $installed_plugins[ $plugin_slug ]['Version'];

		return version_compare( $tdi_user_version, $version_to_compare, '<' );
	}
}
