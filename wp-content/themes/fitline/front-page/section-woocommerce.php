<?php
$fitline_woocommerce_sc = fitline_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $fitline_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$fitline_scheme = fitline_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $fitline_scheme ) && ! fitline_is_inherit( $fitline_scheme ) ) {
			echo ' scheme_' . esc_attr( $fitline_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( fitline_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( fitline_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$fitline_css      = '';
			$fitline_bg_image = fitline_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $fitline_bg_image ) ) {
				$fitline_css .= 'background-image: url(' . esc_url( fitline_get_attachment_url( $fitline_bg_image ) ) . ');';
			}
			if ( ! empty( $fitline_css ) ) {
				echo ' style="' . esc_attr( $fitline_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$fitline_anchor_icon = fitline_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$fitline_anchor_text = fitline_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $fitline_anchor_icon ) || ! empty( $fitline_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $fitline_anchor_icon ) ? ' icon="' . esc_attr( $fitline_anchor_icon ) . '"' : '' )
											. ( ! empty( $fitline_anchor_text ) ? ' title="' . esc_attr( $fitline_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( fitline_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' fitline-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$fitline_css      = '';
				$fitline_bg_mask  = fitline_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$fitline_bg_color_type = fitline_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $fitline_bg_color_type ) {
					$fitline_bg_color = fitline_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $fitline_bg_color_type ) {
					$fitline_bg_color = fitline_get_scheme_color( 'bg_color', $fitline_scheme );
				} else {
					$fitline_bg_color = '';
				}
				if ( ! empty( $fitline_bg_color ) && $fitline_bg_mask > 0 ) {
					$fitline_css .= 'background-color: ' . esc_attr(
						1 == $fitline_bg_mask ? $fitline_bg_color : fitline_hex2rgba( $fitline_bg_color, $fitline_bg_mask )
					) . ';';
				}
				if ( ! empty( $fitline_css ) ) {
					echo ' style="' . esc_attr( $fitline_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$fitline_caption     = fitline_get_theme_option( 'front_page_woocommerce_caption' );
				$fitline_description = fitline_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $fitline_caption ) || ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $fitline_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $fitline_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $fitline_caption, 'fitline_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $fitline_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $fitline_description ), 'fitline_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $fitline_woocommerce_sc ) {
						$fitline_woocommerce_sc_ids      = fitline_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$fitline_woocommerce_sc_per_page = count( explode( ',', $fitline_woocommerce_sc_ids ) );
					} else {
						$fitline_woocommerce_sc_per_page = max( 1, (int) fitline_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$fitline_woocommerce_sc_columns = max( 1, min( $fitline_woocommerce_sc_per_page, (int) fitline_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$fitline_woocommerce_sc}"
										. ( 'products' == $fitline_woocommerce_sc
												? ' ids="' . esc_attr( $fitline_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $fitline_woocommerce_sc
												? ' category="' . esc_attr( fitline_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $fitline_woocommerce_sc
												? ' orderby="' . esc_attr( fitline_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( fitline_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $fitline_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $fitline_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
