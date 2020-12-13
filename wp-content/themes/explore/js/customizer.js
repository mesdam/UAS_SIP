/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ( $ ) {
	// Site title
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-description' ).text( to );
		} );
	} );

	/*
	 * Shows a live preview of changing the site title color.
	 */
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {

			jQuery( '#site-title a' ).css( 'color', to );

		} ); // value.bind
	} ); // wp.customize

	// Site layout
	wp.customize( 'explore_site_layout', function ( value ) {
		value.bind( function ( layout ) {
			var layout_options = layout;
			if ( layout_options == 'wide_layout' ) {
				$( 'body' ).addClass( 'wide' );
			} else if( layout == 'boxed_layout' ) {
				$( 'body' ).removeClass( 'wide' );
				$( 'body' ).addClass( 'boxed' );
			}
		});
	});

	// Primary color option
	wp.customize( 'explore_primary_color', function ( value ) {
		value.bind( function ( primaryColor ) {
			// Store internal style for primary color
			var primaryColorStyle = '<style id="explore-internal-primary-color"> #controllers a.active,' +
			'#controllers a:hover,.comments-area .comment-author-link span,.explore-button,.fa.header-widget-controller,' +
			'.pagination span,.post .entry-meta .read-more-link,.social-links i.fa:hover,a#scroll-up,button,input[type=reset],' +
			'input[type=button],input[type=submit]{background-color:' + primaryColor + ' }' +
			'#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,' +
			'#content .comments-area article header cite a:hover,#controllers a.active,#controllers a:hover,' +
			'#featured-wide-slider .slider-title-head .entry-title a:hover,#site-title a:hover,#wp-calendar #today,' +
			'.comment .comment-reply-link:hover,.comments-area .comment-author-link a:hover,.footer-widgets-area a:hover,' +
			'.main-navigation a:hover,.main-navigation li.menu-item-has-children:hover>a:after,.main-navigation ul li ul li a:hover,' +
			'.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,' +
			'.main-navigation ul li.current-menu-item a:after,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,' +
			'.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a,.more-link,.nav-next a:hover,.nav-previous a:hover,.next a:hover,.page .entry-title a:hover,' +
			'.pagination a span:hover,.post .entry-meta a:hover,.post .entry-title a:hover,.previous a:hover,.read-more,.services-page-title a:hover,.single #content .tags a:hover,' +
			'.slide-next i,.slide-prev i,.social-links i.fa,.type-page .entry-meta a:hover,a,.better-responsive-menu .menu li:hover .sub-toggle .fa{color:' + primaryColor + ' }' +
			'blockquote{border-left:3px solid ' + primaryColor + ' }' +
			'#header-text-nav-container{border-top:2px solid ' + primaryColor + ' }' +
			'.social-links i.fa{border:1px solid ' + primaryColor + ' }' +
			'#featured-wide-slider .slider-read-more-button a.slider-first-button,#featured-wide-slider .slider-read-more-button a.slider-second-button:hover{border:2px solid ' + primaryColor + ' ;background-color:' + primaryColor + ' }' +
			'a.slide-next,a.slide-prev{border:2px solid ' + primaryColor + ' }' +
			'.breadcrumb a,.tg-one-fourth .widget-title a:hover,.tg-one-half .widget-title a:hover,.tg-one-third .widget-title a:hover{color:' + primaryColor + ' }' +
			'.pagination a span:hover{border-color:' + primaryColor + ' }' +
			'.header-widgets-wrapper,.widget-title span{border-bottom:2px solid ' + primaryColor + ' }' +
			'@media screen and (max-width: 767px){.better-responsive-menu .menu li .sub-toggle, .better-responsive-menu .menu li ul li .sub-toggle {background-color:' + primaryColor + ' }' +
			'.menu-toggle:before{color:' + primaryColor + ' }</style>';

			// Remove previously create internal style and add new one.
			$( 'head #explore-internal-primary-color' ).remove();
			$( 'head' ).append( primaryColorStyle );
		}
		);
	} );
})( jQuery );