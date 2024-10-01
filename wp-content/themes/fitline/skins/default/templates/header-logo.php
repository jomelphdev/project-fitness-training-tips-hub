<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_args = get_query_var( 'fitline_logo_args' );

// Site logo
$fitline_logo_type   = isset( $fitline_args['type'] ) ? $fitline_args['type'] : '';
$fitline_logo_image  = fitline_get_logo_image( $fitline_logo_type );
$fitline_logo_text   = fitline_is_on( fitline_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$fitline_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $fitline_logo_image['logo'] ) || ! empty( $fitline_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $fitline_logo_image['logo'] ) ) {
			if ( empty( $fitline_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($fitline_logo_image['logo']) && (int) $fitline_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$fitline_attr = fitline_getimagesize( $fitline_logo_image['logo'] );
				echo '<img src="' . esc_url( $fitline_logo_image['logo'] ) . '"'
						. ( ! empty( $fitline_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $fitline_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $fitline_logo_text ) . '"'
						. ( ! empty( $fitline_attr[3] ) ? ' ' . wp_kses_data( $fitline_attr[3] ) : '' )
						. '>';
			}
		} else {
			fitline_show_layout( fitline_prepare_macros( $fitline_logo_text ), '<span class="logo_text">', '</span>' );
			fitline_show_layout( fitline_prepare_macros( $fitline_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
