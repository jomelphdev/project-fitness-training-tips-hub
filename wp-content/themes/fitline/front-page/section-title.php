<?php
$fitline_slider_sc = fitline_get_theme_option( 'front_page_title_shortcode' );
if ( ! empty( $fitline_slider_sc ) && strpos( $fitline_slider_sc, '[' ) !== false && strpos( $fitline_slider_sc, ']' ) !== false ) {

	?><div class="front_page_section front_page_section_title front_page_section_slider front_page_section_title_slider
		<?php
		if ( fitline_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
	">
	<?php
		// Add anchor
		$fitline_anchor_icon = fitline_get_theme_option( 'front_page_title_anchor_icon' );
		$fitline_anchor_text = fitline_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $fitline_anchor_icon ) || ! empty( $fitline_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $fitline_anchor_icon ) ? ' icon="' . esc_attr( $fitline_anchor_icon ) . '"' : '' )
									. ( ! empty( $fitline_anchor_text ) ? ' title="' . esc_attr( $fitline_anchor_text ) . '"' : '' )
									. ']'
		);
	}
		// Show slider (or any other content, generated by shortcode)
		echo do_shortcode( $fitline_slider_sc );
	?>
	</div>
	<?php

} else {

	?>
	<div class="front_page_section front_page_section_title
		<?php
		$fitline_scheme = fitline_get_theme_option( 'front_page_title_scheme' );
		if ( ! empty( $fitline_scheme ) && ! fitline_is_inherit( $fitline_scheme ) ) {
			echo ' scheme_' . esc_attr( $fitline_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( fitline_get_theme_option( 'front_page_title_paddings' ) );
		if ( fitline_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
		"
		<?php
		$fitline_css      = '';
		$fitline_bg_image = fitline_get_theme_option( 'front_page_title_bg_image' );
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
		$fitline_anchor_icon = fitline_get_theme_option( 'front_page_title_anchor_icon' );
		$fitline_anchor_text = fitline_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $fitline_anchor_icon ) || ! empty( $fitline_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $fitline_anchor_icon ) ? ' icon="' . esc_attr( $fitline_anchor_icon ) . '"' : '' )
									. ( ! empty( $fitline_anchor_text ) ? ' title="' . esc_attr( $fitline_anchor_text ) . '"' : '' )
									. ']'
		);
	}
	?>
		<div class="front_page_section_inner front_page_section_title_inner
		<?php
		if ( fitline_get_theme_option( 'front_page_title_fullheight' ) ) {
			echo ' fitline-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
			"
			<?php
			$fitline_css      = '';
			$fitline_bg_mask  = fitline_get_theme_option( 'front_page_title_bg_mask' );
			$fitline_bg_color_type = fitline_get_theme_option( 'front_page_title_bg_color_type' );
			if ( 'custom' == $fitline_bg_color_type ) {
				$fitline_bg_color = fitline_get_theme_option( 'front_page_title_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_title_content_wrap content_wrap">
				<?php
				// Caption
				$fitline_caption = fitline_get_theme_option( 'front_page_title_caption' );
				if ( ! empty( $fitline_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h1 class="front_page_section_caption front_page_section_title_caption front_page_block_<?php echo ! empty( $fitline_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $fitline_caption, 'fitline_kses_content' ); ?></h1>
					<?php
				}

				// Description (text)
				$fitline_description = fitline_get_theme_option( 'front_page_title_description' );
				if ( ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_title_description front_page_block_<?php echo ! empty( $fitline_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $fitline_description ), 'fitline_kses_content' ); ?></div>
					<?php
				}

				// Buttons
				if ( fitline_get_theme_option( 'front_page_title_button1_link' ) != '' || fitline_get_theme_option( 'front_page_title_button2_link' ) != '' ) {
					?>
					<div class="front_page_section_buttons front_page_section_title_buttons">
					<?php
						fitline_show_layout( fitline_customizer_partial_refresh_front_page_title_button1_link() );
						fitline_show_layout( fitline_customizer_partial_refresh_front_page_title_button2_link() );
					?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
