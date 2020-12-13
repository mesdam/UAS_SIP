<?php
/**
 * The left sidebar widget area.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>

<div id="tertiary">
	<?php do_action( 'explore_before_sidebar' );

	if ( ! dynamic_sidebar( 'explore_left_sidebar' ) ) :

      the_widget( 'WP_Widget_Text',
         array(
            'title'  => __( 'Example Widget', 'explore' ),
            'text'   => sprintf( __( 'This is an example widget to show how the Left sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets are added then this will be replaced by those widgets.', 'explore' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
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