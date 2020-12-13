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

   <?php
   if( has_post_thumbnail() ) {
      $image = '';
      $title_attribute = get_the_title( $post->ID );
      $image .= '<figure class="post-featured-image">';
      $image .= get_the_post_thumbnail( $post->ID, 'explore-featured', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) );
      $image .= '</figure>';

      echo $image;
   }
   ?>

	<div class="entry-content clearfix">
		<?php
      the_content();
		wp_link_pages( array(
			'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'explore' ),
			'after'             => '</div>',
			'link_before'       => '<span>',
			'link_after'        => '</span>'
      ) );
		?>
	</div>
	<footer class="entry-meta-bar clearfix">
		<div class="entry-meta clearfix">
       	<?php edit_post_link( __( 'Edit', 'explore' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</footer>
	<?php
	do_action( 'explore_after_post_content' );
   ?>
</article>