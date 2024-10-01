<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_template_args = get_query_var( 'fitline_template_args' );
$fitline_columns = 1;
if ( is_array( $fitline_template_args ) ) {
	$fitline_columns    = empty( $fitline_template_args['columns'] ) ? 1 : max( 1, $fitline_template_args['columns'] );
	$fitline_blog_style = array( $fitline_template_args['type'], $fitline_columns );
	if ( ! empty( $fitline_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $fitline_columns > 1 ) {
	    $fitline_columns_class = fitline_get_column_class( 1, $fitline_columns, ! empty( $fitline_template_args['columns_tablet']) ? $fitline_template_args['columns_tablet'] : '', ! empty($fitline_template_args['columns_mobile']) ? $fitline_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $fitline_columns_class ); ?>">
		<?php
	}
} else {
	$fitline_template_args = array();
}
$fitline_expanded    = ! fitline_sidebar_present() && fitline_get_theme_option( 'expand_content' ) == 'expand';
$fitline_post_format = get_post_format();
$fitline_post_format = empty( $fitline_post_format ) ? 'standard' : str_replace( 'post-format-', '', $fitline_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $fitline_post_format ) );
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
			'thumb_size' => ! empty( $fitline_template_args['thumb_size'] )
							? $fitline_template_args['thumb_size']
							: fitline_get_thumb_size( strpos( fitline_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $fitline_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$fitline_template_args
	) );

	// Title and post meta
	$fitline_show_title = get_the_title() != '';
	$fitline_show_meta  = count( $fitline_components ) > 0 && ! in_array( $fitline_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $fitline_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'fitline_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'fitline_action_before_post_title' );
				if ( empty( $fitline_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'fitline_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'fitline_filter_show_blog_excerpt', empty( $fitline_template_args['hide_excerpt'] ) && fitline_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'fitline_filter_show_blog_meta', $fitline_show_meta, $fitline_components, 'excerpt' ) ) {
				if ( count( $fitline_components ) > 0 ) {
					do_action( 'fitline_action_before_post_meta' );
					fitline_show_post_meta(
						apply_filters(
							'fitline_filter_post_meta_args', array(
								'components' => join( ',', $fitline_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'fitline_action_after_post_meta' );
				}
			}

			if ( fitline_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'fitline_action_before_full_post_content' );
					the_content( '' );
					do_action( 'fitline_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'fitline' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'fitline' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				fitline_show_post_content( $fitline_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'fitline_filter_show_blog_readmore',  ! isset( $fitline_template_args['more_button'] ) || ! empty( $fitline_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $fitline_template_args['no_links'] ) ) {
					do_action( 'fitline_action_before_post_readmore' );
					if ( fitline_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						fitline_show_post_more_link( $fitline_template_args, '<p>', '</p>' );
					} else {
						fitline_show_post_comments_link( $fitline_template_args, '<p>', '</p>' );
					}
					do_action( 'fitline_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $fitline_template_args ) ) {
	if ( ! empty( $fitline_template_args['slider'] ) || $fitline_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
