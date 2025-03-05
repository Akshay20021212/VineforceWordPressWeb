<?php
/**
 * Custom Theme Css
 */
if ( ! function_exists( 'killarwt_exts_css_output' ) ) {
	
	function killarwt_exts_css_output( $output = '', &$args = array() ) {
		
		global $kwt_exts_head_css;
		if ( $output != '' ) {
			$kwt_exts_head_css .= $output;
			if( \Elementor\Plugin::$instance->editor->is_edit_mode() && !empty( $args['sec_content'] ) ) {
				$args['sec_content'] .= '<style>' . $output . '</style>';
			}
		}
		return $kwt_exts_head_css;
	}
}

/**
 * Templates
 */
function killarwt_exts_get_template( $slug, $args = array() ) {
	
	$template = '';
	
	$template_path = 'template-parts/';
	$plugin_path = trailingslashit( KILLARWT_CORE_DIR );
	
	// If template file doesn't exist, look in yourtheme/template-parts/shortcodes/slug.php
	if ( ! $template ) {
		$template = locate_template( array(
			$template_path . "{$slug}.php"
		) );
	}
	
	// Get default slug.php
	if ( ! $template && file_exists( $plugin_path . "/templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}
	
	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'killarwt_exts_get_template', $template, $slug);	
	extract( $args );
	if ( !empty( $template ) ) {		
		include $template;
	}
}

/**
 * Alignment Array
 */
if ( ! function_exists( 'killarwt_alignment_array' ) ) {

	function killarwt_alignment_array() {		
		return array(
			esc_html__( 'Verticle (default)', 'killarwt-core' ) => 'ver',
			esc_html__( 'Horizontal', 'killarwt-core' ) => 'hor',
		);
	}
}

/**
 * Text Alignment Array
 */
if ( ! function_exists( 'killarwt_text_alignment_array' ) ) {

	function killarwt_text_alignment_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Left', 'killarwt-core' ) => 'start',
			esc_html__( 'Center', 'killarwt-core' ) => 'center',
			esc_html__( 'Right', 'killarwt-core' ) => 'end',
			esc_html__( 'Justified', 'killarwt-core' ) => 'justify',
		);
	}
}

/**
 * Vertical Alignment Array
 */
if ( ! function_exists( 'killarwt_vertical_alignment_array' ) ) {

	function killarwt_vertical_alignment_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Top', 'killarwt-core' ) => 'start',
			esc_html__( 'Middle', 'killarwt-core' ) => 'center',
			esc_html__( 'Bottom', 'killarwt-core' ) => 'end',
		);
	}
}

/**
 * Horizontal Alignment Array
 */
if ( ! function_exists( 'killarwt_horizontal_alignment_array' ) ) {

	function killarwt_horizontal_alignment_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Left', 'killarwt-core' ) => 'start',
			esc_html__( 'Center', 'killarwt-core' ) => 'center',
			esc_html__( 'Right', 'killarwt-core' ) => 'end',
			esc_html__( 'Between', 'killarwt-core' ) => 'between',
			esc_html__( 'Around', 'killarwt-core' ) => 'around',
		);
	}
}

/**
 * Font Size Array
 */
if ( ! function_exists( 'killarwt_font_size_array' ) ) {

	function killarwt_font_size_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'fs-1', 'killarwt-core' ) => 'fs-1',
			esc_html__( 'fs-2', 'killarwt-core' ) => 'fs-2',
			esc_html__( 'fs-3', 'killarwt-core' ) => 'fs-3',
			esc_html__( 'fs-4', 'killarwt-core' ) => 'fs-4',
			esc_html__( 'fs-5', 'killarwt-core' ) => 'fs-5',
			esc_html__( 'fs-6', 'killarwt-core' ) => 'fs-6',
			esc_html__( 'Inherit', 'killarwt-core' ) => 'inherit',
			esc_html__( 'Custom', 'killarwt-core' ) => 'custom',
		);
	}
}

/**
 * Font Weight Array
 */
if ( ! function_exists( 'killarwt_font_weight_array' ) ) {

	function killarwt_font_weight_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Thin: 100', 'killarwt-core' ) => 'thin',
			esc_html__( 'Light: 200', 'killarwt-core' ) => 'light',
			esc_html__( 'Book: 300', 'killarwt-core' ) => 'book',
			esc_html__( 'Normal: 400', 'killarwt-core' ) => 'normal',
			esc_html__( 'Medium: 500', 'killarwt-core' ) => 'medium',
			esc_html__( 'Semibold: 600', 'killarwt-core' ) => 'semibold',
			esc_html__( 'Bold: 700', 'killarwt-core' ) => 'bold',
			esc_html__( 'Extra Bold: 800', 'killarwt-core' ) => 'extra-bold',
			esc_html__( 'Bolder: 900', 'killarwt-core' ) => 'bolder',
		);
	}
}


/**
 * Font Style Array
 */
if ( ! function_exists( 'killarwt_font_style_array' ) ) {

	function killarwt_font_style_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Normal', 'killarwt-core' ) => 'normal',
			esc_html__( 'Italic', 'killarwt-core' ) => 'italic',
		);
	}
}

/**
 * Font Style Array
 */
if ( ! function_exists( 'killarwt_text_transform_array' ) ) {

	function killarwt_text_transform_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'None', 'killarwt-core' ) => 'none',
			esc_html__( 'Capitalize', 'killarwt-core' ) => 'capitalize',
			esc_html__( 'Lowercase', 'killarwt-core' ) => 'lowercase',
			esc_html__( 'Uppercase', 'killarwt-core' ) => 'uppercase',
		);
	}
}

/**
 * Border Radious Array
 */
if ( ! function_exists( 'killarwt_border_radius_array' ) ) {

	function killarwt_border_radius_array() {
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Rounded-0', 'killarwt-core' ) => 'rounded-0',
			esc_html__( 'Rounded-1', 'killarwt-core' ) => 'rounded-1',
			esc_html__( 'Rounded-2', 'killarwt-core' ) => 'rounded-2',
			esc_html__( 'Rounded-3', 'killarwt-core' ) => 'rounded-3',
			esc_html__( 'Rounded-4', 'killarwt-core' ) => 'rounded-4',
			esc_html__( 'Rounded-5', 'killarwt-core' ) => 'rounded-5',
		);
	}
}


/**
 * Animations Array
 */
if ( ! function_exists( 'killarwt_animations_array' ) ) {

	function killarwt_animations_array() {		
		return array(
			esc_html__( 'None', 'killarwt-core' ) => '',
			esc_html__( 'Fade Up', 'killarwt-core' ) => 'fade-up',
			esc_html__( 'Fade Down', 'killarwt-core' ) => 'fade-down',
			esc_html__( 'Fade Right', 'killarwt-core' ) => 'fade-right',
			esc_html__( 'Fade Left', 'killarwt-core' ) => 'fade-left',
			esc_html__( 'Fade Up Right', 'killarwt-core' ) => 'fade-up-right',
			esc_html__( 'Fade Up Left', 'killarwt-core' ) => 'fade-up-left',
			esc_html__( 'Fade Down Right', 'killarwt-core' ) => 'fade-down-right',
			esc_html__( 'Fade Down Left', 'killarwt-core' ) => 'fade-down-left',
			esc_html__( 'Flip Left', 'killarwt-core' ) => 'flip-left',
			esc_html__( 'Flip Right', 'killarwt-core' ) => 'flip-right',
			esc_html__( 'Flip Up', 'killarwt-core' ) => 'flip-up',
			esc_html__( 'Flip Down', 'killarwt-core' ) => 'flip-down',
			esc_html__( 'Zoom In', 'killarwt-core' ) => 'zoom-in',
			esc_html__( 'Zoom In Up', 'killarwt-core' ) => 'zoom-in-up',
			esc_html__( 'Zoom In Down', 'killarwt-core' ) => 'zoom-in-down',
			esc_html__( 'Zoom In Left', 'killarwt-core' ) => 'zoom-in-left',
			esc_html__( 'Zoom In Right', 'killarwt-core' ) => 'zoom-in-right',
			esc_html__( 'Zoom Out', 'killarwt-core' ) => 'zoom-out',
			esc_html__( 'Zoom Out Up', 'killarwt-core' ) => 'zoom-out-up',
			esc_html__( 'Zoom Out Down', 'killarwt-core' ) => 'zoom-out-down',
			esc_html__( 'Zoom Out Left', 'killarwt-core' ) => 'zoom-out-left',
			esc_html__( 'Zoom Out Right', 'killarwt-core' ) => 'zoom-out-right',
		);
	}
}

/**
 * Social Icons Array
 */
if ( ! function_exists( 'killarwt_social_icons_array' ) ) {

	function killarwt_social_icons_array() {		
		return array(
			esc_html__( 'Facebook', 'killarwt-core' ) => 'facebook',
			esc_html__( 'Twitter', 'killarwt-core' ) => 'twitter',
			esc_html__( 'Instagram', 'killarwt-core' ) => 'instagram',
			esc_html__( 'WhatsApp', 'killarwt-core' ) => 'whatsapp',
			esc_html__( 'Linkedin', 'killarwt-core' ) => 'linkedin',
			esc_html__( 'Pinterest', 'killarwt-core' ) => 'pinterest',
			esc_html__( 'Youtube', 'killarwt-core' ) => 'youtube',
			esc_html__( 'Email', 'killarwt-core' ) => 'email',
			esc_html__( 'Github', 'killarwt-core' ) => 'github',
			esc_html__( 'Dribbble', 'killarwt-core' ) => 'dribbble',
			esc_html__( 'Behance', 'killarwt-core' ) => 'behance',
			esc_html__( 'VK', 'killarwt-core' ) => 'vk',
			esc_html__( 'Custom', 'killarwt-core' ) => 'custom',
			
		);
	}
}

/**
 * Color Array
 */
if ( ! function_exists( 'killarwt_color_array' ) ) {

	function killarwt_color_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => 'default',
			esc_html__( 'Theme', 'killarwt-core' ) => 'theme',
			esc_html__( 'Muted', 'killarwt-core' ) => 'muted',
			esc_html__( 'Primary', 'killarwt-core' ) => 'primary',
			esc_html__( 'Secondary', 'killarwt-core' ) => 'secondary',
			esc_html__( 'White', 'killarwt-core' ) => 'white',
			esc_html__( 'Danger', 'killarwt-core' ) => 'danger',
			esc_html__( 'Muted', 'killarwt-core' ) => 'muted',
			esc_html__( 'Muted-2', 'killarwt-core' ) => 'muted-2',
			esc_html__( 'Warning', 'killarwt-core' ) => 'warning',
			esc_html__( 'Success', 'killarwt-core' ) => 'success',
			esc_html__( 'Info', 'killarwt-core' ) => 'info',
			esc_html__( 'Royal', 'killarwt-core' ) => 'royal',
			esc_html__( 'Orange', 'killarwt-core' ) => 'orange',
			esc_html__( 'Black', 'killarwt-core' ) => 'black',
			esc_html__( 'Purple', 'killarwt-core' ) => 'purple',
			esc_html__( 'See Green', 'killarwt-core' ) => 'seegreen',
			esc_html__( 'Gray', 'killarwt-core' ) => 'gray',
			esc_html__( 'Custom', 'killarwt-core' ) => 'custom'
		);
	}
}

/**
 * BG Color Array
 */
if ( ! function_exists( 'killarwt_bg_color_array' ) ) {

	function killarwt_bg_color_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => 'default',
			esc_html__( 'Theme', 'killarwt-core' ) => 'theme',
			esc_html__( 'Primary', 'killarwt-core' ) => 'primary',
			esc_html__( 'Light Primary', 'killarwt-core' ) => 'light-primary',
			esc_html__( 'Success', 'killarwt-core' ) => 'success',
			esc_html__( 'Light Success', 'killarwt-core' ) => 'light-success',
			esc_html__( 'Info', 'killarwt-core' ) => 'info',
			esc_html__( 'Light Info', 'killarwt-core' ) => 'light-info',
			esc_html__( 'Warning', 'killarwt-core' ) => 'warning',
			esc_html__( 'Light Warning', 'killarwt-core' ) => 'light-warning',
			esc_html__( 'Danger', 'killarwt-core' ) => 'danger',
			esc_html__( 'Light Danger', 'killarwt-core' ) => 'light-danger',
			esc_html__( 'Purple', 'killarwt-core' ) => 'purple',
			esc_html__( 'Light Purple', 'killarwt-core' ) => 'light-purple',
			esc_html__( 'Orange', 'killarwt-core' ) => 'orange',
			esc_html__( 'Light Orange', 'killarwt-core' ) => 'light-orange',
			esc_html__( 'See Green', 'killarwt-core' ) => 'seegreen',
			esc_html__( 'Light See Green', 'killarwt-core' ) => 'light-seegreen',
			esc_html__( 'Royal', 'killarwt-core' ) => 'royal',
			esc_html__( 'Light Royal', 'killarwt-core' ) => 'light-royal',
			esc_html__( 'Dark', 'killarwt-core' ) => 'dark',
			esc_html__( 'Light Dark', 'killarwt-core' ) => 'light-dark',
			esc_html__( 'White', 'killarwt-core' ) => 'white',
			esc_html__( 'Black', 'killarwt-core' ) => 'black',
			esc_html__( 'Gray', 'killarwt-core' ) => 'gray',			
			esc_html__( 'Transparent', 'killarwt-core' ) => 'transparent',			
			esc_html__( 'Gray Smoke', 'killarwt-core' ) => 'graysmoke',			
			esc_html__( 'Custom', 'killarwt-core' ) => 'custom'
		);
	}
}

/**
 * Icon Size
 */
if ( ! function_exists( 'killarwt_icon_size_array' ) ) {

	function killarwt_icon_size_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Icon-5', 'killarwt-core' ) => 'ico-5',
			esc_html__( 'Icon-8', 'killarwt-core' ) => 'ico-8',
			esc_html__( 'Icon-10', 'killarwt-core' ) => 'ico-10',
			esc_html__( 'Icon-12', 'killarwt-core' ) => 'ico-12',
			esc_html__( 'Icon-13', 'killarwt-core' ) => 'ico-13',
			esc_html__( 'Icon-14', 'killarwt-core' ) => 'ico-14',
			esc_html__( 'Icon-15', 'killarwt-core' ) => 'ico-15',
			esc_html__( 'Icon-16', 'killarwt-core' ) => 'ico-16',
			esc_html__( 'Icon-17', 'killarwt-core' ) => 'ico-17',
			esc_html__( 'Icon-18', 'killarwt-core' ) => 'ico-18',
			esc_html__( 'Icon-19', 'killarwt-core' ) => 'ico-19',
			esc_html__( 'Icon-20', 'killarwt-core' ) => 'ico-20',
			esc_html__( 'Icon-21', 'killarwt-core' ) => 'ico-21',
			esc_html__( 'Icon-22', 'killarwt-core' ) => 'ico-22',
			esc_html__( 'Icon-25', 'killarwt-core' ) => 'ico-25',
			esc_html__( 'Icon-30', 'killarwt-core' ) => 'ico-30',
			esc_html__( 'Icon-35', 'killarwt-core' ) => 'ico-35',
			esc_html__( 'Icon-40', 'killarwt-core' ) => 'ico-40',
			esc_html__( 'Icon-45', 'killarwt-core' ) => 'ico-45',
			esc_html__( 'Icon-50', 'killarwt-core' ) => 'ico-50',
			esc_html__( 'Icon-55', 'killarwt-core' ) => 'ico-55',
			esc_html__( 'Icon-60', 'killarwt-core' ) => 'ico-60',
			esc_html__( 'Icon-65', 'killarwt-core' ) => 'ico-65',
			esc_html__( 'Icon-70', 'killarwt-core' ) => 'ico-70',
			esc_html__( 'Icon-75', 'killarwt-core' ) => 'ico-75',
			esc_html__( 'Icon-80', 'killarwt-core' ) => 'ico-80',
			esc_html__( 'Custom', 'killarwt-core' ) => 'ico-custom',
		);
	}
}

/**
 * Line Height Array
 */
if ( ! function_exists( 'killarwt_line_height_array' ) ) {

	function killarwt_line_height_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( '1', 'killarwt-core' ) => '1',
			esc_html__( 'Small', 'killarwt-core' ) => 'sm',
			esc_html__( 'Base', 'killarwt-core' ) => 'base',
			esc_html__( 'Large', 'killarwt-core' ) => 'lg',
			esc_html__( 'Inherit', 'killarwt-core' ) => 'inherit',
			esc_html__( 'Custom', 'killarwt-core' ) => 'custom',
		);
	}
}

/**
 * Button Color Array
 */
if ( ! function_exists( 'killarwt_button_color_array' ) ) {

	function killarwt_button_color_array() {		
		return array(
			esc_html__( 'Theme', 'killarwt-core' ) => 'theme',
			esc_html__( 'Muted', 'killarwt-core' ) => 'muted',
			esc_html__( 'Light', 'killarwt-core' ) => 'light',
			esc_html__( 'Danger', 'killarwt-core' ) => 'danger',
			esc_html__( 'Outline Danger', 'killarwt-core' ) => 'outline-danger',
			esc_html__( 'Light Danger', 'killarwt-core' ) => 'light-danger',
			esc_html__( 'Success', 'killarwt-core' ) => 'success',
			esc_html__( 'Outline Success', 'killarwt-core' ) => 'outline-success',
			esc_html__( 'Light Success', 'killarwt-core' ) => 'light-success',
			esc_html__( 'Warning', 'killarwt-core' ) => 'warning',
			esc_html__( 'Outline Warning', 'killarwt-core' ) => 'outline-warning',
			esc_html__( 'light Warning', 'killarwt-core' ) => 'light-warning',
			esc_html__( 'Primary', 'killarwt-core' ) => 'primary',
			esc_html__( 'Outline Primary', 'killarwt-core' ) => 'outline-primary',
			esc_html__( 'Light Primary', 'killarwt-core' ) => 'light-primary',
			esc_html__( 'Info', 'killarwt-core' ) => 'info',
			esc_html__( 'Outline Info', 'killarwt-core' ) => 'outline-info',
			esc_html__( 'Light Info', 'killarwt-core' ) => 'light-info',
			esc_html__( 'Royal', 'killarwt-core' ) => 'royal',
			esc_html__( 'Outline Royal', 'killarwt-core' ) => 'outline-royal',
			esc_html__( 'light Royal', 'killarwt-core' ) => 'light-royal',
			esc_html__( 'Purple', 'killarwt-core' ) => 'purple',
			esc_html__( 'Outline Purple', 'killarwt-core' ) => 'outline-purple',
			esc_html__( 'Light Purple', 'killarwt-core' ) => 'light-purple',
			esc_html__( 'Orange', 'killarwt-core' ) => 'orange',
			esc_html__( 'Outline Orange', 'killarwt-core' ) => 'outline-orange',
			esc_html__( 'Light Orange', 'killarwt-core' ) => 'light-orange',
			esc_html__( 'See Green', 'killarwt-core' ) => 'seegreen',
			esc_html__( 'Outline See Green', 'killarwt-core' ) => 'outline-seegreen',
			esc_html__( 'Light See Green', 'killarwt-core' ) => 'light-seegreen',
			esc_html__( 'Dark', 'killarwt-core' ) => 'dark',
			esc_html__( 'outline-dark', 'killarwt-core' ) => 'outline-dark',
			esc_html__( 'light-dark', 'killarwt-core' ) => 'light-dark',
			esc_html__( 'White', 'killarwt-core' ) => 'whites',
			esc_html__( 'Outline White', 'killarwt-core' ) => 'outline-whites',
			esc_html__( 'Light White', 'killarwt-core' ) => 'light-whites',
			esc_html__( 'Gray', 'killarwt-core' ) => 'gray',
			esc_html__( 'Outline Gray', 'killarwt-core' ) => 'outline-gray',
			esc_html__( 'Gray - 1', 'killarwt-core' ) => 'gray1',
			esc_html__( 'Black', 'killarwt-core' ) => 'black',
			esc_html__( 'Dark Black', 'killarwt-core' ) => 'dark-black',
			esc_html__( 'White', 'killarwt-core' ) => 'white',
			esc_html__( 'Secondary', 'killarwt-core' ) => 'secondary',
			esc_html__( 'Transparent Theme', 'killarwt-core' ) => 'tra-theme',
			esc_html__( 'Transparent Black', 'killarwt-core' ) => 'tra-black',
			esc_html__( 'Transparent White', 'killarwt-core' ) => 'tra-white',
			
			esc_html__( 'Outline See Green', 'killarwt-core' ) => 'outline-seegreen',

		);
	}
}

/**
 * Button Hover Color Array
 */
if ( ! function_exists( 'killarwt_button_hover_color_array' ) ) {

	function killarwt_button_hover_color_array() {
		return array(
			esc_html__( 'Theme', 'killarwt-core' ) => 'theme',
			esc_html__( 'Transparent Theme', 'killarwt-core' ) => 'tra-theme',
			esc_html__( 'Transparent Black', 'killarwt-core' ) => 'tra-black',
			esc_html__( 'Transparent White', 'killarwt-core' ) => 'tra-white',
		);
	}
}

/**
 * Button Size Array
 */
if ( ! function_exists( 'killarwt_button_size_array' ) ) {

	function killarwt_button_size_array() {		
		return array(
			esc_html__( 'Default', 'killarwt-core' ) => '',
			esc_html__( 'Large', 'killarwt-core' ) => 'lg',
			esc_html__( 'Medium', 'killarwt-core' ) => 'md',
			esc_html__( 'Small', 'killarwt-core' ) => 'sm',
			esc_html__( 'XSmall', 'killarwt-core' ) => 'xs',
			esc_html__( 'Inherit', 'killarwt-core' ) => 'inherit',
		);
	}
}

/**
 * Get font size class
 */
if ( ! function_exists( 'killarwt_font_size_class' ) ) {

	function killarwt_font_size_class( $type, $font_size ) {
		
		return $font_size;
		
		$class = '';
		if( in_array( $font_size, array( 'inherit' ) ) ) {
			$class = 'fs-' . $font_size;
		} else if( in_array( $type, array( 'span', 'div', 'p', 'a' ) ) ) {
			$class = 'fs-' . $font_size;
		} else {
			$class = $type . '-' . $font_size;
		}
		
		return $class;
	}
}

/**
 * Extract width/height from string
 *
 * @param string $dimensions WxH
 *
 * @return mixed array(width, height) or false
 *
 */
function killarwt_exts_extract_dimensions( $dimensions ) {
	$dimensions = str_replace( ' ', '', $dimensions );
	$matches = null;

	if ( preg_match( '/(\d+)x(\d+)/', $dimensions, $matches ) ) {
		return array(
			$matches[1],
			$matches[2],
		);
	}

	return false;
}

/**
 * @param $param_value
 * @param string $prefix
 *
 * @return string
 */
function killarwt_vc_shortcode_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

	return $css_class;
}

if ( ! function_exists( 'getCategoryChildsFull' ) ) {
	/**
	 * Get lists of categories.
	 * @param $parent_id
	 * @param array $array
	 * @param $level
	 * @param array $dropdown - passed by  reference
	 * @return array
	 * @since 4.5.3
	 *
	 */
	function getCategoryChildsFull( $parent_id, $array, $level, &$dropdown ) {
		$keys = array_keys( $array );
		$i = 0;
		while ( $i < count( $array ) ) {
			$key = $keys[ $i ];
			$item = $array[ $key ];
			$i ++;
			if ( $item->category_parent == $parent_id ) {
				$name = str_repeat( '- ', $level ) . $item->name;
				$value = $item->slug;
				$dropdown[] = array(
					'label' => $name . '(' . $item->term_id . ')',
					'value' => $value,
				);
				unset( $array[ $key ] );
				$array = getCategoryChildsFull( $item->term_id, $array, $level + 1, $dropdown );
				$keys = array_keys( $array );
				$i = 0;
			}
		}

		return $array;
	}

}

/**
 * @param $content
 * @param bool $autop
 *
 * @return string
 */
function killarwt_js_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

/**
 * Social Share
 */
if ( ! function_exists( 'killarwt_social_links' ) ) :

	function killarwt_social_links( $atts = array() ) {
		
		if( ! killarwt_social_share_enable() ) false;
		
		$atts = shortcode_atts(array(
			'type' 			=> 'share',			
			'style' 		=> 'icon-bordered',
			'shape' 		=> 'icons-shape-circle',
			'size' 			=> 'icons-size-default',
			'css' 			=> '',
			'el_classes' 		=> '',
			'echo' 			=> true,
		), $atts );
		
		extract($atts);
		
		$classes []= 'killar-social';
		$classes []= $style;
		$classes []= $shape;
		$classes []= $size;
		$classes []= ( $el_classes ) ? $el_classes : '';
		$classes []= killarwt_vc_shortcode_custom_css_class( $css, ' ' );
		$classes = implode( ' ', $classes );
		
		$post_title = '';
		$post_link = '';
		$share_twitter_username = '';
		$thumb_id = '';
		$thumb_url = array(0=>'');
		$enabled_social_networks = array();
		if($type == 'share' && killarwt_get_option('show-social-sharing', 1) ){
			$post_title   = htmlspecialchars( urlencode( html_entity_decode( esc_attr( get_the_title() ), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
			$post_link = get_the_permalink();
			// Twitter username
			$share_twitter_username = killarwt_get_option( 'share_twitter_username', '' ) ? ' via %40'.killarwt_get_option( 'share_twitter_username','' ) : '';
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
			$social_networks = killarwt_get_option('social-share-manager', array(
                    'enabled'  =>array(
				'facebook' 		=> 'Facebook',
				'twitter'     	=> 'Twitter',
				'linkedin'   	=> 'Linkedin',
				'telegram'		=> 'Telegram',
				'pinterest'		=> 'Pinterest',
			)));
			$enabled_social_networks = $social_networks['enabled'];			
		}
		
		// Buttons array
		$share_buttons = array(

			'facebook' => array(
				'url'  => 'https://www.facebook.com/sharer/sharer.php?u='. $post_link,
				'text' => esc_html__( 'Facebook', 'killarwt-core' ),
				'icon' => 'fa fa-facebook',
			),
			'twitter' => array(
				'url'   => 'https://twitter.com/share?url='. $post_title . $share_twitter_username .'&amp;url='. $post_link,
				'text'  => esc_html__( 'Twitter', 'killarwt-core' ),
				'icon' => 'fa fa-x-twitter',
			),
			'linkedin' => array(
				'url'  => 'https://www.linkedin.com/shareArticle?mini=true&url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'LinkedIn', 'killarwt-core' ),
				'icon' => 'fa fa-linkedin',
			),
			'stumbleupon' => array(
				'url'  => 'http://www.stumbleupon.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'StumbleUpon', 'killarwt-core' ),
				'icon' => 'fa fa-stumbleupon',
			),
			'tumblr' => array(
				'url'  => 'https://tumblr.com/widgets/share/tool?canonicalUrl='. $post_link .'&amp;name='. $post_title,
				'text' => esc_html__( 'Tumblr', 'killarwt-core' ),
				'icon' => 'fa fa-tumblr',
			),
			'pinterest' => array(
				'url'  => 'https://pinterest.com/pin/create/button/?url='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Pinterest', 'killarwt-core' ),
				'icon' => 'fa fa-pinterest',
			),
			'reddit' => array(
				'url'  => 'https://reddit.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'Reddit', 'killarwt-core' ),
				'icon' => 'fa fa-reddit',
			),
			'vk' => array(
				'url'  => 'https://vk.com/share.php?url='. $post_link,
				'text' => esc_html__( 'VKontakte', 'killarwt-core' ),
				'icon' => 'fa fa-vk',
			),
			'odnoklassniki' => array(
				'url'  => 'https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Odnoklassniki', 'killarwt-core' ),
				'icon' => 'fa fa-odnoklassniki',
			),
			'pocket' => array(
				'url'  => 'https://getpocket.com/save?title='. $post_title .'&amp;url='.$post_link,
				'text' => esc_html__( 'Pocket', 'killarwt-core' ),
				'icon' => 'fa fa-get-pocket',
			),
			'whatsapp' => array(
				'url'   => 'https://wa.me/?text='. $post_link,
				'text'  => esc_html__( 'WhatsApp', 'killarwt-core' ),
				'icon' => 'fa fa-whatsapp',
				'avoid_esc' => true,
			),
			'telegram' => array(
				'url'   => 'https://telegram.me/share/url?url='.$post_link,
				'text'  => esc_html__( 'Telegram', 'killarwt-core' ),
				'icon'  => 'fa fa-telegram',
				'avoid_esc' => true,
			),	
			'email' => array(
				'url'  => 'mailto:?subject='. $post_title .'&amp;body='. $post_link,
				'text' => esc_html__( 'Email', 'killarwt-core' ),
				'icon' => 'fa fa-envelope',
			),
			'print' => array(
				'url'  => '#',
				'text' => esc_html__( 'Print', 'killarwt-core' ),
				'icon' => 'fa fa-print',
				'check'=> killarwt_get_option('share-print', 0 ),
			),
			'instagram' => array(
				'url'  => '#',
				'text' => esc_html__( 'Instagram', 'killarwt-core' ),
				'icon' => 'fa fa-instagram',
			),
			'flickr' => array(
				'url'  => '#',
				'text' => esc_html__( 'Flickr', 'killarwt-core' ),
				'icon' => 'fa fa-flickr',
			),
			'rss' => array(
				'url'  => '#',
				'text' => esc_html__( 'RSS', 'killarwt-core' ),
				'icon' => 'fa fa-rss',
			),
			'youtube' => array(
				'url'  => '#',
				'text' => esc_html__( 'Youtube', 'killarwt-core' ),
				'icon' => 'fa fa-youtube',
			),
			'github' => array(
				'url'  => '#',
				'text' => esc_html__( 'Github', 'killarwt-core' ),
				'icon' => 'fa fa-github',
			),			
		);
		
		$share_buttons = apply_filters( 'killarwt_social_share_buttons', $share_buttons );
		
		$active_share_buttons = array();
		
		foreach ( $share_buttons as $network => $button ){
			$social_link = '';
			
			if($type == 'share' && killarwt_get_option('show-social-share', 1) && array_key_exists($network,$enabled_social_networks)){
				$social_link = $button['url'];
			}elseif($type == 'profile' && killarwt_get_option('show-social-profile', 1) && killarwt_get_option($network.'-link','')){
				$social_link = killarwt_get_option($network.'-link','');
			}
			if( !empty($social_link)  && ! isset( $button['avoid_esc'] )){
				$button['url'] = esc_url( $social_link );
			}
			if(!empty($social_link)){
				$active_share_buttons[$network] = '<a href="'. $social_link .'" rel="external" target="_blank" class="social-'. $network.'"><i class="'. $button['icon'] .'"></i> <span class="social-text">'. $button['text'] .'</span></a>';
			}
		}
		
		/**
		* social share icon order
		*/
		$active_share = array();
		if(!empty($enabled_social_networks)){
			foreach($enabled_social_networks as $social_key => $value){
				if(isset($active_share_buttons[$social_key]))
				$active_share[$social_key] =  $active_share_buttons[$social_key]; 
			}
			$active_share_buttons = array_merge($active_share,$active_share_buttons);
		}
		if( is_array( $active_share_buttons ) && ! empty( $active_share_buttons ) ){
			if($echo){	?>
				<div class="<?php echo esc_attr($classes);?>">
					<?php echo implode( '', $active_share_buttons ); ?>
				</div>
			<?php			
			}else{
				return implode( '', $active_share_buttons );
			}		
		}		
	}
endif;

/*
 * Get Categories
 */
function killarwt_categories( $category, $field_key_return = '' ) {
	
	$categories = get_categories( array( 'taxonomy' => $category ));
	$array = array( '' => 'All');
	foreach( $categories as $cat ){
		if( $field_key_return == 'id' ) {
			$cat_key = $cat->term_id;
		} else {
			$cat_key = $cat->slug;
		}
	
		if( is_object($cat) ) $array[$cat_key] = $cat->cat_name;
	}

	return $array;
}

/*
 * Get Portfolioes
 */
function killarwt_blog_posts() {
	
	$query_args = array(
		'post_type'      		=> 'post',
		'post_status'        	=> array('publish'),
		'posts_per_page'    	=> '-1',
		'ignore_sticky_posts'	=> true,
		'orderby'				=> 'ID',
		'order'					=> 'DESC',
	);
	
	$query = new WP_Query( $query_args );
	$array = array( 'all' => 'All');
	if( !empty( $query ) ) {
		while ( $query->have_posts() ) : $query->the_post();
		$id = get_the_id();
		$array[$id] = get_the_title() . ' - #ID ' . $id;
		endwhile;
		wp_reset_postdata();
	}
	return $array;
}

/*
 * Get Portfolioes
 */
function killarwt_portfolioes() {
	
	$query_args = array(
		'post_type'      		=> 'portfolio',
		'post_status'        	=> array('publish'),
		'posts_per_page'    	=> '-1',
		'ignore_sticky_posts'	=> true,
		'orderby'				=> 'ID',
		'order'					=> 'desc',
	);
	
	$query = new WP_Query( $query_args );
	$array = array( 'all' => 'All');
	if( !empty( $query ) ) {
		while ( $query->have_posts() ) : $query->the_post();
		
		$array[get_the_id()] = get_the_title();
		endwhile;
		wp_reset_postdata();
	}
	return $array;
}

/**
* Get server info
*/
if( !function_exists( 'killarwt_get_server_info' ) ) {
	function killarwt_get_server_info(){
		return $_SERVER['SERVER_SOFTWARE'];
	}
}

/**
* Get Url Data
*/
if( !function_exists( 'killarwt_get_url_data' ) ) {
	function killarwt_get_url_data( $atts ) {
		$link_atts = array();
		if( !empty( $atts ) ) {
			if( $atts['url'] ) $link_atts['href'] = $atts['url'];
			if( $atts['is_external'] ) $link_atts['target'] = 'target="_blank"';
			if( $atts['nofollow'] ) $link_atts['rel'] = 'nofollow';
			if( isset( $atts['custom_attributes'] ) ) {
				$custom_attributes = Elementor\Utils::parse_custom_attributes( $atts['custom_attributes'] );
				foreach ( $custom_attributes as $key => $value ) {
					$link_atts[$key] = $value;
				}
			}
		}
		return $link_atts;
	}
}

/**
* Get Shortcode Fields Html
*/
if( !function_exists( 'killarwt_get_shortcodes_fields_html' ) ) {
	
	function killarwt_get_shortcodes_fields_html( $field_name, $atts, $item = array(), $extra_attr = array() ) {
		
		$html = '';
		
		if( !empty( $item ) ) {
			$atts = array_merge( $atts, $item );
		}
		
		if( !empty( $field_name ) && !empty( $atts[$field_name] ) ) {
			
			$field_attr = array();
			
			if( in_array( $atts["{$field_name}_size"], array( 'a' ) ) && !empty( $atts['link']['url'] ) ) {
				$field_attr = $field_attr + killarwt_get_url_data( $atts['link'] );
				if( !empty( $atts['link_popup'] ) ) $field_attr['data-fancybox'] = '';
				if( !empty( $atts['link_popup'] ) ) $field_attr['data-type'] = 'iframe';
			}
			
			$field_attr['class'] = array( "bx-{$field_name}" );
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_font_size"] ) && !in_array( $atts["{$field_name}_font_size"], array( '', 'custom' ) ) ) ? killarwt_font_size_class( $atts["{$field_name}_size"], $atts["{$field_name}_font_size"] ) : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_font_weight"] ) && !in_array( $atts["{$field_name}_font_weight"], array( '' ) ) ) ? killarwt_get_font_weight_class( $atts["{$field_name}_font_weight"] ) : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_font_style"] ) && !in_array( $atts["{$field_name}_font_style"], array( '', 'normal', 'default' ) ) ) ? 'fst-' . $atts["{$field_name}_font_style"] : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_text_transform"] ) && !in_array( $atts["{$field_name}_text_transform"], array( '', 'normal' ) ) ) ? 'text-' . $atts["{$field_name}_text_transform"] : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_color"] ) && !in_array( $atts["{$field_name}_color"], array( '', 'custom', 'default' ) ) ) ? 'text-' . $atts["{$field_name}_color"] : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_line_height"] ) && !in_array( $atts["{$field_name}_line_height"], array( '', 'custom' ) ) ) ? 'lh-' . $atts["{$field_name}_line_height"]  : '';
			$field_attr['class'][] = ( !empty( $atts["{$field_name}_el_classes"] ) ) ? $atts["{$field_name}_el_classes"] : '';
			$field_attr['class'] += killarwt_get_shortcodes_alignment_array( $field_name, $atts, 'text' );
			
			$field_attr += killarwt_get_shortcodes_animations_array( $atts, $field_name .'_' );
			
			if( !empty( $extra_attr['class'] ) ) {
				$field_attr['class'][] = killarwt_stringify_classes( $extra_attr['class'] );
			}
			if( !empty( $extra_attr ) ) {
				unset( $extra_attr['class'] );
				$field_attr = array_merge( $field_attr, $extra_attr );
			}
			
			$html .= '<'. $atts["{$field_name}_size"] .' ' . killarwt_stringify_atts( $field_attr ) . '>' . wp_kses_post( $atts["{$field_name}"] ) . '</'. $atts["{$field_name}_size"] .'>';
		}
		return $html;
	}
}

/**
* Get Data Wrap Common Classes Array
*/
if( !function_exists( 'killarwt_get_shortcodes_wrap_common_array' ) ) {
	
	function killarwt_get_shortcodes_wrap_common_array( $atts, $args = array() ) {
		
		if( !isset( $args['class'] ) ) $args['class'] = array();
		$args['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_hor', $atts, 'hor' );
		$args['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_ver', $atts, 'ver' );
		$args['class'] += killarwt_get_shortcodes_alignment_array( 'wrap_text', $atts, 'text' );
		$args['class'][] = ( !empty( $atts['wrap_el_classes'] ) ) ? $atts['wrap_el_classes'] : '';
		
		return $args;
	}
}

/**
* Get Data Common Classes Array
*/
if( !function_exists( 'killarwt_get_shortcodes_common_array' ) ) {
	function killarwt_get_shortcodes_common_array( $atts, $args = array() ) {
		
		if( !isset( $args['class'] ) ) $args['class'] = array();

		$args = killarwt_get_shortcodes_icon_classes_array( $atts, $args );
		$args += killarwt_get_shortcodes_animations_array( $atts );
		
		return $args;
	}
}

/**
* Get Data Animations
*/
if( !function_exists( 'killarwt_get_shortcodes_animations_array' ) ) {
	function killarwt_get_shortcodes_animations_array( $atts, $name = '', $item = array() ) {
		
		if( !empty( $item ) ) {
			$atts = array_merge( $atts, $item );
		}
		
		$args = array();
		if( !empty( $atts["{$name}animation"] ) ) {
			$args['data-aos'] = $atts["{$name}animation"];
			if ( !empty( $atts["{$name}animation_durations"] ) ) $args['data-aos-duration'] = $atts["{$name}animation_durations"];
			if ( !empty( $atts["{$name}animation_delay"] ) ) $args['data-aos-delay'] = $atts["{$name}animation_delay"];
		}
		return $args;
	}
}

/**
* Get Data Alignment
*/
if( !function_exists( 'killarwt_get_shortcodes_alignment_array' ) ) {
	function killarwt_get_shortcodes_alignment_array( $name, $atts, $type = 'text' ) {
		
		$args = array();
		if( $type == 'ver' ) {
			if( !empty( $atts["{$name}_alignment"] ) ) $args[$name.'lg'] = 'align-items-' . $atts["{$name}_alignment"];
			if( !empty( $atts["{$name}_alignment_tablet"] ) ) $args[$name.'md'] = 'align-items-md-' . $atts["{$name}_alignment_tablet"];
			if( !empty( $atts["{$name}_alignment_mobile"] ) ) $args[$name.'sm'] = 'align-items-sm-' . $atts["{$name}_alignment_mobile"];
		} else if( $type == 'hor' ) {
			if( !empty( $atts["{$name}_alignment"] ) ) $args[$name.'lg'] = 'jus-con-' . $atts["{$name}_alignment"];
			if( !empty( $atts["{$name}_alignment_tablet"] ) ) $args[$name.'md'] = 'jus-con-md-' . $atts["{$name}_alignment_tablet"];
			if( !empty( $atts["{$name}_alignment_mobile"] ) ) $args[$name.'sm'] = 'jus-con-sm-' . $atts["{$name}_alignment_mobile"];
		} else {
			if( !empty( $atts["{$name}_alignment"] ) ) $args[$name.'lg'] = 'txt-' . $atts["{$name}_alignment"];
			if( !empty( $atts["{$name}_alignment_tablet"] ) ) $args[$name.'md'] = 'txt-md-' . $atts["{$name}_alignment_tablet"];
			if( !empty( $atts["{$name}_alignment_mobile"] ) ) $args[$name.'sm'] = 'txt-sm-' . $atts["{$name}_alignment_mobile"];
		}

		return $args;
	}
}

/**
* Get font weight class
*/
if( !function_exists( 'killarwt_get_font_weight_class' ) ) {
	function killarwt_get_font_weight_class( $weight = '' ) {
		
		if ( !empty( $weight ) ) {
			if ( in_array( $weight, array( 'medium', 'bold', 'semibold' ) )  ) {
				return 'font--' . $weight;
			} else {
				return 'fw-' . $weight;
			}
		}
		return;
	}
}

/**
* Get Shortcode Image Html
*/
if( !function_exists( 'killarwt_get_shortcodes_image_html' ) ) {
	function killarwt_get_shortcodes_image_html( $atts, $item = array(), $extra_attr = array() ) {
		
		$html = '';
		if( !empty( $item ) ) {
			$atts = array_merge( $atts, $item );
		}
		
		if( !empty( $atts['image'] ) ) {
			
			$no_wrap = false;
			if( !empty( $extra_attr['no_wrap'] ) ) {
				$no_wrap = true;
				unset( $extra_attr['no_wrap'], $extra_attr['wrap_class'] );
			} 
			
			$image_wrap_attr = array();
			if( empty( $no_wrap ) ) {
				
				$image_wrap_attr['class'] = array( 'bx-img img-fluid' );
				$image_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'image', $atts );
				$image_wrap_attr['class'][] = ( !empty( $atts['image_hover_overlay'] ) ) ? 'hover-overlay' : '';
				$image_wrap_attr['class'][] = ( !empty( $atts['image_wrap_el_classes'] ) ) ? $atts['image_wrap_el_classes'] : '';
				if( !empty( $extra_attr['wrap_class'] ) ) {
					$image_wrap_attr['class'][] = killarwt_stringify_classes( $extra_attr['wrap_class'] );
				}
				
				if( !empty( $extra_attr ) ) {
					unset( $extra_attr['wrap_class'] );
					$image_wrap_attr = array_merge( $image_wrap_attr, $extra_attr );
				}
			}
			
			$image_size = '';
			if ( $atts['thumbnail_size'] == 'custom' && !empty( $atts['thumbnail_custom_dimension']['width'] ) && !empty( $atts['thumbnail_custom_dimension']['height'] )  ){
				$image_size = $atts['thumbnail_custom_dimension']['width'].'x'.$atts['thumbnail_custom_dimension']['height'];
			} else {
				$image_size = $atts['thumbnail_size'];
			}
			
			$image_attr = array();
			$image_attr['attach_id'] = ( !empty( $atts['image']['id'] ) ) ? $atts['image']['id'] : '';
			$image_attr['size'] = $image_size;
			$image_attr['alt'] = ( !empty( $atts['image_alt_text'] ) ) ? $atts['image_alt_text'] : '';
			$image_attr['title'] = ( !empty( $atts['image_alt_text'] ) ) ? $atts['image_alt_text'] : '';

			$image_attr['class'] = array( 'img-fluid post-image' );
			$image_attr['class'][] = ( !empty( $atts['image_rounded_cornors'] ) ) ? $atts['image_rounded_cornors'] : '';;
			$image_attr['class'][] = ( !empty( $atts['image_el_classes'] ) ) ? $atts['image_el_classes'] : '';
			$image_attr['class'][] = ( !empty( $atts['classes'] ) ) ? $atts['classes'] : '';
			if( !empty( $extra_attr['class'] ) ) {
				$image_attr['class'][] = killarwt_stringify_classes( $extra_attr['class'] );
			}

			$image_attr['class'] = killarwt_stringify_classes( $image_attr['class'] );
			
			$image_attr['atts'] = array();
			$image_attr['atts'] += killarwt_get_shortcodes_animations_array( $atts );
			
			if( !empty( $extra_attr ) ) {
				unset( $extra_attr['class'] );
				$image_attr['atts'] = array_merge( $image_attr['atts'], $extra_attr );
			}
			
			$post_image = killarwt_get_image_html( $image_attr );
			
			if( empty( $no_wrap ) && !empty( $post_image ) ) { 
				$html .= '<div ' . killarwt_stringify_atts( $image_wrap_attr ) . '>';
				$html .= $post_image;
				$html .= '</div>';
			} else {
				$html .= $post_image;
			}
		}
		return $html;
	}
}

/**
* Get Carousel Atts
*/
if( !function_exists( 'killarwt_get_shortcodes_carousel_atts' ) ) {
	
	function killarwt_get_shortcodes_carousel_atts( $atts, $args = array() ) {
		
		if( !isset( $args['class'] ) ) $args['class'] = array();
		if( !empty( $atts['items'] ) ) {
			$args['class'][] = 'kwt-slick-slider';
			$args['class'][] = ( !empty( $atts['carousel_el_classes'] ) ) ? $atts['carousel_el_classes'] : '';
			if( isset( $atts['nums_rows'] ) ) $args['data-rows'] = (int)$atts['nums_rows'];
			if( isset( $atts['items_col_xxl'] ) ) $args['data-items'] = (int)$atts['items_col_xxl'];
			if( isset( $atts['items_col_xxl'] ) ) $args['data-items-xxl'] = (int)$atts['items_col_xxl'];
			if( isset( $atts['items_col_xl'] ) ) $args['data-items-xl'] = (int)$atts['items_col_xl'];
			if( isset( $atts['items_col_lg'] ) ) $args['data-items-lg'] = (int)$atts['items_col_lg'];
			if( isset( $atts['items_col_md'] ) ) $args['data-items-md'] = (int)$atts['items_col_md'];
			if( isset( $atts['items_col_sm'] ) ) $args['data-items-sm'] = (int)$atts['items_col_sm'];
			if( isset( $atts['items_col_xs'] ) ) $args['data-items-xs'] = (int)$atts['items_col_xs'];
			if( isset( $atts['items_col_xxs'] ) ) $args['data-items-xxs'] = (int)$atts['items_col_xxs'];
			if( isset( $atts['carousel_nav'] ) ) $args['data-nav'] = killarwt_bool_text( (int)$atts['carousel_nav'] );
			if( isset( $atts['carousel_infinite'] ) ) $args['data-infinite'] = killarwt_bool_text( (int)$atts['carousel_infinite'] );
			if( isset( $atts['carousel_dots'] ) ) $args['data-dots'] = killarwt_bool_text( (int)$atts['carousel_dots'] );
			if( isset( $atts['carousel_speed'] ) ) $args['data-speed'] = $atts['carousel_speed'];
			if( isset( $atts['carousel_autoplay'] ) ) $args['data-autoplay'] = killarwt_bool_text( (int)$atts['carousel_autoplay'] );
			if( isset( $atts['carousel_autoplay_speed'] ) ) $args['data-autoplay-speed'] = $atts['carousel_autoplay_speed'];
			if( isset( $atts['carousel_center_mode'] ) ) $args['data-center-mode'] = killarwt_bool_text( (int)$atts['carousel_center_mode'] );
			if( isset( $atts['carousel_variable_width'] ) ) $args['data-variable-width'] = killarwt_bool_text( (int)$atts['carousel_variable_width']);
			if( isset( $atts['carousel_variable_width_tablet'] ) ) $args['data-variable-width-tablet'] = killarwt_bool_text( (int)$atts['carousel_variable_width_tablet'] );
			if( isset( $atts['data-variable-width-mobile'] ) ) $args['data-variable-width-mobile'] = killarwt_bool_text( (int)$atts['carousel_variable_width_mobile'] );
			if( isset( $atts['carousel_adaptive_height'] ) ) $args['data-adaptive-height'] = killarwt_bool_text( (int)$atts['carousel_adaptive_height']);
			if( isset( $atts['carousel_as_nav_for'] ) ) $args['data-as-nav-for'] = $atts['carousel_as_nav_for'];
		}
		
		return $args;
	}
}

/**
* Get Data Icon Classes Array
*/
if( !function_exists( 'killarwt_get_shortcodes_icon_classes_array' ) ) {
	function killarwt_get_shortcodes_icon_classes_array( $atts, $args = array() ) {

		if( !isset( $args['class'] ) ) $args['class'] = array();
		$icon_type = ( !empty( $atts['icon_type'] ) ) ? $atts['icon_type'] : '';
		if( !in_array( $icon_type, array( 'none', '' ) ) ) {
			$args['class'][] = 'kwt-bxim';
			$args['class'][] = ( !empty( $icon_type ) ) ? 'media-' . $icon_type : '';
			$args['class'][] = ( !empty( $atts['icon_size'] ) ) ? 'ico-csize' : '';
			$args['class'][] = ( !empty( $atts['icon_view'] ) && !in_array( $atts['icon_view'], array( '', 'default' ) ) ) ? 'bxim-stkfrm' : '';
			$args['class'][] = ( !empty( $atts['icon_view'] ) ) ? 'bxim-view-' . $atts['icon_view'] : '';
			$args['class'][] = ( !empty( $atts['icon_view'] ) && !in_array( $atts['icon_view'], array( '', 'default' ) ) && !in_array( $atts['icon_shape'], array( '' ) ) ) ? 'bxim-shape-' . $atts['icon_shape'] : '';
			$args['class'][] = ( !empty( $atts['icon_position'] ) ) ? 'bxim-pos-' . $atts['icon_position'] : '';
			$args['class'][] = ( !empty( $atts['icon_position_tablet'] ) ) ? 'bxim-pos-md-' . $atts['icon_position_tablet'] : '';
			$args['class'][] = ( !empty( $atts['icon_position_mobile'] ) ) ? 'bxim-pos-sm-' . $atts['icon_position_mobile'] : '';
		}
		
		return $args;
	}
}

/**
* Get Shortcode Social Icon Html
*/
if( !function_exists( 'killarwt_get_shortcodes_social_icon_html' ) ) {
	function killarwt_get_shortcodes_social_icon_html( $atts, $icon_items = array(), $extra_attr = array() ) {
		
		$html = '';
		if( !empty( $icon_items ) ) {
			
			$data_attr = array();
			$data_attr['class'] = array( 'fbx-icons', 'fbx-soc-icons', 'no-list-style' );
			$data_attr = killarwt_get_shortcodes_icon_classes_array( $atts, $data_attr );
			$data_attr['class'][] = ( in_array( $atts['icon_color'], array( 'colored' ) ) ) ? 'btn-colored' : '';
			$data_attr['class'][] = ( in_array( $atts['icon_hcolor'], array( 'colored' ) ) ) ? 'btn-hcolored' : '';
			$data_attr['class'][] = ( ! empty( $atts['icon_wrap_el_classes'] ) ) ? $atts['icon_wrap_el_classes'] : '';
			$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'icon', $atts, 'hor' );
			$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'icon_ver', $atts, 'ver' );
			
			if( !empty( $extra_attr['wrap_class'] ) ) {
				$data_attr['class'][] = killarwt_stringify_classes( $extra_attr['wrap_class'] );
			}
			
			if( !empty( $extra_attr ) ) {
				unset( $extra_attr['wrap_class'] );
				$data_attr['atts'] = array_merge( $data_attr['atts'], $extra_attr );
			}
			
			$html .= '<ul ' . killarwt_stringify_atts( $data_attr ) . '>';
	
			foreach( $icon_items as $k => $item ) {
									
				$item_attr = array();
				$item_attr['class'] = array( 'fbox-ico bx-icon-wrap' );
				$item_attr['class'][] = ( ! empty( $atts['el_classes'] ) ) ? $atts['el_classes'] : '';
				$item_attr['class'][] = ( !empty( $atts['icon_size'] ) && !in_array( $atts['icon_size'], array( '','default','custom' ) ) ) ? $atts['icon_size'] : '';
				
				if( !empty( $extra_attr['item_class'] ) ) {
					$item_attr['class'][] = killarwt_stringify_classes( $extra_attr['item_class'] );
				}
				
				if( !empty( $extra_attr ) ) {
					unset( $extra_attr['item_class'] );
					$item_attr['atts'] = array_merge( $item_attr['atts'], $extra_attr );
				}
				
				$html .= '<li ' . killarwt_stringify_atts( $item_attr ) . '>';
				
				$icon_attr = array();
				$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
				$icon_attr['class'][] = ( !in_array( $item['icon'], array( '', 'custom' ) ) ) ? 'ico-'. $item['icon'] : '';
				$icon_attr = $icon_attr + killarwt_get_url_data( $item['link'] );
				$icon_attr['class'][] = ( !empty( $atts['icon_el_classes'] ) ) ? $atts['icon_el_classes'] : '';
				$icon_attr['aria-label'] = $item['icon'];
				
				if( !empty( $extra_attr['class'] ) ) {
					$icon_attr['class'][] = killarwt_stringify_classes( $extra_attr['class'] );
				}
				
				if( !empty( $extra_attr ) ) {
					unset( $extra_attr['class'] );
					$icon_attr['atts'] = array_merge( $icon_attr['atts'], $extra_attr );
				}
				
				if( in_array( $atts['icon_view'], array( 'stacked', 'framed' ) ) && !in_array( $atts['icon_color'], array( '', 'colored', 'custom' ) ) ) {
					$icon_attr['class'][] =  'btn btn-' . $atts['icon_color'];
				} else {
					$icon_attr['class'][] =  'text-' . $atts['icon_color'];
				}
				
				if( in_array( $atts['icon_view'], array( 'stacked', 'framed' ) ) && !in_array( $atts['icon_hcolor'], array( '', 'colored', 'custom' ) ) ) {
					$icon_attr['class'][] =  'btn btn-h' . $atts['icon_hcolor'];
				} else {
					$icon_attr['class'][] =  $atts['icon_hcolor'] . '-hover';
				}
				
		
				$html .= '<a ' . killarwt_stringify_atts( $icon_attr ) . '>';
				
				if( !empty( $item['icon'] ) ) {
					if( $item['icon'] != 'custom' ) {
						$item['icon'] = ( $item['icon'] == 'facebook' ) ? $item['icon']  : $item['icon'];
						$html .= '<span class="fa-brands fa-' . esc_attr( $item['icon'] ) .'"></span>';
					} else {
						$html .= '<span title="' . esc_attr( $item['icon_alt'] ) .'" class="' . esc_attr( $item['icon_custom'] ) .'"></span>';
					}
				}
				
				$html .= '</a>';
				$html .= '</li>';
			}
				
			$html .= '</ul>';
		}
		
		return $html;
	}
}

/**
* Get Shortcode Icon Html
*/
if( !function_exists( 'killarwt_get_shortcodes_icon_html' ) ) {
	function killarwt_get_shortcodes_icon_html( $atts, $item = array() ) {
		
		$html = '';
		if( !empty( $item ) ) {
			$atts = array_merge( $atts, $item );
		}
		
		if( !in_array( $atts['icon_type'], array( 'none', 'number', 'disc' ) ) ) {
			
			$icon_image_wrap_attr = array();
			$icon_image_wrap_attr['class'] = array( 'fbox-ico bx-im-wrap' );
			$icon_image_wrap_attr['class'][] = ( ! empty( $atts['icon_wrap_el_classes'] ) ) ? $atts['icon_wrap_el_classes'] : '';
			$icon_image_wrap_attr['class'][] = ( !empty( $atts['icon_size'] ) && !in_array( $atts['icon_size'], array( '','default','custom' ) ) ) ? $atts['icon_size'] : '';
			$icon_image_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'icon', $atts, 'hor' );
			$icon_image_wrap_attr['class'] += killarwt_get_shortcodes_alignment_array( 'icon_ver', $atts, 'ver' );
			
			$html .= '<span ' . killarwt_stringify_atts( $icon_image_wrap_attr ) . '>';
						
				$icon_attr = array();
				$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
				$icon_attr['class'][] = ( !in_array( $atts['icon_color'], array( '', 'custom', 'default' ) ) ) ? 'text-' . $atts['icon_color'] : '';
				$icon_attr['class'][] = ( !in_array( $atts['icon_bg_color'], array( '', 'custom', 'default' ) ) ) ? 'bg-' . $atts['icon_bg_color'] : '';
				$icon_attr['class'][] = ( !empty( $atts['icon_rounded_cornors'] ) ) ? $atts['icon_rounded_cornors'] : '';
				$icon_attr['class'][] = ( !empty( $atts['icon_el_classes'] ) ) ? $atts['icon_el_classes'] : '';
			
				$html .= '<span ' . killarwt_stringify_atts( $icon_attr ) . '>';
				
				// Icon ---------------------------------------
				
				if( $atts['icon_type'] == 'icon' && !empty( $atts['icon'] ) ) {
					$icon_ar = array();
					$icon_ar['class'] = array('list-icon');
					$html .= killarwt_elementor_render_icon( $atts['icon'], $icon_ar, 'span' );
					if( !empty( $atts['icon_active'] ) ) {
						$icon_ar['class'][] = 'icon-active';
						$html .= killarwt_elementor_render_icon( $atts['icon_active'], $icon_ar, 'span' );
					}
				}

				// Image ---------------------------------------
				if( $atts['icon_type'] == 'image' && !empty( $atts['icon_image'] ) ) {
					
					$image_wrap_attr = array();
					$image_wrap_attr['class'] = array( 'bx-img' );
					$image_wrap_attr['class'][] = ( !empty( $atts['icon_image_wrap_el_classes'] ) ) ? $atts['icon_image_wrap_el_classes'] : '';
					
					$icon_image_size = '';
					if ( $atts['icon_thumbnail_size'] == 'custom' && !empty( $atts['icon_thumbnail_custom_dimension']['width'] ) && !empty( $atts['icon_thumbnail_custom_dimension']['height'] )  ) {
						$icon_image_size = $atts['icon_thumbnail_custom_dimension']['width'].'x'.$atts['icon_thumbnail_custom_dimension']['height'];
					} else {
						$icon_image_size =  $atts['icon_thumbnail_size'];
					}
					
					$image_attr = array();
					$image_attr['attach_id'] = ( !empty( $atts['icon_image']['id'] ) ) ? $atts['icon_image']['id'] : '';
					$image_attr['size'] = $icon_image_size;
					$image_attr['alt'] = ( !empty( $atts['icon_image_alt_text'] ) ) ? $atts['icon_image_alt_text'] : '';
					$image_attr['title'] = ( !empty( $atts['icon_image_alt_text'] ) ) ? $atts['icon_image_alt_text'] : '';
					$image_attr['class'] = array( 'img-fluid post-image' );
					$image_attr['class'][] = ( !empty( $atts['icon_image_rounded_cornors'] ) ) ? $atts['icon_image_rounded_cornors'] : '';
					$image_attr['class'][] = ( !empty( $atts['icon_image_hover_overlay'] ) ) ? 'hover-overlay' : '';
					$image_attr['class'][] = ( !empty( $atts['icon_image_el_classes'] ) ) ? $atts['icon_image_el_classes'] : '';
					$image_attr['class'] = killarwt_stringify_classes( $image_attr['class'] );
					
					$post_image = killarwt_get_image_html( $image_attr );
					
					if( !empty( $post_image ) ) { 
						$html .= '<span ' . killarwt_stringify_atts( $image_wrap_attr ) . '>';
						$html .= $post_image;
						$html .= '</span>';
					}
				}
				
				// Text Icon ---------------------------------------
				
				if( $atts['icon_type'] == 'text' && $atts['icon_text'] ) {
					$html .= '<span class="icon-text">' . $atts['icon_text'] .'</span>';
				}
				
				// Html Icon ---------------------------------------
				
				if( $atts['icon_type'] == 'html' && $atts['icon_html'] ) {
					$html .= $atts['icon_html'];
				}
				
				$html .= '</span>';
			$html .= '</span>';
		}
		
		return $html;
	}
}

/**
* Get Data Button Classes Array
*/
if( !function_exists( 'killarwt_get_shortcodes_button_classes_array' ) ) {
	function killarwt_get_shortcodes_button_classes_array( $atts, $args = array() ) {
		
		if( !isset( $args['class'] ) ) $args['class'] = array();
		
		$args['class'][] = ( !in_array( $atts['button_style'], array( '', 'default' ) ) ) ? 'btn-' . $atts['button_style'] : '';
		$args['class'][] = ( !in_array( $atts['button_size'], array( '', 'default' ) ) ) ? 'btn-' . $atts['button_size'] : '';
		$args['class'][] = ( !in_array( $atts['button_rounded_cornors'], array( '', 'default', 'custom' ) ) ) ? 'btn-' . $atts['button_rounded_cornors'] : '';
		$args['class'][] = ( !in_array( $atts['button_font_size'], array( '', 'default' ) ) ) ? killarwt_font_size_class( 'button', $atts['button_font_size'] )  : '';
		$args['class'][] = ( !in_array( $atts['button_font_weight'], array( '', 'default' ) ) ) ? killarwt_get_font_weight_class( $atts['button_font_weight'] )  : '';
		$args['class'][] = ( !in_array( $atts['button_font_style'], array( '', 'default' ) ) ) ? 'fst-' . $atts['button_font_style'] : '';
		$args['class'][] = ( !in_array( $atts['button_text_transform'], array( '', 'default' ) ) ) ? 'text-' . $atts['button_text_transform'] : '';
		$args['class'][] = ( !in_array( $atts['button_color'], array( '', 'custom' ) ) && !in_array( $atts['button_style'], array( 'link', 'text' ) )  ) ? 'btn-' . $atts['button_color'] : 'btn-clr-custom';
		$args['class'][] = ( in_array( $atts['button_style'], array( 'link' ) ) ) ? 'text-' . $atts['button_color'] : '';
		$args['class'][] = ( !in_array( $atts['button_hover_color'], array( '', 'custom' ) ) ) ? $atts['button_hover_color'] . '-hover' : 'btn-hclr-custom';
		
		return $args;
	}
}

/**
* Get Shortcode Button Html
*/
if( !function_exists( 'killarwt_get_shortcodes_button_html' ) ) {
	function killarwt_get_shortcodes_button_html( $atts, $item = array(), $extra_attr = array() ) {
		
		$html = '';
		if( !empty( $item ) ) {
			$atts = array_merge( $atts, $item );
		}

		if ( !empty( $atts['button_link'] ) && empty($atts['link']) ) {
			$atts['link'] = $atts['button_link'];
		}
		
		if( !empty( $atts['button_text'] ) ) {
			$data_attr = array();
			$data_attr['class'] = array( 'kwt-button' );
			$data_attr['class'][] = ( in_array( $atts['button_style'], array( 'text' ) ) ) ? '' : 'btn'; 
			$data_attr['class'][] = ( !in_array( $atts['button_style'], array( '', 'default' ) ) ) ? 'btn-' . $atts['button_style'] : '';
			$data_attr['class'][] = ( !in_array( $atts['button_size'], array( '', 'default' ) ) ) ? 'btn-' . $atts['button_size'] : '';
			$data_attr['class'][] = ( !in_array( $atts['button_rounded_cornors'], array( '', 'default', 'custom' ) ) ) ? $atts['button_rounded_cornors'] : '';
			$data_attr['class'][] = ( !empty( $atts['button_font_size'] ) && !in_array( $atts['button_font_size'], array( '', 'default' ) ) ) ? killarwt_get_font_weight_class( $atts['button_font_weight'] ) : '';
			$data_attr['class'][] = ( !in_array( $atts['button_font_weight'], array( '', 'default' ) ) ) ? killarwt_get_font_weight_class( $atts['button_font_weight'] ) : '';
			$data_attr['class'][] = ( !in_array( $atts['button_font_style'], array( '', 'default' ) ) ) ? 'fst-' . $atts['button_font_style'] : '';
			$data_attr['class'][] = ( !in_array( $atts['button_text_transform'], array( '', 'default' ) ) ) ? 'text-' . $atts['button_text_transform'] : '';
			$data_attr['class'][] = ( in_array( $atts['button_style'], array( 'link' ) ) ) ? 'text-' . $atts['button_color'] : '';
			$data_attr['class'][] = ( !in_array( $atts['button_color'], array( '', 'custom' ) ) && !in_array( $atts['button_style'], array( 'link', 'text' ) )  ) ? 'btn-' . $atts['button_color'] : 'text-' . $atts['button_color'] ;
			$data_attr['class'][] = ( !in_array( $atts['button_hover_color'], array( '', 'custom' ) ) && !in_array( $atts['button_style'], array( 'link', 'text' ) )  ) ? 'btn-h' . $atts['button_hover_color'] : $atts['button_hover_color'] . '-hover';
			
			$data_attr = killarwt_get_shortcodes_icon_classes_array( $atts, $data_attr );
			$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'button_hor', $atts, 'hor' );
			$data_attr['class'] += killarwt_get_shortcodes_alignment_array( 'button_ver', $atts, 'ver' );
			
			if( !empty( $extra_attr['class'] ) ) {
				$data_attr['class'][] = killarwt_stringify_classes( $extra_attr['class'] );
			}
			if( !empty( $extra_attr ) ) {
				unset( $extra_attr['class'] );
				$data_attr = array_merge( $data_attr, $extra_attr );
			}
			
			if( !empty( $atts['link']['url'] ) ) {
				$data_attr = $data_attr + killarwt_get_url_data( $atts['link'] );
				if( !empty( $atts['link_popup'] ) ) $data_attr['data-fancybox'] = '';
				if( !empty( $atts['link_popup'] ) ) $data_attr['data-type'] = 'iframe';
			}

			$html .= ( ( !empty( $atts['link']['url'] ) || in_array( $atts['button_style'], array( 'link' ) ) ) ? '<a' : '<a' ) . ' ' .  killarwt_stringify_atts( $data_attr ) . '>';
			
			// Icon ---------------------------------------
			$html .= killarwt_get_shortcodes_icon_html( $atts );
			$html .= $atts['button_text'];
			$html .= ( ( !empty( $atts['link']['url'] ) || in_array( $atts['button_style'], array( 'link' ) ) ) ? '</a>' : '</a>' );
		}
		
		return $html;
	}
}

/**
 * Get Products Query
 */
function killarwt_products_query( $atts, $args = array() ) {


	// Query settings.
	$ordering_args = WC()->query->get_catalog_ordering_args($atts['orderby'], $atts['order']);
	
	$defaults = array(
		'post_type' 			=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts' 	=> 1,
		'paged'             	=> ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
		'orderby'             	=> ( isset($ordering_args['orderby'] ) ) ? $ordering_args['orderby'] : 'date',
		'order'             	=> ( isset($ordering_args['order'] ) ) ? $ordering_args['order'] : 'DESC',
		'posts_per_page' 		=> ( isset( $atts['limit'] ) ) ? $atts['limit'] : 6,
		'meta_query' 			=> WC()->query->get_meta_query(),
		'tax_query'             => WC()->query->get_tax_query(),
	);

	if( $defaults['orderby'] == 'price' ) {
		$defaults['orderby'] = 'meta_value_num';
		$defaults['meta_key'] = '_price';
	}
	
	$args = wp_parse_args( $args, $defaults );
	
	switch ( $atts['data_source'] ) {
		case 'sale_products':
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			break;
		case 'featured_products':
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'featured' ),
					'operator' => 'IN',
				),
			);
			break;
		case 'top_rated_products':
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'best_selling_products';
			$args['meta_key'] = 'total_sales';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'products_ids';
			if ( !empty( $atts['include'] ) && is_array( $atts['include'] ) ) {
				$args['post__in'] = $atts['include'];
			} else if( !empty($atts['include'] ) ) {
				$args['post__in'] = array_map('trim', explode(',', $atts['include']));
			}
			break;
	}
	
	// Exclude products
	if ( !empty( $atts['exclude'] ) ) {
		$args['post__not_in'] = array_map('trim', explode(',', $atts['exclude'] ) );
	}
	
	// Filter categories
	if ( ! empty( $atts['categories'] ) ) {
		$taxonomy_names = get_object_taxonomies( 'product' );
		$taxonomy_names = 'product_cat';
		$terms = get_terms( $taxonomy_names, array(
			'orderby' => 'name',
			'include' => $atts['categories'],
			'hide_empty' => false,
		));
		
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			if ( $atts['data_source'] == 'featured_products' ) $args['tax_query'] = array( 'relation' => 'AND' );

			$relation = $query_type ? $query_type : 'OR';
			if ( count( $terms ) > 1 ) $args['tax_query']['categories'] = array( 'relation' => $relation );

			foreach ( $terms as $term ) {
				$args['tax_query']['categories'][] = array(
					'taxonomy' => $term->taxonomy,
					'field' => 'slug',
					'terms' => array( $term->slug ),
					'include_children' => true,
					'operator' => 'IN'
				);
			}
		}
	}
	//print_r($atts);
	//print_r($args);
	return $args;
}