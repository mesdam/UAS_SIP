<?php
/**
 * Template Name: Business Template
 *
 * Displays the Business Page Template of the theme.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

get_header(); ?>

   <div class="inner-wrap">

      <?php do_action( 'explore_before_body_content' ); ?>

      <?php if (is_active_sidebar('explore_business_page_sidebar')) {
         dynamic_sidebar('explore_business_page_sidebar');
      } ?>

      <?php do_action( 'explore_after_body_content' ); ?>

   </div>

<?php get_footer(); ?>