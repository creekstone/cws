<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package QWERY
 * @since QWERY 1.0
 */

// Page (category, tag, archive, author) title

if ( qwery_need_page_title() ) {
	qwery_sc_layouts_showed( 'title', true );
	qwery_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								qwery_show_post_meta(
									apply_filters(
										'qwery_filter_post_meta_args', array(
											'components' => join( ',', qwery_array_get_keys_by_value( qwery_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', qwery_array_get_keys_by_value( qwery_get_theme_option( 'counters' ) ) ),
											'seo'        => qwery_is_on( qwery_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$qwery_blog_title           = qwery_get_blog_title();
							$qwery_blog_title_text      = '';
							$qwery_blog_title_class     = '';
							$qwery_blog_title_link      = '';
							$qwery_blog_title_link_text = '';
							if ( is_array( $qwery_blog_title ) ) {
								$qwery_blog_title_text      = $qwery_blog_title['text'];
								$qwery_blog_title_class     = ! empty( $qwery_blog_title['class'] ) ? ' ' . $qwery_blog_title['class'] : '';
								$qwery_blog_title_link      = ! empty( $qwery_blog_title['link'] ) ? $qwery_blog_title['link'] : '';
								$qwery_blog_title_link_text = ! empty( $qwery_blog_title['link_text'] ) ? $qwery_blog_title['link_text'] : '';
							} else {
								$qwery_blog_title_text = $qwery_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $qwery_blog_title_class ); ?>">
								<?php
								$qwery_top_icon = qwery_get_term_image_small();
								if ( ! empty( $qwery_top_icon ) ) {
									$qwery_attr = qwery_getimagesize( $qwery_top_icon );
									?>
									<img src="<?php echo esc_url( $qwery_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'qwery' ); ?>"
										<?php
										if ( ! empty( $qwery_attr[3] ) ) {
											qwery_show_layout( $qwery_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $qwery_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $qwery_blog_title_link ) && ! empty( $qwery_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $qwery_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $qwery_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'qwery_action_breadcrumbs' );
						$qwery_breadcrumbs = ob_get_contents();
						ob_end_clean();
						qwery_show_layout( $qwery_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
