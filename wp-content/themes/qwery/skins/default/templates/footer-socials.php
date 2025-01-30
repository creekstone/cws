<?php
/**
 * The template to display the socials in the footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */


// Socials
if ( qwery_is_on( qwery_get_theme_option( 'socials_in_footer' ) ) ) {
	$qwery_output = qwery_get_socials_links();
	if ( '' != $qwery_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php qwery_show_layout( $qwery_output ); ?>
			</div>
		</div>
		<?php
	}
}
