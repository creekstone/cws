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
 * @package QWERY
 * @since QWERY 1.0
 */

$qwery_template = apply_filters( 'qwery_filter_get_template_part', qwery_blog_archive_get_template() );

if ( ! empty( $qwery_template ) && 'index' != $qwery_template ) {

	get_template_part( $qwery_template );

} else {

	qwery_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$qwery_stickies   = is_home()
								|| ( in_array( qwery_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) qwery_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$qwery_post_type  = qwery_get_theme_option( 'post_type' );
		$qwery_args       = array(
								'blog_style'     => qwery_get_theme_option( 'blog_style' ),
								'post_type'      => $qwery_post_type,
								'taxonomy'       => qwery_get_post_type_taxonomy( $qwery_post_type ),
								'parent_cat'     => qwery_get_theme_option( 'parent_cat' ),
								'posts_per_page' => qwery_get_theme_option( 'posts_per_page' ),
								'sticky'         => qwery_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $qwery_stickies )
															&& count( $qwery_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		qwery_blog_archive_start();

		do_action( 'qwery_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'qwery_action_before_page_author' );
			get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'qwery_action_after_page_author' );
		}

		if ( qwery_get_theme_option( 'show_filters' ) ) {
			do_action( 'qwery_action_before_page_filters' );
			qwery_show_filters( $qwery_args );
			do_action( 'qwery_action_after_page_filters' );
		} else {
			do_action( 'qwery_action_before_page_posts' );
			qwery_show_posts( array_merge( $qwery_args, array( 'cat' => $qwery_args['parent_cat'] ) ) );
			do_action( 'qwery_action_after_page_posts' );
		}

		do_action( 'qwery_action_blog_archive_end' );

		qwery_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
