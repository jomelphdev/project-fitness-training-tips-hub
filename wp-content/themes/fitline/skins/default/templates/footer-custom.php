<?php
/**
 * The template to display default site footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */

$fitline_footer_id = fitline_get_custom_footer_id();
$fitline_footer_meta = get_post_meta( $fitline_footer_id, 'trx_addons_options', true );
if ( ! empty( $fitline_footer_meta['margin'] ) ) {
	fitline_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( fitline_prepare_css_value( $fitline_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $fitline_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $fitline_footer_id ) ) ); ?>
						<?php
						$fitline_footer_scheme = fitline_get_theme_option( 'footer_scheme' );
						if ( ! empty( $fitline_footer_scheme ) && ! fitline_is_inherit( $fitline_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $fitline_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'fitline_action_show_layout', $fitline_footer_id );
	?>
</footer><!-- /.footer_wrap -->
