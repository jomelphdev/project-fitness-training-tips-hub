<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

// Page (category, tag, archive, author) title

if ( fitline_need_page_title() ) {
	fitline_sc_layouts_showed( 'title', true );
	fitline_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								fitline_show_post_meta(
									apply_filters(
										'fitline_filter_post_meta_args', array(
											'components' => join( ',', fitline_array_get_keys_by_value( fitline_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', fitline_array_get_keys_by_value( fitline_get_theme_option( 'counters' ) ) ),
											'seo'        => fitline_is_on( fitline_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$fitline_blog_title           = fitline_get_blog_title();
							$fitline_blog_title_text      = '';
							$fitline_blog_title_class     = '';
							$fitline_blog_title_link      = '';
							$fitline_blog_title_link_text = '';
							if ( is_array( $fitline_blog_title ) ) {
								$fitline_blog_title_text      = $fitline_blog_title['text'];
								$fitline_blog_title_class     = ! empty( $fitline_blog_title['class'] ) ? ' ' . $fitline_blog_title['class'] : '';
								$fitline_blog_title_link      = ! empty( $fitline_blog_title['link'] ) ? $fitline_blog_title['link'] : '';
								$fitline_blog_title_link_text = ! empty( $fitline_blog_title['link_text'] ) ? $fitline_blog_title['link_text'] : '';
							} else {
								$fitline_blog_title_text = $fitline_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $fitline_blog_title_class ); ?>">
								<?php
								$fitline_top_icon = fitline_get_term_image_small();
								if ( ! empty( $fitline_top_icon ) ) {
									$fitline_attr = fitline_getimagesize( $fitline_top_icon );
									?>
									<img src="<?php echo esc_url( $fitline_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'fitline' ); ?>"
										<?php
										if ( ! empty( $fitline_attr[3] ) ) {
											fitline_show_layout( $fitline_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $fitline_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $fitline_blog_title_link ) && ! empty( $fitline_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $fitline_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $fitline_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'fitline_action_breadcrumbs' );
						$fitline_breadcrumbs = ob_get_contents();
						ob_end_clean();
						fitline_show_layout( $fitline_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
