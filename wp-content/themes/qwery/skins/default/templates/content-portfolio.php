<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package QWERY
 * @since QWERY 1.0
 */

$qwery_template_args = get_query_var( 'qwery_template_args' );
if ( is_array( $qwery_template_args ) ) {
	$qwery_columns    = empty( $qwery_template_args['columns'] ) ? 2 : max( 1, $qwery_template_args['columns'] );
	$qwery_blog_style = array( $qwery_template_args['type'], $qwery_columns );
    $qwery_columns_class = qwery_get_column_class( 1, $qwery_columns, ! empty( $qwery_template_args['columns_tablet']) ? $qwery_template_args['columns_tablet'] : '', ! empty($qwery_template_args['columns_mobile']) ? $qwery_template_args['columns_mobile'] : '' );
} else {
	$qwery_template_args = array();
	$qwery_blog_style = explode( '_', qwery_get_theme_option( 'blog_style' ) );
	$qwery_columns    = empty( $qwery_blog_style[1] ) ? 2 : max( 1, $qwery_blog_style[1] );
    $qwery_columns_class = qwery_get_column_class( 1, $qwery_columns );
}

$qwery_post_format = get_post_format();
$qwery_post_format = empty( $qwery_post_format ) ? 'standard' : str_replace( 'post-format-', '', $qwery_post_format );

?><div class="
<?php
if ( ! empty( $qwery_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( qwery_is_blog_style_use_masonry( $qwery_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $qwery_columns ) : esc_attr( $qwery_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $qwery_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $qwery_columns )
		. ( 'portfolio' != $qwery_blog_style[0] ? ' ' . esc_attr( $qwery_blog_style[0] )  . '_' . esc_attr( $qwery_columns ) : '' )
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

	$qwery_hover   = ! empty( $qwery_template_args['hover'] ) && ! qwery_is_inherit( $qwery_template_args['hover'] )
								? $qwery_template_args['hover']
								: qwery_get_theme_option( 'image_hover' );

	if ( 'dots' == $qwery_hover ) {
		$qwery_post_link = empty( $qwery_template_args['no_links'] )
								? ( ! empty( $qwery_template_args['link'] )
									? $qwery_template_args['link']
									: get_permalink()
									)
								: '';
		$qwery_target    = ! empty( $qwery_post_link ) && false === strpos( $qwery_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$qwery_components = ! empty( $qwery_template_args['meta_parts'] )
							? ( is_array( $qwery_template_args['meta_parts'] )
								? $qwery_template_args['meta_parts']
								: explode( ',', $qwery_template_args['meta_parts'] )
								)
							: qwery_array_get_keys_by_value( qwery_get_theme_option( 'meta_parts' ) );

	// Featured image
	qwery_show_post_featured( apply_filters( 'qwery_filter_args_featured',
        array(
			'hover'         => $qwery_hover,
			'no_links'      => ! empty( $qwery_template_args['no_links'] ),
			'thumb_size'    => ! empty( $qwery_template_args['thumb_size'] )
								? $qwery_template_args['thumb_size']
								: qwery_get_thumb_size(
									qwery_is_blog_style_use_masonry( $qwery_blog_style[0] )
										? (	strpos( qwery_get_theme_option( 'body_style' ), 'full' ) !== false || $qwery_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( qwery_get_theme_option( 'body_style' ), 'full' ) !== false || $qwery_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => qwery_is_blog_style_use_masonry( $qwery_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $qwery_components,
			'class'         => 'dots' == $qwery_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $qwery_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $qwery_post_link )
												? '<a href="' . esc_url( $qwery_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $qwery_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $qwery_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $qwery_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!