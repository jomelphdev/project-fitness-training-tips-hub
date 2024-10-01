<div class="front_page_section front_page_section_contacts<?php
	$fitline_scheme = fitline_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $fitline_scheme ) && ! fitline_is_inherit( $fitline_scheme ) ) {
		echo ' scheme_' . esc_attr( $fitline_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fitline_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( fitline_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fitline_css      = '';
		$fitline_bg_image = fitline_get_theme_option( 'front_page_contacts_bg_image' );
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
	$fitline_anchor_icon = fitline_get_theme_option( 'front_page_contacts_anchor_icon' );
	$fitline_anchor_text = fitline_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $fitline_anchor_icon ) || ! empty( $fitline_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $fitline_anchor_icon ) ? ' icon="' . esc_attr( $fitline_anchor_icon ) . '"' : '' )
									. ( ! empty( $fitline_anchor_text ) ? ' title="' . esc_attr( $fitline_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( fitline_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' fitline-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$fitline_css      = '';
			$fitline_bg_mask  = fitline_get_theme_option( 'front_page_contacts_bg_mask' );
			$fitline_bg_color_type = fitline_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $fitline_bg_color_type ) {
				$fitline_bg_color = fitline_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$fitline_caption     = fitline_get_theme_option( 'front_page_contacts_caption' );
			$fitline_description = fitline_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $fitline_caption ) || ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $fitline_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $fitline_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $fitline_caption, 'fitline_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $fitline_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $fitline_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $fitline_description ), 'fitline_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$fitline_content = fitline_get_theme_option( 'front_page_contacts_content' );
			$fitline_layout  = fitline_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $fitline_layout && ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $fitline_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $fitline_content, 'fitline_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $fitline_layout && ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$fitline_sc = fitline_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $fitline_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $fitline_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					fitline_show_layout( do_shortcode( $fitline_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $fitline_layout && ( ! empty( $fitline_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
