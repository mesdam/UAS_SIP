jQuery(document).ready( function() {

	// Tabs Widget
	if ( jQuery.isFunction(jQuery.fn.tabs) ) {
		jQuery( ".bm-tabs-wdt" ).tabs();
	}

	// FitVids
	if ( typeof jQuery.fn.fitVids !== 'undefined' ) {
		jQuery(".fitvids-video").fitVids();
	}

});