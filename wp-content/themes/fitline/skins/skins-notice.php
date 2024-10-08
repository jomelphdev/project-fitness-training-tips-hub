<?php
/**
 * The template to display Admin notices
 *
 * @package FITLINE
 * @since FITLINE 1.0.64
 */

$fitline_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$fitline_skins_args = get_query_var( 'fitline_skins_notice_args' );
?>
<div class="fitline_admin_notice fitline_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins available', 'fitline' ); ?>
	</h3>
	<?php

	// Description
	$fitline_total      = $fitline_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$fitline_skins_msg  = $fitline_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $fitline_total, 'fitline' ), $fitline_total ) . '</strong>'
							: '';
	$fitline_total      = $fitline_skins_args['free'];
	$fitline_skins_msg .= $fitline_total > 0
							? ( ! empty( $fitline_skins_msg ) ? ' ' . esc_html__( 'and', 'fitline' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $fitline_total, 'fitline' ), $fitline_total ) . '</strong>'
							: '';
	$fitline_total      = $fitline_skins_args['pay'];
	$fitline_skins_msg .= $fitline_skins_args['pay'] > 0
							? ( ! empty( $fitline_skins_msg ) ? ' ' . esc_html__( 'and', 'fitline' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $fitline_total, 'fitline' ), $fitline_total ) . '</strong>'
							: '';
	?>
	<div class="fitline_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'fitline' ), $fitline_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="fitline_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $fitline_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'fitline' );
			?>
		</a>
	</div>
</div>
