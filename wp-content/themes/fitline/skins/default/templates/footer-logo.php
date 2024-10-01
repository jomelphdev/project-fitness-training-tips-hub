<?php
/**
 * The template to display the site logo in the footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */

// Logo
if ( fitline_is_on( fitline_get_theme_option( 'logo_in_footer' ) ) ) {
	$fitline_logo_image = fitline_get_logo_image( 'footer' );
	$fitline_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $fitline_logo_image['logo'] ) || ! empty( $fitline_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $fitline_logo_image['logo'] ) ) {
					$fitline_attr = fitline_getimagesize( $fitline_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $fitline_logo_image['logo'] ) . '"'
								. ( ! empty( $fitline_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fitline_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'fitline' ) . '"'
								. ( ! empty( $fitline_attr[3] ) ? ' ' . wp_kses_data( $fitline_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $fitline_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $fitline_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
