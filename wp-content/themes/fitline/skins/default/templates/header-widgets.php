<?php
/**
 * The template to display the widgets area in the header
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

// Header sidebar
$fitline_header_name    = fitline_get_theme_option( 'header_widgets' );
$fitline_header_present = ! fitline_is_off( $fitline_header_name ) && is_active_sidebar( $fitline_header_name );
if ( $fitline_header_present ) {
	fitline_storage_set( 'current_sidebar', 'header' );
	$fitline_header_wide = fitline_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $fitline_header_name ) ) {
		dynamic_sidebar( $fitline_header_name );
	}
	$fitline_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $fitline_widgets_output ) ) {
		$fitline_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $fitline_widgets_output );
		$fitline_need_columns   = strpos( $fitline_widgets_output, 'columns_wrap' ) === false;
		if ( $fitline_need_columns ) {
			$fitline_columns = max( 0, (int) fitline_get_theme_option( 'header_columns' ) );
			if ( 0 == $fitline_columns ) {
				$fitline_columns = min( 6, max( 1, fitline_tags_count( $fitline_widgets_output, 'aside' ) ) );
			}
			if ( $fitline_columns > 1 ) {
				$fitline_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fitline_columns ) . ' widget', $fitline_widgets_output );
			} else {
				$fitline_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $fitline_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'fitline_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $fitline_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fitline_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fitline_action_before_sidebar', 'header' );
				fitline_show_layout( $fitline_widgets_output );
				do_action( 'fitline_action_after_sidebar', 'header' );
				if ( $fitline_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fitline_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'fitline_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
