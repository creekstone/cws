<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package QWERY
 * @since QWERY 1.0.50
 */

$qwery_template_args = get_query_var( 'qwery_template_args' );
if ( is_array( $qwery_template_args ) ) {
	$qwery_columns    = empty( $qwery_template_args['columns'] ) ? 2 : max( 1, $qwery_template_args['columns'] );
	$qwery_blog_style = array( $qwery_template_args['type'], $qwery_columns );
} else {
	$qwery_template_args = array();
	$qwery_blog_style = explode( '_', qwery_get_theme_option( 'blog_style' ) );
	$qwery_columns    = empty( $qwery_blog_style[1] ) ? 2 : max( 1, $qwery_blog_style[1] );
}
$qwery_blog_id       = qwery_get_custom_blog_id( join( '_', $qwery_blog_style ) );
$qwery_blog_style[0] = str_replace( 'blog-custom-', '', $qwery_blog_style[0] );
$qwery_expanded      = ! qwery_sidebar_present() && qwery_get_theme_option( 'expand_content' ) == 'expand';
$qwery_components    = ! empty( $qwery_template_args['meta_parts'] )
							? ( is_array( $qwery_template_args['meta_parts'] )
								? join( ',', $qwery_template_args['meta_parts'] )
								: $qwery_template_args['meta_parts']
								)
							: qwery_array_get_keys_by_value( qwery_get_theme_option( 'meta_parts' ) );
$qwery_post_format   = get_post_format();
$qwery_post_format   = empty( $qwery_post_format ) ? 'standard' : str_replace( 'post-format-', '', $qwery_post_format );

$qwery_blog_meta     = qwery_get_custom_layout_meta( $qwery_blog_id );
$qwery_custom_style  = ! empty( $qwery_blog_meta['scripts_required'] ) ? $qwery_blog_meta['scripts_required'] : 'none';

if ( ! empty( $qwery_template_args['slider'] ) || $qwery_columns > 1 || ! qwery_is_off( $qwery_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $qwery_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( qwery_is_off( $qwery_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $qwery_custom_style ) ) . "-1_{$qwery_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $qwery_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $qwery_columns )
					. ' post_layout_' . esc_attr( $qwery_blog_style[0] )
					. ' post_layout_' . esc_attr( $qwery_blog_style[0] ) . '_' . esc_attr( $qwery_columns )
					. ( ! qwery_is_off( $qwery_custom_style )
						? ' post_layout_' . esc_attr( $qwery_custom_style )
							. ' post_layout_' . esc_attr( $qwery_custom_style ) . '_' . esc_attr( $qwery_columns )
						: ''
						)
		);
	qwery_add_blog_animation( $qwery_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'qwery_action_show_layout', $qwery_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $qwery_template_args['slider'] ) || $qwery_columns > 1 || ! qwery_is_off( $qwery_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
