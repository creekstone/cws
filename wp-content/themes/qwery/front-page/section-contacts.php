<div class="front_page_section front_page_section_contacts<?php
	$qwery_scheme = qwery_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $qwery_scheme ) && ! qwery_is_inherit( $qwery_scheme ) ) {
		echo ' scheme_' . esc_attr( $qwery_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( qwery_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( qwery_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$qwery_css      = '';
		$qwery_bg_image = qwery_get_theme_option( 'front_page_contacts_bg_image' );
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
	$qwery_anchor_icon = qwery_get_theme_option( 'front_page_contacts_anchor_icon' );
	$qwery_anchor_text = qwery_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $qwery_anchor_icon ) || ! empty( $qwery_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $qwery_anchor_icon ) ? ' icon="' . esc_attr( $qwery_anchor_icon ) . '"' : '' )
									. ( ! empty( $qwery_anchor_text ) ? ' title="' . esc_attr( $qwery_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( qwery_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' qwery-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$qwery_css      = '';
			$qwery_bg_mask  = qwery_get_theme_option( 'front_page_contacts_bg_mask' );
			$qwery_bg_color_type = qwery_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $qwery_bg_color_type ) {
				$qwery_bg_color = qwery_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$qwery_caption     = qwery_get_theme_option( 'front_page_contacts_caption' );
			$qwery_description = qwery_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $qwery_caption ) || ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $qwery_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $qwery_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $qwery_caption, 'qwery_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $qwery_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $qwery_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $qwery_description ), 'qwery_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$qwery_content = qwery_get_theme_option( 'front_page_contacts_content' );
			$qwery_layout  = qwery_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $qwery_layout && ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $qwery_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $qwery_content, 'qwery_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $qwery_layout && ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$qwery_sc = qwery_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $qwery_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $qwery_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					qwery_show_layout( do_shortcode( $qwery_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $qwery_layout && ( ! empty( $qwery_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
