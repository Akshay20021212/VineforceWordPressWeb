<?php
/**
 * Plugin Name:    	KillarWT Core
 * Plugin URI:     	http://killar.templateoption.com/
 * Description:    	Add extra features like shortcode, elementor Widgets, metaboxes, import/export and a panel to activate the premium extensions for Killar.
 * Version:        	1.0.5
 * Text Domain: 	killarwt-core
 * Domain Path: 	/languages
 * Author:         	WebTwine Technologies
 * Author URL:     	https://webtwine.com
 * WC tested up to: 3.6.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'KillarWT_Core' ) ) {
	
	final class KillarWT_Core {
		
		private static $_instance = null;

		public $token, $version, $plugin_url, $plugin_dir;

		public function __construct () {
			
			global $kwt_exts_head_css;
			$this->token 			= 'killarwt-core';
			$this->version 			= '1.0.5';
			$this->plugin_url 		= plugin_dir_url( __FILE__ );
			$this->plugin_dir 		= plugin_dir_path( __FILE__ );
			
			define( 'KILLARWT_CORE_VERSION', $this->version );
			define( 'KILLARWT_CORE_URL', $this->plugin_url );
			define( 'KILLARWT_CORE_DIR', $this->plugin_dir );
			define( 'KILLARWT_CORE_FILE', __FILE__ );
			define( 'KILLARWT_CORE_INTEGRATIONS_DIR', KILLARWT_CORE_DIR . 'integrations/' );
			define( 'KILLARWT_CORE_INC_DIR', KILLARWT_CORE_DIR . 'inc/' );
			define( 'KILLARWT_CORE_ADMIN_DIR', KILLARWT_CORE_DIR . 'admin/' );
			
			$this->includes();
			$this->load_plugin_textdomain();
					
			add_action( 'killar_footer_css', array( $this, 'killarwt_exts_footer_css' ) );
						
		}

		/**
		 * Main KillarWT_Core Instance
		 *
		 * Ensures only one instance of KillarWT_Core is loaded or can be loaded.
		 */
		public static function instance () {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Includes
		 */
		public function includes() {
			
			// Meta Box
			require_once KILLARWT_CORE_INTEGRATIONS_DIR . 'meta-box/meta-box.php';
			
			// Shortcodes Elements
			require_once KILLARWT_CORE_INC_DIR . 'shortcodes.php';
			
			// Post Types
			require_once KILLARWT_CORE_INC_DIR . 'post-types.php';
			
			// Functions
			require_once KILLARWT_CORE_INC_DIR . 'functions.php';
			
			// Elementor
			require_once KILLARWT_CORE_INTEGRATIONS_DIR . 'elementor/elementor.php';
			
			// Widgets
			require_once KILLARWT_CORE_INC_DIR . 'widgets/widget-functions.php';
			
			// Admin
			require_once KILLARWT_CORE_ADMIN_DIR . 'classes/class-demo-import.php';
		}
		
		/**
		 * Filter Custom css
		 */
		function killarwt_exts_footer_css( $output ) {

			$css = killarwt_exts_css_output();
			$output = ( $css ) ? $output . $css : $output;
			return $output;
			
		}

		/**
		 * Load the localisation file.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'killarwt-core', false, dirname( plugin_basename( KILLARWT_CORE_FILE ) ) . '/languages/' );
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone () {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'killarwt-core' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup () {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'killarwt-core' ), '1.0.0' );
		}
	}
}

/**
 * Returns the main instance of KillarWT_Core to prevent the need to use globals.
 */
function KillarWT_Core() {
	return KillarWT_Core::instance();
}

/*
 * Get Theme
 */
$themeName   = wp_get_theme()->get('TextDomain');


/**
 * Initialise the plugin
 */
if ( in_array( strtolower( $themeName ) , array( 'killar', 'killar-child' ) ) ) {
	KillarWT_Core();
}