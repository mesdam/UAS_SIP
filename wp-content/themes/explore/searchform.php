<?php
/**
 * Displays the searchform of the theme.
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form searchform clearfix" method="get">
	<div class="search-wrap">
		<input type="search" placeholder="<?php esc_attr_e( 'Search', 'explore' ); ?>" class="s field" name="s">
		<button type="submit"><?php esc_html_e( 'Search', 'explore' ); ?></button>
	</div>
</form><!-- .searchform -->
