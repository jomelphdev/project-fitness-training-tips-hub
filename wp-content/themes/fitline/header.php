<?php
/**
 * The Header: Logo and main menu
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( fitline_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'fitline_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'fitline_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('fitline_action_body_wrap_attributes'); ?>>

		<?php do_action( 'fitline_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'fitline_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('fitline_action_page_wrap_attributes'); ?>>

			<?php do_action( 'fitline_action_page_wrap_start' ); ?>

			<?php
			$fitline_full_post_loading = ( fitline_is_singular( 'post' ) || fitline_is_singular( 'attachment' ) ) && fitline_get_value_gp( 'action' ) == 'full_post_loading';
			$fitline_prev_post_loading = ( fitline_is_singular( 'post' ) || fitline_is_singular( 'attachment' ) ) && fitline_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $fitline_full_post_loading && ! $fitline_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="fitline_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fitline_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'fitline' ); ?></a>
				<?php if ( fitline_sidebar_present() ) { ?>
				<a class="fitline_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fitline_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'fitline' ); ?></a>
				<?php } ?>
				<a class="fitline_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'fitline_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'fitline' ); ?></a>

				<?php
				do_action( 'fitline_action_before_header' );

				// Header
				$fitline_header_type = fitline_get_theme_option( 'header_type' );
				if ( 'custom' == $fitline_header_type && ! fitline_is_layouts_available() ) {
					$fitline_header_type = 'default';
				}
				get_template_part( apply_filters( 'fitline_filter_get_template_part', "templates/header-" . sanitize_file_name( $fitline_header_type ) ) );

				// Side menu
				if ( in_array( fitline_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'fitline_action_after_header' );

			}
			?>

			<?php do_action( 'fitline_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( fitline_is_off( fitline_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $fitline_header_type ) ) {
						$fitline_header_type = fitline_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $fitline_header_type && fitline_is_layouts_available() ) {
						$fitline_header_id = fitline_get_custom_header_id();
						if ( $fitline_header_id > 0 ) {
							$fitline_header_meta = fitline_get_custom_layout_meta( $fitline_header_id );
							if ( ! empty( $fitline_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$fitline_footer_type = fitline_get_theme_option( 'footer_type' );
					if ( 'custom' == $fitline_footer_type && fitline_is_layouts_available() ) {
						$fitline_footer_id = fitline_get_custom_footer_id();
						if ( $fitline_footer_id ) {
							$fitline_footer_meta = fitline_get_custom_layout_meta( $fitline_footer_id );
							if ( ! empty( $fitline_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'fitline_action_page_content_wrap_class', $fitline_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'fitline_filter_is_prev_post_loading', $fitline_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( fitline_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'fitline_action_page_content_wrap_data', $fitline_prev_post_loading );
			?>>
				<?php
				do_action( 'fitline_action_page_content_wrap', $fitline_full_post_loading || $fitline_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'fitline_filter_single_post_header', fitline_is_singular( 'post' ) || fitline_is_singular( 'attachment' ) ) ) {
					if ( $fitline_prev_post_loading ) {
						if ( fitline_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'fitline_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$fitline_path = apply_filters( 'fitline_filter_get_template_part', 'templates/single-styles/' . fitline_get_theme_option( 'single_style' ) );
					if ( fitline_get_file_dir( $fitline_path . '.php' ) != '' ) {
						get_template_part( $fitline_path );
					}
				}

				// Widgets area above page
				$fitline_body_style   = fitline_get_theme_option( 'body_style' );
				$fitline_widgets_name = fitline_get_theme_option( 'widgets_above_page' );
				$fitline_show_widgets = ! fitline_is_off( $fitline_widgets_name ) && is_active_sidebar( $fitline_widgets_name );
				if ( $fitline_show_widgets ) {
					if ( 'fullscreen' != $fitline_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					fitline_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $fitline_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'fitline_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $fitline_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'fitline_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'fitline_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="fitline_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( fitline_is_singular( 'post' ) || fitline_is_singular( 'attachment' ) )
							&& $fitline_prev_post_loading 
							&& fitline_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'fitline_action_between_posts' );
						}

						// Widgets area above content
						fitline_create_widgets_area( 'widgets_above_content' );

						do_action( 'fitline_action_page_content_start_text' );
