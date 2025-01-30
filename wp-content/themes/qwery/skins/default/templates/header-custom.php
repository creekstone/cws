<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package QWERY
 * @since QWERY 1.0.06
 */

$qwery_header_css   = '';
$qwery_header_image = get_header_image();
$qwery_header_video = qwery_get_header_video();
if ( ! empty( $qwery_header_image ) && qwery_trx_addons_featured_image_override( is_singular() || qwery_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$qwery_header_image = qwery_get_current_mode_image( $qwery_header_image );
}

$qwery_header_id = qwery_get_custom_header_id();
$qwery_header_meta = get_post_meta( $qwery_header_id, 'trx_addons_options', true );
if ( ! empty( $qwery_header_meta['margin'] ) ) {
	qwery_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( qwery_prepare_css_value( $qwery_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $qwery_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $qwery_header_id ) ) ); ?>
				<?php
				echo ! empty( $qwery_header_image ) || ! empty( $qwery_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'qwery_action_show_layout', $qwery_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
