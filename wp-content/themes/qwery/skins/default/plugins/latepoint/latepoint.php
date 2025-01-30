<?php
/* LatePoint support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('qwery_latepoint_theme_setup9')) {
	add_action( 'after_setup_theme', 'qwery_latepoint_theme_setup9', 9 );
	function qwery_latepoint_theme_setup9() {
		if (is_admin()) {
			add_filter( 'qwery_filter_tgmpa_required_plugins',		'qwery_latepoint_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'qwery_latepoint_tgmpa_required_plugins' ) ) {
	function qwery_latepoint_tgmpa_required_plugins($list=array()) {
		if (qwery_storage_isset('required_plugins', 'latepoint') && qwery_storage_get_array( 'required_plugins', 'latepoint', 'install' ) !== false) {
			$path = qwery_get_plugin_source_path( 'plugins/latepoint/latepoint.zip' );
			if ( ! empty( $path ) || qwery_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => qwery_storage_get_array( 'required_plugins', 'latepoint', 'title' ),
					'slug'     => 'latepoint',
					'source'   => ! empty( $path ) ? $path : 'upload://latepoint.zip',
					'version'  => '3.1.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'qwery_exists_latepoint' ) ) {
	function qwery_exists_latepoint() {
		return class_exists('LatePoint');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'qwery_latepoint_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'qwery_latepoint_importer_required_plugins', 10, 2 );
    function qwery_latepoint_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'latepoint')!==false && !qwery_exists_latepoint() )
            $not_installed .= '<br>' . esc_html__('LatePoint', 'qwery');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'qwery_latepoint_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'qwery_latepoint_importer_set_options' );
	function qwery_latepoint_importer_set_options($options=array()) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'latepoint_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_latepoint'] = str_replace('name.ext', 'latepoint.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( !function_exists( 'qwery_latepoint_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'qwery_latepoint_importer_check_options', 10, 4 );
	function qwery_latepoint_importer_check_options($allow, $k, $v, $options) {
		if ($allow && (strpos($k, 'latepoint_')===0) ) {
			$allow = qwery_exists_latepoint() && in_array('latepoint', $options['required_plugins']);
		}
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'qwery_latepoint_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params',	'qwery_latepoint_importer_show_params', 10, 1 );
	function qwery_latepoint_importer_show_params($importer) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'latepoint',
				'title' => esc_html__('Import LatePoint', 'qwery'),
				'part' => 0
			));
		}
	}
}


// Display import progress
if ( !function_exists( 'qwery_latepoint_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields',	'qwery_latepoint_importer_import_fields', 10, 1 );
	function qwery_latepoint_importer_import_fields($importer) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
					'slug'=>'latepoint',
					'title' => esc_html__('LatePoint meta', 'qwery')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'qwery_latepoint_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export',	'qwery_latepoint_importer_export', 10, 1 );
	function qwery_latepoint_importer_export($importer) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $importer->options['required_plugins']) ) {
			trx_addons_fpc($importer->export_file_dir('latepoint.txt'), serialize( array(
					"latepoint_activities"						=> $importer->export_dump("latepoint_activities"),
					"latepoint_agents"							=> $importer->export_dump("latepoint_agents "),
					"latepoint_agents_services"					=> $importer->export_dump("latepoint_agents_services"),
					"latepoint_agent_meta"						=> $importer->export_dump("latepoint_agent_meta"),
					"latepoint_bookings"						=> $importer->export_dump("latepoint_bookings"),
					"latepoint_booking_intents"					=> $importer->export_dump("latepoint_booking_intents"),
					"latepoint_booking_meta"					=> $importer->export_dump("latepoint_booking_meta"),
					"latepoint_customers"						=> $importer->export_dump("latepoint_customers"),
					"latepoint_customer_meta"					=> $importer->export_dump("latepoint_customer_meta"),
					"latepoint_custom_prices"					=> $importer->export_dump("latepoint_custom_prices"),
					"latepoint_locations"						=> $importer->export_dump("latepoint_locations"),
					"latepoint_location_categories"				=> $importer->export_dump("latepoint_location_categories"),
					"latepoint_processes"						=> $importer->export_dump("latepoint_processes"),
					"latepoint_process_jobs"					=> $importer->export_dump("latepoint_process_jobs"),
					"latepoint_sent_reminders"					=> $importer->export_dump("latepoint_sent_reminders"),
					"latepoint_services"						=> $importer->export_dump("latepoint_services"),
					"latepoint_service_categories"				=> $importer->export_dump("latepoint_service_categories"),
					"latepoint_service_meta"					=> $importer->export_dump("latepoint_service_meta"),
					"latepoint_sessions"						=> $importer->export_dump("latepoint_sessions"),
					"latepoint_settings"						=> $importer->export_dump("latepoint_settings"),
					"latepoint_step_setting"					=> $importer->export_dump("latepoint_step_settings"),
					"latepoint_transactions"					=> $importer->export_dump("latepoint_transactions"),
					"latepoint_work_periods"					=> $importer->export_dump("latepoint_work_periods"),
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'qwery_latepoint_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields',	'qwery_latepoint_importer_export_fields', 10, 1 );
	function qwery_latepoint_importer_export_fields($importer) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
					'slug'	=> 'latepoint',
					'title' => esc_html__('LatePoint', 'qwery')
				)
			);
		}
	}
}

// Import posts
if ( !function_exists( 'qwery_latepoint_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import', 'qwery_latepoint_importer_import', 10, 2 );
	function qwery_latepoint_importer_import($importer, $action) {
		if ( qwery_exists_latepoint() && in_array('latepoint', $importer->options['required_plugins']) ) {
			if ( $action == 'import_latepoint' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('latepoint', esc_html__('LatePoint meta', 'qwery'));
			}
		}
	}
}

?>