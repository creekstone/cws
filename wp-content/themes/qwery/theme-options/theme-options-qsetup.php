<?php
/**
 * Quick Setup Section in the Theme Panel
 *
 * @package QWERY
 * @since QWERY 1.0.48
 */


// Load required styles and scripts for admin mode
if ( ! function_exists( 'qwery_options_qsetup_add_scripts' ) ) {
	add_action("admin_enqueue_scripts", 'qwery_options_qsetup_add_scripts');
	function qwery_options_qsetup_add_scripts() {
		if ( ! QWERY_THEME_FREE ) {
			$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
			if ( is_object( $screen ) && ! empty( $screen->id ) && false !== strpos($screen->id, 'page_trx_addons_theme_panel') ) {
				wp_enqueue_style( 'qwery-fontello', qwery_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
				wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'jquery-ui-accordion', false, array( 'jquery', 'jquery-ui-core' ), null, true );
				wp_enqueue_script( 'qwery-options', qwery_get_file_url( 'theme-options/theme-options.js' ), array( 'jquery' ), null, true );
				wp_localize_script( 'qwery-options', 'qwery_dependencies', qwery_get_theme_dependencies() );
				wp_localize_script(	'qwery-options', 'qwery_options_vars', apply_filters(
					'qwery_filter_options_vars', array(
						'max_load_fonts'            => qwery_get_theme_setting( 'max_load_fonts' ),
						'save_only_changed_options' => qwery_get_theme_setting( 'save_only_changed_options' ),
					)
				) );
			}
		}
	}
}


// Add step to the 'Quick Setup'
if ( ! function_exists( 'qwery_options_qsetup_theme_panel_steps' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_steps', 'qwery_options_qsetup_theme_panel_steps' );
	function qwery_options_qsetup_theme_panel_steps( $steps ) {
		if ( ! QWERY_THEME_FREE ) {
			$steps = qwery_array_merge( $steps, array( 'qsetup' => esc_html__( 'Start customizing your theme.', 'qwery' ) ) );
		}
		return $steps;
	}
}


// Add tab link 'Quick Setup'
if ( ! function_exists( 'qwery_options_qsetup_theme_panel_tabs' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_tabs', 'qwery_options_qsetup_theme_panel_tabs' );
	function qwery_options_qsetup_theme_panel_tabs( $tabs ) {
		if ( ! QWERY_THEME_FREE ) {
			qwery_array_insert_after( $tabs, 'plugins', array( 'qsetup' => esc_html__( 'Quick Setup', 'qwery' ) ) );
		}
		return $tabs;
	}
}

// Add accent colors to the 'Quick Setup' section in the Theme Panel
if ( ! function_exists( 'qwery_options_qsetup_add_accent_colors' ) ) {
	add_filter( 'qwery_filter_qsetup_options', 'qwery_options_qsetup_add_accent_colors' );
	function qwery_options_qsetup_add_accent_colors( $options ) {
		return qwery_array_merge(
			array(
				'colors_info'        => array(
					'title'    => esc_html__( 'Theme Colors', 'qwery' ),
					'desc'     => '',
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'info',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_link' ) => array(
					'title'    => esc_html__( 'Accent color 1', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the links", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_link' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_hover' ) => array(
					'title'    => esc_html__( 'Accent color 1 (hovered state)', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the hovered state of the links", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_hover' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_link2' )  => array(
					'title'    => esc_html__( 'Accent color 2', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the accented areas", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_link2' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_hover2' ) => array(
					'title'    => esc_html__( 'Accent color 2 (hovered state)', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the hovered state of the accented areas", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_hover2' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_link3' )  => array(
					'title'    => esc_html__( 'Accent color 3', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the another accented areas", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_link3' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
				'colors_' . qwery_get_scheme_color_name( 'text_hover3' ) => array(
					'title'    => esc_html__( 'Accent color 3 (hovered state)', 'qwery' ),
					'desc'     => wp_kses_data( __( "Color of the hovered state of the another accented areas", 'qwery' ) ),
					'std'      => '',
					'val'      => qwery_get_scheme_color( 'text_hover3' ),
					'qsetup'   => esc_html__( 'General', 'qwery' ),
					'type'     => 'color',
				),
			),
			$options
		);
	}
}

// Display 'Quick Setup' section in the Theme Panel
if ( ! function_exists( 'qwery_options_qsetup_theme_panel_section' ) ) {
	add_action( 'trx_addons_action_theme_panel_section', 'qwery_options_qsetup_theme_panel_section', 10, 2);
	function qwery_options_qsetup_theme_panel_section( $tab_id, $theme_info ) {
		if ( 'qsetup' !== $tab_id ) return;
		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">

			<?php do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info); ?>
			
			<div class="trx_addons_theme_panel_section_content trx_addons_theme_panel_qsetup">

				<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>

				<h1 class="trx_addons_theme_panel_section_title">
					<?php esc_html_e( 'Quick Setup', 'qwery' ); ?>
				</h1>

				<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>
				
				<div class="trx_addons_theme_panel_section_description">
					<p>
						<?php
						echo wp_kses_data( __( 'Here you can customize the basic settings of your website.', 'qwery' ) )
							. ' '
							. wp_kses_data( sprintf(
								__( 'For a detailed customization, go to %s.', 'qwery' ),
								'<a href="' . esc_url(admin_url() . 'customize.php') . '">' . esc_html__( 'Customizer', 'qwery' ) . '</a>'
								. ( QWERY_THEME_FREE 
									? ''
									: ' ' . esc_html__( 'or', 'qwery' ) . ' ' . '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ) . '">' . esc_html__( 'Theme Options', 'qwery' ) . '</a>'
									)
								)
							);
						echo ' ' . wp_kses_data( __( "If you've imported the demo data, you may skip this step, since all the necessary settings have already been applied.", 'qwery' ) );
						?>
					</p>
				</div>

				<?php
				do_action('trx_addons_action_theme_panel_before_qsetup', $tab_id, $theme_info);

				qwery_options_qsetup_show();

				do_action('trx_addons_action_theme_panel_after_qsetup', $tab_id, $theme_info);

				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);
				?>

			</div>

			<?php do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info); ?>

		</div>
		<?php
	}
}


// Display options
if ( ! function_exists( 'qwery_options_qsetup_show' ) ) {
	function qwery_options_qsetup_show() {
		$tabs_titles  = array();
		$tabs_content = array();
		$options      = apply_filters( 'qwery_filter_qsetup_options', qwery_storage_get( 'options' ) );
		// Show fields
		$cnt = 0;
		foreach ( $options as $k => $v ) {
			if ( empty( $v['qsetup'] ) ) {
				continue;
			}
			if ( is_bool( $v['qsetup'] ) ) {
				$v['qsetup'] = esc_html__( 'General', 'qwery' );
			}
			if ( ! isset( $tabs_titles[ $v['qsetup'] ] ) ) {
				$tabs_titles[ $v['qsetup'] ]  = $v['qsetup'];
				$tabs_content[ $v['qsetup'] ] = '';
			}
			if ( 'info' !== $v['type'] ) {
				$cnt++;
				if ( ! empty( $v['class'] ) ) {
					$v['class'] = str_replace( array( 'qwery_column-1_2', 'qwery_new_row' ), '', $v['class'] );
				}
				$v['class'] = ( ! empty( $v['class'] ) ? $v['class'] . ' ' : '' ) . 'qwery_column-1_2' . ( $cnt % 2 == 1 ? ' qwery_new_row' : '' );
			} else {
				$cnt = 0;
			}
			$tabs_content[ $v['qsetup'] ] .= qwery_options_show_field( $k, $v );
		}
		if ( count( $tabs_titles ) > 0 ) {
			?>
			<div class="qwery_options qwery_options_qsetup">
				<form action="<?php echo esc_url( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel' ) ); ?>" class="trx_addons_theme_panel_section_form" name="trx_addons_theme_panel_qsetup_form" method="post">
					<input type="hidden" name="qsetup_options_nonce" value="<?php echo esc_attr( wp_create_nonce( admin_url() ) ); ?>" />
					<?php
					if ( count( $tabs_titles ) > 1 ) {
						?>
						<div id="qwery_options_tabs" class="qwery_tabs">
							<ul>
								<?php
								$cnt = 0;
								foreach ( $tabs_titles as $k => $v ) {
									$cnt++;
									?>
									<li><a href="#qwery_options_<?php echo esc_attr( $cnt ); ?>"><?php echo esc_html( $v ); ?></a></li>
									<?php
								}
								?>
							</ul>
							<?php
							$cnt = 0;
							foreach ( $tabs_content as $k => $v ) {
								$cnt++;
								?>
								<div id="qwery_options_<?php echo esc_attr( $cnt ); ?>" class="qwery_tabs_section qwery_options_section">
									<?php qwery_show_layout( $v ); ?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					} else {
						?>
						<div class="qwery_options_section">
							<?php qwery_show_layout( qwery_array_get_first( $tabs_content, false ) ); ?>
						</div>
						<?php
					}
					?>
					<div class="qwery_options_buttons trx_buttons">
						<a href="#" class="qwery_options_button_submit trx_addons_button trx_addons_button_accent" tabindex="0"><?php esc_html_e( 'Save Options', 'qwery' ); ?></a>
					</div>
				</form>
			</div>
			<?php
		}
	}
}


// Save quick setup options
if ( ! function_exists( 'qwery_options_qsetup_save_options' ) ) {
	add_action( 'after_setup_theme', 'qwery_options_qsetup_save_options', 4 );
	function qwery_options_qsetup_save_options() {

		if ( ! isset( $_REQUEST['page'] ) || 'trx_addons_theme_panel' != $_REQUEST['page'] || '' == qwery_get_value_gp( 'qsetup_options_nonce' ) ) {
			return;
		}

		// verify nonce
		if ( ! wp_verify_nonce( qwery_get_value_gp( 'qsetup_options_nonce' ), admin_url() ) ) {
			trx_addons_set_admin_message( esc_html__( 'Bad security code! Options are not saved!', 'qwery' ), 'error', true );
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			trx_addons_set_admin_message( esc_html__( 'Manage options is denied for the current user! Options are not saved!', 'qwery' ), 'error', true );
			return;
		}

		// Prepare colors for Theme Options
		$scheme_storage = get_theme_mod( 'scheme_storage' );
		if ( empty( $scheme_storage ) ) {
			$scheme_storage = qwery_get_scheme_storage();
		}
		if ( ! empty( $scheme_storage ) ) {
			$schemes = qwery_unserialize( $scheme_storage );
			if ( is_array( $schemes ) ) {
				$main_scheme = qwery_storage_get_array( 'schemes_sorted', 0 );
				$color_scheme = get_theme_mod( $main_scheme, qwery_storage_get_array( 'options', $main_scheme, 'std' ) );
				if ( empty( $color_scheme ) ) {
					$color_scheme = qwery_array_get_first( $schemes );
				}
				if ( ! empty( $schemes[ $color_scheme ] ) ) {
					$schemes_simple = qwery_storage_get( 'schemes_simple' );
					// Get posted data and calculate substitutions
					$need_save = false;
					foreach ( $schemes[ $color_scheme ][ 'colors' ] as $k => $v ) {
						$v2 = qwery_get_value_gp( "qwery_options_field_colors_{$k}" );
						if ( ! empty( $v2 ) && $v != $v2 ) {
							$schemes[ $color_scheme ][ 'colors' ][ $k ] = $v2;
							$need_save = true;
							// Сalculate substitutions
							if ( isset( $schemes_simple[ $k ] ) && is_array( $schemes_simple[ $k ] ) ) {
								foreach ( $schemes_simple[ $k ] as $color => $level ) {
									$new_v2 = $v2;
									// Make color_value darker or lighter
									if ( 1 != $level ) {
										$hsb = qwery_hex2hsb( $new_v2 );
										$hsb[ 'b' ] = min( 100, max( 0, $hsb[ 'b' ] * ( $hsb[ 'b' ] < 70 ? 2 - $level : $level ) ) );
										$new_v2 = qwery_hsb2hex( $hsb );
									}
									$schemes[ $color_scheme ][ 'colors' ][ $color ] = $new_v2;
								}
							}
						}
					}
					// Put new values to the POST
					if ( $need_save ) {
						$_POST[ 'qwery_options_field_scheme_storage' ] = serialize( $schemes );
					}
				}
			}
		}

		// Save options
		qwery_options_update( null, 'qwery_options_field_' );

		// Return result
		trx_addons_set_admin_message( esc_html__( 'Options are saved', 'qwery' ), 'success', true );
		wp_redirect( get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_qsetup' ) );
		exit();
	}
}
