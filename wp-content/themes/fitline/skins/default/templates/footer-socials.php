<?php
/**
 * The template to display the socials in the footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */


// Socials
if ( fitline_is_on( fitline_get_theme_option( 'socials_in_footer' ) ) ) {
	$fitline_output = fitline_get_socials_links();
	if ( '' != $fitline_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php fitline_show_layout( $fitline_output ); ?>
			</div>
		</div>
		<?php
	}
}
