<?php
/**
 * The template to display Admin notices
 *
 * @package FITLINE
 * @since FITLINE 1.0.1
 */

$fitline_theme_slug = get_option( 'template' );
$fitline_theme_obj  = wp_get_theme( $fitline_theme_slug );
?>
<div class="fitline_admin_notice fitline_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$fitline_theme_img = fitline_get_file_url( 'screenshot.jpg' );
	if ( '' != $fitline_theme_img ) {
		?>
		<div class="fitline_notice_image"><img src="<?php echo esc_url( $fitline_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'fitline' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="fitline_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'fitline' ),
				$fitline_theme_obj->get( 'Name' ) . ( FITLINE_THEME_FREE ? ' ' . __( 'Free', 'fitline' ) : '' ),
				$fitline_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="fitline_notice_text">
		<p class="fitline_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $fitline_theme_obj->description ) );
			?>
		</p>
		<p class="fitline_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'fitline' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="fitline_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=fitline_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'fitline' );
			?>
		</a>
	</div>
</div>
