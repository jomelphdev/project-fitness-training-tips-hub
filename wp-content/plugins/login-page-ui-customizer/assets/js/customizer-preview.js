/**
 * Handles login page Customizer preview events.
 *
 * @package CR_Login_Page_UI_Customizer
 * @since 1.0.0
 */

var crlpuic_customizer = (function(wp, $) {
	'use strict';

	/**
	 * Handles Customizer control events.
	 *
	 * @since 1.0.0
	 */
	var customizerControls = function() {

		// Login page Template Styling.

		var  Content_column_width = 50;

		wp.customize(
			'crlpuic-settings[column_width]',
			function(value) {

				value.bind(
					function(newValue) {

						$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', newValue + '%' );
						Content_column_width = 100 - newValue;

						$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'width', Content_column_width + '%' );
					}
				);

			}
		);

		wp.customize(
			'crlpuic-settings[login_template]',
			function( value ) {
				value.bind(
					function( newValue ) {

						var bg_image     = wp.customize( 'crlpuic-settings[bg_image]' )(),
						bg_color         = wp.customize( 'crlpuic-settings[bg_color]' )(),
						bg_opacity       = wp.customize( 'crlpuic-settings[bg_opacity]' )(),
						hide_links       = wp.customize( 'crlpuic-settings[hide_links]' )();
						var bg_color_rgb = hex_to_rbg( bg_color );

						if ( bg_image != '') {
							$( 'body.login' ).css( 'background-color', bg_color );
							$( 'body.login' ).css( 'background', 'linear-gradient(rgba(' + bg_color + ', ' + bg_opacity + '),rgba(' + bg_color + ', ' + bg_opacity + ')),url(' + bg_image + ')' );
						} else {
							$( 'body.login' ).css( 'background-color', bg_color );
							if ( null != bg_color_rgb ) {
								$( 'body.login' ).css( 'background', 'linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + bg_opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + bg_opacity + '))' );
							}
						}

						if ( true === hide_links ) {
							$( '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a' ).css( 'display', 'none !important' );
						} else {
							$( '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a' ).css( 'display', 'inline-block !important' );
						}

						if ( newValue == 'center_form' || newValue == 'center_form_1' ) {
							$( '.center_form_bg_edit' ).css( 'display', 'block' );
						} else {
							$( '.center_form_bg_edit' ).css( 'display', 'none' );
							// $( '#login' ).css( 'width', 'auto !important' );
							if ( $( '.crlpuic-content-wrapper-inner' ).has( 'p' ) ) {
								$( '.crlpuic-content-wrapper-inner p.content-desc' ).html( wp.customize( 'crlpuic-settings[content_desc]' )() );
							} else {
								$( '.crlpuic-content-wrapper-inner p.content-desc' ).append( '<p class="content-desc" >' + wp.customize( 'crlpuic-settings[content_desc]' )() + '</p>' );
							}
						}

						if ( newValue == 'left_form' || newValue == 'form_1_3_left' ) {

							$( '.login' ).addClass( 'crlpuic-one-half crlpuic-left-form' );
							$( '.login' ).removeClass( 'boxed' );
							$( '.login' ).addClass( 'crlpuic-one-half' );
							$( '.login' ).removeClass( 'crlpuic-right-form' );
							$( '.login' ).removeClass( 'crlpuic-full-width' );

							if ( newValue == 'form_1_3_left' ) {
								$( '.login' ).addClass( 'crlpuic-form-1-3-left' );
								$( '#loginform' ).removeClass( 'crlpuic-form-shadow' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '33%' );
							} else if ( newValue == 'left_form' ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '50%' );
								$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'width', '50%' );
								$( '#loginform' ).addClass( 'crlpuic-form-shadow' );
							}
							$( '.crlpuic-content-wrapper' ).css( 'display', 'flex' );
							$( '.crlpuic-wrapper .crlpuic-content' ).css( 'left', 'unset' );

						} else if ( newValue == 'right_form' || newValue == 'form_1_3_right' || newValue == 'fresh_food' ) {

							$( '.login' ).addClass( 'crlpuic-one-half crlpuic-right-form' );
							$( '.login' ).removeClass( 'crlpuic-left-form' );
							$( '.login' ).addClass( 'crlpuic-one-half' );
							$( '.login' ).removeClass( 'crlpuic-full-width' );
							$( '.login' ).removeClass( 'boxed' );
							if ( newValue == 'form_1_3_right' ) {
								$( '.login' ).addClass( 'crlpuic-form-1-3-right' );
								$( '#loginform' ).removeClass( 'crlpuic-form-shadow' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '33%' );

							} else if ( newValue == 'right_form' || newValue == 'boxed_right' ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '50%' );
								$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'width', '50%' );
								$( '#loginform' ).addClass( 'crlpuic-form-shadow' );
							} else if ( newValue == 'fresh_food' ) {
								$( '.crlpuic-form-wrapper' ).css( 'background', 'none' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '50%' );
								$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'width', '50%' );
								$( '#loginform' ).removeClass( 'crlpuic-form-shadow' );
								$( '#crlpuic-username-label' ).text( '' );
								$( '#crlpuic-password-label' ).text( '' );

							}
							$( '.crlpuic-content-wrapper' ).css( 'display', 'flex' );
							$( '.crlpuic-wrapper .crlpuic-content' ).css( 'left', '0' );

						} else if ( newValue == 'center_form' || newValue == 'center_form_1') {

							$( '.login' ).removeClass( 'crlpuic-left-form' );
							$( '.login' ).removeClass( 'crlpuic-right-form' );
							$( '.login' ).removeClass( 'crlpuic-one-half' );
							$( '.login' ).removeClass( 'boxed' );
							$( '.login' ).addClass( 'crlpuic-full-width' );
							$( '#loginform' ).addClass( 'crlpuic-form-shadow' );
							$( '.crlpuic-content' ).css( 'width', '0' );
							$( '.crlpuic-content-wrapper' ).css( 'display', 'none' );
							$( '.crlpuic-content' ).css( 'display', 'none' );
							$( 'div.crlpuic-form-wrapper' ).css( 'width', '100%' );
							$( 'div.crlpuic-form-wrapper' ).css( 'background', 'unset' );
							$( 'div.crlpuic-wrapper' ).css( 'background', 'unset' );
							$( 'div.crlpuic-form-wrapper' ).css( 'background-color', 'unset' );
						} else if ( newValue == 'boxed_left' ) {

							$( '.login' ).addClass( 'crlpuic-one-half crlpuic-left-form boxed' );
							$( '#loginform' ).addClass( 'crlpuic-form-shadow' );
							$( '.login' ).removeClass( 'crlpuic-right-form' );
							$( '.login' ).removeClass( 'crlpuic-full-width' );
							$( '.crlpuic-content-wrapper' ).css( 'display', 'flex' );
							$( '.crlpuic-wrapper .crlpuic-content' ).css( 'left', 'unset' );
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '50%' );
							$( 'body.crlpuic-one-half.boxed .crlpuic-wrapper > .crlpuic-content' ).css( 'width', '50%' );

						} else if ( newValue == 'boxed_right' ) {

							$( '.login' ).addClass( 'crlpuic-one-half crlpuic-right-form boxed' );
							$( '#loginform' ).addClass( 'crlpuic-form-shadow' );
							$( '.login' ).removeClass( 'crlpuic-left-form' );
							$( '.login' ).removeClass( 'crlpuic-full-width' );
							$( '.crlpuic-content-wrapper' ).css( 'display', 'flex' );
							$( '.crlpuic-wrapper .crlpuic-content' ).css( 'left', 'unset' );
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'width', '50%' );
							$( 'body.crlpuic-one-half.boxed .crlpuic-wrapper > .crlpuic-content' ).css( 'width', '50%' );

						} else if ( newValue == 'fresh_food' || newValue == 'center_form_1' ) {

							// Form input field placeholder check.
							$( '#loginform' ).css( 'background-color', 'transparent' );
							$( '.login form' ).css( 'box-shadow',  'none !important' );
							$( '.login form' ).css( 'border-radius',  '5px !important' );
							$( '#user_login' ).attr( 'placeholder', 'Username or Email Address' );
							$( '#user_email' ).attr( 'placeholder', 'User Email' );
							$( '#user_pass' ).attr( 'placeholder', 'Password' );
							$( '#crlpuic-username-label' ).text( '' );
							$( '#crlpuic-password-label' ).text( '' );

						} else {

							$( '#crlpuic-username-label' ).text( wp.customize( 'crlpuic-settings[username_label]' )() );
							$( '#crlpuic-password-label' ).text( wp.customize( 'crlpuic-settings[password_label]' )() );
							$( '#user_login' ).attr( 'placeholder', '' );
							$( '#user_email' ).attr( 'placeholder', '' );
							$( '#user_pass' ).attr( 'placeholder', '' );
						}

						if ( 'bg_color' == wp.customize( 'crlpuic-settings[background]' )() ) {
							$( 'body.login' ).css( 'background-color',  wp.customize( 'crlpuic-settings[bg_color]' )() );
							$( 'body.login' ).css( 'background-image',  'none' );
							if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'none' );
							} else {
								$( 'body.login' ).css( 'background-image',  'none' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'none' );
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'flex' );

							}

						} else if ( 'bg_image' == wp.customize( 'crlpuic-settings[background]' )() ) {
							$( 'body.login' ).css( 'background-image',  'url(' + wp.customize( 'crlpuic-settings[bg_image]' )() + ')' );
							$( 'body.login' ).css( 'background-color',  wp.customize( 'crlpuic-settings[bg_color]' )() );
							$( 'body.login' ).css( 'background-size', 'cover' );

							if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {

							} else {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'url(' + wp.customize( 'crlpuic-settings[form_column_bg_img]' )() + ')' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-color',  wp.customize( 'crlpuic-settings[form_column_bg_color]' )() );
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'flex' );
							}

						}
					}
				);
			}
		);

		// Login page background Styling.
		wp.customize(
			'crlpuic-settings[background]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( 'bg_color' == newValue ) {
							$( 'body.login' ).css( 'background-color',  wp.customize( 'crlpuic-settings[bg_color]' )() );
							$( 'body.login' ).css( 'background-image',  'none' );
							if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'none' );
							} else {
								$( 'body.login' ).css( 'background-image',  'none' );
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'none' );
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'flex' );
								// $( 'body .crlpuic-content-wrapper-inner' ).html( wp.customize( 'crlpuic-settings[content_column]' )() );

							}

						} else if ( 'bg_image' == newValue ) {
							$( 'body.login' ).css( 'background-image',  'url(' + wp.customize( 'crlpuic-settings[bg_image]' )() + ')' );

							if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'none' );
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'none' );
							} else {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'url(' + wp.customize( 'crlpuic-settings[form_column_bg_img]' )() + ')' );
								$( '.crlpuic-wrapper .crlpuic-content' ).css( 'display', 'flex' );
								// $( 'body .crlpuic-content-wrapper-inner' ).html( wp.customize( 'crlpuic-settings[content_column]' )() );
							}
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[bg_color]',
			function(value) {
				value.bind(
					function( newValue ) {
						$( 'body.login' ).css( 'background-color', newValue );

						var bg_opacity   = wp.customize( 'crlpuic-settings[bg_opacity]' )();
						var bg_color_rgb = hex_to_rbg( newValue );
						var bg_image     = wp.customize( 'crlpuic-settings[bg_image]' )();

						if ( '' !== bg_image ) {

							$( 'body.login' ).css( 'background-color', newValue );

							$( 'body.login' ).css( 'background-image', + 'url("' + bg_image + '")' );
							if ( null != bg_color_rgb ) {
								$( '.crlpuic-overlay' ).css( 'background-color', 'rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + bg_opacity + ')' );
							}
						} else {
							if ( null != bg_color_rgb ) {
								$( '.crlpuic-overlay' ).css( 'background-color', 'rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + bg_opacity + ')' );
							}
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[bg_image]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'body.login' ).css( 'background', 'url(' + newValue + ')' );
						$( 'body.login' ).css( 'background-size', 'cover' );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[bg_overlay]',
			function(value) {
				value.bind(
					function(newValue) {

						var opacity  = wp.customize( 'crlpuic-settings[bg_opacity]' )();
						var bg_color = wp.customize( 'crlpuic-settings[bg_overlay]' )();

						var bg_color_rgb = hex_to_rbg( bg_color );

						var bg_image = wp.customize( 'crlpuic-settings[bg_image]' )();

						if ( bg_image !== '' ) {
							$( 'body.login' ).css( 'background-color', newValue );
							if ( null != bg_color_rgb ) {
								$( 'body.login' ).css( 'background', '-ms-linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '), url(' + bg_image + '))' );
								$( 'body.login' ).css( 'background', '-moz-linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '), url(' + bg_image + '))' );
								$( 'body.login' ).css( 'background', '-o-linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '), url(' + bg_image + '))' );
								$( 'body.login' ).css( 'background', '-webkit-linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '), url(' + bg_image + '))' );
								$( 'body.login' ).css( 'background', 'linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '), url(' + bg_image + '))' );
								$( '.crlpuic-overlay' ).css( 'background-color', 'rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + ')' );
							}
						} else {
							$( 'body.login' ).css( 'background-color', newValue );
							if ( null != bg_color_rgb ) {
								$( 'body.login' ).css( 'background', 'linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + opacity + '))' );
							}
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[bg_opacity]',
			function(value) {
				value.bind(
					function( newValue ) {

						var bg_overlay   = wp.customize( 'crlpuic-settings[bg_overlay]' )();
						var bg_color_rgb = hex_to_rbg( bg_overlay );
						var bg_image     = wp.customize( 'crlpuic-settings[bg_image]' )();
						if ( bg_image !== '') {

							$( 'body.login' ).css( 'background-image', 'url(' + bg_image + ')' );
							if ( null != bg_color_rgb ) {
								$( 'body.login' ).css( 'background-color', 'rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + newValue + ')' );
								$( '.crlpuic-overlay' ).css( 'background-color', 'rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + newValue + ')' );
							}
						} else {
							$( 'body.login' ).css( 'background-color', 'rgba(' + bg_overlay + ')' );
							if ( null != bg_color_rgb ) {
								$( 'body.login' ).css( 'background', 'linear-gradient(rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + newValue + '),rgba(' + bg_color_rgb.r + ',' + bg_color_rgb.g + ',' + bg_color_rgb.b + ', ' + newValue + '))' );
							}
						}
					}
				);
			}
		);

		// Login page logo styling.
		wp.customize(
			'crlpuic-settings[logo_settings]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( 'hide_logo' == wp.customize( 'crlpuic-settings[logo_settings]' )() ) {
							$( '#login h1 a' ).css( 'display', 'none' );
						} else if ( 'show_logo' == wp.customize( 'crlpuic-settings[logo_settings]' )() ) {
							$( '#login h1 a' ).css( 'display', 'block' );
							$( '#login h1 a' ).css( 'margin-bottom', '25px' );
							$( '#login h1 a' ).css( 'text-indent', '-9999px' );
							$( '#login h1 a' ).css( 'background-image',  'url(' + $( '#login h1 a' ).data( 'bg-img' ) + ')' );
							$( '#login h1 a' ).css( 'height', wp.customize( 'crlpuic-settings[custom_logo_height]' )() + 'px' );
						} else if ( 'show_title' == wp.customize( 'crlpuic-settings[logo_settings]' )() ) {
							$( '#login h1 a' ).css( 'margin-bottom', '0' );
							$( '#login h1 a' ).css( 'display', 'block' );
							$( '#login h1 a' ).css( 'background-image', 'none' );
							$( '#login h1 a' ).css( 'height', 'auto' );
							$( '#login h1 a' ).css( 'text-indent', 'unset' );
						}

					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[custom_logo]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#login h1 a' ).css( 'background-image', 'url(' + newValue + ')' );
						$( '#login h1 a' ).data( 'bg-img', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[custom_logo_height]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#login h1 a' ).css( 'height', newValue + 'px' );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[logo_title]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login h1 a span#title-text' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_page_title]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'title' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[logo_title_color]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login h1 a span#title-text' ).css( 'color', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[logo_title_font_size]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login h1 a span#title-text' ).css( 'font-size', newValue + 'px' );
					}
				);
			}
		);

		// Form Styling.
		wp.customize(
			'crlpuic-settings[transparent_background]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( newValue == true ) {
							$( '#loginform, #registerform, #lostpasswordform' ).addClass( 'crlpuic-transparent' );
							$( '.crlpuic-login-form-bg #login' ).css( 'background-color', 'transparent' );
						} else {
							var wrapper = $( '#crlpuic-toggle-crlpuic-settings[form_wrapper]' ).val();
							if ( ! wrapper ) {
								$( '#loginform, #registerform, #lostpasswordform' ).removeClass( 'crlpuic-transparent' );
							} else {
								var color = $( '#loginform' ).css( 'background-color' );
								$( '.crlpuic-login-form-bg #login' ).css( 'background-color', color );
								$( '.login form' ).css( 'border', 'none' );
								$( '.login form' ).css( 'box-shadow', 'none' );
								$( '.crlpuic-login-form-bg #login' ).removeClass( 'crlpuic-transparent' );
							}
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[form_wrapper]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( newValue == true ) {
							var color = $( '#loginform' ).css( 'background-color' );
							$( '.crlpuic-login-form-bg #login' ).css( 'background-color', color );
							$( '.login form' ).css( 'border', 'none' );
							$( '.login form' ).css( 'box-shadow', 'none' );
							$( '.crlpuic-login-form-bg #login' ).removeClass( 'crlpuic-transparent' );
						} else {
							$( '.crlpuic-login-form-bg #login' ).addClass( 'crlpuic-transparent' );
						}
					}
				);
			}
		);

		// Content column title.
		wp.customize(
			'crlpuic-settings[content_title]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( $( '.crlpuic-content-wrapper-inner' ).has( 'h2' ) ) {
							$( '.crlpuic-content-wrapper-inner h2.content-title' ).html( newValue );
						}
					}
				);
			}
		);

		// Content column title color.
		wp.customize(
			'crlpuic-settings[content_title_color]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( $( '.crlpuic-content-wrapper-inner' ).has( 'h2' ) ) {
							$( '.crlpuic-content-wrapper-inner h2.content-title' ).css( 'color', newValue );
						}
					}
				);
			}
		);

		// Content column description.
		wp.customize(
			'crlpuic-settings[content_desc]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( $( '.crlpuic-content-wrapper-inner' ).has( 'p' ) ) {
							$( '.crlpuic-content-wrapper-inner p.content-desc' ).html( newValue );
						}
					}
				);
			}
		);

		// Content column description color.
		wp.customize(
			'crlpuic-settings[content_desc_color]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( $( '.crlpuic-content-wrapper-inner' ).has( 'p' ) ) {
							$( '.crlpuic-content-wrapper-inner p.content-desc' ).css( 'color', newValue );
						}
					}
				);
			}
		);

		// Content column description.
		wp.customize(
			'crlpuic-settings[content_img]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( $( '.crlpuic-content-wrapper-inner' ).has( 'img' ) ) {
							$( '.crlpuic-content-wrapper-inner img.content-img' ).attr( "src", newValue );
						}
					}
				);
			}
		);

		// Form Column styling.
		wp.customize(
			'crlpuic-settings[form_background_color]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#loginform' ).css( 'background-color', newValue );
						$( '#registerform' ).css( 'background-color', newValue );
						$( '#lostpasswordform' ).css( 'background-color', newValue );
						var form_wrapper = wp.customize( 'crlpuic-settings[form_wrapper]' )();
						if ( true == form_wrapper) {
							var color = $( '#loginform' ).css( 'background-color' );
							$( '.crlpuic-login-form-bg #login' ).css( 'background-color', color );
							$( '.login form' ).css( 'border', 'none' );
							$( '.login form' ).css( 'box-shadow', 'none' );
							$( '.crlpuic-login-form-bg #login' ).removeClass( 'crlpuic-transparent' );
						} else {
							$( '.crlpuic-login-form-bg #login' ).addClass( 'crlpuic-transparent' );
						}
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[form_width]',
			function(value) {
				value.bind(
					function(newValue) {
						var login_form_width = parseInt( newValue ) + 5;
						$( '.crlpuic-wrapper #login' ).css( 'width', login_form_width + '%' );
						if ( 'form_1_3_right' == wp.customize( 'crlpuic-settings[login_template]' )()) {
							$( '#loginform, #registerform, #lostpasswordform' ).css( 'width', '100%' );
							$( '.crlpuic-wrapper #login' ).css( 'width', newValue + '% !important' );
						} else {
							$( '#loginform, #registerform, #lostpasswordform' ).css( 'width', newValue + '%' );
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[form_column_bg_color]',
			function(value) {
				value.bind(
					function(newValue) {

						var form_column_bg_rgb = hex_to_rbg( newValue );
						var form_column_bg_img = wp.customize( 'crlpuic-settings[form_column_bg_img]' )();
						var opacity            = wp.customize( 'crlpuic-settings[column_bg_opacity]' )();

						var login_template = wp.customize( 'crlpuic-settings[login_template]' )();

						if ( form_column_bg_img != '') {
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-color', newValue );
							if ( null != form_column_bg_rgb ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background', 'linear-gradient(rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + opacity + '),rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + opacity + ')),url(' + form_column_bg_img + ')' );
								if ( 'boxed_left' == login_template || 'boxed_right' == login_template ) {
									$( '.crlpuic-form-wrapper-inner' ).css( 'background-color', 'transparent' );
								} else {
									$( '.crlpuic-form-wrapper-inner' ).css( 'background-color', 'rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + opacity + ')' );
								}
							}

						} else {
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-color', newValue );
							if ( null != form_column_bg_rgb ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background', 'linear-gradient(rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + '),rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + '))' );
							}
						}

					}
				);

			}
		);

		wp.customize(
			'crlpuic-settings[content_column_bg_color]',
			function(value) {
				value.bind(
					function(newValue) {
						var cc_bg_color_rgb = hex_to_rbg( newValue );
						var opacity         = wp.customize( 'crlpuic-settings[content_column_bg_opacity]' )();

						$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'background-color', newValue );
						if ( null != cc_bg_color_rgb ) {
							$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'background', 'rgba(' + cc_bg_color_rgb.r + ',' + cc_bg_color_rgb.g + ',' + cc_bg_color_rgb.b + ',' + opacity + ')' );
						}

					}
				);

			}
		);

		wp.customize(
			'crlpuic-settings[content_column_bg_opacity]',
			function(value) {
				value.bind(
					function(newValue) {

						var cc_bg_color     = wp.customize( 'crlpuic-settings[content_column_bg_color]' )();
						var cc_bg_color_rgb = hex_to_rbg( cc_bg_color );
						$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'background-color', cc_bg_color );
						if ( null != cc_bg_color_rgb ) {
							$( 'body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content' ).css( 'background', 'rgba(' + cc_bg_color_rgb.r + ',' + cc_bg_color_rgb.g + ',' + cc_bg_color_rgb.b + ',' + newValue + ')' );
						}

					}
				);

			}
		);

		wp.customize(
			'crlpuic-settings[form_column_bg_img]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-image', 'url(' + newValue + ')' );
						$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-size', 'cover' );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[column_bg_opacity]',
			function(value) {
				value.bind(
					function(newValue) {

						var form_column_bg_overlay_hex = wp.customize( 'crlpuic-settings[form_column_bg_color]' )();

						var form_column_bg_rgb = hex_to_rbg( form_column_bg_overlay_hex );

						var form_column_bg_img = wp.customize( 'crlpuic-settings[form_column_bg_img]' )();
						if ( form_column_bg_img != '') {
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-color', form_column_bg_overlay_hex );
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background', 'linear-gradient(rgba(' + form_column_bg_overlay_hex + ', ' + newValue + '),rgba(' + form_column_bg_overlay_hex + ', ' + newValue + ')),url(' + form_column_bg_img + ')' );
							if ( null != form_column_bg_rgb ) {
								$( '.crlpuic-form-wrapper-inner' ).css( 'background-color', 'rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + newValue + ')' );
							}
						} else {
							$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background-color', form_column_bg_overlay_hex );
							if ( null != form_column_bg_rgb ) {
								$( 'body.crlpuic-one-half .crlpuic-form-wrapper' ).css( 'background', 'linear-gradient(rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + newValue + '),rgba(' + form_column_bg_rgb.r + ',' + form_column_bg_rgb.g + ',' + form_column_bg_rgb.b + ', ' + newValue + '))' );
							}
						}

					}
				);
			}
		);

		// Button Styling.

		wp.customize(
			'crlpuic-settings[login_btn_bg_color]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#loginform .button-primary' ).css( 'background-color', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_btn_bg_hover]',
			function(value) {
				value.bind(
					function(newValue) {

						$( '#loginform .button-primary' ).hover(
							function(e){
								if (e.type === 'mouseenter' ) {
									$( this ).css( "background-color", newValue );
								} else {
									$( this ).css( "background-color", wp.customize( 'crlpuic-settings[login_btn_bg_color]' )() );
								}

							}
						);

						$( '#lostpasswordform .button-primary' ).hover(
							function(e){
								if (e.type === 'mouseenter' ) {
									$( this ).css( "background-color", newValue );
								} else {
									$( this ).css( "background-color", wp.customize( 'crlpuic-settings[login_btn_bg_color]' )() );
								}

							}
						);

					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_btn_txt_color]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#loginform .button-primary' ).css( 'color', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_btn_font_size]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#loginform .button-primary' ).css( 'font-size', newValue + 'px' );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[form_label_color]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login label, .login #backtoblog a, .login #nav a' ).css( 'color', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[field_icons]',
			function(value) {
				value.bind(
					function(newValue) {
						if ( newValue == true ) {
							$( '#user_login' ).addClass( 'user_login' );
							$( '#user_pass' ).addClass( 'user_pass' );
							$( '#user_login' ).css( 'padding-left', '27px' );
							$( '#user_pass' ).css( 'padding-left', '27px' );

							var loc = window.location.pathname;
							var dir = loc.substring( 0, loc.lastIndexOf( '/' ) );
							$( '#user_login' ).css( 'background-image', 'url(' + dir + '"/username.svg")' );
							// $( '#user_pass' ).css( 'background-image', 'url("./password.svg")' );
						} else {
							$( '#user_login' ).removeClass( 'user_login' );
							$( '#user_pass' ).removeClass( 'user_pass' );
							$( '#user_login' ).css( 'padding-left', '17px' );
							$( '#user_pass' ).css( 'padding-left', '17px' );
							$( '#user_login' ).css( 'background-image', 'none' );
							$( '#user_pass' ).css( 'background-image', 'none' );
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[form_label_font_size]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login label, .login #backtoblog a, .login #nav a' ).css( 'font-size', newValue + 'px' );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[rememberme_hide]',
			function(value) {
				value.bind(
					function(newValue) {
						if (newValue) {
							$( '.login .forgetmenot' ).css( 'display', 'none' );
						} else {
							$( '.login .forgetmenot' ).css( 'display', 'inline-block' );
						}
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[hide_links]',
			function(value) {
				value.bind(
					function(newValue) {
						if (newValue) {
							$( '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a' ).css( 'display', 'none' );
						} else {
							$( '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a' ).css( 'display', 'inline-block' );
						}

						if ( $( '#registerform' ).is( ':visible' ) == true ) {
							$( 'a#login-link-label' ).css( 'display', 'inline-block' );
							$( 'a#register-link-label' ).css( 'display', 'none' );
						}

						if ( $( '#loginform' ).is( ':visible' ) == true ) {
							$( 'a#login-link-label' ).css( 'display', 'none' );
							$( 'a#register-link-label' ).css( 'display', 'inline-block' );
						}

						if ( $( '#lostpasswordform' ).is( ':visible' ) == true ) {
							$( 'a#login-link-label' ).css( 'display', 'inline-block' );
							$( 'a#register-link-label' ).css( 'display', 'none' );
							$( 'a#crlpuic-lost-password-text' ).css( 'display', 'none' );
						}

					}
				);
			}
		);

		// Form text edit settings.
		wp.customize(
			'crlpuic-settings[username_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login span#crlpuic-username-label' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[password_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login span#crlpuic-password-label' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[rememberme_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login span#crlpuic-rememberme-label' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[lost_password_text]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login a#crlpuic-lost-password-text' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[back_to_website]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '.login a span#crlpuic-back-to-text' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_btn_text]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#loginform input.button-primary' ).prop( 'value', newValue );
					}
				);
			}
		);

		// Register Form text edit settings.
		wp.customize(
			'crlpuic-settings[register_username_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'span#crlpuic-register-username-label' ).text( newValue );
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[register_email_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'span#crlpuic-register-email-label' ).text( newValue );
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[registration_message]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'p#reg_passmail' ).text( newValue );
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[register_btn_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#registerform input.button-primary' ).prop( 'value', newValue );
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[register_link_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#register-link-label' ).prop( 'value', newValue );
					}
				);
			}
		);
		wp.customize(
			'crlpuic-settings[login_link_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( 'a#login-link-label' ).text( newValue );
					}
				);
			}
		);

		// Lost Password Form text edit settings.
		wp.customize(
			'crlpuic-settings[lost_pwd_username_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#lostpasswordform label span' ).text( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[lost_pwd_button_label]',
			function(value) {
				value.bind(
					function(newValue) {
						$( '#lostpasswordform input.button-primary' ).prop( 'value', newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[custom_css]',
			function(value) {
				value.bind(
					function(newValue) {
						var pen_icon_css = '.crlpuic-preview-event{display:inline-block;cursor:pointer;background-color:#008ec2;border-radius:100%;color:#fff;width:30px;height:25px;padding-top:5px;text-align:center;border:2px solid #fff;box-shadow:0 2px 1px rgba(46,68,83,.15)}';
						$( '#crlpuic-custom-login-inline-css' ).html( pen_icon_css + newValue );
					}
				);
			}
		);

		// Send "lpuic_focus_section" data over to the Customizer.

		$( document ).on(
			'click',
			'#crlpuic-content-edit',
			function() {
				wp.customize.preview.send( 'crlpuic_focus_section', $( this ).data( 'section' ) );
			}
		);

		$( '#crlpuic-loginform' ).click(
			function() {
				wp.customize.preview.send( 'crlpuic_focus_section', $( this ).data( 'section' ) );
			}
		);

		$( '#crlpuic-logo' ).click(
			function() {
				wp.customize.preview.send( 'crlpuic_focus_section', $( this ).data( 'section' ) );
			}
		);

		// Form show as per section selected.

		wp.customize.preview.bind(
			'change-form',
			function( form ) {

				if ( 'register' == form ) {

					$( '.crlpuic-enable-login' ).hide();
					$( '.crlpuic-enable-lostpassword' ).hide();
					$( '.crlpuic-enable-register' ).show();

				} else if ( 'lostpassword' == form ) {

					$( '.crlpuic-enable-login' ).hide();
					$( '.crlpuic-enable-register' ).hide();
					$( '.crlpuic-enable-lostpassword' ).show();

				} else {

					$( '.crlpuic-enable-register' ).hide();
					$( '.crlpuic-enable-lostpassword' ).hide();
					$( '.crlpuic-enable-login' ).show();

				}
			}
		);

	},

	hex_to_rbg = function( hex ) {

				var rgb = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );

				return rgb ? {
					r: parseInt( rgb[1], 16 ),
					g: parseInt( rgb[2], 16 ),
					b: parseInt( rgb[3], 16 )
		} : null;

	},

		/**
		 * Bind behavior to events.
		 */
		ready = function() {

			// Run on document ready.
			customizerControls();

		};

	// Only expose the ready function to the world.
	return {
		ready: ready
	};

})( wp, jQuery );

jQuery( crlpuic_customizer.ready );
