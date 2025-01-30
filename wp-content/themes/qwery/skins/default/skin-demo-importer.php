<?php
/**
 * Skin Demo importer
 *
 * @package QWERY
 * @since QWERY 1.76.0
 */


// Theme storage
//-------------------------------------------------------------------------

qwery_storage_set( 'theme_demo_url', '//qwery.ancorathemes.com' );

// Demofiles for RTL
function trl_theme_data($val, $param) {
	if($param== 'theme_demofiles_archive_name')
		$val = 'demo/default-rtl.zip';
	return $val;
}

//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'qwery_skin_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'qwery_skin_importer_set_options', 9 );
	function qwery_skin_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			$demo_type = function_exists( 'qwery_skins_get_current_skin_name' ) ? qwery_skins_get_current_skin_name() : 'default';
			if ($demo_type == 'default' && is_rtl()) {
				$demo_type = 'default-rtl';
				qwery_storage_set( 'theme_demo_url', '//rtl.qwery.ancorathemes.com' );
				add_filter( 'trx_addons_filter_get_theme_data', 'trl_theme_data', 10, 2 );
			}
			if ( 'default' != $demo_type ) {
				$options['demo_type'] = $demo_type;
				$options['files'][ $demo_type ] = $options['files']['default'];
				unset($options['files']['default']);
			}
			$options['files'][ $demo_type ]['title']       = esc_html__( 'Qwery Demo', 'qwery' );
			$options['files'][ $demo_type ]['domain_dev']  = '';  // Developers domain
			$options['files'][ $demo_type ]['domain_demo'] = qwery_storage_get( 'theme_demo_url' ); // Demo-site domain

			if ( substr( $options['files'][ $demo_type ]['domain_demo'], 0, 2 ) === '//' ) {
				$options['files'][ $demo_type ]['domain_demo'] = qwery_get_protocol() . ':' . $options['files'][ $demo_type ]['domain_demo'];
			}
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'qwery_skin_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'qwery_skin_ocdi_set_options', 9 );
	function qwery_skin_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Qwery OCDI Demo', 'qwery' );
			$options['files']['ocdi']['domain_demo'] = qwery_storage_get( 'theme_demo_url' );
			if ( substr( $options['files']['ocdi']['domain_demo'], 0, 2 ) === '//' ) {
				$options['files']['ocdi']['domain_demo'] = qwery_get_protocol() . ':' . $options['files']['ocdi']['domain_demo'];
			}
			// If theme need more demo - just copy 'default' and change required parameters
		}
		return $options;
	}
}
