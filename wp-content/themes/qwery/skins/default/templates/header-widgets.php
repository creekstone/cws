<?php
/**
 * The template to display the widgets area in the header
 *
 * @package QWERY
 * @since QWERY 1.0
 */

// Header sidebar
$qwery_header_name    = qwery_get_theme_option( 'header_widgets' );
$qwery_header_present = ! qwery_is_off( $qwery_header_name ) && is_active_sidebar( $qwery_header_name );
if ( $qwery_header_present ) {
	qwery_storage_set( 'current_sidebar', 'header' );
	$qwery_header_wide = qwery_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $qwery_header_name ) ) {
		dynamic_sidebar( $qwery_header_name );
	}
	$qwery_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $qwery_widgets_output ) ) {
		$qwery_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $qwery_widgets_output );
		$qwery_need_columns   = strpos( $qwery_widgets_output, 'columns_wrap' ) === false;
		if ( $qwery_need_columns ) {
			$qwery_columns = max( 0, (int) qwery_get_theme_option( 'header_columns' ) );
			if ( 0 == $qwery_columns ) {
				$qwery_columns = min( 6, max( 1, qwery_tags_count( $qwery_widgets_output, 'aside' ) ) );
			}
			if ( $qwery_columns > 1 ) {
				$qwery_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $qwery_columns ) . ' widget', $qwery_widgets_output );
			} else {
				$qwery_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $qwery_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'qwery_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $qwery_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $qwery_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'qwery_action_before_sidebar', 'header' );
				qwery_show_layout( $qwery_widgets_output );
				do_action( 'qwery_action_after_sidebar', 'header' );
				if ( $qwery_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $qwery_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'qwery_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
