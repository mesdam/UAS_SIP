<?php
/**
 * The Sidebar containing the header widget areas.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>

<?php
/**
 * The header widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'explore_header_sidebar_one' ) &&
   !is_active_sidebar( 'explore_header_sidebar_two' ) &&
   !is_active_sidebar( 'explore_header_sidebar_three' ) ) {
   return;
}
?>
<div class="header-widgets-wrapper">
   <div class="inner-wrap">
      <div class="header-widgets-area clearfix">
         <div class="tg-one-third">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'explore_header_sidebar_one' ) ):
            endif;
            ?>
         </div>
         <div class="tg-one-third">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'explore_header_sidebar_two' ) ):
            endif;
            ?>
         </div>
         <div class="tg-one-third tg-one-third-last">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'explore_header_sidebar_three' ) ):
            endif;
            ?>
         </div>
      </div>
   </div>
</div>