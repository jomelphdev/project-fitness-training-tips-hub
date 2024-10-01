<div class="front_page_section front_page_section_googlemap<?php
	$fitline_scheme = fitline_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $fitline_scheme ) && ! fitline_is_inherit( $fitline_scheme ) ) {
		echo ' scheme_' . esc_attr( $fitline_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fitline_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( fitline_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fitline_css      = '';
		$fitline_bg_image = fitline_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$fitline_anchor_icon = fitline_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$fitline_anchor_text = fitline_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $fitline_anchor_icon ) || ! empty( $fitline_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $fitline_anchor_icon ) ? ' icon="' . esc_attr( $fitline_anchor_icon ) . '"' : '' )
									. ( ! empty( $fitline_anchor_text ) ? ' title="' . esc_attr( $fitline_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$fitline_layout = fitline_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $fitline_layout );
		if ( fitline_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' fitline-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$fitline_css      = '';
			$fitline_bg_mask  = fitline_get_theme_option( 'front_page_googlemap_bg_mask' );
			$fitline_bg_color_type = fitline_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $fitline_bg_color_type ) {
				$fitline_bg_color = fitline_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $fitline_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$fitline_caption     = fitline_get_theme_option( 'front_page_googlemap_caption' );
			$fitline_description = fitline_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $fitline_caption ) || ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $fitline_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $fitline_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $fitline_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $fitline_caption, 'fitline_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $fitline_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $fitline_description ), 'fitline_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $fitline_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$fitline_content = fitline_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $fitline_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $fitline_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $fitline_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $fitline_content, 'fitline_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $fitline_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $fitline_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! fitline_exists_trx_addons() ) {
						fitline_customizer_need_trx_addons_message();
					} else {
						fitline_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $fitline_layout && ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
