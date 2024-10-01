<?php
/**
 * The template to display default site header
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_header_css   = '';
$fitline_header_image = get_header_image();
$fitline_header_video = fitline_get_header_video();
if ( ! empty( $fitline_header_image ) && fitline_trx_addons_featured_image_override( is_singular() || fitline_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$fitline_header_image = fitline_get_current_mode_image( $fitline_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $fitline_header_image ) || ! empty( $fitline_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $fitline_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $fitline_header_image ) {
		echo ' ' . esc_attr( fitline_add_inline_css_class( 'background-image: url(' . esc_url( $fitline_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( fitline_is_on( fitline_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight fitline-full-height';
	}
	$fitline_header_scheme = fitline_get_theme_option( 'header_scheme' );
	if ( ! empty( $fitline_header_scheme ) && ! fitline_is_inherit( $fitline_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $fitline_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $fitline_header_video ) ) {
		get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( fitline_is_on( fitline_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
