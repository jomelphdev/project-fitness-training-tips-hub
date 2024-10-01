<?php
/**
 * Plugin Name: Login Page UI Customizer
 * Plugin URI: https://cloudredux.com/contributions/wordpress/login-page-ui-customizer/
 * Description: With Login Page UI Customizer create a Login Page that looks as beautiful as your website. Start your creative engine and get started now!
 * Text Domain: login-page-ui-customizer
 * Domain Path: /languages
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author: CloudRedux
 * Author URI: https://cloudredux.com
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * PHP version 7.2
 *
 * @package   CR_Login_Page_UI_Customizer
 * @author    CloudRedux <hello@cloudredux.com>
 * @copyright Copyright (C) 2022 CloudRedux - support@cloudredux.com
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL v3
 * @link      https://wordpress.org/plugins/login-page-ui-customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'CR_Login_Page_UI_Customizer' ) ) {

	include 'class-cr-login-page-ui-customizer.php';

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'crlpuic_settings_link' );

	/**
	 * Add customize settings link at plugin page.
	 *
	 * @param array $links This contains links.
	 *
	 * @return array
	 */
	function crlpuic_settings_link( array $links ) {

		$url = get_admin_url() . 'customize.php?autofocus[panel]=' . CRLPUIC_SLUG;

		$settings_link = '<a href="' . $url . '">' . esc_html__( 'Customize', 'login-page-ui-customizer' ) . '</a>';

		$links[] = $settings_link;

		return $links;
	}

	// Run plugin.
	$crlpuic_run = CR_Login_Page_UI_Customizer::instance();

}
