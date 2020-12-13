<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>

<?php
$explore_class = "secondary";
$sidebar = 'explore_right_sidebar';
$sidebar_display = __( 'Right', 'explore' );

$layout = explore_sidebar_layout();
if ( $layout == "left_sidebar" )   {
	$explore_class = "tertiary";
	$sidebar = 'explore_left_sidebar';
	$sidebar_display = __( 'Left', 'explore' );
}
?>

<div id="<?php echo $explore_class ?>">
	<?php do_action( 'explore_before_sidebar' );

	if( is_page_template( 'page-templates/contact.php' ) ) {
		$sidebar = 'explore_contact_page_sidebar';
		$sidebar_display = __('Contact Page', 'explore');
	}

	if ( ! dynamic_sidebar( $sidebar ) ) :

      the_widget( 'WP_Widget_Text',
         array(
            'title'  => __( 'Example Widget', 'explore' ),
            'text'   => sprintf( __( 'This is an example widget to show how the %s sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets are added then this will be replaced by those widgets.', 'explore' ), $sidebar_display, current_user_can( 'edit_theme_options' ) ? '<a href="' . esc_url( admin_url( 'widgets.php' ) ). '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
            'filter' => true,
         ),
         array(
            'before_widget' => '<section class="widget widget_text">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
         )
      );
	endif;

	do_action( 'explore_after_sidebar' ); ?>
</div>