<?php
/**
 * Theme Single Post Section for our theme.
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

   				<?php get_template_part( 'content', 'single' ); ?>

   				<?php get_template_part( 'navigation', 'archive' ); ?>

               <?php // showing the author bio ?>
               <?php if ( get_theme_mod( 'explore_enable_author_bio', '0' ) == 1 ) : ?>
                  <?php if ( get_the_author_meta( 'description' ) ) : ?>
                     <div class="author-box">
                        <div class="author-img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), '100' ); ?></div>
                           <h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>
                           <p class="author-description"><?php the_author_meta( 'description' ); ?></p>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>

               <?php if ( get_theme_mod( 'explore_related_posts_activate', '0' ) == 1 ) {
                  get_template_part( 'inc/related-posts' );
               } ?>

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