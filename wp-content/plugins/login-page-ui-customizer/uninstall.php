<?php
/**
 * Uninstall login page customizer.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$crlpuic_setting   = get_option( 'admin-crlpuic-settings' );
$crlpuic_uninstall = isset( $crlpuic_setting['remove_settings_on_uninstall'] ) ? $crlpuic_setting['remove_settings_on_uninstall'] : false;

// Check option is set to delete data.
if ( true !== $crlpuic_uninstall ) {
	return;
}

if ( ! is_multisite() ) {

	// Delete all plugin Options.
	if ( true === $crlpuic_uninstall ) {
		delete_option( 'admin-crlpuic-settings' );
		delete_option( 'crlpuic-settings' );
	}
} else {

	global $wpdb; //phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery

	// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching
	$crlpuic_blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ); //phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery


	foreach ( $crlpuic_blog_ids as $current_blog_id ) {

		switch_to_blog( $current_blog_id );

		// Delete Options.
		if ( true === $crlpuic_uninstall ) {
			delete_option( 'admin-crlpuic-settings' );
			delete_option( 'crlpuic-settings' );
		}

		restore_current_blog();
	}
}
