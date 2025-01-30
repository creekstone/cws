<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package QWERY
 * @since QWERY 1.71.0
 */

$qwery_template_args = get_query_var( 'qwery_template_args' );
if ( ! is_array( $qwery_template_args ) ) {
	$qwery_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$qwery_columns       = 1;

$qwery_expanded      = ! qwery_sidebar_present() && qwery_get_theme_option( 'expand_content' ) == 'expand';

$qwery_post_format   = get_post_format();
$qwery_post_format   = empty( $qwery_post_format ) ? 'standard' : str_replace( 'post-format-', '', $qwery_post_format );

if ( is_array( $qwery_template_args ) ) {
	$qwery_columns    = empty( $qwery_template_args['columns'] ) ? 1 : max( 1, $qwery_template_args['columns'] );
	$qwery_blog_style = array( $qwery_template_args['type'], $qwery_columns );
	if ( ! empty( $qwery_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $qwery_columns > 1 ) {
	    $qwery_columns_class = qwery_get_column_class( 1, $qwery_columns, ! empty( $qwery_template_args['columns_tablet']) ? $qwery_template_args['columns_tablet'] : '', ! empty($qwery_template_args['columns_mobile']) ? $qwery_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $qwery_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $qwery_post_format ) );
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
								: array_map( 'trim', explode( ',', $qwery_template_args['meta_parts'] ) )
								)
							: qwery_array_get_keys_by_value( qwery_get_theme_option( 'meta_parts' ) );
	qwery_show_post_featured( apply_filters( 'qwery_filter_args_featured',
		array(
			'no_links'   => ! empty( $qwery_template_args['no_links'] ),
			'hover'      => $qwery_hover,
			'meta_parts' => $qwery_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $qwery_template_args['thumb_size'] )
								? $qwery_template_args['thumb_size']
								: qwery_get_thumb_size( 
								in_array( $qwery_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( qwery_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $qwery_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$qwery_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$qwery_show_title = get_the_title() != '';
		$qwery_show_meta  = count( $qwery_components ) > 0 && ! in_array( $qwery_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $qwery_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'qwery_filter_show_blog_categories', $qwery_show_meta && in_array( 'categories', $qwery_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'qwery_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						qwery_show_post_meta( apply_filters(
															'qwery_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $qwery_hover, 1
															)
											);
						?>
					</div>
					<?php
					$qwery_components = qwery_array_delete_by_value( $qwery_components, 'categories' );
					do_action( 'qwery_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'qwery_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'qwery_action_before_post_title' );
					if ( empty( $qwery_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'qwery_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $qwery_template_args['excerpt_length'] ) && ! in_array( $qwery_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$qwery_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'qwery_filter_show_blog_excerpt', empty( $qwery_template_args['hide_excerpt'] ) && qwery_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				qwery_show_post_content( $qwery_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'qwery_filter_show_blog_meta', $qwery_show_meta, $qwery_components, 'band' ) ) {
			if ( count( $qwery_components ) > 0 ) {
				do_action( 'qwery_action_before_post_meta' );
				qwery_show_post_meta(
					apply_filters(
						'qwery_filter_post_meta_args', array(
							'components' => join( ',', $qwery_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'qwery_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'qwery_filter_show_blog_readmore', ! $qwery_show_title || ! empty( $qwery_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $qwery_template_args['no_links'] ) ) {
				do_action( 'qwery_action_before_post_readmore' );
				qwery_show_post_more_link( $qwery_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'qwery_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $qwery_template_args ) ) {
	if ( ! empty( $qwery_template_args['slider'] ) || $qwery_columns > 1 ) {
		?>
		</div>
		<?php
	}
}