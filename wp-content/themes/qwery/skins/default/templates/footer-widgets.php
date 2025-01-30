<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package QWERY
 * @since QWERY 1.0.10
 */

// Footer sidebar
$qwery_footer_name    = qwery_get_theme_option( 'footer_widgets' );
$qwery_footer_present = ! qwery_is_off( $qwery_footer_name ) && is_active_sidebar( $qwery_footer_name );
if ( $qwery_footer_present ) {
	qwery_storage_set( 'current_sidebar', 'footer' );
	$qwery_footer_wide = qwery_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $qwery_footer_name ) ) {
		dynamic_sidebar( $qwery_footer_name );
	}
	$qwery_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $qwery_out ) ) {
		$qwery_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $qwery_out );
		$qwery_need_columns = true;   //or check: strpos($qwery_out, 'columns_wrap')===false;
		if ( $qwery_need_columns ) {
			$qwery_columns = max( 0, (int) qwery_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $qwery_columns ) {
				$qwery_columns = min( 4, max( 1, qwery_tags_count( $qwery_out, 'aside' ) ) );
			}
			if ( $qwery_columns > 1 ) {
				$qwery_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $qwery_columns ) . ' widget', $qwery_out );
			} else {
				$qwery_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $qwery_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'qwery_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $qwery_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $qwery_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'qwery_action_before_sidebar', 'footer' );
				qwery_show_layout( $qwery_out );
				do_action( 'qwery_action_after_sidebar', 'footer' );
				if ( $qwery_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $qwery_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'qwery_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
