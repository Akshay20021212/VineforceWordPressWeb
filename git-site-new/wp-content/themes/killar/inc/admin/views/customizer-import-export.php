<?php
/**
 * Import / Export View
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if( !theme_license_verified() ) { ?>
<div class="kwt-error mb-0"><?php esc_html_e( 'Activate your theme in order to be able to import/export settings.', 'killar' ); ?></div>
<?php } else { ?>
<div class="kwt-dashboard">
	<div class="kwt-row">
		<div class="kwt-col-12">
			<div class="kwt-info mb-0"><?php esc_html_e( 'Export Customizer settings of the current theme and import on a Child Theme or use to create your own default styling for the next website.', 'killar' ); ?></div>
		</div>
	</div>
	<div class="kwt-row">
		<div class="kwt-col-12">
			<div class="kwt-panel activation-panel">
				<div class="kwt-panel-header">
					<div class="title"><?php esc_html_e( 'Export', 'killar' ); ?></div>
				</div>
				<div class="kwt-panel-content">
					<div class="kwt-messages"></div>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'killar' ); ?></p>
						<input type="button" class="button" name="wt-cie-export-button" value="<?php esc_attr_e( 'Export', 'killar' ); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="kwt-row">
		<div class="kwt-col-12">
			
			<div class="kwt-panel activation-panel">
				<div class="kwt-panel-header">
					<div class="title"><?php esc_html_e( 'Import', 'killar' ); ?></div>
				</div>
				<div class="kwt-panel-content">
					
						<?php 
						global $cie_error, $cie_success;
						if ( $cie_error ) {
							echo '<script> alert("' . $cie_error . '"); </script>';
						}
						if( !empty( $cie_success ) ) {
							echo '<div class="kwt-success">' . wp_kses_post( $cie_success ) . '</div>';
						}
						?>
					<form name="wt-cie-import-from" class="cie-form" method="POST" enctype="multipart/form-data">
						<p class="about-description"><?php esc_html_e( 'Choose a valid .dat file, previously generated using the Export Customizer Styling option.', 'killar' ); ?></p>
						<p><input type="file" name="wt-cie-import-file" class="wt-cie-import-file"></p>
						<?php wp_nonce_field( 'wt-cie-importing', 'wt-cie-import' ); ?>
						<div class="cie-uploading kwt-loader">Uploading...</div>
						<input type="button" class="button" name="wt-cie-import-button" value="<?php esc_attr_e( 'Import', 'killar' ); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>