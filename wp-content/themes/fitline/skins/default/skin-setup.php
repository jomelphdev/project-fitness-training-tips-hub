<?php
/**
 * Skin Setup
 *
 * @package FITLINE
 * @since FITLINE 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'fitline_theme_defaults' ) ) {
	function fitline_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'fitline_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'fitline_filter_load_woocommerce_extensions', 'fitline_skin_woocommerce_allow_extensions' );
	function fitline_skin_woocommerce_allow_extensions( $allow ) {
		return false;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup', 1 );
	function fitline_skin_setup() {

		$GLOBALS['FITLINE_STORAGE'] = array_merge( $GLOBALS['FITLINE_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-axiom',

			'theme_doc_url'       => '//fitline.axiomthemes.com/doc',

			'theme_demofiles_url' => '//demofiles.axiomthemes.com/fitline/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom

			'theme_video_url'     => '//www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',   // Axiom

			'theme_privacy_url'   => '//axiomthemes.com/privacy-policy/',                    // Axiom

			'portfolio_url'       => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom


			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'fitline_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_settings', 1 );
	function fitline_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		fitline_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		fitline_storage_set_array2( 'required_plugins', 'leadin', 'install', false);
		fitline_storage_set_array2( 'required_plugins', 'instagram-feed', 'install', false);
		fitline_storage_set_array2( 'required_plugins', 'revslider', 'install', true);
	}
}

// Add/remove/change Theme Options
if ( ! function_exists( 'fitline_skin_setup_options' ) ) {
    add_action( 'after_setup_theme', 'fitline_skin_setup_options', 3 );
    function fitline_skin_setup_options()  {
		fitline_storage_set_array2( 'options', 'color_scheme', 'std', 'light' );
		fitline_storage_set_array2( 'options', 'sidebar_scheme', 'std', 'light' );
        fitline_storage_set_array2( 'options', 'footer_scheme', 'std', 'dark' );
    }
}

// Enqueue extra styles for frontend
if ( ! function_exists( 'fitline_trx_addons_extra_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'fitline_trx_addons_extra_styles', 2060 );
    function fitline_trx_addons_extra_styles() {
        $fitline_url = fitline_get_file_url( 'extra-styles.css' );
        if ( '' != $fitline_url ) {
            wp_enqueue_style( 'fitline-trx-addons-extra-styles', $fitline_url, array(), null );
        }
    }
}

//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_fonts', 1 );
	function fitline_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		fitline_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'semplicitapro',
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/yyi3lii.css',
					'styles' => ''
				),
				// Google font
				array(
					'name'   => 'Kumbh Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'wght@100;200;300;400;500;600;700;800;900',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		fitline_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => fitline_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'fitline' );

		fitline_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'fitline' ) ),
					'font-family'     => '"Kumbh Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.647em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.7em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'fitline' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '3.352em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.12em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.6px',
					'margin-top'      => '1.14em',
					'margin-bottom'   => '0.43em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '2.764em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.12em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.1px',
					'margin-top'      => '0.85em',
					'margin-bottom'   => '0.5em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '2.058em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.09em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.24em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '1.647em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.5em',
					'margin-bottom'   => '0.76em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '1.411em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.208em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.65em',
					'margin-bottom'   => '0.86em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '1.117em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.473em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2.4em',
					'margin-bottom'   => '1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'fitline' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'fitline' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'fitline' ) ),
					'font-family'     => 'semplicitapro,sans-serif',
					'font-size'       => '17px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'fitline' ) ),
					'font-family'     => '"Kumbh Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'fitline' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'fitline' ) ),
                    'font-family'     => '"Kumbh Sans",sans-serif',
                ),
			)
		);

		// Font presets
		fitline_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'fitline' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'fitline' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'fitline' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_schemes', 1 );
	function fitline_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		fitline_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'fitline' ),
					'description' => esc_html__( 'Colors of the main content area', 'fitline' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'fitline' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'fitline' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'fitline' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'fitline' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'fitline' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'fitline' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'fitline' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'fitline' ),
				),
			)
		);

		fitline_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'fitline' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'fitline' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'fitline' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'fitline' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'fitline' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'fitline' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'fitline' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'fitline' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'fitline' ),
					'description' => esc_html__( 'Color of the text inside this block', 'fitline' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'fitline' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'fitline' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'fitline' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'fitline' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'fitline' ),
					'description' => esc_html__( 'Color of the links inside this block', 'fitline' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'fitline' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'fitline' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'fitline' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'fitline' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'fitline' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'fitline' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'fitline' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'fitline' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'fitline' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'fitline' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F7F9F2', //ok +
					'bd_color'         => '#E0E3D8', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#18240A', //ok +
					'text_link'        => '#7FB951', //ok +
					'text_hover'       => '#62A230', //ok +
					'text_link2'       => '#FFA01E', //ok +
					'text_hover2'      => '#ED8A00', //ok +
					'text_link3'       => '#FF5C1E', //ok +
					'text_hover3'      => '#DE4A13', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#ECF0E2', //ok +
					'alter_bd_color'   => '#E0E3D8', //ok +
					'alter_bd_hover'   => '#CCD0C5', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#18240A', //ok +
					'alter_link'       => '#7FB951', //ok +
					'alter_hover'      => '#62A230', //ok +
					'alter_link2'      => '#FFA01E', //ok +
					'alter_hover2'     => '#ED8A00', //ok +
					'alter_link3'      => '#FF5C1E', //ok +
					'alter_hover3'     => '#DE4A13', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1E2B0E', //ok +
					'extra_bg_hover'   => '#30431B', 
					'extra_bd_color'   => '#465236', //ok +
					'extra_bd_hover'   => '#3A4A3C',
					'extra_text'       => '#C6CEBA', //ok +
					'extra_light'      => '#7D837D',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7FB951', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FFA01E',
					'extra_hover2'     => '#ED8A00',
					'extra_link3'      => '#FF5C1E',
					'extra_hover3'     => '#DE4A13',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E0E3D8', //ok +
					'input_bd_hover'   => '#CCD0C5', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#18240A', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#18240A', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#18240A', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#273615', //ok +
					'bd_color'         => '#465236', //ok +

					// Text and links colors
					'text'             => '#969F96', //ok +
					'text_light'       => '#7D837D', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#7FB951', //ok +
					'text_hover'       => '#62A230', //ok +
					'text_link2'       => '#FFA01E', //ok +
					'text_hover2'      => '#ED8A00', //ok +
					'text_link3'       => '#FF5C1E', //ok +
					'text_hover3'      => '#DE4A13', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#2D3E19', //ok +
					'alter_bg_hover'   => '#354A1E', //ok +
					'alter_bd_color'   => '#465236', //ok +
					'alter_bd_hover'   => '#566246', //ok +
					'alter_text'       => '#969F96', //ok +
					'alter_light'      => '#7D837D', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#7FB951', //ok +
					'alter_hover'      => '#62A230', //ok +
					'alter_link2'      => '#FFA01E', //ok +
					'alter_hover2'     => '#ED8A00', //ok +
					'alter_link3'      => '#FF5C1E', //ok +
					'alter_hover3'     => '#DE4A13', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1E2B0E', //ok +
					'extra_bg_hover'   => '#30431B', 
					'extra_bd_color'   => '#465236', //ok +
					'extra_bd_hover'   => '#566246',
                    'extra_text'       => '#C6CEBA', //ok +
					'extra_light'      => '#7D837D',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7FB951', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FFA01E',
					'extra_hover2'     => '#ED8A00',
					'extra_link3'      => '#FF5C1E',
					'extra_hover3'     => '#DE4A13',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#465236', //ok +
					'input_bd_hover'   => '#566246', //ok +
					'input_text'       => '#969F96', //ok +
					'input_light'      => '#7D837D', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#18240A', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#18240A', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#E0E3D8', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#18240A', //ok +
					'text_link'        => '#7FB951', //ok +
					'text_hover'       => '#62A230', //ok +
					'text_link2'       => '#FFA01E', //ok +
					'text_hover2'      => '#ED8A00', //ok +
					'text_link3'       => '#FF5C1E', //ok +
					'text_hover3'      => '#DE4A13', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F7F9F2', //ok +
					'alter_bg_hover'   => '#EBEEE0', //ok +
					'alter_bd_color'   => '#E0E3D8', //ok +
					'alter_bd_hover'   => '#CCD0C5', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#18240A', //ok +
					'alter_link'       => '#7FB951', //ok +
					'alter_hover'      => '#62A230', //ok +
					'alter_link2'      => '#FFA01E', //ok +
					'alter_hover2'     => '#ED8A00', //ok +
					'alter_link3'      => '#FF5C1E', //ok +
					'alter_hover3'     => '#DE4A13', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1E2B0E', //ok +
					'extra_bg_hover'   => '#30431B', 
					'extra_bd_color'   => '#465236', //ok +
					'extra_bd_hover'   => '#3A4A3C',
					'extra_text'       => '#C6CEBA', //ok +
					'extra_light'      => '#7D837D',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#7FB951', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#FFA01E',
					'extra_hover2'     => '#ED8A00',
					'extra_link3'      => '#FF5C1E',
					'extra_hover3'     => '#DE4A13',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#E0E3D8', //ok +
					'input_bd_hover'   => '#CCD0C5', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#18240A', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#18240A', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#18240A', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'aqua_default'
			'aqua_default' => array(
				'title'    => esc_html__( 'Aqua Default', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FDF8F6', //ok +
					'bd_color'         => '#EFEAE4', //ok +

					// Text and links colors
					'text'             => '#7F7C79', //ok +
					'text_light'       => '#A59D95', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#66B6BB', //ok +
					'text_hover'       => '#4C9A9F', //ok +
					'text_link2'       => '#E8B395', //ok +
					'text_hover2'      => '#CB9678', //ok +
					'text_link3'       => '#00646B', //ok +
					'text_hover3'      => '#085157', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#FAF1EC', //ok +
					'alter_bd_color'   => '#EFEAE4', //ok +
					'alter_bd_hover'   => '#C7C0B6', //ok +
					'alter_text'       => '#7F7C79', //ok +
					'alter_light'      => '#A59D95', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#66B6BB', //ok +
					'alter_hover'      => '#4C9A9F', //ok +
					'alter_link2'      => '#E8B395', //ok +
					'alter_hover2'     => '#CB9678', //ok +
					'alter_link3'      => '#00646B', //ok +
					'alter_hover3'     => '#085157', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1511', //ok +
					'extra_bg_hover'   => '#2E2721', 
					'extra_bd_color'   => '#403D37', //ok +
					'extra_bd_hover'   => '#534F47',
					'extra_text'       => '#AEA59A', //ok +
					'extra_light'      => '#989796',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#66B6BB', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#E8B395',
					'extra_hover2'     => '#CB9678',
					'extra_link3'      => '#00646B',
					'extra_hover3'     => '#085157',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#EFEAE4', //ok +
					'input_bd_hover'   => '#C7C0B6', //ok +
					'input_text'       => '#7F7C79', //ok +
					'input_light'      => '#A59D95', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'aqua_dark'
			'aqua_dark'    => array(
				'title'    => esc_html__( 'Aqua Dark', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#211C17', //ok +
					'bd_color'         => '#3E3B38', //ok +

					// Text and links colors
					'text'             => '#D5D4D2', //ok +
					'text_light'       => '#989796', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#66B6BB', //ok +
					'text_hover'       => '#4C9A9F', //ok +
					'text_link2'       => '#E8B395', //ok +
					'text_hover2'      => '#CB9678', //ok +
					'text_link3'       => '#00646B', //ok +
					'text_hover3'      => '#085157', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#27211C', //ok +
					'alter_bg_hover'   => '#2E2721', //ok +
					'alter_bd_color'   => '#3E3B38', //ok +
					'alter_bd_hover'   => '#514D49', //ok +
					'alter_text'       => '#D5D4D2', //ok +
					'alter_light'      => '#989796', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#66B6BB', //ok +
					'alter_hover'      => '#4C9A9F', //ok +
					'alter_link2'      => '#E8B395', //ok +
					'alter_hover2'     => '#CB9678', //ok +
					'alter_link3'      => '#00646B', //ok +
					'alter_hover3'     => '#085157', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1511', //ok +
					'extra_bg_hover'   => '#2E2721', 
					'extra_bd_color'   => '#403D37', //ok +
					'extra_bd_hover'   => '#534F47',
					'extra_text'       => '#AEA59A', //ok +
					'extra_light'      => '#989796',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#66B6BB', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#E8B395',
					'extra_hover2'     => '#CB9678',
					'extra_link3'      => '#00646B',
					'extra_hover3'     => '#085157',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#3E3B38', //ok +
					'input_bd_hover'   => '#514D49', //ok +
					'input_text'       => '#D5D4D2', //ok +
					'input_light'      => '#989796', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#0C0F26', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'aqua_light'
			'aqua_light' => array(
				'title'    => esc_html__( 'Aqua Light', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#EFEAE4', //ok +

					// Text and links colors
					'text'             => '#7F7C79', //ok +
					'text_light'       => '#A59D95', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#66B6BB', //ok +
					'text_hover'       => '#4C9A9F', //ok +
					'text_link2'       => '#E8B395', //ok +
					'text_hover2'      => '#CB9678', //ok +
					'text_link3'       => '#00646B', //ok +
					'text_hover3'      => '#085157', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FDF8F6', //ok +
					'alter_bg_hover'   => '#F4EBE6', //ok +
					'alter_bd_color'   => '#EFEAE4', //ok +
					'alter_bd_hover'   => '#C7C0B6', //ok +
					'alter_text'       => '#7F7C79', //ok +
					'alter_light'      => '#A59D95', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#66B6BB', //ok +
					'alter_hover'      => '#4C9A9F', //ok +
					'alter_link2'      => '#E8B395', //ok +
					'alter_hover2'     => '#CB9678', //ok +
					'alter_link3'      => '#00646B', //ok +
					'alter_hover3'     => '#085157', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1511', //ok +
					'extra_bg_hover'   => '#2E2721', 
					'extra_bd_color'   => '#403D37', //ok +
					'extra_bd_hover'   => '#534F47',
					'extra_text'       => '#AEA59A', //ok +
					'extra_light'      => '#989796',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#66B6BB', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#E8B395',
					'extra_hover2'     => '#CB9678',
					'extra_link3'      => '#00646B',
					'extra_hover3'     => '#085157',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#EFEAE4', //ok +
					'input_bd_hover'   => '#C7C0B6', //ok +
					'input_text'       => '#7F7C79', //ok +
					'input_light'      => '#A59D95', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'orange_default'
			'orange_default' => array(
				'title'    => esc_html__( 'Orange Default', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#EFF6F7', //ok +
					'bd_color'         => '#D0D6DD', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#F85600', //ok +
					'text_hover'       => '#E34F00', //ok +
					'text_link2'       => '#F8B500', //ok +
					'text_hover2'      => '#E6A901', //ok +
					'text_link3'       => '#6ABC56', //ok +
					'text_hover3'      => '#5EA54D', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E5ECED', //ok +
					'alter_bd_color'   => '#D0D6DD', //ok +
					'alter_bd_hover'   => '#C0C5CB', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#F85600', //ok +
					'alter_hover'      => '#E34F00', //ok +
					'alter_link2'      => '#F8B500', //ok +
					'alter_hover2'     => '#E6A901', //ok +
					'alter_link3'      => '#6ABC56', //ok +
					'alter_hover3'     => '#5EA54D', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12141A', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333740', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#ACACAC', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F85600', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#F8B500',
					'extra_hover2'     => '#E6A901',
					'extra_link3'      => '#6ABC56',
					'extra_hover3'     => '#5EA54D',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D0D6DD', //ok +
					'input_bd_hover'   => '#C0C5CB', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'orange_dark'
			'orange_dark'    => array(
				'title'    => esc_html__( 'Orange Dark', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#171A21', //ok +
					'bd_color'         => '#313540', //ok +

					// Text and links colors
					'text'             => '#D0D1D2', //ok +
					'text_light'       => '#96999F', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#F85600', //ok +
					'text_hover'       => '#E34F00', //ok +
					'text_link2'       => '#F8B500', //ok +
					'text_hover2'      => '#E6A901', //ok +
					'text_link3'       => '#6ABC56', //ok +
					'text_hover3'      => '#5EA54D', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1D2029', //ok +
					'alter_bg_hover'   => '#252935', //ok +
					'alter_bd_color'   => '#313540', //ok +
					'alter_bd_hover'   => '#3F4452', //ok +
					'alter_text'       => '#D0D1D2', //ok +
					'alter_light'      => '#96999F', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#F85600', //ok +
					'alter_hover'      => '#E34F00', //ok +
					'alter_link2'      => '#F8B500', //ok +
					'alter_hover2'     => '#E6A901', //ok +
					'alter_link3'      => '#6ABC56', //ok +
					'alter_hover3'     => '#5EA54D', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12141A', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333740', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#ACACAC', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F85600', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#F8B500',
					'extra_hover2'     => '#E6A901',
					'extra_link3'      => '#6ABC56',
					'extra_hover3'     => '#5EA54D',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#313540', //ok +
					'input_bd_hover'   => '#3F4452', //ok +
					'input_text'       => '#D0D1D2', //ok +
					'input_light'      => '#96999F', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#0C0F26', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'orange_light'
			'orange_light' => array(
				'title'    => esc_html__( 'Orange Light', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#D0D6DD', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#F85600', //ok +
					'text_hover'       => '#E34F00', //ok +
					'text_link2'       => '#F8B500', //ok +
					'text_hover2'      => '#E6A901', //ok +
					'text_link3'       => '#6ABC56', //ok +
					'text_hover3'      => '#5EA54D', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#EFF6F7', //ok +
					'alter_bg_hover'   => '#D9E6E8', //ok +
					'alter_bd_color'   => '#D0D6DD', //ok +
					'alter_bd_hover'   => '#C0C5CB', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#F85600', //ok +
					'alter_hover'      => '#E34F00', //ok +
					'alter_link2'      => '#F8B500', //ok +
					'alter_hover2'     => '#E6A901', //ok +
					'alter_link3'      => '#6ABC56', //ok +
					'alter_hover3'     => '#5EA54D', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12141A', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333740', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#ACACAC', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F85600', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#F8B500',
					'extra_hover2'     => '#E6A901',
					'extra_link3'      => '#6ABC56',
					'extra_hover3'     => '#5EA54D',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D0D6DD', //ok +
					'input_bd_hover'   => '#C0C5CB', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'crimson_default'
			'crimson_default' => array(
				'title'    => esc_html__( 'Crimson Default', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#EFF6F7', //ok +
					'bd_color'         => '#D0D6DD', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#F80051', //ok +
					'text_hover'       => '#C60342', //ok +
					'text_link2'       => '#072F83', //ok +
					'text_hover2'      => '#062567', //ok +
					'text_link3'       => '#4300F8', //ok +
					'text_hover3'      => '#3703C4', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //ok +
					'alter_bg_hover'   => '#E2E8F0', //ok +
					'alter_bd_color'   => '#D0D6DD', //ok +
					'alter_bd_hover'   => '#C0C5CB', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#F80051', //ok +
					'alter_hover'      => '#C60342', //ok +
					'alter_link2'      => '#072F83', //ok +
					'alter_hover2'     => '#062567', //ok +
					'alter_link3'      => '#4300F8', //ok +
					'alter_hover3'     => '#3703C4', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F1217', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333742', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#AEAEAE', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F80051', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#072F83',
					'extra_hover2'     => '#062567',
					'extra_link3'      => '#4300F8',
					'extra_hover3'     => '#3703C4',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D0D6DD', //ok +
					'input_bd_hover'   => '#C0C5CB', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'crimson_dark'
			'crimson_dark'    => array(
				'title'    => esc_html__( 'Crimson Dark', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#171A21', //ok +
					'bd_color'         => '#313540', //ok +

					// Text and links colors
					'text'             => '#D0D1D2', //ok +
					'text_light'       => '#96999F', //ok +
					'text_dark'        => '#FFFFFF', //ok +
					'text_link'        => '#F80051', //ok +
					'text_hover'       => '#C60342', //ok +
					'text_link2'       => '#072F83', //ok +
					'text_hover2'      => '#062567', //ok +
					'text_link3'       => '#4300F8', //ok +
					'text_hover3'      => '#3703C4', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1D2029', //ok +
					'alter_bg_hover'   => '#262935', //ok +
					'alter_bd_color'   => '#313540', //ok +
					'alter_bd_hover'   => '#3F4452', //ok +
					'alter_text'       => '#D0D1D2', //ok +
					'alter_light'      => '#96999F', //ok +
					'alter_dark'       => '#FFFFFF', //ok +
					'alter_link'       => '#F80051', //ok +
					'alter_hover'      => '#C60342', //ok +
					'alter_link2'      => '#072F83', //ok +
					'alter_hover2'     => '#062567', //ok +
					'alter_link3'      => '#4300F8', //ok +
					'alter_hover3'     => '#3703C4', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F1217', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333742', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#AEAEAE', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F80051', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#072F83',
					'extra_hover2'     => '#062567',
					'extra_link3'      => '#4300F8',
					'extra_hover3'     => '#3703C4',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#313540', //ok +
					'input_bd_hover'   => '#3F4452', //ok +
					'input_text'       => '#D0D1D2', //ok +
					'input_light'      => '#96999F', //ok +
					'input_dark'       => '#FFFFFF', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#FFFFFF', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#0C0F26', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'crimson_light'
			'crimson_light' => array(
				'title'    => esc_html__( 'Crimson Light', 'fitline' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //ok +
					'bd_color'         => '#D0D6DD', //ok +

					// Text and links colors
					'text'             => '#797C7F', //ok +
					'text_light'       => '#A5A6AA', //ok +
					'text_dark'        => '#0C0F26', //ok +
					'text_link'        => '#F80051', //ok +
					'text_hover'       => '#C60342', //ok +
					'text_link2'       => '#072F83', //ok +
					'text_hover2'      => '#062567', //ok +
					'text_link3'       => '#4300F8', //ok +
					'text_hover3'      => '#3703C4', //ok +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#EFF6F7', //ok +
					'alter_bg_hover'   => '#E2E8F0', //ok +
					'alter_bd_color'   => '#D0D6DD', //ok +
					'alter_bd_hover'   => '#C0C5CB', //ok +
					'alter_text'       => '#797C7F', //ok +
					'alter_light'      => '#A5A6AA', //ok +
					'alter_dark'       => '#0C0F26', //ok +
					'alter_link'       => '#F80051', //ok +
					'alter_hover'      => '#C60342', //ok +
					'alter_link2'      => '#072F83', //ok +
					'alter_hover2'     => '#062567', //ok +
					'alter_link3'      => '#4300F8', //ok +
					'alter_hover3'     => '#3703C4', //ok +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F1217', //ok +
					'extra_bg_hover'   => '#232631', 
					'extra_bd_color'   => '#333742', //ok +
					'extra_bd_hover'   => '#3F4452',
					'extra_text'       => '#AEAEAE', //ok +
					'extra_light'      => '#96999F',
					'extra_dark'       => '#FFFFFF', //ok +
					'extra_link'       => '#F80051', //ok +
					'extra_hover'      => '#FFFFFF', //ok +
					'extra_link2'      => '#072F83',
					'extra_hover2'     => '#062567',
					'extra_link3'      => '#4300F8',
					'extra_hover3'     => '#3703C4',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok +
					'input_bg_hover'   => 'transparent', //ok +
					'input_bd_color'   => '#D0D6DD', //ok +
					'input_bd_hover'   => '#C0C5CB', //ok +
					'input_text'       => '#797C7F', //ok +
					'input_light'      => '#A5A6AA', //ok +
					'input_dark'       => '#0C0F26', //ok +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#FFFFFF',
					'inverse_bd_hover' => '#FFFFFF',
					'inverse_text'     => '#0C0F26', //ok +
					'inverse_light'    => '#FFFFFF',
					'inverse_dark'     => '#0C0F26', //ok +
					'inverse_link'     => '#FFFFFF', //ok +
					'inverse_hover'    => '#FFFFFF', //ok +

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		fitline_storage_set( 'schemes', $schemes );
		fitline_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> fitline_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'fitline' ),
		//---> 	'description' => __( 'Description of the new color 1', 'fitline' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		fitline_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		fitline_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		fitline_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		fitline_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'fitline' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'fitline' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}

// Activation methods
if ( ! function_exists( 'fitline_clone_activation_methods' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'fitline_clone_activation_methods', 11, 1 );
    function fitline_clone_activation_methods( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}
