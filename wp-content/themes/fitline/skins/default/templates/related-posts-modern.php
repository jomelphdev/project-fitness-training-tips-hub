<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_link        = get_permalink();
$fitline_post_format = get_post_format();
$fitline_post_format = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $fitline_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	fitline_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'fitline_filter_related_thumb_size', fitline_get_thumb_size( (int) fitline_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( fitline_get_post_categories( '' ), 'fitline_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $fitline_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'fitline' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $fitline_link ) . '" class="post_meta_item post_date">' . wp_kses_data( fitline_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
