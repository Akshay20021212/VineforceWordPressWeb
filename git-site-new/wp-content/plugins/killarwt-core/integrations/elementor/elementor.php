<?php
namespace KillarElementor;
use Elementor\Controls_Manager;

/**
 * Modules : Killar Elementor
 * Description : Add elementor elements and fields for killar theme.
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Killar_Elementor' ) ) {
	
	final class Killar_Elementor {
		
		public function __construct () {
		
			$this->init();
			
			define( 'KILLAR_ELEXTS_DIR', plugin_dir_path( __FILE__ ) );
			define( 'KILLAR_ELEXTS_URL', plugin_dir_url( __FILE__ ) );
			define( 'KILLAR_ELEXTS_FILE', __FILE__ );
			define( 'KILLAR_ELEXTS_WIDGETS_DIR', KILLAR_ELEXTS_DIR.'/widgets' );

			add_action('elementor/init', [$this, 'includes']);
			add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
			
			// Register categories
			add_action( 'elementor/elements/categories_registered', [ $this, 'categories_registered' ] );
			
			// Register controls
			add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );
			
			// Register widgets
			add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
			
			// Add Icons
			add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'elkwt_custom_fonts' ] );
			
			// Add Styles/Scripts
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
			add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
			//add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'before_enqueue_styles' ], 1000 );
			
			
			// Remove elementor fontawesome css
			add_action( 'elementor/frontend/after_register_styles',function() {
				foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
					wp_deregister_style( 'elementor-icons-fa-' . $style );
				}
			}, 20 ); 
			
		}
		
		/**
		 * Initialize the plugin
		 */
		public function init() {
			
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}
		}


		/**
		 * Includes
		 */
		public function includes()
		{
			require_once(KILLAR_ELEXTS_DIR . '/custom-attributes/custom-attributes.php');
			require_once(KILLAR_ELEXTS_DIR . '/functions.php');
		}
		
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'killarwt-core' ),
				'<strong>' . esc_html__( 'Hub Elementor Addons', 'killarwt-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'killarwt-core' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}
		
		/**
		 * Categories Register
		 */
		public function categories_registered( $elements_manager ) {
			$elements_manager->add_category (
				'killar-elements',
				[
				  'title' => esc_attr('Killar Elements', 'killarwt-core'),
				  'icon' => 'fa fa-plug',
				]
			);
		}
		
		/**
		 * Register Controls
		 */
		public function register_controls( $controls_manager ) {

			require_once( KILLAR_ELEXTS_DIR . '/controls/iconSelector-control.php' );
			require_once( KILLAR_ELEXTS_DIR . '/controls/wt_autocomplete.php' );

			if ( version_compare('3.5.0', ELEMENTOR_VERSION, '>') ){
				$controls_manager->register_control('icon_selector', new \KillarElementor\IconSelector_Control());
			} else {
				$controls_manager->register( new \KillarElementor\IconSelector_Control() );
				$controls_manager->register( new \KillarElementor\WTAutocomplete_Control() );
			}
		}
		
		/**
		 * Register Widgets
		 */
		public function register_widgets( $widgets_manager ) {

			require KILLAR_ELEXTS_DIR . 'widget-base.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/heading.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/text.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/image.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/button.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/features-box.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/image-box.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/image-carousel.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/screenshots-carousel.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/counter.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/blog.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/reviews-carousel.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/reviews-tabs.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/gallery.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/social-icons.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/icon-list.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/portfolio.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/team-member.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/pricing.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/blockquote.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/posts.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/countdown.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/scene.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/scene-animation.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/accordion.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/testimonial.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/progress-bar.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/tabs.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/woo-products.php';
			require KILLAR_ELEXTS_WIDGETS_DIR . '/woo-product-categories.php';
		}
		
		
		public function elkwt_custom_fonts( $tabs = array() ) {
			
			require KILLARWT_CORE_INC_DIR.'/icons_list.php';

			$tabs['elkwt-fa-solid'] = array(
				'name'          => 'elkwt-fa-solid',
				'label'         => esc_html__( 'Extra Fontawesome - Solid', 'killarwt-core' ),
				'url'           => KILLARWT_CSS_DIR_URI . 'fontawesome-all.min.css',
				'enqueue' 		=> '',
				'prefix'        => 'fa-',
				'displayPrefix' => 'fa fas',
				'labelIcon'     => 'fab fa-font-awesome',
				'ver'           => '1.0.0',
				'icons'         => elkwt_fa_icons(),
			);

			$tabs['elkwt-fa-brand'] = array(
				'name'          => 'elkwt-fa-brand',
				'label'         => esc_html__( 'Extra Fontawesome - Brands', 'killarwt-core' ),
				'url'           => KILLARWT_CSS_DIR_URI . 'fontawesome-all.min.css',
				'enqueue' 		=> '',
				'prefix'        => 'fa-',
				'displayPrefix' => 'fa fab',
				'labelIcon'     => 'fab fa-font-awesome',
				'ver'           => '1.0.0',
				'icons'         => elkwt_fab_icons(),
			);
		
			return $tabs;
		}
		
		public function enqueue_editor_styles() {
			wp_enqueue_style( 'killarwt-elementor-editor', KILLAR_ELEXTS_URL.'assets/css/editor.css' );
		}

		public function enqueue_editor_scripts() {
			wp_enqueue_script( 'killarwt-elementor-editor', KILLAR_ELEXTS_URL . 'assets/js/editor-support.js', [
				//'jquery',
				'backbone-marionette',
				'elementor-common',
				'elementor-editor-modules',
				'elementor-editor-document',
			], null, true );
		}
		
		/**
		 * Before Qequeue Style
		 */
		public function before_enqueue_styles() {
			
			wp_register_style( 'flaticon-icons', KILLARWT_CSS_DIR_URI . 'fonts.css' );
			wp_enqueue_style( 'flaticon-icons' );
		}
	}
}
new Killar_Elementor();