<?php
/**
 * Header Shop Right Content
 *
 * @package KillarWT
 * @since 1.0.0
 */

if (empty(KILLARWT_WOOCOMMERCE_ACTIVE)) return;

$buttons = killarwt_header_shop_right_buttons();
if (empty($buttons)) return;

$current_user = wp_get_current_user();

$account_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
$style = killarwt_header_style();

$link_attr = array();
$link_attr['href'] = esc_url($account_url);

?>
<ul class="nav-menu nav-menu-social align-to-right">
	<?php 
	do_action('killar_header_right_sidebar_list_before');

	foreach( $buttons as $button ) {
		switch($button ) {
			case 'signin-account' :
				if (!empty($current_user->ID)) {
					$link_attr['class'] = array('btn btn-order-by-filt');
					$link_attr['title'] = esc_attr('My Account', 'killar');
					echo '<li class="account-drop"><a '. killarwt_stringify_atts($link_attr) . '> ' . get_avatar($current_user->user_email, 128, '', '',  ['class' => "img-fluid circle"]).'</a></li>';
				} else {
					$link_attr['class'] = array('login-register-action');
					if (!(function_exists('is_account_page') && is_account_page())) {
						$link_attr['data-bs-toggle'] = 'modal';
						$link_attr['data-bs-class'] = 'login-modal';
						$link_attr['data-bs-target'] = '#login-register-popup';
					}
					echo '<li><a '. killarwt_stringify_atts($link_attr) .'><i class="fas fa-sign-in-alt me-2"></i>' . esc_html__('Sign In', 'killar') .'</a></li>';
				}
				break;
			case 'register':
				if ( empty($current_user->ID) && 'yes' === get_option('woocommerce_enable_myaccount_registration') ) {
					$link_attr['class'] = array('login-register-action', ($style == 'header_v2') ? '' : 'bg-theme');
					if (!(function_exists('is_account_page') && is_account_page())) {
						$link_attr['data-bs-toggle'] = 'modal';
						$link_attr['data-bs-class'] = 'register-modal';
						$link_attr['data-bs-target'] = '#login-register-popup';
					}
					echo '<li class="list-buttons ' . esc_attr((($style == 'header_v2') ? 'light' : '')) . ' ms-2"><a ' . killarwt_stringify_atts($link_attr) . '> ' .  esc_html__('Register Now', 'killar') . '<i class="fa-regular fa-circle-right ms-2"></i></a></li>';
				}
			break;
			case 'cart':
				if ( !empty(killarwt_minicart_style()) ) {
					echo get_minicart_markup();
				}
				break;
		}
	} 

	do_action('killar_header_right_sidebar_list_after');
	?>
</ul>