<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

							do_action( 'fitline_action_page_content_end_text' );
							
							// Widgets area below the content
							fitline_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'fitline_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'fitline_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'fitline_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'fitline_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$fitline_body_style = fitline_get_theme_option( 'body_style' );
					$fitline_widgets_name = fitline_get_theme_option( 'widgets_below_page' );
					$fitline_show_widgets = ! fitline_is_off( $fitline_widgets_name ) && is_active_sidebar( $fitline_widgets_name );
					$fitline_show_related = fitline_is_single() && fitline_get_theme_option( 'related_position' ) == 'below_page';
					if ( $fitline_show_widgets || $fitline_show_related ) {
						if ( 'fullscreen' != $fitline_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $fitline_show_related ) {
							do_action( 'fitline_action_related_posts' );
						}

						// Widgets area below page content
						if ( $fitline_show_widgets ) {
							fitline_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $fitline_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'fitline_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'fitline_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! fitline_is_singular( 'post' ) && ! fitline_is_singular( 'attachment' ) ) || ! in_array ( fitline_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="fitline_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'fitline_action_before_footer' );

				// Footer
				$fitline_footer_type = fitline_get_theme_option( 'footer_type' );
				if ( 'custom' == $fitline_footer_type && ! fitline_is_layouts_available() ) {
					$fitline_footer_type = 'default';
				}
				get_template_part( apply_filters( 'fitline_filter_get_template_part', "templates/footer-" . sanitize_file_name( $fitline_footer_type ) ) );

				do_action( 'fitline_action_after_footer' );

			}
			?>

			<?php do_action( 'fitline_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'fitline_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'fitline_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>