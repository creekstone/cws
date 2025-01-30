<?php
/**
 * The "Style 5" template to display the post header of the single post or attachment:
 * title and meta placed in the post header and featured image placed inside content
 *
 * @package QWERY
 * @since QWERY 1.75.0
 */

if ( apply_filters( 'qwery_filter_single_post_header', is_singular( 'post' ) || is_singular( 'attachment' ) ) ) {
	ob_start();
	?>
	<div class="post_header_wrap post_header_wrap_in_header post_header_wrap_style_<?php
		echo esc_attr( qwery_get_theme_option( 'single_style' ) );
	?>">
		<?php
		// Post title and meta
		qwery_show_post_title_and_meta( array( 
			'author_avatar' => true,
			'show_meta'     => true,
		) );
        ?>
	</div>
	<?php
	$qwery_post_header = ob_get_contents();
	ob_end_clean();
	if ( strpos( $qwery_post_header, 'post_title' ) !== false ) {
		do_action( 'qwery_action_before_post_header' );
		?>
		<div class="content_wrap">
			<?php qwery_show_layout( $qwery_post_header ); ?>
		</div>
		<?php
		do_action( 'qwery_action_after_post_header' );
	}
}
