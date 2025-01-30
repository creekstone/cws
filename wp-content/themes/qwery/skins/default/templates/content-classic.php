<?php
/**
 * The Classic template to display the content
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
$qwery_expanded   = ! qwery_sidebar_present() && qwery_get_theme_option( 'expand_content' ) == 'expand';

$qwery_post_format = get_post_format();
$qwery_post_format = empty( $qwery_post_format ) ? 'standard' : str_replace( 'post-format-', '', $qwery_post_format );

?><div class="<?php
	if ( ! empty( $qwery_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( qwery_is_blog_style_use_masonry( $qwery_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $qwery_columns ) : esc_attr( $qwery_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $qwery_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $qwery_columns )
				. ' post_layout_' . esc_attr( $qwery_blog_style[0] )
				. ' post_layout_' . esc_attr( $qwery_blog_style[0] ) . '_' . esc_attr( $qwery_columns )
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

	// Featured image
	$qwery_hover      = ! empty( $qwery_template_args['hover'] ) && ! qwery_is_inherit( $qwery_template_args['hover'] )
							? $qwery_template_args['hover']
							: qwery_get_theme_option( 'image_hover' );

	$qwery_components = ! empty( $qwery_template_args['meta_parts'] )
							? ( is_array( $qwery_template_args['meta_parts'] )
								? $qwery_template_args['meta_parts']
								: explode( ',', $qwery_template_args['meta_parts'] )
								)
							: qwery_array_get_keys_by_value( qwery_get_theme_option( 'meta_parts' ) );

	qwery_show_post_featured( apply_filters( 'qwery_filter_args_featured',
		array(
			'thumb_size' => ! empty( $qwery_template_args['thumb_size'] )
				? $qwery_template_args['thumb_size']
				: qwery_get_thumb_size(
					'classic' == $qwery_blog_style[0]
						? ( strpos( qwery_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $qwery_columns > 2 ? 'big' : 'huge' )
								: ( $qwery_columns > 2
									? ( $qwery_expanded ? 'square' : 'square' )
									: ($qwery_columns > 1 ? 'square' : ( $qwery_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( qwery_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $qwery_columns > 2 ? 'masonry-big' : 'full' )
								: ($qwery_columns === 1 ? ( $qwery_expanded ? 'huge' : 'big' ) : ( $qwery_columns <= 2 && $qwery_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $qwery_hover,
			'meta_parts' => $qwery_components,
			'no_links'   => ! empty( $qwery_template_args['no_links'] ),
        ),
        'content-classic',
        $qwery_template_args
    ) );

	// Title and post meta
	$qwery_show_title = get_the_title() != '';
	$qwery_show_meta  = count( $qwery_components ) > 0 && ! in_array( $qwery_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $qwery_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'qwery_filter_show_blog_meta', $qwery_show_meta, $qwery_components, 'classic' ) ) {
				if ( count( $qwery_components ) > 0 ) {
					do_action( 'qwery_action_before_post_meta' );
					qwery_show_post_meta(
						apply_filters(
							'qwery_filter_post_meta_args', array(
							'components' => join( ',', $qwery_components ),
							'seo'        => false,
							'echo'       => true,
						), $qwery_blog_style[0], $qwery_columns
						)
					);
					do_action( 'qwery_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'qwery_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'qwery_action_before_post_title' );
				if ( empty( $qwery_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'qwery_action_after_post_title' );
			}

			if( !in_array( $qwery_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'qwery_filter_show_blog_readmore', ! $qwery_show_title || ! empty( $qwery_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $qwery_template_args['no_links'] ) ) {
						do_action( 'qwery_action_before_post_readmore' );
						qwery_show_post_more_link( $qwery_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'qwery_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $qwery_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('qwery_filter_show_blog_excerpt', empty($qwery_template_args['hide_excerpt']) && qwery_get_theme_option('excerpt_length') > 0, 'classic')) {
			qwery_show_post_content($qwery_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $qwery_template_args['more_button'] )) {
			if ( empty( $qwery_template_args['no_links'] ) ) {
				do_action( 'qwery_action_before_post_readmore' );
				qwery_show_post_more_link( $qwery_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'qwery_action_after_post_readmore' );
			}
		}
		$qwery_content = ob_get_contents();
		ob_end_clean();
		qwery_show_layout($qwery_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
