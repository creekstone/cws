<?php
/**
 * The template to display default site footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */

$qwery_footer_id = qwery_get_custom_footer_id();
$qwery_footer_meta = get_post_meta( $qwery_footer_id, 'trx_addons_options', true );
if ( ! empty( $qwery_footer_meta['margin'] ) ) {
	qwery_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( qwery_prepare_css_value( $qwery_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $qwery_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $qwery_footer_id ) ) ); ?>
						<?php
						$qwery_footer_scheme = qwery_get_theme_option( 'footer_scheme' );
						if ( ! empty( $qwery_footer_scheme ) && ! qwery_is_inherit( $qwery_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $qwery_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'qwery_action_show_layout', $qwery_footer_id );
	?>
</footer><!-- /.footer_wrap -->
