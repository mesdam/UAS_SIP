<?php
/**
 * The template for displaying 404 pages (Page Not Found).
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

get_header(); ?>

	<?php do_action( 'explore_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<section class="error-404 not-found">
				<div class="page-content">

					<?php if ( ! dynamic_sidebar( 'explore_error_404_page_sidebar' ) ) : ?>
						<header class="page-header">
							<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'explore' ); ?></h1>
						</header>
						<p><?php _e( 'It looks like nothing was found at this location. Try the search below.', 'explore' ); ?></p>
						<?php get_search_form(); ?>
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
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

<?php get_footer(); ?>