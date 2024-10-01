<?php
/**
 * Skin Options
 *
 * @package FITLINE
 * @since FITLINE 1.76.0
 */


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

if ( ! function_exists( 'fitline_create_theme_options' ) ) {

	function fitline_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'fitline' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( fitline_storage_get( 'schemes' ) ) < 2;

		fitline_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'fitline' ),
					'desc'     => '',
					'priority' => 10,
					'icon'     => 'icon-home-2',
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'fitline' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'fitline' ) ),
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'switch',
				),
				'logo_zoom'                     => array(
					'title'      => esc_html__( 'Logo zoom', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Zoom the logo (set 1 to leave original size). For this parameter to affect images, their max-height should be specified in "em" instead of "px" during header creation. In this case, maximum logo size depends on the actual size of the picture.', 'fitline' ) ),
					'std'        => 1,
					'min'        => 0.2,
					'max'        => 2,
					'step'       => 0.1,
					'refresh'    => false,
					'show_value' => true,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'slider',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'fitline' ) ),
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'switch',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'fitline' ) ),
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'fitline' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'fitline' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'fitline' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'fitline' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'fitline' ) ),
					'std'   => '',
					'type'  => 'hidden',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'fitline' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'fitline' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'icon'     => 'icon-settings',
                    'demo'     => true,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'fitline' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'fitline' ),
                    'demo'     => true,
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => fitline_get_list_body_styles( false ),
                    'demo'     => true,
					'type'     => 'choice',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'fitline' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => fitline_theme_defaults( 'page_width' ),
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page_width',               // SASS variable's name to preview changes 'on fly'
					'pro_only'   => FITLINE_THEME_FREE,
					'demo'       => true,
					'type'       => 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'fitline' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => fitline_theme_defaults( 'page_boxed_extra' ),
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'pro_only'   => FITLINE_THEME_FREE,
					'demo'       => true,
					'type'       => 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload image for the background of the boxed content.', 'fitline' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Page margins', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Add margins above and below the content area', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'options'  => fitline_get_list_remove_margins(),
					'type'     => 'choice',
				),

				'general_menu_info'             => array(
					'title' => esc_html__( 'Navigation', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				'menu_side'                     => array(
					'title'    => esc_html__( 'Sidemenu position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position of the side menu - panel with icons (ancors) for inner-page navigation. Use this menu if shortcodes "Ancor" are present on the page.', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'      => 'none',
					'options'  => array(
						'hide'  => array(
										'title' => esc_html__( 'No menu', 'fitline' ),
										'icon'  => 'images/theme-options/menu-side/hide.png',
									),
						'left'  => array(
										'title' => esc_html__( 'Left menu', 'fitline' ),
										'icon'  => 'images/theme-options/menu-side/left.png',
									),
						'right' => array(
										'title' => esc_html__( 'Right menu', 'fitline' ),
										'icon'  => 'images/theme-options/menu-side/right.png',
									),
					),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'hidden',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display them in the sidemenu, or mark sidemenu items with simple dots', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
						'menu_side_icons' => array( 1 )
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden',
				),				
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'fitline' ) ),
					'std'   => 1,
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'hidden',
				),
				'menu_mobile_socials'           =>  array(
                    'title' => esc_html__( 'Mobile menu socials', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Show socials in the Mobile Menu. Socials are available only if plugin ThemeREX Addons is active', 'fitline' ) ),
					'std'   => 1,
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'switch',
                ),
                'widgets_menu_mobile_fullscreen'                => array(
                    'title'    => esc_html__( 'Mobile menu fullscreen widgets', 'fitline' ),
                    'desc'     => wp_kses_data( __( 'Show widgets on the Fullscreen Mobile Menu', 'fitline' ) ),
                    'dependency' => array(
                        'menu_mobile_fullscreen' => array( 1 )
                    ),
                    'refresh'  => false,
                    'std'      => 1,
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type'     => 'switch',
                ),
                'widgets_additional_menu_mobile_fullscreen'            => array(
                    'title'    => esc_html__( 'Select mobile menu widgets', 'fitline' ),
                    'desc'     => wp_kses_data( __( 'Select widgets to show on the Fullscreen Mobile Menu', 'fitline' ) ),
                    'dependency' => array(
                        'menu_mobile_fullscreen' => array( 1 ),
                        'widgets_menu_mobile_fullscreen' => array( 1 )
                    ),
                    'std'      => 'hide',
                    'options'  => array(),
                    'pro_only' => FITLINE_THEME_FREE,
                    'type'     => 'select',
                ),
                'scroll_to_top_style'           =>  array(
                    'title'    => esc_html__( 'Scroll to top style', 'fitline' ),
                    'desc'     => wp_kses_data( __( 'Select scroll to top style. Scroll to top style are available only if plugin ThemeREX Addons is active', 'fitline' ) ),
                    'std'      => 'default',
                    'options' => array(
                        'default'   => esc_html__( 'Default', 'fitline' ),
                        'modern'    => esc_html__( 'Modern', 'fitline' ),
                    ),
                    'override'   => array(
                        'mode'    => 'page',
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type' => 'select',
                ),
                'scroll_to_top_scheme_watchers' => array(
                    'title' => esc_html__('Scroll to top color scheme watchers', 'fitline'),
                    'desc' => wp_kses_data( __('Monitors what color scheme the object is located', 'fitline') ),
                    'std' => 0,
                    'override'   => array(
                        'mode'    => 'page',
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
                    'dependency' => array(
                        'scroll_to_top_style' => 'modern'
                    ),
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type' => 'switch'
                ),
                'general_elements_info'          => array(
                    'title' => esc_html__( 'Sticky Elements', 'fitline' ),
                    'desc'  => '',
                    'type'  => 'info',
                ),
                'sticky_socials' => array(
                    'title' => esc_html__('Sticky socials', 'fitline'),
                    'desc' => wp_kses_data( __('Show sticky socials. Socials are available only if plugin ThemeREX Addons is active', 'fitline') ),
                    'std' => 0,
                    'override'   => array(
                        'mode'    => 'page',
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type' => 'switch'
                ),
                'sticky_socials_style'           =>  array(
                    'title'    => esc_html__( 'Sticky socials style', 'fitline' ),
                    'desc'     => wp_kses_data( __( 'Select sticky socials style', 'fitline' ) ),
                    'std'      => 'default',
                    'options' => array(
                        'default'   => esc_html__( 'Default', 'fitline' ),
                        'modern'    => esc_html__( 'Modern', 'fitline' ),
                    ),
                    'override'   => array(
                        'mode'    => 'page',
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
                    'dependency' => array(
                        'sticky_socials' => array( 1 ),
                    ),
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type' => 'select',
                ),
                'sticky_socials_scheme_watchers' => array(
                    'title' => esc_html__('Sticky socials color scheme watchers', 'fitline'),
                    'desc' => wp_kses_data( __('Monitors what color scheme the object is located', 'fitline') ),
                    'std' => 0,
                    'override'   => array(
                        'mode'    => 'page',
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
                    'dependency' => array(
                        'sticky_socials' => array( 1 ),
                    ),
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type' => 'switch'
                ),
                'general_sidebar_info'          => array(
                    'title' => esc_html__( 'Sidebar', 'fitline' ),
                    'desc'  => '',
                    'demo'  => true,
                    'type'  => 'info',
                ),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'options'  => array(),
                    'demo'      => true,
					'type'     => 'choice',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'fitline' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'fitline' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					// Commented to enable a default value for other modes where sidebar is visible
					//'dependency' => array(
					//	'sidebar_position' => array( '^hide' ),
					//),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type'              => array(
					'title'    => esc_html__( 'Sidebar style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style'                 => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type' => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type'     => array( 'default')
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width (minimum sidebar width might vary based on its location and type)', 'fitline' ) ),
					'std'        => fitline_theme_defaults( 'sidebar_width' ),
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'sidebar_width',      // SASS variable's name to preview changes 'on fly'
					'pro_only'   => FITLINE_THEME_FREE,
					'demo'       => true,
					'type'       => 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'fitline' ) ),
					'std'        => fitline_theme_defaults( 'sidebar_gap' ),
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'sidebar_gap',  // SASS variable's name to preview changes 'on fly'
					'pro_only'   => FITLINE_THEME_FREE,
					'demo'       => true,
					'type'       => 'slider',
				),
				'sidebar_proportional'          => array(
					'title'      => esc_html__( 'Sidebar proportional', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Change the width of the sidebar and gap proportionally when the window is resized, or leave the width of the sidebar constant', 'fitline' ) ),
					'refresh'    => false,
					'customizer' => 'sidebar_proportional',  // SASS variable's name to preview changes 'on fly'
					'std'        => 1,
					'type'       => 'switch',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'fitline' ) ),
					'refresh' => false,
					'override'   => array(
                        'mode'    => 'page',		// Override parameters for single posts moved to the 'expand_content_single'
                        'section' => esc_html__( 'Content', 'fitline' ),
                    ),
					'options' => fitline_get_list_expand_content(),
					'std'     => 'expand',
					'type'    => 'choice',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'fitline' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'select',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'fitline' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'select',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'fitline' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'select',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'fitline' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'select',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'fitline' ) ),
					'std'        => fitline_theme_defaults( 'rad' ),
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden', // old value "slider"
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'fitline' ) ),
					'std'   => 0,
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'switch',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'fitline'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'fitline') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'fitline'), 'fitline_kses_content' ),
					"type"  => "textarea"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'fitline' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'icon'     => 'icon-header',
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select site header position', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Stretch header area to fill the entire screen. Used only if the header has a background image', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'      => 0,
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'switch',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'        => 1,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header title zoom', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'fitline' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'show_value' => true,
					'refresh' => false,
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'fitline' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'fitline' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => fitline_get_list_range( 0, 6 ),
					'type'       => 'select',
				),


				'header_style_info_404'             => array(
					'title' => esc_html__( 'Header style 404', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_404'                   => array(
					'title'    => esc_html__( 'Header style 404', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_404'                  => array(
					'title'      => esc_html__( 'Select custom layout 404', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'header_type_404' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),


				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'fitline' ),
					'desc'     => wp_kses_data( __( "Allow overriding the header image with a featured image of the page, post, product, etc.", 'fitline' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'      => 0,
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'switch',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'fitline' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'fitline' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'fitline' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'fitline' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'fitline' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'fitline' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'fitline' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'fitline' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),


				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'fitline' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'icon'     => 'icon-footer',
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'fitline' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'fitline' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'fitline' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => fitline_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'fitline' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'fitline' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'hidden', // old - 'switch'
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'fitline' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'fitline' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'fitline' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'hidden' // old - ! fitline_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'fitline' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y}. All rights reserved.', 'fitline' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'fitline' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'icon'     => 'icon-smartphone',
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose the header to be used on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select sidebar position on mobile devices', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'choice',
				),
				'sidebar_type_mobile'           => array(
					'title'    => esc_html__( 'Sidebar style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'sidebar_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'fitline' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'default' )
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden on mobile devices', 'fitline' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options' => fitline_get_list_expand_content( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'choice',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'fitline' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fitline' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => fitline_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'fitline' ) ),
					'priority' => 70,
					'icon'     => 'icon-page',
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'fitline' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'fitline' ),
					'desc'   => wp_kses_data( __( 'Customize the blog archive: post layout, header and footer style, sidebar position, etc.', 'fitline' ) ),
					'qsetup' => esc_html__( 'General', 'fitline' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'fitline' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'options'    => array(),
					'type'       => 'choice',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'Large first post', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'fitline' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => fitline_get_list_blog_contents(),
					'type'       => 'radio',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'fitline' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => 30,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'fitline' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'fitline' ) ),
					'std'     => 2,
					'options' => fitline_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'fitline' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => fitline_get_list_blog_paginations(),
					'type'       => 'choice',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'fitline' ),
					'desc'       => wp_kses_data( __( "Select post animation for the archive page. Attention! Do not use any animation on pages with the 'wheel to the anchor' behaviour!", 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				'disable_animation_on_mobile'   => array(
					'title'      => esc_html__( 'Disable animation on mobile', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Disable any posts animation on mobile devices', 'fitline' ) ),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'video_in_popup'                => array(
					'title'      => esc_html__( 'Open video in the popup on a blog archive', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Open the video from posts in the popup (if plugin "ThemeREX Addons" is installed) or play the video instead the cover image', 'fitline' ) ),
					'std'        => 0,
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'type'       => 'switch',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'open_full_post_hide_author'    => array(
					'title'      => esc_html__( 'Hide author bio', 'fitline' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when open the full version of the post directly in the blog feed.", 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'open_full_post_hide_related'   => array(
					'title'      => esc_html__( 'Hide related posts', 'fitline' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when open the full version of the post directly in the blog feed.", 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Stretch header area to fill the entire screen. Used only if the header has a background image', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'fitline' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'fitline' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'type'    => 'choice',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'fitline' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_blog'           => array(
					'title'    => esc_html__( 'Sidebar style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_blog'            => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'fitline' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'fitline' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => fitline_get_list_expand_content( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'choice',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'fitline' ),
					'desc'  => wp_kses_data( __( "Select or upload a placeholder image for posts without a featured image. Placeholder is used exclusively on the blog stream page (and not on single post pages), and only in those styles, where omitting a featured image would be inappropriate.", 'fitline' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'fitline' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'fitline' ),
						'columns' => esc_html__( 'Mini-cards', 'fitline' ),
					),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'hidden', // old -> select
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'fitline' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'fitline' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=1|modified=0|views=0|likes=0|comments=1|author=0|share=0|edit=0',
					'options'    => fitline_get_list_meta_parts(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'checklist',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy readable date format', 'fitline' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'fitline' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'use_blog_archive_pages'        => array(
					'title'      => esc_html__( 'Use "Blog Archive" page settings on the post list', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Apply options and content of pages created with the template "Blog Archive" for some type of posts and / or taxonomy when viewing feeds of posts of this type and taxonomy.', 'fitline' ) ),
					'std'        => 0,
					'type'       => 'switch',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'fitline' ) ),
					'type'  => 'section',
				),

				'blog_single_info'       => array(
					'title' => esc_html__( 'Single posts', 'fitline' ),
					'desc'   => wp_kses_data( __( 'Customize the single post: content  layout, header and footer styles, sidebar position, meta elements, etc.', 'fitline' ) ),
					'type'  => 'info',
				),
				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'fitline' ),
					'desc'   => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Stretch header area to fill the entire screen. Used only if the header has a background image', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'fitline' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),						
				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'fitline' ) ),
					'std'     => 'hide',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'options' => array(),
					'type'    => 'choice',
				),
				'sidebar_position_ss_single'    => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_single'           => array(
					'title'    => esc_html__( 'Sidebar style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_single'            => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'         => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width on the single posts if the sidebar is hidden. Attention! "Narrow" width is only available for posts. For all other post types (Team, Services, etc.), it is equivalent to "Normal"', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => fitline_get_list_expand_content( true, true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'choice',
				),
				'blog_single_title_info'        => array(
					'title' => esc_html__( 'Featured image and title', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'single_style'                  => array(
					'title'      => esc_html__( 'Single style', 'fitline' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => 'style-1',
					'qsetup'     => esc_html__( 'General', 'fitline' ),
					'options'    => array(),
					'type'       => 'choice',
				),
				'single_parallax'               => array(
					'title'      => esc_html__( 'Parallax speed', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Speed for shifting the image while scrolling the page. If 0, the effect is not applied.', 'fitline' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'        => 0,
					'min'        => -50,
					'max'        => 50,
					'step'       => 1,
					'refresh'    => false,
					'show_value' => true,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'slider',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'fitline' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'fitline' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'fitline' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'fitline' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'fitline' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|author=1|date=1|modified=0|views=0|likes=1|share=0|comments=1|edit=0',
					'options'    => fitline_get_list_meta_parts(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'checklist',
				),
				'share_position'                 => array(
					'title'      => esc_html__( 'Share links position', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select one or more positions to show Share links on single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'fitline' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'std'        => 'top=0|left=0|bottom=1',
					'options'    => fitline_get_list_share_links_positions(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'checklist',
				),
				'share_fixed'                   => array(
					'title' => esc_html__( 'Share links fixed', 'fitline' ),
					'desc'  => wp_kses_data( __( "Fix share links when a document scrolled down", 'fitline' ) ),
					'dependency' => array(
						'share_position[left]' => array( 1 ),
					),
					'std'   => 1,
					'type'  => 'switch',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'fitline' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'fitline' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),
				'show_comments_button'          => array(
					'title' => esc_html__( 'Show comments button', 'fitline' ),
					'desc'  => wp_kses_data( __( "Display button to show/hide comments block", 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'   => 0,
					'type'  => 'switch',
				),
				'show_comments'                 => array(
					'title'   => esc_html__( 'Comments block', 'fitline' ),
					'desc'    => wp_kses_data( __( "Select initial state of the comments block", 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'options' => fitline_get_list_visiblehidden(),
					'dependency' => array(
						'show_comments_button' => array( 1 ),
					),
					'std'     => 'hidden',
					'type'    => 'radio',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'fitline' ),
					'desc'     => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'fitline' ) ),
					'override' => array(
						'mode'    => 'post,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'std'      => 1,
					'type'     => 'switch',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select the style of the related posts output', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						// old -> 'modern'  => esc_html__( 'Modern', 'fitline' ),
						'classic' => esc_html__( 'Classic', 'fitline' ),
						// old -> 'wide'    => esc_html__( 'Wide', 'fitline' ),
						'list'    => esc_html__( 'List', 'fitline' ),
						'short'   => esc_html__( 'Short', 'fitline' ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'radio',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'fitline' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'fitline' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'fitline' ),
						'below_content' => esc_html__( 'After the content', 'fitline' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'fitline' ),
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => fitline_get_list_range( 0, 9 ),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'fitline' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post?', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post,cpt_portfolio',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'show_value' => true,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'fitline' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts on the single post page?', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => fitline_get_list_range( 1, 6 ),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'radio',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden', // old - switch
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'fitline'),
						'side'    => esc_html__('Side', 'fitline'),
						'outside' => esc_html__('Outside', 'fitline'),
						'top'     => esc_html__('Top', 'fitline'),
						'bottom'  => esc_html__('Bottom', 'fitline')
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden', // old -> select
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'fitline'),
						'bottom'  => esc_html__('Bottom', 'fitline')
					),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden', // old -> radio
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space between slides', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Space between slides in the related posts slider (in pixels)', 'fitline' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'fitline' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'min'        => 0,
					'max'        => 100,
					'show_value' => true,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'hidden', // old -> slider
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Post navigation', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show post navigation', 'fitline' ),
					'desc'    => wp_kses_data( __( "Display post navigation on single post pages or load the next post automatically after the content of the current article.", 'fitline' ) ),
					'std'     => 'links',
					'options' => array(
						'none'   => esc_html__('None', 'fitline'),
						'links'  => esc_html__('Prev/Next links', 'fitline'),
						'scroll' => esc_html__('Autoload next post', 'fitline')
					),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'radio',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed post navigation', 'fitline' ),
					'desc'       => wp_kses_data( __( "Fix the position of post navigation buttons on desktop. Display them on either side of post content.", 'fitline' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
                'posts_navigation_scroll_same_cat'     => array(
                    'title'      => esc_html__( 'Next post from same category', 'fitline' ),
                    'desc'       => wp_kses_data( __( "Load next post from the same category or from any category.", 'fitline' ) ),
                    'dependency' => array(
                        'posts_navigation' => array( 'scroll' ),
                    ),
                    'std'        => 1,
                    'pro_only'   => FITLINE_THEME_FREE,
                    'type'       => 'switch',
                ),
				'posts_navigation_scroll_which_block'  => array(
					'title'   => esc_html__( 'Which block to load?', 'fitline' ),
					'desc'    => wp_kses_data( __( "Load only the content of the next article or the article and sidebar together.", 'fitline' ) )
								. '<br>'
								. wp_kses_data( __( "Attention! If you override sidebar position or content width on single posts (e.g. the sidebar is displayed on some posts and hidden on others), please don’t use the 'Full post' option to prevent improper content positioning.", 'fitline' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'     => 'article',
					'options' => array(
						'article' => array(
										'title' => esc_html__( 'Only content', 'fitline' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/article.png',
									),
						'wrapper' => array(
										'title' => esc_html__( 'Full post', 'fitline' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/wrapper.png',
									),
					),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'choice',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'fitline' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'fitline' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'fitline' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'fitline' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'fitline' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'fitline' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'switch',
				),
				'blog_single_footer_info'                        => array(
					'title'    => esc_html__( 'Footer', 'fitline' ),					
					'desc'   => '',
					'type'  => 'info',
				),
				'footer_type_single'                   => array(
					'title'    => esc_html__( 'Footer style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style_single'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						'footer_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'fitline' ),
					'desc'     => '',
					'priority' => 300,
					'icon'     => 'icon-customizer',
                    'demo'     => true,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'fitline' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block uses the main color scheme from the first parameter - Site Color Scheme', 'fitline' ) ),
					'hidden' => $hide_schemes,
                    'demo'   => true,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'fitline' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,post,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
                    'demo'     => true,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'fitline' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,post,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'fitline' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
                    'demo'     => true,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'fitline' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'fitline' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'pro_only' => FITLINE_THEME_FREE,
                    'demo'     => true,
					'type'     => 'hidden',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'fitline' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,post,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
                    'demo'     => true,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'fitline' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,post,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'fitline' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
                    'demo'     => true,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'fitline' ),
					'desc'  => wp_kses_data( __( 'Select a color scheme to modify. Attention! Only sections of the site with the selected color scheme will be affected by the changes', 'fitline' ) ),
                    'demo'  => true,
                    'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'fitline' ),
					'desc'        => '',
					'std'         => '$fitline_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'spectrum', //'tiny',
                    'demo'  => true,
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Huge priority is used to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'demo'  => true,
					'type'  => 'hidden',
				),

			)
		);


		// Add parameters for "Caregory", "Tag", "Author", "Search" to Theme Options
		fitline_storage_set_array_before( 'options', 'blog_single', fitline_options_get_list_blog_options( 'category', esc_html__( 'Category', 'fitline' ) ) );
		fitline_storage_set_array_before( 'options', 'blog_single', fitline_options_get_list_blog_options( 'tag', esc_html__( 'Tag', 'fitline' ) ) );
		fitline_storage_set_array_before( 'options', 'blog_single', fitline_options_get_list_blog_options( 'author', esc_html__( 'Author', 'fitline' ) ) );
		fitline_storage_set_array_before( 'options', 'blog_single', fitline_options_get_list_blog_options( 'search', esc_html__( 'Search', 'fitline' ) ) );



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'fitline' ),
				'desc'     => '',
				'priority' => 200,
				'icon'     => 'icon-text',
                'demo'     => true,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'fitline' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'fitline' ) )
						. wp_kses_data( __( 'Press "Refresh" button to reload preview area after the all fonts are changed', 'fitline' ) ),
                'demo'   => true,
				'type'  => 'section',
			),
			'load_fonts_info'   => array(
				'title' => esc_html__( 'Load fonts', 'fitline' ),
				'desc'  => '',
                'demo'   => true,
				'type'  => 'info',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'fitline' ),
				'desc'    => wp_kses_data( __( 'Specify a comma separated list of subsets to be loaded from Google fonts.', 'fitline' ) )
						. wp_kses_data( __( 'Permitted subsets include: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'fitline' ) ),
				'class'   => 'fitline_column-1_3 fitline_new_row',
				'refresh' => false,
                'demo'   => true,
				'std'     => '$fitline_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= fitline_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( fitline_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'fitline' ), $i ) ),
					'desc'  => '',
					'demo'  => true,
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'fitline' ),
				'desc'    => '',
				'class'   => 'fitline_column-1_4 fitline_new_row',
				'refresh' => false,
				'demo'    => true,
				'std'     => '$fitline_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'fitline' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select a font family to be used if the preferred font is not available', 'fitline' ) )
							: '',
				'class'   => 'fitline_column-1_4',
				'refresh' => false,
				'std'     => '$fitline_get_load_fonts_option',
                'demo'   => true,
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'fitline' ),
					'serif'      => esc_html__( 'serif', 'fitline' ),
					'sans-serif' => esc_html__( 'sans-serif', 'fitline' ),
					'monospace'  => esc_html__( 'monospace', 'fitline' ),
					'cursive'    => esc_html__( 'cursive', 'fitline' ),
					'fantasy'    => esc_html__( 'fantasy', 'fitline' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-link" ] = array(
				'title'   => esc_html__( 'Font URL', 'fitline' ),
				'desc'    => 1 == $i
					? wp_kses_data( __( 'Font URL used only for Adobe fonts. This is URL of the stylesheet for the project with a fonts collection from the site adobe.com', 'fitline' ) )
					: '',
				'class'   => 'fitline_column-1_4',
				'refresh' => false,
                'demo'   => true,
				'std'     => '$fitline_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'fitline' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for Google fonts. This is a comma separated list of the font weight and style options. For example: 400,400italic,700', 'fitline' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style option increases download size! Specify only those weight and style options that you plan on using.', 'fitline' ) )
							: '',
				'class'   => 'fitline_column-1_4',
				'refresh' => false,
				'demo'    => true,
				'std'     => '$fitline_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'demo' => true,
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = fitline_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_font_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'fitline' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses_data( sprintf( __( 'Font settings for the "%s" tag.', 'fitline' ), $tag ) ),
                'demo'   => true,
				'type'  => 'section',
			);
			$fonts[ "{$tag}_font_info" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'fitline' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								: '',
				'demo'  => true,
				'type'  => 'info',
			);
			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'fitline' ),
						'100'     => esc_html__( '100 (Thin)', 'fitline' ),
						'200'     => esc_html__( '200 (Extra-light)', 'fitline' ),
						'300'     => esc_html__( '300 (Light)', 'fitline' ),
						'400'     => esc_html__( '400 (Regular)', 'fitline' ),
						'500'     => esc_html__( '500 (Medium)', 'fitline' ),
						'600'     => esc_html__( '600 (Semi-bold)', 'fitline' ),
						'700'     => esc_html__( '700 (Bold)', 'fitline' ),
						'800'     => esc_html__( '800 (Extra-bold)', 'fitline' ),
						'900'     => esc_html__( '900 (Black)', 'fitline' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'fitline' ),
						'normal'  => esc_html__( 'Normal', 'fitline' ),
						'italic'  => esc_html__( 'Italic', 'fitline' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'fitline' ),
						'none'         => esc_html__( 'None', 'fitline' ),
						'underline'    => esc_html__( 'Underline', 'fitline' ),
						'overline'     => esc_html__( 'Overline', 'fitline' ),
						'line-through' => esc_html__( 'Line-through', 'fitline' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'fitline' ),
						'none'       => esc_html__( 'None', 'fitline' ),
						'uppercase'  => esc_html__( 'Uppercase', 'fitline' ),
						'lowercase'  => esc_html__( 'Lowercase', 'fitline' ),
						'capitalize' => esc_html__( 'Capitalize', 'fitline' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'refresh'    => false,
					'demo'       => true,
					'load_order' => $load_order,
					'std'        => '$fitline_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'demo' => true,
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'demo' => true,
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		fitline_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			fitline_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'fitline' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'fitline' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! fitline_check_url( 'customize.php' ) ) {
			fitline_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'fitline' ) ),
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'fitline' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for categories, tags, archives, author posts, search, etc.
if ( ! function_exists( 'fitline_options_get_list_blog_options' ) ) {
	function fitline_options_get_list_blog_options( $mode, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $mode );
		}
		return apply_filters( 'fitline_filter_get_list_blog_options', array(
				"blog_general_{$mode}"           => array(
					'title' => $title,
					// Translators: Add mode name to the description
					'desc'  => wp_kses_data( sprintf( __( "Style and components of the %s posts page", 'fitline' ), $title ) ),
					'type'  => 'section',
				),
				"blog_general_info_{$mode}"      => array(
					// Translators: Add mode name to the title
					'title'  => wp_kses_data( sprintf( __( "%s posts page", 'fitline' ), $title ) ),
					// Translators: Add mode name to the description
					'desc'   => wp_kses_data( sprintf( __( 'Customize %s page: post layout, header and footer styles, sidebar position and widgets, etc.', 'fitline' ), $title ) ),
					'type'   => 'info',
				),
				"blog_style_{$mode}"             => array(
					'title'      => esc_html__( 'Blog style', 'fitline' ),
					'desc'       => '',
					'std'        => 'excerpt',
					'options'    => array(),
					'type'       => 'choice',
				),
				"first_post_large_{$mode}"       => array(
					'title'      => esc_html__( 'Large first post', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'fitline' ) ),
					'std'        => 0,
					'options'    => fitline_get_list_yesno( true ),
					'dependency' => array(
						'blog_style_{$mode}' => array( 'classic', 'masonry' ),
					),
					'type'       => 'radio',
				),
				"blog_content_{$mode}"           => array(
					'title'      => esc_html__( 'Posts content', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'fitline' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						"blog_style_{$mode}" => array( 'excerpt' ),
					),
					'options'    => fitline_get_list_blog_contents( true ),
					'type'       => 'radio',
				),
				"excerpt_length_{$mode}"         => array(
					'title'      => esc_html__( 'Excerpt length', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'fitline' ) ),
					'dependency' => array(
						"blog_style_{$mode}"   => array( 'excerpt' ),
						"blog_content_{$mode}" => array( 'excerpt' ),
					),
					'std'        => 55,
					'type'       => 'text',
				),
				"meta_parts_{$mode}"             => array(
					'title'      => esc_html__( 'Post meta', 'fitline' ),
					'desc'       => wp_kses_data( __( "Set up post meta parts to show in the blog archive. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'fitline' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'fitline' ) ),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=1|modified=0|views=1|likes=1|comments=1|author=0|share=0|edit=0',
					'options'    => fitline_get_list_meta_parts(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'checklist',
				),
				"blog_pagination_{$mode}"        => array(
					'title'      => esc_html__( 'Pagination style', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'fitline' ) ),
					'std'        => 'pages',
					'options'    => fitline_get_list_blog_paginations( true ),
					'type'       => 'choice',
				),
				"blog_animation_{$mode}"         => array(
					'title'      => esc_html__( 'Post animation', 'fitline' ),
					'desc'       => wp_kses_data( __( "Select post animation for the archive page. Attention! Do not use any animation on pages with the 'wheel to the anchor' behaviour!", 'fitline' ) ),
					'std'        => 'none',
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				"open_full_post_in_blog_{$mode}" => array(
					'title'      => esc_html__( 'Open full post in blog', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the posts feed. Attention! Applies only to 1 column layouts!', 'fitline' ) ),
					'std'        => 0,
					'options'    => fitline_get_list_checkbox_values( true ),
					'type'       => 'radio',
				),

				"blog_header_info_{$mode}"       => array(
					'title' => esc_html__( 'Header', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				"header_type_{$mode}"            => array(
					'title'    => esc_html__( 'Header style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_header_footer_types( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				"header_style_{$mode}"           => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						"header_type_{$mode}" => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				"header_position_{$mode}"        => array(
					'title'    => esc_html__( 'Header position', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				"header_fullheight_{$mode}"      => array(
					'title'    => esc_html__( 'Header fullheight', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Stretch header area to fill the entire screen. Used only if the header has a background image', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),
				"header_wide_{$mode}"            => array(
					'title'      => esc_html__( 'Header fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'fitline' ) ),
					'dependency' => array(
						"header_type_{$mode}" => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => fitline_get_list_checkbox_values( true ),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => 'radio',
				),

				"blog_sidebar_info_{$mode}"      => array(
					'title' => esc_html__( 'Sidebar', 'fitline' ),
					'desc'  => '',
					'type'  => 'info',
				),
				"sidebar_position_{$mode}"       => array(
					'title'   => esc_html__( 'Sidebar position', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'fitline' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'type'    => 'choice',
				),
				"sidebar_type_{$mode}"           => array(
					'title'    => esc_html__( 'Sidebar style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => fitline_get_list_header_footer_types(),
					'pro_only' => FITLINE_THEME_FREE,
					'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
				),
				"sidebar_style_{$mode}"          => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
						"sidebar_type_{$mode}"     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				"sidebar_widgets_{$mode}"        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'fitline' ) ),
					'dependency' => array(
						"sidebar_position_{$mode}" => array( '^hide' ),
						"sidebar_type_{$mode}"     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				"expand_content_{$mode}"         => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'fitline' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => fitline_get_list_expand_content( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'choice',
				),

				"blog_widgets_info_{$mode}"      => array(
					'title' => esc_html__( 'Additional widgets', 'fitline' ),
					'desc'  => '',
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				"widgets_above_page_{$mode}"     => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_above_content_{$mode}"  => array(
					'title'   => esc_html__( 'Widgets above the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_below_content_{$mode}"  => array(
					'title'   => esc_html__( 'Widgets below the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_below_page_{$mode}"     => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
			), $mode, $title
		);
	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'fitline_options_get_list_cpt_options' ) ) {
	function fitline_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return apply_filters( 'fitline_filter_get_list_cpt_options',
								array_merge(
                                    fitline_options_get_list_cpt_options_body( $cpt, $title ),
                                    ('portfolio' == $cpt ? fitline_options_get_list_cpt_options_color( $cpt, $title ) : array()),
                                    ('portfolio' == $cpt ? fitline_options_get_list_cpt_navigation( $cpt, $title ) : array()),
                                    ('events' == $cpt ? fitline_options_get_list_cpt_options_color( $cpt, $title ) : array()),
									fitline_options_get_list_cpt_options_header( $cpt, $title, 'list' ),
									fitline_options_get_list_cpt_options_header( $cpt, $title, 'single' ),
									fitline_options_get_list_cpt_options_sidebar( $cpt, $title, 'list' ),
									fitline_options_get_list_cpt_options_sidebar( $cpt, $title, 'single' ),
									fitline_options_get_list_cpt_options_footer( $cpt, $title ),
									fitline_options_get_list_cpt_options_widgets( $cpt, $title )
								),
								$cpt,
								$title
							);
	}
}


// Returns a text description suffix for CPT
if ( ! function_exists( 'fitline_options_get_cpt_description_suffix' ) ) {
	function fitline_options_get_cpt_description_suffix( $title, $mode ) {
		return $mode == 'both'
					// Translators: Add CPT name to the description
					? sprintf( __( 'the %s list and single posts', 'fitline' ), $title )
					: ( $mode == 'list'
						// Translators: Add CPT name to the description
						? sprintf( __( 'the %s list', 'fitline' ), $title )
						// Translators: Add CPT name to the description
						: sprintf( __( 'Single %s posts', 'fitline' ), $title )
						);
	}
}


// Returns a list of options that can be overridden for CPT. Section 'Content' - Color
if ( ! function_exists( 'fitline_options_get_list_cpt_navigation' ) ) {
    function fitline_options_get_list_cpt_navigation( $cpt, $title = '' ) {
        if ( empty( $title ) ) {
            $title = ucfirst( $cpt );
        }
        return apply_filters( 'fitline_filter_get_list_cpt_navigation', array(
            "content_info_{$cpt}"           => array(
                'title' => esc_html__( 'Body style', 'fitline' ),
                // Translators: Add CPT name to the description
                'desc'  => wp_kses_data( sprintf( __( 'Select body style to display %s list and single posts', 'fitline' ), $title ) ),
                'type'  => 'info',
            ),
            "cpt_navigation_{$cpt}"           => array(
                'title'   => esc_html__( 'Show post navigation', 'fitline' ),
                'desc'    => wp_kses_data( __( "Display post navigation on single post pages.", 'fitline' ) ),
                'override'   => array(
                    'mode'    => 'cpt_portfolio',
                    'section' => esc_html__( 'Content', 'fitline' ),
                ),
                'std'     => 0,
                'pro_only'=> FITLINE_THEME_FREE,
                'type'    => 'switch',
            ),
        ), $cpt, $title
        );
    }
}


// Returns a list of options that can be overridden for CPT. Section 'Content' - Color
if ( ! function_exists( 'fitline_options_get_list_cpt_options_color' ) ) {
    function fitline_options_get_list_cpt_options_color( $cpt, $title = '' ) {
        if ( empty( $title ) ) {
            $title = ucfirst( $cpt );
        }
        return apply_filters( 'fitline_filter_get_list_cpt_options_color', array(
            "content_info_{$cpt}"           => array(
                'title' => esc_html__( 'Body style', 'fitline' ),
                // Translators: Add CPT name to the description
                'desc'  => wp_kses_data( sprintf( __( 'Select body style to display %s list and single posts', 'fitline' ), $title ) ),
                'type'  => 'info',
            ),
            "color_scheme_{$cpt}"                => array(
                'title'    => wp_kses_data( sprintf( __( 'Color Scheme', 'fitline' ), $title)),
                'desc'     => '',
                'std'      => 'inherit',
                'options'  => array(),
                'refresh'  => false,
                'type'     => 'radio',
            ),
            "sidebar_scheme_{$cpt}"                => array(
                'title'    => wp_kses_data( sprintf( __( 'Sidebar Color Scheme', 'fitline' ), $title)),
                'desc'     => '',
                'std'      => 'inherit',
                'options'  => array(),
                'refresh'  => false,
                'type'     => 'radio',
            ),
            "color_scheme_single_{$cpt}"                => array(
                'title'    => wp_kses_data( sprintf( __( 'Single %s Color Scheme', 'fitline' ), $title)),
                'desc'     => '',
                'std'      => 'inherit',
                'options'  => array(),
                'refresh'  => false,
                'type'     => 'radio',
            ),
        ), $cpt, $title
        );
    }
}


// Returns a list of options that can be overridden for CPT. Section 'Content'
if ( ! function_exists( 'fitline_options_get_list_cpt_options_body' ) ) {
	function fitline_options_get_list_cpt_options_body( $cpt, $title = '', $mode = 'both' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		$suffix = $mode == 'single' ? '_single' : '';
		$suffix2 = fitline_options_get_cpt_description_suffix( $title, $mode );
		return apply_filters( "fitline_filter_get_list_cpt_options_body{$suffix}", array(
				"content_info{$suffix}_{$cpt}"           => array(
					// Translators: Add CPT name to the description
					'title' => wp_kses_data( sprintf( __( 'Body style on %s', 'fitline' ), $suffix2 ) ),
					// Translators: Add CPT name to the description
					'desc'  => wp_kses_data( sprintf( __( 'Select body style to display %s', 'fitline' ), $suffix2 ) ),
					'type'  => 'info',
				),
				"body_style{$suffix}_{$cpt}"             => array(
					'title'    => esc_html__( 'Body style', 'fitline' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'fitline' ) ),
					'std'      => 'inherit',
					'options'  => fitline_get_list_body_styles( true ),
					'type'     => 'choice',
				),
				"boxed_bg_image{$suffix}_{$cpt}"         => array(
					'title'      => esc_html__( 'Boxed bg image', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'fitline' ) ),
					'dependency' => array(
						"body_style{$suffix}_{$cpt}" => array( 'boxed' ),
					),
					'std'        => 'inherit',
					'type'       => 'image',
				),
			), $cpt, $title
		);
	}
}


// Returns a list of options that can be overridden for CPT. Section 'Header'
if ( ! function_exists( 'fitline_options_get_list_cpt_options_header' ) ) {
	function fitline_options_get_list_cpt_options_header( $cpt, $title = '', $mode = 'both' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		$suffix = $mode == 'single' ? '_single' : '';
		$suffix2 = fitline_options_get_cpt_description_suffix( $title, $mode );
		return apply_filters( "fitline_filter_get_list_cpt_options_header{$suffix}", array(
				"header_info{$suffix}_{$cpt}"            => array(
					// Translators: Add CPT name to the description
					'title' => wp_kses_data( sprintf( __( 'Header on %s', 'fitline' ), $suffix2 ) ),
					// Translators: Add CPT name to the description
					'desc'  => wp_kses_data( sprintf( __( 'Set up header parameters to display %s', 'fitline' ), $suffix2 ) ),
					'type'  => 'info',
				),
				"header_type{$suffix}_{$cpt}"            => array(
					'title'   => esc_html__( 'Header style', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'     => 'inherit',
					'options' => fitline_get_list_header_footer_types( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'radio',
				),
				"header_style{$suffix}_{$cpt}"           => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					// Translators: Add CPT name to the description
					'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'fitline' ), $title ) ),
					'dependency' => array(
						"header_type{$suffix}_{$cpt}" => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				"header_position{$suffix}_{$cpt}"        => array(
					'title'   => esc_html__( 'Header position', 'fitline' ),
					// Translators: Add CPT name to the description
					'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'fitline' ), $title ) ),
					'std'     => 'inherit',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'radio',
				),
				"header_image_override{$suffix}_{$cpt}"  => array(
					'title'   => esc_html__( 'Header image override', 'fitline' ),
					// Translators: Add CPT name to the description
					'desc'    => wp_kses_data( sprintf( __( "Allow overriding the header image with a featured image of %s.", 'fitline' ), $title ) ),
					'std'     => 'inherit',
					'options' => fitline_get_list_yesno( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'radio',
				),
				"header_widgets{$suffix}_{$cpt}"         => array(
					'title'   => esc_html__( 'Header widgets', 'fitline' ),
					// Translators: Add CPT name to the description
					'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'fitline' ), $title ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => 'select',
				),
			), $cpt, $title
		);
	}
}


// Returns a list of options that can be overridden for CPT. Section 'Sidebar'
if ( ! function_exists( 'fitline_options_get_list_cpt_options_sidebar' ) ) {
	function fitline_options_get_list_cpt_options_sidebar( $cpt, $title = '', $mode = 'both' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		$suffix = $mode == 'single' ? '_single' : '';
		$suffix2 = fitline_options_get_cpt_description_suffix( $title, $mode );
		return apply_filters( "fitline_filter_get_list_cpt_options_sidebar{$suffix}", array_merge(
				array(
					"sidebar_info{$suffix}_{$cpt}"           => array(
						// Translators: Add CPT name to the description
						'title' => wp_kses_data( sprintf( __( 'Sidebar on %s', 'fitline' ), $suffix2 ) ),
						// Translators: Add CPT name to the description
						'desc'  => wp_kses_data( sprintf( __( 'Set up sidebar parameters to display %s', 'fitline' ), $suffix2 ) ),
						'type'  => 'info',
					),
					"sidebar_position{$suffix}_{$cpt}"       => array(
						'title'   => esc_html__( 'Sidebar position', 'fitline' ),
						'desc'    => wp_kses_data( __( 'Select sidebar position', 'fitline' ) ),
						'std'     => 'right',
						'options' => array(),
						'type'    => 'choice',
					),
					"sidebar_position_ss{$suffix}_{$cpt}"    => array(
						'title'    => esc_html__( 'Sidebar position on the small screen', 'fitline' ),
						'desc'     => wp_kses_data( __( 'Select a position for the sidebar on the small screen: above the content, below or on a sliding side-panel.', 'fitline' ) ),
						'std'      => 'below',
						'dependency' => array(
							"sidebar_position{$suffix}_{$cpt}" => array( '^hide' ),
						),
						'options'  => array(),
						'type'     => 'radio',
					),
					"sidebar_type{$suffix}_{$cpt}"           => array(
						'title'    => esc_html__( 'Sidebar style', 'fitline' ),
						'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
						'dependency' => array(
							"sidebar_position{$suffix}_{$cpt}" => array( '^hide' ),
						),
						'std'      => 'default',
						'options'  => fitline_get_list_header_footer_types( true ),
						'pro_only' => FITLINE_THEME_FREE,
						'type'     => ! fitline_exists_trx_addons() ? 'hidden' : 'radio',
					),
					"sidebar_style{$suffix}_{$cpt}"          => array(
						'title'      => esc_html__( 'Select custom layout', 'fitline' ),
						'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'fitline' ), 'fitline_kses_content' ),
						'dependency' => array(
							"sidebar_position{$suffix}_{$cpt}" => array( '^hide' ),
							"sidebar_type{$suffix}_{$cpt}"     => array( 'custom' ),
						),
						'std'        => '',
						'options'    => array(),
						'type'       => 'select',
					),
					"sidebar_widgets{$suffix}_{$cpt}"        => array(
						'title'      => esc_html__( 'Sidebar widgets', 'fitline' ),
						'desc'       => wp_kses_data( __( 'Select set of widgets to display in the sidebar', 'fitline' ) ),
						'dependency' => array(
							"sidebar_position{$suffix}_{$cpt}" => array( '^hide' ),
							"sidebar_type{$suffix}_{$cpt}"     => array( 'default' ),
						),
						'std'        => 'hide',
						'options'    => array(),
						'type'       => 'select',
					),
				),
				$mode == 'single' ? array() : array(
					"sidebar_width{$suffix}_{$cpt}"          => array(
						'title'      => esc_html__( 'Sidebar width', 'fitline' ),
						'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width (minimum sidebar width might vary based on its location and type)', 'fitline' ) ),
						'std'        => 'inherit',
						'min'        => 0,
						'max'        => 500,
						'step'       => 10,
						'show_value' => true,
						'units'      => 'px',
						'refresh'    => false,
						'pro_only'   => FITLINE_THEME_FREE,
						'type'       => 'slider',
					),
					"sidebar_gap{$suffix}_{$cpt}"            => array(
						'title'      => esc_html__( 'Sidebar gap', 'fitline' ),
						'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'fitline' ) ),
						'std'        => 'inherit',
						'min'        => 0,
						'max'        => 100,
						'step'       => 1,
						'show_value' => true,
						'units'      => 'px',
						'refresh'    => false,
						'pro_only'   => FITLINE_THEME_FREE,
						'type'       => 'slider',
					),
					"sidebar_proportional{$suffix}_{$cpt}"          => array(
						'title'      => esc_html__( 'Sidebar proportional', 'fitline' ),
						'desc'       => wp_kses_data( __( 'Change the width of the sidebar and gap proportionally when the window is resized, or leave the width of the sidebar constant', 'fitline' ) ),
						'refresh'    => false,
						'std'        => 1,
						'type'       => 'switch',
					),
				),
				array(
					"expand_content{$suffix}_{$cpt}"         => array(
					'title'   => esc_html__( 'Content width', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Content width if the sidebar is hidden', 'fitline' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => fitline_get_list_expand_content( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'choice',
					),
				)
			), $cpt, $title
		);
	}
}


// Returns a list of options that can be overridden for CPT. Section 'Footer'
if ( ! function_exists( 'fitline_options_get_list_cpt_options_footer' ) ) {
	function fitline_options_get_list_cpt_options_footer( $cpt, $title = '', $mode = 'both' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		$suffix = $mode == 'single' ? '_single' : '';
		$suffix2 = fitline_options_get_cpt_description_suffix( $title, $mode );
		return apply_filters( "fitline_filter_get_list_cpt_options_footer{$suffix}", array(
				"footer_info{$suffix}_{$cpt}"            => array(
					// Translators: Add CPT name to the description
					'title' => wp_kses_data( sprintf( __( 'Footer on %s', 'fitline' ), $suffix2 ) ),
					// Translators: Add CPT name to the description
					'desc'  => wp_kses_data( sprintf( __( 'Set up footer parameters to display %s', 'fitline' ), $suffix2 ) ),
					'type'  => 'info',
				),
				"footer_type{$suffix}_{$cpt}"            => array(
					'title'   => esc_html__( 'Footer style', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'fitline' ) ),
					'std'     => 'inherit',
					'options' => fitline_get_list_header_footer_types( true ),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'radio',
				),
				"footer_style{$suffix}_{$cpt}"           => array(
					'title'      => esc_html__( 'Select custom layout', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'fitline' ) ),
					'std'        => 'inherit',
					'dependency' => array(
						"footer_type{$suffix}_{$cpt}" => array( 'custom' ),
					),
					'options'    => array(),
					'pro_only'   => FITLINE_THEME_FREE,
					'type'       => 'select',
				),
				"footer_widgets{$suffix}_{$cpt}"         => array(
					'title'      => esc_html__( 'Footer widgets', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'fitline' ) ),
					'dependency' => array(
						"footer_type{$suffix}_{$cpt}" => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				"footer_columns{$suffix}_{$cpt}"         => array(
					'title'      => esc_html__( 'Footer columns', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'fitline' ) ),
					'dependency' => array(
						"footer_type{$suffix}_{$cpt}"    => array( 'default' ),
						"footer_widgets{$suffix}_{$cpt}" => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => fitline_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				"footer_wide{$suffix}_{$cpt}"            => array(
					'title'      => esc_html__( 'Footer fullwidth', 'fitline' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'fitline' ) ),
					'dependency' => array(
						"footer_type{$suffix}_{$cpt}" => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
			), $cpt, $title
		);
	}
}


// Returns a list of options that can be overridden for CPT. Section 'Additional Widget Areas'
if ( ! function_exists( 'fitline_options_get_list_cpt_options_widgets' ) ) {
	function fitline_options_get_list_cpt_options_widgets( $cpt, $title = '', $mode = 'both' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		$suffix = $mode == 'single' ? '_single' : '';
		$suffix2 = fitline_options_get_cpt_description_suffix( $title, $mode );
		return apply_filters( "fitline_filter_get_list_cpt_options_widgets{$suffix}", array(
				"widgets_info{$suffix}_{$cpt}"           => array(
					// Translators: Add CPT name to the description
					'title' => wp_kses_data( sprintf( __( 'Additional panels on %s', 'fitline' ), $suffix2 ) ),
					// Translators: Add CPT name to the description
					'desc'  => wp_kses_data( sprintf( __( 'Set up additional panels to display %s', 'fitline' ), $suffix2 ) ),
					'pro_only'  => FITLINE_THEME_FREE,
					'type'  => 'info',
				),
				"widgets_above_page{$suffix}_{$cpt}"     => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_above_content{$suffix}_{$cpt}"  => array(
					'title'   => esc_html__( 'Widgets above the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_below_content{$suffix}_{$cpt}"  => array(
					'title'   => esc_html__( 'Widgets below the content', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
				"widgets_below_page{$suffix}_{$cpt}"     => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'fitline' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'fitline' ) ),
					'std'     => 'hide',
					'options' => array(),
					'pro_only'=> FITLINE_THEME_FREE,
					'type'    => 'select',
				),
			), $cpt, $title
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'fitline_options_get_list_choises' ) ) {
	add_filter( 'fitline_filter_options_get_list_choises', 'fitline_options_get_list_choises', 10, 2 );
	function fitline_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = fitline_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = fitline_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = fitline_get_list_schemes( 'color_scheme' != $id );
			} else if ( strpos( $id, 'sidebar_style' ) === 0 ) {
				$list = fitline_get_list_sidebar_styles( strpos( $id, 'sidebar_style_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = fitline_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = fitline_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = fitline_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
            } elseif ( strpos( $id, 'widgets_additional_menu_mobile_fullscreen' ) === 0 ) {
                $list = fitline_get_list_sidebars( strpos( $id, 'widgets_additional_menu_mobile_fullscreen_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = fitline_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = fitline_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = fitline_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'single_style' ) === 0 ) {
				$list = fitline_get_list_single_styles( strpos( $id, 'single_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = fitline_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = fitline_array_merge( array( 0 => esc_html__( '- Select category -', 'fitline' ) ), fitline_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = fitline_get_list_animations_in( strpos( $id, 'blog_animation_' ) === 0 );
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = fitline_get_list_schemes();
			} elseif ( 'color_preset' == $id ) {
				$list = fitline_get_list_color_presets();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = fitline_get_list_load_fonts( true );
			} elseif ( 'font_preset' == $id ) {
				$list = fitline_get_list_font_presets();
			}
		}
		return $list;
	}
}




//--------------------------------------------
// THUMBS
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup_thumbs' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_thumbs', 1 );
	function fitline_skin_setup_thumbs() {
		fitline_storage_set(
			'theme_thumbs', apply_filters(
				'fitline_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'fitline-thumb-huge'        => array(
						'size'  => array( 1290, 725, true ), //ok
						'title' => esc_html__( 'Huge image', 'fitline' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'fitline-thumb-big'         => array(
						'size'  => array( 840, 473, true ), //ok
						'title' => esc_html__( 'Large image', 'fitline' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'fitline-thumb-med'         => array(
						'size'  => array( 410, 230, true ),
						'title' => esc_html__( 'Medium image', 'fitline' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'fitline-thumb-tiny'        => array(
						'size'  => array( 120, 120, true ),
						'title' => esc_html__( 'Small square avatar', 'fitline' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'fitline-thumb-masonry-big' => array(
						'size'  => array( 840, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'fitline' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'fitline-thumb-masonry'     => array(
						'size'  => array( 410, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'fitline' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

					'fitline-thumb-rectangle' => array(
						'size'  => array( 570, 696, true ), // old - 480x586
						'title' => esc_html__( 'Rectangle', 'fitline' ),
						'subst' => 'trx_addons-thumb-rectangle',
					),

                    'fitline-thumb-medium-square' => array(
                        'size'  => array( 650, 572, true ),
                        'title' => esc_html__( 'Square medium', 'fitline' ),
                        'subst' => 'trx_addons-thumb-medium-square',
                    ),

					'fitline-thumb-square' => array(
						'size'  => array( 890, 664, true ),
						'title' => esc_html__( 'Square', 'fitline' ),
						'subst' => 'trx_addons-thumb-square',
					),

				)
			)
		);
	}
}


//--------------------------------------------
// BLOG STYLES
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup_blog_styles' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_blog_styles', 1 );
	function fitline_skin_setup_blog_styles() {

		$blog_styles = array(
			'excerpt' => array(
				'title'   => esc_html__( 'Standard', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-excerpt',
				'styles'  => 'excerpt',
				'icon'    => "images/theme-options/blog-style/excerpt.png",
			),
			'band'    => array(
				'title'   => esc_html__( 'Band', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-band',
				'styles'  => 'band',
				'icon'    => "images/theme-options/blog-style/band.png",
			),
			'classic' => array(
				'title'   => esc_html__( 'Classic', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'classic',
				'icon'    => "images/theme-options/blog-style/classic-%d.png",
				'new_row' => true,
			),
		);
		if ( ! FITLINE_THEME_FREE ) {
			$blog_styles['classic-masonry']   = array(
				'title'   => esc_html__( 'Classic Masonry', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-classic',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'classic', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/classic-masonry-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio'] = array(
				'title'   => esc_html__( 'Portfolio', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'portfolio',
				'icon'    => "images/theme-options/blog-style/portfolio-%d.png",
				'new_row' => true,
			);
			$blog_styles['portfolio-masonry'] = array(
				'title'   => esc_html__( 'Portfolio Masonry', 'fitline' ),
				'archive' => 'index',
				'item'    => 'templates/content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'portfolio', 'masonry' ),
				'scripts' => 'masonry',
				'icon'    => "images/theme-options/blog-style/portfolio-masonry-%d.png",
				'new_row' => true,
			);
		}
		fitline_storage_set( 'blog_styles', apply_filters( 'fitline_filter_add_blog_styles', $blog_styles ) );
	}
}


//--------------------------------------------
// SINGLE STYLES
//--------------------------------------------
if ( ! function_exists( 'fitline_skin_setup_single_styles' ) ) {
	add_action( 'after_setup_theme', 'fitline_skin_setup_single_styles', 1 );
	function fitline_skin_setup_single_styles() {

		fitline_storage_set( 'single_styles', apply_filters( 'fitline_filter_add_single_styles', array(
			'style-1'   => array(
				'title'       => esc_html__( 'Style 1', 'fitline' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are over the image', 'fitline' ),
				'styles'      => 'style-1',
				'icon'        => "images/theme-options/single-style/style-1.png",
			),
			'style-2'   => array(
				'title'       => esc_html__( 'Style 2', 'fitline' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are inside the content area', 'fitline' ),
				'styles'      => 'style-2',
				'icon'        => "images/theme-options/single-style/style-2.png",
			),
			'style-3'   => array(
				'title'       => esc_html__( 'Style 3', 'fitline' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are below the image', 'fitline' ),
				'styles'      => 'style-3',
				'icon'        => "images/theme-options/single-style/style-3.png",
			),
			'style-4'   => array(
				'title'       => esc_html__( 'Style 4', 'fitline' ),
				'description' => esc_html__( 'Boxed image is above the content area, the title and meta are above the image', 'fitline' ),
				'styles'      => 'style-4',
				'icon'        => "images/theme-options/single-style/style-4.png",
			),
			'style-5'   => array(
				'title'       => esc_html__( 'Style 5', 'fitline' ),
				'description' => esc_html__( 'Boxed image is inside the content area, the title and meta are above the content area', 'fitline' ),
				'styles'      => 'style-5',
				'icon'        => "images/theme-options/single-style/style-5.png",
			),
			'style-6'   => array(
				'title'       => esc_html__( 'Style 6', 'fitline' ),
				'description' => esc_html__( 'Boxed image, the title and meta are inside the content area, the title and meta are above the image', 'fitline' ),
				'styles'      => 'style-6',
				'icon'        => "images/theme-options/single-style/style-6.png",
			),
			'style-7'   => array(
				'title'       => esc_html__( 'Style 7', 'fitline' ),
				'description' => esc_html__( 'Fullwidth image is above the content area, the title and meta are below the image', 'fitline' ),
				'styles'      => 'style-7',
				'icon'        => "images/theme-options/single-style/style-7.png",
			),
		) ) );
	}
}