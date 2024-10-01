<?php
/**
 * The template to display default site footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$fitline_footer_scheme = fitline_get_theme_option( 'footer_scheme' );
if ( ! empty( $fitline_footer_scheme ) && ! fitline_is_inherit( $fitline_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fitline_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
