<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package QWERY
 * @since QWERY 1.0
 */

if ( qwery_sidebar_present() ) {
	
	$qwery_sidebar_type = qwery_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $qwery_sidebar_type && ! qwery_is_layouts_available() ) {
		$qwery_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $qwery_sidebar_type ) {
		// Default sidebar with widgets
		$qwery_sidebar_name = qwery_get_theme_option( 'sidebar_widgets' );
		qwery_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $qwery_sidebar_name ) ) {
			dynamic_sidebar( $qwery_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$qwery_sidebar_id = qwery_get_custom_sidebar_id();
		do_action( 'qwery_action_show_layout', $qwery_sidebar_id );
	}
	$qwery_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $qwery_out ) ) {
		$qwery_sidebar_position    = qwery_get_theme_option( 'sidebar_position' );
		$qwery_sidebar_position_ss = qwery_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $qwery_sidebar_position );
			echo ' sidebar_' . esc_attr( $qwery_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $qwery_sidebar_type );

			$qwery_sidebar_scheme = apply_filters( 'qwery_filter_sidebar_scheme', qwery_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $qwery_sidebar_scheme ) && ! qwery_is_inherit( $qwery_sidebar_scheme ) && 'custom' != $qwery_sidebar_type ) {
				echo ' scheme_' . esc_attr( $qwery_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="qwery_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'qwery_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $qwery_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$qwery_title = apply_filters( 'qwery_filter_sidebar_control_title', 'float' == $qwery_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'qwery' ) : '' );
				$qwery_text  = apply_filters( 'qwery_filter_sidebar_control_text', 'above' == $qwery_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'qwery' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $qwery_title ); ?>"><?php echo esc_html( $qwery_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'qwery_action_before_sidebar', 'sidebar' );
				qwery_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $qwery_out ) );
				do_action( 'qwery_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'qwery_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
