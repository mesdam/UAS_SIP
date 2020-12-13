<?php
/**
 * The template used for displaying blog post full content.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'explore_before_post_content' ); ?>
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
		</h2><!-- .entry-title -->
	</header>

   <?php explore_entry_meta(); ?>

   <?php
   if( has_post_thumbnail() ) {
      $image = '';
      $title_attribute = get_the_title( $post->ID );
      $image .= '<figure class="post-featured-image">';
      $image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
      $image .= get_the_post_thumbnail( $post->ID, 'explore-featured', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
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

	<?php
	do_action( 'explore_after_post_content' );
   ?>
</article>