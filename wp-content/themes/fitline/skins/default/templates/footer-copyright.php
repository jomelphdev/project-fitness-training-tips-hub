<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$fitline_copyright_scheme = fitline_get_theme_option( 'copyright_scheme' );
if ( ! empty( $fitline_copyright_scheme ) && ! fitline_is_inherit( $fitline_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fitline_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$fitline_copyright = fitline_get_theme_option( 'copyright' );
			if ( ! empty( $fitline_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$fitline_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $fitline_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$fitline_copyright = fitline_prepare_macros( $fitline_copyright );
				// Display copyright
				echo wp_kses( nl2br( $fitline_copyright ), 'fitline_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
