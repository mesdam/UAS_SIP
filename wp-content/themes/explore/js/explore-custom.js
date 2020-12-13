/*
 * Main Theme's JavaScript files
 */

jQuery(document).ready(function(){

   // For Search Icon Toggle effect added at the top
   jQuery('.search-top').click(function(){
      jQuery('#masthead .search-form-top').toggle();
   });

   jQuery('.header-widget-controller').click(function(){
      jQuery('.header-widgets-wrapper').slideToggle('slow');
   });

   // For scroll to top setting
	jQuery('#scroll-up').hide();
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 1000) {
				jQuery('#scroll-up').fadeIn();
			} else {
				jQuery('#scroll-up').fadeOut();
			}
		});
		jQuery('a#scroll-up').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

   // For Header Sidebar Toggle effect added at the top
   jQuery('.header-sidebar-ribbon').click(function(){
      jQuery('#masthead .header-widgets-wrapper').slideToggle('slow');
   });

   // Setting for the responsive video using fitvids
   if ( typeof jQuery.fn.fitVids !== 'undefined' ) {
      jQuery('.fitvids-video').fitVids();
   }

   // Setting for the sticky menu
   if ( typeof jQuery.fn.sticky !== 'undefined' ) {
      var wpAdminBar = jQuery('#wpadminbar');
      if (wpAdminBar.length) {
         jQuery('#header-text-nav-container').sticky({topSpacing:wpAdminBar.height()});
      } else {
         jQuery('#header-text-nav-container').sticky({topSpacing:0});
      }
   }

   // Setting for the bxSlider
   if ( typeof jQuery.fn.bxSlider !== 'undefined' ) {
      jQuery('.slider-rotate').bxSlider({
         mode: 'horizontal',
         speed: 1500,
         auto: true,
         pause: 5000,
         adaptiveHeight: true,
         nextText: '<a class="slide-next"><i class="fa fa-angle-right"></i></a>',
         prevText: '<a class="slide-prev"><i class="fa fa-angle-left"></i></a>',
         pager: false,
         tickerHover: true
      });
   }

});
jQuery(document).ready(function() {
    jQuery('.better-responsive-menu #site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-caret-down"></i> </span>');
    jQuery('.better-responsive-menu #site-navigation .sub-toggle').click(function() {
        jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).children('.fa-caret-right').first().toggleClass('fa-caret-down');
        jQuery(this).toggleClass('active');
    });

    jQuery('.better-responsive-menu #site-navigation .menu-toggle').click(function() {
      jQuery('.better-responsive-menu #site-navigation .menu').slideToggle('slow');
    });

});
