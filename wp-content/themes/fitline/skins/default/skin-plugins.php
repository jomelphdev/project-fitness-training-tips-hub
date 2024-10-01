<?php
/**
 * Required plugins
 *
 * @package FITLINE
 * @since FITLINE 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$fitline_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'fitline' ),
	'page_builders' => esc_html__( 'Page Builders', 'fitline' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'fitline' ),
	'socials'       => esc_html__( 'Socials and Communities', 'fitline' ),
	'events'        => esc_html__( 'Events and Appointments', 'fitline' ),
	'content'       => esc_html__( 'Content', 'fitline' ),
	'other'         => esc_html__( 'Other', 'fitline' ),
);
$fitline_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'fitline' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'fitline' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $fitline_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'fitline' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'fitline' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $fitline_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'fitline' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'fitline' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $fitline_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'fitline' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'fitline' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $fitline_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'fitline' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'fitline' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $fitline_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'fitline' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'fitline' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $fitline_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'fitline' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'fitline' ),
        'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $fitline_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'fitline' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'fitline' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $fitline_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'fitline' ),
		'description' => '',
        	'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'booked.png',
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'fitline' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'quickcal.png',
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'fitline' ),
		'description' => '',
        	'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'the-events-calendar.png',
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'fitline' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'fitline' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'fitline' ),
		'description' => '',
        	'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => fitline_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'fitline' ),
		'description' => '',
		'required'    => false,
		'logo'        => fitline_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'fitline' ),
		'description' => '',
        	'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => fitline_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'fitline' ),
		'description' => '',
		'required'    => false,
		'logo'        => fitline_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $fitline_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'fitline' ),
		'description' => '',
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => fitline_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $fitline_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'fitline' ),
		'description' => '',
        	'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => fitline_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'fitline' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'fitline' ),
		'description' => '',
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'revslider.png',
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'fitline' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'fitline' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $fitline_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'fitline' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'fitline' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $fitline_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'fitline' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'fitline' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $fitline_theme_required_plugins_groups['other'],
	),
	'learnpress'                 => array(
		'title'       => esc_html__( 'LearnPress', 'fitline' ),
		'description' => '',
		'required'    => false,
		'logo'        => fitline_get_file_url( 'plugins/learnpress/learnpress.png' ),
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
	'leadin'                 => array(
		'title'       => esc_html__( 'HubSpot All-In-One Marketing - Forms, Popups, Live Chat', 'fitline' ),
		'description' => '',
		'required'    => false,
		'logo'        => fitline_get_file_url( 'plugins/leadin/leadin.png' ),
		'group'       => $fitline_theme_required_plugins_groups['events'],
	),
);

if ( FITLINE_THEME_FREE ) {
	unset( $fitline_theme_required_plugins['js_composer'] );
	unset( $fitline_theme_required_plugins['booked'] );
	unset( $fitline_theme_required_plugins['quickcal'] );
	unset( $fitline_theme_required_plugins['the-events-calendar'] );
	unset( $fitline_theme_required_plugins['calculated-fields-form'] );
	unset( $fitline_theme_required_plugins['essential-grid'] );
	unset( $fitline_theme_required_plugins['revslider'] );
	unset( $fitline_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $fitline_theme_required_plugins['trx_updater'] );
	unset( $fitline_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
fitline_storage_set( 'required_plugins', $fitline_theme_required_plugins );
