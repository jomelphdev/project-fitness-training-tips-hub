<?php
/**
 * Defines default settings.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** Function to set admin default settings.
 *
 * @return array Settings.
 */
function crlpuic_get_plugin_setting_defaults() {

	return apply_filters(
		'crlpuic_options_defaults',
		array(

			'remove_settings_on_uninstall' => false,
			'crlpuic_reset'                => false,

		)
	);
}

/** Function to set customizer default settings.
 *
 * @return array Settings.
 */
function crlpuic_get_customizer_defaults() {

	$website_logo = esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) );

	$default_wp_logo = ( ! empty( $website_logo ) ) ? $website_logo : get_site_url() . '/wp-admin/images/wordpress-logo.svg';

	$crlpuic_settings = get_option( CRLPUIC_SLUG );
	if ( ! empty( $crlpuic_settings['custom_logo'] ) ) {
		$default_wp_logo = $crlpuic_settings['custom_logo'];
	}

	$logo_text = get_bloginfo( 'title', 'display' );

	$bg_image = CRLPUIC_PLUGIN_DIR . '/assets/images/bg.png';

	$column_content_default_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-2.png';

	$column_content = "<h2 class='content-title'>Manage your account</h2><p class='content-desc'>Login to your account to manage your recent orders, post and much more</p><img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-2.png' alt='Introduction' class='content-img'>";

	return apply_filters(
		'crlpuic_customizer_settings_defaults',
		array(

			// Template.

			'login_template'            => 'boxed_right',

			// Background section.

			'background'                => 'bg_image',
			'bg_image'                  => $bg_image,
			'bg_overlay'                => '#4F97D1',
			'bg_color'                  => '#4F97D1',
			'bg_opacity'                => 0,
			'opacity_min'               => 0,
			'opacity_max'               => 1,
			'content_column'            => $column_content,
			'content_title'             => __( 'Manage your account', 'login-page-ui-customizer' ),
			'content_title_color'       => '#000000',
			'content_desc'              => __( 'Login to your account to manage your recent orders, post and much more', 'login-page-ui-customizer' ),
			'content_desc_color'        => '#000000',
			'content_img'               => $column_content_default_img,
			'content_column_bg_color'   => '#F0E2E1',
			'content_column_bg_opacity' => 0.9,
			'form_column_bg_color'      => '#FFFFFF',
			'column_bg_opacity'         => 1,
			'form_column_bg_img'        => '',
			'form_column_bg_overlay'    => '',
			'column_width'              => 50,

			// Logo section.

			'logo_settings'             => 'show_logo',
			'logo_title'                => $logo_text,
			'logo_title_color'          => '#000000',
			'login_page_title'          => '',
			'logo_title_font_size'      => 26,
			'custom_logo'               => $default_wp_logo,
			'custom_logo_height'        => 84,

			// Login Form Style.

			'form_width'                => 75,
			'form_min_width'            => 30,
			'form_max_width'            => 90,
			'form_background_color'     => '#ffffff',
			'transparent_background'    => false,
			'form_wrapper'              => false,
			'field_icons'               => true,
			'form_label_color'          => '#000000',
			'form_label_font_size'      => 14,
			'login_btn_bg_color'        => '#2271B1',
			'login_btn_bg_hover'        => '',
			'login_btn_shodow'          => '',
			'login_btn_txt_shodow'      => '',
			'login_btn_txt_color'       => '#ffffff',
			'login_btn_font_size'       => 14,
			'rememberme_hide'           => false,
			'hide_links'                => true,

			// Login Form text edit.

			'username_label'            => '',
			'password_label'            => '',
			'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
			'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
			'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

			'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

			// Register Form text edit.
			'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
			'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
			'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
			'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
			'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
			'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

			// Lost Password Form text edit.

			'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
			'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

			// Custom CSS.

			'custom_css'                => 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}.form-placeholder #login form p.forgetmenot,.crlpuic-right-form #login form p.forgetmenot{width:100%}.form-placeholder #login form p.submit,.crlpuic-right-form #login form p.submit{float:left;margin-top:20px;width: 100%;}.input{border:none!important}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{font-size:16px;padding:4px 62px;float:left;border-radius: 10px;}::placeholder{color:#929191;opacity:revert}.login form{box-shadow:none!important}#registerform #user_login, #registerform #user_register, #registerform #user_email, #loginform #user_login, #loginform #user_pass{background-color:#EBEBEB;}.login h1 a{margin-bottom: 0px}@media only screen and (max-width: 577px) {.boxed.crlpuic-right-form .crlpuic-content{border-radius: 30px 30px 0px 0px;}.boxed.crlpuic-right-form .crlpuic-form-wrapper{border-radius: 0px 0px 30px 30px;}}',
		)
	);
}

/** Function for settings of Modern Template.
 *
 * @return array Settings.
 */
function crlpuic_get_templates() {

	$website_logo = esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) );

	$default_wp_logo = ( ! empty( $website_logo ) ) ? $website_logo : get_site_url() . '/wp-admin/images/wordpress-logo.svg';

	$crlpuic_settings = get_option( CRLPUIC_SLUG );
	if ( ! empty( $crlpuic_settings['custom_logo'] ) ) {
		$default_wp_logo = $crlpuic_settings['custom_logo'];
	}

	$logo_text = get_bloginfo( 'title', 'display' );

	$bg_image = CRLPUIC_PLUGIN_DIR . '/assets/images/center-form-bg-1.jpg';

	$bg_image1      = CRLPUIC_PLUGIN_DIR . '/assets/images/center-form-bg-2.jpg';
	$bg_image2      = CRLPUIC_PLUGIN_DIR . '/assets/images/center-form-bg-4.jpg';
	$bg_image3      = CRLPUIC_PLUGIN_DIR . '/assets/images/center-form-bg-4.jpg';
	$bg_image_boxed = CRLPUIC_PLUGIN_DIR . '/assets/images/bg.png';
	$fresh_food     = CRLPUIC_PLUGIN_DIR . '/assets/images/freshfood-bg.jpg';

	// $column_content = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-4.png' alt='Introduction' class='content-img'><h2 class='content-title'>Manage your website </h2><p class='content-desc'>Login to your account to manage your website.</p>";

	$column_content_tpl2 = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-1.png'" . ' alt=' . "'Brand Icon'" . '/>';

	$column_content_tpl2_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-1.png';

	$column_content_tpl3 = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-3.png'" . ' alt=' . "'Brand Icon'" . '/>';

	$column_content_tpl3_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-3.png';

	$column_content_tpl_13_left = "<h2 style='text-align:left;font-size:40px;'><span style='color:#704ABB'>Edu</span><span style='color:#FF545A'>cate</span></h2><h3 style='text-align:left;font-size:30px;color:#000'>Training programs that propel your career</h3><img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-4.png'" . ' alt=' . "'Brand Icon'" . '/>';

	$column_content_tpl_13_left_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-4.png';

	$column_content_tpl_13_right = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-3.png'" . ' alt=' . "'Brand Icon'" . '/>';

	$column_content_tpl_13_right_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-3.png';

	$column_content1 = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-2.png' alt='Brand Icon' style='width:70%;'><h2 class='content-title' >Manage your account</h2><p style='color:ff80b4;font-size:20px;'>Login to your account to manage your recent orders, post and much more.</p>";

	$column_content1_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-2.png';

	$column_content2 = "<h2 class='content-title'>Manage your account</h2><p style='color:ff80b4;font-size:20px;'>Login to your account to manage your recent orders, post and much more</p><img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/side-illustrations-2.png' alt='Brand Icon' style='width:70%;'>";

	$column_content2_img = CRLPUIC_PLUGIN_DIR . '/assets/images/side-illustrations-2.png';

	$fresh_food_content = "<img src='" . CRLPUIC_PLUGIN_DIR . "/assets/images/freshfood-logo.png' alt='Brand Icon'><h2 style='color:#fff;font-size:50px;'>Welcome to Freshfood </h2><p style='color:#ff80b4;font-size:24px;'>We deliver food instantly</p>";

	$fresh_food_content_img = CRLPUIC_PLUGIN_DIR . '/assets/images/freshfood-logo.png';

	$templates['default'] = array(

		// Template.

		'login_template'            => 'center_form',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $bg_image,
		'bg_overlay'                => '#e0e0e0',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 0,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => '',
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => '',
		'content_column_bg_color'   => '#ffffff',
		'content_column_bg_opacity' => 0.5,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 0.5,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 40,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => false,

		// Login Form text edit.

		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body .crlpuic-content-wrapper { padding: 5% 25% 5% 25%; } .login form { border-radius: 8px; border: 0 none; }',

	);

	$templates['center_form'] = array(

		// Template.

		'login_template'            => 'center_form',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $bg_image,
		'bg_overlay'                => '#e0e0e0',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 0,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => '',
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => '',
		'content_column_bg_color'   => '#ffffff',
		'content_column_bg_opacity' => 0.5,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 0.5,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 45,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => false,

		// Login Form text edit.

		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body .crlpuic-content-wrapper { padding: 5% 25% 5% 25%; } .login form { border-radius: 10px; border: 0 none; }',

	);

	$templates['center_form_1'] = array(

		// Template.

		'login_template'            => 'center_form_1',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $bg_image3,
		'bg_overlay'                => '#e0e0e0',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 0,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => '',
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => '',
		'content_column_bg_color'   => '#ffffff',
		'content_column_bg_opacity' => 0.5,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 0.5,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_title',
		'logo_title'                => __( 'Website Title', 'login-page-ui-customizer' ),
		'logo_title_color'          => '#FFFFFF',
		'login_page_title'          => $logo_text,
		'logo_title_font_size'      => 40,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 45,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#ffffff',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#86EB6D',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#000000',
		'login_btn_font_size'       => 18,
		'rememberme_hide'           => false,
		'hide_links'                => false,

		// Login Form text edit.

		'username_label'            => '',
		'password_label'            => '',
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body .crlpuic-content-wrapper { padding: 5% 25% 5% 25%; } .login form { border-radius: 10px; border: 0 none; }.crlpuic-content-wrapper h2{font-size:35px;margin-bottom:0}.crlpuic-content-wrapper p{font-size:22px;margin-bottom:10px;color:rgba(255,255,255,.5)}.crlpuic-content{justify-content:unset}.login form{padding:0;border-radius:0;}.login h1 a{font-weight:700}.form-placeholder #login form p.forgetmenot,.center-form-1 #login form p.forgetmenot{width:100%}.form-placeholder #login form p.submit,.center-form-1 #login form p.submit{font-weight: 600;float:left;margin-top:20px;width:100%}.input{border:none!important}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{font-size:16px;padding:4px 72px;width: 100%;border-radius: 10px;}#loginform #user_login, #loginform #user_pass,#registerform #user_login, #registerform #user_email, #registerform #user_register, ::-webkit-input-placeholder,::placeholder{color:#929191;background-color:#35373B;opacity:revert}.login form{box-shadow:none!important}#loginform, #registerform, #lostpasswordform{background-color:transparent}',

	);

	$templates['right_form'] = array(

		// Template.

		'login_template'            => 'right_form',

		// Background section.

		'background'                => 'bg_color',
		'bg_image'                  => $bg_image2,
		'bg_overlay'                => '#ffffff',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 1,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content_tpl2,
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content_tpl2_img,
		'content_column_bg_color'   => '#ffffff',
		'content_column_bg_opacity' => 1,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 1,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.
		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.
		'form_width'                => 65,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => false,

		// Login Form text edit.
		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.
		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => '.login form{box-shadow:rgba(0,0,0,.2) 0 4px 40px;border-radius:10px;}body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}',

	);

	$templates['left_form'] = array(

		// Template.

		'login_template'            => 'left_form',

		// Background section.

		'background'                => 'bg_color',
		'bg_image'                  => $bg_image2,
		'bg_overlay'                => '#ffffff',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 1,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content_tpl2,
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content_tpl2_img,
		'content_column_bg_color'   => '#ffffff',
		'content_column_bg_opacity' => 1,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 1,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 65,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => false,

		// Login Form text edit.

		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => '.login form{box-shadow:rgba(0,0,0,.2) 0 4px 40px!important;border-radius:10px!important}body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}',

	);

	$templates['form_1_3_right'] = array(

		// Template.

		'login_template'            => 'form_1_3_right',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => '',
		'bg_overlay'                => '#E2EBF2',
		'bg_color'                  => '#E2EBF2',
		'bg_opacity'                => 0,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content_tpl_13_right,
		'content_title'             => '',
		'content_title_color'       => '#000000',
		'content_desc'              => '',
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content_tpl_13_right_img,
		'content_column_bg_color'   => '#E2EBF2',
		'content_column_bg_opacity' => 0.5,
		'form_column_bg_color'      => '#E2EBF2',
		'column_bg_opacity'         => 0.5,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 33,

		// Logo section.

		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 60,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#E2EBF2',
		'transparent_background'    => true,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#1E2A5B',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 16,
		'rememberme_hide'           => false,
		'hide_links'                => true,

		// Login Form text edit.

		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => '.login form { border-radius: 0px; border: 0 none; }body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}.crlpuic-login-form-bg #login{box-shadow: -10px -10px 30px rgba(255, 255, 255, 0.5), 10px 10px 30px rgba(174, 174, 192, 0.4);border-radius:10px;padding: 20px 0px 0px 0px;}.login form, #loginform{box-shadow:none;width:100%;} body .crlpuic-content-wrapper{padding:0;}.crlpuic-form-wrapper-inner, .crlpuic-content-wrapper-inner{margin: 0;}.login h1 a{margin-bottom: 0px}.crlpuic-right-form #login form p.submit{display:inline-block;float:left;margin-top:20px;width:100%}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{width: 100%;padding: 5px;}.login form .input,.login input[type=password],.login input[type=submit],.login input[type=text]{border:.5px solid #dbe3e6;border-radius:10px}',

	);

	$templates['form_1_3_left'] = array(

		// Template.

		'login_template'            => 'form_1_3_left',

		// Background section.

		'background'                => 'bg_color',
		'bg_image'                  => $bg_image3,
		'bg_overlay'                => '#ffffff',
		'bg_color'                  => '#ffffff',
		'bg_opacity'                => 1,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content_tpl_13_left,
		'content_title'             => __( 'Educate', 'login-page-ui-customizer' ),
		'content_title_color'       => '#704abb',
		'content_desc'              => __( 'Training programs that propel your career', 'login-page-ui-customizer' ),
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content_tpl_13_left_img,
		'content_column_bg_color'   => '#DDF2FE',
		'content_column_bg_opacity' => 0.5,
		'form_column_bg_color'      => '#FFFFFF',
		'column_bg_opacity'         => 1,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 33,

		// Logo section.

		'logo_settings'             => 'show_title',
		'logo_title'                => __( 'Login to Educate', 'login-page-ui-customizer' ),
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 80,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => true,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#704ABB',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#FFFFFF',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => true,

		// Login Form text edit.

		'username_label'            => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'password_label'            => __( 'Password', 'login-page-ui-customizer' ),
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body .crlpuic-content-wrapper{padding:5% 20% 5% 20%}.login h1 a{font-weight:700;}.login form{border:0 none;box-shadow:none!important}body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0} .crlpuic-form-1-3-left .crlpuic-content-wrapper p { font-size: 24px; } #login form p.submit{display:inline-block;float:left;margin-top:20px;width:100%}#loginform .button-primary, #registerform .button-primary, #lostpasswordform .button-primary{width:100%;padding:5px}.login form .input,.login input[type=password],.login input[type=submit],.login input[type=text]{border:.5px solid #e6e5e4;border-radius:22px}',

	);

	$templates['boxed_left'] = array(

		// Template.

		'login_template'            => 'boxed_left',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $bg_image_boxed,
		'bg_overlay'                => '#172327',
		'bg_color'                  => '#172327',
		'bg_opacity'                => 0.2,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content1,
		'content_title'             => __( 'Manage your account', 'login-page-ui-customizer' ),
		'content_title_color'       => '#000000',
		'content_desc'              => __( 'Login to your account to manage your recent orders, post and much more', 'login-page-ui-customizer' ),
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content1_img,
		'content_column_bg_color'   => '#F0E2E1',
		'content_column_bg_opacity' => 0.9,
		'form_column_bg_color'      => '#FFFFFF',
		'column_bg_opacity'         => 1,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.
		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login form field style setting.
		'form_width'                => 75,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#ffffff',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => true,

		// Login Form text edit.

		'username_label'            => '',
		'password_label'            => '',
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}.form-placeholder #login form p.forgetmenot,.crlpuic-right-form #login form p.forgetmenot{width:100%}.form-placeholder #login form p.submit,.crlpuic-left-form #login form p.submit{float:left;margin-top:20px;width: 100%;}.input{border:none!important}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{font-size:16px;padding:4px 62px;float:left;border-radius: 10px;}#registerform #user_login, #registerform #user_email, #registerform #user_register::placeholder{color:#929191;opacity:revert}.login form{box-shadow:none!important}#loginform #user_login, #loginform #user_pass,#registerform #user_login, #registerform #user_email, #registerform #user_register{background-color:#EBEBEB;}.login h1 a{margin-bottom: 0px}@media only screen and (max-width: 577px) {.boxed.crlpuic-left-form .crlpuic-content{border-radius: 30px 30px 0px 0px;} .boxed.crlpuic-left-form .crlpuic-form-wrapper{border-radius: 0px 0px 30px 30px;}}',

	);

	$templates['boxed_right'] = array(

		// Template.

		'login_template'            => 'boxed_right',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $bg_image_boxed,
		'bg_overlay'                => '#4F97D1',
		'bg_color'                  => '#4F97D1',
		'bg_opacity'                => 0.2,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $column_content2,
		'content_title'             => __( 'Manage your account', 'login-page-ui-customizer' ),
		'content_title_color'       => '#000000',
		'content_desc'              => __( 'Login to your account to manage your recent orders, post and much more', 'login-page-ui-customizer' ),
		'content_desc_color'        => '#000000',
		'content_img'               => $column_content2_img,
		'content_column_bg_color'   => '#F0E2E1',
		'content_column_bg_opacity' => 0.9,
		'form_column_bg_color'      => '#FFFFFF',
		'column_bg_opacity'         => 1,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_logo',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 26,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 75,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => false,
		'form_wrapper'              => false,
		'field_icons'               => true,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 14,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#ffffff',
		'login_btn_font_size'       => 14,
		'rememberme_hide'           => false,
		'hide_links'                => true,

		// Login Form text edit.

		'username_label'            => '',
		'password_label'            => '',
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin:0}.form-placeholder #login form p.forgetmenot,.crlpuic-right-form #login form p.forgetmenot{width:100%}.form-placeholder #login form p.submit,.crlpuic-right-form #login form p.submit{float:left;margin-top:20px;width: 100%;}.input{border:none!important}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{font-size:16px;padding:4px 62px;float:left;border-radius: 10px;}::placeholder{color:#929191;opacity:revert}.login form{box-shadow:none!important}#registerform #user_login, #registerform #user_register, #registerform #user_email, #loginform #user_login, #loginform #user_pass{background-color:#EBEBEB;}.login h1 a{margin-bottom: 0px}@media only screen and (max-width: 577px) {.boxed.crlpuic-right-form .crlpuic-content{border-radius: 30px 30px 0px 0px;}.boxed.crlpuic-right-form .crlpuic-form-wrapper{border-radius: 0px 0px 30px 30px;}}',

	);

	$templates['fresh_food'] = array(

		// Template.

		'login_template'            => 'fresh_food',

		// Background section.

		'background'                => 'bg_image',
		'bg_image'                  => $fresh_food,
		'bg_overlay'                => '#f0f0f1',
		'bg_color'                  => '#ededcb',
		'bg_opacity'                => 0,
		'opacity_min'               => 0,
		'opacity_max'               => 1,
		'content_column'            => $fresh_food_content,
		'content_title'             => __( 'Welcome to Freshfood', 'login-page-ui-customizer' ),
		'content_title_color'       => '#ffffff',
		'content_desc'              => __( 'We deliver food instantly', 'login-page-ui-customizer' ),
		'content_desc_color'        => '#ff80b4',
		'content_img'               => $fresh_food_content_img,
		'content_column_bg_color'   => '#ff006a',
		'content_column_bg_opacity' => 0.9,
		'form_column_bg_color'      => '#ffffff',
		'column_bg_opacity'         => 0,
		'form_column_bg_img'        => '',
		'form_column_bg_overlay'    => '',
		'column_width'              => 50,

		// Logo section.

		'logo_settings'             => 'show_title',
		'logo_title'                => $logo_text,
		'logo_title_color'          => '#000000',
		'login_page_title'          => '',
		'logo_title_font_size'      => 24,
		'custom_logo'               => $default_wp_logo,
		'custom_logo_height'        => 84,

		// Login Form Style.

		'form_width'                => 71,
		'form_min_width'            => 30,
		'form_max_width'            => 90,
		'form_background_color'     => '#ffffff',
		'transparent_background'    => true,
		'form_wrapper'              => false,
		'field_icons'               => false,
		'form_label_color'          => '#000000',
		'form_label_font_size'      => 12,
		'login_btn_bg_color'        => '#2271B1',
		'login_btn_bg_hover'        => '',
		'login_btn_shodow'          => '',
		'login_btn_txt_shodow'      => '',
		'login_btn_txt_color'       => '#ffffff',
		'login_btn_font_size'       => 16,
		'rememberme_hide'           => false,
		'hide_links'                => true,

		// Login Form text edit.

		'username_label'            => '',
		'password_label'            => '',
		'rememberme_label'          => __( 'Remember Me', 'login-page-ui-customizer' ),
		'lost_password_text'        => __( 'Lost your password?', 'login-page-ui-customizer' ),
		'back_to_website'           => __( '&larr; Back to Website', 'login-page-ui-customizer' ),

		'login_btn_text'            => __( 'Log In', 'login-page-ui-customizer' ),

		// Register Form text edit.
		'register_username_label'   => __( 'Username', 'login-page-ui-customizer' ),
		'register_email_label'      => __( 'Email Address', 'login-page-ui-customizer' ),
		'registration_message'      => __( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ),
		'register_btn_label'        => __( 'Register', 'login-page-ui-customizer' ),
		'register_link_label'       => __( 'Register', 'login-page-ui-customizer' ),
		'login_link_label'          => __( 'Log In', 'login-page-ui-customizer' ),

		// Lost Password Form text edit.

		'lost_pwd_username_label'   => __( 'Username or Email Address', 'login-page-ui-customizer' ),
		'lost_pwd_button_label'     => __( 'Get New Password', 'login-page-ui-customizer' ),

		// Custom CSS.

		'custom_css'                => 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content{margin-top:10%;margin-bottom:10%}.boxed .crlpuic-wrapper{height:auto;max-width:100%;margin:10% auto}.crlpuic-content-wrapper h2{font-size:35px;margin-bottom:0}.crlpuic-content-wrapper p{font-size:22px;margin-bottom:10px;color:rgba(255,255,255,.5)}.crlpuic-content{justify-content:unset}.login form{padding:0}.login h1 a{font-weight:700;text-align:left;width:71%}.form-placeholder #login form p.forgetmenot,.crlpuic-right-form #login form p.forgetmenot{width:100%}.form-placeholder #login form p.submit,.crlpuic-right-form #login form p.submit{float:left;margin-top:20px}.input{border:none!important}#registerform .button-primary,#loginform .button-primary,#lostpasswordform .button-primary{font-size:16px;padding:4px 72px}::placeholder{color:#929191;opacity:revert}.login form{box-shadow:none!important}.crlpuic-form-wrapper {background:transparent;}@media only screen and (max-width: 577px){ .crlpuic-wrapper #login{background: rgba(255,255,255,0.5)!important;padding: 10px;} .crlpuic-content-wrapper h2{font-size: 30px !important;}}',

	);

	return $templates;
}
