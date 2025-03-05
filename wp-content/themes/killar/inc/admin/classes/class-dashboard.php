<?php
/**
 * Admin Dashboard
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class KillarWT_Dashboard {
	
	protected static $instance = null;
	public $post_types;
	public $prefix;
	
	function __construct() {
		$this->setup();
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	
	public function setup() {
		global $pagenow;
		if ( is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ){
			wp_redirect(admin_url('?page=killar-dashboard'));
		}
	}
	
	public function admin_menu() {
		
		if ( !current_user_can( 'administrator' ) ) {
			return;
		}
		
		add_menu_page( 'Killar', 'Killar', 'manage_options', 'killar-dashboard', array( $this, 'dashboard_page' ), 'dashicons-kwt-icon', 100 );
		add_submenu_page( 'killar-dashboard', 'Killar Dashboard', 'Dashboard', 'manage_options', 'killar-dashboard', array( $this, 'dashboard_page' ), 100  );
	}
	
	public function dashboard_page() {
		$this->header_page_section();
		require_once KILLARWT_ADMIN . '/views/dashboard.php';
		$this->footer_page_section();
	}
	
	public function dashboard_plugins_page() {
		$this->header_page_section();
		require_once KILLARWT_ADMIN . '/views/plugins.php';
		$this->footer_page_section();
	}
	
	public function demo_import_page() {
		$this->header_page_section();
		require_once KILLARWT_ADMIN . '/views/dashboard.php';
		$this->footer_page_section();
	}
	
	public function header_page_section() {
		require_once KILLARWT_ADMIN . '/views/header.php';
	}
	
	public function footer_page_section() {
		require_once KILLARWT_ADMIN . '/views/footer.php';
	}
	
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
new KillarWT_Dashboard();