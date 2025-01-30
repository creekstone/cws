<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package QWERY
 * @since QWERY 1.0
 */

$qwery_args = get_query_var( 'qwery_logo_args' );

// Site logo
$qwery_logo_type   = isset( $qwery_args['type'] ) ? $qwery_args['type'] : '';
$qwery_logo_image  = qwery_get_logo_image( $qwery_logo_type );
$qwery_logo_text   = qwery_is_on( qwery_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$qwery_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $qwery_logo_image['logo'] ) || ! empty( $qwery_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $qwery_logo_image['logo'] ) ) {
			if ( empty( $qwery_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($qwery_logo_image['logo']) && (int) $qwery_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$qwery_attr = qwery_getimagesize( $qwery_logo_image['logo'] );
				echo '<img src="' . esc_url( $qwery_logo_image['logo'] ) . '"'
						. ( ! empty( $qwery_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $qwery_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $qwery_logo_text ) . '"'
						. ( ! empty( $qwery_attr[3] ) ? ' ' . wp_kses_data( $qwery_attr[3] ) : '' )
						. '>';
			}
		} else {
			qwery_show_layout( qwery_prepare_macros( $qwery_logo_text ), '<span class="logo_text">', '</span>' );
			qwery_show_layout( qwery_prepare_macros( $qwery_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
