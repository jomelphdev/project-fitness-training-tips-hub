/**
 * Custom script.
 *
 * @package CR_Login_Page_UI_Customizer
 * @since 1.0.0
 */

var crlpuic_custom_script = (function($) {
	'use strict';

	/**
	 * Add placeholders at login form.
	 *
	 * @since 1.0.0
	 */

	var change_placeholder = function() {

		$( '#user_login' ).attr( 'placeholder', 'Username' );
		$( '#user_email' ).attr( 'placeholder', 'User Email' );
		$( '#user_pass' ).attr( 'placeholder', 'Password' );
		$( '#crlpuic-username-label' ).text( '' );
		$( '#crlpuic-password-label' ).text( '' );

		$( '#lostpasswordform #user_login' ).attr( 'placeholder', 'Username or Email Address' );

	},

		/**
		 * Bind behavior to events.
		 */
		ready = function() {

			// Run on document ready.
			change_placeholder();

		};

	// Only expose the ready function to the world.
	return {
		ready: ready
	};

})( jQuery );

jQuery( crlpuic_custom_script.ready );
