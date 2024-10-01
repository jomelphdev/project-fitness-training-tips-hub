<?php
/**
 * The template to display single post
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

// Full post loading
$full_post_loading          = fitline_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = fitline_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = fitline_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$fitline_related_position   = fitline_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$fitline_posts_navigation   = fitline_get_theme_option( 'posts_navigation' );
$fitline_prev_post          = false;
$fitline_prev_post_same_cat = fitline_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( fitline_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	fitline_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'fitline_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $fitline_posts_navigation ) {
		$fitline_prev_post = get_previous_post( $fitline_prev_post_same_cat );  // Get post from same category
		if ( ! $fitline_prev_post && $fitline_prev_post_same_cat ) {
			$fitline_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $fitline_prev_post ) {
			$fitline_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $fitline_prev_post ) ) {
		fitline_sc_layouts_showed( 'featured', false );
		fitline_sc_layouts_showed( 'title', false );
		fitline_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $fitline_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/content', 'single-' . fitline_get_theme_option( 'single_style' ) ), 'single-' . fitline_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $fitline_related_position, 'inside' ) === 0 ) {
		$fitline_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'fitline_action_related_posts' );
		$fitline_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $fitline_related_content ) ) {
			$fitline_related_position_inside = max( 0, min( 9, fitline_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $fitline_related_position_inside ) {
				$fitline_related_position_inside = mt_rand( 1, 9 );
			}

			$fitline_p_number         = 0;
			$fitline_related_inserted = false;
			$fitline_in_block         = false;
			$fitline_content_start    = strpos( $fitline_content, '<div class="post_content' );
			$fitline_content_end      = strrpos( $fitline_content, '</div>' );

			for ( $i = max( 0, $fitline_content_start ); $i < min( strlen( $fitline_content ) - 3, $fitline_content_end ); $i++ ) {
				if ( $fitline_content[ $i ] != '<' ) {
					continue;
				}
				if ( $fitline_in_block ) {
					if ( strtolower( substr( $fitline_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$fitline_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $fitline_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $fitline_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$fitline_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $fitline_content[ $i + 1 ] && in_array( $fitline_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$fitline_p_number++;
					if ( $fitline_related_position_inside == $fitline_p_number ) {
						$fitline_related_inserted = true;
						$fitline_content = ( $i > 0 ? substr( $fitline_content, 0, $i ) : '' )
											. $fitline_related_content
											. substr( $fitline_content, $i );
					}
				}
			}
			if ( ! $fitline_related_inserted ) {
				if ( $fitline_content_end > 0 ) {
					$fitline_content = substr( $fitline_content, 0, $fitline_content_end ) . $fitline_related_content . substr( $fitline_content, $fitline_content_end );
				} else {
					$fitline_content .= $fitline_related_content;
				}
			}
		}

		fitline_show_layout( $fitline_content );
	}

	// Comments
	do_action( 'fitline_action_before_comments' );
	comments_template();
	do_action( 'fitline_action_after_comments' );

	// Related posts
	if ( 'below_content' == $fitline_related_position
		&& ( 'scroll' != $fitline_posts_navigation || fitline_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || fitline_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'fitline_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $fitline_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $fitline_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $fitline_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $fitline_prev_post ) ); ?>"
			<?php do_action( 'fitline_action_nav_links_single_scroll_data', $fitline_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
