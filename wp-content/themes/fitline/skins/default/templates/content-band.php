<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FITLINE
 * @since FITLINE 1.71.0
 */

$fitline_template_args = get_query_var( 'fitline_template_args' );
if ( ! is_array( $fitline_template_args ) ) {
	$fitline_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$fitline_columns       = 1;

$fitline_expanded      = ! fitline_sidebar_present() && fitline_get_theme_option( 'expand_content' ) == 'expand';

$fitline_post_format   = get_post_format();
$fitline_post_format   = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );

if ( is_array( $fitline_template_args ) ) {
	$fitline_columns    = empty( $fitline_template_args['columns'] ) ? 1 : max( 1, $fitline_template_args['columns'] );
	$fitline_blog_style = array( $fitline_template_args['type'], $fitline_columns );
	if ( ! empty( $fitline_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $fitline_columns > 1 ) {
	    $fitline_columns_class = fitline_get_column_class( 1, $fitline_columns, ! empty( $fitline_template_args['columns_tablet']) ? $fitline_template_args['columns_tablet'] : '', ! empty($fitline_template_args['columns_mobile']) ? $fitline_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $fitline_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $fitline_post_format ) );
	fitline_add_blog_animation( $fitline_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$fitline_hover      = ! empty( $fitline_template_args['hover'] ) && ! fitline_is_inherit( $fitline_template_args['hover'] )
							? $fitline_template_args['hover']
							: fitline_get_theme_option( 'image_hover' );
	$fitline_components = ! empty( $fitline_template_args['meta_parts'] )
							? ( is_array( $fitline_template_args['meta_parts'] )
								? $fitline_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $fitline_template_args['meta_parts'] ) )
								)
							: fitline_array_get_keys_by_value( fitline_get_theme_option( 'meta_parts' ) );
	fitline_show_post_featured( apply_filters( 'fitline_filter_args_featured',
		array(
			'no_links'   => ! empty( $fitline_template_args['no_links'] ),
			'hover'      => $fitline_hover,
			'meta_parts' => $fitline_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $fitline_template_args['thumb_size'] )
								? $fitline_template_args['thumb_size']
								: fitline_get_thumb_size( 
								in_array( $fitline_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $fitline_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$fitline_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$fitline_show_title = get_the_title() != '';
		$fitline_show_meta  = count( $fitline_components ) > 0 && ! in_array( $fitline_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $fitline_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'fitline_filter_show_blog_categories', $fitline_show_meta && in_array( 'categories', $fitline_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'fitline_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						fitline_show_post_meta( apply_filters(
															'fitline_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $fitline_hover, 1
															)
											);
						?>
					</div>
					<?php
					$fitline_components = fitline_array_delete_by_value( $fitline_components, 'categories' );
					do_action( 'fitline_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'fitline_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'fitline_action_before_post_title' );
					if ( empty( $fitline_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'fitline_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $fitline_template_args['excerpt_length'] ) && ! in_array( $fitline_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$fitline_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'fitline_filter_show_blog_excerpt', empty( $fitline_template_args['hide_excerpt'] ) && fitline_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				fitline_show_post_content( $fitline_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'fitline_filter_show_blog_meta', $fitline_show_meta, $fitline_components, 'band' ) ) {
			if ( count( $fitline_components ) > 0 ) {
				do_action( 'fitline_action_before_post_meta' );
				fitline_show_post_meta(
					apply_filters(
						'fitline_filter_post_meta_args', array(
							'components' => join( ',', $fitline_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'fitline_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'fitline_filter_show_blog_readmore', ! $fitline_show_title || ! empty( $fitline_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $fitline_template_args['no_links'] ) ) {
				do_action( 'fitline_action_before_post_readmore' );
				fitline_show_post_more_link( $fitline_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'fitline_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $fitline_template_args ) ) {
	if ( ! empty( $fitline_template_args['slider'] ) || $fitline_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
