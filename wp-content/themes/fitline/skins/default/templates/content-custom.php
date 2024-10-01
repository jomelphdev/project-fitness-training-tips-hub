<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FITLINE
 * @since FITLINE 1.0.50
 */

$fitline_template_args = get_query_var( 'fitline_template_args' );
if ( is_array( $fitline_template_args ) ) {
	$fitline_columns    = empty( $fitline_template_args['columns'] ) ? 2 : max( 1, $fitline_template_args['columns'] );
	$fitline_blog_style = array( $fitline_template_args['type'], $fitline_columns );
} else {
	$fitline_template_args = array();
	$fitline_blog_style = explode( '_', fitline_get_theme_option( 'blog_style' ) );
	$fitline_columns    = empty( $fitline_blog_style[1] ) ? 2 : max( 1, $fitline_blog_style[1] );
}
$fitline_blog_id       = fitline_get_custom_blog_id( join( '_', $fitline_blog_style ) );
$fitline_blog_style[0] = str_replace( 'blog-custom-', '', $fitline_blog_style[0] );
$fitline_expanded      = ! fitline_sidebar_present() && fitline_get_theme_option( 'expand_content' ) == 'expand';
$fitline_components    = ! empty( $fitline_template_args['meta_parts'] )
							? ( is_array( $fitline_template_args['meta_parts'] )
								? join( ',', $fitline_template_args['meta_parts'] )
								: $fitline_template_args['meta_parts']
								)
							: fitline_array_get_keys_by_value( fitline_get_theme_option( 'meta_parts' ) );
$fitline_post_format   = get_post_format();
$fitline_post_format   = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );

$fitline_blog_meta     = fitline_get_custom_layout_meta( $fitline_blog_id );
$fitline_custom_style  = ! empty( $fitline_blog_meta['scripts_required'] ) ? $fitline_blog_meta['scripts_required'] : 'none';

if ( ! empty( $fitline_template_args['slider'] ) || $fitline_columns > 1 || ! fitline_is_off( $fitline_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $fitline_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( fitline_is_off( $fitline_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $fitline_custom_style ) ) . "-1_{$fitline_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $fitline_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $fitline_columns )
					. ' post_layout_' . esc_attr( $fitline_blog_style[0] )
					. ' post_layout_' . esc_attr( $fitline_blog_style[0] ) . '_' . esc_attr( $fitline_columns )
					. ( ! fitline_is_off( $fitline_custom_style )
						? ' post_layout_' . esc_attr( $fitline_custom_style )
							. ' post_layout_' . esc_attr( $fitline_custom_style ) . '_' . esc_attr( $fitline_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'fitline_action_show_layout', $fitline_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $fitline_template_args['slider'] ) || $fitline_columns > 1 || ! fitline_is_off( $fitline_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
