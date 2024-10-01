<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package FITLINE
 * @since FITLINE 1.0.10
 */

// Footer sidebar
$fitline_footer_name    = fitline_get_theme_option( 'footer_widgets' );
$fitline_footer_present = ! fitline_is_off( $fitline_footer_name ) && is_active_sidebar( $fitline_footer_name );
if ( $fitline_footer_present ) {
	fitline_storage_set( 'current_sidebar', 'footer' );
	$fitline_footer_wide = fitline_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $fitline_footer_name ) ) {
		dynamic_sidebar( $fitline_footer_name );
	}
	$fitline_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $fitline_out ) ) {
		$fitline_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $fitline_out );
		$fitline_need_columns = true;   //or check: strpos($fitline_out, 'columns_wrap')===false;
		if ( $fitline_need_columns ) {
			$fitline_columns = max( 0, (int) fitline_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $fitline_columns ) {
				$fitline_columns = min( 4, max( 1, fitline_tags_count( $fitline_out, 'aside' ) ) );
			}
			if ( $fitline_columns > 1 ) {
				$fitline_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $fitline_columns ) . ' widget', $fitline_out );
			} else {
				$fitline_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $fitline_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'fitline_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $fitline_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $fitline_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'fitline_action_before_sidebar', 'footer' );
				fitline_show_layout( $fitline_out );
				do_action( 'fitline_action_after_sidebar', 'footer' );
				if ( $fitline_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $fitline_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'fitline_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
