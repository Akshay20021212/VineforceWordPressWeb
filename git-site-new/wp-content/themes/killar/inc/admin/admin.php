<?php
/**
 * KillarWT Admin
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class KillarWT_Admin {
	
	static $instance = null;

	public static $api_url = 'https://wpdemo.templateoption.com/envato/';
	
	function __construct() {

	}
	
	public static function get_system_data() {
		$system = array();
		
		$system['server'] 			= ( function_exists( 'killarwt_get_server_info' ) ) ? killarwt_get_server_info() : '';
		$system['phpversion'] 		= phpversion();
		$system['wp_uploads'] 		= wp_get_upload_dir();
		$system['memory_limit'] 	= wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) );
		$system['time_limit'] 		= ini_get( 'max_execution_time' );
		$system['max_input_vars']	= ini_get( 'max_input_vars' );
		$system['uploads'] 			= wp_is_writable( $system['wp_uploads']['basedir'] );
		$system['zip']				= class_exists( 'ZipArchive' );
		$system['suhosin'] 			= extension_loaded( 'suhosin' );
			
		return $system;
	}
	
	public function killarwt_server_status(){
		global $wp_version;
		$response = wp_remote_get( self::$api_url.'connect.php' );
		if ( is_wp_error( $response ) ) {
			$data = array( 'result' => 0 , 'message' => 'The server is unable to connect with the external websites.' );
		} else {
			if ( !empty( $response['body'] ) ) {
				$data = json_decode( $response['body'], true);
			}
		}
		if( $data['result'] == 1 ) {
			return true;
		}
		
		return false;
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

if( ! function_exists( 'KillarWT_Admin' ) ) {
	function KillarWT_Admin() {
		return KillarWT_Admin::get_instance();
	}
}