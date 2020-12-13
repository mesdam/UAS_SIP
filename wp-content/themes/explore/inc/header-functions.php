<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package 		ThemeGrill
 * @subpackage 		Explore
 * @since 			Explore 1.0
 */

/****************************************************************************************/
// Filter the get_header_image_tag() for supporting the older way of displaying the header image
function explore_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if ( $header_image ) {
		$output .= '<img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' .  get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
	}

	return $output;
}

function explore_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'explore_header_image_markup', 10, 3 );
}

add_action( 'explore_header_image_markup_render','explore_header_image_markup_filter' );

/****************************************************************************************/

if ( ! function_exists( 'explore_render_header_image' ) ) :
/**
 * Shows the small info text on top header part
 */
function explore_render_header_image() {
	if ( function_exists('the_custom_header_markup') ) {
		do_action( 'explore_header_image_markup_render' );
		the_custom_header_markup();
	} else {
		$header_image = get_header_image();
		if ( $header_image ) {
			?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php
		}
	}
}

endif;

/****************************************************************************************/

if ( ! function_exists( 'explore_featured_image_slider' ) ) :
/**
 * display featured post slider
 */
function explore_featured_image_slider() {
   global $post;
   ?>
      <section id="featured-wide-slider">
         <div class="slider-cycle">
            <div class="slider-rotate">
            <?php
            $page_array = array();
            // adding slider pages to the array
            for ( $i = 1; $i <= 5; $i++ ) {
               $page_id = get_theme_mod( 'explore_slider_image'.$i );
               if ( !empty ($page_id ) )
                  array_push( $page_array, $page_id );
            }

            // quering the pages
            $get_featured_posts = new WP_Query( array(
               'posts_per_page' => 5,
               'post_type' => array( 'page' ),
               'post__in' => $page_array,
               'orderby' => 'post__in'
            ) );

            $i = 1;
            while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();

               $explore_slider_title = get_the_title();
               $explore_slider_description = get_the_excerpt();
               $explore_slider_title_attribute = get_the_title( $post->ID );
               $explore_slider_image = get_the_post_thumbnail( $post->ID, 'full', array( 'title' => esc_attr( $explore_slider_title_attribute ), 'alt' => esc_attr( $explore_slider_title_attribute ) ) );

               // slider buttons
               $explore_slider_first_button_link = get_theme_mod( 'explore_slider_first_button_link'.$i );
               $explore_slider_first_button_text = get_theme_mod( 'explore_slider_first_button_text'.$i );
               $explore_slider_second_button_text = get_theme_mod( 'explore_slider_second_button_text'.$i );
               $explore_slider_second_button_link = get_theme_mod( 'explore_slider_second_button_link'.$i );

               if ( !empty( $explore_slider_image ) ) : ?>
               <div class="bxslider">
                  <figure>
                     <?php echo $explore_slider_image; ?>
                  </figure><!-- /Slider Image -->

                  <div class="entry-container">
                     <?php
                     if ( !empty( $explore_slider_title ) || !empty( $explore_slider_description ) ) { ?>
                        <div class="slider-title-head">
                           <h3 class="entry-title">
                              <?php if ( !empty( $explore_slider_first_button_link ) ) { ?>
                                 <a href="<?php echo esc_url( $explore_slider_first_button_link ); ?>" title="<?php echo esc_attr( $explore_slider_title ); ?>"><?php echo wp_kses_post( $explore_slider_title ); ?></a>
                              <?php } else { ?>
                                 <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $explore_slider_title_attribute ); ?>"><?php echo wp_kses_post( $explore_slider_title ); ?></a>
                              <?php } ?>
                           </h3><!-- /Slider title -->

                           <div class="entry-content">
                              <p><?php echo wp_kses_post( $explore_slider_description ); ?></p>
                           </div>
                        </div><!-- /Slider description -->

                        <?php if( !empty( $explore_slider_first_button_text ) || !empty( $explore_slider_second_button_text ) ) { ?>
                           <div class="slider-read-more-button">

                              <?php if ( !empty( $explore_slider_first_button_text ) ) { ?>
                                 <?php if (!empty($explore_slider_first_button_link)) {
                                    $slider_first_link = $explore_slider_first_button_link;
                                 } else {
                                    $slider_first_link = get_the_permalink();
                                 } ?>
                                 <a class="slider-first-button" href="<?php echo esc_url( $slider_first_link ); ?>" title="<?php echo esc_attr( $explore_slider_title ); ?>"><?php echo esc_html( $explore_slider_first_button_text ); ?></a>
                              <?php } else { ?>
                                 <a class="slider-first-button" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $explore_slider_title_attribute ); ?>"><?php _e( 'Read More', 'explore' ); ?></a>
                              <?php } ?>

                              <?php if ( !empty( $explore_slider_second_button_text ) ) { ?>
                                 <a class="slider-second-button" href="<?php echo esc_url( $explore_slider_second_button_link ); ?>" title="<?php echo esc_attr( $explore_slider_title ); ?>"><?php echo esc_html( $explore_slider_second_button_text ); ?></a>
                              <?php } ?>
                           </div>
                        <?php } ?>
                     <?php }
                     ?>
                  </div><!-- /Slider Content -->
               </div>
               <?php endif;
               $i++;
            endwhile;
            // Reset Post Data
            wp_reset_query();
            ?>

            </div>
         </div>
      </section>

   <?php
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'explore_header_title' ) ) :
/**
 * Show the title in header
 */
function explore_header_title() {
	if( is_archive() ) {
		if ( is_category() ) :
			$explore_header_title = single_cat_title( '', FALSE );

		elseif ( is_tag() ) :
			$explore_header_title = single_tag_title( '', FALSE );

		elseif ( is_author() ) :
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			*/
			the_post();
			$explore_header_title =  sprintf( __( 'Author: %s', 'explore' ), '<span class="vcard">' . get_the_author() . '</span>' );
			/* Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

		elseif ( is_day() ) :
			$explore_header_title = sprintf( __( 'Day: %s', 'explore' ), '<span>' . get_the_date() . '</span>' );

		elseif ( is_month() ) :
			$explore_header_title = sprintf( __( 'Month: %s', 'explore' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

		elseif ( is_year() ) :
			$explore_header_title = sprintf( __( 'Year: %s', 'explore' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

		elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
			$explore_header_title = __( 'Asides', 'explore' );

		elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
			$explore_header_title = __( 'Images', 'explore');

		elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
			$explore_header_title = __( 'Videos', 'explore' );

      elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
         $explore_header_title = __( 'Quotes', 'explore' );

      elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
         $explore_header_title = __( 'Links', 'explore' );

      elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
         $explore_header_title = __( 'Gallery', 'explore' );

      elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
         $explore_header_title = __( 'Chat', 'explore' );

      elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
         $explore_header_title = __( 'Audio', 'explore' );

		elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
			$explore_header_title = __( 'Status', 'explore' );

		else :
			$explore_header_title = __( 'Archives', 'explore' );

		endif;
	}
	elseif( is_404() ) {
		$explore_header_title = __( 'Page NOT Found', 'explore' );
	}
	elseif( is_search() ) {
		$explore_header_title = __( 'Search Results', 'explore' );
	}
	elseif( is_page()  ) {
		$explore_header_title = get_the_title();
	}
	elseif( is_single()  ) {
		$explore_header_title = get_the_title();
	}
	elseif( is_home() ){
		$queried_id = get_option( 'page_for_posts' );
		$explore_header_title = get_the_title( $queried_id );
	}
	else {
		$explore_header_title = '';
	}

	return $explore_header_title;

}
endif;

/****************************************************************************************/

if ( ! function_exists( 'explore_breadcrumb' ) ) :
/**
 * Display breadcrumb on header.
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
 */
function explore_breadcrumb() {
	if( function_exists( 'bcn_display' ) ) {
		echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
		echo '<span class="breadcrumb-title">'.__( 'You are here:', 'explore' ).'</span>';
		bcn_display();
		echo '</div> <!-- .breadcrumb -->';
	}
}
endif;

?>
