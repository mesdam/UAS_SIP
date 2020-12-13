<?php
/**
 * Theme Index Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

get_header(); ?>

   <div class="inner-wrap">

   	<?php do_action( 'explore_before_body_content' ); ?>

      <div class="content-primary-sidebar">

      	<div id="primary">
      		<div id="content" class="clearfix">

      			<?php if ( have_posts() ) : ?>

      				<?php while ( have_posts() ) : the_post(); ?>

      					<?php get_template_part( 'content', get_post_format() ); ?>

      				<?php endwhile; ?>

      				<?php get_template_part( 'navigation', 'none' ); ?>

      			<?php else : ?>

      				<?php get_template_part( 'no-results', 'none' ); ?>

      			<?php endif; ?>

      		</div><!-- #content -->

            <?php
            $layout = explore_sidebar_layout();
            if ( $layout == "both_sidebar" ) {
               get_sidebar( 'left' );
            }
            ?>
      	</div><!-- #primary -->

         <?php
         if ( $layout != "no_sidebar_full_width" &&  $layout != "no_sidebar_content_centered" ) {
            get_sidebar();
         }
         ?>
      </div>

   	<?php do_action( 'explore_after_body_content' ); ?>
   </div>

<?php get_footer(); ?>