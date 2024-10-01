<?php
/**
 * Sanitization class to handle validation of user input
 *
 * Reference: Derived from Genesis framework's settings sanitization class
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

/**
 * Settings sanitization class. Provides methods for sanitizing data.
 *
 * @since 1.0.0
 */
class CRLPUIC_Sanitization_Callbacks {

	/**
	 * Returns a bool value.
	 * Stores empty value as false.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $new_value Should ideally be empty or a bool value.
	 * @return int Bool value.
	 */
	public static function bool( $new_value ) {

		return isset( $new_value ) ? (bool) $new_value : false;

	}

	/**
	 * Returns a 1 or 0, for all truthy / falsy values.
	 *
	 * Uses double casting. First, we cast to bool, then to integer.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $new_value Should ideally be a 1 or 0 integer passed in.
	 * @return int `1` or `0`.
	 */
	public static function one_zero( $new_value ) {

		return (int) (bool) $new_value;

	}

	/**
	 * Returns a positive integer value.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $new_value Should ideally be a positive integer.
	 * @return int Positive integer.
	 */
	public static function absint( $new_value ) {

		return absint( $new_value );

	}


	/**
	 * Returns a float value between 0 to 1.
	 *
	 * @since 1.0.0
	 *
	 * @param float $new_value Input value.
	 * @return float value between 0 to 1.
	 */
	public static function opacity( $new_value ) {

		$min = 0;
		$max = 1;

		$steps   = 0.1;
		$default = 0;

		$new_value = floor( doubleval( $new_value ) / $steps ) * $steps;

		return ( $min <= $new_value && $new_value <= $max ) ? $new_value : $default;

	}

	/**
	 * Removes HTML tags from string.
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_value String, possibly with HTML in it.
	 * @return string String without HTML in it.
	 */
	public static function no_html( $new_value ) {

		return wp_strip_all_tags( $new_value );

	}

	/**
	 * Makes URLs safe
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_value String, a URL, possibly unsafe.
	 * @return string String a safe URL.
	 */
	public static function url( $new_value ) {

		return esc_url_raw( $new_value );

	}

	/**
	 * Makes Email Addresses safe, via sanitize_email()
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_value String, an email address, possibly unsafe.
	 * @return string String a safe email address.
	 */
	public static function email_address( $new_value ) {

		return sanitize_email( $new_value );

	}

	/**
	 * Removes unsafe HTML tags, via wp_kses_post().
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_value String with potentially unsafe HTML in it.
	 * @return string String with only safe HTML in it.
	 */
	public static function safe_html( $new_value ) {

		return wp_kses_post( $new_value );

	}

	/**
	 * Removes unsafe HTML tags when user does not have unfiltered_html
	 * capability.
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_value New value.
	 * @param string $old_value Previous value.
	 * @return string New or safe HTML value, depending if user has correct
	 *                capability or not.
	 */
	public static function unfiltered_or_safe_html( $new_value, $old_value ) {

		if ( current_user_can( 'unfiltered_html' ) ) {
			return $new_value;
		}

		return wp_kses_post( $new_value );

	}

	/**
	 * Sanitizes the input strings based on WP's sanitize_title filter; strips all HTML, PHP tags, accents removed
	 *
	 * @param string $new_value Input string.
	 * @since 1.0.0
	 */
	public static function sanitize_string( $new_value ) {

		return sanitize_title( $new_value );

	}

	/**
	 * Sanitizes the input strings based on WP's sanitize_text_field
	 *
	 * @param string $new_value Input string.
	 * @since 1.0.0
	 */
	public static function sanitize_text( $new_value ) {

		return sanitize_text_field( $new_value );

	}

	/**
	 * Sanitizes the input strings based on WP's sanitize_hex_color
	 *
	 * @param string $new_value Input string.
	 * @since 1.0.0
	 */
	public static function color( $new_value ) {

		return sanitize_hex_color( $new_value );

	}

}
