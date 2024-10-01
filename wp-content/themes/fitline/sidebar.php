<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

if ( fitline_sidebar_present() ) {
	
	$fitline_sidebar_type = fitline_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $fitline_sidebar_type && ! fitline_is_layouts_available() ) {
		$fitline_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $fitline_sidebar_type ) {
		// Default sidebar with widgets
		$fitline_sidebar_name = fitline_get_theme_option( 'sidebar_widgets' );
		fitline_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $fitline_sidebar_name ) ) {
			dynamic_sidebar( $fitline_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$fitline_sidebar_id = fitline_get_custom_sidebar_id();
		do_action( 'fitline_action_show_layout', $fitline_sidebar_id );
	}
	$fitline_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $fitline_out ) ) {
		$fitline_sidebar_position    = fitline_get_theme_option( 'sidebar_position' );
		$fitline_sidebar_position_ss = fitline_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $fitline_sidebar_position );
			echo ' sidebar_' . esc_attr( $fitline_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $fitline_sidebar_type );

			$fitline_sidebar_scheme = apply_filters( 'fitline_filter_sidebar_scheme', fitline_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $fitline_sidebar_scheme ) && ! fitline_is_inherit( $fitline_sidebar_scheme ) && 'custom' != $fitline_sidebar_type ) {
				echo ' scheme_' . esc_attr( $fitline_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="fitline_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'fitline_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $fitline_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$fitline_title = apply_filters( 'fitline_filter_sidebar_control_title', 'float' == $fitline_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fitline' ) : '' );
				$fitline_text  = apply_filters( 'fitline_filter_sidebar_control_text', 'above' == $fitline_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'fitline' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $fitline_title ); ?>"><?php echo esc_html( $fitline_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'fitline_action_before_sidebar', 'sidebar' );
				fitline_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fitline_out ) );
				do_action( 'fitline_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'fitline_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
