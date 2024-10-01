<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package FITLINE
 * @since FITLINE 1.0.06
 */

$fitline_header_css   = '';
$fitline_header_image = get_header_image();
$fitline_header_video = fitline_get_header_video();
if ( ! empty( $fitline_header_image ) && fitline_trx_addons_featured_image_override( is_singular() || fitline_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$fitline_header_image = fitline_get_current_mode_image( $fitline_header_image );
}

$fitline_header_id = fitline_get_custom_header_id();
$fitline_header_meta = get_post_meta( $fitline_header_id, 'trx_addons_options', true );
if ( ! empty( $fitline_header_meta['margin'] ) ) {
	fitline_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( fitline_prepare_css_value( $fitline_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $fitline_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $fitline_header_id ) ) ); ?>
				<?php
				echo ! empty( $fitline_header_image ) || ! empty( $fitline_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'fitline_action_show_layout', $fitline_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
