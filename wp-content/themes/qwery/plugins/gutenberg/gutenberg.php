<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'qwery_gutenberg_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'qwery_gutenberg_theme_setup9', 9 );
	function qwery_gutenberg_theme_setup9() {

		// Add wide and full blocks support
		add_theme_support( 'align-wide' );

		// Add editor styles to backend
		add_theme_support( 'editor-styles' );
		if ( is_admin() && ( ! is_rtl() || ! is_customize_preview() ) ) {
			if ( qwery_exists_gutenberg() && qwery_gutenberg_is_preview() ) {
				if ( ! qwery_get_theme_setting( 'gutenberg_add_context' ) ) {
					if ( ! qwery_exists_trx_addons() ) {
						// Attention! This place need to use 'trx_addons_filter' instead 'qwery_filter'
						add_editor_style( apply_filters( 'trx_addons_filter_add_editor_style', array(), 'gutenberg' ) );
					}
				}
			} else {
				add_editor_style( apply_filters( 'qwery_filter_add_editor_style', array(
					qwery_get_file_url( 'css/font-icons/css/fontello.css' ),
					qwery_get_file_url( 'css/editor-style.css' )
					), 'editor' )
				);
			}
		}

		if ( qwery_exists_gutenberg() ) {
			add_action( 'wp_enqueue_scripts', 'qwery_gutenberg_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'qwery_gutenberg_responsive_styles', 2000 );
			add_filter( 'qwery_filter_merge_styles', 'qwery_gutenberg_merge_styles' );
			add_filter( 'qwery_filter_merge_styles_responsive', 'qwery_gutenberg_merge_styles_responsive' );
		}
		add_action( 'enqueue_block_editor_assets', 'qwery_gutenberg_editor_scripts' );
		add_filter( 'qwery_filter_localize_script_admin',	'qwery_gutenberg_localize_script');
		add_action( 'after_setup_theme', 'qwery_gutenberg_add_editor_colors' );
		if ( is_admin() ) {
			add_filter( 'qwery_filter_tgmpa_required_plugins', 'qwery_gutenberg_tgmpa_required_plugins' );
			add_filter( 'qwery_filter_theme_plugins', 'qwery_gutenberg_theme_plugins' );
		}
	}
}

// Add theme's icons styles to the Gutenberg editor
if ( ! function_exists( 'qwery_gutenberg_add_editor_style_icons' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'qwery_gutenberg_add_editor_style_icons', 10 );
	function qwery_gutenberg_add_editor_style_icons( $styles ) {
		$qwery_url = qwery_get_file_url( 'css/font-icons/css/fontello.css' );
		if ( '' != $qwery_url ) {
			$styles[] = $qwery_url;
		}
		return $styles;
	}
}

// Add required styles to the Gutenberg editor
if ( ! function_exists( 'qwery_gutenberg_add_editor_style' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'qwery_gutenberg_add_editor_style', 1100 );
	function qwery_gutenberg_add_editor_style( $styles ) {
		$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' );
		if ( '' != $qwery_url ) {
			$styles[] = $qwery_url;
		}
		return $styles;
	}
}

// Add required styles to the Gutenberg editor
if ( ! function_exists( 'qwery_gutenberg_add_editor_style_responsive' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'qwery_gutenberg_add_editor_style_responsive', 2000 );
	function qwery_gutenberg_add_editor_style_responsive( $styles ) {
		$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg-preview-responsive.css' );
		if ( '' != $qwery_url ) {
			$styles[] = $qwery_url;
		}
		return $styles;
	}
}

// Add all skin-specific font-faces to the editor styles
if ( ! function_exists( 'qwery_gutenberg_add_editor_style_font_urls' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'qwery_gutenberg_add_editor_style_font_urls', 9990 );
	function qwery_gutenberg_add_editor_style_font_urls( $styles ) {
		return array_merge( $styles, qwery_theme_fonts_for_editor( true ) );
	}
}

// Remove main-theme and child-theme urls from the editor style paths
if ( ! function_exists( 'qwery_gutenberg_add_editor_style_remove_theme_url' ) ) {
	add_filter( 'trx_addons_filter_add_editor_style', 'qwery_gutenberg_add_editor_style_remove_theme_url', 9999 );
	function qwery_gutenberg_add_editor_style_remove_theme_url( $styles ) {
		if ( is_array( $styles ) ) {
			$template_uri   = trailingslashit( get_template_directory_uri() );
			$stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );
			$plugins_uri    = trailingslashit( defined( 'WP_PLUGIN_URL' ) ? WP_PLUGIN_URL : plugins_url() );
			$theme_replace  = '';
			$plugin_replace = '../'            // up to the folder 'themes'
								. '../'        // up to the folder 'wp-content'
								. 'plugins/';  // open the folder 'plugins'
			foreach( $styles as $k => $v ) {
				$styles[ $k ] = str_replace(
									array(
										$template_uri,
										strpos( $template_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $template_uri ) : $template_uri,
										$stylesheet_uri,
										strpos( $stylesheet_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $stylesheet_uri ) : $stylesheet_uri,
										$plugins_uri,
										strpos( $plugins_uri, 'http:' ) === 0 ? str_replace( 'http:', 'https:', $plugins_uri ) : $plugins_uri,
									),
									array(
										$theme_replace,
										$theme_replace,
										$theme_replace,
										$theme_replace,
										$plugin_replace,
										$plugin_replace,
									),
									$v
								);
			}
		}
		return $styles;
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'qwery_gutenberg_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('qwery_filter_tgmpa_required_plugins',	'qwery_gutenberg_tgmpa_required_plugins');
	function qwery_gutenberg_tgmpa_required_plugins( $list = array() ) {
		if ( qwery_storage_isset( 'required_plugins', 'gutenberg' ) ) {
			if ( qwery_storage_get_array( 'required_plugins', 'gutenberg', 'install' ) !== false && version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ) {
				$list[] = array(
					'name'     => qwery_storage_get_array( 'required_plugins', 'gutenberg', 'title' ),
					'slug'     => 'gutenberg',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'qwery_gutenberg_theme_plugins' ) ) {
	//Handler of the add_filter( 'qwery_filter_theme_plugins', 'qwery_gutenberg_theme_plugins' );
	function qwery_gutenberg_theme_plugins( $list = array() ) {
		$list = qwery_add_group_and_logo_to_slave( $list, 'gutenberg', 'coblocks' );
		$list = qwery_add_group_and_logo_to_slave( $list, 'gutenberg', 'kadence-blocks' );
		return $list;
	}
}


// Check if Gutenberg is installed and activated
if ( ! function_exists( 'qwery_exists_gutenberg' ) ) {
	function qwery_exists_gutenberg() {
		return function_exists( 'register_block_type' );
	}
}

// Return true if Gutenberg exists and current mode is preview
if ( ! function_exists( 'qwery_gutenberg_is_preview' ) ) {
	function qwery_gutenberg_is_preview() {
		return qwery_exists_gutenberg() 
				&& (
					qwery_gutenberg_is_block_render_action()
					||
					qwery_is_post_edit()
					||
					qwery_gutenberg_is_widgets_block_editor()
					||
					qwery_gutenberg_is_site_editor()
					);
	}
}

// Return true if current mode is "Full Site Editor"
if ( ! function_exists( 'qwery_gutenberg_is_site_editor' ) ) {
	function qwery_gutenberg_is_site_editor() {
		return is_admin()
				&& qwery_exists_gutenberg() 
				&& version_compare( get_bloginfo( 'version' ), '5.9', '>=' )
				&& qwery_check_url( 'site-editor.php' )
				&& qwery_gutenberg_is_fse_theme();
	}
}

// Return true if current mode is "Widgets Block Editor" (a new widgets panel with Gutenberg support)
if ( ! function_exists( 'qwery_gutenberg_is_widgets_block_editor' ) ) {
	function qwery_gutenberg_is_widgets_block_editor() {
		return is_admin()
				&& qwery_exists_gutenberg() 
				&& version_compare( get_bloginfo( 'version' ), '5.8', '>=' )
				&& qwery_check_url( 'widgets.php' )
				&& function_exists( 'wp_use_widgets_block_editor' )
				&& wp_use_widgets_block_editor();
	}
}

// Return true if current mode is "Block render"
if ( ! function_exists( 'qwery_gutenberg_is_block_render_action' ) ) {
	function qwery_gutenberg_is_block_render_action() {
		return qwery_exists_gutenberg() 
				&& qwery_check_url( 'block-renderer' ) && ! empty( $_GET['context'] ) && 'edit' == $_GET['context'];
	}
}

// Return true if content built with "Gutenberg"
if ( ! function_exists( 'qwery_gutenberg_is_content_built' ) ) {
	function qwery_gutenberg_is_content_built($content) {
		return qwery_exists_gutenberg() 
				&& has_blocks( $content );	// This condition is equval to: strpos($content, '<!-- wp:') !== false;
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'qwery_gutenberg_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'qwery_gutenberg_frontend_scripts', 1100 );
	function qwery_gutenberg_frontend_scripts() {
		if ( qwery_is_on( qwery_get_theme_option( 'debug_mode' ) ) ) {
			// Theme-specific styles
			$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg-general.css' );
			if ( '' != $qwery_url ) {
				wp_enqueue_style( 'qwery-gutenberg-general', $qwery_url, array(), null );
			}
			// Skin-specific styles
			$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg.css' );
			if ( '' != $qwery_url ) {
				wp_enqueue_style( 'qwery-gutenberg', $qwery_url, array(), null );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'qwery_gutenberg_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'qwery_gutenberg_responsive_styles', 2000 );
	function qwery_gutenberg_responsive_styles() {
		if ( qwery_is_on( qwery_get_theme_option( 'debug_mode' ) ) ) {
			// Theme-specific styles
			$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg-general-responsive.css' );
			if ( '' != $qwery_url ) {
				wp_enqueue_style( 'qwery-gutenberg-general-responsive', $qwery_url, array(), null, qwery_media_for_load_css_responsive( 'gutenberg-general' ) );
			}
			// Skin-specific styles
			$qwery_url = qwery_get_file_url( 'plugins/gutenberg/gutenberg-responsive.css' );
			if ( '' != $qwery_url ) {
				wp_enqueue_style( 'qwery-gutenberg-responsive', $qwery_url, array(), null, qwery_media_for_load_css_responsive( 'gutenberg' ) );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'qwery_gutenberg_merge_styles' ) ) {
	//Handler of the add_filter('qwery_filter_merge_styles', 'qwery_gutenberg_merge_styles');
	function qwery_gutenberg_merge_styles( $list ) {
		$list[ 'plugins/gutenberg/gutenberg-general.css' ] = true;
		$list[ 'plugins/gutenberg/gutenberg.css' ] = true;
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'qwery_gutenberg_merge_styles_responsive' ) ) {
	//Handler of the add_filter('qwery_filter_merge_styles_responsive', 'qwery_gutenberg_merge_styles_responsive');
	function qwery_gutenberg_merge_styles_responsive( $list ) {
		$list[ 'plugins/gutenberg/gutenberg-general-responsive.css' ] = true;
		$list[ 'plugins/gutenberg/gutenberg-responsive.css' ] = true;
		return $list;
	}
}


// Load required styles and scripts for Gutenberg Editor mode
if ( ! function_exists( 'qwery_gutenberg_editor_scripts' ) ) {
	//Handler of the add_action( 'enqueue_block_editor_assets', 'qwery_gutenberg_editor_scripts');
	function qwery_gutenberg_editor_scripts() {
		qwery_admin_scripts(true);
		qwery_admin_localize_scripts();
		// Editor styles
		wp_enqueue_style( 'qwery-gutenberg-editor', qwery_get_file_url( 'plugins/gutenberg/gutenberg-editor.css' ), array(), null );
		// Block styles
		if ( qwery_get_theme_setting( 'gutenberg_add_context' ) ) {
			wp_enqueue_style( 'qwery-gutenberg-preview', qwery_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' ), array(), null );
			wp_enqueue_style( 'qwery-gutenberg-preview-responsive', qwery_get_file_url( 'plugins/gutenberg/gutenberg-preview-responsive.css' ), array(), null );
		}
		// Load merged scripts ?????
		wp_enqueue_script( 'qwery-main', qwery_get_file_url( 'js/__scripts-full.js' ), apply_filters( 'qwery_filter_script_deps', array( 'jquery' ) ), null, true );
		// Editor scripts
		wp_enqueue_script( 'qwery-gutenberg-preview', qwery_get_file_url( 'plugins/gutenberg/gutenberg-preview.js' ), array( 'jquery' ), null, true );
	}
}

// Add plugin's specific variables to the scripts
if ( ! function_exists( 'qwery_gutenberg_localize_script' ) ) {
	//Handler of the add_filter( 'qwery_filter_localize_script_admin',	'qwery_gutenberg_localize_script');
	function qwery_gutenberg_localize_script( $arr ) {
		// Not overridden options
		$arr['color_scheme']     = qwery_get_theme_option( 'color_scheme' );
		// Overridden options
		$arr['override_classes'] = apply_filters( 'qwery_filter_override_options_list', array(
													'body_style'       => 'body_style_%s',
													'sidebar_position' => 'sidebar_position_%s',
													'expand_content'   => '%s_content'
									) );
		$post_id   = qwery_get_value_gpc( 'post' );
		$post_type = '';
		$post_slug = '';
		if ( qwery_gutenberg_is_preview() )  {
			if ( ! empty( $post_id ) ) {		// Edit post
				$post_type = qwery_get_edited_post_type();
				$meta = get_post_meta( $post_id, 'qwery_options', true );
			} else {							// New post
				$post_type = qwery_get_value_gpc( 'post_type' );
				if ( empty( $post_type ) ) {
					$post_type = 'post';
				}
			}
			if ( ! empty( $post_type ) ) {
				$post_slug = str_replace( 'cpt_', '', $post_type );
			}
		}
		foreach( $arr['override_classes'] as $opt => $class_mask ) {
			$arr[ $opt ] = 'inherit';
			if ( ! empty( $post_type ) ) {
				// Get an overridden value from the post meta
				if ( 'page' != $post_type && ! empty( $meta["{$opt}_single"] ) ) {
					$arr[ $opt ] = $meta["{$opt}_single"];
				} elseif ( 'page' == $post_type && ! empty( $meta[ $opt ] ) ) {
					$arr[ $opt ] = $meta[ $opt ];
				}
				// Get an overridden value from the theme options
				if ( 'inherit' == $arr[ $opt ] ) {
					if ( 'post' == $post_type ) {
						if ( qwery_check_theme_option( "{$opt}_single" ) ) {
							$arr[ $opt ] = qwery_get_theme_option( "{$opt}_single" );
						}
						if ( 'inherit' == $arr[ $opt ] && qwery_check_theme_option( "{$opt}_blog" ) ) {
							$arr[ $opt ] = qwery_get_theme_option( "{$opt}_blog" );
						}
					} else if ( 'page' != $post_type && qwery_check_theme_option( "{$opt}_single_" . sanitize_title( $post_slug ) ) ) {
						$arr[ $opt ] = qwery_get_theme_option( "{$opt}_single_" . sanitize_title( $post_slug ) );
						if ( 'inherit' == $arr[ $opt ] && qwery_check_theme_option( "{$opt}_" . sanitize_title( $post_slug ) ) ) {
							$arr[ $opt ] = qwery_get_theme_option( "{$opt}_" . sanitize_title( $post_slug ) );
						}
					}
				}
			}
			if ( 'inherit' == $arr[ $opt ] ) {
				$arr[ $opt ] = qwery_get_theme_option( $opt );
			}
		}
		return $arr;
	}
}

// Save CSS with custom colors and fonts to the gutenberg-preview.css
if ( ! function_exists( 'qwery_gutenberg_save_css' ) ) {
	add_action( 'qwery_action_save_options', 'qwery_gutenberg_save_css', 30 );
	add_action( 'trx_addons_action_save_options', 'qwery_gutenberg_save_css', 30 );
	function qwery_gutenberg_save_css() {

		$msg = '/* ' . esc_html__( "ATTENTION! This file was generated automatically! Don't change it!!!", 'qwery' )
				. "\n----------------------------------------------------------------------- */\n";

		$add_context = array(
							'context'      => '.edit-post-visual-editor ',
							'context_self' => array( 'html', 'body', '.edit-post-visual-editor' )
							);

		// Get main styles
		//----------------------------------------------
		$css = '';
		// Add styles from the theme style.css file is not recommended, because this file contains reset styles and it's can broke the editor styles
		if ( apply_filters( 'qwery_filter_add_style_css_to_gutenberg_preview', false ) ) {
			$css = qwery_fgc( qwery_get_file_dir( 'style.css' ) );
		}
		// Allow to add a skin-specific styles
		$css = apply_filters( 'qwery_filter_gutenberg_get_styles', $css );

		// Append single post styles
		if ( apply_filters( 'qwery_filters_separate_single_styles', false ) ) {
			$css .= qwery_fgc( qwery_get_file_dir( 'css/__single.css' ) );
		}
		// Append supported plugins styles
		$css .= qwery_fgc( qwery_get_file_dir( 'css/__plugins-full.css' ) );
		// Append theme-vars styles
		$css .= qwery_customizer_get_css();
		// Add context class to each selector
		if ( qwery_get_theme_setting( 'gutenberg_add_context' ) && function_exists( 'trx_addons_css_add_context' ) ) {
			$css = trx_addons_css_add_context( $css, $add_context );
		} else {
			$css = apply_filters( 'qwery_filter_prepare_css', $css );
		}

		// Get responsive styles
		//-----------------------------------------------
		$css_responsive = apply_filters( 'qwery_filter_gutenberg_get_styles_responsive',
								qwery_fgc( qwery_get_file_dir( 'css/__responsive-full.css' ) )
								. ( apply_filters( 'qwery_filters_separate_single_styles', false )
									? qwery_fgc( qwery_get_file_dir( 'css/__single-responsive.css' ) )
									: ''
									)
								);
		// Add context class to each selector
		if ( qwery_get_theme_setting( 'gutenberg_add_context' ) && function_exists( 'trx_addons_css_add_context' ) ) {
			$css_responsive = trx_addons_css_add_context( $css_responsive, $add_context );
		} else {
			$css_responsive = apply_filters( 'qwery_filter_prepare_css', $css_responsive );
		}

		// Save styles to separate files
		//-----------------------------------------------

		// Save responsive styles
		$preview = qwery_get_file_dir( 'plugins/gutenberg/gutenberg-preview-responsive.css' );
		if ( $preview ) {
			qwery_fpc( $preview, $msg . $css_responsive );
			$css_responsive = '';
		}
		// Save main styles (and append responsive if its not saved to the separate file)
		qwery_fpc( qwery_get_file_dir( 'plugins/gutenberg/gutenberg-preview.css' ), $msg . $css . $css_responsive );
	}
}


// Add theme-specific colors to the Gutenberg color picker
if ( ! function_exists( 'qwery_gutenberg_add_editor_colors' ) ) {
	//Handler of the add_action( 'after_setup_theme', 'qwery_gutenberg_add_editor_colors' );
	function qwery_gutenberg_add_editor_colors() {
		$scheme = qwery_get_scheme_colors();
		$groups = qwery_storage_get( 'scheme_color_groups' );
		$names  = qwery_storage_get( 'scheme_color_names' );
		$colors = array();
		foreach( $groups as $g => $group ) {
			foreach( $names as $n => $name ) {
				$c = 'main' == $g ? ( 'text' == $n ? 'text_color' : $n ) : $g . '_' . str_replace( 'text_', '', $n );
				if ( isset( $scheme[ $c ] ) ) {
					$colors[] = array(
						'slug'  => preg_replace( '/([a-z])([0-9])+/', '$1-$2', str_replace( '_', '-', $c ) ),
						'name'  => ( 'main' == $g ? '' : $group['title'] . ' ' ) . $name['title'],
						'color' => $scheme[ $c ]
					);
				}
			}
			// Add only one group of colors
			// Delete next condition (or add false && to them) to add all groups
			if ( 'main' == $g ) {
				break;
			}
		}
		add_theme_support( 'editor-color-palette', $colors );
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( qwery_exists_gutenberg() ) {
	$qwery_fdir = qwery_get_file_dir( 'plugins/gutenberg/gutenberg-style.php' );
	if ( ! empty( $qwery_fdir ) ) {
		require_once $qwery_fdir;
	}
	$qwery_fdir = qwery_get_file_dir( 'plugins/gutenberg/gutenberg-fse.php' );
	if ( ! empty( $qwery_fdir ) ) {
		require_once $qwery_fdir;
	}
}
