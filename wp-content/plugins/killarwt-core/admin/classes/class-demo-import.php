<?php
/**
 * KillarWT Demo Import
 *
 * @package  killarwt
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KillarWT_Demos' ) ) {

	class KillarWT_Demos {
				
		public function __construct() {
			
			// Return if not in admin
			if ( ! is_admin() || is_customize_preview() ) {
				return;
			}
			
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				require_once( KILLARWT_CORE_ADMIN_DIR .'classes/importer/class-helpers.php' );
			}
			
			$this->init();
						
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			
		}
		
		public function init() {
					
			add_action( 'ocdi/register_plugins', array( $this, 'ocdi_register_plugins' ), 10 );
			add_action( 'ocdi/import_files', array( $this, 'ocdi_import_files' ), 20 );
			add_action( 'ocdi/before_content_import', array( $this, 'ocdi_before_content_import' ), 30 );
			add_action( 'ocdi/after_import', array( $this, 'ocdi_after_import_setup' ), 30 );
		}
		
		function ocdi_register_plugins( $plugins ) {
 
		  // List of plugins used by all theme demos.
		  $theme_plugins = [
			[
				'slug'  	=> 'killarwt-core',
				'init'  	=> 'killarwt-core/killarwt-core.php',
				'name'  	=> 'KillarWT Core',
				'required' 	=> true, 
			],
			[
				'slug'  	=> 'woocommerce',
				'init'  	=> 'woocommerce/woocommerce.php',
				'name'  	=> 'WooCommerce',
				'required' 	=> true, 
			],
			[
				'slug'  	=> 'elementor',
				'init'  	=> 'elementor/elementor.php',
				'name'  	=> 'Elementor',
				'required' 	=> true, 
			],
			[
				'slug'  	=> 'contact-form-7',
				'init'  	=> 'contact-form-7/wp-contact-form-7.php',
				'name'  	=> 'Contact Form 7',
				'required' 	=> false, 
			],
			[
				'slug'  	=> 'mailchimp-for-wp',
				'init'  	=> 'mailchimp-for-wp/mailchimp-for-wp.php',
				'name'  	=> 'MC4WP: Mailchimp for WordPress',
				'required' 	=> false, 
			],
		  ];
		  
		  return array_merge( $plugins, $theme_plugins );

		}


		function ocdi_import_files() {
			
			return [
				[
					'import_file_name'             	=> 'Demo',
					'categories'                   	=> [ 'Blog', 'Shop' ],
					'import_preview_image_url'     	=> KILLARWT_CORE_URL . 'admin/demo-data/demo-1/preview.jpg',
					'local_import_file'            	=> KILLARWT_CORE_DIR . 'admin/demo-data/demo-1/sample-data.xml',
					'local_import_widget_file'     	=> KILLARWT_CORE_DIR . 'admin/demo-data/demo-1/widgets.json',
					'local_import_customizer_file' 	=> KILLARWT_CORE_DIR . 'admin/demo-data/demo-1/customize.dat',
					'preview_url'                  	=> get_site_url(),
				]
			];
		}
		
		function ocdi_before_content_import( $selected_import ) {

			if ( function_exists( 'theme_license_verified' ) ) {
				return theme_license_verified( true );
			}
		}
			
		function ocdi_after_import_setup( $selected_import ) {
				
			// Set imported menus to registered theme locations
			$locations 	= get_theme_mod( 'nav_menu_locations' );
			$menus 		= wp_get_nav_menus();

			if ( $menus ) {
				
				foreach ( $menus as $menu ) {
					if ( $menu->name == 'One Page Menu' ) {
						$locations['one-page-menu'] = $menu->term_id;
					} else if ( $menu->name == 'Main Menu' ) {
						$locations['primary'] = $menu->term_id;
						$locations['main_menu'] = $menu->term_id;
					} else if ( $menu->name == 'Mobile Menu' ) {
						$locations['mobile-menu'] = $menu->term_id;
					}
				}
			}
			
			// Set menus to locations
			set_theme_mod( 'nav_menu_locations', $locations );
		 
			// Assign front page and posts page (blog page).
			$front_page_id = get_page_by_title( 'CORPORATE & AGENCY' );
			$blog_page_id  = get_page_by_title( 'Blog' );
		 
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page_id->ID );
			update_option( 'page_for_posts', $blog_page_id->ID );

			// Elementor
			update_option( 'elementor_experiment-e_font_icon_svg' , 'inactive' );
		}
		
		/**
		 * Import revslider
		 */
		public function killarwt_ajax_import_revslider( $selected_import ) {
			
			//if ( !current_user_can('manage_options') ||! wp_verify_nonce( $_POST['kwt_import_demo_data_nonce'], 'kwt_import_demo_data_nonce' ) ) {
			//	die( 'This action was stopped for security purposes.' );
			//}

			// Include form importer
			include KILLARWT_CORE_ADMIN_DIR .'classes/importer/class-revslider-importer.php';
			
			$revslider_path 	= ( !empty( $selected_import['revslider_path'] ) ) ? $selected_import['revslider_path'] : '';

			// Import settings.
			$revslider_importer = new KillarWT_RevSlider_Importer();
			$result = $revslider_importer->import_revslider( $revslider_path );
			
			if ( is_wp_error( $result ) ) {
				echo json_encode( $result->errors );
			} else {
				echo 'successful import revolution sliders';
			}
		}
		
		public function scripts ( $hook ) {
			
			if ( $hook != 'killar_page_killar-dashboard-demo-import' ) {
				return;
			}
			
			//css
			wp_enqueue_style( 'killar-demos-style', KILLARWT_CORE_URL. 'admin/assets/css/demos.css' );			
			
			//js
			wp_enqueue_script( 'killar-demos-js', KILLARWT_CORE_URL. 'admin/assets/js/demos.js', array( 'jquery' ) );
			
			wp_localize_script( 'killar-demos-js', 'kWTDemos', array(
				'ajaxUrl' 					=> admin_url( 'admin-ajax.php' ),
				'kwt_demo_data_nonce' 		=> wp_create_nonce( 'kwt_demo_data_nonce' ),
				'kwt_import_data_nonce' 	=> wp_create_nonce( 'kwt_import_data_nonce' ),
				'content_importing_error' 	=> esc_html__( 'There was a problem during the importing process resulting in the following error from your server:', 'killarwt-core' ),
				'button_activating' 		=> esc_html__( 'Activating', 'killarwt-core' ) . '&hellip;',
				'button_active' 			=> esc_html__( 'Activated', 'killarwt-core' ),
			) );
			
		}	
	}

}
new KillarWT_Demos();

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );