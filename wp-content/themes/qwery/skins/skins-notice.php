<?php
/**
 * The template to display Admin notices
 *
 * @package QWERY
 * @since QWERY 1.0.64
 */

$qwery_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$qwery_skins_args = get_query_var( 'qwery_skins_notice_args' );
?>
<div class="qwery_admin_notice qwery_skins_notice notice notice-info is-dismissible" data-notice="skins">
	<?php
	// Theme image
	$qwery_theme_img = qwery_get_file_url( 'screenshot.jpg' );
	if ( '' != $qwery_theme_img ) {
		?>
		<div class="qwery_notice_image"><img src="<?php echo esc_url( $qwery_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'qwery' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="qwery_notice_title">
		<?php esc_html_e( 'New skins are available', 'qwery' ); ?>
	</h3>
	<?php

	// Description
	$qwery_total      = $qwery_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$qwery_skins_msg  = $qwery_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $qwery_total, 'qwery' ), $qwery_total ) . '</strong>'
							: '';
	$qwery_total      = $qwery_skins_args['free'];
	$qwery_skins_msg .= $qwery_total > 0
							? ( ! empty( $qwery_skins_msg ) ? ' ' . esc_html__( 'and', 'qwery' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $qwery_total, 'qwery' ), $qwery_total ) . '</strong>'
							: '';
	$qwery_total      = $qwery_skins_args['pay'];
	$qwery_skins_msg .= $qwery_skins_args['pay'] > 0
							? ( ! empty( $qwery_skins_msg ) ? ' ' . esc_html__( 'and', 'qwery' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $qwery_total, 'qwery' ), $qwery_total ) . '</strong>'
							: '';
	?>
	<div class="qwery_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'qwery' ), $qwery_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="qwery_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $qwery_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'qwery' );
			?>
		</a>
	</div>
</div>
