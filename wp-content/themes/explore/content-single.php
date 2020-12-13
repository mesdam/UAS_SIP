<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'explore_before_post_content' ); ?>

   <?php explore_entry_meta(); ?>

   <?php if ( get_theme_mod( 'explore_featured_image_disable', '0' ) == 0 ) : ?>
      <?php
      $image_popup_id = get_post_thumbnail_id();
      $image_popup_url = wp_get_attachment_url( $image_popup_id );
      ?>

      <?php if ( has_post_thumbnail() ) { ?>
         <div class="post-featured-image">
            <?php the_post_thumbnail( 'explore-featured' ); ?>
         </div>
      <?php } ?>
   <?php endif; ?>

	<div class="entry-content clearfix">
		<?php
		the_content();

		$explore_tag_list = get_the_tag_list( '', '&nbsp;&nbsp;&nbsp;&nbsp;', '' );
		if( !empty( $explore_tag_list ) ) {
			?>
			<div class="tags">
				<?php
				_e( 'Tagged on: ', 'explore' ); echo $explore_tag_list;
				?>
			</div>
			<?php
		}

		wp_link_pages( array(
			'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'explore' ),
			'after'             => '</div>',
			'link_before'       => '<span>',
			'link_after'        => '</span>'
      ) );
		?>
	</div>



	<?php
	do_action( 'explore_after_post_content' );
   ?>
</article>