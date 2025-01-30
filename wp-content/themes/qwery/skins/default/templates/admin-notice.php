<?php
/**
 * The template to display Admin notices
 *
 * @package QWERY
 * @since QWERY 1.0.1
 */

$qwery_theme_slug = get_option( 'template' );
$qwery_theme_obj  = wp_get_theme( $qwery_theme_slug );
?>
<div class="qwery_admin_notice qwery_welcome_notice notice notice-info is-dismissible" data-notice="admin">
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
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'qwery' ),
				$qwery_theme_obj->get( 'Name' ) . ( QWERY_THEME_FREE ? ' ' . __( 'Free', 'qwery' ) : '' ),
				$qwery_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="qwery_notice_text">
		<p class="qwery_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $qwery_theme_obj->description ) );
			?>
		</p>
		<p class="qwery_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'qwery' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="qwery_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=qwery_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'qwery' );
			?>
		</a>
	</div>
</div>
