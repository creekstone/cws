<?php
/**
 * The template to display the site logo in the footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */

// Logo
if ( qwery_is_on( qwery_get_theme_option( 'logo_in_footer' ) ) ) {
	$qwery_logo_image = qwery_get_logo_image( 'footer' );
	$qwery_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $qwery_logo_image['logo'] ) || ! empty( $qwery_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $qwery_logo_image['logo'] ) ) {
					$qwery_attr = qwery_getimagesize( $qwery_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $qwery_logo_image['logo'] ) . '"'
								. ( ! empty( $qwery_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $qwery_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'qwery' ) . '"'
								. ( ! empty( $qwery_attr[3] ) ? ' ' . wp_kses_data( $qwery_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $qwery_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $qwery_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
