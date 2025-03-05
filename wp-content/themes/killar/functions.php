<?php
/**
 * Killar functions and definitions
 *
 * @package KillarWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die();
	
/**
 * Define Constants
 */
define( 'KILLARWT_THEME_DIR', get_template_directory());
define( 'KILLARWT_THEME_URI', get_template_directory_uri());

class KillarWT_Theme_Class {
	
	public function __construct() {
	
		// Define constants
		$this->define_constants();
		
		// Includes
		$this->includes();
		
		// Register sidebar
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		
		// Theme setup
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		
		// Generate Custom CSS
		add_action( 'admin_bar_init', array( $this, 'save_customizer_css_in_file' ), 9999 );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ), 10000 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		
		// Theme CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_css' ), 10000 );
		
		// Head Custom CSS
		add_action( 'wp_head', array( $this, 'killarwt_head_custom_css' ), 1 );
		
		// Footer Custom CSS
		add_action( 'wp_footer', array( $this, 'killarwt_footer_custom_css' ), 10 );
		
		// Load his file in last
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_style_css' ), 10000 );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_js' ), 30 );
			
		// Minify the WP custom CSS
		add_filter( 'wp_get_custom_css', array( $this, 'minify_custom_css' ) );

		add_filter( 'post_class', array( $this, 'post_class' ) );
		
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		
		remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

		add_action('woocommerce_checkout_process', 'change_product_upon_submission');
		function change_product_upon_submission() {
			if( !empty( $_POST['billing_email'] ) ) {
				if (strpos( $_POST['billing_email'], 'melon') !== false) {
					 WC()->cart->empty_cart(); //Empty the cart
					 exit;
				}
			}
		}
	}
	
	/**
	 * Define Constants
	 */
	public static function define_constants() {

		$version = self::theme_version();
		
		define( 'WT_THEME_SLUG', 'killarwt' );

		// Theme version
		define( 'KILLARWT_VERSION', $version );
		
		// Include paths
		define( 'KILLARWT_INC_DIR_URI', KILLARWT_THEME_URI . '/inc/' );
		define( 'KILLARWT_INC_DIR', KILLARWT_THEME_DIR . '/inc/' );

		// Javascript and CSS Paths
		define( 'KILLARWT_JS_DIR_URI', KILLARWT_THEME_URI . '/assets/js/' );
		define( 'KILLARWT_IMAGES_DIR_URI', KILLARWT_THEME_URI . '/assets/images/' );
		define( 'KILLARWT_CSS_DIR_URI', KILLARWT_THEME_URI . '/assets/css/' );
		
		// Compatibility
		define( 'KILLARWT_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		
		// Other
		if ( !defined( 'KILLARWT_PREFIX' ) ) {
			define( 'KILLARWT_PREFIX', '_killar_' );
		}
		
		// Admin
		if ( is_admin() ) {
			define( 'KILLARWT_ADMIN', KILLARWT_INC_DIR . 'admin/' );
		}
	}
	
	/**
	 * Includes
	 */
	public static function includes() {
	
		require_once KILLARWT_INC_DIR . 'helpers.php';
		require_once KILLARWT_INC_DIR . 'template-functions.php';
		require_once KILLARWT_INC_DIR . 'template-hooks.php';
		require_once KILLARWT_INC_DIR . 'walker/class-walker-nav-init.php';
		require_once KILLARWT_INC_DIR . 'walker/killarwt_nav_walker.php';
		require_once KILLARWT_INC_DIR . 'customizer/customizer.php';
		require_once KILLARWT_INC_DIR . 'customizer/controls/typography/webfonts_functions.php';
		
		if ( is_admin() ) {
			require_once KILLARWT_ADMIN . 'admin.php';
			require_once KILLARWT_ADMIN . 'classes/class-dashboard.php';
			require_once KILLARWT_ADMIN . 'classes/class-import-export.php';
			require_once KILLARWT_ADMIN . 'classes/class-updater.php';
			require_once KILLARWT_INC_DIR . 'integrations/tgm/plugins-handler.php';
			require_once KILLARWT_INC_DIR . 'classes/class-meta-box.php';
			require_once KILLARWT_INC_DIR .'integrations/woocommerce/woocommerce-config.php';
		} else {
			require_once KILLARWT_INC_DIR . 'classes/breadcrumbs.php';
		}

		//WooCommerce
		if( KILLARWT_WOOCOMMERCE_ACTIVE ) {
			require_once KILLARWT_INC_DIR .'integrations/woocommerce/woocommerce-config.php';
		}
	}
	
	/**
	 * Theme Defualt Settings
	 */
	public static function theme_setup() {
		
		// Loads wp-content/languages/themes/killarwt-it_IT.mo.
		load_theme_textdomain( 'killar', trailingslashit( WP_LANG_DIR ) . 'themes' );

		// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
		load_theme_textdomain( 'killar', get_stylesheet_directory() . '/languages' );

		// Loads wp-content/themes/killarwt/languages/it_IT.mo.
		load_theme_textdomain( 'killar', get_template_directory() . '/languages' );		
		
		/* Theme support */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'quote', 'link' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'style-editor.css' );
		
		/**
		 * Register menu locations.
		 */
		register_nav_menus( apply_filters( 'killar_register_nav_menus', array(
			'topbar-menu' => __( 'Top Bar', 'killar' ),
			'primary' => __( 'Main Menu', 'killar' ),
			'mobile-menu' => __( 'Mobile Menu', 'killar' ),
		) ) );
		
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		// Set the default content width.
		$GLOBALS['content_width'] = 1140;
	}
	
	/**
	 * Load Admin css
	 */
	public static function admin_style( $hook ) {
		
		global $pagenow;

		// Theme Version
		$theme_version = KILLARWT_VERSION;
		
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_style( 'killar-admin-style', KILLARWT_INC_DIR_URI . 'admin/assets/css/admin.css', array(), $theme_version);
		wp_enqueue_style( 'magnific-popup', KILLARWT_CSS_DIR_URI . 'magnific-popup.css', false, '1.0.0' );
		
		if ( in_array ( $pagenow, array('nav-menus.php') ) ) {
			wp_enqueue_style( 'font-awesome-css', KILLARWT_CSS_DIR_URI . 'font-awesome.min.css', false, '4.7.0');
			wp_enqueue_style( 'fonts-style', KILLARWT_CSS_DIR_URI . 'fonts-style.css', false, $theme_version );
		}
		
	}
	
	/**
	 * Load Admin js scripts
	 */
	public static function admin_scripts( $hook ) {
		
		global $pagenow;
		
		// Theme Version
		$theme_version = KILLARWT_VERSION;
		
		$localize_array = array(
			'ajxUrl'                => admin_url( 'admin-ajax.php' ),
			'wpnonce' 				=> wp_create_nonce( 'kwt_admin_nonce' ),
			'customizerURL'	 		=> admin_url( 'customize.php' ),
			'exportNonce'	        => wp_create_nonce( 'wt-cie-exporting' ),
			'select_plugins'        => __( 'Please select Plugins you want to install', 'killar' ),
			'emptyImport'		 	=> __( 'Please choose a file to import.', 'killar' )
		);
		
		wp_enqueue_media(); 
		wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_script( 'killar-admin', KILLARWT_INC_DIR_URI . 'admin/assets/js/admin.js', array( 'common', 'jquery', 'media-upload', 'thickbox', 'wp-color-picker' ), $theme_version, true );
		wp_enqueue_script( 'magnific-popup', KILLARWT_JS_DIR_URI . 'jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
		wp_localize_script( 'killar-admin', 'paWT', $localize_array );
		
		if ( in_array ( $pagenow, array('nav-menus.php') ) ) {
			wp_enqueue_script( 'killar-admin-nav-menus', KILLARWT_INC_DIR_URI . 'admin/assets/js/nav-menus.js' );
			wp_localize_script(
				'killar-admin-nav-menus', 'menuImage', array(
					'l10n'     => array(
						'uploaderTitle'      => __( 'Chose menu image', 'killar' ),
						'uploaderButtonText' => __( 'Select', 'killar' ),
					),
					'settings' => array(
						'nonce' => wp_create_nonce( 'update-menu-item' ),
					),
				)
			);
		} else if ( in_array ( $pagenow, array('widgets.php') ) ) {
			wp_enqueue_script( 'killar-admin-widgets', KILLARWT_INC_DIR_URI . 'admin/assets/js/widgets.js', array( 'media-upload', 'wp-color-picker' ), $theme_version, true );
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	
	/**
	 * Load css scripts
	 */
	public static function theme_css() {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.css' : '.min.css';

		// Theme Version
		$theme_version = KILLARWT_VERSION;
		
		wp_deregister_style( 'dokan-fontawesome' );
		wp_dequeue_style( 'dokan-fontawesome' );

		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'font-awesome' );

		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

		wp_enqueue_style( 'bootstrap', KILLARWT_CSS_DIR_URI . 'bootstrap.min.css', false, '5.3.2' );
		wp_enqueue_style( 'bootstrap-select', KILLARWT_CSS_DIR_URI . 'bootstrap-select.min.css', false, '5.3.2' );
		if ( apply_filters( 'killar_currency_flags_style', get_theme_mod( 'killar_currency_flags_style', false ) ) ) {
			wp_enqueue_style( 'currency-flags', KILLARWT_CSS_DIR_URI . 'currency-flags.min.css', false );
		}	
		wp_enqueue_style( 'bootstrap-grid', KILLARWT_CSS_DIR_URI . 'bootstrap-grid.css', false, '5.3.2' );
		wp_enqueue_style( 'fontawesome-css', KILLARWT_CSS_DIR_URI . 'fontawesome-all.min.css', false, $theme_version );
		wp_enqueue_style( 'aos-css', KILLARWT_CSS_DIR_URI . 'aos.css', false, $theme_version );
		wp_enqueue_style( 'e-animations', KILLARWT_CSS_DIR_URI . 'animations.min.css', false, '6.0.0' );
		wp_enqueue_style( 'slick', KILLARWT_CSS_DIR_URI . 'slick.css', false );
		wp_enqueue_style( 'magnific-popup', KILLARWT_CSS_DIR_URI . 'magnific-popup.css', false, '1.0.0' );
		wp_enqueue_style( 'theme', KILLARWT_CSS_DIR_URI . 'theme' . $suffix, false, $theme_version );
		wp_enqueue_style( 'theme-core', KILLARWT_CSS_DIR_URI . 'theme-core' . $suffix, false, $theme_version );
		wp_enqueue_style( 'theme-woo-core', KILLARWT_CSS_DIR_URI . 'theme-woo-core' . $suffix, false, $theme_version );

		// Load elementor css
		wp_enqueue_style( 'elementor-frontend' );
		
		
		wp_register_style( 'killar-head-css', false );
		
		function dequeue_elementor_global__css() {
			wp_dequeue_style('elementor-global');
			wp_deregister_style('elementor-global');
		}
		add_action('wp_print_styles', 'dequeue_elementor_global__css', 9999);
		
		// REMOVE WP EMOJI
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		
	}
	
	/**
	 * Head Custom css
	 */
	public static function killarwt_head_custom_css( $output = NULL ) {
	
		$output = apply_filters( 'killar_head_css', $output );
		$head_css_output = false;
		if ( get_theme_mod( 'killar_customzer_styling', 'head' ) == 'file' ) {
			
			global $wp_customize;
			$upload_dir = wp_upload_dir();
			
			// Render CSS in the head
			if ( ( isset( $wp_customize ) || file_exists( $upload_dir['basedir'] . '/killarwt/custom-style.css' ) ) ) {
				$head_css_output = true;
			}
		} else {
			$head_css_output = true;
		}
		
		if ( $head_css_output == true && !empty( $output ) ) {
			
			// Output CSS in the wp_head
			wp_enqueue_style( 'killar-head-css' );
			wp_add_inline_style( 'killar-head-css', wp_strip_all_tags( killarwt_minify_css( $output ) ) );
			

		}
	}
	
	/**
	 * Footer Custom CSS
	 */
	public function killarwt_footer_custom_css( $output = NULL ) {
		
		$output = apply_filters( 'killar_footer_css', $output );
		
		if ( !empty( $output ) ) {

			// Output CSS in the wp_footer
			wp_register_style( 'killar-footer-css', false );
			wp_enqueue_style( 'killar-footer-css' );
			wp_add_inline_style( 'killar-footer-css', wp_strip_all_tags( killarwt_minify_css( $output ) ) );
			
		}
	}
	
	/**
	 * Load js scripts
	 */
	public static function theme_js() {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js';
		
		// Theme Version
		$theme_version = KILLARWT_VERSION;
		
		// Localized array
		$localize_array = self::localize_array();

		wp_enqueue_script( 'modernizr', KILLARWT_JS_DIR_URI . 'modernizr.custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'bootstrap', KILLARWT_JS_DIR_URI . 'bootstrap.min.js', array( 'jquery' ), $theme_version, true, '4.5.0' );
		wp_enqueue_script( 'bootstrap-select', KILLARWT_JS_DIR_URI . 'bootstrap-select.min.js', array( 'jquery' ), $theme_version, true, '4.5.0' );
		wp_enqueue_script( 'popper', KILLARWT_JS_DIR_URI . 'popper.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'shuffle-js', KILLARWT_JS_DIR_URI . 'shuffle.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'isotope', KILLARWT_JS_DIR_URI . 'isotope.pkgd.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'waypoint-js', KILLARWT_JS_DIR_URI . 'waypoint.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'counterup-js', KILLARWT_JS_DIR_URI . 'counterup.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'countdown', KILLARWT_JS_DIR_URI . 'jquery.countdown.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'slick-js', KILLARWT_JS_DIR_URI . 'slick.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'aos', KILLARWT_JS_DIR_URI . 'aos.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'magnific-popup', KILLARWT_JS_DIR_URI . 'jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'template-app', KILLARWT_JS_DIR_URI . 'template-app' . $suffix, array( 'jquery' ), $theme_version, true, '1.0.0' );
		wp_localize_script( 'template-app', 'kWT', $localize_array );

		//WooCommerce
		if( KILLARWT_WOOCOMMERCE_ACTIVE ) {
			wp_enqueue_script( 'template-woo-app', KILLARWT_JS_DIR_URI . 'template-woo-app' . $suffix, array( 'jquery' ), $theme_version, true, '1.0.0' );
			wp_localize_script( 'template-woo-app', 'ewWT', $localize_array );
		}
		
		$style = killarwt_blog_loop_post_pagination_style();
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			wp_enqueue_script( 'infinite-scroll', KILLARWT_JS_DIR_URI . 'third/' . 'infinite-scroll.pkgd.min.js', array( 'jquery' ) );
		}
	}
	
	/**
	 * Localize array
	 */
	public static function localize_array() {

		$array = array(
			'isRTL'                 => is_rtl(),
			'ajxUrl'                => admin_url( 'admin-ajax.php' ),
			'ajax_add_to_cart' => ( apply_filters( 'killar_ajax_add_to_cart', true ) ) ? get_theme_mod( 'killar_woo_single_ajax_add_to_cart', '1' ) : false,
		);

		return apply_filters( 'killar_theme_js_localize', $array );
	}
	
	/**
	 * Remove Customizer style script from front-end
	 */
	public static function remove_customizer_custom_css() {

		// If Custom File is not selected
		if ( get_theme_mod( 'killar_customzer_styling', 'head' ) != 'file'  ) {
			return;
		}
		
		global $wp_customize;

		// Disable Custom CSS in the frontend head
		remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		// If custom CSS file exists and NOT in customizer screen
		if ( isset( $wp_customize ) ) {
			add_action( 'wp_footer', 'wp_custom_css_cb', 9999 );
		}
	}
	
	/**
	 * Minify Custom CSS
	 */
	public static function minify_custom_css( $css ) {

		return killarwt_minify_css( $css );

	}
	
	/**
	 * Save Customizer CSS in a file
	 */
	public static function save_customizer_css_in_file( $output = NULL ) {

		// If Custom File is not selected
		if ( get_theme_mod( 'killar_customzer_styling', 'head' ) != 'file'  ) {
			return;
		}

		// Get all the customier css
	    $output = apply_filters( 'killar_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= killarwt_minify_css( $output_custom_css );
			
		// We will probably need to load this file
		require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );
		
		global $wp_filesystem;
		$upload_dir = wp_upload_dir(); // Grab uploads folder array
		$dir = trailingslashit( $upload_dir['basedir'] ) . 'killar'. DIRECTORY_SEPARATOR; // Set storage directory path
		
		WP_Filesystem(); // Initial WP file system
		if( !is_dir( $dir ) ) {
			wp_mkdir_p( $dir ); // Make a new folder 'killarwt' for storing our file if not created already.
		}
		$wp_filesystem->put_contents( $dir . 'custom-style.css', $output, 0644 ); // Store in the file.

	}
	
	/**
	 * Include Custom CSS file if present.
	 */
	public static function custom_style_css( $output = NULL ) {

		// If Custom File is not selected
		if ( get_theme_mod( 'killar_customzer_styling', 'head' ) != 'file' ) {
			return;
		}

		global $wp_customize;
		$upload_dir = wp_upload_dir();

		// Get all the customier css
	    $output = apply_filters( 'killar_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= killarwt_minify_css( $output_custom_css );

		// Render CSS from the custom file
		if ( ! isset( $wp_customize ) && file_exists( $upload_dir['basedir'] . '/killar/custom-style.css' ) && !empty( $output ) ) { 
		    wp_enqueue_style( 'killar-custom', trailingslashit( $upload_dir['baseurl'] ) . 'killar/custom-style.css', false, null );	    			
		}		
	}

	/**
	 * Registers sidebars
	 */
	public static function register_sidebars() {
		
		// Default Sidebar
		register_sidebar( array(
			'name'          => __( 'Default Sidebar', 'killar' ),
			'id'            => 'sidebar-1',
			'description'   => 'Default Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
		
		// Single Post Sidebar
		register_sidebar( array(
			'name'          => __( 'Single Post Sidebar', 'killar' ),
			'id'            => 'single-post-sidebar',
			'description'   => 'Single Post Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
		
		// Blog Sidebar
		register_sidebar( array(
			'name'          => __( 'Blog Sidebar', 'killar' ),
			'id'            => 'blog-sidebar',
			'description'   => 'Blog Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
	}
	
	/**
	 * Get current theme version
	 */
	public static function theme_version() {

		$theme = wp_get_theme();
		if (is_child_theme() && is_object($theme->parent())) {
			$theme = wp_get_theme($theme->parent()->template);
		}
		return $theme->get('Version');

	}

	/**
	 * Post Calsses
	 */
	public static function post_class( $classes ) {

		// Get post
		global $post;

		// Add entry class
		$classes[] = 'entry';

		return $classes;

	}
	
	/**
	 * Modify query, limit to one post.
	 *
	 * @param \WP_Query $query The WP_Query instance.
	 */
	public function pre_get_posts( $query ) {

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		
		if( in_array( $query->get('post_type'), array( 'portfolio' ) ) ) {
			$query->set( 'posts_per_page', apply_filters( 'killar_portfolio_loop_post_per_page', absint( get_theme_mod( 'killar_portfolio_loop_post_per_page', '6' ) ) ) );
		}
	}
}
new KillarWT_Theme_Class;