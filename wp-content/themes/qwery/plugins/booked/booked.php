<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'qwery_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'qwery_booked_theme_setup9', 9 );
	function qwery_booked_theme_setup9() {
		if ( qwery_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'qwery_booked_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'qwery_booked_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'qwery_booked_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'qwery_booked_frontend_scripts_responsive', 10, 1 );
			add_filter( 'qwery_filter_merge_styles', 'qwery_booked_merge_styles' );
			add_filter( 'qwery_filter_merge_styles_responsive', 'qwery_booked_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'qwery_filter_tgmpa_required_plugins', 'qwery_booked_tgmpa_required_plugins' );
			add_filter( 'qwery_filter_theme_plugins', 'qwery_booked_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'qwery_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('qwery_filter_tgmpa_required_plugins',	'qwery_booked_tgmpa_required_plugins');
	function qwery_booked_tgmpa_required_plugins( $list = array() ) {
		if ( qwery_storage_isset( 'required_plugins', 'booked' ) && qwery_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && qwery_is_theme_activated() ) {
			$path = qwery_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || qwery_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => qwery_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.4.3.1',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'qwery_booked_theme_plugins' ) ) {
	//Handler of the add_filter( 'qwery_filter_theme_plugins', 'qwery_booked_theme_plugins' );
	function qwery_booked_theme_plugins( $list = array() ) {
		return qwery_add_group_and_logo_to_slave( $list, 'booked', 'booked-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'qwery_exists_booked' ) ) {
	function qwery_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Return a relative path to the plugin styles depend the version
if ( ! function_exists( 'qwery_booked_get_styles_dir' ) ) {
	function qwery_booked_get_styles_dir( $file ) {
		$base_dir = 'plugins/booked/';
		return $base_dir
				. ( defined( 'BOOKED_VERSION' ) && version_compare( BOOKED_VERSION, '2.4', '<' ) && qwery_get_folder_dir( $base_dir . 'old' )
					? 'old/'
					: ''
					)
				. $file;
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'qwery_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'qwery_booked_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'qwery_booked_frontend_scripts', 10, 1 );
	function qwery_booked_frontend_scripts( $force = false ) {
		qwery_enqueue_optimized( 'booked', $force, array(
			'css' => array(
				'qwery-booked' => array( 'src' => qwery_booked_get_styles_dir( 'booked.css' ) ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'qwery_booked_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'qwery_booked_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'qwery_booked_frontend_scripts_responsive', 10, 1 );
	function qwery_booked_frontend_scripts_responsive( $force = false ) {
		qwery_enqueue_optimized_responsive( 'booked', $force, array(
			'css' => array(
				'qwery-booked-responsive' => array( 'src' => qwery_booked_get_styles_dir( 'booked-responsive.css' ), 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'qwery_booked_merge_styles' ) ) {
	//Handler of the add_filter('qwery_filter_merge_styles', 'qwery_booked_merge_styles');
	function qwery_booked_merge_styles( $list ) {
		$list[ qwery_booked_get_styles_dir( 'booked.css' ) ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'qwery_booked_merge_styles_responsive' ) ) {
	//Handler of the add_filter('qwery_filter_merge_styles_responsive', 'qwery_booked_merge_styles_responsive');
	function qwery_booked_merge_styles_responsive( $list ) {
		$list[ qwery_booked_get_styles_dir( 'booked-responsive.css' ) ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( qwery_exists_booked() ) {
	$qwery_fdir = qwery_get_file_dir( qwery_booked_get_styles_dir( 'booked-style.php' ) );
	if ( ! empty( $qwery_fdir ) ) {
		require_once $qwery_fdir;
	}
}
