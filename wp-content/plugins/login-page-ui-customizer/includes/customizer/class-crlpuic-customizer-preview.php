<?php
/**
 * This file is regarding Customizer preview functionality for the plugin.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CRLPUIC_Customizer_Preview class handles CSS settings as provided in customizer.
 */
class CRLPUIC_Customizer_Preview {

	/**
	 * Var $options Defines plugin customizer options.
	 *
	 * @var array $options Settings.
	 */
	public $options = array();

	/**
	 * Var $defaults Defines plugin customizer deault settings.
	 *
	 * @var array $defaults Settings.
	 */
	private $defaults;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->defaults = crlpuic_get_customizer_defaults();
		$this->options  = get_option( CRLPUIC_SLUG );

		global $wp_version;

		add_action( 'login_init', array( $this, 'modify_text_of_links_below_form' ) );

		add_action( 'login_form_login', array( $this, 'modify_login_form_labels' ) );
		add_action( 'login_form_register', array( $this, 'modify_register_texts' ) );
		add_action( 'login_form_lostpassword', array( $this, 'modify_lost_pwd_texts' ) );

		add_action( 'login_header', array( $this, 'add_content_div' ) );
		add_action( 'login_footer', array( $this, 'close_content_div' ) );

		add_filter( 'login_body_class', array( $this, 'body_class' ) );

		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_login_page_scripts' ) );

		add_filter( 'login_headerurl', array( $this, 'logo_url' ), 99 );

		if ( version_compare( $wp_version, '5.2.0', '<' ) ) {

			add_filter( 'login_headertitle', array( $this, 'logo_title' ), 99 );

		} else {

			add_filter( 'login_headertext', array( $this, 'logo_title' ), 26 );

		}

		add_filter( 'login_title', array( $this, 'login_page_title' ), 99 );

	}

	/**
	 * Load style for login page preview.
	 *
	 * @access public
	 */
	public function enqueue_login_page_scripts() {

		// Enqueue login page static style.
		wp_enqueue_style( 'crlpuic-custom-login', CRLPUIC_PLUGIN_DIR . '/assets/css/login-style.min.css', array( 'login' ), CRLPUIC_VER, 'all' );

		// Add dynamic generated CSS to login style.
		wp_add_inline_style( 'crlpuic-custom-login', $this->login_page_css_generated_by_customizer() );

		// Get template style.
		$crlpuic_settings = get_option( CRLPUIC_SLUG );
		$custom_css       = isset( $crlpuic_settings['custom_css'] ) ? $crlpuic_settings['custom_css'] : '';
		wp_add_inline_style( 'crlpuic-custom-login', $custom_css );

		wp_enqueue_script( 'crlpuic-custom-login-script', CRLPUIC_PLUGIN_DIR . '/assets/js/custom.min.js', array( 'jquery' ), CRLPUIC_VER, true );

	}

	/**
	 * Generate CSS from customizer settings.
	 */
	public function login_page_css_generated_by_customizer() {

		// Generate CSS as per customizer settings.

		$crlpuic_settings = get_option( CRLPUIC_SLUG );

		// Background section.

		$login_template = isset( $crlpuic_settings['login_template'] ) ? $crlpuic_settings['login_template'] : '';
		$background     = isset( $crlpuic_settings['background'] ) ? $crlpuic_settings['background'] : '';
		$bg_image       = isset( $crlpuic_settings['bg_image'] ) ? $crlpuic_settings['bg_image'] : '';
		$bg_overlay     = isset( $crlpuic_settings['bg_overlay'] ) ? $crlpuic_settings['bg_overlay'] : '';
		$bg_color       = isset( $crlpuic_settings['bg_color'] ) ? $crlpuic_settings['bg_color'] : '';

		// Hex to rgb.
		list($r, $g, $b) = sscanf( $bg_overlay, '#%02x%02x%02x' );
		$bg_overlay_rgb  = $r . ', ' . $g . ', ' . $b;

		$bg_opacity              = isset( $crlpuic_settings['bg_opacity'] ) ? strval( $crlpuic_settings['bg_opacity'] ) : '';
		$form_column_bg_color    = isset( $crlpuic_settings['form_column_bg_color'] ) ? $crlpuic_settings['form_column_bg_color'] : '';
		$content_title_color     = isset( $crlpuic_settings['content_title_color'] ) ? $crlpuic_settings['content_title_color'] : '';
		$content_desc_color      = isset( $crlpuic_settings['content_desc_color'] ) ? $crlpuic_settings['content_desc_color'] : '';
		$content_column_bg_color = isset( $crlpuic_settings['content_column_bg_color'] ) ? $crlpuic_settings['content_column_bg_color'] : '';

		// Hex to rgb.
		list($r, $g, $b) = sscanf( $content_column_bg_color, '#%02x%02x%02x' );
		$cc_bg_color_rgb = $r . ', ' . $g . ', ' . $b;

		$content_column_bg_opacity = isset( $crlpuic_settings['content_column_bg_opacity'] ) ? $crlpuic_settings['content_column_bg_opacity'] : '';

		$column_bg_opacity    = isset( $crlpuic_settings['column_bg_opacity'] ) ? strval( $crlpuic_settings['column_bg_opacity'] ) : '';
		$form_column_bg_img   = isset( $crlpuic_settings['form_column_bg_img'] ) ? $crlpuic_settings['form_column_bg_img'] : '';
		$column_width         = isset( $crlpuic_settings['column_width'] ) ? $crlpuic_settings['column_width'] : '';
		$content_column_width = 100 - $column_width;

		// Hex to rgb.
		list($r1, $g1, $b1)         = sscanf( $form_column_bg_color, '#%02x%02x%02x' );
		$form_column_bg_overlay_rgb = $r1 . ', ' . $g1 . ', ' . $b1;

		// Logo section.

		$logo_settings        = isset( $crlpuic_settings['logo_settings'] ) ? $crlpuic_settings['logo_settings'] : '';
		$logo_title           = isset( $crlpuic_settings['logo_title'] ) ? $crlpuic_settings['logo_title'] : '';
		$logo_title_color     = isset( $crlpuic_settings['logo_title_color'] ) ? $crlpuic_settings['logo_title_color'] : '';
		$login_page_title     = isset( $crlpuic_settings['login_page_title'] ) ? $crlpuic_settings['login_page_title'] : '';
		$logo_title_font_size = isset( $crlpuic_settings['logo_title_font_size'] ) ? $crlpuic_settings['logo_title_font_size'] : '';

		$default_wp_logo    = get_site_url() . '/wp-admin/images/wordpress-logo.svg';
		$custom_logo        = isset( $crlpuic_settings['custom_logo'] ) ? $crlpuic_settings['custom_logo'] : $default_wp_logo;
		$custom_logo_height = isset( $crlpuic_settings['custom_logo_height'] ) ? $crlpuic_settings['custom_logo_height'] : '';

		// Form section.

		$form_width            = isset( $crlpuic_settings['form_width'] ) ? $crlpuic_settings['form_width'] : '';
		$transparent_bg        = isset( $crlpuic_settings['transparent_background'] ) ? $crlpuic_settings['transparent_background'] : false;
		$form_bg_color         = isset( $crlpuic_settings['form_background_color'] ) ? $crlpuic_settings['form_background_color'] : '';
		$form_background_color = ( true === $transparent_bg ) ? 'transparent' : $form_bg_color;

		$form_wrapper = ( isset( $crlpuic_settings['form_wrapper'] ) && false === $transparent_bg ) ? $crlpuic_settings['form_wrapper'] : false;

		$form_label_color     = isset( $crlpuic_settings['form_label_color'] ) ? $crlpuic_settings['form_label_color'] : '';
		$form_label_font_size = isset( $crlpuic_settings['form_label_font_size'] ) ? $crlpuic_settings['form_label_font_size'] : '';
		$login_btn_text       = isset( $crlpuic_settings['login_btn_text'] ) ? $crlpuic_settings['login_btn_text'] : '';
		$login_btn_bg_color   = isset( $crlpuic_settings['login_btn_bg_color'] ) ? $crlpuic_settings['login_btn_bg_color'] : '';
		$login_btn_bg_hover   = isset( $crlpuic_settings['login_btn_bg_hover'] ) ? $crlpuic_settings['login_btn_bg_hover'] : '';
		$login_btn_shodow     = isset( $crlpuic_settings['login_btn_shodow'] ) ? $crlpuic_settings['login_btn_shodow'] : '';
		$login_btn_txt_shodow = isset( $crlpuic_settings['login_btn_txt_shodow'] ) ? $crlpuic_settings['login_btn_txt_shodow'] : '';
		$login_btn_txt_color  = isset( $crlpuic_settings['login_btn_txt_color'] ) ? $crlpuic_settings['login_btn_txt_color'] : '';
		$login_btn_font_size  = isset( $crlpuic_settings['login_btn_font_size'] ) ? $crlpuic_settings['login_btn_font_size'] : '';

		$field_icons     = isset( $crlpuic_settings['field_icons'] ) ? $crlpuic_settings['field_icons'] : false;
		$hide_links      = isset( $crlpuic_settings['hide_links'] ) ? $crlpuic_settings['hide_links'] : false;
		$rememberme_hide = isset( $crlpuic_settings['rememberme_hide'] ) ? $crlpuic_settings['rememberme_hide'] : false;

		$custom_css = isset( $crlpuic_settings['custom_css'] ) ? $crlpuic_settings['custom_css'] : '';

		// Template.
		if ( 'left_form' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { right: 0; }';
		} elseif ( 'right_form' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { left: 0; }';
		} elseif ( 'center_form' === $login_template ) {
			$crlpuic_css  = '.crlpuic-wrapper .crlpuic-content { display: none; }';
			$crlpuic_css .= 'body:not(.crlpuic-one-half) .crlpuic-wrapper .crlpuic-form-wrapper { 
							width: 100%;
							background-color:' . $bg_color . ';
						};';
		} elseif ( 'boxed_left' === $login_template || 'form_1_3_left' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { right: 0; }';
		} elseif ( 'boxed_right' === $login_template || 'form_1_3_right' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { left: 0; }';
		} elseif ( 'modern_left' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { right: 0; }';
		} elseif ( 'modern_right' === $login_template ) {
			$crlpuic_css = '.crlpuic-wrapper .crlpuic-content { left: 0; }';
		} else {
			$crlpuic_css = '';
		}

		// Background Style.
		if ( 'bg_color' === $background ) {

			$crlpuic_css .= '.crlpuic-overlay {  rgba(' . $bg_overlay_rgb . ', ' . $bg_opacity . ') }';
			$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-form-wrapper, body.crlpuic-one-half .crlpuic-wrapper .crlpuic-form-wrapper { 

								background-image:none; 
								background-color:' . $form_column_bg_color . ';
								width:' . $column_width . '%;
							}';
			$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content {
								width:' . $content_column_width . '% ;
								background-color:' . $content_column_bg_color . ';
								
							}';

		} else {

			if ( '' !== $bg_image ) {

				$crlpuic_css = 'body {
									background-repeat: no-repeat;
									background-position: center center; 
									background: 
											linear-gradient(
											rgba(' . $bg_overlay_rgb . ', ' . $bg_opacity . '),
											rgba(' . $bg_overlay_rgb . ', ' . $bg_opacity . ')
											),
											url(' . $bg_image . ');
									background-size: cover;
									background-color: rgb(' . $bg_overlay_rgb . ');
								}';
			} else {

				$crlpuic_css = '.crlpuic-overlay {
									background-color: rgba(' . $bg_overlay_rgb . ', ' . $bg_opacity . '); 
								}';

			}

			$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content {
				background-color:' . $content_column_bg_color . ';
				background: 
								linear-gradient(
								rgba(' . $cc_bg_color_rgb . ', ' . $content_column_bg_opacity . '),
								rgba(' . $cc_bg_color_rgb . ', ' . $content_column_bg_opacity . ')
								);
			}';

			if ( '' !== $form_column_bg_img ) {

				$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-form-wrapper, body.crlpuic-one-half .crlpuic-form-wrapper { 
									background-color:' . $form_column_bg_color . ';
									background: 
											linear-gradient(
											rgba(' . $form_column_bg_overlay_rgb . ', ' . $column_bg_opacity . '),
											rgba(' . $form_column_bg_overlay_rgb . ', ' . $column_bg_opacity . ')
											),
											url(' . $form_column_bg_img . ');
									background-size: cover;
									width:' . $column_width . '% ;
								}';
			} else {

				$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-form-wrapper, body.crlpuic-one-half .crlpuic-form-wrapper {
									background-color:' . $form_column_bg_color . ';
									background: 
											linear-gradient(
											rgba(' . $form_column_bg_overlay_rgb . ', ' . $column_bg_opacity . '),
											rgba(' . $form_column_bg_overlay_rgb . ', ' . $column_bg_opacity . ')
											);
									width:' . $column_width . '% ;
								}';
			}

			$crlpuic_css .= 'body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content {
							width:' . $content_column_width . '% ;
						}';

		}

		// Logo style.

		if ( 'show_logo' === $logo_settings ) {

			$crlpuic_css .= '.login h1 a{
								background-image: url(' . $custom_logo . ');
								height:' . $custom_logo_height . 'px;
							}';
		} elseif ( 'show_title' === $logo_settings ) {

			$crlpuic_css .= '.login h1 a{
								background-image: none;
								height:auto;
								text-indent: unset;
								color: ' . $logo_title_color . ';
								font-size:' . $logo_title_font_size . 'px;
								margin-bottom:0;
							}';
		} elseif ( 'hide_logo' === $logo_settings ) {
			$crlpuic_css .= '.login h1 a{ display: none;}';
		}

		// Form style.
		$login_width = $form_width + 5;

		$crlpuic_css .= '#login {
								width:' . $login_width . '%;
							}';
		$crlpuic_css .= '.login #login_error, .login .message {
								width:' . $form_width . '% !important;
								margin: 0 auto;
								box-sizing: border-box;
							}';

		$crlpuic_css .= '#loginform, #registerform, #lostpasswordform {
								background-color:' . $form_background_color . ';
								width:' . $form_width . '%;
							}';
		$crlpuic_css .= '#loginform .button-primary,
					   #registerform .button-primary,
					   #lostpasswordform .button-primary {
								background-color:' . $login_btn_bg_color . ';
								color:' . $login_btn_txt_color . ';
								font-size:' . $login_btn_font_size . 'px;
							}';
		$crlpuic_css .= '#loginform .button-primary:hover,
					   #registerform .button-primary:hover,
					   #lostpasswordform .button-primary:hover {
								background-color:' . $login_btn_bg_hover . ';
							}';

		$crlpuic_css .= '.login label, .login #backtoblog a, .login #nav a, #reg_passmail,
					   .login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a { 
								color:' . $form_label_color . '; 
								font-size:' . $form_label_font_size . 'px;
							}';

		if ( true === $form_wrapper ) {

			$crlpuic_css .= '.crlpuic-login-form-bg #login {
								background-color:' . $form_background_color . ';
								padding: 20px 10px;
							}';

			$crlpuic_css .= '.crlpuic-wrapper #login{ 
								max-width:' . $form_width . '%; 
							}';

			$crlpuic_css .= '.login form{
								border: none;
								box-shadow: none;
							}';

		}

		if ( $field_icons ) {

			$crlpuic_css .= '#loginform #user_login {
								padding-left: 27px;
								background-image: url(' . CRLPUIC_PLUGIN_DIR . '/assets/images/username.svg);
								background-repeat: no-repeat;
							}';

			$crlpuic_css .= '#loginform #user_pass {
								padding-left: 27px;
								background-image: url(' . CRLPUIC_PLUGIN_DIR . '/assets/images/password.svg);
								background-repeat: no-repeat;
							}';

		} else {
			$crlpuic_css .= '#loginform #user_login, #loginform #user_pass {
								padding-left: 17px;
								background-image:none;
							}';

		}

		if ( true === $rememberme_hide ) {

			$crlpuic_css .= '.login .forgetmenot{ display:none;}';

		} else {

			$crlpuic_css .= '.login .forgetmenot{ display:block;}';

		}

		if ( true === $hide_links ) {

			$crlpuic_css .= '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a{ display:none;}';

		} else {

			$crlpuic_css .= '.login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a{ display:inline-block;}';

		}

		// Disable links in customizer.
		if ( is_customize_preview() ) {
			$crlpuic_css .= '#crlpuic-logo-link, .login #nav, .login #backtoblog, .login #backtoblog a, .login #nav a, #loginform .button-primary { cursor: not-allowed !important; }';

			if ( 'center_form' === $login_template || 'center_form_1' === $login_template ) {
					$crlpuic_css .= '#login {
										width: ' . $login_width . '%;
									}';
			} else {
					$crlpuic_css .= '#login {
										width: auto;
									}';
			}

			$crlpuic_css .= '.crlpuic-preview-event {
								display: inline-block;
								cursor: pointer;
								background-color: #008ec2;
								border-radius: 100%;
								color: #fff;
								width: 30px;
								height: 30px;
								text-align: center;
								border: 2px solid #fff;
								box-shadow: 0 2px 1px rgba(46,68,83,.15);
							}

							#logo-edit,
							#crlpuic-logo{
								left: 45%;
								top: 0;
							}
							
							.logo-edit,
							.form-edit {
								line-height: 30px;
							}';

			if ( 'center_form' !== $login_template || 'center_form_1' !== $login_template ) {
				$crlpuic_css .= '#crlpuic-content-edit{
									left: 8%;
								}';
				$crlpuic_css .= '.center_form_bg_edit{
									display:none;
								}';
			}

			if ( 'center_form' === $login_template || 'center_form_1' === $login_template ) {
				$crlpuic_css .= '.crlpuic-preview-event {
									left:5%;
									top: 200px;
								}';
			}
		}

		if ( 'fresh_food' === $login_template ) {
			$crlpuic_css .= '.login form{
								box-shadow: none;
							}';
		} else {
			$crlpuic_css .= '.login form{
				box-shadow: rgba(0,0,0,.2) 0 4px 40px;
			}';
		}

		if ( 'center_form' !== $login_template || 'center_form_1' !== $login_template ) {
			$crlpuic_css .= '.crlpuic-content-wrapper-inner h2.content-title{
								color: ' . $content_title_color . ';
							}';
			$crlpuic_css .= '.crlpuic-content-wrapper-inner p.content-desc{
								color: ' . $content_desc_color . ';
							}';
		}

		// Media Query.
		$crlpuic_css .= '@media only screen and (max-width: 768px) {';

		$crlpuic_css .= '.crlpuic-wrapper #login, #loginform, #registerform, #lostpasswordform, .login #login_error, .login .message {
						width: 100% !important;
						max-width: 100%;
					}';

		$crlpuic_css .= '.crlpuic-wrapper #login{
						max-width: 80%;
					}';

		$crlpuic_css .= '}';

		return $crlpuic_css;
	}

	/**
	 * Adding div elements for show content on login page.
	 */
	public function add_content_div() {
		?>
		<div class="crlpuic-overlay"></div>
		<div class="crlpuic-wrapper">
			<?php
			if ( is_customize_preview() ) {

				if ( 'center_form' !== $this->options['login_template'] ) {
					?>
					<div id="crlpuic-content-edit" class="crlpuic-preview-event center_form_bg_edit" data-section="lpuic_design_section"><span class="dashicons dashicons-edit form-edit"></span></div>
					<?php
				}
			}
			?>
			<div class="crlpuic-content">
				<div class="crlpuic-content-wrapper">
					<?php
					if ( is_customize_preview() ) {
						?>
							<div id="crlpuic-content-edit" class="crlpuic-preview-event" data-section="lpuic_design_section"><span class="dashicons dashicons-edit form-edit"></span></div>
							<?php
					}
					?>
					<div class="crlpuic-content-wrapper-inner">
						<?php
						if ( is_customize_preview() ) {
							echo ( isset( $this->options['content_title'] ) ) ? '<h2 class="content-title">' . esc_html( $this->options['content_title'] ) . '</h2>' : '';
							echo ( isset( $this->options['content_desc'] ) ) ? '<p class="content-desc">' . esc_html( $this->options['content_desc'] ) . '</p>' : '';
							echo ( isset( $this->options['content_img'] ) ) ? '<img src="' . esc_url( $this->options['content_img'] ) . '" alt="Introduction" class="content-img" width="" height="" />' : '';
						} else {
							echo ( isset( $this->options['content_title'] ) && ! empty( $this->options['content_title'] ) ) ? '<h2 class="content-title">' . esc_html( $this->options['content_title'] ) . '</h2>' : '';
							echo ( isset( $this->options['content_desc'] ) && ! empty( $this->options['content_title'] ) ) ? '<p class="content-desc">' . esc_html( $this->options['content_desc'] ) . '</p>' : '';
							echo ( isset( $this->options['content_img'] ) && ! empty( $this->options['content_img'] ) ) ? '<img src="' . esc_url( $this->options['content_img'] ) . '" alt="Introduction" class="content-img" width="" height="" />' : '';
						}
						?>
					</div>
				</div>
			</div>
		<div class="crlpuic-form-wrapper">
			<div class="crlpuic-form-wrapper-inner">
		<?php
	}

	/**
	 * Closing div elements for show content on login page.
	 */
	public function close_content_div() {
		echo wp_kses_post( '</div></div></div>' );
	}

	/**
	 * Add body classes on login page.
	 *
	 * @param array $classes Body classes.
	 * @return array  $classes All body classes.
	 */
	public function body_class( $classes ) {

		$login_template = isset( $this->options['login_template'] ) ? $this->options['login_template'] : 'center_form';

		if ( 'left_form' === $login_template || 'form_1_3_left' === $login_template ) {

			$classes[] = 'crlpuic-one-half crlpuic-left-form crlpuic-form-1-3-left';

		} elseif ( 'right_form' === $login_template || 'form_1_3_right' === $login_template || 'fresh_food' === $login_template ) {

			$classes[] = 'crlpuic-one-half crlpuic-right-form';

		} elseif ( 'center_form' === $login_template || 'center_form_1' === $login_template ) {

			$classes[] = 'crlpuic-full-width center-form';

			if ( 'center_form_1' === $login_template ) {
				$classes[] = 'center-form-1';
			}
		} elseif ( 'boxed_left' === $login_template ) {

			$classes[] = 'crlpuic-one-half crlpuic-left-form boxed';

		} elseif ( 'boxed_right' === $login_template ) {

			$classes[] = 'crlpuic-one-half crlpuic-right-form boxed';

		}

		$classes[] = 'crlpuic-login-form-bg';

		return $classes;
	}

	/**
	 * Get logo URL on login page.
	 *
	 * @param string $url Logo URL.
	 * @return string  $url Custom logo url if it is there.
	 */
	public function logo_url( $url ) {

		$default_wp_logo = get_site_url() . '/wp-admin/images/wordpress-logo.svg';

		$custom_logo = isset( $this->options['custom_logo'] ) ? $this->options['custom_logo'] : $default_wp_logo;

		if ( '' !== $custom_logo ) {

			return esc_url( site_url() );
		}

		return $url;
	}

	/**
	 * Get title of login page.
	 *
	 * @param string $title Title.
	 * @return string  $title Title if it is set there.
	 */
	public function logo_title( $title ) {

		$logo_title = isset( $this->options['logo_title'] ) ? $this->options['logo_title'] : '';

		if ( '' !== $logo_title ) {
			return wp_kses_post( $logo_title );
		}

		return $title;
	}

	/**
	 * Get page title of login page.
	 *
	 * @param string $title Page title.
	 * @return string  $title Page title if it is set there.
	 */
	public function login_page_title( $title ) {

		$logo_title = isset( $this->options['login_page_title'] ) ? $this->options['login_page_title'] : get_bloginfo( 'title', 'display' );

		if ( '' !== $logo_title ) {

			return esc_html( $logo_title );

		}

		return $title;
	}

	/**
	 * Filters to modify if required Login form label text.
	 */
	public function modify_login_form_labels() {

		add_filter( 'gettext', array( $this, 'modify_username_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_password_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_rememberme_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_login_button_text' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_register_login_link_text' ), 99, 3 );

	}

	/**
	 * Lost password & back to website link text modification.
	 */
	public function modify_text_of_links_below_form() {

		add_filter( 'gettext', array( $this, 'modify_lost_password_label' ), 99, 3 );
		add_filter( 'gettext_with_context', array( $this, 'modify_back_to_text' ), 99, 4 );

	}

	/**
	 * Check Register page texts.
	 */
	public function modify_register_texts() {

		add_filter( 'gettext', array( $this, 'modify_register_username_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_register_email_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_register_register_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_register_confirmation_text' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_login_register_link_text' ), 99, 3 );

	}

	/**
	 * Check Lost Password page texts.
	 */
	public function modify_lost_pwd_texts() {

		add_filter( 'gettext', array( $this, 'change_lost_pwd_username_label' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'change_lost_pwd_button_label' ), 99, 3 );

		add_filter( 'gettext', array( $this, 'modify_register_login_link_text' ), 99, 3 );
		add_filter( 'gettext', array( $this, 'modify_login_register_link_text' ), 99, 3 );

	}

	/**
	 * For custom username label text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text Username modified text.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_username_label( $translated_text, $new_text, $text_domain ) {

		$default_value  = 'Username or Email Address';
		$username_label = isset( $this->options['username_label'] ) ? $this->options['username_label'] : $default_value;

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Check if the login button text is changed.
		if ( $username_label === $new_text ) {
			return $translated_text;
		} else {
			$translated_text = esc_attr( $username_label );
		}

		return $translated_text;
	}

	/**
	 * For custom password label.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text The modified label.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_password_label( $translated_text, $new_text, $text_domain ) {

		$default_value  = 'Password';
		$password_label = isset( $this->options['password_label'] ) ? $this->options['password_label'] : $default_value;

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $password_label === $new_text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $password_label );
		}

		return $translated_text;
	}

	/**
	 * For custom remember me text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text The modified label.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_rememberme_label( $translated_text, $new_text, $text_domain ) {

		$default_value    = 'Remember Me';
		$rememberme_label = isset( $this->options['rememberme_label'] ) ? $this->options['rememberme_label'] : $default_value;

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Check if the label is modified.
		if ( $rememberme_label === $new_text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $rememberme_label );
		}

		return $translated_text;
	}

	/**
	 * For custom login button text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text The modified label.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_login_button_text( $translated_text, $new_text, $text_domain ) {

		$default_value  = 'Log In';
		$login_btn_text = isset( $this->options['login_btn_text'] ) ? $this->options['login_btn_text'] : 'Log In';

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Check if the login button text is changed.
		if ( $login_btn_text === $new_text ) {
			return $translated_text;
		} else {
			$translated_text = esc_attr( $login_btn_text );
		}

		return $translated_text;
	}

	/**
	 * For custom login button text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text The modified label.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_lost_password_label( $translated_text, $new_text, $text_domain ) {

		$default_value = 'Lost your password?';

		$lost_password_text = isset( $this->options['lost_password_text'] ) ? $this->options['lost_password_text'] : $default_value;

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Check if the label is modified.
		if ( $lost_password_text === $new_text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $lost_password_text );
		}

		return $translated_text;
	}

	/**
	 * For custom Back to website text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $new_text The modified label.
	 * @param string $context Context.
	 * @param string $text_domain The text domain.
	 * @return string
	 */
	public function modify_back_to_text( $translated_text, $new_text, $context, $text_domain ) {

		$default_value   = '&larr; Go to %s';
		$back_to_website = isset( $this->options['back_to_website'] ) ? $this->options['back_to_website'] : '';

		if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true ) && 'site' === $context ) {

			$translated_text = str_ireplace( $default_value, $back_to_website, $translated_text );

			$translated_text = str_replace( '{site_title}', get_bloginfo(), $translated_text );

			return $translated_text;
		}

		// Check with default value.
		if ( $default_value !== $new_text ) {
			return $translated_text;
		}

		// Check if the label is modified.
		if ( $back_to_website === $new_text ) {
			return $translated_text;
		} else {
			// AIO WP Security Compatibility.
			if ( class_exists( 'AIO_WP_Security' ) ) {
				$translated_text = esc_html( $back_to_website );
			} else {
				$translated_text = '&larr; ' . esc_html( $back_to_website ) . ' %s';
			}
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom register username label.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_register_username_label( $translated_text, $text, $domain ) {

		$default_value           = 'Username';
		$register_username_label = isset( $this->options['register_username_label'] ) ? $this->options['register_username_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $register_username_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = wp_kses_post( $register_username_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom register email label.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_register_email_label( $translated_text, $text, $domain ) {

		$default_value        = 'Email';
		$register_email_label = isset( $this->options['register_email_label'] ) ? $this->options['register_email_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $register_email_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $register_email_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom registration confirmation text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_register_confirmation_text( $translated_text, $text, $domain ) {

		$default_value        = 'Registration confirmation will be emailed to you.';
		$registration_message = isset( $this->options['registration_message'] ) ? $this->options['registration_message'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $registration_message === $text ) {
			return $translated_text;
		} else {
			$translated_text = wp_kses_post( $registration_message );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom register button text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_register_register_label( $translated_text, $text, $domain ) {

		$default_value      = 'Register';
		$register_btn_label = isset( $this->options['register_btn_label'] ) ? $this->options['register_btn_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $register_btn_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $register_btn_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom register link text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_login_register_link_text( $translated_text, $text, $domain ) {

		$default_value       = 'Log in';
		$register_link_label = isset( $this->options['login_link_label'] ) ? $this->options['login_link_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $register_link_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $register_link_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom register login link text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function modify_register_login_link_text( $translated_text, $text, $domain ) {

		$default_value       = 'Register';
		$register_link_label = isset( $this->options['register_link_label'] ) ? $this->options['register_link_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $register_link_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $register_link_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom username label text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function change_lost_pwd_username_label( $translated_text, $text, $domain ) {

		$default_value           = 'Username or Email Address';
		$lost_pwd_username_label = isset( $this->options['lost_pwd_username_label'] ) ? $this->options['lost_pwd_username_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $lost_pwd_username_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = wp_kses_post( $lost_pwd_username_label );
		}

		return $translated_text;
	}

	/**
	 * Customizer output for custom lost password button text.
	 *
	 * @param string $translated_text The translated text.
	 * @param string $text The label we want to replace.
	 * @param string $domain The text domain of the site.
	 * @return string
	 */
	public function change_lost_pwd_button_label( $translated_text, $text, $domain ) {

		$default_value         = 'Get New Password';
		$lost_pwd_button_label = isset( $this->options['lost_pwd_button_label'] ) ? $this->options['lost_pwd_button_label'] : $default_value;

		// Check if is our text.
		if ( $default_value !== $text ) {
			return $translated_text;
		}

		// Modify if the text is changed.
		if ( $lost_pwd_button_label === $text ) {
			return $translated_text;
		} else {
			$translated_text = esc_html( $lost_pwd_button_label );
		}

		return $translated_text;
	}

}
