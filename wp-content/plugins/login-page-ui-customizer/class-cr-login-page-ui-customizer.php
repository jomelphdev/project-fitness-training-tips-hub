<?php
/**
 * This is main class of plugin.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author  Suresh Shinde <suresh.shinde@cloudredux.com>
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'CR_Login_Page_UI_Customizer' ) ) :

	/**
	 * Class CR_Login_Page_UI_Customizer does init, include and defines constants.
	 *
	 * @since 1.0.0
	 */
	final class CR_Login_Page_UI_Customizer {

		/**
		 * Admin page init by this var.
		 *
		 * @var object type
		 */
		private $admin_page;

		/**
		 * For init.
		 *
		 * @var Single instance of the class
		 */
		protected static $single_instance = null;

		/**
		 * To create class object.
		 *
		 * @return object  $single_instance object of the class
		 */
		public static function instance() {

			if ( is_null( self::$single_instance ) ) {
				self::$single_instance = new self();
			}
			return self::$single_instance;

		}

		/**
		 * To instantiate class.
		 */
		public function __construct() {

			$this->define_constants();

			$this->includes();

			$this->init_hooks();

			add_action( 'plugins_loaded', array( $this, 'crlpuic_load_plugin_textdomain' ) );

		}

		/**
		 * Define required constants.
		 */
		public function define_constants() {

			define( 'CRLPUIC_SLUG', 'crlpuic-settings' );
			define( 'CRLPUIC_ADMIN_OPTION', 'admin-crlpuic-settings' );
			define( 'CRLPUIC_VER', '1.0.1' );
			define( 'CRLPUIC_PLUGIN_DIR', $this->plugin_url() );
			define( 'CRLPUIC_PLUGIN_DIR_PATH', $this->plugin_path() );
			define( 'CRLPUIC_TPL_DIR_PATH', $this->template_path() );

		}

		/**
		 * Include required files.
		 */
		private function includes() {

			// Required Functions.
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/functions/core.php';
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/functions/settings.php';

			// Required Classes.
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/class-crlpuic-customizer.php';
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/customizer/class-crlpuic-customizer-preview.php';
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/admin/class-crlpuic-admin.php';
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/class-crlpuic-settings-sanitization.php';
			include CRLPUIC_PLUGIN_DIR_PATH . '/includes/class-crlpuic-sanitization-callbacks.php';

		}

		/**
		 * Init admin page & customizer class.
		 */
		private function init_hooks() {

			if ( is_admin() ) {
				$this->admin_page = new CRLPUIC_Admin();
			}

			$crlpuic_customizer = new CRLPUIC_Customizer();

		}



		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {

			return untrailingslashit( plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {

			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function template_path() {

			$template_path = wp_normalize_path( untrailingslashit( plugin_dir_path( __FILE__ ) . '/includes' ) );

			return $template_path;
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'login-page-ui-customizer' ), CRLPUIC_VER ); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'login-page-ui-customizer' ), CRLPUIC_VER ); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		/**
		 * Load plugin textdomain.
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function crlpuic_load_plugin_textdomain() {

			$domain = 'login-page-ui-customizer';

			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, CRLPUIC_PLUGIN_DIR . '/languages/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		}

	}

endif;
