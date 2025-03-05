<?php
/**
 * Updater
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class KillarWT_Updater {
	
	static $instance = null;
	public $api_url;
	public $item_name;
	public $item_id;
	public $envato_option;
	public $theme_token;
	public $plugin_url;

	protected function __construct() {
		
		$this->api_url = 'https://wpdemo.templateoption.com/envato/';
		$this->item_id = '50099740';
		$this->item_name = 'Killar - Multipurpose WordPress theme for SaaS Startup Business & Agency';
		$this->envato_option = 'envato_purchase_code_'.$this->item_id;
		$this->theme_token = WT_THEME_SLUG .'_token';
		$this->plugin_url = WT_THEME_SLUG .'_plugin_url';
		
		add_action( 'wp_ajax_activation_theme', array( $this, 'killarwt_check_activation_state' ) );
		add_action( 'wp_ajax_nopriv_activation_theme', array( $this, 'killarwt_check_activation_state' ) );
		
		/* Admin Notice */
		add_action( 'admin_notices', array( $this, 'check_theme_license_activate' ), 90);
	}
	
	public function getVerifyUrl(){
		$url = $this->api_url . 'verify.php';
		$url .= '?domain='. $this->killarwt_domain();
		return $url;
    }
	
	public function getDeactivateUrl(){
        $url = $this->api_url . 'deactivate.php';
		$url .= '?domain='. $this->killarwt_domain();
		return $url;
    }
	
	public function killarwt_check_activation_state() {
		$data = array();
		if ( empty( $_POST['purchase_code'] ) ) {
			$data = array( 'result' => 0 , 'message' => __( 'Purchase code field required', 'killar' ) );
        }
		
		if ( !empty( $_POST['purchase_code'] ) && !empty( $_POST['activation_actions'] ) ) {
			$purchase_code = sanitize_text_field( $_POST['purchase_code'] );
			$actions = sanitize_text_field( $_POST['activation_actions'] );
			if ( $actions == 'deactivate_theme' ) {
				$purchase_code = $this->get_purchase_code();
			}
			$url = ( $actions == 'activate_theme' ) ? $this->getVerifyUrl() : $this->getDeactivateUrl();
			$url = add_query_arg( array('purchase_code' => $purchase_code, 'item_id' => $this->item_id ), $url );

			$response = wp_remote_get( $url );
			if ( is_wp_error( $response ) ) {
				$data = array( 'result' => 0 , 'message' => 'The server is unable to connect with the external websites.' );
			} else {
				if ( !empty( $response['body'] ) ) {
					$data = json_decode( $response['body'], true);
					if ( $actions == 'activate_theme' ) {
						if ( $data['result'] == 1 ) {
							if ( !empty( $data['data']['token'] ) ) {
								$this->killarwt_activate_theme( $data['data']['purchase_code'], $data['data']['token'], $data['data']['plugin_url'] );
							}
						}
					} else {
						if ( $data['result'] == 1 ) {
							if ( !empty( $data['data']['token'] ) ) {
								$this->killarwt_deactivate_theme( $data['data']['purchase_code'] );
							}
						}
					}
					
					$data['message'] = $this->killarwt_get_html_messages( $data['result'], $data['message'] );
					if ( $data['result'] == 1 ) {
						$data['is_reload'] = true;	
					}
				}
			}
		}

		echo json_encode( $data );
		die();
	}
	
	public function killarwt_get_html_messages( $status, $message ) {
		$html = '';
		if ( $status == 0 ) {
			$html = '<div class="notice notice-error is-dismissible"><p>'.$message.'</p></div>';
		} else if ( $status == 1 ) {
			$html = '<div class="notice notice-success is-dismissible"> <p>'.$message.'</p></div>';
		} else if ( $status == 2 ) {
			$html = '<div class="notice notice-warning is-dismissible"> <p>'.$message.'</p></div>';
		} else if ( $status == 3 ) {
			$html = '<div class="notice notice-info is-dismissible"> <p>'.$message.'</p></div>';
		}
		return $html;
	}
	
	public function killarwt_domain() {
        $domain = get_option('siteurl'); 
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www', '', $domain); 
        return urlencode($domain);
    }
	
	public function killarwt_activate_theme( $purchase_code, $token, $plugin_url ) {
		update_option( $this->envato_option, $purchase_code );
		update_option( $this->theme_token, $token );
		update_option( $this->plugin_url, $plugin_url );
		update_option( WT_THEME_SLUG . '_license_verified', true );
	}
	
	public function killarwt_deactivate_theme( $purchase_code ) {
		delete_option( $this->envato_option );
		delete_option( $this->theme_token );
		delete_option( $this->plugin_url );
		delete_option( WT_THEME_SLUG . '_license_verified' );
	}
	
	public function init_actions() {
		if ( current_user_can( 'manage_options' ) ) {
			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
			}
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
		}
	}
	
	public static function cleanFilePath( $path ) {
		$path = str_replace( '', '', str_replace( array( '\\', '\\\\', '//' ), '/', $path ) );
		if ( $path[ strlen( $path ) - 1 ] === '/' ) {
			$path = rtrim( $path, '/' );
		}

		return $path;
	}
	
	public function is_verified() {
		$code = get_option( $this->envato_option );
       	return ( get_option( WT_THEME_SLUG . '_license_verified' ) && $code ) ? true : false;
	}
	
	public function get_purchase_code() {
		$code = get_option( $this->envato_option );
       	return ( $code ) ? $code : false;
	}
	public function get_purchase_code_asterisk() {
		$code = get_option( $this->envato_option );
       	if ( $code ) {
			$code = substr( $code, 0, 15 );
			$code = $code . '**-****-************';
		}
		return $code;
	}
	
	public function check_theme_license_activate(){
            
		if( theme_license_verified() ){
			return;
		}
		$theme_details		= wp_get_theme();
		$activate_page_link	= admin_url( 'admin.php?page=killar-dashboard' );

		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php 
					echo sprintf( esc_html__( ' %1$s Theme is not activated! Please activate your theme and enjoy all features of the %2$s theme', 'killar'), 'Killar','Killar' );
					?>
			</p>
			<p>
				<strong style="color:red"><?php esc_html_e( 'Please activate the theme!', 'killar' ); ?></strong> -
				<a href="<?php echo esc_url(( $activate_page_link )); ?>">
					<?php esc_html_e( 'Activate Now','killar' ); ?> 
				</a> 
			</p>
		</div>
	<?php
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
add_action( 'after_setup_theme', 'KillarWT_Updater', 10 );
if ( ! function_exists( 'KillarWT_Updater' ) ) :
	function KillarWT_Updater() {
		return KillarWT_Updater::get_instance();
	}
endif;