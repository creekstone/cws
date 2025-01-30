<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'qwery_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'qwery_elegro_payment_theme_setup9', 9 );
	function qwery_elegro_payment_theme_setup9() {
		if ( qwery_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'qwery_elegro_payment_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'qwery_elegro_payment_frontend_scripts', 10, 1 );
			add_filter( 'qwery_filter_merge_styles', 'qwery_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'qwery_filter_tgmpa_required_plugins', 'qwery_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'qwery_elegro_payment_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('qwery_filter_tgmpa_required_plugins',	'qwery_elegro_payment_tgmpa_required_plugins');
	function qwery_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( qwery_storage_isset( 'required_plugins', 'woocommerce' ) && qwery_storage_isset( 'required_plugins', 'elegro-payment' ) && qwery_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => qwery_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'qwery_exists_elegro_payment' ) ) {
	function qwery_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'qwery_elegro_payment_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'qwery_elegro_payment_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'qwery_elegro_payment_frontend_scripts', 10, 1 );
	function qwery_elegro_payment_frontend_scripts( $force = false ) {
		qwery_enqueue_optimized( 'elegro_payment', $force, array(
			'css' => array(
				'qwery-elegro-payment' => array( 'src' => 'plugins/elegro-payment/elegro-payment.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'qwery_elegro_payment_merge_styles' ) ) {
	//Handler of the add_filter('qwery_filter_merge_styles', 'qwery_elegro_payment_merge_styles');
	function qwery_elegro_payment_merge_styles( $list ) {
		$list[ 'plugins/elegro-payment/elegro-payment.css' ] = false;
		return $list;
	}
}
