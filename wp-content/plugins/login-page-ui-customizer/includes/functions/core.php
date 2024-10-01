<?php
/**
 * Defines all core plugin functions.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

/**
 * Get option name by field name.
 *
 * @param mixed $field Input field name.
 * @param mixed $settings_field Settings.
 * @return string Option name.
 */
function crlpuic_get_option( $field, $settings_field = CRLPUIC_SLUG ) {

	return sprintf( '%s[%s]', $settings_field, $field );

}

/**
 * Get option value by field name.
 *
 * @param mixed $field Input field name.
 * @param mixed $settings_field Settings.
 * @param mixed $cache Cache. Default value is true.
 * @return string Option name.
 */
function crlpuic_get_option_value( $field, $settings_field = CRLPUIC_SLUG, $cache = true ) {

	// Bypass the cache?
	if ( ! $cache ) {

		$settings = get_option( $settings_field );

		if ( ! is_array( $settings ) || ! array_key_exists( $field, $settings ) ) {
			return '';
		}

		return is_array( $settings[ $field ] ) ? stripslashes_deep( $settings[ $field ] ) : stripslashes( wp_kses_decode_entities( $settings[ $field ] ) );
	}

	// Setup caches.
	static $settings_cache = array();
	static $options_cache  = array();

	// Check options cache.
	if ( isset( $options_cache[ $settings_field ][ $field ] ) ) {
		// Option has been cached.
		return $options_cache[ $settings_field ][ $field ];
	}

	// Check settings cache.
	if ( isset( $settings_cache[ $settings_field ] ) ) {
		// Setting has been cached.
		$settings = $settings_cache[ $settings_field ];
	} else {
		// Set value and cache setting.
		$settings_cache[ $settings_field ] = get_option( $settings_field );
		$settings                          = $settings_cache[ $settings_field ];
	}

	// Check for non-existent option.
	if ( ! is_array( $settings ) || ! array_key_exists( $field, (array) $settings ) ) {
		// Cache non-existent option.
		$options_cache[ $settings_field ][ $field ] = '';
	} else {
		// Option has not been previously been cached, so cache now.
		$options_cache[ $settings_field ][ $field ] = is_array( $settings[ $field ] ) ? stripslashes_deep( $settings[ $field ] ) : stripslashes( wp_kses_decode_entities( $settings[ $field ] ) );
	}

	return $options_cache[ $settings_field ][ $field ];
}


/**
 * Returns the URL to Customizer panel for Login Page.
 *
 * @param bool $echo Bool value.
 * @return string Customizer panel link.
 * @since 1.0.0
 */
function crlpuic_get_customizer_panel_link( $echo = false ) {

	$link = esc_url( get_admin_url() . 'customize.php?autofocus[panel]=' . CRLPUIC_SLUG );

	if ( $echo ) {

		esc_url( $link );

		return null;
	}

	return $link;
}

/**
 * Check current page is admin.
 *
 * @param string $pagehook Bool value.
 * @return bool True or false.
 * @since 1.0.0
 */
function crlpuic_is_admin_page( $pagehook = '' ) {

	global $page_hook;

	if ( isset( $page_hook ) && $page_hook === $pagehook ) {
		return true;
	}

	// May be too early for $page_hook.
	if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === $pagehook ) { // phpcs:ignore WordPress.Security.NonceVerification
		return true;
	}

	return false;

}

/**
 * Safe redirect to required page.
 *
 * @param string $page Page.
 * @param array  $query_args Query string, default is empty array.
 *
 * @since 1.0.0
 */
function crlpuic_admin_redirect( $page, array $query_args = array() ) {

	if ( ! $page ) {
		return;
	}

	$url = html_entity_decode( menu_page_url( $page, 0 ) );
	foreach ( (array) $query_args as $key => $value ) {
		if ( ! empty( $key ) && ! empty( $value ) && 'reset' === $key ) {
			unset( $query_args[ $key ] );
		}
	}

	$url = add_query_arg( $query_args, $url );
	wp_safe_redirect( $url );
	exit;
}

// Customezer functions.

/**
 * Login page layouts.
 *
 * @return array Layouts array.
 *
 * @since 1.0.0
 */
function crlpuic_available_page_layouts() {
	$layout_options = array(
		'boxed_right'    => array(
			'label' => __( 'Boxed Right', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-3-boxed-right-form.jpg',
		),
		'boxed_left'     => array(
			'label' => __( 'Boxed Left', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-3-boxed-left-form.jpg',
		),
		'right_form'     => array(
			'label' => __( 'Right Form', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-2-right-form.jpg',
		),
		'left_form'      => array(
			'label' => __( 'Left Form', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-2-left-form.jpg',
		),
		'center_form'    => array(
			'label' => __( 'Center Form', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-1-center-form.jpg',
		),
		'center_form_1'  => array(
			'label' => __( 'Center Form', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-1-center-form-1.jpg',
		),
		'form_1_3_right' => array(
			'label' => __( 'Form right 1_3', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-2-form-1-3-right.jpg',
		),
		'form_1_3_left'  => array(
			'label' => __( 'Form left 1_3', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-2-form-1-3-left.jpg',
		),
		'fresh_food'     => array(
			'label' => __( 'Fresh Food', 'login-page-ui-customizer' ),
			'url'   => CRLPUIC_PLUGIN_DIR . '/assets/images/tpl-2-freshfood.jpg',
		),
	);

	return $layout_options;
}

/**
 * Background options.
 *
 * @return array Background array options.
 *
 * @since 1.0.0
 */
function crlpuic_background_choices() {

	$background_choices = array(
		'bg_color' => __( 'Background Color', 'login-page-ui-customizer' ),
		'bg_image' => __( 'Background Image', 'login-page-ui-customizer' ),
	);

	return $background_choices;
}

/**
 * Logo option to choose.
 *
 * @return array $logo_choices Choices.
 * @since 1.2.96
 */
function crlpuic_logo_options() {

	$logo_choices = array(
		'hide_logo'  => __( 'Hide logo', 'login-page-ui-customizer' ),
		'show_logo'  => __( 'Show logo', 'login-page-ui-customizer' ),
		'show_title' => __( 'Show title', 'login-page-ui-customizer' ),
	);

	return $logo_choices;
}

// Compatibility fix with All In One WP Security Plugin.
add_action( 'init', 'crlpuic_aio_wp_security_comp_fix' );

/**
 * All In One WP Security customizer login page fix.
 *
 * @since 1.2.96
 */
function crlpuic_aio_wp_security_comp_fix() {

	if ( ! is_customize_preview() ) {
		return;
	}

	if ( ! class_exists( 'AIO_WP_Security' ) ) {
		return;
	}

	global $aio_wp_security;

	if ( ! is_a( $aio_wp_security, 'AIO_WP_Security' ) ) {
		return;
	}

	if ( remove_action( 'wp_loaded', array( $aio_wp_security, 'aiowps_wp_loaded_handler' ) ) ) {
		add_filter( 'option_aio_wp_security_configs', 'crlpuic_aio_wp_security_filter_options' );
	}
}

/**
 * Unset option of aiowps_enable_rename_login_page from aio_wp_security_configs.
 *
 * @param string $option Option name to unset.
 * @since 1.2.96
 */
function crlpuic_aio_wp_security_filter_options( $option ) {
	unset( $option['aiowps_enable_rename_login_page'] );
	return $option;
}
