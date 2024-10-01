<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */


if ( ! defined( 'FITLINE_THEME_DIR' ) ) {
	define( 'FITLINE_THEME_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'FITLINE_THEME_URL' ) ) {
	define( 'FITLINE_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}
if ( ! defined( 'FITLINE_CHILD_DIR' ) ) {
	define( 'FITLINE_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'FITLINE_CHILD_URL' ) ) {
	define( 'FITLINE_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

if ( ! function_exists( 'fitline_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'fitline_theme_setup1', 1 );
	/**
	 * Load a text domain before all other actions.
	 *
	 * Theme-specific init actions order:
	 *
	 * Action 'after_setup_theme':
	 *
	 * 1 - register filters to add/remove items to the lists used in the Theme Options
	 *
	 * 2 - create the Theme Options
	 *
	 * 3 - add/remove elements to the Theme Options
	 *
	 * 5 - load the Theme Options. Attention! After this step you can use only basic options (not overriden options)
	 *
	 * 9 - register other filters (for installer, etc.)
	 *
	 * 10 - all other (standard) Theme init procedures (not ordered)
	 *
	 * Action 'wp_loaded'
	 *
	 * 1 - detect an override mode. Attention! Only after this step you can use overriden options
	 *     (separate values for the Blog, Shop, Team, Courses, etc.)
	 */
	function fitline_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'fitline', fitline_get_folder_dir( 'languages' ) );
	}
}

if ( ! function_exists( 'fitline_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'fitline_theme_setup9', 9 );
	/**
	 * A general theme setup: add a theme supports, navigation menus, hooks for other actions and filters.
	 */
	function fitline_theme_setup9() {

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'fitline_filter_content_width', fitline_get_theme_option( 'page_width' ) );

		// Theme support '-full' versions of styles and scripts (used in the editors)
		add_theme_support( 'styles-and-scripts-full-merged' );
		
		// Allow external updtates
		if ( FITLINE_THEME_ALLOW_UPDATE ) {
			add_theme_support( 'theme-updates-allowed' );
		}

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Custom header setup
		add_theme_support( 'custom-header',
			array(
				'header-text' => false,
				'video'       => true,
			)
		);

		// Custom logo
		add_theme_support( 'custom-logo',
			array(
				'width'       => 250,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array() );

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Supported posts formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat' ) );

		// Autogenerate title tag
		add_theme_support( 'title-tag' );

		// Add theme menus
		add_theme_support( 'nav-menus' );

		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Register navigation menu
		register_nav_menus(
			array(
				'menu_main'   => esc_html__( 'Main Menu', 'fitline' ),
				'menu_mobile' => esc_html__( 'Mobile Menu', 'fitline' ),
				'menu_footer' => esc_html__( 'Footer Menu', 'fitline' ),
			)
		);

		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 370, 0, false );
		$thumb_sizes = fitline_storage_get( 'theme_thumbs' );
		$mult        = fitline_get_theme_option( 'retina_ready', 1 );
		if ( $mult > 1 ) {
			$GLOBALS['content_width'] = apply_filters( 'fitline_filter_content_width', 1170 * $mult );
		}
		foreach ( $thumb_sizes as $k => $v ) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2] );
			if ( $mult > 1 ) {
				add_image_size( $k . '-@retina', $v['size'][0] * $mult, $v['size'][1] * $mult, $v['size'][2] );
			}
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose', 'fitline_theme_thumbs_sizes' );

		// Excerpt filters
		add_filter( 'excerpt_length', 'fitline_excerpt_length' );
		add_filter( 'excerpt_more', 'fitline_excerpt_more' );

		// Comment form
		add_filter( 'comment_form_fields', 'fitline_comment_form_fields' );
		add_filter( 'comment_form_fields', 'fitline_comment_form_agree', 11 );

		// Add required meta tags in the head
		add_action( 'wp_head', 'fitline_wp_head', 0 );

		// Load current page/post customization (if present)
		add_action( 'wp_footer', 'fitline_wp_footer' );
		add_action( 'admin_footer', 'fitline_wp_footer' );

		// Enqueue scripts and styles for the frontend
		add_action( 'wp_enqueue_scripts', 'fitline_load_theme_fonts', 0 );
		add_action( 'wp_enqueue_scripts', 'fitline_load_theme_icons', 0 );
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles', 1000 );                  // priority 1000 - load main theme styles
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_single', 1020);            // priority 1020 - load styles of single posts
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_plugins', 1100 );          // priority 1100 - load styles of the supported plugins
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_custom', 1200 );           // priority 1200 - load styles with custom fonts and colors
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_child', 1500 );            // priority 1500 - load styles of the child theme
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_responsive', 2000 );       // priority 2000 - load responsive styles after all other styles
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_single_responsive', 2020); // priority 2020 - load responsive styles of single posts after all other styles
		add_action( 'wp_enqueue_scripts', 'fitline_wp_styles_responsive_child', 2500);  // priority 2500 - load responsive styles of the child theme after all other responsive styles

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', 'fitline_wp_scripts', 1000 );                 // priority 1000 - load main theme scripts
		add_action( 'wp_footer', 'fitline_localize_scripts' );

		// Add body classes
		add_filter( 'body_class', 'fitline_add_body_classes' );

		// Register sidebars
		add_action( 'widgets_init', 'fitline_register_sidebars' );
	}
}


//-------------------------------------------------------
//-- Theme styles
//-------------------------------------------------------

if ( ! function_exists( 'fitline_theme_fonts' ) ) {
	/**
	 * Load a theme-specific fonts at priority 0, because the font styles must be loaded before a main stylesheet.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_load_theme_fonts', 0);
	 */
	function fitline_load_theme_fonts() {
		$links = fitline_theme_fonts_links();
		if ( count( $links ) > 0 ) {
			foreach ( $links as $slug => $link ) {
				wp_enqueue_style( sprintf( 'fitline-font-%s', $slug ), $link, array(), null );
			}
		}
	}
}

if ( ! function_exists( 'fitline_load_theme_icons' ) ) {
	/**
	 * Load a theme-specific font icons at priority 0, because the icon styles must be loaded before a main stylesheet.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_load_theme_icons', 0);
	 */
	function fitline_load_theme_icons() {
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'fitline-fontello', fitline_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
	}
}

if ( ! function_exists( 'fitline_wp_styles' ) ) {
	/**
	 * Load a main theme styles for the frontend.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles', 1000);
	 */
	function fitline_wp_styles() {

		// Load main stylesheet
		$main_stylesheet = FITLINE_THEME_URL . 'style.css';
		wp_enqueue_style( 'fitline-style', $main_stylesheet, array(), null );

		// Add custom bg image
		$bg_image = fitline_remove_protocol_from_url( fitline_get_theme_option( 'front_page_bg_image' ), false );
		if ( is_front_page() && ! empty( $bg_image ) && fitline_is_on( fitline_get_theme_option( 'front_page_enabled', false ) ) ) {
			// Add custom bg image for the Front page
			fitline_add_inline_css( 'body.frontpage, body.home-page, body.home { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
		} else {
			// Add custom bg image for the body_style == 'boxed'
			$bg_image = fitline_get_theme_option( 'boxed_bg_image' );
			if ( ! empty( $bg_image ) && ( fitline_get_theme_option( 'body_style' ) == 'boxed' || is_customize_preview() ) ) {
				fitline_add_inline_css( '.body_style_boxed { background-image:url(' . esc_url( fitline_clear_thumb_size( $bg_image ) ) . ') !important }' );
			}
		}

		// Add post nav background
		fitline_add_bg_in_post_nav();
	}
}

if ( ! function_exists( 'fitline_wp_styles_single' ) ) {
	/**
	 * Load styles for single posts.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_single', 1020);
	 */
	function fitline_wp_styles_single() {
		if ( apply_filters( 'fitline_filters_separate_single_styles', false )
			&& apply_filters( 'fitline_filters_load_single_styles', fitline_is_single() || fitline_is_singular( 'attachment' ) || (int) fitline_get_theme_option( 'open_full_post_in_blog' ) > 0 )
		) {
			if ( fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) ) {
				$file = fitline_get_file_url( 'css/__single.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'fitline-single', $file, array(), null );
				}
			} else {
				$file = fitline_get_file_url( 'css/single.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'fitline-single', $file, array(), null );
				}
			}
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_plugins' ) ) {
	/**
	 * Load styles for all supported plugins.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_plugins', 1100);
	 */
	function fitline_wp_styles_plugins() {
		if ( fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'fitline-plugins', fitline_get_file_url( 'css/__plugins' . ( fitline_is_preview() || ! fitline_optimize_css_and_js_loading() ? '-full' : '' ) . '.css' ), array(), null );
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_custom' ) ) {
	/**
	 * Load styles with CSS variables to set up a theme-specific custom fonts and colors.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_custom', 1200);
	 */
	function fitline_wp_styles_custom() {
		if ( ! is_customize_preview() && fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) && ! fitline_is_blog_mode_custom() ) {
			wp_enqueue_style( 'fitline-custom', fitline_get_file_url( 'css/__custom.css' ), array(), null );
		} else {
			wp_enqueue_style( 'fitline-custom', fitline_get_file_url( 'css/__custom-inline.css' ), array(), null );
			wp_add_inline_style( 'fitline-custom', fitline_customizer_get_css() );
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_responsive' ) ) {
	/**
	 * Load a theme responsive styles (a priority 2000 is used to load it after the main styles and plugins custom styles)
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_responsive', 2000);
	 */
	function fitline_wp_styles_responsive() {
		if ( fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'fitline-responsive', fitline_get_file_url( 'css/__responsive' . ( fitline_is_preview() || ! fitline_optimize_css_and_js_loading() ? '-full' : '' ) . '.css' ), array(), null, fitline_media_for_load_css_responsive( 'main' ) );
		} else {
			wp_enqueue_style( 'fitline-responsive', fitline_get_file_url( 'css/responsive.css' ), array(), null, fitline_media_for_load_css_responsive( 'main' ) );
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_single_responsive' ) ) {
	/**
	 * Load a theme responsive styles for single posts (a priority 2020 is used to load it after the main and plugins responsive styles).
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_single_responsive', 2020);
	 */
	function fitline_wp_styles_single_responsive() {
		if ( apply_filters( 'fitline_filters_separate_single_styles', false )
			&& apply_filters( 'fitline_filters_load_single_styles', fitline_is_single() || fitline_is_singular( 'attachment' ) || (int) fitline_get_theme_option( 'open_full_post_in_blog' ) > 0 )
		) {
			if ( fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) ) {
				$file = fitline_get_file_url( 'css/__single-responsive.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'fitline-single-responsive', $file, array(), null, fitline_media_for_load_css_responsive( 'single' ) );
				}
			} else {
				$file = fitline_get_file_url( 'css/single-responsive.css' );
				if ( ! empty( $file ) ) {
					wp_enqueue_style( 'fitline-single-responsive', $file, array(), null, fitline_media_for_load_css_responsive( 'single' ) );
				}
			}
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_child' ) ) {
	/**
	 * Load a child-theme stylesheet after all theme styles (if child-theme folder is not equal to the theme folder).
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_child', 1500);
	 */
	function fitline_wp_styles_child() {
		if ( FITLINE_THEME_URL != FITLINE_CHILD_URL ) {
			wp_enqueue_style( 'fitline-child', FITLINE_CHILD_URL . 'style.css', array( 'fitline-style' ), null );
		}
	}
}

if ( ! function_exists( 'fitline_wp_styles_responsive_child' ) ) {
	/**
	 * Load a child-theme responsive styles (a priority 2500 is used to load it after other responsive styles
	 * and after the child-theme stylesheet)
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_styles_responsive_child', 2500);
	 */
	function fitline_wp_styles_responsive_child() {
		if ( FITLINE_THEME_URL != FITLINE_CHILD_URL && file_exists( FITLINE_CHILD_DIR . 'responsive.css' ) ) {
			wp_enqueue_style( 'fitline-responsive-child', FITLINE_CHILD_URL . 'responsive.css', array( 'fitline-responsive' ), null, fitline_media_for_load_css_responsive( 'main' ) );
		}
	}
}

if ( ! function_exists( 'fitline_media_for_load_css_responsive' ) ) {
	/**
	 * Return a 'media' descriptor for the tag 'link' to load responsive CSS only on devices where they are really needed.
	 *
	 * @param string $slug   Optional. A slug of responsive CSS. Default is 'main'.
	 * @param string $media  Optional. A default media descriptor. Default is 'all'.
	 *
	 * @return string        A media descriptor corresponding to the specified slug.
	 */
	function fitline_media_for_load_css_responsive( $slug = 'main', $media = 'all' ) {
		global $FITLINE_STORAGE;
		$condition = 'all';
		$media = apply_filters( 'fitline_filter_media_for_load_css_responsive', $media, $slug );
		if ( ! empty( $FITLINE_STORAGE['responsive'][ $media ]['max'] ) ) {
			$condition = sprintf( '(max-width:%dpx)', $FITLINE_STORAGE['responsive'][ $media ]['max'] );
		} 
		return apply_filters( 'fitline_filter_condition_for_load_css_responsive', $condition, $slug );
	}
}

if ( ! function_exists( 'fitline_media_for_load_css_responsive_callback' ) ) {
	add_filter( 'fitline_filter_media_for_load_css_responsive', 'fitline_media_for_load_css_responsive_callback', 10, 2 );
	/**
	 * Return a maximum 'media' slug to use as a default value for all responsive css-files
	 * (if corresponding media is not detected by a specified slug).
	 *
	 * Hooks: add_filter( 'fitline_filter_media_for_load_css_responsive', 'fitline_media_for_load_css_responsive_callback', 10, 2 );
	 *
	 * @param string $media  A current media descriptor.
	 * @param string $slug   A current slug to detect a media descriptor. Not used in this function.
	 *
	 * @return string        A default media descriptor, if media stay equal to 'all' after all previous hooks.
	 */
	function fitline_media_for_load_css_responsive_callback( $media, $slug ) {
		return 'all' == $media ? 'xxl' : $media;
	}
}


//-------------------------------------------------------
//-- Theme scripts
//-------------------------------------------------------

if ( ! function_exists( 'fitline_wp_scripts' ) ) {
	/**
	 * Load a theme-specific scripts for the frontend.
	 *
	 * Hooks: add_action('wp_enqueue_scripts', 'fitline_wp_scripts', 1000);
	 */
	function fitline_wp_scripts() {
		$blog_archive = fitline_storage_get( 'blog_archive' ) === true || is_home();
		$blog_style   = fitline_get_theme_option( 'blog_style' );
		$use_masonry  = false;
		if ( strpos( $blog_style, 'blog-custom-' ) === 0 ) {
			$blog_id   = fitline_get_custom_blog_id( $blog_style );
			$blog_meta = fitline_get_custom_layout_meta( $blog_id );
			if ( ! empty( $blog_meta['scripts_required'] ) && ! fitline_is_off( $blog_meta['scripts_required'] ) ) {
				$blog_style  = $blog_meta['scripts_required'];
				$use_masonry = strpos( $blog_meta['scripts_required'], 'masonry' ) !== false;
			}
		} else {
			$blog_parts  = explode( '_', $blog_style );
			$blog_style  = $blog_parts[0];
			$use_masonry = fitline_is_blog_style_use_masonry( $blog_style );
		}

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', fitline_get_file_url( 'js/superfish/superfish.min.js' ), array( 'jquery' ), null, true );

		// Background video
		$header_video = fitline_get_header_video();
		if ( ! empty( $header_video ) && ! fitline_is_inherit( $header_video ) ) {
			if ( fitline_is_youtube_url( $header_video ) ) {
				wp_enqueue_script( 'jquery-tubular', fitline_get_file_url( 'js/tubular/jquery.tubular.js' ), array( 'jquery' ), null, true );
			} else {
				wp_enqueue_script( 'bideo', fitline_get_file_url( 'js/bideo/bideo.js' ), array(), null, true );
			}
		}

		// Merged scripts
		if ( fitline_is_off( fitline_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_script( 'fitline-init', fitline_get_file_url( 'js/__scripts' . ( fitline_is_preview() || ! fitline_optimize_css_and_js_loading() ? '-full' : '' ) . '.js' ), apply_filters( 'fitline_filter_script_deps', array( 'jquery' ) ), null, true );
		} else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', fitline_get_file_url( 'js/skip-link-focus-fix/skip-link-focus-fix.js' ), null, true );
			// Theme scripts
			wp_enqueue_script( 'fitline-utils', fitline_get_file_url( 'js/utils.js' ), array( 'jquery' ), null, true );
			wp_enqueue_script( 'fitline-init', fitline_get_file_url( 'js/init.js' ), array( 'jquery' ), null, true );
		}

		// Load scripts for smooth parallax animation on the single post or on the post archive (if the option 'open_full_post_in_blog' is on)
		if ( fitline_get_theme_option( 'single_parallax' ) != 0
			&& ( fitline_is_singular( 'post' )
				|| ( (int) fitline_get_theme_option( 'open_full_post_in_blog' ) > 0 && ( is_home() || is_archive() || is_category() ) )
				)
		) {
			fitline_load_parallax_scripts();
		}

		// Load masonry scripts
		if ( ( $blog_archive && $use_masonry ) || ( fitline_is_singular( 'post' ) && str_replace( 'post-format-', '', get_post_format() ) == 'gallery' ) ) {
			fitline_load_masonry_scripts();
		}

		// Load tabs to show filters
		if ( $blog_archive && ! is_customize_preview() && ! fitline_is_off( fitline_get_theme_option( 'show_filters' ) ) ) {
			wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
		}

		// Comments
		if ( fitline_is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library
		if ( fitline_get_theme_setting( 'use_mediaelements' ) ) {
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}

if ( ! function_exists( 'fitline_localize_scripts' ) ) {
	/**
	 * Localize a theme-specific scripts: add variables to use in JS in the frontend.
	 *
	 * Trigger a filter 'fitline_filter_localize_script' to allow other modules add their variables to the localization array.
	 *
	 * Hooks: add_action( 'wp_footer', 'fitline_localize_scripts' );
	 */
	function fitline_localize_scripts() {

		$video = fitline_get_header_video();

		wp_localize_script( 'fitline-init', 'FITLINE_STORAGE', apply_filters( 'fitline_filter_localize_script', array(
			// AJAX parameters
			'ajax_url'            => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajax_nonce'          => esc_attr( wp_create_nonce( admin_url( 'admin-ajax.php' ) ) ),

			// Site base url
			'site_url'            => esc_url( get_home_url() ),
			'theme_url'           => FITLINE_THEME_URL,

			// Site color scheme
			'site_scheme'         => sprintf( 'scheme_%s', fitline_get_theme_option( 'color_scheme' ) ),

			// User logged in
			'user_logged_in'      => is_user_logged_in() ? true : false,

			// Window width to switch the site header to the mobile layout
			'mobile_layout_width' => 768,
			'mobile_device'       => wp_is_mobile(),

			// Mobile breakpoints for JS (if window width less then)
			'mobile_breakpoint_underpanels_off' => 768,
			'mobile_breakpoint_fullheight_off' => 1025,

			// Sidemenu options
			'menu_side_stretch'   => (int) fitline_get_theme_option( 'menu_side_stretch' ) > 0,
			'menu_side_icons'     => (int) fitline_get_theme_option( 'menu_side_icons' ) > 0,

			// Video background
			'background_video'    => fitline_is_from_uploads( $video ) ? $video : '',

			// Video and Audio tag wrapper
			'use_mediaelements'   => fitline_get_theme_setting( 'use_mediaelements' ) ? true : false,

			// Resize video and iframe
			'resize_tag_video'    => false,
			'resize_tag_iframe'   => true,

			// Allow open full post in the blog
			'open_full_post'      => (int) fitline_get_theme_option( 'open_full_post_in_blog' ) > 0,

			// Which block to load in the single posts
			'which_block_load'    => fitline_get_theme_option( 'posts_navigation_scroll_which_block' ),

			// Current mode
			'admin_mode'          => false,

			// Strings for translation
			'msg_ajax_error'      => esc_html__( 'Invalid server answer!', 'fitline' ),
			'msg_i_agree_error'   => esc_html__( 'Please accept the terms of our Privacy Policy.', 'fitline' ),
		) ) );
	}
}

if ( ! function_exists( 'fitline_load_masonry_scripts' ) ) {
	/**
	 * Enqueue a masonry scripts (if need for the current page).
	 */
	function fitline_load_masonry_scripts() {
		static $once = true;
		if ( $once ) {
			$once = false;
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
		}
	}
}

if ( ! function_exists( 'fitline_load_parallax_scripts' ) ) {
	/**
	 * Enqueue a parallax scripts (if need for the current page).
	 */
	function fitline_load_parallax_scripts() {
		if ( function_exists( 'trx_addons_enqueue_parallax' ) ) {
			trx_addons_enqueue_parallax();
		}
	}
}

if ( ! function_exists( 'fitline_load_specific_scripts' ) ) {
	add_filter( 'fitline_filter_enqueue_blog_scripts', 'fitline_load_specific_scripts', 10, 5 );
	/**
	 * Enqueue a blog-specific styles and scripts.
	 *
	 * Hooks: add_filter( 'fitline_filter_enqueue_blog_scripts', 'fitline_load_specific_scripts', 10, 5 );
	 *
	 * @param bool $load           A filterable flag indicating whether scripts should be loaded by default (true)
	 *                             or they are already loaded by one of the handlers (false).
	 * @param string $blog_style   A slug of the blog style.
	 * @param string $script_slug  A slug of the script to load.
	 * @param array|bool $list     A list with scripts to merge or false if called from enqueue_scripts.
	 * @param bool $responsive     If true - need to load responsive styles, else - a main styles and scripts.
	 *
	 * @return bool                A filtered flag indicating whether scripts should be loaded by default (true)
	 *                             or they are already loaded by one of the handlers (false).
	 */
	function fitline_load_specific_scripts( $load, $blog_style, $script_slug, $list, $responsive ) {
		if ( 'masonry' == $script_slug && false === $list ) { // if list === false - called from enqueue_scripts, else - called from merge_script
			fitline_load_masonry_scripts();
			$load = false;
		}
		return $load;
	}
}


//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------

if ( ! function_exists( 'fitline_wp_head' ) ) {
	/**
	 * Add meta tags to the header for the frontend.
	 *
	 * Hooks: add_action( 'wp_head',	'fitline_wp_head', 1 );
	 */
	function fitline_wp_head() {
		if ( ! fitline_gutenberg_is_fse_theme() ) {
			?>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<?php
		}
		// Add ', maximum-scale=1' to the content of the meta name 'viewport' to disallow the page scaling.
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<?php
		if ( fitline_is_singular() && pings_open() ) {
			?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
			<?php
		}
	}
}

if ( ! function_exists( 'fitline_add_body_classes' ) ) {
	/**
	 * Add a theme-specific classes to the tag 'body'.
	 *
	 * Hooks: add_filter( 'body_class', 'fitline_add_body_classes' );
	 *
	 * @param array $classes  An array with classes for the tag 'body'.
	 *
	 * @return array          A filtered array with a theme-specific classes for the tag 'body'.
	 */
	function fitline_add_body_classes( $classes ) {

		$classes[] = 'scheme_' . esc_attr( fitline_get_theme_option( 'color_scheme' ) );

		if ( is_customize_preview() ) {
			$classes[] = 'customize_preview';
		}

		$blog_mode = fitline_storage_get( 'blog_mode' );
		$classes[] = 'blog_mode_' . esc_attr( $blog_mode );
		$classes[] = 'body_style_' . esc_attr( fitline_get_theme_option( 'body_style' ) );

		if ( in_array( $blog_mode, array( 'post', 'page' ) ) || apply_filters( 'fitline_filter_single_post_header', fitline_is_singular( 'post' ) ) ) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_' . esc_attr( fitline_get_theme_option( 'blog_style' ) );
			if ( fitline_storage_get( 'blog_template' ) > 0 ) {
				$classes[] = 'blog_template';
			}
		}

		if ( apply_filters( 'fitline_filter_single_post_header', fitline_is_singular( 'post' ) || fitline_is_singular( 'attachment' ) ) ) {
			$classes[] = 'single_style_' . esc_attr( fitline_get_theme_option( 'single_style' ) );
		}

		if ( fitline_sidebar_present() ) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr( fitline_get_theme_option( 'sidebar_position' ) );
			$classes[] = 'sidebar_small_screen_' . esc_attr( fitline_get_theme_option( 'sidebar_position_ss' ) );
		} else {
			$expand = fitline_get_theme_option( 'expand_content' );
			// Compatibility with old versions
			if ( "={$expand}" == '=0' ) {
				$expand = 'normal';
			} else if ( "={$expand}" == '=1' ) {
				$expand = 'expand';
			}
			if ( 'narrow' == $expand && ! fitline_is_singular( apply_filters('fitline_filter_is_singular_type', array('post') ) ) ) {
				$expand = 'normal';
			}
			$classes[] = 'sidebar_hide';
			$classes[] = "{$expand}_content";
		}

		if ( fitline_is_on( fitline_get_theme_option( 'remove_margins' ) ) ) {
			$classes[] = 'remove_margins';
		}

		$bg_image = fitline_get_theme_option( 'front_page_bg_image' );
		if ( is_front_page() && ! empty( $bg_image ) && fitline_is_on( fitline_get_theme_option( 'front_page_enabled', false ) ) ) {
			$classes[] = 'with_bg_image';
		}

		$classes[] = 'trx_addons_' . esc_attr( fitline_exists_trx_addons() ? 'present' : 'absent' );

		$classes[] = 'header_type_' . esc_attr( fitline_get_theme_option( 'header_type' ) );
		$classes[] = 'header_style_' . esc_attr( 'default' == fitline_get_theme_option( 'header_type' ) ? 'header-default' : fitline_get_theme_option( 'header_style' ) );
		$header_position = fitline_get_theme_option( 'header_position' );
		if ( 'over' == $header_position && fitline_is_single() && ! has_post_thumbnail() ) {
			$header_position = 'default';
		}
		$classes[] = 'header_position_' . esc_attr( $header_position );

		$menu_side = fitline_get_theme_option( 'menu_side' );
		$classes[] = 'menu_side_' . esc_attr( $menu_side ) . ( in_array( $menu_side, array( 'left', 'right' ) ) ? ' menu_side_present' : '' );
		$classes[] = 'no_layout';

		if ( fitline_get_theme_setting( 'fixed_blocks_sticky' ) ) {
			$classes[] = 'fixed_blocks_sticky';
		}

		if ( fitline_get_theme_option( 'blog_content' ) == 'fullpost' ) {
			$classes[] = 'fullpost_exist';
		}

		return $classes;
	}
}

if ( ! function_exists( 'fitline_wp_footer' ) ) {
	/**
	 * Load a customization styles with css rules added while a current page built.
	 *
	 * Hooks: add_action('wp_footer', 'fitline_wp_footer');
	 * add_action('admin_footer', 'fitline_wp_footer');
	 */
	function fitline_wp_footer() {
		// Add header zoom
		$header_zoom = max( 0.2, min( 2, (float) fitline_get_theme_option( 'header_zoom' ) ) );
		if ( 1 != $header_zoom ) {
			fitline_add_inline_css( ".sc_layouts_title_title{font-size:{$header_zoom}em}" );
		}
		// Add logo zoom
		$logo_zoom = max( 0.2, min( 2, (float) fitline_get_theme_option( 'logo_zoom' ) ) );
		if ( 1 != $logo_zoom ) {
			fitline_add_inline_css( ".custom-logo-link,.sc_layouts_logo{font-size:{$logo_zoom}em}" );
		}
		// Put inline styles to the output
		$css = fitline_get_inline_css();
		if ( ! empty( $css ) ) {
			// Attention! Don't change id in the tag 'style' - need to properly work the 'view more' script
			fitline_show_layout( apply_filters( 'fitline_filter_inline_css', $css ), '<style type="text/css" id="fitline-inline-styles-inline-css">', '</style>' );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

if ( ! function_exists( 'fitline_register_sidebars' ) ) {
	/**
	 * Register a theme-specific widgetized areas.
	 *
	 * Hooks: add_action('widgets_init', 'fitline_register_sidebars');
	 */
	function fitline_register_sidebars() {
		$sidebars = fitline_get_sidebars();
		if ( is_array( $sidebars ) && count( $sidebars ) > 0 ) {
			$cnt = 0;
			foreach ( $sidebars as $id => $sb ) {
				$cnt++;
				register_sidebar(
					apply_filters( 'fitline_filter_register_sidebar',
						array(
							'name'          => $sb['name'],
							'description'   => $sb['description'],
							// Translators: Add the sidebar number to the id
							'id'            => ! empty( $id ) ? $id : sprintf( 'theme_sidebar_%d', $cnt),
							'before_widget' => '<aside class="widget %2$s">',	// %1$s - id, %2$s - class
							'after_widget'  => '</aside>',
							'before_title'  => '<h5 class="widget_title">',
							'after_title'   => '</h5>',
						)
					)
				);
			}
		}
	}
}

if ( ! function_exists( 'fitline_get_sidebars' ) ) {
	/**
	 * Return a list with all theme-specific widgetized areas.
	 *
	 * @return array  A list of the widgetized areas in format:
	 *                [
	 *                  ['name' => 'Sidebar1 Name', 'description' => 'Sidebar1 Description'],
	 *                  ['name' => 'Sidebar2 Name', 'description' => 'Sidebar2 Description'],
	 *                  ...
	 *                ]
	 */
	function fitline_get_sidebars() {
		$list = apply_filters(
			'fitline_filter_list_sidebars', array(
				'sidebar_widgets'       => array(
					'name'        => esc_html__( 'Sidebar Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown on the main sidebar', 'fitline' ),
				),
				'header_widgets'        => array(
					'name'        => esc_html__( 'Header Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown at the top of the page (in the page header area)', 'fitline' ),
				),
				'above_page_widgets'    => array(
					'name'        => esc_html__( 'Top Page Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown below the header, but above the content and sidebar', 'fitline' ),
				),
				'above_content_widgets' => array(
					'name'        => esc_html__( 'Above Content Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown above the content, near the sidebar', 'fitline' ),
				),
				'below_content_widgets' => array(
					'name'        => esc_html__( 'Below Content Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown below the content, near the sidebar', 'fitline' ),
				),
				'below_page_widgets'    => array(
					'name'        => esc_html__( 'Bottom Page Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown below the content and sidebar, but above the footer', 'fitline' ),
				),
				'footer_widgets'        => array(
					'name'        => esc_html__( 'Footer Widgets', 'fitline' ),
					'description' => esc_html__( 'Widgets to be shown at the bottom of the page (in the page footer area)', 'fitline' ),
				),
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

if ( ! function_exists( 'fitline_theme_fonts_links' ) ) {
	/**
	 * Return a list with links for all theme-specific fonts in the format:
	 *
	 * [
	 *   'font1-slug' => 'font1-url',
	 *   'font2-slug' => 'font2-url',
	 *   ...
	 * ]
	 * 
	 * @param bool $separate  Combine all Google fonts to the single link (if false)
	 *                        or add each font-face as separate link (if true)
	 *
	 * @return array  An array with links for all theme-specific fonts.
	 */
	function fitline_theme_fonts_links( $separate = false ) {
		$links = array();

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off'  !== _x( 'on', 'Google fonts: on or off', 'fitline' ) );
		$google_fonts_api     = ( 'css2' !== _x( 'css2', 'Google fonts API: css or css2', 'fitline' ) ? 'css' : 'css2' );
		$adobe_fonts_enabled  = ( 'off'  !== _x( 'on', 'Adobe fonts: on or off', 'fitline' ) );
		$custom_fonts_enabled = ( 'off'  !== _x( 'on', 'Custom fonts (included in the theme): on or off', 'fitline' ) );

		if ( ( $google_fonts_enabled || $adobe_fonts_enabled || $custom_fonts_enabled ) && ! fitline_storage_empty( 'load_fonts' ) ) {
			$load_fonts = fitline_storage_get( 'load_fonts' );
			if ( count( $load_fonts ) > 0 ) {
				$google_fonts_subset = fitline_get_theme_option( 'load_fonts_subset' );
				$google_fonts = '';
				$adobe_fonts  = '';
				foreach ( $load_fonts as $font ) {
					$used = false;
					$slug = fitline_get_load_fonts_slug( $font['name'] );
					// Custom (in the theme folder included) font
					if ( $custom_fonts_enabled && empty( $font['styles'] ) && empty( $font['link'] ) ) {
						$url = fitline_get_file_url( "css/font-face/{$slug}/stylesheet.css" );
						if ( ! empty( $url ) ) {
							$links[ $slug ] = $url;
							$used = true;
						}
					}
					// Adobe font
					if ( $adobe_fonts_enabled && ! empty( $font['link'] ) ) {
						if ( ! in_array( $font['link'], $links ) ) {
							$links[ $slug ] = $font['link'];
						}
						$used = true;
					}
					// Google font
					if ( $google_fonts_enabled && ! $used ) {
						$link = str_replace( ' ', '+', $font['name'] )
									. ':'
									. ( empty( $font['styles'] )
										? ( 'css2' == $google_fonts_api
											? 'ital,wght@0,400;0,700;1,400;1,700'
											: '400,700,400italic,700italic'
											)
										: $font['styles']
										);
						if ( $separate ) {
							$links[ $slug ] = esc_url( "https://fonts.googleapis.com/{$google_fonts_api}?family={$link}&subset={$google_fonts_subset}&display=swap" );
						} else {
							$google_fonts .= ( $google_fonts
												? ( 'css2' == $google_fonts_api
													? '&family='
													: '|'			// Attention! Using '%7C' instead '|' damage loading second+ fonts
													)
												: ''
												)
											. $link;
						}
					}
				}
				if ( $google_fonts_enabled && ! empty( $google_fonts ) && ! $separate ) {
					$links['google_fonts'] = esc_url( "https://fonts.googleapis.com/{$google_fonts_api}?family={$google_fonts}&subset={$google_fonts_subset}&display=swap" );
				}
			}
		}
		return apply_filters( 'fitline_filter_theme_fonts_links', $links );
	}
}

if ( ! function_exists( 'fitline_theme_fonts_for_editor' ) ) {
	/**
	 * Return a list with links for all theme-specific fonts to use its as editor styles.
	 * 
	 * @param bool $separate  Combine all Google fonts to the single link (if false)
	 *                        or add each font-face as separate link (if true)
	 *
	 * @return array  An array with links for all theme-specific fonts
	 */
	function fitline_theme_fonts_for_editor( $separate = false ) {
		$links = array_values( fitline_theme_fonts_links( $separate ) );
		if ( is_array( $links ) && count( $links ) > 0 ) {
			for ( $i = 0; $i < count( $links ); $i++ ) {
				$links[ $i ] = str_replace( ',', '%2C', $links[ $i ] );
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------

if ( ! function_exists( 'fitline_excerpt_length' ) ) {
	/**
	 * Return an excerpt length depends of the current blog style.
	 *
	 * Hooks: add_filter( 'excerpt_length', 'fitline_excerpt_length' );
	 *
	 * @param int $length  Current value of the length.
	 *
	 * @return int         Filtered value of the length.
	 */
	function fitline_excerpt_length( $length ) {
		$blog_style = explode( '_', fitline_get_theme_option( 'blog_style' ) );
		return max( 0, round( fitline_get_theme_option( 'excerpt_length' ) / ( in_array( $blog_style[0], array( 'classic', 'masonry', 'portfolio' ) ) ? 2 : 1 ) ) );
	}
}

if ( ! function_exists( 'fitline_excerpt_more' ) ) {
	/**
	 * Return a string '&hellip;' to append to the excerpt.
	 *
	 * Hooks: add_filter( 'excerpt_more', 'fitline_excerpt_more' );
	 *
	 * @param string $more  A current string to append.
	 *
	 * @return string       A theme-specific string to append.
	 */
	function fitline_excerpt_more( $more ) {
		return '&hellip;';
	}
}


//-------------------------------------------------------
//-- Comments
//-------------------------------------------------------

if ( ! function_exists( 'fitline_comment_form_fields' ) ) {
	/**
	 * Reorder a list with fields for the comment form - put the field 'comment' to the end of the list.
	 *
	 * Hooks: add_filter('comment_form_fields', 'fitline_comment_form_fields');
	 *
	 * @param array $comment_fields  An array with fields for the comments form.
	 *
	 * @return array                 A reordered array with fields.
	 */
	function fitline_comment_form_fields( $comment_fields ) {
		if ( fitline_get_theme_setting( 'comment_after_name' ) ) {
			$keys = array_keys( $comment_fields );
			if ( 'comment' == $keys[0] ) {
				$comment_fields['comment'] = array_shift( $comment_fields );
			}
		}
		return $comment_fields;
	}
}

if ( ! function_exists( 'fitline_comment_form_agree' ) ) {
	/**
	 * Add a checkbox with "I agree ..." to the list of fields for the comments form.
	 *
	 * Hooks: add_filter('comment_form_fields', 'fitline_comment_form_agree', 11);
	 *
	 * @param array $comment_fields  An array with fields for the comments form.
	 *
	 * @return array                 A list with the comments form fields with a checkbox added.
	 */
	function fitline_comment_form_agree( $comment_fields ) {
		$privacy_text = fitline_get_privacy_text();
		if ( ! empty( $privacy_text )
			&& ( ! function_exists( 'fitline_exists_gdpr_framework' ) || ! fitline_exists_gdpr_framework() )
			&& ( ! function_exists( 'fitline_exists_wp_gdpr_compliance' ) || ! fitline_exists_wp_gdpr_compliance() )
		) {
			$comment_fields['i_agree_privacy_policy'] = fitline_single_comments_field(
				array(
					'form_style'        => 'default',
					'field_type'        => 'checkbox',
					'field_req'         => '',
					'field_icon'        => '',
					'field_value'       => '1',
					'field_name'        => 'i_agree_privacy_policy',
					'field_title'       => $privacy_text,
				)
			);
		}
		return $comment_fields;
	}
}


//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------

if ( ! function_exists( 'fitline_theme_thumbs_sizes' ) ) {
	/**
	 * Add a retina-ready dimensions to the list with thumb sizes.
	 *
	 * Hooks: add_filter( 'image_size_names_choose', 'fitline_theme_thumbs_sizes' );
	 *
	 * @param $sizes
	 * @return mixed
	 */
	function fitline_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = fitline_storage_get( 'theme_thumbs' );
		$mult        = fitline_get_theme_option( 'retina_ready', 1 );
		foreach ( $thumb_sizes as $k => $v ) {
			$sizes[ $k ] = $v['title'];
			if ( $mult > 1 ) {
				$sizes[ $k . '-@retina' ] = $v['title'] . ' ' . esc_html__( '@2x', 'fitline' );
			}
		}
		return $sizes;
	}
}


//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

// Load a theme core files
require_once FITLINE_THEME_DIR . 'includes/utils.php';
require_once FITLINE_THEME_DIR . 'includes/storage.php';

require_once FITLINE_THEME_DIR . 'includes/lists.php';
require_once FITLINE_THEME_DIR . 'includes/wp.php';

if ( is_admin() ) {
	require_once FITLINE_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once FITLINE_THEME_DIR . 'includes/admin.php';
}

require_once FITLINE_THEME_DIR . 'theme-options/theme-customizer.php';

require_once FITLINE_THEME_DIR . 'front-page/front-page-options.php';

// Load a skins support
if ( defined( 'FITLINE_ALLOW_SKINS' ) && FITLINE_ALLOW_SKINS && file_exists( FITLINE_THEME_DIR . 'skins/skins.php' ) ) {
	require_once FITLINE_THEME_DIR . 'skins/skins.php';
}

// Load next files after the skins support loaded to allow a file substitution from the skins folder
require_once fitline_get_file_dir( 'theme-specific/theme-tags.php' );
require_once fitline_get_file_dir( 'theme-specific/theme-about/theme-about.php' );

// Add a free theme support
if ( FITLINE_THEME_FREE ) {
	require_once fitline_get_file_dir( 'theme-specific/theme-about/theme-upgrade.php' );
}

// Load an image hover effects
$fitline_file_dir = fitline_get_file_dir( 'theme-specific/theme-hovers/theme-hovers.php' );
if ( ! empty( $fitline_file_dir ) ) {
	require_once fitline_get_file_dir( 'theme-specific/theme-hovers/theme-hovers.php' );      // Substitution from skin is allowed
}

// Load a plugins support
$fitline_required_plugins = apply_filters( 'fitline_required_plugins', fitline_storage_get( 'required_plugins' ) );
if ( is_array( $fitline_required_plugins ) ) {
	foreach ( $fitline_required_plugins as $fitline_plugin_slug => $fitline_plugin_data ) {
		$fitline_plugin_slug = fitline_esc( $fitline_plugin_slug );
		$fitline_plugin_path = fitline_get_file_dir( sprintf( 'plugins/%1$s/%1$s.php', $fitline_plugin_slug ) );
		if ( ! empty( $fitline_plugin_path ) ) {
			require_once $fitline_plugin_path;
		}
	}
}


// CURRENT CHANGES START



// // Automatically activate "WPS Hide Login" plugin after migration
// function ensure_wps_hide_login_activated() {
//     // Check if WPS Hide Login is not active
//     if ( !is_plugin_active('wps-hide-login/wps-hide-login.php') ) {
//         // Activate the WPS Hide Login plugin
//         activate_plugin('wps-hide-login/wps-hide-login.php');
//     }
// }
// // Run the function on every page load
// add_action('wp_loaded', 'ensure_wps_hide_login_activated');




// Automatically activate "WPS Hide Login" plugin and flush rewrite rules after migration
function ensure_wps_hide_login_activated() {
    // Check if WPS Hide Login plugin is installed but not active
    if ( !is_plugin_active('wps-hide-login/wps-hide-login.php') && file_exists(WP_PLUGIN_DIR . '/wps-hide-login/wps-hide-login.php') ) {
        // Activate the plugin
        activate_plugin('wps-hide-login/wps-hide-login.php');

        // Flush rewrite rules to avoid 404 errors
        flush_rewrite_rules();
    }
}
// Run the function on every page load
add_action('wp_loaded', 'ensure_wps_hide_login_activated');








// Remove Privacy Policy link in login page
function remove_privacy_link() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var privacyPolicyLink = document.querySelector('a.privacy-policy-link');
            if (privacyPolicyLink) {
                privacyPolicyLink.style.display = 'none';
            }
        });
    </script>
    <?php
}
add_action('login_footer', 'remove_privacy_link');

// remove or change the "WordPress" label in the title bar of the login page
function change_login_title() {
    return 'Log In - ' . get_bloginfo('name');
}
add_filter('login_title', 'change_login_title');

// remove or change the "WordPress" label in the title bar of the Admin Dashboard
function change_admin_title($admin_title, $title) {
    return $title . ' - ' . get_bloginfo('name');
}
add_filter('admin_title', 'change_admin_title', 10, 2);



// Add a new column to the Users Admin Dashboard
function add_date_created_column($columns) {
    $columns['date_created'] = 'Date Created';
    return $columns;
}
add_filter('manage_users_columns', 'add_date_created_column');

// Populate the Date Created column with the user registration date
function show_date_created_column($value, $column_name, $user_id) {
    if ('date_created' == $column_name) {
        $user = get_userdata($user_id);
        $date_format = 'F j, Y g:i a'; // Format: July 18, 2024 8:34 pm
        return date_i18n($date_format, strtotime($user->user_registered));
    }
    return $value;
}
add_action('manage_users_custom_column', 'show_date_created_column', 10, 3);

// Make the Date Created column sortable
function make_date_created_column_sortable($columns) {
    $columns['date_created'] = 'date_created';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'make_date_created_column_sortable');

// Apply sorting to the Date Created column
function sort_users_by_date_created($query) {
    if (!is_admin()) {
        return;
    }

    $screen = get_current_screen();
    if ('users' === $screen->id) {
        if (isset($_GET['orderby']) && 'date_created' === $_GET['orderby']) {
            $query->query_vars['orderby'] = 'registered';
        }
    }
}
add_action('pre_get_users', 'sort_users_by_date_created');



// Initialize global variables for site settings
function init_global_site_settings() {
    $options = get_option('global_site_settings');

    // Define global variables
    $GLOBALS['SITE_HEADER_BACKGROUND'] = isset($options['site_header_background']) ? esc_html($options['site_header_background']) : '';
	$GLOBALS['SITE_HEADER_LOGO'] = isset($options['site_header_logo']) ? esc_url($options['site_header_logo']) : '';
    $GLOBALS['SITE_HEADER_LOGO_WIDTH'] = isset($options['site_header_logo_width']) ? esc_html($options['site_header_logo_width']) : '';
	$GLOBALS['SITE_HEADER_LOGO_HEIGHT'] = isset($options['site_header_logo_height']) ? esc_html($options['site_header_logo_height']) : '';
	$GLOBALS['SITE_HEADER_LINKS_COLOR'] = isset($options['site_header_links_color']) ? esc_html($options['site_header_links_color']) : '';
	$GLOBALS['SITE_HEADER_ACTIVE_LINK_COLOR'] = isset($options['site_header_active_link_color']) ? esc_html($options
	['site_header_active_link_color']) : '';


	$GLOBALS['HOME_PAGE_SECTION3_IMAGE'] = isset($options['home_page_section3_image']) ? esc_url($options['home_page_section3_image']) : '';
	$GLOBALS['HOME_PAGE_SECTION4_IMAGE'] = isset($options['home_page_section4_image']) ? $options['home_page_section4_image'] : '';
	$GLOBALS['HOME_PAGE_VIEW_MORE_BUTTON_BACKGROUND_COLOR'] = isset($options['home_page_view_more_button_background_color']) ? $options['home_page_view_more_button_background_color'] : '';
	$GLOBALS['HOME_PAGE_VIEW_MORE_BUTTON_TEXT_COLOR'] = isset($options['home_page_view_more_button_text_color']) ? $options['home_page_view_more_button_text_color'] : '';
	
	$GLOBALS['BURGER_MENU_ICON_COLOR'] = isset($options['burger_menu_icon_color']) ? esc_html($options['burger_menu_icon_color']) : '';
	$GLOBALS['BURGER_MENU_CLOSE_ICON_COLOR'] = isset($options['burger_menu_close_icon_color']) ? esc_html($options['burger_menu_close_icon_color']) : '';
	$GLOBALS['MOBILE_MENU_LINKS_COLOR'] = isset($options['mobile_menu_links_color']) ? esc_html($options['mobile_menu_links_color']) : '';
	$GLOBALS['MOBILE_MENU_BACKGROUND_COLOR'] = isset($options['mobile_menu_background_color']) ? esc_html($options['mobile_menu_background_color']) : '';
	
	$GLOBALS['SITE_FOOTER_BACKGROUND'] = isset($options['site_footer_background']) ? esc_html($options['site_footer_background']) : '';
	$GLOBALS['SITE_FOOTER_LINKS_COLOR'] = isset($options['site_footer_links_color']) ? esc_html($options['site_footer_links_color']) : '';
	$GLOBALS['SITE_FOOTER_ACTIVE_LINK_COLOR'] = isset($options['site_footer_active_link_color']) ? esc_html($options['site_footer_active_link_color']) : '';
	$GLOBALS['SITE_FOOTER_COPYRIGHT_COLOR'] = isset($options['site_footer_copyright_color']) ? esc_html($options['site_footer_copyright_color']) : '#ffffff';
	$GLOBALS['SITE_FOOTER_LOGO'] = isset($options['site_footer_logo']) ? esc_url($options['site_footer_logo']) : '';
	$GLOBALS['SITE_FOOTER_LOGO_WIDTH'] = isset($options['site_footer_logo_width']) ? esc_html($options['site_footer_logo_width']) : '';
	$GLOBALS['SITE_FOOTER_LOGO_HEIGHT'] = isset($options['site_footer_logo_height']) ? esc_html($options['site_footer_logo_height']) : '';
	$GLOBALS['SITE_FOOTER_HORIZONTAL_LINE_COLOR'] = isset($options['site_footer_horizontal_line_color']) ? esc_html($options['site_footer_horizontal_line_color']) : '';

	$GLOBALS['SITE_LOGIN_LOGO'] = isset($options['site_login_logo']) ? esc_url($options['site_login_logo']) : '';
	$GLOBALS['SITE_LOGIN_LOGO_WIDTH'] = isset($options['site_login_logo_width']) ? esc_html($options['site_login_logo_width']) : '';
	$GLOBALS['SITE_LOGIN_LOGO_HEIGHT'] = isset($options['site_login_logo_height']) ? esc_html($options['site_login_logo_height']) : '';
	$GLOBALS['SITE_LOGIN_BUTTON_COLOR'] = isset($options['site_login_button_color']) ? esc_html($options['site_login_button_color']) : '';
	$GLOBALS['SITE_LOGIN_BUTTON_TEXT_COLOR'] = isset($options['site_login_button_text_color']) ? esc_html($options['site_login_button_text_color']) : '';
	$GLOBALS['SITE_LOGIN_BACKGROUND_IMAGE'] = isset($options['site_login_background_image']) ? esc_url($options['site_login_background_image']) : '';
	$GLOBALS['SITE_LOGIN_FITNESS_TITLE'] = isset($options['site_login_fitness_title']) ? esc_textarea($options['site_login_fitness_title']) : '';
	$GLOBALS['SITE_LOGIN_FITNESS_DESCRIPTION'] = isset($options['site_login_fitness_description']) ? esc_textarea($options['site_login_fitness_description']) : '';

    $GLOBALS['EMAIL_TEMPLATE_THANK_YOU_BACKGROUND'] = isset($options['email_template_thank_you_background']) ? esc_html($options['email_template_thank_you_background']) : '';
    $GLOBALS['EMAIL_TEMPLATE_THANK_YOU_TEXT_COLOR'] = isset($options['email_template_thank_you_text_color']) ? esc_html($options['email_template_thank_you_text_color']) : '';
    $GLOBALS['EMAIL_TEMPLATE_LOGO'] = isset($options['email_template_logo']) ? esc_url($options['email_template_logo']) : '';
	$GLOBALS['EMAIL_TEMPLATE_LOGO_WIDTH'] = isset($options['email_template_logo_width']) ? esc_html($options['email_template_logo_width']) : '';
	$GLOBALS['EMAIL_TEMPLATE_LOGO_HEIGHT'] = isset($options['email_template_logo_height']) ? esc_html($options['email_template_logo_height']) : '';
	$GLOBALS['EMAIL_TEMPLATE_IMAGE'] = isset($options['email_template_image']) ? esc_url($options['email_template_image']) : '';
    $GLOBALS['EMAIL_TEMPLATE_BUTTON_COLOR'] = isset($options['email_template_button_color']) ? esc_html($options['email_template_button_color']) : '';
    $GLOBALS['EMAIL_TEMPLATE_BUTTON_TEXT_COLOR'] = isset($options['email_template_button_text_color']) ? esc_html($options['email_template_button_text_color']) : '';
    $GLOBALS['EMAIL_TEMPLATE_FOOTER_BACKGROUND'] = isset($options['email_template_footer_background']) ? esc_html($options['email_template_footer_background']) : '';
    $GLOBALS['EMAIL_TEMPLATE_FOOTER_TEXT_COLOR'] = isset($options['email_template_footer_text_color']) ? esc_html($options['email_template_footer_text_color']) : '';
    $GLOBALS['EMAIL_TEMPLATE_FONT_FAMILY'] = isset($options['email_template_font_family']) ? esc_html($options['email_template_font_family']) : '';

	$GLOBALS['THEME_COLOR'] = isset($options['theme_color']) ? esc_html($options['theme_color']) : '';
	$GLOBALS['BUTTON_TEXT_COLOR'] = isset($options['button_text_color']) ? esc_html($options['button_text_color']) : '';
	$GLOBALS['SCROLL_TO_TOP_BUTTON_BACKGROUND'] = isset($options['scroll_to_top_button_background']) ? esc_html($options['scroll_to_top_button_background']) : '';
	$GLOBALS['COURSE_PREVIEW_BUTTON_BACKGROUND'] = isset($options['course_preview_button_background']) ? esc_html($options['course_preview_button_background']) : '';
	$GLOBALS['SITE_TITLE'] = isset($options['site_title']) ? esc_html($options['site_title']) : '';
	$GLOBALS['SUPPORT_EMAIL'] = isset($options['support_email']) ? esc_html($options['support_email']) : '';
	$GLOBALS['FAVICON'] = isset($options['favicon']) ? esc_url($options['favicon']) : '';
}
add_action('init', 'init_global_site_settings');


// Shortcode for site title
function shortcode_site_title() {
    return isset($GLOBALS['SITE_TITLE']) ? $GLOBALS['SITE_TITLE'] : '';
}
add_shortcode('website_title', 'shortcode_site_title');

// Shortcode for support email
function shortcode_support_email() {
    return isset($GLOBALS['SUPPORT_EMAIL']) ? $GLOBALS['SUPPORT_EMAIL'] : '';
}
add_shortcode('support_email', 'shortcode_support_email');


// change site title 
add_filter('admin_title', 'custom_admin_title', 10, 2);
function custom_admin_title($admin_title, $title) {
    // Set a custom site title for the admin dashboard
	global $SITE_TITLE;
    return $title . ' - ' . $SITE_TITLE;
}
add_filter('bloginfo', 'custom_bloginfo', 10, 2);
function custom_bloginfo($output, $show) {
	// Set a custom site title for the blog pages
	global $SITE_TITLE;
    if ($show === 'name') {
        $output = $SITE_TITLE;
    }
    return $output;
}
add_action('admin_bar_menu', 'customize_admin_bar_site_title', 999);
function customize_admin_bar_site_title($wp_admin_bar) {
    // Get the existing site title node
    $node = $wp_admin_bar->get_node('site-name');

	global $SITE_TITLE;

    // Update the node with the custom title
    $wp_admin_bar->add_node([
        'id' => 'site-name',
        'title' => $SITE_TITLE,
        'href' => $node->href, // Preserve the link to the front-end
    ]);
}
add_filter('login_title', 'custom_login_page_title', 10, 2);
function custom_login_page_title($login_title, $title) {
    // Customize the title on the login page
	global $SITE_TITLE;
    return "Log In - $SITE_TITLE";
}
function custom_update_site_title() {
	// Set a custom site title in Customize>Site Title & Logo Settings
    global $SITE_TITLE;

    // Update the 'blogname' option with your custom title
    update_option( 'blogname', $SITE_TITLE );
}
add_action( 'init', 'custom_update_site_title' );


// Remove the login logo link
function remove_login_logo_link() {
    return '#'; // Set the URL to a hash, effectively removing the link
}
add_filter('login_headerurl', 'remove_login_logo_link');

// Remove the login logo title
function remove_login_logo_title() {
    return ''; // Return an empty string to remove the title
}
add_filter('login_headertext', 'remove_login_logo_title');


// Change the header logo
function change_header_logo() {
    global $SITE_HEADER_LOGO, $SITE_TITLE;

    ?>
    <style>
		/* initially hide the old logo in desktop view  */
		header section:first-child img {
			display: none;
		}
		/* initially hide the old logo in when scroll the page  */
		header section:nth-child(2) img {
			display: none;
		}
		/* initially hide the old logo in other mobile screen  */
		header section:nth-child(3) img {
			display: none;
		}
		/* initially hide the old logo in mobile view  */
		.menu_mobile_inner img {
			display: none;
		}
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			// show the new logo in desktop view
			let headerLogo = document.querySelector("header section:first-child img");
            if (headerLogo) {
                headerLogo.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                headerLogo.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				headerLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                headerLogo.style.display = "block";
            }

			// show the new logo when scroll the page
			let headerLogo2 = document.querySelector("header section:nth-child(2) img");
            if (headerLogo2) {
                headerLogo2.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                headerLogo2.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				headerLogo2.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                headerLogo2.style.display = "block";
            }

			// show the new logo in other mobile screen
			let headerLogo3 = document.querySelector("header section:nth-child(3) img");
            if (headerLogo3) {
                headerLogo3.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                headerLogo3.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				headerLogo3.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                headerLogo3.style.display = "block";
            }

			// show the new logo in mobile view
			let mobileHeaderLogo = document.querySelector(".menu_mobile_inner img");
            if (mobileHeaderLogo) {
                mobileHeaderLogo.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                mobileHeaderLogo.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				mobileHeaderLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                mobileHeaderLogo.style.display = "block";
            }

        });
    </script>
    <?php
}
add_action('wp_head', 'change_header_logo');


// Change the footer logo
function change_footer_logo() {
    global $SITE_FOOTER_LOGO, $SITE_TITLE;
    ?>
	<style>
        footer img {
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let footerLogo = document.querySelector("footer img");
            if (footerLogo) {
                footerLogo.src = "<?php echo $SITE_FOOTER_LOGO; ?>";
                footerLogo.srcset = "<?php echo $SITE_FOOTER_LOGO; ?>";
				footerLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
				footerLogo.style.display = "block";
            }
        });
    </script>
    <?php
}
add_action('wp_head', 'change_footer_logo');


// Remove default RSS feed link
remove_action('wp_head', 'feed_links', 2);

// Change the RSS feed title and output the custom link
function change_rss_feed_title() {
    global $SITE_TITLE;

    // Set the dynamic site title
    $dynamic_title = $SITE_TITLE;
    $comments_feed_url = esc_url(get_bloginfo('comments_rss2_url'));

    // Capture the output of get_bloginfo('rss2_url') to construct the <link> tag manually
    $rss_url = esc_url(get_bloginfo('rss2_url'));

    echo '<link rel="alternate" type="application/rss+xml" title="' . esc_attr($dynamic_title) . ' &raquo; Feed' . '" href="' . $rss_url . '" />' . PHP_EOL;

    echo '<link rel="alternate" type="application/rss+xml" title="' . esc_attr($dynamic_title . ' &raquo; Comments Feed') . '" href="' . $comments_feed_url . '" />' . PHP_EOL;

    echo '<meta property="og:site_name" content="' . esc_attr($dynamic_title) . '" />' . PHP_EOL;
}
add_action('wp_head', 'change_rss_feed_title', 1);


// custom global settings
function custom_site_global_variables() {
    global $SITE_FOOTER_BACKGROUND, $SITE_HEADER_BACKGROUND, $SITE_HEADER_LINKS_COLOR, $BURGER_MENU_ICON_COLOR, $BURGER_MENU_CLOSE_ICON_COLOR, $MOBILE_MENU_LINKS_COLOR, $SITE_HEADER_ACTIVE_LINK_COLOR, $SITE_FOOTER_LINKS_COLOR, $SITE_FOOTER_ACTIVE_LINK_COLOR, $THEME_COLOR, $SCROLL_TO_TOP_BUTTON_BACKGROUND, $COURSE_PREVIEW_BUTTON_BACKGROUND, $SITE_HEADER_LOGO_WIDTH, $SITE_HEADER_LOGO_HEIGHT, $SITE_FOOTER_LOGO_WIDTH, $SITE_FOOTER_LOGO_HEIGHT, $HOME_PAGE_SECTION3_IMAGE, $HOME_PAGE_SECTION4_IMAGE, $MOBILE_MENU_BACKGROUND_COLOR, $SITE_FOOTER_COPYRIGHT_COLOR, $BUTTON_TEXT_COLOR, $SITE_FOOTER_HORIZONTAL_LINE_COLOR, $HOME_PAGE_VIEW_MORE_BUTTON_BACKGROUND_COLOR, $HOME_PAGE_VIEW_MORE_BUTTON_TEXT_COLOR;

    // Escaping the $HOME_PAGE_SECTION4_IMAGE for safe JavaScript output
    $home_page_images = !empty($HOME_PAGE_SECTION4_IMAGE) ? esc_js($HOME_PAGE_SECTION4_IMAGE) : '';

    echo '<style>
		/* Header */
		header div section.sc_layouts_row {
			background-color: ' . $SITE_HEADER_BACKGROUND . ' !important;
		}
		header section:first-child img, header section:nth-child(2) img, header section:nth-child(3) img, .menu_mobile_inner img {
			width: ' . $SITE_HEADER_LOGO_WIDTH . ' !important;
			height: ' . $SITE_HEADER_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		@media only screen and (max-width: 500px) {
			.menu_mobile_inner img {
				width: 170px !important;
				height: auto !important;
			}
		}
		#menu_main a,
        #menu_main a span {
            color: ' . $SITE_HEADER_LINKS_COLOR . ' !important;
        }
		#menu_main .current-menu-item a,
        #menu_main .current-menu-item a span {
        	color: ' . $SITE_HEADER_ACTIVE_LINK_COLOR . ' !important;
        }
		.menu_hover_zoom_line .sc_layouts_menu_nav > li:not(.menu-collapse) > a:after {
			background-color: ' . $SITE_HEADER_ACTIVE_LINK_COLOR . ' !important;
		}
		#menu_main a:hover,
        #menu_main a:hover span {
            color: ' . $SITE_HEADER_ACTIVE_LINK_COLOR . ' !important;
        }

		/* Footer */
		footer div section:first-of-type {
			background-color: ' . $SITE_FOOTER_BACKGROUND . ' !important;
		}
		footer img {
			width: ' . $SITE_FOOTER_LOGO_WIDTH . ' !important;
			height: ' . $SITE_FOOTER_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		@media only screen and (max-width: 500px) {
			footer img {
				width: 170px !important;
				height: auto !important;
			}
		}
		.sc_layouts_menu_nav > li > a {
			color: ' . $SITE_FOOTER_LINKS_COLOR . ' !important;
		}
		.sc_layouts_menu_nav > li.current-menu-item > a {
			color: ' . $SITE_FOOTER_ACTIVE_LINK_COLOR . ' !important;
		}
		.sc_layouts_menu_nav > li > a:hover {
			color: ' . $SITE_FOOTER_ACTIVE_LINK_COLOR . ' !important;
		}
		footer .elementor-widget-divider:not(.elementor-widget-divider--view-line_text):not(.elementor-widget-divider--view-line_icon) .elementor-divider-separator {
			border-color: ' . $SITE_FOOTER_HORIZONTAL_LINE_COLOR . ' !important;
		}

		/* Home page */
		.home-view-more-btn {
			background: ' . $HOME_PAGE_VIEW_MORE_BUTTON_BACKGROUND_COLOR . ' !important;
			color: ' . $HOME_PAGE_VIEW_MORE_BUTTON_TEXT_COLOR . ' !important;
		}

		/* Videos page */
        .lp-archive-courses .learn-press-courses[data-layout] .course .course-item .course-content .course-wrap-meta .meta-item:before {
			color: ' . $THEME_COLOR . ' !important;
		}
        .course-summary .course-summary-content .course-detail-info .course-info-left .course-meta .course-meta__pull-left .meta-item:before {
			color: ' . $THEME_COLOR . ' !important;
		}
        .lp-archive-courses .lp-badge.featured-course {
            background: ' . $THEME_COLOR . ' !important;
        }
		.lp-archive-courses .lp-badge.featured-course:before {
            color: ' . $BUTTON_TEXT_COLOR . ' !important;
        }
        #learn-press-course-tabs.course-tabs .course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link:before { 
			color: ' . $THEME_COLOR . ' !important;
        }
        #learn-press-course-tabs.course-tabs ul.learn-press-nav-tabs .course-nav.active:before {
        	background: ' . $THEME_COLOR . ' !important;
        }
        ul[class*="trx_addons_list"]>li:before {
			color: ' . $THEME_COLOR . ' !important;
		}
        #learn-press-course-tabs.course-tabs .course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link .course-item-info .course-item-info-pre .item-meta.duration {
			background: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
		/* background: #620613 !important; */
        #learn-press-course-tabs.course-tabs .course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link .course-item-info .course-item-info-pre .item-meta.course-item-preview:before {
			background: ' . $COURSE_PREVIEW_BUTTON_BACKGROUND . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
        }
		#popup-course #popup-sidebar #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link .course-item-info .course-item-info-pre .item-meta.course-item-preview:before {
        	background: ' . $COURSE_PREVIEW_BUTTON_BACKGROUND . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
        }
        #popup-course #popup-sidebar #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link:before {
        	color: ' . $THEME_COLOR . ' !important;
        }
        #popup-course #popup-sidebar #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link .course-item-info .course-item-info-pre .item-meta.duration {
        	background: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
        }
        #popup-course #sidebar-toggle {
        	background: ' . $THEME_COLOR . ' !important;
        }
        #popup-course #sidebar-toggle:before {
        	background: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
        }
        #popup-course #popup-content .lp-button {
			background: ' . $THEME_COLOR . ' !important;
		}
        #popup-course #popup-header {
        	background: ' . $SITE_HEADER_BACKGROUND . ' !important;
        }
		#popup-course #popup-header .popup-header__inner .course-title a,
		#popup-course #popup-header .popup-header__inner .items-progress .number,
		#popup-course #popup-header a.back-course {
        	color: ' . $SITE_HEADER_LINKS_COLOR . ' !important;
        }
		#popup-course #popup-header .popup-header__inner .items-progress .learn-press-progress:before {
        	background: ' . $SITE_HEADER_LINKS_COLOR . ' !important;
        }
		/* when clicked the "Complete" button in Videos content */
		.learnpress.learnpress-page .lp-button,
		.learnpress.learnpress-page .lp-button {
			background: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}

		/* My Account page */
		.woocommerce-MyAccount-navigation li.is-active a {
			color: ' . $THEME_COLOR . ' !important;
		}
		.woocommerce-MyAccount-navigation li > a:hover {
			color: ' . $THEME_COLOR . ' !important;
		}
		.woocommerce-MyAccount-content > p > a {
			color: ' . $THEME_COLOR . ' !important;
		}
		.woocommerce .button, .woocommerce-page .button {
			background-color: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
        .woocommerce-LostPassword.lost_password a {
            color: ' . $THEME_COLOR . ' !important;
        }

		/* Burger Menu */
		.menu_mobile .menu_mobile_inner {
			background-color: ' . $MOBILE_MENU_BACKGROUND_COLOR . ' !important;
		}
		.menu_mobile .menu_mobile_inner a {
			color: ' . $MOBILE_MENU_LINKS_COLOR . ' !important;
		}
		.menu_mobile .menu_mobile_inner a:hover {
			color: ' . $SITE_FOOTER_LINKS_COLOR . ' !important;
		}
		.menu_mobile.opened .menu_mobile_close .menu_button_close_text {
			color: ' . $BURGER_MENU_CLOSE_ICON_COLOR . ' !important;
		}
		.menu_mobile.opened .menu_mobile_close .menu_button_close_icon {
			color: ' . $BURGER_MENU_CLOSE_ICON_COLOR . ' !important;
		}
		.sc_layouts_menu_mobile_button .sc_layouts_item_icon, .sc_layouts_menu_mobile_button_burger .sc_layouts_item_icon {
			color: ' . $BURGER_MENU_ICON_COLOR . ' !important;
		}

		/* all pages */
		.scroll_to_top_style_default {
			background-color: ' . $SCROLL_TO_TOP_BUTTON_BACKGROUND . ' !important;
			border-color: ' . $SCROLL_TO_TOP_BUTTON_BACKGROUND . ' !important;
		}
			
    </style>';

	echo '<script>
        document.addEventListener("DOMContentLoaded", function() {

			// replace home page section 3 image
            let section4image = document.querySelectorAll(".post_content section:nth-child(4) img");
            section4image.forEach(function(image) {
                image.src = "' . $HOME_PAGE_SECTION3_IMAGE . '";
                image.srcset = "' . $HOME_PAGE_SECTION3_IMAGE . '";
            });


			// replace home page slideshow images in section 4
            setTimeout(function() {
                let newImages = ' . json_encode(explode(",", $home_page_images)) . ';

                let slideshowSlides = document.querySelectorAll(".elementor-background-slideshow__slide__image");
                slideshowSlides.forEach(function(slide, index) {
                    let newImageUrl = newImages[index % newImages.length].trim();
                    slide.style.backgroundImage = "url(" + newImageUrl + ")";
                });
            }, 100);

			// change the color of Copyright text in footer
			const spans = document.querySelectorAll("footer span");
            spans.forEach(span => {
                if (span.textContent.includes("Copyright")) {
                    span.style.color = "' . $SITE_FOOTER_COPYRIGHT_COLOR . '";
                }
            });

			
        });
    </script>';
}
add_action('wp_head', 'custom_site_global_variables');


// function to replace the favicon
function add_favicon_inline_script() {
    global $FAVICON;
    
    if ($FAVICON) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                let link = document.querySelector("link[rel~=\'icon\']");
                if (!link) {
                    link = document.createElement("link");
                    link.rel = "icon";
                    document.getElementsByTagName("head")[0].appendChild(link);
                }
                link.href = "' . esc_url($FAVICON) . '";
            });
        </script>';
    }
}
add_action('wp_print_scripts', 'add_favicon_inline_script');


// function for login form template 1
function login_form_template1() {
	global $SITE_LOGIN_BUTTON_COLOR, $SITE_LOGIN_LOGO, $SITE_LOGIN_BUTTON_TEXT_COLOR, $SITE_LOGIN_BACKGROUND_IMAGE, $THEME_COLOR, $SITE_LOGIN_LOGO_WIDTH, $SITE_LOGIN_LOGO_HEIGHT, $SITE_LOGIN_FITNESS_TITLE, $SITE_LOGIN_FITNESS_DESCRIPTION;

	echo '<style type="text/css">
		body.login {
			background-color: transparent !important; /* Remove default background color */
			display: flex !important;
			align-items: center !important;
			justify-content: center !important;
			min-height: 100vh !important; /* Ensures the body covers the entire viewport */
			padding: 0 !important; /* Remove any default padding */
			margin: 0 !important; /* Remove any default margin */
		}
		.login {
			background-image: url(' .$SITE_LOGIN_BACKGROUND_IMAGE. ') !important;
			background-size: cover !important;
			background-repeat: no-repeat !important;
			background-position: center center !important;
			min-height: 100vh !important;
		}
		@media (min-width: 768px) {
			.login {
				overflow: hidden !important;
			}
		}
		.login .crlpuic-wrapper {
            flex-direction: column;
            align-items: center;
        }
        .login .crlpuic-wrapper .crlpuic-content {
        	border-radius: 0 !important;
			border-top-left-radius: 50px !important;
    		border-top-right-radius: 50px !important;
		}
        .login .crlpuic-wrapper .crlpuic-form-wrapper {
        	border-radius: 0 !important;
			border-bottom-left-radius: 50px !important;
    		border-bottom-right-radius: 50px !important;
		}
        .submit #wp-submit {
			width: 100%;
		}	
        .crlpuic-content-wrapper h2 {
        	line-height: 1.1;
            text-align: center;
        }
        body.crlpuic-one-half .crlpuic-wrapper .crlpuic-content {
        	background-color: #DDDDDD !important;
        }
        body .crlpuic-content-wrapper {
			padding: 0 15% !important;
		}
        .crlpuic-content-wrapper h2 {
			font-size: 29px !important;
		}	
        .crlpuic-content-wrapper p {
			font-size: 14px !important;
		}
        .login form {
			padding: 26px 24px 10px !important;
		}

		body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        .login {
            background-repeat: no-repeat;
            height: 100vh;
        }
		#loginform .button-primary {
			background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			border: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			color: ' . $SITE_LOGIN_BUTTON_TEXT_COLOR . ' !important;
		} 
		#loginform .button-primary:hover {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		#loginform .button-primary:focus {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
            box-shadow: 0 0 0 1px ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		.login h1 a {
			background-image: url(' .$SITE_LOGIN_LOGO. ') !important;
    		margin-top: 1em !important;
			width: ' . $SITE_LOGIN_LOGO_WIDTH . ' !important;
			height: ' . $SITE_LOGIN_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		.login .button.wp-hide-pw .dashicons {
			color: ' . $THEME_COLOR . ' !important;
		}

		@media only screen and (max-width: 1400px) {
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 60% !important;
            }
        }
        @media only screen and (max-width: 1200px) {
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 70% !important;
            }
        }
        
        @media only screen and (max-width: 992px) {
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 80% !important;
            }
        }
        
        @media only screen and (max-width: 768px) {
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 90% !important;
            }
        }
        
        @media only screen and (max-width: 577px) {
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 100% !important;
            }
        }
    </style>';


	echo '
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let titleElement = document.querySelector(".login .crlpuic-content-wrapper-inner .content-title");
            if (titleElement) {
                titleElement.textContent = "' . esc_js($SITE_LOGIN_FITNESS_TITLE) . '";
            }
            
            let descElement = document.querySelector(".login .crlpuic-content-wrapper-inner .content-desc");
            if (descElement) {
                descElement.textContent = "' . esc_js($SITE_LOGIN_FITNESS_DESCRIPTION) . '";
            }
        });
    </script>
    ';
}

// function for login form template 2
function login_form_template2() {
	global $SITE_LOGIN_BUTTON_COLOR, $SITE_LOGIN_LOGO, $SITE_LOGIN_BUTTON_TEXT_COLOR, $SITE_LOGIN_BACKGROUND_IMAGE, $THEME_COLOR, $SITE_LOGIN_LOGO_WIDTH, $SITE_LOGIN_LOGO_HEIGHT, $SITE_LOGIN_FITNESS_TITLE, $SITE_LOGIN_FITNESS_DESCRIPTION;

	echo '<style type="text/css">
		body.login {
			background-color: transparent !important; /* Remove default background color */
			display: flex !important;
			align-items: center !important;
			justify-content: center !important;
			min-height: 100vh !important; /* Ensures the body covers the entire viewport */
			padding: 0 !important; /* Remove any default padding */
			margin: 0 !important; /* Remove any default margin */
		}
		.login {
			background-image: url(' .$SITE_LOGIN_BACKGROUND_IMAGE. ') !important;
			background-size: cover !important;
			background-repeat: no-repeat !important;
			background-position: center center !important;
			min-height: 100vh !important;
		}
		@media (min-width: 768px) {
			.login {
				overflow: hidden !important;
			}
		}
		@media only screen and (max-width: 768px) {
			.login .crlpuic-wrapper .crlpuic-content {
				border-radius: 0 !important;
				border-top-left-radius: 50px !important;
				border-top-right-radius: 50px !important;
			}
			.login .crlpuic-wrapper .crlpuic-form-wrapper {
				border-radius: 0 !important;
				border-bottom-left-radius: 50px !important;
				border-bottom-right-radius: 50px !important;
			}
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-content,
            html body.crlpuic-one-half .crlpuic-wrapper > .crlpuic-form-wrapper {
                width: 100% !important;
            }
			.crlpuic-form-wrapper-inner {
				margin: 0% auto !important;
			}
        }

		#loginform .button-primary {
			background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			border: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			color: ' . $SITE_LOGIN_BUTTON_TEXT_COLOR . ' !important;
		} 
		#loginform .button-primary:hover {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		#loginform .button-primary:focus {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
            box-shadow: 0 0 0 1px ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		.login h1 a {
			background-image: url(' .$SITE_LOGIN_LOGO. ') !important;
    		margin-top: 1em !important;
			width: ' . $SITE_LOGIN_LOGO_WIDTH . ' !important;
			height: ' . $SITE_LOGIN_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		.login .button.wp-hide-pw .dashicons {
			color: ' . $THEME_COLOR . ' !important;
		}
    </style>';


	echo '
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let titleElement = document.querySelector(".login .crlpuic-content-wrapper-inner .content-title");
            if (titleElement) {
                titleElement.textContent = "' . esc_js($SITE_LOGIN_FITNESS_TITLE) . '";
            }
            
            let descElement = document.querySelector(".login .crlpuic-content-wrapper-inner .content-desc");
            if (descElement) {
                descElement.textContent = "' . esc_js($SITE_LOGIN_FITNESS_DESCRIPTION) . '";
            }
        });
    </script>
    ';
}

// Function to switch login templates
function switch_login_template() {
	$options = get_option('global_site_settings');
    $template = isset($options['site_login_form_template']) ? $options['site_login_form_template'] : '1';

    if ($template == '1') {
        login_form_template1();
    } 
	else {
        login_form_template2();
    }
}
add_action('login_enqueue_scripts', 'switch_login_template');



/**
 * credentials function - this is from woocommerce rest api 
 * generate a new one for new site
 */
function creds() {
	global $SITE_TITLE;
	return array(
		'username' => 'ck_ca65581060a64373bc6c34dc2daee365d7dd4400',
		'password' => 'cs_e3454aafb71deb94705407628b368a7cc2e16719',
		'domain_name' => $SITE_TITLE,
		'subject_domain_name' => $SITE_TITLE,
		'base_url' => str_replace(array('https://', 'http://', 'www'), array('', '', ''), get_base_url())
	);
}



/**
 * ADD NEW USER COLUMN FOR ACTIVE STATUS
 */
function new_active_status( $active_status ) {
    $active_status['active_status'] = 'Active Status';
    return $active_status;
}
add_filter( 'user_contactmethods', 'new_active_status', 10, 1 );


function new_modify_user_table( $column ) {
    $column['active_status'] = 'Active Status';
	if (isset($column['posts'])) unset($column['posts']);
	if (isset($column['locked'])) unset($column['locked']);
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'active_status' :
            return get_user_meta($user_id, 'active_status', true) == "1" ? "Active" : "Inactive";
            // return get_user_meta($user_id, 'active_status', true);
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );



/**
 * Bypass Force Login to allow for exceptions.
 *
 * @param bool $bypass Whether to disable Force Login. Default false.
 * @param string $visited_url The visited URL.
 * @return bool
 */
function my_forcelogin_bypass( $bypass, $visited_url ) {

	// Allow 'My Page' to be publicly accessible
	if ( is_page(array(2334, 'my-account', 'my-account-lost-password')) ) {
		$bypass = true;
	}

	if (strpos($_SERVER['REQUEST_URI'], '/wp-json/wp/v2/users/register') != "") {
		$bypass = true;
	} 

	return $bypass;
}
add_filter( 'v_forcelogin_bypass', 'my_forcelogin_bypass', 10, 2 );

/**
 * POSTBACK ENDPOINTS
 */

add_action( 'rest_api_init', function () {
	register_rest_route('wp/v2', 'users/register', array(
		'methods' => 'POST',
		'callback' => 'wc_rest_user_endpoint_handler',
		'permission_callback' => '__return_true'
	));
} );

function wc_rest_user_endpoint_handler($request = null) {
	$reponseCode = 200;
	$response = array();
	$parameters = $request->get_params();
	
	$username = sanitize_text_field($parameters['email']); // use email as username
	$firstname = sanitize_text_field($parameters['firstname']);
	$lastname = sanitize_text_field($parameters['lastname']);
	$email = sanitize_text_field($parameters['email']);
	$order_id = sanitize_text_field($parameters['order_id']);
	$limit = sanitize_text_field($parameters['limit']);

	//shipping address
	$shippingDetails = array(
		'shipping_first_name' => $firstname,
		'shipping_last_name' => $lastname,
		'shipping_phone' => sanitize_text_field($parameters['phone']),
		'shipping_city' => sanitize_text_field($parameters['shippingCity']),
		'shipping_state' => sanitize_text_field($parameters['shippingState']),
		'shipping_country' => sanitize_text_field($parameters['shippingCountry']),
		'shipping_address_1' => sanitize_text_field($parameters['address']),
		'shipping_postcode' => sanitize_text_field($parameters['zipcode'])
	);

	$password = getRandomString(12);
	$emailArr = explode("@", $email);

	//auth checking
	if (auth_checking() === false) {
		$reponseCode = 401;
		$response['code'] = 401;
		$response['message'] = __("Unauthorized", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}

	if (isset($limit) && $limit != "") {
		for($i = 1; $i <= $limit; $i++) {
			$usernameLoop  = $username.''.$i;
			$email     = $emailArr[0] . $i . "@" . $emailArr[1];
			$resSingle = register_user($usernameLoop, $firstname, $lastname, $email, $password, $order_id, $shippingDetails);
			if ($resSingle['code'] != 200) $reponseCode = $resSingle['code'];
			$response[] = $resSingle;
		}
	} else {
		$resSingle = register_user($username, $firstname, $lastname, $email, $password, $order_id, $shippingDetails);
		if ($resSingle['code'] != 200) $reponseCode = $resSingle['code'];
		$response[] = $resSingle;
	}

	return new WP_REST_Response($response, $reponseCode);
}

function register_user($username, $firstname, $lastname, $email, $password, $order_id, $shippingDetails) {
	$response = array();
	$error = new WP_Error();

	if (empty($username)) {
		$response['code'] = 400;
		$response['message'] = __("Username field is required.", "wp-rest-user");
		return $response;
	}
	if (empty($email)) {
		$response['code'] = 400;
		$response['message'] = __("Email field is required.", 'wp-rest-user');
		return $response;
	} else {
		if (!is_email($email)) {
			$response['code'] = 400;
			$response['message'] = __("Email field is invalid.", 'wp-rest-user');
			return $response;
		}
	}
	
	$user_id = username_exists($username);

	if (!$user_id && email_exists($email) == false) {
		$user_id = wp_create_user($username, $password, $email);
		if (!is_wp_error($user_id)) {
			// Ger User Meta Data (Sensitive, Password included. DO NOT pass to front end.)
			$user = get_user_by('id', $user_id);
			$user->set_role('customer');
			
			// generate gift card
				// $giftCard = customer_gift_card(get_base_url(), $email);
				// $giftCardNumber = $giftCard[0]->gift_card->number;

			$emailConfirmationSub = "Customer Account Confirmation";
			$emailSubject = "Welcome to " . creds()['subject_domain_name'];

			// add user meta data
				// add_user_meta($user_id, 'gift_card_id', $giftCardNumber, true);
			add_user_meta($user_id, 'active_status', "1", true);
			add_user_meta($user_id, 'order_id', $order_id, true);

			// send email for coupon details
			customer_login_creds($emailSubject, $firstname, $lastname, get_base_url(), $email, $password);

			wp_update_user([
				'ID' => $user_id, // this is the ID of the user you want to update.
				'first_name' => $firstname,
				'last_name' => $lastname,
			]);

			// update shipping address
			foreach ($shippingDetails as $meta_key => $meta_value ) {
				update_user_meta( $user_id, $meta_key, $meta_value );
			}

			// WooCommerce specific code
			if (class_exists('WooCommerce')) {
				$user->set_role('customer');
			}
			// Ger User Data (Non-Sensitive, Pass to front end.)
			$response['code'] = 200;
			$response['message'] = __("User '" . $username . "' Registration was Successful", "wp-rest-user");
		} else {
			return $user_id;
		}
	} else {
		$response['code'] = 400;
		$response['message'] = __("Email or Username is already exists, please try 'Reset Password'", 'wp-rest-user');
		return $response;
	}

	return $response;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/customer/rebill', array(
		'methods'  => 'POST',
		'callback' => 'customer_rebill',
		'permission_callback' => '__return_true',
	) );
} );

function customer_rebill($request) {
	$reponseCode = 200;
	$response = array();
	$parameters = $request->get_params();
	
	$isActive = sanitize_text_field($parameters['is_active']);
	$email = sanitize_text_field($parameters['email']);
	
	//auth checking
	if (auth_checking() === false) {
		$reponseCode = 401;
		$response['code'] = 401;
		$response['message'] = __("Unauthorized", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}

	if (empty($email)) {
		$reponseCode = 400;
		$response['code'] = 400;
		$response['message'] = __("Email field 'email' is required.", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}

	if ((isset($email) && $email != "") && (isset($isActive) && $isActive != "")) {
		$user = get_user_by_email($email);
		if (empty($user)) {
			$reponseCode = 400;
			$response['code'] = 400;
			$response['message'] = __("Invalid email please try a new email", 'wp-rest-user');
			return new WP_REST_Response($response, $reponseCode);
		}

		$userId = $user->get('ID');

		// add separated user meta for active status
		add_user_meta($userId, 'active_status', $isActive, true);

		if (isset($userId) && $userId != "") {
			if ($isActive == "1") {
				// unlock the customer
				delete_user_meta($userId, 'baba_user_locked');
				update_user_meta($userId, 'active_status', '1');

				$reponseCode = 200;
				$response['code'] = 200;
				$response['message'] = __("Active Status set to ACTIVE - '$email'.", 'wp-rest-user');
			} elseif ($isActive == "0") {
				// lock the customer
				add_user_meta($userId, 'baba_user_locked', 'yes');
				delete_user_meta($userId, 'active_status');

				$reponseCode = 200;
				$response['code'] = 200;
				$response['message'] = __("Active Status set to INACTIVE - '$email'", 'wp-rest-user');
			}
		} else {
			$reponseCode = 400;
			$response['code'] = 400;
			$response['message'] = __("Can't find the user ID", 'wp-rest-user');
		}
	} else {
		$reponseCode = 400;
		$response['code'] = 400;
		$response['message'] = __("Parameter mismatch", 'wp-rest-user');
	}

	return new WP_REST_Response($response, $reponseCode);
}

function customer_login_creds($subject, $firstname, $lastname, $baseUrl, $email, $password) {
	$domainName = creds()['domain_name'];
	// $urlReplace = creds()['base_url'];
	$yearNow = date('Y');

	global $SUPPORT_EMAIL, $EMAIL_TEMPLATE_THANK_YOU_BACKGROUND, $EMAIL_TEMPLATE_THANK_YOU_TEXT_COLOR, $EMAIL_TEMPLATE_LOGO, $EMAIL_TEMPLATE_LOGO_WIDTH, $EMAIL_TEMPLATE_LOGO_HEIGHT, $EMAIL_TEMPLATE_BUTTON_COLOR, $EMAIL_TEMPLATE_BUTTON_TEXT_COLOR, $EMAIL_TEMPLATE_FOOTER_BACKGROUND, $EMAIL_TEMPLATE_IMAGE, $EMAIL_TEMPLATE_FONT_FAMILY, $EMAIL_TEMPLATE_FOOTER_TEXT_COLOR;

	$html = "
		<table width='100%' cellpadding='0' cellspacing='0' role='presentation' style='background:#edf2f7;margin:0px;padding:32px 15px;width:100%!important'>
			<tbody style='font-family: $EMAIL_TEMPLATE_FONT_FAMILY;'>
			<tr>
				<td align='center'>
					<table width='100%' cellpadding='0' cellspacing='0' role='presentation' style='margin:0px;padding:0px;max-width:570px'>
						<tbody>
							
						<tr>
							<td width='100%' cellpadding='0' cellspacing='0' style='border-top-width:1px;border-top-color:rgb(237,242,247);border-bottom-width:1px;border-bottom-color:rgb(237,242,247);margin:0px;padding:0px'>
								<table align='center' cellpadding='0' cellspacing='0' role='presentation' style='background-color:rgb(255,255,255);border-color:rgb(232,229,239);border-radius:2px;border-width:1px;margin:0px auto;padding:0px;max-width:570px'>
									<tbody>
									<tr>
										<td style='padding:10px 0px;text-align:center'>&nbsp;
											<table cellpadding='0' cellspacing='0' role='presentation' style='text-align:center;width:100%;max-width:250px;margin:auto'>
												<tbody>
													<tr>
														<td style='padding:5px' valign='middle'>
															<a href='$baseUrl' style='text-decoration:none;color:rgb(61,72,82);font-size:1.6em;font-weight:bold;display:inline-block;text-align:right' target='_blank'>
																<img src='$EMAIL_TEMPLATE_LOGO' style='
																max-width:100%;
																max-height:100% !important;
																width: $EMAIL_TEMPLATE_LOGO_WIDTH;
																height: $EMAIL_TEMPLATE_LOGO_HEIGHT;
																display:block' 
																class='CToWUd' data-bit='iit' jslog='138226; u014N:xr6bB; 53:WzAsMl0.'>
															</a>
														</td>
														
													</tr>
												</tbody>
												</table>     
										</td>
									</tr>
									<tr>
										<td style='max-width:100vw;padding:0px 20px 32px'>
										
											<table width='100%' cellpadding='0' cellspacing='0' role='presentation' style='text-align:center;background-color: $EMAIL_TEMPLATE_THANK_YOU_BACKGROUND;'>
												<tbody>
												<tr>
													<td style='padding:16px'>
														<p style='margin:0px;line-height:1.5em;padding-bottom:0px;font-size:1.3em'>
															<span style='color:inherit;text-decoration:none;text-transform:uppercase;font-weight:bold;color: $EMAIL_TEMPLATE_THANK_YOU_TEXT_COLOR'>Thank You For Joining</span>
														</p>
													</td>
												</tr>
												</tbody>
											</table>
											<p style='margin-top:0'>
												<img width='100%' src='$EMAIL_TEMPLATE_IMAGE' style='font-size:1rem;width:100%;display:block' class='CToWUd a6T' data-bit='iit' tabindex='0'>
											</p>
											<p style='padding-left: 40px; padding-right:40px; text-align:center; font-weight:700; font-size: 1.2rem; margin-top:2em;'>Click on LOGIN button below to login to your account</p>
												<center>	
													<table width='100%' cellpadding='0' cellspacing='0' role='presentation'>
														<tbody>
														<tr>
															<td>
																<table width='100%' cellpadding='0' cellspacing='0' role='presentation'>
			<tbody>
				<tr>
					<td style='padding-top:10px; padding-bottom: 20px; text-align:center'>
						<a href='$baseUrl' style='color: $EMAIL_TEMPLATE_BUTTON_TEXT_COLOR; text-decoration:none;font-weight:bold;background-color: $EMAIL_TEMPLATE_BUTTON_COLOR; padding: 16px;border-radius: 25px;width: 50%;display: inline-block;margin: 0 auto;' target='_blank'>LOGIN</a>
					</td>
				</tr>
			</tbody>
		</table>

															</td>
														</tr>
														</tbody>
													</table>
												</center>
											<br>
											<p style='padding-left: 20px; padding-right:20px; line-height: 1.2;font-size: 16px;color: #000;'>If you’re having trouble clicking the ’’LOGIN’’ button, copy and paste the URL below into your web browser:</p>

										<br>   
											<div style='line-height: 0.3'>
												<p style='padding-left: 20px; padding-right:20px; font-size: 16px;'>
													<b>Login URL:</b><a href='$baseUrl/login' target='_blank' style='text-decoration: none; color: blue;'> $baseUrl/login</a>
												</p>
												<p style='padding-left: 20px; padding-right:20px; font-size: 16px;'>
													<b>Email:</b><a href='mailto:$email' target='_blank' style='text-decoration: none; color: blue;'> $email</a>
												</p>
												<p style='padding-left: 20px; padding-right:20px; font-size: 16px;'>
													<b>Password:</b> $password
												</p>
											</div>

											<br><br>
											
											<div style='padding-left: 20px; padding-right:20px; text-align:center; '>
												<span style='color: #666'>
												In order to receive all our communications in your inbox please add <a href='mailto:$SUPPORT_EMAIL' target='_blank' style='text-decoration: none; color:blue;'>$SUPPORT_EMAIL</a> to your address book and authorize automatic image downloads.
												</span>
											</div>

											<br>
											
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr style='background-color: $EMAIL_TEMPLATE_FOOTER_BACKGROUND'>
							<td>
								<table align='center' cellpadding='0' cellspacing='0' role='presentation' style='margin:0px auto;padding:0px;text-align:center;max-width:570px'>
									<tbody>
									<tr>
										<td align='center' style='max-width:100vw;padding:32px'><p style='line-height:1.5em;color: $EMAIL_TEMPLATE_FOOTER_TEXT_COLOR ;font-size:12px'>
											© $yearNow $domainName. All rights reserved.</p></td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	";

	return wp_mail($email, $subject, $html, email_headers());
}

/**
 * Instraction: change Reply-To based on the email reply availble per site
 */
function email_headers() {
	global $SITE_TITLE, $SUPPORT_EMAIL;

	$headers = array(
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: $SITE_TITLE <$SUPPORT_EMAIL>",
    );

	return $headers;
}

// redirect the admin to dashboard after login
function redirect_to_dashboard() {
    // Check if the user is an administrator
    if (current_user_can('administrator')) {
        // Redirect to the admin dashboard
        wp_redirect(admin_url());
        exit;
    }
}
add_action('wp_login', 'redirect_to_dashboard');

function getRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function get_base_url() {
	$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] 
                === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'];

	return $link;
}

function auth_checking() {
	$final_username = "rsf_create_user";
	$final_password = "$6s3J5blHI4";

	$server_username = $_SERVER['PHP_AUTH_USER'];
	$server_password = $_SERVER['PHP_AUTH_PW'];

	if ($final_username != $server_username || $final_password != $server_password) {
		return false;
	}

	return true;
}

function dump_now($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}