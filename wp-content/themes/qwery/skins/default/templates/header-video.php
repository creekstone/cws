<?php
/**
 * The template to display the background video in the header
 *
 * @package QWERY
 * @since QWERY 1.0.14
 */
$qwery_header_video = qwery_get_header_video();
$qwery_embed_video  = '';
if ( ! empty( $qwery_header_video ) && ! qwery_is_from_uploads( $qwery_header_video ) ) {
	if ( qwery_is_youtube_url( $qwery_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $qwery_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php qwery_show_layout( qwery_get_embed_video( $qwery_header_video ) ); ?></div>
		<?php
	}
}
