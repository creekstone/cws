<div class="front_page_section front_page_section_blog<?php
	$qwery_scheme = qwery_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $qwery_scheme ) && ! qwery_is_inherit( $qwery_scheme ) ) {
		echo ' scheme_' . esc_attr( $qwery_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( qwery_get_theme_option( 'front_page_blog_paddings' ) );
	if ( qwery_get_theme_option( 'front_page_blog_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$qwery_css      = '';
		$qwery_bg_image = qwery_get_theme_option( 'front_page_blog_bg_image' );
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
	$qwery_anchor_icon = qwery_get_theme_option( 'front_page_blog_anchor_icon' );
	$qwery_anchor_text = qwery_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $qwery_anchor_icon ) || ! empty( $qwery_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $qwery_anchor_icon ) ? ' icon="' . esc_attr( $qwery_anchor_icon ) . '"' : '' )
									. ( ! empty( $qwery_anchor_text ) ? ' title="' . esc_attr( $qwery_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( qwery_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' qwery-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$qwery_css      = '';
			$qwery_bg_mask  = qwery_get_theme_option( 'front_page_blog_bg_mask' );
			$qwery_bg_color_type = qwery_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $qwery_bg_color_type ) {
				$qwery_bg_color = qwery_get_theme_option( 'front_page_blog_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$qwery_caption = qwery_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $qwery_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $qwery_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $qwery_caption, 'qwery_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$qwery_description = qwery_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $qwery_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $qwery_description ), 'qwery_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
				<?php
				if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! qwery_exists_trx_addons() ) {
						qwery_customizer_need_trx_addons_message();
					} else {
						qwery_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
