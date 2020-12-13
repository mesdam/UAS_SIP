<?php
/**
 * Explore functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 540;

/**
 * $content_width global variable adjustment as per layout option.
 */
function explore_content_width() {
   global $post;
   global $content_width;

   if( $post ) { $layout_meta = get_post_meta( $post->ID, 'explore_page_layout', true ); }
   if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
   $explore_default_layout = get_theme_mod( 'explore_default_layout', 'both_sidebar' );

   if( $layout_meta == 'default_layout' ) {
      if ( $explore_default_layout == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
      elseif ( ( $explore_default_layout == 'right_sidebar' ) || ( $explore_default_layout == 'left_sidebar' ) ) { $content_width = 840; /* pixels */ }
      else { $content_width = 540; /* pixels */ }
   }
   elseif ( $layout_meta == 'no_sidebar_full_width' ) { $content_width = 1140; /* pixels */ }
   elseif ( ( $layout_meta == 'right_sidebar' ) || ( $layout_meta == 'left_sidebar' ) ) { $content_width = 840; /* pixels */ }
   else { $content_width = 540; /* pixels */ }
}
add_action( 'template_redirect', 'explore_content_width' );

add_action( 'after_setup_theme', 'explore_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'explore_setup' ) ) :
function explore_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'explore', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );

	// Added WooCommerce support.
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

	// Adds the support for the Custom Logo introduced in WordPress 4.5
	add_theme_support( 'custom-logo', array(
		'flex-width' => true,
		'flex-height' => true,
	));

	// Gutenberg wide layout support.
   add_theme_support( 'align-wide' );

   // Gutenberg block layout support.
   add_theme_support( 'wp-block-styles' );

   // Gutenberg editor support.
   add_theme_support( 'responsive-embeds' );


	// Registering navigation menus.
   register_nav_menus( array(
      'social' => esc_html__( 'Social Menu', 'explore' ),
      'primary' => esc_html__( 'Primary Menu', 'explore' ),
      'footer' => esc_html__( 'Footer Menu', 'explore' ),
   ) );

	// Cropping the images to different sizes to be used in the theme
	add_image_size( 'explore-featured-blog-medium', 270, 270, true );
	add_image_size( 'explore-featured', 750, 310, true );
   add_image_size( 'explore-services', 360, 240, true );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'explore_custom_background_args', array(
		'default-color' => 'f0f0f0'
	) ) );

   /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
   add_theme_support('title-tag');

   // Enable support for Post Formats.
   add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'chat', 'audio', 'status' ) );

   /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support('html5', array(
       'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
   ));

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}
endif;

/**
 * Enqueue block editor styles.
 *
 * @since Explore 1.1.3
 */
function explore_block_editor_styles() {
	wp_enqueue_style( 'explore-editor-googlefonts', '//fonts.googleapis.com/css2?family=PT+Sans' );
	wp_enqueue_style( 'explore-block-editor-styles', get_template_directory_uri() . '/style-editor-block.css' );
}

add_action( 'enqueue_block_editor_assets', 'explore_block_editor_styles', 1, 1 );
/**
 * Define Directory Location Constants
 */
define( 'EXPLORE_PARENT_DIR', get_template_directory() );
define( 'EXPLORE_CHILD_DIR', get_stylesheet_directory() );

define( 'EXPLORE_INCLUDES_DIR', EXPLORE_PARENT_DIR. '/inc' );
define( 'EXPLORE_CSS_DIR', EXPLORE_PARENT_DIR . '/css' );
define( 'EXPLORE_JS_DIR', EXPLORE_PARENT_DIR . '/js' );
define( 'EXPLORE_LANGUAGES_DIR', EXPLORE_PARENT_DIR . '/languages' );

define( 'EXPLORE_ADMIN_DIR', EXPLORE_INCLUDES_DIR . '/admin' );
define( 'EXPLORE_WIDGETS_DIR', EXPLORE_INCLUDES_DIR . '/widgets' );

define( 'EXPLORE_ADMIN_IMAGES_DIR', EXPLORE_ADMIN_DIR . '/images' );
define( 'EXPLORE_ADMIN_CSS_DIR', EXPLORE_ADMIN_DIR . '/css' );


/**
 * Define URL Location Constants
 */
define( 'EXPLORE_PARENT_URL', get_template_directory_uri() );
define( 'EXPLORE_CHILD_URL', get_stylesheet_directory_uri() );

define( 'EXPLORE_INCLUDES_URL', EXPLORE_PARENT_URL. '/inc' );
define( 'EXPLORE_CSS_URL', EXPLORE_PARENT_URL . '/css' );
define( 'EXPLORE_JS_URL', EXPLORE_PARENT_URL . '/js' );
define( 'EXPLORE_LANGUAGES_URL', EXPLORE_PARENT_URL . '/languages' );

define( 'EXPLORE_ADMIN_URL', EXPLORE_INCLUDES_URL . '/admin' );
define( 'EXPLORE_WIDGETS_URL', EXPLORE_INCLUDES_URL . '/widgets' );

define( 'EXPLORE_ADMIN_IMAGES_URL', EXPLORE_ADMIN_URL . '/images' );
define( 'EXPLORE_ADMIN_CSS_URL', EXPLORE_ADMIN_URL . '/css' );

/** Load functions */
require_once( EXPLORE_INCLUDES_DIR . '/custom-header.php' );
require_once( EXPLORE_INCLUDES_DIR . '/functions.php' );
require_once( EXPLORE_INCLUDES_DIR . '/customizer.php' );
require_once( EXPLORE_INCLUDES_DIR . '/header-functions.php' );

require_once( EXPLORE_ADMIN_DIR . '/meta-boxes.php' );

/** Load Widgets and Widgetized Area */
require_once( EXPLORE_WIDGETS_DIR . '/widgets.php' );

/**
 * Assign the Explore version to a variable.
 */
$explore_theme = wp_get_theme( 'explore' );

define( 'EXPLORE_THEME_VERSION', $explore_theme->get( 'Version' ) );

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require( EXPLORE_ADMIN_DIR . '/class-explore-admin.php' );
	require( EXPLORE_ADMIN_DIR . '/class-explore-welcome-notice.php' );
	require( EXPLORE_ADMIN_DIR . '/class-explore-dashboard.php' );
	require( EXPLORE_ADMIN_DIR . '/class-explore-theme-review-notice.php' );
}
