<?php
/**
 * The Header: Logo and main menu
 *
 * @package QWERY
 * @since QWERY 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( qwery_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'qwery_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'qwery_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('qwery_action_body_wrap_attributes'); ?>>

		<?php do_action( 'qwery_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'qwery_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('qwery_action_page_wrap_attributes'); ?>>

			<?php do_action( 'qwery_action_page_wrap_start' ); ?>

			<?php
			$qwery_full_post_loading = ( qwery_is_singular( 'post' ) || qwery_is_singular( 'attachment' ) ) && qwery_get_value_gp( 'action' ) == 'full_post_loading';
			$qwery_prev_post_loading = ( qwery_is_singular( 'post' ) || qwery_is_singular( 'attachment' ) ) && qwery_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $qwery_full_post_loading && ! $qwery_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="qwery_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'qwery_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'qwery' ); ?></a>
				<?php if ( qwery_sidebar_present() ) { ?>
				<a class="qwery_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'qwery_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'qwery' ); ?></a>
				<?php } ?>
				<a class="qwery_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'qwery_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'qwery' ); ?></a>

				<?php
				do_action( 'qwery_action_before_header' );

				// Header
				$qwery_header_type = qwery_get_theme_option( 'header_type' );
				if ( 'custom' == $qwery_header_type && ! qwery_is_layouts_available() ) {
					$qwery_header_type = 'default';
				}
				get_template_part( apply_filters( 'qwery_filter_get_template_part', "templates/header-" . sanitize_file_name( $qwery_header_type ) ) );

				// Side menu
				if ( in_array( qwery_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'qwery_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'qwery_action_after_header' );

			}
			?>

			<?php do_action( 'qwery_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( qwery_is_off( qwery_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $qwery_header_type ) ) {
						$qwery_header_type = qwery_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $qwery_header_type && qwery_is_layouts_available() ) {
						$qwery_header_id = qwery_get_custom_header_id();
						if ( $qwery_header_id > 0 ) {
							$qwery_header_meta = qwery_get_custom_layout_meta( $qwery_header_id );
							if ( ! empty( $qwery_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$qwery_footer_type = qwery_get_theme_option( 'footer_type' );
					if ( 'custom' == $qwery_footer_type && qwery_is_layouts_available() ) {
						$qwery_footer_id = qwery_get_custom_footer_id();
						if ( $qwery_footer_id ) {
							$qwery_footer_meta = qwery_get_custom_layout_meta( $qwery_footer_id );
							if ( ! empty( $qwery_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'qwery_action_page_content_wrap_class', $qwery_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'qwery_filter_is_prev_post_loading', $qwery_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( qwery_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'qwery_action_page_content_wrap_data', $qwery_prev_post_loading );
			?>>
				<?php
				do_action( 'qwery_action_page_content_wrap', $qwery_full_post_loading || $qwery_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'qwery_filter_single_post_header', qwery_is_singular( 'post' ) || qwery_is_singular( 'attachment' ) ) ) {
					if ( $qwery_prev_post_loading ) {
						if ( qwery_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'qwery_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$qwery_path = apply_filters( 'qwery_filter_get_template_part', 'templates/single-styles/' . qwery_get_theme_option( 'single_style' ) );
					if ( qwery_get_file_dir( $qwery_path . '.php' ) != '' ) {
						get_template_part( $qwery_path );
					}
				}

				// Widgets area above page
				$qwery_body_style   = qwery_get_theme_option( 'body_style' );
				$qwery_widgets_name = qwery_get_theme_option( 'widgets_above_page' );
				$qwery_show_widgets = ! qwery_is_off( $qwery_widgets_name ) && is_active_sidebar( $qwery_widgets_name );
				if ( $qwery_show_widgets ) {
					if ( 'fullscreen' != $qwery_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					qwery_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $qwery_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'qwery_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $qwery_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'qwery_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'qwery_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="qwery_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( qwery_is_singular( 'post' ) || qwery_is_singular( 'attachment' ) )
							&& $qwery_prev_post_loading 
							&& qwery_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'qwery_action_between_posts' );
						}

						// Widgets area above content
						qwery_create_widgets_area( 'widgets_above_content' );

						do_action( 'qwery_action_page_content_start_text' );
