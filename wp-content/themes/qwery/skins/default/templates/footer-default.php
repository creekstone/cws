<?php
/**
 * The template to display default site footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$qwery_footer_scheme = qwery_get_theme_option( 'footer_scheme' );
if ( ! empty( $qwery_footer_scheme ) && ! qwery_is_inherit( $qwery_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $qwery_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
