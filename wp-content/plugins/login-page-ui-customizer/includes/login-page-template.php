<?php
/**
 * Template Name: Login Page Customizer Template
 *
 * Page Template to preview the WordPress login page in the Customizer.
 *
 * @package CR_Login_Page_UI_Customizer
 * @author Suresh Shinde
 */

$crlpuic_settings = get_option( CRLPUIC_SLUG );

/**
 * Fires when the login form is initialized.
 */
do_action( 'login_init' );

/**
 * Fires before a specified login form action.
 */
do_action( 'login_form_login' );
do_action( 'login_form_register' );

/**
 * Filters the separator used between login form navigation links.
 *
 * @since 4.9.0
 *
 * @param string $login_link_separator The separator used between login form navigation links.
 */
$login_link_separator = apply_filters( 'login_link_separator', ' | ' );
$login_page_title     = get_bloginfo( 'name', 'display' );

/* translators: Login screen title. 1: Login screen name, 2: Network or site name. */
$login_page_title = sprintf( __( '%1$s &lsaquo; %2$s', 'login-page-ui-customizer' ), $title, $login_page_title );

/**
 * Filters the title tag content for login page.
 *
 * @since 4.9.0
 *
 * @param string $login_page_title The page title, with extra context added.
 * @param string $title       The original page title.
 */
$new_login_title = apply_filters( 'login_title', $login_page_title, $title );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<title><?php echo esc_html( $new_login_title ); ?></title>
	<?php
	wp_enqueue_style( 'login' );

	/**
	 * Enqueue scripts and styles for the login page.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_enqueue_scripts' );

	/**
	 * Fires in the login page header after scripts are enqueued.
	 *
	 * @since 2.1.0
	 */
	do_action( 'login_head' );
	?>
	<style>
		/* Astra & FosterX: Compatability at customizer preview. */
		#btn-go-to-top,
		#ast-mobile-popup-wrapper,
		#astra-mobile-cart-drawer,
		#astra-mobile-cart-overlay {
			display:none;
		}
	</style>
</head>

<?php

$login_header_url = site_url();

/**
 * Filters link URL of the header logo above login form.
 *
 * @since 2.1.0
 *
 * @param string $login_header_url Login header logo URL.
 */
$login_header_url = apply_filters( 'login_headerurl', $login_header_url );

// Logo title/text.
$logo_text = get_bloginfo( 'name', 'display' );

global $wp_version;

if ( version_compare( $wp_version, '5.2.0', '<' ) ) {
	/**
	 * Filters the title attribute of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $logo_text Login header logo title attribute.
	 */
	$logo_text = apply_filters( 'login_headertitle', $logo_text );

} else {

	/**
	 * Filters the title attribute of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $logo_text Login header logo title attribute.
	 */
	$logo_text = apply_filters( 'login_headertext', $logo_text );

}

$classes   = array( 'login-action-login', 'wp-core-ui' );
$classes[] = ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

/**
 * Filters the login page body classes.
 *
 * @since 3.5.0
 *
 * @param array  $classes An array of body classes.
 */
$classes = apply_filters( 'login_body_class', $classes, 'login' );
?>

<body class="login <?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php
	/**
	 * Fires in the login page header after the body tag is opened.
	 *
	 * @since 4.6.0
	 */
	do_action( 'login_header' );

	?>

	<div id="login">

		<h1><span id="crlpuic-logo" class="crlpuic-preview-event" data-section="crlpuic_logo_section"><span class="dashicons dashicons-edit logo-edit"></span></span>
			<a id="crlpuic-logo-link" href="<?php echo esc_url( $login_header_url ); ?>" title="<?php echo esc_attr( $logo_text ); ?>" data-bg-img="<?php echo esc_url( $crlpuic_settings['custom_logo'] ); ?>" tabindex="-1">

				<span id="title-text"><?php echo esc_attr( $logo_text ); ?></span>
			</a>
		</h1>

		<form name="loginform" class="crlpuic-enable-login" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
			<div id="crlpuic-loginform" class="crlpuic-preview-event" data-section="crlpuic_login_form_section"><span class="dashicons dashicons-edit form-edit"></span></div>
			<p>
				<label for="user_login"><span id="crlpuic-username-label"><?php esc_html_e( 'Username or Email Address', 'login-page-ui-customizer' ); ?></span><br />
				<input type="text" name="log" id="user_login" class="input" value="<?php echo esc_attr( $user_login ); ?>" size="20" /></label>
			</p>
			<p>
				<label for="user_pass"><span id="crlpuic-password-label"><?php esc_html_e( 'Password', 'login-page-ui-customizer' ); ?></span><br />
				<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
			</p>
			<?php
			/**
			 * Fires following the 'Password' field in the login form.
			 *
			 * @since 2.1.0
			 */
			do_action( 'login_form' );
			?>
			<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span id="crlpuic-rememberme-label"><?php esc_html_e( 'Remember Me', 'login-page-ui-customizer' ); ?></span></label></p>
			<p class="submit"><input type="submit" name="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Log In', 'login-page-ui-customizer' ); ?>" /></p>
		</form>

		<form name="registerform" style="display:none" class="crlpuic-enable-register" id="registerform" action="<?php echo esc_url( wp_registration_url() ); ?>" method="post">
			<p>
				<label for="user_register"><span id="crlpuic-register-username-label"><?php esc_html_e( 'Username', 'login-page-ui-customizer' ); ?></span><br />
					<input type="text" name="log" id="user_register" class="input" value="<?php echo esc_attr( $user_login ); ?>" size="20" /></label>
			</p>
			<p>
				<label for="user_email"><span id="crlpuic-register-email-label"><?php esc_html_e( 'Email', 'login-page-ui-customizer' ); ?></span><br />
					<input type="email" name="email" id="user_email" class="input" value="" size="20" /></label>
			</p>
			<?php
			/**
			 * Fires following the 'Password' field in the login form.
			 *
			 * @since 2.1.0
			 */
			do_action( 'login_form' );
			?>
			<p id="reg_passmail"><?php esc_html_e( 'Registration confirmation will be emailed to you.', 'login-page-ui-customizer' ); ?></p>
			<p class="submit"><input type="submit" name="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Register', 'login-page-ui-customizer' ); ?>" /></p>
		</form>

		<form style="display:none;" class="crlpuic-enable-lostpassword" name="lostpasswordform" id="lostpasswordform" action="" method="post">
			<p>
				<label for="user_login" ><span><?php esc_html_e( 'Username or Email Address', 'login-page-ui-customizer' ); ?></span><br />
				<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( $user_login ); ?>" size="20" autocapitalize="off" /></label>
			</p>
			<?php
			/**
			 * Fires inside the lostpassword form tags, before the hidden fields.
			 *
			 * @since 2.1.0
			 */
			do_action( 'lostpassword_form' );
			?>
			<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Get New Password', 'login-page-ui-customizer' ); ?>" /></p>
		</form>

		<p id="nav">
			<?php
			if ( get_option( 'users_can_register' ) ) :
				$registration_url = sprintf( '<a id="register-link-label" href="%s" class="crlpuic-enable-login crlpuic-enable-lostpassword">%s</a>', esc_url( wp_registration_url() ), $crlpuic_settings['register_link_label'] );

				/** This filter is documented in wp-includes/general-template.php */
				echo wp_kses_post( apply_filters( 'register', $registration_url ) );

				echo '<span style="display:none" class="crlpuic-enable-lostpassword">' . esc_html( $login_link_separator ) . '</span>';

				echo '<a href="#" id="login-link-label" class="crlpuic-enable-register crlpuic-enable-lostpassword" style="display:none">' . esc_html( $crlpuic_settings['login_link_label'] ) . '</a>';

				echo '<span class="crlpuic-enable-register crlpuic-enable-login">' . esc_html( $login_link_separator ) . '</span>';
			endif;
			?>
			<a class="crlpuic-enable-register crlpuic-enable-login" href="<?php echo esc_url( wp_lostpassword_url() ); ?>" id="crlpuic-lost-password-text"><?php esc_html_e( 'Lost your password?', 'login-page-ui-customizer' ); ?></a>
		</p>
		<p id="backtoblog">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span  id="crlpuic-back-to-text">
					<?php

					if ( isset( $crlpuic_settings['back_to_website'] ) ) {
						$back_to_website = str_replace( '{site_title}', get_bloginfo(), $crlpuic_settings['back_to_website'] );
						echo esc_html( $back_to_website );
					} else {
						esc_html_e( '&larr; Back to', 'login-page-ui-customizer' );
						echo esc_html( get_bloginfo( 'title', 'display' ) );
					}

					?>
				</span>
			</a>
		</p>
	</div>

	<?php do_action( 'login_footer' ); ?>
	<div class="clear"></div>
	<?php
	wp_footer();
	?>
</body>

</html>
