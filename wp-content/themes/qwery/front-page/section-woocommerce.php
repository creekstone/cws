<?php
$qwery_woocommerce_sc = qwery_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $qwery_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$qwery_scheme = qwery_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $qwery_scheme ) && ! qwery_is_inherit( $qwery_scheme ) ) {
			echo ' scheme_' . esc_attr( $qwery_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( qwery_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( qwery_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$qwery_css      = '';
			$qwery_bg_image = qwery_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $qwery_bg_image ) ) {
				$qwery_css .= 'background-image: url(' . esc_url( qwery_get_attachment_url( $qwery_bg_image ) ) . ');';
			}
			if ( ! empty( $qwery_css ) ) {
				echo ' style="' . esc_attr( $qwery_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$qwery_anchor_icon = qwery_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$qwery_anchor_text = qwery_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $qwery_anchor_icon ) || ! empty( $qwery_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $qwery_anchor_icon ) ? ' icon="' . esc_attr( $qwery_anchor_icon ) . '"' : '' )
											. ( ! empty( $qwery_anchor_text ) ? ' title="' . esc_attr( $qwery_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( qwery_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' qwery-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$qwery_css      = '';
				$qwery_bg_mask  = qwery_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$qwery_bg_color_type = qwery_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $qwery_bg_color_type ) {
					$qwery_bg_color = qwery_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $qwery_bg_color_type ) {
					$qwery_bg_color = qwery_get_scheme_color( 'bg_color', $qwery_scheme );
				} else {
					$qwery_bg_color = '';
				}
				if ( ! empty( $qwery_bg_color ) && $qwery_bg_mask > 0 ) {
					$qwery_css .= 'background-color: ' . esc_attr(
						1 == $qwery_bg_mask ? $qwery_bg_color : qwery_hex2rgba( $qwery_bg_color, $qwery_bg_mask )
					) . ';';
				}
				if ( ! empty( $qwery_css ) ) {
					echo ' style="' . esc_attr( $qwery_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$qwery_caption     = qwery_get_theme_option( 'front_page_woocommerce_caption' );
				$qwery_description = qwery_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $qwery_caption ) || ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $qwery_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $qwery_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $qwery_caption, 'qwery_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $qwery_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $qwery_description ), 'qwery_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $qwery_woocommerce_sc ) {
						$qwery_woocommerce_sc_ids      = qwery_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$qwery_woocommerce_sc_per_page = count( explode( ',', $qwery_woocommerce_sc_ids ) );
					} else {
						$qwery_woocommerce_sc_per_page = max( 1, (int) qwery_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$qwery_woocommerce_sc_columns = max( 1, min( $qwery_woocommerce_sc_per_page, (int) qwery_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$qwery_woocommerce_sc}"
										. ( 'products' == $qwery_woocommerce_sc
												? ' ids="' . esc_attr( $qwery_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $qwery_woocommerce_sc
												? ' category="' . esc_attr( qwery_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $qwery_woocommerce_sc
												? ' orderby="' . esc_attr( qwery_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( qwery_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $qwery_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $qwery_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
