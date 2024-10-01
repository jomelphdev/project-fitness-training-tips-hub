/**
 * Handles custom controls of customizer.
 *
 * @package CR_Login_Page_UI_Customizer
 * @since 1.0.0
 */

var crlpuic_customizer_controls = (function(wp, $) {
	'use strict';
	/**
	 * Handles radio image control input selection.
	 *
	 * @since 1.0.0
	 */
	var radioControl = function() {

			wp.customize.controlConstructor['crlpuic_radio_image'] = wp.customize.Control.extend(
				{

					ready: function() {
						var control = this;

						$( 'select', control.container ).change(
							function() {
								control.setting.set( $( this ).val() );
							}
						);
					}

				}
			);
	},

	/**
	 * Handles range control input.
	 *
	 * @reference: https://github.com/maddisondesigns/customizer-custom-controls
	 *
	 * @since 1.0.0
	 */
	rangeControl = function() {

		// Set our slider defaults and initialise the slider.
		$( '.crlpuic-range-control' ).each(
			function() {
				var sliderValue     = $( this ).find( '.crlpuic-range-control-input' ).val();
				var rangeSlider     = $( this ).find( '.crlpuic-range-slider' );
				var sliderMinValue  = parseFloat( rangeSlider.attr( 'data-min' ) );
				var sliderMaxValue  = parseFloat( rangeSlider.attr( 'data-max' ) );
				var sliderStepValue = parseFloat( rangeSlider.attr( 'data-step' ) );

				rangeSlider.slider(
					{
						value: sliderValue,
						min: sliderMinValue,
						max: sliderMaxValue,
						step: sliderStepValue,
						change: function(e, ui) {
							// Trigger change event when slider movement is stopped so Customizer knows it has to save the field.
							$( this ).parent().find( '.crlpuic-range-control-input' ).trigger( 'change' );
						}
					}
				);
			}
		);

		// Change the value of the input field as the slider is moved.
		$( '.crlpuic-range-slider' ).on(
			'slide',
			function(event, ui) {
				$( this ).parent().find( '.crlpuic-range-control-input' ).val( ui.value );
			}
		);

		// Reset slider and input field back to the default value.
		$( '.crlpuic-range-slider-reset' ).on(
			'click',
			function() {
				var resetValue = $( this ).attr( 'data-reset' );

				$( this ).parent().find( '.crlpuic-range-control-input' ).val( resetValue );
				$( this ).parent().find( '.crlpuic-range-slider' ).slider( 'value', resetValue );
			}
		);

		// Update slider if the input field loses focus as it's most likely changed.
		$( '.customize-control-slider-value' ).blur(
			function() {
				var resetValue     = $( this ).val();
				var slider         = $( this ).parent().find( '.crlpuic-range-slider' );
				var sliderMinValue = parseInt( slider.attr( 'data-min' ) );
				var sliderMaxValue = parseInt( slider.attr( 'data-max' ) );

				// Make sure our manual input value doesn't exceed the minimum & maxmium values.
				if (resetValue < sliderMinValue) {
					resetValue = sliderMinValue;
					$( this ).val( resetValue );
				}

				if (resetValue > sliderMaxValue) {
					resetValue = sliderMaxValue;
					$( this ).val( resetValue );
				}

				$( this ).parent().find( '.crlpuic-range-slider' ).slider( 'value', resetValue );
			}
		);
	},

	/**
	 * Handles visibility of Logo Height control based on Logo Image value.
	 * if Logo Image is removed, the Logo Height control is hidden.
	 *
	 * @since 0.3.1
	 */
	toggleLogoHeightControl = function() {

		logoHeightVisibility( ! ! wp.customize( 'crlpuic_theme_custx[logo_url]' )() );

		wp.customize(
			'crlpuic_theme_custx[logo_url]',
			function(value) {
				value.bind(
					function(to) {
						// Show or hide Logo Height setting on changing Logo Image setting.
						logoHeightVisibility( ! ! to );
					}
				);
			}
		);
	},

	/**
	 * Shows or hides the Logo Height setting based on the supplied value.
	 *
	 * @since 0.3.1
	 */
	logoHeightVisibility = function(visible) {
		wp.customize.control( 'crlpuic_theme_custx[logo_height]' ).container.toggle( visible );
	},

	/**
	 * Handles toggle control input.
	 *
	 * @since 0.3.9
	 */
	toggleControl = function() {

		wp.customize.controlConstructor['crlpuic_toggle'] = wp.customize.Control.extend(
			{

				ready: function() {
					var control = this;

					this.container.on(
						'change',
						'input:checkbox',
						function() {
							value = this.checked ? true : false;
							control.setting.set( value );
						}
					);
				}

			}
		);
	},

	/**
	 * Toggle visibility of Customizer controls based on supplied setting.
	 *
	 * @since 0.3.9
	 */
	conditionalCustomizerControls = function() {

		toggleControlBySetting( 'login_template', 'background' );
		toggleControlBySetting( 'login_template', 'content_column_bg_color' );
		toggleControlBySetting( 'login_template', 'content_column_bg_color' );
		toggleControlBySetting( 'login_template', 'content_column_bg_opacity' );

		toggleControlBySetting( 'background', 'bg_image' );
		toggleControlBySetting( 'background', 'bg_overlay' );
		toggleControlBySetting( 'background', 'bg_color' );
		toggleControlBySetting( 'background', 'bg_opacity' );
		toggleControlBySetting( 'background', 'form_column_bg_img' );
		toggleControlBySetting( 'background', 'form_column_bg_color' );
		toggleControlBySetting( 'background', 'column_bg_opacity' );
		toggleControlBySetting( 'background', 'login_template' );
		toggleControlBySetting( 'background', 'form_column_bg_overlay' );
		toggleControlBySetting( 'background', 'column_width' );
		toggleControlBySetting( 'background', 'content_column_bg_color' );
		toggleControlBySetting( 'background', 'content_column_bg_opacity' );

		toggleControlBySetting( 'logo_settings', 'logo_title' );
		toggleControlBySetting( 'logo_settings', 'logo_title_color' );
		toggleControlBySetting( 'logo_settings', 'logo_title_font_size' );
		toggleControlBySetting( 'logo_settings', 'custom_logo' );
		toggleControlBySetting( 'logo_settings', 'custom_logo_height' );

		toggleControlBySetting( 'transparent_background', 'form_background_color' );
		toggleControlBySetting( 'transparent_background', 'form_wrapper' );

	},

	/**
	 * Hide or show a control based on supplied Customizer setting.
	 *
	 * @since 1.0.0
	 */
	toggleControlBySetting = function( setting, control ) {

		if ( setting == 'login_template' ) {

			if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
				toggleThisControl( false, 'content_title' );
				toggleThisControl( false, 'content_title_color' );
				toggleThisControl( false, 'content_desc' );
				toggleThisControl( false, 'content_desc_color' );
				toggleThisControl( false, 'content_img' );
				toggleThisControl( false, 'column_width' );
				toggleThisControl( false, 'form_column_bg_img' );
				toggleThisControl( false, 'form_column_bg_color' );
				toggleThisControl( false, 'column_bg_opacity' );
				toggleThisControl( false, 'section_separator_content_column' );
				toggleThisControl( false, 'section_separator_bg_column' );

			} else {
				toggleThisControl( true, 'content_title' );
				toggleThisControl( true, 'content_title_color' );
				toggleThisControl( true, 'content_desc' );
				toggleThisControl( true, 'content_desc_color' );
				toggleThisControl( true, 'content_img' );
				toggleThisControl( true, 'column_width' );
				toggleThisControl( true, 'section_separator_content_column' );
				toggleThisControl( true, 'section_separator_bg_column' );
				toggleThisControl( true, 'form_column_bg_color' );
				if ( 'bg_color' == wp.customize( 'crlpuic-settings[background]' )() ) {
					toggleThisControl( false, 'form_column_bg_img' );
					toggleThisControl( false, 'column_bg_opacity' );
				} else if ( 'bg_image' == wp.customize( 'crlpuic-settings[background]' )() ) {
					toggleThisControl( true, 'form_column_bg_img' );
					toggleThisControl( true, 'column_bg_opacity' );
				}
			}

		} else if ( setting == 'background' ) {
			if ( 'bg_color' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
				toggleThisControl( true, 'bg_color' );
				toggleThisControl( true, 'form_column_bg_color' );
				toggleThisControl( false, 'bg_image' );
				toggleThisControl( false, 'bg_overlay' );
				toggleThisControl( false, 'bg_opacity' );
				toggleThisControl( false, 'form_column_bg_img' );
				toggleThisControl( false, 'column_bg_opacity' );
				if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
					toggleThisControl( false, 'content_title' );
					toggleThisControl( false, 'content_title_color' );
					toggleThisControl( false, 'content_desc' );
					toggleThisControl( false, 'content_desc_color' );
					toggleThisControl( false, 'content_img' );
					toggleThisControl( false, 'column_width' );
					toggleThisControl( false, 'form_column_bg_img' );
					toggleThisControl( false, 'form_column_bg_color' );
					toggleThisControl( false, 'column_bg_opacity' );
					toggleThisControl( false, 'section_separator_content_column' );
					toggleThisControl( false, 'section_separator_bg_column' );
				} else {
					toggleThisControl( true, 'content_title' );
					toggleThisControl( true, 'content_title_color' );
					toggleThisControl( true, 'content_desc' );
					toggleThisControl( true, 'content_desc_color' );
					toggleThisControl( true, 'content_img' );
					toggleThisControl( true, 'column_width' );
					toggleThisControl( true, 'form_column_bg_color' );
					toggleThisControl( true, 'section_separator_content_column' );
					toggleThisControl( true, 'section_separator_bg_column' );
				}

				if ( 'left_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'right_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
					toggleThisControl( false, 'bg_color' );
				}
			} else if ( 'bg_image' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
				toggleThisControl( true, 'bg_image' );
				toggleThisControl( true, 'form_column_bg_img' );
				toggleThisControl( true, 'bg_opacity' );
				toggleThisControl( true, 'form_column_bg_img' );
				toggleThisControl( true, 'column_bg_opacity' );
				toggleThisControl( true, 'bg_overlay' );
				toggleThisControl( false, 'bg_color' );
				toggleThisControl( true, 'form_column_bg_color' );

				if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
					toggleThisControl( false, 'content_title' );
					toggleThisControl( false, 'content_title_color' );
					toggleThisControl( false, 'content_desc' );
					toggleThisControl( false, 'content_desc_color' );
					toggleThisControl( false, 'content_img' );
					toggleThisControl( false, 'column_width' );
					toggleThisControl( false, 'form_column_bg_img' );
					toggleThisControl( false, 'form_column_bg_color' );
					toggleThisControl( false, 'column_bg_opacity' );
					toggleThisControl( false, 'section_separator_content_column' );
					toggleThisControl( false, 'section_separator_bg_column' );

				} else {
					toggleThisControl( true, 'content_title' );
					toggleThisControl( true, 'content_title_color' );
					toggleThisControl( true, 'content_desc' );
					toggleThisControl( true, 'content_desc_color' );
					toggleThisControl( true, 'content_img' );
					toggleThisControl( true, 'form_column_bg_color' );
					toggleThisControl( true, 'section_separator_content_column' );
					toggleThisControl( true, 'section_separator_bg_column' );
				}
			}
		} else if ( setting == 'logo_settings' ) {

			if ( 'hide_logo' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
				toggleThisControl( false, 'custom_logo' );
				toggleThisControl( false, 'custom_logo_height' );
				toggleThisControl( false, 'logo_title' );
				toggleThisControl( false, 'logo_title_color' );
				toggleThisControl( false, 'logo_title_font_size' );
			} else if ( 'show_logo' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
				toggleThisControl( true, 'custom_logo' );
				toggleThisControl( true, 'custom_logo_height' );
				toggleThisControl( false, 'logo_title' );
				toggleThisControl( false, 'logo_title_color' );
				toggleThisControl( false, 'logo_title_font_size' );
			} else if ( 'show_title' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
				toggleThisControl( false, 'custom_logo' );
				toggleThisControl( false, 'custom_logo_height' );
				toggleThisControl( true, 'logo_title' );
				toggleThisControl( true, 'logo_title_color' );
				toggleThisControl( true, 'logo_title_font_size' );
			}

		} else if ( setting == 'transparent_background' ) {
			toggleThisControl( ! wp.customize( 'crlpuic-settings[' + setting + ']' )(), control );
		} else {
			toggleThisControl( ! ! wp.customize( 'crlpuic-settings[' + setting + ']' )(), control );
		}

		wp.customize(
			'crlpuic-settings[' + setting + ']',
			function( value ) {
				value.bind(
					function( to ) {
						// Show or hide Logo Height setting on changing Logo Image setting.
						if ( control == 'form_background_color' || control == 'form_wrapper' ) {
							toggleThisControl( ! to, control );
						} else if ( setting == 'login_template' ) {
							if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
								toggleThisControl( false, 'content_title' );
								toggleThisControl( false, 'content_title_color' );
								toggleThisControl( false, 'content_desc' );
								toggleThisControl( false, 'content_desc_color' );
								toggleThisControl( false, 'content_img' );
								toggleThisControl( false, 'content_column_bg_color' );
								toggleThisControl( false, 'content_column_bg_opacity' );
								toggleThisControl( false, 'column_width' );
								toggleThisControl( false, 'form_column_bg_img' );
								toggleThisControl( false, 'form_column_bg_color' );
								toggleThisControl( false, 'column_bg_opacity' );
								toggleThisControl( false, 'section_separator_content_column' );
								toggleThisControl( false, 'section_separator_bg_column' );

							} else {
								toggleThisControl( true, 'content_title' );
								toggleThisControl( true, 'content_title_color' );
								toggleThisControl( true, 'content_desc' );
								toggleThisControl( true, 'content_desc_color' );
								toggleThisControl( true, 'content_img' );
								toggleThisControl( true, 'content_column_bg_color' );
								toggleThisControl( true, 'content_column_bg_opacity' );
								toggleThisControl( true, 'column_width' );
								toggleThisControl( true, 'section_separator_content_column' );
								toggleThisControl( true, 'section_separator_bg_column' );
								toggleThisControl( true, 'form_column_bg_color' );
								if ( 'bg_color' == wp.customize( 'crlpuic-settings[background]' )() ) {
									toggleThisControl( false, 'form_column_bg_img' );
									toggleThisControl( false, 'column_bg_opacity' );
								} else if ( 'bg_image' == wp.customize( 'crlpuic-settings[background]' )() ) {
									toggleThisControl( true, 'form_column_bg_img' );
									toggleThisControl( true, 'column_bg_opacity' );
								}
							}

						} else if ( setting == 'background' ) {
							if ( 'bg_color' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
								toggleThisControl( true, 'bg_color' );
								toggleThisControl( true, 'form_column_bg_color' );
								toggleThisControl( false, 'bg_image' );
								toggleThisControl( false, 'bg_overlay' );
								toggleThisControl( false, 'bg_opacity' );
								toggleThisControl( false, 'form_column_bg_img' );
								toggleThisControl( false, 'column_bg_opacity' );
								if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
									toggleThisControl( false, 'content_title' );
									toggleThisControl( false, 'content_title_color' );
									toggleThisControl( false, 'content_desc' );
									toggleThisControl( false, 'content_desc_color' );
									toggleThisControl( false, 'content_img' );
									toggleThisControl( false, 'content_column_bg_color' );
									toggleThisControl( false, 'content_column_bg_opacity' );
									toggleThisControl( false, 'column_width' );
									toggleThisControl( false, 'form_column_bg_img' );
									toggleThisControl( false, 'form_column_bg_color' );
									toggleThisControl( false, 'column_bg_opacity' );
									toggleThisControl( false, 'section_separator_content_column' );
									toggleThisControl( false, 'section_separator_bg_column' );
								} else {
									toggleThisControl( true, 'content_column_bg_color' );
									toggleThisControl( true, 'content_column_bg_opacity' );
									toggleThisControl( true, 'content_title' );
									toggleThisControl( true, 'content_title_color' );
									toggleThisControl( true, 'content_desc' );
									toggleThisControl( true, 'content_desc_color' );
									toggleThisControl( true, 'content_img' );
									toggleThisControl( true, 'column_width' );
									toggleThisControl( true, 'form_column_bg_color' );
									toggleThisControl( true, 'section_separator_content_column' );
									toggleThisControl( true, 'section_separator_bg_column' );
								}

								if ( 'left_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'right_form' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
									toggleThisControl( false, 'bg_color' );
								}

							} else if ( 'bg_image' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
								toggleThisControl( true, 'bg_image' );
								toggleThisControl( true, 'form_column_bg_img' );
								toggleThisControl( true, 'bg_opacity' );
								toggleThisControl( true, 'form_column_bg_img' );
								toggleThisControl( true, 'column_bg_opacity' );
								toggleThisControl( true, 'bg_overlay' );
								toggleThisControl( false, 'bg_color' );
								toggleThisControl( true, 'form_column_bg_color' );

								if ( 'center_form' == wp.customize( 'crlpuic-settings[login_template]' )() || 'center_form_1' == wp.customize( 'crlpuic-settings[login_template]' )() ) {
									toggleThisControl( false, 'content_title' );
									toggleThisControl( false, 'content_title_color' );
									toggleThisControl( false, 'content_desc' );
									toggleThisControl( false, 'content_desc_color' );
									toggleThisControl( false, 'content_img' );
									toggleThisControl( false, 'content_column_bg_color' );
									toggleThisControl( false, 'content_column_bg_opacity' );
									toggleThisControl( false, 'column_width' );
									toggleThisControl( false, 'form_column_bg_img' );
									toggleThisControl( false, 'form_column_bg_color' );
									toggleThisControl( false, 'column_bg_opacity' );
									toggleThisControl( false, 'section_separator_content_column' );
									toggleThisControl( false, 'section_separator_bg_column' );

								} else {
									toggleThisControl( true, 'content_column_bg_color' );
									toggleThisControl( true, 'content_column_bg_opacity' );
									toggleThisControl( true, 'content_title' );
									toggleThisControl( true, 'content_title_color' );
									toggleThisControl( true, 'content_desc' );
									toggleThisControl( true, 'content_desc_color' );
									toggleThisControl( true, 'content_img' );
									toggleThisControl( true, 'form_column_bg_color' );
									toggleThisControl( true, 'section_separator_content_column' );
									toggleThisControl( true, 'section_separator_bg_column' );
								}
							}
						} else if ( 'logo_settings' == setting ) {

							if ( 'hide_logo' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
									toggleThisControl( false, 'custom_logo' );
									toggleThisControl( false, 'custom_logo_height' );
									toggleThisControl( false, 'logo_title' );
									toggleThisControl( false, 'logo_title_color' );
									toggleThisControl( false, 'logo_title_font_size' );
							} else if ( 'show_logo' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
								toggleThisControl( true, 'custom_logo' );
								toggleThisControl( true, 'custom_logo_height' );
								toggleThisControl( false, 'logo_title' );
								toggleThisControl( false, 'logo_title_color' );
								toggleThisControl( false, 'logo_title_font_size' );
							} else if ( 'show_title' == wp.customize( 'crlpuic-settings[' + setting + ']' )() ) {
								toggleThisControl( false, 'custom_logo' );
								toggleThisControl( false, 'custom_logo_height' );
								toggleThisControl( true, 'logo_title' );
								toggleThisControl( true, 'logo_title_color' );
								toggleThisControl( true, 'logo_title_font_size' );
							}
						} else {
							toggleThisControl( ! ! to, control );

						}
					}
				);
			}
		);
	},

	toggleThisControl = function( visible, control ) {

			wp.customize.control( 'crlpuic-settings[' + control + ']' ).container.toggle( visible );
			wp.customize.control( 'crlpuic-settings[' + control + ']' ).container.addClass( 'visible', visible );
	},

	onToggleSettingsUpdated = function() {

		wp.customize(
			'crlpuic-settings[login_template]',
			function( value ) {
				value.bind(
					function( newValue ) {
						var template = $( 'input[name="_customize-crlpuic_radio_image-crlpuic-settings[login_template]"]:checked' ).attr( "data-template" );
						// Converting JSON encoded string to JS object.
						var obj = JSON.parse( template );
						wp.customize( 'crlpuic-settings[login_template]' ).set( obj.login_template );
						wp.customize( 'crlpuic-settings[background]' ).set( obj.background );
						wp.customize( 'crlpuic-settings[bg_image]' ).set( obj.bg_image );
						wp.customize( 'crlpuic-settings[bg_overlay]' ).set( obj.bg_overlay );
						wp.customize( 'crlpuic-settings[bg_color]' ).set( obj.bg_color );
						wp.customize( 'crlpuic-settings[bg_opacity]' ).set( obj.bg_opacity );
						wp.customize( 'crlpuic-settings[form_column_bg_color]' ).set( obj.form_column_bg_color );
						wp.customize( 'crlpuic-settings[column_bg_opacity]' ).set( obj.column_bg_opacity );
						wp.customize( 'crlpuic-settings[form_column_bg_img]' ).set( obj.form_column_bg_img );
						wp.customize( 'crlpuic-settings[form_column_bg_overlay]' ).set( obj.form_column_bg_overlay );
						wp.customize( 'crlpuic-settings[column_width]' ).set( obj.column_width );
						wp.customize( 'crlpuic-settings[content_column_bg_color]' ).set( obj.content_column_bg_color );
						wp.customize( 'crlpuic-settings[content_title]' ).set( obj.content_title );
						wp.customize( 'crlpuic-settings[content_title_color]' ).set( obj.content_title_color );
						wp.customize( 'crlpuic-settings[content_desc]' ).set( obj.content_desc );
						wp.customize( 'crlpuic-settings[content_desc_color]' ).set( obj.content_desc_color );
						wp.customize( 'crlpuic-settings[content_img]' ).set( obj.content_img );
						wp.customize( 'crlpuic-settings[content_column_bg_opacity]' ).set( obj.content_column_bg_opacity );
						wp.customize( 'crlpuic-settings[logo_settings]' ).set( obj.logo_settings );
						wp.customize( 'crlpuic-settings[logo_title]' ).set( obj.logo_title );
						wp.customize( 'crlpuic-settings[logo_title_color]' ).set( obj.logo_title_color );
						wp.customize( 'crlpuic-settings[logo_title_font_size]' ).set( obj.logo_title_font_size );
						wp.customize( 'crlpuic-settings[custom_logo]' ).set( obj.custom_logo );
						wp.customize( 'crlpuic-settings[custom_logo_height]' ).set( obj.custom_logo_height );
						wp.customize( 'crlpuic-settings[form_width]' ).set( obj.form_width );
						wp.customize( 'crlpuic-settings[form_background_color]' ).set( obj.form_background_color );
						wp.customize( 'crlpuic-settings[transparent_background]' ).set( obj.transparent_background );
						wp.customize( 'crlpuic-settings[form_wrapper]' ).set( obj.form_wrapper );
						wp.customize( 'crlpuic-settings[field_icons]' ).set( obj.field_icons );
						wp.customize( 'crlpuic-settings[username_label]' ).set( obj.username_label );
						wp.customize( 'crlpuic-settings[password_label]' ).set( obj.password_label );
						wp.customize( 'crlpuic-settings[form_label_color]' ).set( obj.form_label_color );
						wp.customize( 'crlpuic-settings[form_label_font_size]' ).set( obj.form_label_font_size );
						wp.customize( 'crlpuic-settings[login_btn_bg_color]' ).set( obj.login_btn_bg_color );
						wp.customize( 'crlpuic-settings[login_btn_bg_hover]' ).set( obj.login_btn_bg_hover );
						wp.customize( 'crlpuic-settings[login_btn_txt_color]' ).set( obj.login_btn_txt_color );
						wp.customize( 'crlpuic-settings[login_btn_font_size]' ).set( obj.login_btn_font_size );
						wp.customize( 'crlpuic-settings[rememberme_hide]' ).set( obj.rememberme_hide );
						wp.customize( 'crlpuic-settings[hide_links]' ).set( obj.hide_links );
						wp.customize( 'crlpuic-settings[custom_css]' ).set( obj.custom_css );

					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[login_template]',
			function( value ) {
				value.bind(
					function( newValue ) {
						wp.customize( 'crlpuic-settings[login_template]' ).set( newValue );
					}
				);
			}
		);

		wp.customize(
			'crlpuic-settings[transparent_background]',
			function( value ) {
				value.bind(
					function( newValue ) {
						wp.customize( 'crlpuic-settings[form_wrapper]' ).set( newValue );
					}
				);
			}
		);
	},

	enable_login_section = function(){
		// Detect when the login page panel is opened (or closed).
		wp.customize.panel(
			'crlpuic-settings',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						var loginURL = crlpuic_Urls.siteurl + '?crlpuic-login-page-customizer-customization=true';

						// isExpanding will be true if you're entering the section.

						if ( isExpanding ) {
								wp.customize.previewer.previewUrl.set( loginURL );
						} else {
							wp.customize.previewer.previewUrl.set( crlpuic_Urls.siteurl );
						}

					}
				);

			}
		);

		wp.customize.section(
			'crlpuic_register_form_section',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
								wp.customize.previewer.send( 'change-form', 'register' );
						} else {
							wp.customize.previewer.send( 'change-form', 'login' );
						}
					}
				);
			}
		);

		wp.customize.section(
			'crlpuic_lost_pwd_form_text_edit_section',
			function ( section ) {
				section.expanded.bind(
					function ( isExpanding ) {
						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						if ( isExpanding ) {
								wp.customize.previewer.send( 'change-form', 'lostpassword' );
						} else {
							wp.customize.previewer.send( 'change-form', 'login' );
						}
					}
				);
			}
		);
	},

	// Listen to previewer events.
	focus_to_section = function(){

		// Listen to the "lpuic_focus_section" event has been triggered from the Previewer.
		wp.customize.previewer.bind(
			'crlpuic_focus_section',
			function( data ) {

				var section = wp.customize.section( data );

				if ( undefined !== section ) {
					section.focus();
				}

			}
		);

	},

	/**
	 * Bind behavior to events.
	 */
	ready = function() {

		// Run on document ready.
		radioControl();
		rangeControl();
		// toggleLogoHeightControl(); // Logo height control function.
		toggleControl();
		conditionalCustomizerControls();
		onToggleSettingsUpdated();
		enable_login_section();
		focus_to_section();
	};

	// Only expose the ready function to the world.
	return {
		ready: ready
	};
})( wp, jQuery );

jQuery( crlpuic_customizer_controls.ready );
