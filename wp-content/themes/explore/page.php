<?php
/**
 * Theme Page Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

get_header(); ?>

   <div class="inner-wrap">

   	<?php do_action( 'explore_before_body_content' ); ?>

   	<div id="primary">
   		<div id="content" class="clearfix">
   			<?php while ( have_posts() ) : the_post(); ?>

   				<?php get_template_part( 'content', 'page' ); ?>

   				<?php
   					do_action( 'explore_before_comments_template' );
   					// If comments are open or we have at least one comment, load up the comment template
   					if ( comments_open() || '0' != get_comments_number() )
   						comments_template();
   	      		do_action ( 'explore_after_comments_template' );
   				?>

   			<?php endwhile; ?>

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

   	<?php do_action( 'explore_after_body_content' ); ?>
   </div>

<?php get_footer(); ?>