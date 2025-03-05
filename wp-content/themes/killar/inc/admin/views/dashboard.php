<?php
/**
 * Admin Dashboard
 *
 * @package KillarWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$is_verified = theme_license_verified();
?>
<?php if( !$is_verified ) { ?>
<div class="kwt-error mb-0"><?php esc_html_e( 'Activate your theme in order to be able to download and update addons.', 'killar' ); ?></div>
<?php } ?>
<div class="kwt-dashboard">
	<div class="kwt-row">
		<div class="kwt-col-12">
			<div class="kwt-panel activation-panel">
				<div class="kwt-panel-header">
					<div class="title"><?php esc_html_e( 'Purchase Code', 'killar' ); ?></div>
					<span class="activation-status"><?php echo wp_kses_post( ( $is_verified ) ? '<span class="act-status active">' . __( 'Activated', 'killar' ) . '</span>' : '<span class="act-status not-active">' . __( 'No Activated', 'killar' ) . '</span>' ); ?></span>
				</div>
				<div class="kwt-panel-content">
					<div class="kwt-messages"></div>
				<?php if ( $is_verified ) { ?>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Your product is registered now.', 'killar' ); ?></p>
						<p>
							<input type="text" class="regular-text txt-purchase-code" name="purchase_code" placeholder="<?php esc_attr_e( 'Enter Purchased Code', 'killar' ); ?>" required="" value="<?php echo KillarWT_Updater()->get_purchase_code_asterisk(); ?>" disabled>
							<input type="hidden" name="activation_actions" value="deactivate_theme">
							<input type="submit" class="button button-primary button-large kwt-large-button" value="<?php esc_attr_e( 'Deactive Theme', 'killar' ); ?>">
						</p>
					</form>
				<?php } else { ?>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Please enter your Purchase Code to complete registration.', 'killar' ); ?></p>
						<p>
							<input type="text" class="regular-text txt-purchase-code" name="purchase_code" placeholder="<?php esc_attr_e( 'Enter Purchased Code', 'killar' ); ?>" required="">
							<input type="hidden" name="activation_actions" value="activate_theme">
							<input type="submit" class="button button-primary button-large kwt-large-button" value="<?php esc_attr_e( 'Active Theme', 'killar' ); ?>">
							<p><?php echo wp_sprintf( __( 'You can find your purchase code', 'killar' ) . '<a href="%s" target="_blank"> here </a>','https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code' ); ?></p>
						</p>
					</form>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	//System Status
	require_once KILLARWT_ADMIN . '/views/system-status.php';
	?>
</div>