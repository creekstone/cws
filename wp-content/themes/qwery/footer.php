<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package QWERY
 * @since QWERY 1.0
 */

							do_action( 'qwery_action_page_content_end_text' );
							
							// Widgets area below the content
							qwery_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'qwery_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'qwery_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'qwery_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'qwery_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$qwery_body_style = qwery_get_theme_option( 'body_style' );
					$qwery_widgets_name = qwery_get_theme_option( 'widgets_below_page' );
					$qwery_show_widgets = ! qwery_is_off( $qwery_widgets_name ) && is_active_sidebar( $qwery_widgets_name );
					$qwery_show_related = qwery_is_single() && qwery_get_theme_option( 'related_position' ) == 'below_page';
					if ( $qwery_show_widgets || $qwery_show_related ) {
						if ( 'fullscreen' != $qwery_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $qwery_show_related ) {
							do_action( 'qwery_action_related_posts' );
						}

						// Widgets area below page content
						if ( $qwery_show_widgets ) {
							qwery_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $qwery_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'qwery_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'qwery_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! qwery_is_singular( 'post' ) && ! qwery_is_singular( 'attachment' ) ) || ! in_array ( qwery_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="qwery_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'qwery_action_before_footer' );

				// Footer
				$qwery_footer_type = qwery_get_theme_option( 'footer_type' );
				if ( 'custom' == $qwery_footer_type && ! qwery_is_layouts_available() ) {
					$qwery_footer_type = 'default';
				}
				get_template_part( apply_filters( 'qwery_filter_get_template_part', "templates/footer-" . sanitize_file_name( $qwery_footer_type ) ) );

				do_action( 'qwery_action_after_footer' );

			}
			?>

			<?php do_action( 'qwery_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'qwery_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'qwery_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>