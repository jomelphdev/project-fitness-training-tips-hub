<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package FITLINE
 * @since FITLINE 1.0
 */

$fitline_template = apply_filters( 'fitline_filter_get_template_part', fitline_blog_archive_get_template() );

if ( ! empty( $fitline_template ) && 'index' != $fitline_template ) {

	get_template_part( $fitline_template );

} else {

	fitline_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$fitline_stickies   = is_home()
								|| ( in_array( fitline_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) fitline_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$fitline_post_type  = fitline_get_theme_option( 'post_type' );
		$fitline_args       = array(
								'blog_style'     => fitline_get_theme_option( 'blog_style' ),
								'post_type'      => $fitline_post_type,
								'taxonomy'       => fitline_get_post_type_taxonomy( $fitline_post_type ),
								'parent_cat'     => fitline_get_theme_option( 'parent_cat' ),
								'posts_per_page' => fitline_get_theme_option( 'posts_per_page' ),
								'sticky'         => fitline_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $fitline_stickies )
															&& count( $fitline_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		fitline_blog_archive_start();

		do_action( 'fitline_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'fitline_action_before_page_author' );
			get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'fitline_action_after_page_author' );
		}

		if ( fitline_get_theme_option( 'show_filters' ) ) {
			do_action( 'fitline_action_before_page_filters' );
			fitline_show_filters( $fitline_args );
			do_action( 'fitline_action_after_page_filters' );
		} else {
			do_action( 'fitline_action_before_page_posts' );
			fitline_show_posts( array_merge( $fitline_args, array( 'cat' => $fitline_args['parent_cat'] ) ) );
			do_action( 'fitline_action_after_page_posts' );
		}

		do_action( 'fitline_action_blog_archive_end' );

		fitline_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'fitline_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
