<?php
/**
 * SignIn Mobile Header Right Content
 *
 * @package KillarWT
 * @since 1.0.0
 */
$current_user = wp_get_current_user();

$account_url = get_permalink( get_option('woocommerce_myaccount_page_id') );

$link_attr = array();
$link_attr['href'] = esc_url( $account_url );
?>
<div class="mobile_nav">
<ul class="d-flex align-items-center">
	<?php do_action( 'killar_mob_header_right_sidebar_list_before' ); ?>
	<?php if( !empty( $current_user->ID ) ) {
		$link_attr['class'] = array( 'btn btn-sm btn-order-by-filt' );
		$link_attr['title'] = esc_attr( 'My Account', 'killar' );
		?>
		<li class="account-drop">
			<a <?php echo killarwt_stringify_atts( $link_attr ); ?>><?php echo get_avatar( $current_user->user_email, 128, '', '',  [ 'class' => "img-fluid circle" ] ) ?></a>
		</li>
	<?php } else { 
		$link_attr['class'] = array( 'btn btn-sm btn-info login-register-action' );
		if ( ! ( function_exists('is_account_page') && is_account_page() ) ) {
			$link_attr['data-bs-toggle'] = 'modal';
			$link_attr['data-bs-class'] = 'login-modal';
			$link_attr['data-bs-target'] = '#login-register-popup';
		}
		?>
		<li><a <?php echo killarwt_stringify_atts( $link_attr ); ?>><i class="fas fa-sign-in-alt me-2"></i><?php esc_html_e( 'Sign In', 'killar' ); ?></a></li>
	<?php } ?>
	<?php do_action( 'killar_mob_header_right_sidebar_list_after' ); ?>
</ul>
</div>