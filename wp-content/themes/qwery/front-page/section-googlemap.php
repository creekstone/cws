<div class="front_page_section front_page_section_googlemap<?php
	$qwery_scheme = qwery_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $qwery_scheme ) && ! qwery_is_inherit( $qwery_scheme ) ) {
		echo ' scheme_' . esc_attr( $qwery_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( qwery_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( qwery_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$qwery_css      = '';
		$qwery_bg_image = qwery_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$qwery_anchor_icon = qwery_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$qwery_anchor_text = qwery_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $qwery_anchor_icon ) || ! empty( $qwery_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $qwery_anchor_icon ) ? ' icon="' . esc_attr( $qwery_anchor_icon ) . '"' : '' )
									. ( ! empty( $qwery_anchor_text ) ? ' title="' . esc_attr( $qwery_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$qwery_layout = qwery_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $qwery_layout );
		if ( qwery_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' qwery-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$qwery_css      = '';
			$qwery_bg_mask  = qwery_get_theme_option( 'front_page_googlemap_bg_mask' );
			$qwery_bg_color_type = qwery_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $qwery_bg_color_type ) {
				$qwery_bg_color = qwery_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $qwery_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$qwery_caption     = qwery_get_theme_option( 'front_page_googlemap_caption' );
			$qwery_description = qwery_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $qwery_caption ) || ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $qwery_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $qwery_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $qwery_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $qwery_caption, 'qwery_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $qwery_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $qwery_description ), 'qwery_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $qwery_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$qwery_content = qwery_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $qwery_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $qwery_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $qwery_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $qwery_content, 'qwery_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $qwery_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $qwery_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! qwery_exists_trx_addons() ) {
						qwery_customizer_need_trx_addons_message();
					} else {
						qwery_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $qwery_layout && ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
