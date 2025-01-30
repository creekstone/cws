<?php
/**
 * The template to display single post
 *
 * @package QWERY
 * @since QWERY 1.0
 */

// Full post loading
$full_post_loading          = qwery_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = qwery_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = qwery_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$qwery_related_position   = qwery_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$qwery_posts_navigation   = qwery_get_theme_option( 'posts_navigation' );
$qwery_prev_post          = false;
$qwery_prev_post_same_cat = qwery_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( qwery_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	qwery_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'qwery_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $qwery_posts_navigation ) {
		$qwery_prev_post = get_previous_post( $qwery_prev_post_same_cat );  // Get post from same category
		if ( ! $qwery_prev_post && $qwery_prev_post_same_cat ) {
			$qwery_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $qwery_prev_post ) {
			$qwery_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $qwery_prev_post ) ) {
		qwery_sc_layouts_showed( 'featured', false );
		qwery_sc_layouts_showed( 'title', false );
		qwery_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $qwery_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/content', 'single-' . qwery_get_theme_option( 'single_style' ) ), 'single-' . qwery_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $qwery_related_position, 'inside' ) === 0 ) {
		$qwery_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'qwery_action_related_posts' );
		$qwery_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $qwery_related_content ) ) {
			$qwery_related_position_inside = max( 0, min( 9, qwery_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $qwery_related_position_inside ) {
				$qwery_related_position_inside = mt_rand( 1, 9 );
			}

			$qwery_p_number         = 0;
			$qwery_related_inserted = false;
			$qwery_in_block         = false;
			$qwery_content_start    = strpos( $qwery_content, '<div class="post_content' );
			$qwery_content_end      = strrpos( $qwery_content, '</div>' );

			for ( $i = max( 0, $qwery_content_start ); $i < min( strlen( $qwery_content ) - 3, $qwery_content_end ); $i++ ) {
				if ( $qwery_content[ $i ] != '<' ) {
					continue;
				}
				if ( $qwery_in_block ) {
					if ( strtolower( substr( $qwery_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$qwery_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $qwery_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $qwery_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$qwery_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $qwery_content[ $i + 1 ] && in_array( $qwery_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$qwery_p_number++;
					if ( $qwery_related_position_inside == $qwery_p_number ) {
						$qwery_related_inserted = true;
						$qwery_content = ( $i > 0 ? substr( $qwery_content, 0, $i ) : '' )
											. $qwery_related_content
											. substr( $qwery_content, $i );
					}
				}
			}
			if ( ! $qwery_related_inserted ) {
				if ( $qwery_content_end > 0 ) {
					$qwery_content = substr( $qwery_content, 0, $qwery_content_end ) . $qwery_related_content . substr( $qwery_content, $qwery_content_end );
				} else {
					$qwery_content .= $qwery_related_content;
				}
			}
		}

		qwery_show_layout( $qwery_content );
	}

	// Comments
	do_action( 'qwery_action_before_comments' );
	comments_template();
	do_action( 'qwery_action_after_comments' );

	// Related posts
	if ( 'below_content' == $qwery_related_position
		&& ( 'scroll' != $qwery_posts_navigation || qwery_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || qwery_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'qwery_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $qwery_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $qwery_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $qwery_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $qwery_prev_post ) ); ?>"
			<?php do_action( 'qwery_action_nav_links_single_scroll_data', $qwery_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
