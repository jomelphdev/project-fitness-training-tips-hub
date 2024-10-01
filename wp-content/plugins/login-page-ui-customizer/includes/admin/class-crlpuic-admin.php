<?php
/**
 * Registers and sets-up admin page settings.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Class CRLPUIC_Admin handles admin settings of the plugin.
 *
 * @since 1.0.0
 */
class CRLPUIC_Admin {

	/**
	 * Var $admin_options Settings.
	 *
	 * @var array $admin_options Settings.
	 */
	public $admin_options = CRLPUIC_ADMIN_OPTION;

	/**
	 * Var $page_id Page id.
	 *
	 * @var array $page_id Page id.
	 */
	public $page_id = CRLPUIC_SLUG;

	/**
	 * Var $customizer_settings Customizer settings.
	 *
	 * @var array $customizer_settings Customizer Settings.
	 */
	private $customizer_settings = CRLPUIC_SLUG;

	/**
	 * Var $default_options Default Settings.
	 *
	 * @var array $default_options Default Settings.
	 */
	public $default_options;

	/**
	 * Var $admin_default_options Admin Default Settings.
	 *
	 * @var array $admin_default_options Admin Default Settings.
	 */
	public $admin_default_options;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->set_default_options();

		// Load admin style.
		add_action( 'admin_enqueue_scripts', array( $this, 'wp_enqueue_admin_css' ) );

		add_action( 'admin_menu', array( $this, 'register_config_page' ) );

		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Sanitize settings.
		add_action( 'crlpuic_sanitize_settings', array( $this, 'sanitize' ) );

		// Confirm dialog before reset settings.
		add_action( 'admin_footer', array( $this, 'confirm_to_reset_settings' ) );

	}


	/**
	 * Load CSS for admin settings page.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function wp_enqueue_admin_css() {

		$current_screen = get_current_screen();

		if ( strpos( $current_screen->base, CRLPUIC_SLUG ) === false ) {
			return;
		} else {
			wp_enqueue_style( 'crlpuic-login-admin-styles', CRLPUIC_PLUGIN_DIR . '/assets/css/admin-style.min.css', array(), CRLPUIC_VER, 'all' );
		}
	}

	/**
	 * Register Settings.
	 */
	public function register_settings() {

		if ( ! is_customize_preview() ) {

			register_setting( $this->customizer_settings, $this->customizer_settings );
			add_option( $this->customizer_settings, $this->default_options );

			register_setting( $this->admin_options, $this->admin_options );
			add_option( $this->admin_options, $this->admin_default_options );

		}

		if ( ! crlpuic_is_admin_page( $this->page_id ) ) {
			return;
		}
		// Reset settings.
		if ( ! empty( crlpuic_get_option_value( 'crlpuic_reset', $this->admin_options ) ) ) {
			if ( crlpuic_get_option_value( 'crlpuic_reset', $this->admin_options ) === 'Reset Settings' ) {
				update_option( $this->customizer_settings, $this->default_options );
				$this->admin_default_options['crlpuic_reset'] = false;
				update_option( $this->admin_options, $this->admin_default_options );
				crlpuic_admin_redirect( $this->page_id, array( 'reset' => 'true' ) );
			}
		}
	}

	/**
	 * Set default settings.
	 */
	public function set_default_options() {

			$this->admin_default_options = crlpuic_get_plugin_setting_defaults();
			$this->default_options       = crlpuic_get_customizer_defaults();
	}

	/**
	 * Handles validation and sanitization of settings.
	 */
	public function sanitize() {

		crlpuic_settings_filter(
			'bool',
			$this->admin_options,
			array(
				'remove_settings_on_uninstall',
			)
		);

		crlpuic_settings_filter(
			'sanitize_text',
			$this->admin_options,
			array(
				'crlpuic_reset',
			)
		);

		crlpuic_settings_filter(
			'bool',
			$this->customizer_settings,
			array(
				'transparent_background',
				'form_wrapper',
				'field_icons',
				'rememberme_hide',
				'hide_links',
			)
		);

		crlpuic_settings_filter(
			'sanitize_text',
			$this->customizer_settings,
			array(
				'login_template',
				'readymade_template',
				'background',
				'content_title',
				'content_desc',
				'logo_settings',
				'logo_title',
				'login_page_title',
				'username_label',
				'password_label',
				'rememberme_label',
				'lost_password_text',
				'back_to_website',
				'login_btn_text',
				'register_username_label',
				'register_email_label',
				'registration_message',
				'register_btn_label',
				'register_link_label',
				'login_link_label',
				'lost_pwd_username_label',
				'lost_pwd_button_label',
				'custom_css',
			)
		);

		crlpuic_settings_filter(
			'color',
			$this->customizer_settings,
			array(
				'bg_overlay',
				'bg_color',
				'form_column_bg_color',
				'content_title_color',
				'content_desc_color',
				'logo_title_color',
				'form_background_color',
				'form_label_color',
				'login_btn_bg_color',
				'login_btn_bg_hover',
				'login_btn_txt_color',
				'form_column_bg_overlay',
				'content_column_bg_color',
			)
		);

		crlpuic_settings_filter(
			'opacity',
			$this->customizer_settings,
			array(
				'bg_opacity',
				'column_bg_opacity',
				'content_column_bg_opacity',
			)
		);

		crlpuic_settings_filter(
			'absint',
			$this->customizer_settings,
			array(
				'opacity_min',
				'opacity_max',
				'column_width',
				'logo_title_font_size',
				'custom_logo_height',
				'form_width',
				'form_min_width',
				'form_max_width',
				'form_label_font_size',
				'login_btn_font_size',
			)
		);

		crlpuic_settings_filter(
			'url',
			$this->customizer_settings,
			array(
				'bg_image',
				'content_img',
				'form_column_bg_img',
				'custom_logo',
				'bg_color',
			)
		);

	}

	/**
	 * Add menu link in WP settings.
	 */
	public function register_config_page() {

		add_options_page( __( 'Login Page UI', 'login-page-ui-customizer' ), __( 'Login Page UI', 'login-page-ui-customizer' ), 'manage_options', $this->page_id, array( $this, 'crlpuic_render_settings_form' ) );

	}

	/**
	 * Add settings html form.
	 */
	public function crlpuic_render_settings_form() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html_e( 'You do not have sufficient permissions to access this page.', 'login-page-ui-customizer' ) );
			return;
		}

		$uninstall_option_name  = crlpuic_get_option( 'remove_settings_on_uninstall', $this->admin_options );
		$uninstall_option_value = crlpuic_get_option_value( 'remove_settings_on_uninstall', $this->admin_options );

		$reset_option_name  = crlpuic_get_option( 'crlpuic_reset', $this->admin_options );
		$reset_option_value = crlpuic_get_option_value( 'crlpuic_reset', $this->admin_options );

		?>
		<div class="crlpuic-wrap">
			<h1 class="crlpuic-settings-title"><?php esc_html_e( 'Login Page UI Customizer &mdash; Settings', 'login-page-ui-customizer' ); ?> <a href="<?php echo esc_url( crlpuic_get_customizer_panel_link() ); ?>" class="button button-default" target="_blank" style="margin-left:20px;"> <?php esc_html_e( 'Customizer Settings →', 'login-page-ui-customizer' ); ?> </a></h1>
			<div class="crlpuic-settings-wrap crlpuic-flex crlpuic-flex-wrap">
				<div class="settings-col crlpuic-settings-left crlpuic-grid-2-3">
				<h3 class="crlpuic-heading crlpuic-card"><?php esc_html_e( 'Settings', 'login-page-ui-customizer' ); ?></h3>
				<div class="crlpuic-inside crlpuic-card rss-widget">
					<form  method="POST"  action="options.php" class="form-table crlpuic-setting-form" style="margin-top: 1em;"> 

							<?php settings_fields( $this->admin_options ); ?>
							<div class="settings-column-fields settings-panel--container">
								<table class="crlpuic-settings-table">
									<tbody>
										<tr>
											<th scope="row">
												<?php esc_html_e( 'Remove Settings on Uninstall', 'login-page-ui-customizer' ); ?>
											</th>
											<td> <fieldset>
												<legend class="screen-reader-text"><span><?php esc_html_e( 'Remove Settings on Uninstall', 'login-page-ui-customizer' ); ?></span></legend>
												<label for="<?php echo esc_html( $uninstall_option_name ); ?>">
													<input name="<?php echo esc_html( $uninstall_option_name ); ?>" type="checkbox" id="<?php echo esc_html( $uninstall_option_name ); ?>" value="1" <?php checked( $uninstall_option_value ); ?>>
													<?php esc_html_e( 'Delete settings', 'login-page-ui-customizer' ); ?>
												</label>
											</fieldset></td>
										</tr>
										<tr>
											<th scope="row">
												<?php esc_html_e( 'Reset Customizer Settings', 'login-page-ui-customizer' ); ?>
											</th>
											<td> <fieldset>
												<legend class="screen-reader-text"><span><?php esc_html_e( 'Reset to default settings', 'login-page-ui-customizer' ); ?></span></legend>
												<?php submit_button( __( 'Reset Settings', 'login-page-ui-customizer' ), 'delete', $reset_option_name, false ); ?>
											</fieldset><br><span id="customizer-reset-settings"></span></td>
										</tr>

									</tbody>
								</table>
							</div>
							<p class="submit">

								<?php submit_button( __( 'Save', 'login-page-ui-customizer' ), 'primary', 'submit', false ); ?>

							</p>
					</form>
				</div>
				</div>
				<div class="settings-col crlpuic-settings-right crlpuic-grid-1-3">
					<?php
					$args = array(
						'type'         => 'crlpuic-features-widget',
						'link'         => 'https://docs.cloudredux.com/feed/?post_type=cr-plugin-features&cr_plugins=login-page-ui-customizer',
						'url'          => 'https://docs.cloudredux.com/feed/?post_type=cr-plugin-features&cr_plugins=login-page-ui-customizer',
						'title'        => __( 'Upcoming Features', 'login-page-ui-customizer' ),
						'items'        => apply_filters( 'crlpuic_features_widget_items', 3 ),
						'show_summary' => 0,
						'show_author'  => 0,
						'show_date'    => 0,
					);

					?>
					<div class="crlpuic-upcoming-features">
						<h3 class="crlpuic-heading crlpuic-card"><?php esc_html_e( 'Learn About Plugin', 'login-page-ui-customizer' ); ?></h3>
						<div class="crlpuic-inside crlpuic-card rss-widget">
							<div class="crlpuic-settings-wrap crlpuic-flex crlpuic-flex-wrap">
								<div class="settings-col crlpuic-settings-left crlpuic-grid-1-5">
									<img src="<?php echo esc_url( CRLPUIC_PLUGIN_DIR . '/assets/images/login-page-ui-customizer-icon.png' ); ?>" width="52px" height="52px" alt="Login Page UI Customizer Icon">
								</div>
								<div class="settings-col crlpuic-settings-right crlpuic-grid-4-5 crlpuic-margin-zero">
									<h3 class="crlpuic-about-heading"> <?php esc_html_e( 'Login Page UI Customizer', 'login-page-ui-customizer' ); ?></h3>
									<p class="crlpuic-about-desc"><?php esc_html_e( 'A personalized Doorway to your Website!', 'login-page-ui-customizer' ); ?></p>
								</div>
							</div>
							<p><?php esc_html_e( 'Customize your Login Page (Login, Register, and Password forms). Take control of your website and how it looks, right from the login page! A Login Page customizer that is intuitive and flexible yet simple!', 'login-page-ui-customizer' ); ?></p>
							<p><?php esc_html_e( 'Get started right away! Here’s how you can design the login page you want.', 'login-page-ui-customizer' ); ?></p>
							<a href="<?php echo esc_url( 'https://docs.cloudredux.com/contributions/wordpress/login-page-ui-customizer/documentation/?spf-plugin-name=Login%20Page%20UI%20Customizer&utm_source=plugin-setting&utm_medium=plugin-referral&utm_campaign=documentation' ); ?>" class="button secondary"><?php esc_html_e( 'Plugin Documentation &rarr;', 'login-page-ui-customizer' ); ?></a>
						</div>
					</div>
					<div class="crlpuic-feature">
						<h3 class="crlpuic-heading crlpuic-card"><?php esc_html_e( 'Suggest a feature', 'login-page-ui-customizer' ); ?></h3>
						<div class="crlpuic-inside crlpuic-card">
							<p><?php esc_html_e( 'Got a suggestion or an idea for a new feature? We\'re all ears! Submit your thoughts here.', 'login-page-ui-customizer' ); ?></p>
							<a href="<?php echo esc_url( 'https://docs.cloudredux.com/wordpress-plugin-features-suggest-a-feature/?spf-plugin-name=Login%20Page%20UI%20Customizer&utm_source=plugin-setting&utm_medium=plugin-referral&utm_campaign=suggest-feature' ); ?>" class="button secondary"><?php esc_html_e( 'Suggest a feature &rarr;', 'login-page-ui-customizer' ); ?></a>
						</div>
					</div>
					<div class="crlpuic-review">
						<h3 class="crlpuic-heading crlpuic-card"><span class="dashicons dashicons-star-half"></span> <?php esc_html_e( 'We\'d love to hear your feedback', 'login-page-ui-customizer' ); ?></h3>
						<div class="crlpuic-inside crlpuic-card">
							<p><?php esc_html_e( 'If the plugin has helped enriching the experience on your website login page, help spread the word.', 'login-page-ui-customizer' ); ?></p>
							<p>
								<?php
								$crlpuic_customizere_link = crlpuic_get_customizer_panel_link();
								/* translators: %1$s is replaced with the anchor tag to the plugin page on CloudRedux.com, %2$s closes the anchor tag, %3$s is replaced with the URL to the plugin's review page on WordPress.org */
								printf( esc_html__( '%3$sLeave us a review and rate our plugin%2$s on WordPress.org so that several other businesses like yours are able to utilize what %1$s%4$s%5$sLogin Page UI Customizer for login page%2$s has to offer.', 'login-page-ui-customizer' ), '<a href="', '</a>', '<a href="https://wordpress.org/support/plugin/login-page-ui-customizer/reviews/" target="_blank">', esc_url_raw( $crlpuic_customizere_link ), '" target="_blank">' );
								?>
							</p>
							<p><a class="crlpuic-button crlpuic-button-green" href="<?php echo esc_url( 'https://wordpress.org/support/plugin/login-page-ui-customizer/reviews/' ); ?>"><?php esc_html_e( 'Leave a Review', 'login-page-ui-customizer' ); ?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/** This is the confirmation message that will appear. **/
	public function confirm_to_reset_settings() {
		?>
		<script type="text/javascript">

		var reset_settings = document.getElementById("admin-crlpuic-settings[crlpuic_reset]");

		if ( reset_settings !== null) {
			reset_settings.onclick = function(){

				var cr_do_reset = confirm("Are you sure to reset customizer settings?");

				if( cr_do_reset == true ) {
					document.getElementById("customizer-reset-settings").style.color = "green";
					document.getElementById("customizer-reset-settings").textContent="Restored default customizer settings.";
				}

				return cr_do_reset;
			};
		}
		</script>
		<?php
	}

}
