<?php
/* HubSpot – CRM, Email Marketing, Live Chat, Forms & Analytics support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('fitline_leadin_theme_setup9')) {
	add_action( 'after_setup_theme', 'fitline_leadin_theme_setup9', 9 );
	function fitline_leadin_theme_setup9() {
		if (is_admin()) {
			add_filter( 'fitline_filter_tgmpa_required_plugins', 'fitline_leadin_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fitline_leadin_tgmpa_required_plugins' ) ) {
	function fitline_leadin_tgmpa_required_plugins($list=array()) {
		if (fitline_storage_isset('required_plugins', 'leadin') && fitline_storage_get_array( 'required_plugins', 'leadin', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> fitline_storage_get_array('required_plugins', 'leadin', 'title'),
				'slug' 		=> 'leadin',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'fitline_exists_leadin' ) ) {
	function fitline_exists_leadin() {
		return function_exists('leadin_dir_init');
	}
}