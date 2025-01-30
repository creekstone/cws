<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$qwery_copyright_scheme = qwery_get_theme_option( 'copyright_scheme' );
if ( ! empty( $qwery_copyright_scheme ) && ! qwery_is_inherit( $qwery_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $qwery_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$qwery_copyright = qwery_get_theme_option( 'copyright' );
			if ( ! empty( $qwery_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$qwery_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $qwery_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$qwery_copyright = qwery_prepare_macros( $qwery_copyright );
				// Display copyright
				echo wp_kses( nl2br( $qwery_copyright ), 'qwery_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
