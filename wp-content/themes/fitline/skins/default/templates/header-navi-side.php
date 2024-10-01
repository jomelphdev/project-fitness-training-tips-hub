<?php
/**
 * The template to display the side menu
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */
?>
<div class="menu_side_wrap
<?php
echo ' menu_side_' . esc_attr( fitline_get_theme_option( 'menu_side_icons' ) > 0 ? 'icons' : 'dots' );
$fitline_menu_scheme = fitline_get_theme_option( 'menu_scheme' );
$fitline_header_scheme = fitline_get_theme_option( 'header_scheme' );
if ( ! empty( $fitline_menu_scheme ) && ! fitline_is_inherit( $fitline_menu_scheme  ) ) {
	echo ' scheme_' . esc_attr( $fitline_menu_scheme );
} elseif ( ! empty( $fitline_header_scheme ) && ! fitline_is_inherit( $fitline_header_scheme ) ) {
	echo ' scheme_' . esc_attr( $fitline_header_scheme );
}
?>
				">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		set_query_var( 'fitline_logo_args', array( 'type' => 'side' ) );
		get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'fitline_logo_args', array() );
		// Main menu button
		?>
		<div class="toc_menu_item"
			<?php
			if ( fitline_mouse_helper_enabled() ) {
				echo ' data-mouse-helper="click" data-mouse-helper-axis="y" data-mouse-helper-text="' . esc_attr__( 'Open main menu', 'fitline' ) . '"';
			}
			?>
		>
			<a href="#" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e( 'Main menu', 'fitline' ); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#"></a>
		</div>		
	</div>

</div><!-- /.menu_side_wrap -->
