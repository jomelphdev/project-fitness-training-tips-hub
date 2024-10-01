<?php
/**
 * The Portfolio template to display the content
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

$fitline_post_format = get_post_format();
$fitline_post_format = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );

?><div class="
<?php
if ( ! empty( $fitline_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( fitline_is_blog_style_use_masonry( $fitline_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $fitline_columns ) : esc_attr( $fitline_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $fitline_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $fitline_columns )
		. ( 'portfolio' != $fitline_blog_style[0] ? ' ' . esc_attr( $fitline_blog_style[0] )  . '_' . esc_attr( $fitline_columns ) : '' )
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

	$fitline_hover   = ! empty( $fitline_template_args['hover'] ) && ! fitline_is_inherit( $fitline_template_args['hover'] )
								? $fitline_template_args['hover']
								: fitline_get_theme_option( 'image_hover' );

	if ( 'dots' == $fitline_hover ) {
		$fitline_post_link = empty( $fitline_template_args['no_links'] )
								? ( ! empty( $fitline_template_args['link'] )
									? $fitline_template_args['link']
									: get_permalink()
									)
								: '';
		$fitline_target    = ! empty( $fitline_post_link ) && false === strpos( $fitline_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$fitline_components = ! empty( $fitline_template_args['meta_parts'] )
							? ( is_array( $fitline_template_args['meta_parts'] )
								? $fitline_template_args['meta_parts']
								: explode( ',', $fitline_template_args['meta_parts'] )
								)
							: fitline_array_get_keys_by_value( fitline_get_theme_option( 'meta_parts' ) );

	// Featured image
	fitline_show_post_featured( apply_filters( 'fitline_filter_args_featured',
        array(
			'hover'         => $fitline_hover,
			'no_links'      => ! empty( $fitline_template_args['no_links'] ),
			'thumb_size'    => ! empty( $fitline_template_args['thumb_size'] )
								? $fitline_template_args['thumb_size']
								: fitline_get_thumb_size(
									fitline_is_blog_style_use_masonry( $fitline_blog_style[0] )
										? (	strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false || $fitline_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false || $fitline_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => fitline_is_blog_style_use_masonry( $fitline_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $fitline_components,
			'class'         => 'dots' == $fitline_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $fitline_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $fitline_post_link )
												? '<a href="' . esc_url( $fitline_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $fitline_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $fitline_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $fitline_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!