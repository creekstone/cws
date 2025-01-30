<?php
/**
 * The template to display default site header
 *
 * @package QWERY
 * @since QWERY 1.0
 */

$qwery_header_css   = '';
$qwery_header_image = get_header_image();
$qwery_header_video = qwery_get_header_video();
if ( ! empty( $qwery_header_image ) && qwery_trx_addons_featured_image_override( is_singular() || qwery_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$qwery_header_image = qwery_get_current_mode_image( $qwery_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $qwery_header_image ) || ! empty( $qwery_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $qwery_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $qwery_header_image ) {
		echo ' ' . esc_attr( qwery_add_inline_css_class( 'background-image: url(' . esc_url( $qwery_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( qwery_is_on( qwery_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight qwery-full-height';
	}
	$qwery_header_scheme = qwery_get_theme_option( 'header_scheme' );
	if ( ! empty( $qwery_header_scheme ) && ! qwery_is_inherit( $qwery_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $qwery_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $qwery_header_video ) ) {
		get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( qwery_is_on( qwery_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
