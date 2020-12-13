<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

add_action( 'widgets_init', 'explore_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function explore_widgets_init() {

	// Registering main right sidebar
	register_sidebar( array(
		'name' 				=> __( 'Right Sidebar', 'explore' ),
		'id' 					=> 'explore_right_sidebar',
		'description'   	=> __( 'Shows widgets at Right side.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering main left sidebar
	register_sidebar( array(
		'name' 				=> __( 'Left Sidebar', 'explore' ),
		'id' 					=> 'explore_left_sidebar',
		'description'   	=> __( 'Shows widgets at Left side.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering Header sidebar one
	register_sidebar( array(
		'name' 				=> __( 'Header Sidebar One', 'explore' ),
		'id' 					=> 'explore_header_sidebar_one',
		'description'   	=> __( 'Shows widgets in header section one.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

   // Registering Header sidebar two
   register_sidebar( array(
      'name'            => __( 'Header Sidebar Two', 'explore' ),
      'id'              => 'explore_header_sidebar_two',
      'description'     => __( 'Shows widgets in header section two.', 'explore' ),
      'before_widget'   => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'    => '</aside>',
      'before_title'    => '<h3 class="widget-title"><span>',
      'after_title'     => '</span></h3>'
   ) );

   // Registering Header sidebar three
   register_sidebar( array(
      'name'            => __( 'Header Sidebar Three', 'explore' ),
      'id'              => 'explore_header_sidebar_three',
      'description'     => __( 'Shows widgets in header section three.', 'explore' ),
      'before_widget'   => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'    => '</aside>',
      'before_title'    => '<h3 class="widget-title"><span>',
      'after_title'     => '</span></h3>'
   ) );

   // Registering front page sidebar area
   register_sidebar( array(
      'name'            => __( 'Business Sidebar', 'explore' ),
      'id'              => 'explore_business_page_sidebar',
      'description'     => __( 'Shows widgets in the business sidebar page area.', 'explore' ),
      'before_widget'   => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'    => '</aside>',
      'before_title'    => '<h3 class="widget-title">',
      'after_title'     => '</h3>'
   ) );

	// Registering contact Page sidebar
	register_sidebar( array(
		'name' 				=> __( 'Contact Page Sidebar', 'explore' ),
		'id' 					=> 'explore_contact_page_sidebar',
		'description'   	=> __( 'Shows widgets on Contact Page Template.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering Error 404 Page sidebar
	register_sidebar( array(
		'name' 				=> __( 'Error 404 Page Sidebar', 'explore' ),
		'id' 					=> 'explore_error_404_page_sidebar',
		'description'   	=> __( 'Shows widgets on Error 404 page.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar one
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar One', 'explore' ),
		'id' 					=> 'explore_footer_sidebar_one',
		'description'   	=> __( 'Shows widgets at footer sidebar one.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar two
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Two', 'explore' ),
		'id' 					=> 'explore_footer_sidebar_two',
		'description'   	=> __( 'Shows widgets at footer sidebar two.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar three
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Three', 'explore' ),
		'id' 					=> 'explore_footer_sidebar_three',
		'description'   	=> __( 'Shows widgets at footer sidebar three.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering footer sidebar four
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Four', 'explore' ),
		'id' 					=> 'explore_footer_sidebar_four',
		'description'   	=> __( 'Shows widgets at footer sidebar four.', 'explore' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	register_widget('explore_services_widget');
}

/****************************************************************************************/

/**
 * Featured service widget to show pages.
 */
class explore_services_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_service_block', 'description' => __( 'Display some of the pages as services.', 'explore' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Services', 'explore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
 		for ( $i=0; $i<6; $i++ ) {
 			$var = 'page_id'.$i;
 			$defaults[$var] = '';
 		}
 		$instance = wp_parse_args( (array) $instance, $defaults );
 		for ( $i=0; $i<6; $i++ ) {
 			$var = 'page_id'.$i;
 			$var = absint( $instance[ $var ] );
		}
		?>
		<?php for( $i=0; $i<6; $i++) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php _e( 'Page', 'explore' ); ?>:</label>
				<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => $instance[key($defaults)] ) ); ?>
			</p>
		<?php
		next( $defaults ); // forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		for( $i=0; $i<6; $i++ ) {
			$var = 'page_id'.$i;
			$instance[ $var] = absint( $new_instance[ $var ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
 		extract( $instance );

 		global $post;
 		// adding the services pages in array
      $page_array = array();
      // looping through the pages
      for( $i=0; $i <= 6; $i++ ) {
      	$var = 'page_id'.$i;
         $page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';

         if( !empty( $page_id ) )
            array_push( $page_array, $page_id ); // Push the page id in the array
      }
      // quering through the page
      $get_featured_pages = new WP_Query( array(
         'posts_per_page' => -1,
         'post_type' => array( 'page' ),
         'post__in' => $page_array,
         'orderby' => 'post__in'
      ) );

		echo $before_widget;

		// displaying the contents
		$j = 1;
      while( $get_featured_pages->have_posts() ) : $get_featured_pages->the_post();
         $page_title = get_the_title();
         // adding specific classes for the divs
         $class = '';
         if ( $j % 3 == 0 ) {
            $class = 'tg-one-third-last';
         }
      ?>

      <div class="tg-one-third <?php echo $class; ?>">
         <?php if ( has_post_thumbnail() ) { ?>
            <div class="service-image">
               <?php the_post_thumbnail( 'explore-services' ); ?>
            </div>
         <?php } ?>
         <?php echo $before_title; ?><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo wp_kses_post($page_title); ?></a><?php echo $after_title; ?>
         <?php the_excerpt(); ?>
         <div class="more-link-wrap">
            <a class="more-link" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php _e( 'Read more','explore' ); ?></a>
         </div>
      </div>

      <?php
         $j++;
      endwhile;
      // Reset Post Data
		wp_reset_postdata();

		echo $after_widget;
	}

}
?>