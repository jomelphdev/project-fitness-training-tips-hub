<?php
/**
 * The template to display blog archive
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it to the menu to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% to the desired place of content
 */

if ( function_exists( 'fitline_elementor_is_preview' ) && fitline_elementor_is_preview() ) {

	// Redirect to the page
	get_template_part( apply_filters( 'fitline_filter_get_template_part', 'page' ) );

} else {

	// Store post with blog archive template
	if ( have_posts() ) {
		the_post();
		if ( isset( $GLOBALS['post'] ) && is_object( $GLOBALS['post'] ) ) {
			fitline_storage_set( 'blog_archive_template_post', $GLOBALS['post'] );
		}
	}

	// Make a new main query
	fitline_new_main_query(
		array(
			'post_type'      => fitline_get_theme_option( 'post_type' ),
			'category'       => fitline_get_theme_option( 'parent_cat' ),
			'posts_per_page' => fitline_get_theme_option( 'posts_per_page' ),
			'page'           => get_query_var( 'page_number' )
								? get_query_var( 'page_number' )
								: ( is_paged()
									? ( get_query_var( 'paged' )
										? get_query_var( 'paged' )
										: ( get_query_var( 'page' )
											? get_query_var( 'page' )
											: 1
											)
										)
									: 1
									),
		)
	);

	get_template_part( apply_filters( 'fitline_filter_get_template_part', fitline_blog_archive_get_template() ) );
}
