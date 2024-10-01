<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_template_args = get_query_var( 'fitline_template_args' );

if ( is_array( $fitline_template_args ) ) {
	$fitline_columns    = empty( $fitline_template_args['columns'] ) ? 2 : max( 1, $fitline_template_args['columns'] );
	$fitline_blog_style = array( $fitline_template_args['type'], $fitline_columns );
    $fitline_columns_class = fitline_get_column_class( 1, $fitline_columns, ! empty( $fitline_template_args['columns_tablet']) ? $fitline_template_args['columns_tablet'] : '', ! empty($fitline_template_args['columns_mobile']) ? $fitline_template_args['columns_mobile'] : '' );
} else {
	$fitline_template_args = array();
	$fitline_blog_style = explode( '_', fitline_get_theme_option( 'blog_style' ) );
	$fitline_columns    = empty( $fitline_blog_style[1] ) ? 2 : max( 1, $fitline_blog_style[1] );
    $fitline_columns_class = fitline_get_column_class( 1, $fitline_columns );
}
$fitline_expanded   = ! fitline_sidebar_present() && fitline_get_theme_option( 'expand_content' ) == 'expand';

$fitline_post_format = get_post_format();
$fitline_post_format = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );

?><div class="<?php
	if ( ! empty( $fitline_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( fitline_is_blog_style_use_masonry( $fitline_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fitline_columns ) : esc_attr( $fitline_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fitline_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $fitline_columns )
				. ' post_layout_' . esc_attr( $fitline_blog_style[0] )
				. ' post_layout_' . esc_attr( $fitline_blog_style[0] ) . '_' . esc_attr( $fitline_columns )
	);
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
								: explode( ',', $fitline_template_args['meta_parts'] )
								)
							: fitline_array_get_keys_by_value( fitline_get_theme_option( 'meta_parts' ) );

	fitline_show_post_featured( apply_filters( 'fitline_filter_args_featured',
		array(
			'thumb_size' => ! empty( $fitline_template_args['thumb_size'] )
				? $fitline_template_args['thumb_size']
				: fitline_get_thumb_size(
					'classic' == $fitline_blog_style[0]
						? ( strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fitline_columns > 2 ? 'big' : 'huge' )
								: ( $fitline_columns > 2
									? ( $fitline_expanded ? 'square' : 'square' )
									: ($fitline_columns > 1 ? 'square' : ( $fitline_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $fitline_columns > 2 ? 'masonry-big' : 'full' )
								: ($fitline_columns === 1 ? ( $fitline_expanded ? 'huge' : 'big' ) : ( $fitline_columns <= 2 && $fitline_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $fitline_hover,
			'meta_parts' => $fitline_components,
			'no_links'   => ! empty( $fitline_template_args['no_links'] ),
        ),
        'content-classic',
        $fitline_template_args
    ) );

	// Title and post meta
	$fitline_show_title = get_the_title() != '';
	$fitline_show_meta  = count( $fitline_components ) > 0 && ! in_array( $fitline_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fitline_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'fitline_filter_show_blog_meta', $fitline_show_meta, $fitline_components, 'classic' ) ) {
				if ( count( $fitline_components ) > 0 ) {
					do_action( 'fitline_action_before_post_meta' );
					fitline_show_post_meta(
						apply_filters(
							'fitline_filter_post_meta_args', array(
							'components' => join( ',', $fitline_components ),
							'seo'        => false,
							'echo'       => true,
						), $fitline_blog_style[0], $fitline_columns
						)
					);
					do_action( 'fitline_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'fitline_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'fitline_action_before_post_title' );
				if ( empty( $fitline_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'fitline_action_after_post_title' );
			}

			if( !in_array( $fitline_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'fitline_filter_show_blog_readmore', ! $fitline_show_title || ! empty( $fitline_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $fitline_template_args['no_links'] ) ) {
						do_action( 'fitline_action_before_post_readmore' );
						fitline_show_post_more_link( $fitline_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'fitline_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $fitline_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('fitline_filter_show_blog_excerpt', empty($fitline_template_args['hide_excerpt']) && fitline_get_theme_option('excerpt_length') > 0, 'classic')) {
			fitline_show_post_content($fitline_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $fitline_template_args['more_button'] )) {
			if ( empty( $fitline_template_args['no_links'] ) ) {
				do_action( 'fitline_action_before_post_readmore' );
				fitline_show_post_more_link( $fitline_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'fitline_action_after_post_readmore' );
			}
		}
		$fitline_content = ob_get_contents();
		ob_end_clean();
		fitline_show_layout($fitline_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
