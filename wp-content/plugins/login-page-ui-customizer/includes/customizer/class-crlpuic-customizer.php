<?php
/**
 * Customizer class for the plugin.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

/**
 * CRLPUIC_Customizer class handles plugin settings provided in customizer.
 */
class CRLPUIC_Customizer {

	/**
	 * Var $panel Defines the panel ID.
	 *
	 * @var string $panel Panel.
	 */
	public $panel;

	/**
	 * Var $defaults Defines plugin customizer settings.
	 *
	 * @var array $defaults Settings.
	 */
	public $defaults;

	/**
	 * Var $plugin_options Plugin settings.
	 *
	 * @var array $plugin_options Settings.
	 */
	public $plugin_options;

	/**
	 * The $wp_customize object.
	 *
	 * @since 1.0.0
	 *
	 * @var WP_Customize_Manager
	 */
	public $wp_customize;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->panel = CRLPUIC_SLUG;

		$this->plugin_options = CRLPUIC_SLUG;

		add_action( 'customize_register', array( $this, 'custom_controls' ) );
		add_action( 'customize_register', array( $this, 'add_panel' ) );
		add_action( 'customize_register', array( $this, 'add_section' ) );
		add_action( 'customize_register', array( $this, 'add_setting' ) );
		add_action( 'customize_register', array( $this, 'add_control' ) );

		// Load customizer assets.
		add_action( 'customize_controls_print_scripts', array( $this, 'load_customizer_control_scripts' ) );
		add_action( 'customize_preview_init', array( $this, 'load_customize_preview_init' ) );

		add_action( 'init', array( $this, 'load_customizer_css' ) );
		add_filter( 'template_include', array( $this, 'apply_login_page_template' ), 99 );

	}

	/**
	 * Include Custom Controls.
	 *
	 * Includes all custom control classes.
	 *
	 * @param WP_Customize_Manager $wp_customize WP Customizer Manager object.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function custom_controls( $wp_customize ) {

		// Custom controls.
		require_once CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/controls/class-crlpuic-radio-images-control.php';
		require_once CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/controls/class-crlpuic-range-control.php';

		require_once CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/controls/class-crlpuic-section-separator-control.php';
		require_once CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/controls/class-crlpuic-toggle-control.php';

		$wp_customize->register_control_type( 'CRLPUIC_Radio_Images_Control' );
		$wp_customize->register_control_type( 'CRLPUIC_Range_Control' );
		$wp_customize->register_control_type( 'CRLPUIC_Section_Separator_Control' );
		$wp_customize->register_control_type( 'CRLPUIC_Toggle_Control' );

	}

	/**
	 * Load scripts for Customizer preview.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_customizer_control_scripts() {

		wp_enqueue_style( 'crlpuic-login-customizer-styles', CRLPUIC_PLUGIN_DIR . '/assets/css/customizer-styles.min.css', array(), CRLPUIC_VER, 'all' );

		wp_enqueue_script(
			'crlpuic-login-customizer-script',
			CRLPUIC_PLUGIN_DIR . '/assets/js/customizer-controls.min.js',
			array(
				'jquery',
				// 'customize-preview',
				'customize-controls',
			),
			CRLPUIC_VER,
			true
		);

		wp_localize_script(
			'crlpuic-login-customizer-script',
			'crlpuic_Urls',
			array(
				'siteurl'      => get_option( 'siteurl' ),
				'register_url' => wp_registration_url(),
			)
		);

		wp_enqueue_script( 'crlpuic-custom-login-preview', CRLPUIC_PLUGIN_DIR . '/assets/js/customizer-preview.min.js', array( 'jquery', 'customize-preview' ), CRLPUIC_VER, true );

	}

	/**
	 * Load customizer preview scripts.
	 */
	public function load_customize_preview_init() {

		wp_enqueue_script( 'crlpuic-custom-login-preview', CRLPUIC_PLUGIN_DIR . '/assets/js/customizer-preview.min.js', array( 'jquery', 'customize-preview' ), CRLPUIC_VER, true );
	}

	/**
	 * Init customizer preview class object.
	 */
	public function load_customizer_css() {
		new CRLPUIC_Customizer_Preview();
	}

	/**
	 * Add panel.
	 *
	 * @param WP_Customize_Manager $wp_customize WP Customizer Manager object.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_panel( $wp_customize ) {

		$wp_customize->add_panel(
			$this->panel,
			array(
				'title'       => __( 'Login Page UI', 'login-page-ui-customizer' ),
				'description' => esc_html__( 'Control the appearance of login page for your website.', 'login-page-ui-customizer' ),
				'capability'  => 'edit_theme_options',
			)
		);

	}

	/**
	 * Add section.
	 *
	 * @param WP_Customize_Manager $wp_customize WP Customizer Manager object.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_section( $wp_customize ) {

		// Template Display Section.
		$wp_customize->add_section(
			'crlpuic_template_section',
			array(
				'title'              => __( 'Templates', 'login-page-ui-customizer' ),
				'priority'           => 30,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you choose best suitable template', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Background Display Section.
		$wp_customize->add_section(
			'lpuic_design_section',
			array(
				'title'              => __( 'Design', 'login-page-ui-customizer' ),
				'priority'           => 31,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you choose best suitable style', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Logo Display Section.
		$wp_customize->add_section(
			'crlpuic_logo_section',
			array(
				'title'              => __( 'Logo Settings', 'login-page-ui-customizer' ),
				'priority'           => 32,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you style login form', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Login Form Display Section.
		$wp_customize->add_section(
			'crlpuic_login_form_section',
			array(
				'title'              => __( 'Form Style', 'login-page-ui-customizer' ),
				'priority'           => 33,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you style login form', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Login Form Text Edit Section.
		$wp_customize->add_section(
			'crlpuic_login_form_text_edit_section',
			array(
				'title'              => __( 'Login Form Text', 'login-page-ui-customizer' ),
				'priority'           => 34,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you edit login form text', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Register Form Text Edit Section.
		if ( get_option( 'users_can_register' ) ) {
			$wp_customize->add_section(
				'crlpuic_register_form_section',
				array(
					'title'              => __( 'Register Form Text', 'login-page-ui-customizer' ),
					'priority'           => 35,
					'panel'              => $this->panel,
					'description'        => esc_html__( 'The settings below help you edit register form text', 'login-page-ui-customizer' ),
					'description_hidden' => true,
				)
			);
		}

		// Lost Password Form Text Edit Section.
		$wp_customize->add_section(
			'crlpuic_lost_pwd_form_text_edit_section',
			array(
				'title'              => __( 'Lost Password Form', 'login-page-ui-customizer' ),
				'priority'           => 36,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you edit lost password form text', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Custom CSS.
		$wp_customize->add_section(
			'crlpuic_custom_css_section',
			array(
				'title'              => __( 'Custom CSS', 'login-page-ui-customizer' ),
				'priority'           => 37,
				'panel'              => $this->panel,
				'description'        => esc_html__( 'The settings below help you for custom style', 'login-page-ui-customizer' ),
				'description_hidden' => true,
			)
		);

		// Background Section Separators.
		$section_separator_bg_setting = array( 'bg_column', 'content_column' );

		foreach ( $section_separator_bg_setting as $bg_settings ) {

			$wp_customize->add_setting(
				$this->panel . '[section_separator_' . $bg_settings . ']',
				array(
					'default' => '',
				)
			);
		}

	}

	/**
	 * Add setting.
	 *
	 * @param WP_Customize_Manager $wp_customize WP Customizer Manager object.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_setting( $wp_customize ) {

		$this->defaults = crlpuic_get_customizer_defaults();

		$wp_customize->add_setting(
			$this->plugin_options . '[login_template]',
			array(
				'default'           => $this->defaults['login_template'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		// Login page background.
		$wp_customize->add_setting(
			$this->plugin_options . '[background]',
			array(
				'default'           => $this->defaults['background'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[bg_image]',
			array(
				'default'           => $this->defaults['bg_image'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'url' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[bg_overlay]',
			array(
				'default'           => $this->defaults['bg_overlay'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[form_column_bg_overlay]',
			array(
				'default'           => $this->defaults['form_column_bg_overlay'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[bg_color]',
			array(
				'default'           => $this->defaults['bg_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);
		$wp_customize->add_setting(
			$this->plugin_options . '[form_column_bg_color]',
			array(
				'default'           => $this->defaults['form_column_bg_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);
		$wp_customize->add_setting(
			$this->plugin_options . '[form_column_bg_img]',
			array(
				'default'           => $this->defaults['form_column_bg_img'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'url' ),
			)
		);
		$wp_customize->add_setting(
			$this->plugin_options . '[bg_opacity]',
			array(
				'default'           => $this->defaults['bg_opacity'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'opacity' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[column_bg_opacity]',
			array(
				'default'           => $this->defaults['column_bg_opacity'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'opacity' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_title]',
			array(
				'default'           => $this->defaults['content_title'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_title_color]',
			array(
				'default'           => $this->defaults['content_title_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_desc]',
			array(
				'default'           => $this->defaults['content_desc'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_desc_color]',
			array(
				'default'           => $this->defaults['content_desc_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_img]',
			array(
				'default'           => $this->defaults['content_img'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'url' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_column_bg_color]',
			array(
				'default'           => $this->defaults['content_column_bg_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[content_column_bg_opacity]',
			array(
				'default'           => $this->defaults['content_column_bg_opacity'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'opacity' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[column_width]',
			array(
				'default'           => $this->defaults['column_width'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_btn_bg_color]',
			array(
				'default'           => $this->defaults['login_btn_bg_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_btn_bg_hover]',
			array(
				'default'           => $this->defaults['login_btn_bg_hover'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_btn_txt_color]',
			array(
				'default'           => $this->defaults['login_btn_txt_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_btn_font_size]',
			array(
				'default'           => $this->defaults['login_btn_font_size'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[form_label_color]',
			array(
				'default'           => $this->defaults['form_label_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[form_label_font_size]',
			array(
				'default'           => $this->defaults['form_label_font_size'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		// Logo Settings.

		$wp_customize->add_setting(
			$this->plugin_options . '[logo_settings]',
			array(
				'default'           => $this->defaults['logo_settings'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[logo_title]',
			array(
				'default'           => $this->defaults['logo_title'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[logo_title_color]',
			array(
				'default'           => $this->defaults['logo_title_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[logo_title_font_size]',
			array(
				'default'           => $this->defaults['logo_title_font_size'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_page_title]',
			array(
				'default'           => $this->defaults['login_page_title'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[custom_logo]',
			array(
				'default'           => $this->defaults['custom_logo'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'url' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[custom_logo_height]',
			array(
				'default'           => $this->defaults['custom_logo_height'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		// Login Form Settings.

		$wp_customize->add_setting(
			$this->plugin_options . '[form_background_color]',
			array(
				'default'           => $this->defaults['form_background_color'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'color' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[transparent_background]',
			array(
				'default'           => $this->defaults['transparent_background'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'bool' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[form_width]',
			array(
				'default'           => $this->defaults['form_width'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'absint' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[form_wrapper]',
			array(
				'default'           => $this->defaults['form_wrapper'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'bool' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[field_icons]',
			array(
				'default'           => $this->defaults['field_icons'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'bool' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[rememberme_hide]',
			array(
				'default'           => $this->defaults['rememberme_hide'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'bool' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[hide_links]',
			array(
				'default'           => $this->defaults['hide_links'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'bool' ),
			)
		);

		// Form text edit settings.
		$wp_customize->add_setting(
			$this->plugin_options . '[username_label]',
			array(
				'default'           => $this->defaults['username_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[password_label]',
			array(
				'default'           => $this->defaults['password_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[rememberme_label]',
			array(
				'default'           => $this->defaults['rememberme_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[lost_password_text]',
			array(
				'default'           => $this->defaults['lost_password_text'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[back_to_website]',
			array(
				'default'           => $this->defaults['back_to_website'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_btn_text]',
			array(
				'default'           => $this->defaults['login_btn_text'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		// Register Form Settings.
		$wp_customize->add_setting(
			$this->plugin_options . '[register_username_label]',
			array(
				'default'           => $this->defaults['register_username_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[register_email_label]',
			array(
				'default'           => $this->defaults['register_email_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[registration_message]',
			array(
				'default'           => $this->defaults['registration_message'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[register_btn_label]',
			array(
				'default'           => $this->defaults['register_btn_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[register_link_label]',
			array(
				'default'           => $this->defaults['register_link_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[login_link_label]',
			array(
				'default'           => $this->defaults['login_link_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		// Lost Password Form.
		$wp_customize->add_setting(
			$this->plugin_options . '[lost_pwd_username_label]',
			array(
				'default'           => $this->defaults['lost_pwd_username_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		$wp_customize->add_setting(
			$this->plugin_options . '[lost_pwd_button_label]',
			array(
				'default'           => $this->defaults['lost_pwd_button_label'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

		// CSS setting.
		$wp_customize->add_setting(
			$this->plugin_options . '[custom_css]',
			array(
				'default'           => $this->defaults['custom_css'],
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => array( 'CRLPUIC_Sanitization_Callbacks', 'sanitize_text' ),
			)
		);

	}

	/**
	 * Add section.
	 *
	 * @param WP_Customize_Manager $wp_customize WP Customizer Manager object.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_control( $wp_customize ) {

		// Template Controls.
		$wp_customize->add_control(
			new CRLPUIC_Radio_Images_Control(
				$wp_customize,
				$this->plugin_options . '[login_template]',
				array(
					'label'       => __( 'Select Template', 'login-page-ui-customizer' ),
					'description' => __( 'Layout options for the login page', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_template_section',
					'settings'    => $this->plugin_options . '[login_template]',
					'choices'     => crlpuic_available_page_layouts(),
				)
			)
		);

		// Logo Settings.
		$wp_customize->add_control(
			$this->plugin_options . '[logo_settings]',
			array(
				'label'       => __( 'Logo Options', 'login-page-ui-customizer' ),
				'description' => __( 'select required logo settings', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_logo_section',
				'type'        => 'select',
				'choices'     => crlpuic_logo_options(),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[logo_title]',
			array(
				'label'           => __( 'Title Text', 'login-page-ui-customizer' ),
				'description'     => __( 'It will show at logo', 'login-page-ui-customizer' ),
				'section'         => 'crlpuic_logo_section',
				'type'            => 'text',
				'active_callback' => array( $this, 'is_logo_title_enabled' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[logo_title_color]',
				array(
					'label'           => __( 'Title text Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page title color.', 'login-page-ui-customizer' ),
					'section'         => 'crlpuic_logo_section',
					'active_callback' => array( $this, 'is_logo_title_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[logo_title_font_size]',
				array(
					'label'           => __( 'Title Font size', 'login-page-ui-customizer' ),
					'description'     => __( '(in px)', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'crlpuic_logo_section',
					'input_attrs'     => array(
						'min'     => 8,
						'max'     => 100,
						'step'    => 1,
						'unit'    => 'px',
						'class'   => 'fx-range crlpuic-input-site-width',
						'style'   => 'color: #38aee0',
						'default' => $this->defaults['logo_title_font_size'],
					),
					'active_callback' => array( $this, 'is_logo_title_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$this->plugin_options . '[custom_logo]',
				array(
					'label'           => __( 'Custom Logo', 'login-page-ui-customizer' ),
					'description'     => __( 'Login page logo', 'login-page-ui-customizer' ),
					'section'         => 'crlpuic_logo_section',
					'active_callback' => array( $this, 'custom_logo_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[custom_logo_height]',
				array(
					'label'           => __( 'Max-height for Logo Image', 'login-page-ui-customizer' ),
					'description'     => __( '(in px)', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'crlpuic_logo_section',
					'input_attrs'     => array(
						'min'     => 20,
						'max'     => 200,
						'step'    => 1,
						'unit'    => 'px',
						'class'   => 'fx-range crlpuic-input-opacity',
						'style'   => 'color: #38aee0',
						'default' => 84,
					),
					'active_callback' => array( $this, 'custom_logo_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[login_page_title]',
			array(
				'label'       => __( 'Login Page Title', 'login-page-ui-customizer' ),
				'description' => __( "It is shown in the browser's title bar", 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_logo_section',
				'type'        => 'text',
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[background]',
			array(
				'label'       => __( 'Background', 'login-page-ui-customizer' ),
				'description' => __( 'Choose background option', 'login-page-ui-customizer' ),
				'section'     => 'lpuic_design_section',
				'type'        => 'select',
				'choices'     => crlpuic_background_choices(),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$this->plugin_options . '[bg_image]',
				array(
					'label'           => __( 'Background Image', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page background.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'check_background' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[bg_overlay]',
				array(
					'label'           => __( 'Overlay Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page overlay.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'check_background' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[bg_color]',
				array(
					'label'           => __( 'Background Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page background.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'check_background_color' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[bg_opacity]',
				array(
					'label'           => __( 'Background Opacity', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page background opacity.', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'lpuic_design_section',
					'input_attrs'     => array(
						'min'     => $this->defaults['opacity_min'],
						'max'     => $this->defaults['opacity_max'],
						'step'    => 0.1,
						'unit'    => '',
						'class'   => 'fx-range crlpuic-input-opacity',
						'style'   => 'color: #38aee0',
						'default' => 0.5,
					),
					'active_callback' => array( $this, 'check_background' ),
				)
			)
		);

		// Separator.
		$wp_customize->add_control(
			new CRLPUIC_Section_Separator_Control(
				$wp_customize,
				$this->plugin_options . '[section_separator_content_column]',
				array(
					'label'           => __( 'Content Column', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_set_bg_image_for_column' ),
				)
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[content_title]',
			array(
				'label'           => __( 'Content Title', 'login-page-ui-customizer' ),
				'description'     => __( 'It is shown in the content column.', 'login-page-ui-customizer' ),
				'section'         => 'lpuic_design_section',
				'type'            => 'text',
				'active_callback' => array( $this, 'is_column_enabled' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[content_title_color]',
				array(
					'label'           => __( 'Title text Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to title text.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[content_desc]',
			array(
				'label'           => __( 'Description', 'login-page-ui-customizer' ),
				'description'     => __( 'It is shown in the content column area.', 'login-page-ui-customizer' ),
				'section'         => 'lpuic_design_section',
				'type'            => 'textarea',
				'active_callback' => array( $this, 'is_column_enabled' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[content_desc_color]',
				array(
					'label'           => __( 'Description text Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to description text.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$this->plugin_options . '[content_img]',
				array(
					'label'           => __( 'Content Image', 'login-page-ui-customizer' ),
					'description'     => __( 'It is shown in the content column area.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[content_column_bg_color]',
				array(
					'label'           => __( 'Content Column Background Color', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page Content Column background.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[content_column_bg_opacity]',
				array(
					'label'           => __( 'Content Column Background Opacity', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the content column background opacity.', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'lpuic_design_section',
					'input_attrs'     => array(
						'min'     => $this->defaults['opacity_min'],
						'max'     => $this->defaults['opacity_max'],
						'step'    => 0.1,
						'unit'    => '',
						'class'   => 'fx-range crlpuic-input-opacity',
						'style'   => 'color: #38aee0',
						'default' => 0.5,
					),
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		// Separator.
		$wp_customize->add_control(
			new CRLPUIC_Section_Separator_Control(
				$wp_customize,
				$this->plugin_options . '[section_separator_bg_column]',
				array(
					'label'           => __( 'Form Column Background', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_set_bg_image_for_column' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[column_width]',
				array(
					'label'           => __( 'Form Column width', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the form column.', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'lpuic_design_section',
					'input_attrs'     => array(
						'min'     => 20,
						'max'     => 100,
						'step'    => 1,
						'unit'    => '%',
						'class'   => 'fx-range crlpuic-input-opacity',
						'style'   => 'color: #38aee0',
						'default' => 50,
					),
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$this->plugin_options . '[form_column_bg_img]',
				array(
					'label'           => __( 'Form column background image', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page form column background.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_set_bg_image_for_column' ),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[form_column_bg_color]',
				array(
					'label'           => __( 'Form Column Background Color', 'login-page-ui-customizer' ),
					'description'     => __( 'If there is background image, this setting applies after changing the opacity.', 'login-page-ui-customizer' ),
					'section'         => 'lpuic_design_section',
					'active_callback' => array( $this, 'is_column_enabled' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[column_bg_opacity]',
				array(
					'label'           => __( 'Form Column Background Opacity', 'login-page-ui-customizer' ),
					'description'     => __( 'Applied to the login page background opacity.', 'login-page-ui-customizer' ),
					'type'            => 'range',
					'section'         => 'lpuic_design_section',
					'input_attrs'     => array(
						'min'     => $this->defaults['opacity_min'],
						'max'     => $this->defaults['opacity_max'],
						'step'    => 0.1,
						'unit'    => '',
						'class'   => 'fx-range crlpuic-input-opacity',
						'style'   => 'color: #38aee0',
						'default' => 0.5,
					),
					'active_callback' => array( $this, 'is_set_bg_image_for_column' ),
				)
			)
		);

		// Form Settings.
		$wp_customize->add_control(
			new CRLPUIC_Toggle_Control(
				$wp_customize,
				$this->plugin_options . '[transparent_background]',
				array(
					'type'        => 'crlpuic_toggle',
					'label'       => __( 'Transparent form', 'login-page-ui-customizer' ),
					'description' => __( 'If enabled, form background will be transparent', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[form_background_color]',
				array(
					'label'           => __( 'Form background color', 'login-page-ui-customizer' ),
					'description'     => __( 'select form background color', 'login-page-ui-customizer' ),
					'section'         => 'crlpuic_login_form_section',
					'active_callback' => array( $this, 'check_form_background' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Toggle_Control(
				$wp_customize,
				$this->plugin_options . '[form_wrapper]',
				array(
					'type'            => 'crlpuic_toggle',
					'label'           => __( 'Form wrapper', 'login-page-ui-customizer' ),
					'description'     => __( 'If enabled, wraps all elements, its background color is same as form color', 'login-page-ui-customizer' ),
					'section'         => 'crlpuic_login_form_section',
					'active_callback' => array( $this, 'check_form_background' ),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[form_width]',
				array(
					'label'       => __( 'Form width', 'login-page-ui-customizer' ),
					'description' => __( '(in %)', 'login-page-ui-customizer' ),
					'type'        => 'range',
					'section'     => 'crlpuic_login_form_section',
					'input_attrs' => array(
						'min'     => $this->defaults['form_min_width'],
						'max'     => $this->defaults['form_max_width'],
						'step'    => 1,
						'unit'    => '%',
						'class'   => 'fx-range crlpuic-input-site-width',
						'style'   => 'color: #38aee0',
						'default' => $this->defaults['form_width'],
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[form_label_color]',
				array(
					'label'       => __( 'Form label color', 'login-page-ui-customizer' ),
					'description' => __( 'Applied to the login label text.', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[form_label_font_size]',
				array(
					'label'       => __( 'Form label font size', 'login-page-ui-customizer' ),
					'description' => __( '(in px)', 'login-page-ui-customizer' ),
					'type'        => 'range',
					'section'     => 'crlpuic_login_form_section',
					'input_attrs' => array(
						'min'     => 8,
						'max'     => 50,
						'step'    => 1,
						'unit'    => 'px',
						'class'   => 'fx-range crlpuic-input-site-width',
						'style'   => 'color: #38aee0',
						'default' => $this->defaults['form_label_font_size'],
					),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Toggle_Control(
				$wp_customize,
				$this->plugin_options . '[field_icons]',
				array(
					'type'        => 'crlpuic_toggle',
					'label'       => __( 'Enable field icons', 'login-page-ui-customizer' ),
					'description' => __( 'If enabled it will show user icon & password icon at field', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[login_btn_bg_color]',
				array(
					'label'       => __( 'Button background color', 'login-page-ui-customizer' ),
					'description' => __( 'Applied to the login button.', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[login_btn_bg_hover]',
				array(
					'label'       => __( 'Button hover color', 'login-page-ui-customizer' ),
					'description' => __( 'Applied to the login button after hover.', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$this->plugin_options . '[login_btn_txt_color]',
				array(
					'label'       => __( 'Button text color', 'login-page-ui-customizer' ),
					'description' => __( 'Applied to the login text button.', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Range_Control(
				$wp_customize,
				$this->plugin_options . '[login_btn_font_size]',
				array(
					'label'       => __( 'Button text font size', 'login-page-ui-customizer' ),
					'description' => __( '(in px)', 'login-page-ui-customizer' ),
					'type'        => 'range',
					'section'     => 'crlpuic_login_form_section',
					'input_attrs' => array(
						'min'     => 8,
						'max'     => 100,
						'step'    => 1,
						'unit'    => 'px',
						'class'   => 'fx-range crlpuic-input-site-width',
						'style'   => 'color: #38aee0',
						'default' => $this->defaults['login_btn_font_size'],
					),
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Toggle_Control(
				$wp_customize,
				$this->plugin_options . '[rememberme_hide]',
				array(
					'type'        => 'crlpuic_toggle',
					'label'       => __( 'Hide Remember Me setting', 'login-page-ui-customizer' ),
					'description' => __( 'If enabled it will hide Remember Me link ', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		$wp_customize->add_control(
			new CRLPUIC_Toggle_Control(
				$wp_customize,
				$this->plugin_options . '[hide_links]',
				array(
					'type'        => 'crlpuic_toggle',
					'label'       => __( 'Hide links below form', 'login-page-ui-customizer' ),
					'description' => __( 'If enabled it will hide lost password & back to website link ', 'login-page-ui-customizer' ),
					'section'     => 'crlpuic_login_form_section',
				)
			)
		);

		// Form text edit Settings.
		$wp_customize->add_control(
			$this->plugin_options . '[username_label]',
			array(
				'label'       => __( 'Username Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Username Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-username-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[password_label]',
			array(
				'label'       => __( 'Password Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Password Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-password-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[rememberme_label]',
			array(
				'label'       => __( 'Remember Me Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Remember Me Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-rememberme-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[lost_password_text]',
			array(
				'label'       => __( 'Lost Password Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Lost Password Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-lost-password-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[back_to_website]',
			array(
				'label'       => __( 'Back To Website Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Back To Website', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-back-to-website-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[login_btn_text]',
			array(
				'label'       => __( 'Button Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Button Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_login_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		// Register Form text edit.
		$wp_customize->add_control(
			$this->plugin_options . '[register_username_label]',
			array(
				'label'       => __( 'Username Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Username Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-username-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[register_email_label]',
			array(
				'label'       => __( 'Email Address Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit email Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[registration_message]',
			array(
				'label'       => __( 'Registration Message', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Registration message text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'textarea',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[register_btn_label]',
			array(
				'label'       => __( 'Register Button Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Register Button Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[register_link_label]',
			array(
				'label'       => __( 'Register link Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Register link Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[login_link_label]',
			array(
				'label'       => __( 'Login link Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Log In Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_register_form_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);

		// Lost Password Form text edit.
		$wp_customize->add_control(
			$this->plugin_options . '[lost_pwd_username_label]',
			array(
				'label'       => __( 'Username Label', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Username Label', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_lost_pwd_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-username-text',
				),
			)
		);

		$wp_customize->add_control(
			$this->plugin_options . '[lost_pwd_button_label]',
			array(
				'label'       => __( 'Button Text', 'login-page-ui-customizer' ),
				'description' => __( 'Edit Button Text', 'login-page-ui-customizer' ),
				'section'     => 'crlpuic_lost_pwd_form_text_edit_section',
				'type'        => 'text',
				'input_attrs' => array(
					'class' => 'crlpuic-button-text',
				),
			)
		);
	}

	/**
	 * Login page template.
	 *
	 * @param string $template Tempale.
	 * @return string $template Modified login template.
	 */
	public function apply_login_page_template( $template ) {

		if ( is_customize_preview() && isset( $_REQUEST['crlpuic-login-page-customizer-customization'] ) && is_user_logged_in() ) { // phpcs:ignore WordPress.Security.NonceVerification
			$new_template = CRLPUIC_TPL_DIR_PATH . '/login-page-template.php';
			return $new_template;
		}

		return $template;
	}

	/**
	 * Callback functions to check logo setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function custom_logo_enabled( $control ) {

		if ( 'show_logo' === $control->manager->get_setting( 'crlpuic-settings[logo_settings]' )->value() ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback functions to check title setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function is_logo_title_enabled( $control ) {

		if ( 'show_title' === $control->manager->get_setting( 'crlpuic-settings[logo_settings]' )->value() ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback functions to check login page background setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function check_background( $control ) {

		if ( 'bg_image' === $control->manager->get_setting( 'crlpuic-settings[background]' )->value() ) {

			return true;
		}

		return false;
	}

	/**
	 * Callback functions to check form background setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function check_form_background( $control ) {

		if ( true === $control->manager->get_setting( 'crlpuic-settings[transparent_background]' )->value() ) {
			return false;
		}

		return true;
	}

	/**
	 * Callback functions to check column setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function is_column_enabled( $control ) {

		if ( 'center_form' === $control->manager->get_setting( 'crlpuic-settings[login_template]' )->value() || 'center_form_1' === $control->manager->get_setting( 'crlpuic-settings[login_template]' )->value() ) {
			return false;
		}

		return true;
	}

	/**
	 * Callback functions to check background color setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function check_background_color( $control ) {

		if ( 'bg_color' === $control->manager->get_setting( 'crlpuic-settings[background]' )->value() ) {

			return true;
		}

		return false;
	}

	/**
	 * Callback functions to check background image for column setting has been set.
	 *
	 * @param object $control Control object.
	 * @return bool It returns bool.
	 */
	public function is_set_bg_image_for_column( $control ) {

		if ( 'bg_image' === $control->manager->get_setting( 'crlpuic-settings[background]' )->value() && ( 'left_form' === $control->manager->get_setting( 'crlpuic-settings[login_template]' )->value() || 'right_form' === $control->manager->get_setting( 'crlpuic-settings[login_template]' )->value() ) ) {

			return true;
		}

		return false;
	}

}
