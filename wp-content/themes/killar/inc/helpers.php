<?php
/**
 * Helpers
 *
 * @package KillarWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! function_exists( 'killarwt_is_woocommerce_activated' ) ) {
	function killarwt_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

if( ! function_exists( 'killarwt_is_blog_archive' ) ) {
	function killarwt_is_blog_archive() {
		return ( is_home() || is_search() || is_tag() || is_archive() || is_category() || is_date() || is_author() );
	}
}

/**
 * Check is catalog
 */
if ( ! function_exists( 'killarwt_is_catalog' ) ) {
	function killarwt_is_catalog() {

		if ( killarwt_is_woo_shop() || ( function_exists( 'is_product_category' ) && is_product_category() ) || ( function_exists( 'is_product_tag' ) && is_product_tag() ) || is_tax( 'product_brand' ) ) {
			return true;
		}
	
		return false;
	}
}

 /**
 * Check is WooCommerce shop page.
 */
if ( ! function_exists( 'killarwt_is_woo_shop' ) ) {

	function killarwt_is_woo_shop() {
		if ( ! KILLARWT_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			return true;
		}
	}
}

/**
 * Check is WooCommerce product page.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'killarwt_is_woo_single_prod' ) ) {

	function killarwt_is_woo_single_prod() {
		if ( ! KILLARWT_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( is_woocommerce() && is_singular( 'product' ) ) {
			return true;
		}
	}
}

/*-----------------------------------------------
 * General
 *----------------------------------------------*/

if ( ! function_exists( 'killarwt_get_post_meta' ) ) {

	function killarwt_get_post_meta( $meta ) {
		
		if ( empty( $meta ) ) return;
		
		$prefix = KILLARWT_PREFIX;
		$post_meta = get_post_meta( killarwt_post_id(), $prefix.$meta, true );
		$post_meta = ( empty( $post_meta ) && $post_meta != false  ) ? '' : $post_meta;
		
		return apply_filters( 'killar_get_post_meta', $post_meta );
	}
}

if ( ! function_exists( 'killarwt_check_not_def_empty' ) ) {

	function killarwt_is_not_def_empty( $value ) {
		
		if ( $value != '' && $value != 'default' ) {
			return true;
		}
		return false;
	}
}

/**
 * Minify CSS
 */
if ( ! function_exists( 'killarwt_minify_css' ) ) {

	function killarwt_minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) return;

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		return $css;
		
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
if ( ! function_exists( 'killarwt_do_shortcode' ) ) {
	
	function killarwt_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		$content = call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
		
		// Replace {{Y}} or {Y} with the current year
		$content = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $content );
		
		return $content;
	}
}
 
/**
 * Container Width
 */
if ( ! function_exists( 'killarwt_container_width' ) ) {

	function killarwt_container_width() {
		
		$layout = killarwt_main_layout_style();
		$width = get_theme_mod( 'killar_container_width', '1320' );
		
		if( $layout == 'boxed' ) {
			$width = get_theme_mod( 'killar_boxed_layout_width', '1200' );
		}
		
		$width = ($width) ? $width : 1200;

		return apply_filters( 'killar_container_width', $width );
	}
}

if ( ! function_exists( 'killarwt_get_image_html' ) ) {

	function killarwt_get_image_html( $params = array() ) {
		$params = array_merge( array(
			'post_id' => null,
			'attach_id' => null,
			'alt' => null,
			'title' => null,
			'size' => 'thumbnail',
			'class' => '',
			'atts' => false
		), $params );

		if ( ! $params['size'] ) {
			$params['size'] = 'thumbnail';
		}

		if ( ! $params['attach_id'] && ! $params['post_id'] ) {
			return false;
		}

		$post_id = $params['post_id'];

		$attach_id = $post_id ? get_post_thumbnail_id( $post_id ) : $params['attach_id'];
		$attach_id = apply_filters( 'killar_object_id', $attach_id );
		$size = $params['size'];
		$thumb_class = ( isset( $params['class'] ) && '' !== $params['class'] ) ? $params['class'] . ' ' : '';

		global $_wp_additional_image_sizes;
		$html = '';

		$sizes = array(
			'thumbnail',
			'thumb',
			'medium',
			'large',
			'full',
		);
		
		if ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, $sizes, true ) ) ) {
			$attributes = array( 'class' => $thumb_class . 'attachment-' . $size );
			if ( !empty( $params['alt'] ) ) { $attributes['alt'] = $params['alt'];}
			if ( !empty( $params['title'] ) ) {	$attributes['title'] = $params['title']; }
			if ( !empty( $params['atts'] ) ) { $attributes = array_merge( $attributes, $params['atts'] ); }
			//$attributes = killarwt_stringify_atts( $attributes );
			$html = wp_get_attachment_image( $attach_id, $size, false, $attributes );
		} elseif ( $attach_id ) {
			if ( is_string( $size ) ) {
				preg_match_all( '/\d+/', $size, $thumb_matches );
				if ( isset( $thumb_matches[0] ) ) {
					$size = array();
					$count = count( $thumb_matches[0] );
					if ( $count > 1 ) {
						$size[] = $thumb_matches[0][0]; // width
						$size[] = $thumb_matches[0][1]; // height
					} elseif ( 1 === $count ) {
						$size[] = $thumb_matches[0][0]; // width
						$size[] = $thumb_matches[0][0]; // height
					} else {
						$size = false;
					}
				}
			}
			if ( is_array( $size ) ) {
				// Resize image to custom size
				$p_img = killarwt_resize( $attach_id, null, $size[0], $size[1], true );
				$alt = trim( wp_strip_all_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
				$attachment = get_post( $attach_id );
				if ( ! empty( $attachment ) ) {
					$title = trim( wp_strip_all_tags( $attachment->post_title ) );

					if ( empty( $alt ) ) {
						$alt = trim( wp_strip_all_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
					}

					if ( empty( $alt ) ) {
						$alt = $title;
					}

					if ( ! $params['alt'] ) {
						$alt = $params['alt'];
					}

					if ( ! $params['title'] ) {
						$title = $params['title'];
					}

					if ( $p_img ) {
						$attributes = array(
							'class' => $thumb_class,
							'src' => $p_img['url'],
							'width' => $p_img['width'],
							'height' => $p_img['height'],
							'alt' => $alt,
							'title' => $title,
						);
						if ( !empty( $params['atts'] ) ) {
							$attributes = array_merge( $attributes, $params['atts'] );
						}
						$attributes = killarwt_stringify_atts( $attributes );
						$html = '<img ' . $attributes . ' />';
					}
				}
			}
		}

		return apply_filters( 'killarwt_get_image_html', $html );
	}

}

/*
* Resize images dynamically using wp built in functions
* Victor Teixeira
*/
if ( ! function_exists( 'killarwt_resize' ) ) {

	function killarwt_resize( $attach_id, $img_url, $width, $height, $crop = false ) {
		// this is an attachment, so we have the ID
		$image_src = array();
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} elseif ( $img_url ) {
			$file_path = wp_parse_url( $img_url );
			$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
			$orig_size = getimagesize( $actual_file_path );
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		if ( ! empty( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $width,
						'height' => $height,
					);

					return $vt_image;
				}

				if ( ! $crop ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array(
							'url' => $resized_img_url,
							'width' => $proportional_size[0],
							'height' => $proportional_size[1],
						);

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}
				if ( ! is_string( $new_img_path ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output
				$vt_image = array(
					'url' => $new_img,
					'width' => $new_img_size[0],
					'height' => $new_img_size[1],
				);

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array(
				'url' => $image_src[0],
				'width' => $image_src[1],
				'height' => $image_src[2],
			);

			return $vt_image;
		}

		return false;
	}
}

/**
 * Get the placeholder image URL either from media, or use the fallback image.
 *
 * @param string $size Thumbnail size to use.
 * @return string
 */
if ( ! function_exists( 'killarwt_placeholder_img_src' ) ) {
	
	function killarwt_placeholder_img_src( $size = 'thumbnail', $src = '' ) {
		$src = ( empty( !$src ) ) ? $src : KILLARWT_CORE_URL . 'assets/images/placeholder.png';
		$placeholder_image = get_option( 'killarwt_placeholder_image', 0 );

		if ( ! empty( $placeholder_image ) ) {
			if ( is_numeric( $placeholder_image ) ) {
				$image = wp_get_attachment_image_src( $placeholder_image, $size );

				if ( ! empty( $image[0] ) ) {
					$src = $image[0];
				}
			} else {
				$src = $placeholder_image;
			}
		}

		return apply_filters( 'killarwt_placeholder_img_src', $src );
	}
}

/**
 * Default color picker palettes
 */
if ( ! function_exists( 'killarwt_default_color_palettes' ) ) {

	function killarwt_default_color_palettes() {

		$palettes = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		// Apply filters and return
		return apply_filters( 'killar_default_color_palettes', $palettes );
	}
}

/**
 * Get current url
 */
if ( ! function_exists( 'killarwt_get_current_url' ) ) {
	function killarwt_get_current_url() {
		return esc_url( add_query_arg( NULL, NULL ) );
	}
}

/**
 * Get Main Layout
 */
if ( ! function_exists( 'killarwt_main_layout_style' ) ) {
	function killarwt_main_layout_style() {
		return get_theme_mod( 'killar_main_layout_style', 'wide' );
	}
}
 
/**
 * Adds classes to the body tag
 */
if ( ! function_exists( 'killarwt_body_classes' ) ) {
	
	function killarwt_body_classes( $classes ) {

		$post_layout  = killarwt_get_layout();
		$main_layout_style = killarwt_main_layout_style();

		// RTL
		if ( is_rtl() ) {
			$classes[] = 'rtl';
		}
		
		// Main class
		$classes[] = 'killarwt-theme';

		// Boxed layout
		if ( $main_layout_style == 'boxed' ) {
			$classes[] = 'boxed-layout';
		}

		// Predefine layout
		if ( $main_layout_style == 'predefine' ) {
			$classes[] = 'predefine-layout';
		}

		// If separate style nad blog page
		if ( $main_layout_style == 'predefine'
			&& ( is_home()
				|| is_category()
				|| is_tag()
				|| is_date()
				|| is_author() ) ) {
			$classes[] = 'predefine-blg';
		}

		// Sidebar enabled
		if ( in_array( $post_layout, array('left-sidebar', 'right-sidebar', 'both-sidebar')) ) {
			$classes[] = 'has-sidebar';
		}

		// Content layout
		if ( $post_layout ) {
			$classes[] = 'content-'. $post_layout;
		}

		if ( is_page( 'my-account' ) ) {
			$classes[] = 'gray-simple';
		}

		return $classes;

	}
	add_filter( 'body_class', 'killarwt_body_classes' );
}

/**
 * Retrun post id
 */
if ( ! function_exists( 'killarwt_post_id' ) ) {

	function killarwt_post_id() {

		$id = '';

		if ( is_singular() ) {
			$id = get_the_ID();
		} else if ( KILLARWT_WOOCOMMERCE_ACTIVE && is_shop() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( isset( $shop_id ) ) {
				$id = $shop_id;
			}
		} else if ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			$id = $page_for_posts;
		} else {
			$id = get_the_ID();
		}

		$id = apply_filters( 'killar_post_id', $id );

		$id = $id ? $id : '';

		return $id;

	}
}

if ( ! function_exists( 'killarwt_cols_class' ) ) {
	
	function killarwt_cols_class( $d, $num ) {
		if($num==''){ return '';}
		$numcol=12/$num;
		$class='';
		if (in_array($num,array(1,2,3,4,6))) {
			$class='col-'.$d.'-'.$numcol;
		} else if ($num==8) {
			$class='col-'.$d.'-wt-8';
		} else if ($num==7) {
			$class='col-'.$d.'-wt-7';
		} else if ($num==5) {
			$class='col-'.$d.'-wt-5';
		}
		
		$class = str_replace('xs-', '', $class);
		
		return $class;
	}
}

/**
 * Get Unique ID
 */
if ( ! function_exists( 'killarwt_uniqid' ) ) :
	function killarwt_uniqid( $prefix = '' ) {		
		return $prefix.uniqid();
	}
endif;

/**
 * Convert array of named params to string version
 * All values will be escaped
 *
 * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
 *
 * @param $attributes
 *
 * @return string
 */
if ( ! function_exists( 'killarwt_stringify_atts' ) ) {

	function killarwt_stringify_atts( $attributes ) {

		if ( !empty( $attributes ) ) { 
			$atts = array();
			
			foreach ( $attributes as $name => $value ) {
				if ( !empty( $name ) ) {
					$value = ( is_array( $value ) ) ? killarwt_stringify_classes(  array_filter( $value ) ) : $value;
					$atts[] = $name . '="' . esc_attr( $value ) . '"';
				}
			}

			return implode( ' ', $atts );
		}
		return;
	}

}

/**
 * Convert array of classes to string
 */
if ( ! function_exists( 'killarwt_stringify_classes' ) ) {

	function killarwt_stringify_classes( $classes ) {
		
		if ( is_array($classes) ) {
			$classes = array_unique( $classes );
			$classes = esc_attr( trim( implode( ' ', $classes ) ) );
		}

		return $classes;
	}
}

/**
 * Parse CSS
 */
if ( ! function_exists( 'killarwt_output_css' ) ) {

	/**
	 * Parse CSS
	 *
	 * Recursive function that generates from a a multidimensional array of CSS rules, a valid CSS string.
	 *
	 * @param array $rules
     *   An array of CSS rules in the form of:
	 *   array('selector'=>array('property' => 'value')). Also supports selector
	 *   nesting, e.g.,
	 *   array('selector' => array('selector'=>array('property' => 'value'))).
	 */
	function killarwt_output_css( $output_ar = array(), $min_width = '',  $max_width = '', $type = 'external') {
		$css_output = $media_output = '';
		$indent = 0;
		$prefix = str_repeat('', $indent);
		if ( !empty( $output_ar ) ) {
			foreach ($output_ar as $key => $value) {
				if ( is_array( $value ) ) {
					$selector = $key;
					if( !empty( $value ) ) {
						$properties = array_filter( $value );
						if ( !empty( $properties ) ) {
							$css_output .= $prefix . "$selector {";
							$css_output .= $prefix . killarwt_output_css($properties);
							$css_output .= $prefix . "}";
						}
					}
				} else {
					$property = $key;
					if ( $property != '' ) {
						$css_output .= $prefix . "$property: $value;";
					}
				}
			}

			if ( $css_output != '' && ( $min_width != '' || $max_width != '' ) ) {
				$media_output .= '@media';
				$media_output .= ( $min_width != '' ) ? '(min-width:' . $min_width . 'px)' : '';
				$media_output .= ( $min_width != '' && $max_width != '') ? ' and ' : '';
				$media_output .= ( $max_width != '' ) ? '(max-width:' . $max_width . 'px)' : '';
				$media_output .= '{' . $css_output . '}';
			} else {
				$media_output = $css_output;
			}
	
		}
	
		return $media_output;
	}
}

/**
 * Inline Parse CSS
 */
if ( ! function_exists( 'killarwt_inline_output_css' ) ) {

	/**
	 * Parse CSS
	 *
	 * Recursive function that generates from a a multidimensional array of CSS rules, a valid CSS string.
	 *
	 * @param array $rules
     *   An array of CSS rules in the form of:
	 *   array('selector'=>array('property' => 'value')). Also supports selector
	 *   nesting, e.g.,
	 *   array('selector' => array('selector'=>array('property' => 'value'))).
	 */
	function killarwt_inline_output_css( $output_ar = array() ) {
		$css_output = '';
		$indent = 0;
		$prefix = str_repeat('', $indent);
		if ( !empty( $output_ar ) ) {
			foreach ($output_ar as $key => $value) {
				$property = $key;
				if ( $property != '' ) {
					$css_output .= $prefix . "$property: $value;";
				}
			}
		}

		return $css_output;
	}
}

/**
 * Get Killar Templates
 */
if ( ! function_exists( 'killarwt_get_template' ) ) { 
	
	function killarwt_get_template( $templates, $args = array() ) {
		
		if( strpos( $templates, '.php' ) === false) {
			$templates = "{$templates}.php";
		}
		
		//Located files
		$located = locate_template( $templates, false );
		
		//Filter get template
		$located = apply_filters( 'killar_get_template', $located, $templates, $args);
		
		if ( !file_exists ( $located ) ) {
			echo sprintf( '%s does not exist.', '<code>' . $located . '</code>' );
			return;
		}
		
		//Filter arguments
		$args = apply_filters( "killar_get_template-{$templates}", $args );
		
		if ( !empty( $args ) ) {
			extract( $args );
		}
		
		do_action( "killar_before_get_template", $located, $templates, $args );
		
		include_once $located;
		
		do_action( "killar_after_get_template", $located, $templates, $args );
	}
}

if ( ! function_exists( 'killarwt_elementor_render_icon' ) ) {

	function killarwt_elementor_render_icon( $icon, $attributes = [], $tag = 'i' ) {
		ob_start();
		\Elementor\Plugin::instance()->icons_manager->render_icon( $icon, $attributes, $tag );
		return ob_get_clean();
	}
}

/**
 * Numbered Pagination
 */
if ( ! function_exists( 'killarwt_pagination') ) {

	function killarwt_pagination( $query = '', $echo = true ) {
		
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set vars
		$total  = $query->max_num_pages;
		$big    = 999999999;

		// Display pagination if total var is greater then 1 ( current query is paginated )
		if ( $total > 1 ) {

			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}
			
			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$format = 'page/%#%/';
				} else {
					$format = '/%#%/';
				}
			} else {
				$format = '&paged=%#%';
			}

			$args = apply_filters( 'killar_pagination_args', array(
				'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'format'    => $format,
				'current'   => max( 1, $current_page ),
				'total'     => $total,
				'mid_size'  => 3,
				'type'      => 'list',
				'prev_text'    => '<i class="fas fa-angle-left"></i>',
				'next_text'    => '<i class="fas fa-angle-right"></i>',
			) );

			// Output pagination
			if ( $echo ) {
				echo '<div class="kwt-pagination pagination icon-20">'. wp_kses_post( paginate_links( $args ) ) .'</div>';
			} else {
				return '<div class="kwt-pagination pagination icon-20">'. wp_kses_post( paginate_links( $args ) ) .'</div>';
			}
		}
	}
}

/**
 * Translation support
 */
if ( ! function_exists( 'killarwt_tm_translation' ) ) {

	function killarwt_tm_translation( $id, $val = '' ) {

		// Translate theme mod val
		if ( $val ) {

			// Polylang Translation
			if ( function_exists( 'pll__' ) && $id ) {
				$val = pll__( $val );
			}

			// Return the value
			return $val;

		}
	}
}

if ( ! function_exists( 'killarwt_bool_text' ) ) {

	function killarwt_bool_text( $val = '' ) {
		return ( !empty( $val ) && ( $val == 'yes' || $val == true ) ) ? 'true' : 'false';
	}
}

/**
 * Infinite Scroll Pagination
 */
if ( ! function_exists( 'killarwt_infinite_scroll' ) ) {

	function killarwt_infinite_scroll( $args = array() ) {

		// Load infinite scroll script
		wp_enqueue_script( 'infinite-scroll' );

		// Error text
		$error = esc_html__( 'No more pages to load', 'killar' );
		
		$prev_posts = get_previous_posts_link( '<span aria-hidden="true">&larr;</span> '. esc_html__( 'Prev Posts', 'killar' ) );
		$next_posts = get_next_posts_link( esc_html__( 'Next Posts', 'killar' ) .' <span aria-hidden="true">&rarr;</span>' );
		
		// Output pagination HTML
		$output = '';
		$output .= '<div class="kwt-pagination pagination icon-20 '.( empty( $next_posts ) ? 'last-posts' : 'next-posts' ).'">';
			$output .= '<div class="infinite-pagination" data-style="'.$args['style'].'" data-item-selector="'.$args['item-selector'].'">';
				$output .= '<div class="loader-ellips infinite-scroll-request wt-loading mb-3"><i class="fas fa-spinner fa-pulse theme-color fa-2x"></i></div>';
				$output .= '<p class="infinite-scroll-last">'. $args['last'] .'</p>';
				$output .= '<p class="infinite-scroll-error">'. $error .'</p>';
				$output .= '<div class="infinite-scroll-nav">';
					$output .= '<div class="prev-posts">'. $prev_posts .'</div>';
					$output .= '<div class="next-posts">'. $next_posts .'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		// Load More
		if ( !empty( $next_posts ) && $args['style'] == 'load-more' ) {

			$output .= '<div class="load-more-nav text-center">';
				$output .= '<button class="button button2 load-more-button">' . $args['load_more'] . '</button>';
			$output .= '</div>';
			
		}

		echo wp_kses_post( $output );
	}
}

/**
 * Loop attributes
 */
if ( ! function_exists( 'killarwt_loop_atts' ) ) {

	function killarwt_loop_atts( $atts = array() ) {
		
		$l_atts = array();
		$view_type = ( !empty( $atts['view_type'] ) ) ? $atts['view_type'] : '';
		if ( !empty( $atts['items_col_xxl'] ) ) $l_atts['data-items'] = $atts['items_col_xxl'];
		if ( !empty( $atts['items_col_xxl'] ) ) $l_atts['data-items-xxl'] = $atts['items_col_xxl'];
		if ( !empty( $atts['items_col_xl'] ) ) $l_atts['data-items-xl'] = $atts['items_col_xl'];
		if ( !empty( $atts['items_col_lg'] ) ) $l_atts['data-items-lg'] = $atts['items_col_lg'];
		if ( !empty( $atts['items_col_md'] ) ) $l_atts['data-items-md'] = $atts['items_col_md'];
		if ( !empty( $atts['items_col_sm'] ) ) $l_atts['data-items-sm'] = $atts['items_col_sm'];
		if ( !empty( $atts['items_col_xs'] ) ) $l_atts['data-items-xs'] = $atts['items_col_xs'];
		if ( !empty( $atts['items_col_xxs'] ) ) $l_atts['data-items-xxs'] = $atts['items_col_xxs'];
		
		if ( in_array( $view_type, array( 'slider', 'micro_slider', 'carousel', 'micro_carousel' ) ) ) {
			if ( isset( $atts['carousel_nav'] ) ) $l_atts['data-nav'] = (bool)$atts['carousel_nav'];
			if ( isset( $atts['carousel_infinite'] ) ) $l_atts['data-infinite'] = (bool)$atts['carousel_infinite'];
			if ( isset( $atts['carousel_dots'] ) ) $l_atts['data-dots'] = (bool)$atts['carousel_dots'];					
			if ( isset( $atts['carousel_speed'] ) ) $l_atts['data-speed'] = $atts['carousel_speed'];					
			if ( isset( $atts['carousel_autoplay'] ) ) $l_atts['data-autoplay'] = (bool)$atts['carousel_autoplay'];	
			if ( isset( $atts['carousel_autoplay_speed'] ) ) $l_atts['data-autoplay-speed'] = $atts['carousel_autoplay_speed'];	
			if ( isset( $atts['carousel_center_mode'] ) ) $l_atts['data-center-mode'] = (bool)$atts['carousel_center_mode'];	
			if ( isset( $atts['carousel_variable_width'] ) ) $l_atts['data-variable-width'] = (bool)$atts['carousel_variable_width'];	
			if ( isset( $atts['carousel_variable_width_tablet'] ) ) $l_atts['data-variable-width-tablet'] = (bool)$atts['carousel_variable_width_tablet'];	
			if ( isset( $atts['carousel_variable_width_mobile'] ) ) $l_atts['data-variable-width-mobile'] = (bool)$atts['carousel_variable_width_mobile'];	
			if ( isset( $atts['carousel_adaptive_height'] ) ) $l_atts['data-adaptive-height'] = (bool)$atts['carousel_adaptive_height'];	
			if ( isset( $atts['carousel_as_nav_for'] ) ) $l_atts['data-as-nav-for'] = $atts['carousel_as_nav_for'];	
		}
		
		return $l_atts;
	}
}

if ( ! function_exists( 'killarwt_get_nav_classes' ) ) {
	function killarwt_get_nav_classes( $atts = array() ) {
		$classes = array();
		if ( !empty( $atts['carousel_nav'] ) ) {
			$classes[] = ( !empty( $atts['carousel_nav_style'] ) ) ? 'owl-nav-'.$atts['carousel_nav_style'] : '';
			$classes[] = ( !empty( $atts['carousel_nav_position'] ) && $atts['carousel_nav_position'] == 'title-right' ) ? 'owl-nav-title-right owl-nav-small' : 'nav-slider-middle';	
		}
		return $classes;
	}
}

/*-----------------------------------------------
 * Page Layouts
 *----------------------------------------------*/

if ( ! function_exists( 'killarwt_get_layout' ) ) {

	function killarwt_get_layout() {
		
		$layout = get_theme_mod( 'killar_blog_loop_post_page_layout', 'right-sidebar' );
		$sidebar = killarwt_get_sidebar_name();
		
		$pm_layout = killarwt_get_post_meta( 'page_layout' );
		if ( killarwt_is_not_def_empty( $pm_layout ) ) {
			$layout = $pm_layout;
		} else if ( killarwt_is_portfolio_archive() ) {
			$layout = get_theme_mod( 'killar_portfolio_loop_post_page_layout', 'full-width' );
		} else if ( is_singular( 'portfolio' ) ) {
			$layout = get_theme_mod( 'killar_portfolio_single_post_page_layout', 'right-sidebar' );
		} else if ( killarwt_is_catalog() ) {
			$layout = get_theme_mod( 'killar_woo_archive_layout', 'left-sidebar' );
		} else if ( killarwt_is_woo_single_prod() ) {
			$layout = get_theme_mod( 'killar_woo_single_prod_layout', 'full-width' );
		} else if ( is_singular( 'post' ) ) {
			$layout = get_theme_mod( 'killar_blog_single_post_page_layout', 'right-sidebar' );
	 	} else if ( is_page() ) {
			$layout = get_theme_mod( 'killar_page_layout', 'full-width' );
		}

		$layout = ( !empty( $layout ) && !empty( $sidebar ) ) ? $layout : 'full-width';

		return apply_filters( 'killar_post_page_layout', $layout );
	}
}

if ( !function_exists( 'killarwt_is_woo_layout' ) ) {
	function killarwt_is_woo_layout() {
		return ( killarwt_is_catalog() || killarwt_is_woo_single_prod()  ) ? true : false;
	}
}

if ( ! function_exists( 'killarwt_primary_columns' ) ) {

	function killarwt_primary_columns( $classes = '' ) {

		$post_layout = killarwt_get_layout();

		$classes = array();

		if ( $post_layout == 'full-width' ) {
			$classes = array( 'col-12 aside' );
		} else {
			$classes = array( ( !empty( killarwt_is_woo_layout() ) ) ? 'col-xl-9 col-lg-9 aside' : 'col-12 col-lg-8 col-xl-8 aside' );
		}
		
		return apply_filters( 'killar_primary_columns', $classes );
	}
}


if ( ! function_exists( 'killarwt_sidebar_columns' ) ) {

	function killarwt_sidebar_columns( $classes = '' ) {

		$post_layout = killarwt_get_layout();

		$classes = array( ( !empty( killarwt_is_woo_layout() ) ) ? 'col-xl-3 col-lg-3' : 'col-xl-3 col-lg-4 col-md-12 col-xl-offset-1' );

		if ( $post_layout == 'left-sidebar' ) {
			$classes[] = 'aside--left';
		} else if ( $post_layout == 'right-sidebar' ) {
			$classes[] = 'aside--right';
		}

		return apply_filters( 'killar_sidebar_columns', $classes );
	}
}

/**
 * Start Wrapper
 * Wraps all content in wrappers which match the theme markup
 */
function killarwt_start_wrapper() {
	get_template_part( 'template-parts/start-wrapper' );
}

/**
 * End Wrapper
 * Closes the wrapping divs
 */
function killarwt_end_wrapper() {
	get_template_part( 'template-parts/end-wrapper' );
}

/**
 * End Content Wrapper
 * Closes the wrapping divs
 */
function killarwt_before_body_end() {
	get_template_part( 'template-parts/before-body-end' );
}

/**
 * Display Topbar
 */
if ( ! function_exists( 'killarwt_display_topbar' ) ) {
	
	function killarwt_display_topbar() {
		
		$pm_topbar = killarwt_get_post_meta( 'topbar' );
		if ( killarwt_is_not_def_empty( $pm_topbar ) ) {
			$return = $pm_topbar; 
		} else {
			$return = get_theme_mod( 'killar_topbar', false );	
		}
		$return = ( !$return ) ? false : true;
		return apply_filters( 'killar_display_topbar', $return );
		
	}
}

/*-----------------------------------------------
 * Top Bar
 *----------------------------------------------*/
 
if ( ! function_exists( 'killarwt_preloader' ) ) {
	
	function killarwt_preloader() {
		
		$status = get_theme_mod( 'killar_general_preloader', false );
		if( $status == false ) return;
		
		$html = '<div id="loader-wrapper">';
		$type = get_theme_mod( 'killar_general_preloader_type', 'predefine' );
		$loader_img = get_theme_mod( 'killar_general_preloader_custom_bg_image' );
		if( $type == 'custom' && !empty( $loader_img ) ) {
			$html .= '<div id="custom-loader">' . '<img src="' . $loader_img . '" />' . '</div>';
		} else {
			$html .= '<div id="preloader">
						<div class="preloader"><span></span><span></span></div>
					</div>';
		}
		
		$html .= '</div>';
		
		echo apply_filters( 'killar_preloader', $html );
	}
	
	add_action( 'killar_before_site', 'killarwt_preloader' );
}

/**
 * Display top bar templates
 */
if ( ! function_exists( 'killarwt_topbar_template' ) ) {

	function killarwt_topbar_template() {

		// Return if no top bar
		if ( !killarwt_display_topbar() ) {
			return;
		}

		get_template_part( 'template-parts/topbar/layout' );
	}

	add_action( 'killar_topbar', 'killarwt_topbar_template' );
}

/**
 * Top Bar Store Info
 */
if ( ! function_exists( 'killarwt_topbar_store_info' ) ) {

	function killarwt_topbar_store_info() {
		return apply_filters( 'killar_topbar_store_info', array(
			'phone' => array(
				'label' => esc_html__( 'Contact Number', 'killar' ),
				'icon_class' => 'fas fa-phone-alt',
			),
			'time' => array(
				'label' => esc_html__( 'Time', 'killar' ),
				'icon_class' => 'fas fa-alarm-clock',
			),
		) );
	}
}


/**
 * Display top bar social
 */
if ( ! function_exists( 'killarwt_display_topbar_social' ) ) {
	
	function killarwt_display_topbar_social() {
	
		$return = ( get_theme_mod( 'killar_topbar_social', true ) != true ) ? false : true;
		
		return apply_filters( 'killar_display_topbar_social', $return );
	}
}

/**
 * Topbar Social Links
 */
if ( ! function_exists( 'killarwt_topbar_social_links' ) ) {
	
	function killarwt_topbar_social_links() {
		
		return apply_filters( 'killar_topbar_social_links', get_theme_mod( 'killar_topbar_social_links') );
	}
}


/*-----------------------------------------------
 * Header
 *----------------------------------------------*/

/**
 * Header Style
 */
if ( ! function_exists( 'killarwt_header_style_list' ) ) {

	function killarwt_header_style_list() {

		return apply_filters( 'killar_header_style_list', array(
					'header_v1' 		=> __( 'Header - v1 ( Default Menu )', 'killar' ),
					'header_v2' 		=> __( 'Header - v2 ( White Menu )', 'killar' ),
					'hidden' 			=> __( 'Hidden', 'killar' ),
				) );
	}
}

/**
 * Header Style
 */
if ( ! function_exists( 'killarwt_header_style' ) ) {

	function killarwt_header_style() {
		
		$pm_style = killarwt_get_post_meta( 'header_style' );
		if ( killarwt_is_not_def_empty( $pm_style ) ) {
			$style = $pm_style;
		} else {
			$style = get_theme_mod( 'killar_header_style', 'header_v1' );	
		}
		$style = ($style) ? $style : 'header_v1';

		return apply_filters( 'killar_header_style', $style );
	}
}

/**
 * Header Classes Filter
 */
if ( ! function_exists( 'killarwt_header_classes' ) ) {

	function killarwt_header_classes( $classes ) {

		if ( is_array( $classes ) ) {
			
			$is_sticky = get_theme_mod( 'killar_header_sticky', false );
			$classes[] = ( killarwt_mob_header_search_style() == 'fixed' ) ? 'fixed-mob-header-search' : '';
			$classes[] = ( killarwt_transparent_header() == true ) ? 'header-transparent' : '';
			$classes[] = ( $is_sticky == false ) ? 'no-sticky' : '';
		}
		
		$classes[] = 'header-search';

		return $classes;
	}
	
	add_filter( 'killar_header_classes', 'killarwt_header_classes' );
}

/**
 * Header template
 */
if ( ! function_exists( 'killarwt_header_template' ) ) {

	function killarwt_header_template() {
		
		$header_style = killarwt_header_style();
		if ( $header_style == 'hidden' ) return;
		
		$args = array();
		$args['classes'] = array('header-wrapper');
		$args['classes'][] = str_replace( '_', '-', $header_style );
		$args['classes'][] = 'header-search';

		killarwt_get_template( 'template-parts/header/'.$header_style , $args );
		
	}
	add_action( 'killar_header', 'killarwt_header_template' );
}

/**
 * Header Logo
 */
if ( ! function_exists( 'killarwt_header_logo' ) ){
	
	function killarwt_header_logo() {

		$main_logo_src = '';
		$sticky_logo_src = apply_filters ( 'killar_header_sticky_logo', get_theme_mod( 'killar_header_sticky_logo' ) );
		$mob_logo_src = apply_filters ( 'killar_mob_header_logo', get_theme_mod( 'killar_mob_header_logo' ) );
		$logo_width	= get_theme_mod( 'killar_header_logo_width', '150' );
		$site_title = get_bloginfo( 'name', 'display' );

		$html = '';
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$main_logo_src = get_theme_mod( 'custom_logo' );
			$main_logo_class = ( !empty( $sticky_logo_src ) && $main_logo_src != $sticky_logo_src ) ? 'static-logo' : '';
			$main_logo_class .= ( empty( $mob_logo_src ) ) ? ' mob-logo' : '';
			$logo = get_custom_logo();
			$html .= '<div class="nav-brand '. $main_logo_class .'">' . wp_kses_post( $logo ) . '</div>';
		} else {
			$main_logo_src = apply_filters( 'killar_header_main_logo', get_theme_mod( 'killar_header_main_logo', KILLARWT_IMAGES_DIR_URI . 'logo.png' ) );
			$main_logo_class = ( !empty( $sticky_logo_src ) && $main_logo_src != $sticky_logo_src ) ? 'static-logo' : '';
			$main_logo_class .= ( empty( $mob_logo_src ) ) ? ' mob-logo' : '';
			$html .= '<a class="nav-brand '. $main_logo_class .'" href="'.esc_url( home_url( '/' ) ).'"><img src="'.esc_url( $main_logo_src ).'" alt="' . esc_attr( $site_title ) . '" width="'. esc_attr( $logo_width ) .'" /></a>';
		}

		// Sticky Logo
		if ( !empty( $sticky_logo_src ) && $sticky_logo_src != $main_logo_src ) {
			$html .= '<a class="nav-brand fixed-logo" href="'.esc_url( home_url( '/' ) ).'" rel="home"><img src="'.esc_url( $sticky_logo_src ).'" alt="' . esc_attr( $site_title ) . '" width="'. esc_attr( $logo_width ) .'" /></a>';
		}

		// Mobile Logo
		if ( !empty( $mob_logo_src ) && $mob_logo_src != $main_logo_src ) {
			$mob_logo_width	= get_theme_mod( 'killar_header_logo_width', $logo_width );
			$html .= '<a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="nav-brand mob-logo d-block d-lg-none"><img src="'.esc_url( $mob_logo_src ).'" alt="' . esc_attr( $site_title ) . '" width="'. esc_attr( $mob_logo_width ) .'" /></a>';
		}

		$html .= '<a class="nav-toggle" href="#offcanvasMobileFlyout" data-bs-toggle="offcanvas" aria-controls="offcanvasMobileFlyout"></a>';
		
		echo apply_filters( 'killar_header_logo_html', $html );
	}
	add_action( 'killar_header_logo', 'killarwt_header_logo' );
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'killarwt_mob_header_navigation' ) ) {
	
	function killarwt_mob_header_navigation(){ ?>
	
		<nav id="mobile-menu" class="mobile-nav" role="navigation">
			<?php
			$ext_nav_list = '';
			if ( has_nav_menu( 'mobile-menu') ) {
				
				wp_nav_menu(array(
					'theme_location'    =>  'mobile-menu',
					'menu_type'         =>  'mobile-menu',
					'item_spacing'      =>  'discard',
					'menu_class'        =>  'kwt-menu nav-menu',
					'items_wrap'      	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'killar_header_extra_navigation', $ext_nav_list ) .'</ul>',
					'container'         => 	false,
					'fallback_cb' 		=>  'KillarWT_Nav_Walker::fallback',
					'walker' 			=>  new KillarWT_Nav_Walker(),
				) );
			}
			
			?>
		</nav>
		<?php
	}
	add_action( 'killar_mob_header_navigation', 'killarwt_mob_header_navigation' );
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'killarwt_header_main_menu' ) ) {
	
	function killarwt_header_main_menu(){
			$ext_nav_list = '';
			if ( is_page_template( 'page-templates/one-page.php' ) ) {
				if ( has_nav_menu( 'primary') ) {
					
					wp_nav_menu(array(
						'theme_location'    =>  'one-page-menu',
						'menu_type'         =>  'main-menu',
						'item_spacing'      =>  'discard',
						'menu_class'        =>  'kwt-menu nav-menu',
						'items_wrap'     	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'killar_header_extra_navigation', $ext_nav_list  ) .'</ul>',
						'container'         => 	false,
						'fallback_cb' 		=>  'KillarWT_Nav_Walker::fallback',
						'walker' 			=>  new KillarWT_Nav_Walker(),
					) );
				}
			} else {
				if ( has_nav_menu( 'primary') ) {
					
					wp_nav_menu(array(
						'theme_location'    =>  'primary',
						'menu_type'         =>  'main-menu',
						'item_spacing'      =>  'discard',
						'menu_class'        =>  'kwt-menu nav-menu',
						'items_wrap'      	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'killar_header_extra_navigation', $ext_nav_list ) .'</ul>',
						'container'         => 	false,
						'fallback_cb' 		=>  'KillarWT_Nav_Walker::fallback',
						'walker' 			=>  new KillarWT_Nav_Walker(),
					) );
				}
			}
	}
	add_action( 'killar_header_primary_navigation', 'killarwt_header_main_menu' );
}


/**
 * Transparent Header
 */
if ( ! function_exists( 'killarwt_transparent_header' ) ) {
	
	function killarwt_transparent_header() {
		
		$pm_transparent = killarwt_get_post_meta( 'transparent_header' );
		if ( killarwt_is_not_def_empty( $pm_transparent ) ) {
			$is_transparent = $pm_transparent;
		} else {
			$is_transparent = get_theme_mod( 'killar_transparent_header', false );	
		}
			
		return apply_filters( 'killar_transparent_header', $is_transparent );
	}
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'killarwt_header_search_icon' ) ) {
	
	function killarwt_header_search_icon( $items ) {
		
		$status = killarwt_theme_mod( 'killar_show_header_search', false );
		if( $status == false ) return $items;
			
		echo '<li class="menu-item item-search"><a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#search"><span class="fa-solid fa-magnifying-glass text-muted fs-6"></span></a></li>';
	}
}

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
if ( !function_exists( 'killarwt_search_form' ) ) {
	function killarwt_search_form( $form ) {
		$form = '<form method="get" class="searchform" action="' . home_url( '/' ) . '" >
			<div class="search-wrap"><label class="screen-reader-text">' . esc_html( 'Search for:' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr( 'Type Keyword...', 'killar' ) . '" />
			<button type="submit" class="search-btn" aria-label="' . esc_attr( 'Search', 'killar' ) . '"><span class="ico fas fa-search"></span><span class="txt btn d-none">' . esc_attr( 'Search', 'killar' ) . '</span></button>
			</div>
		</form>';

		return $form;
	}
	add_filter( 'get_search_form', 'killarwt_search_form' );	
}

/**
 * Header Primary Navigation Extra Content
 */
if ( ! function_exists( 'killarwt_header_primary_extra_content' ) ) {
	
	function killarwt_header_primary_extra_content( $items ) {
		
		$content = get_theme_mod( 'killar_header_nav_extra_content' );
		if( empty( $content ) ) return $items;
			
		$items .= $content;
			
		return apply_filters( 'killar_header_primary_extra_content', $items );
	}
	add_filter( 'killar_header_extra_navigation', 'killarwt_header_primary_extra_content' );
}

/**
 * Mobile Header Search Style
 */
if ( ! function_exists( 'killarwt_mob_header_search_style' ) ) {

	function killarwt_mob_header_search_style() {

		$style = get_theme_mod( 'killar_mob_header_search_style', 'toggle' );
		$style = ($style) ? $style : 'toggle';

		return apply_filters( 'killar_mob_header_search_style', $style );

	}
}

/**
 * Newsletter Popup Layout List
 */
if ( ! function_exists( 'killarwt_newsletter_popup_layout_list' ) ) {

	function killarwt_newsletter_popup_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'newsletter_popup', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts[''] = esc_html__( 'None', 'killar' );
		
		return apply_filters( 'killar_newsletter_popup_layout_list', $layouts);
	}
}

/**
 * Newsletter Popup Modal
 */
if ( ! function_exists( 'killar_general_newsletter_popup_modal' ) ) {

	function killar_general_newsletter_popup_modal() {

		$layout = get_theme_mod( 'killar_general_newsletter_popup_layout', 'none' );
		$delay = get_theme_mod( 'killar_general_newsletter_popup_delay', '3600' );
		$html = '';
		if( !empty( $layout ) && $layout != 'none' ) {
			$html .= '<div id="newsletter-modal" class="modal fade" tabindex="-1" data-pause="'. esc_attr( $delay ) .'" role="dialog" aria-label="myModalLabel" aria-hidden="true" >
							<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content rounded-2 overflow-hidden">
									<div class="container-fluid p-0">
										<span class="mod-close bg-transparent text-primary" data-bs-dismiss="modal" aria-hidden="true">
											<svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
												<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
												<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
											</svg>
										</span>';
			$html .= killarwt_do_shortcode( 'killar_layout', array( 'id' => apply_filters( 'killar_general_newsletter_popup_layout', $layout ) ) );
			$html .= '				</div>
								</div>
							</div>
						</div>';

			echo do_shortcode( $html );
		}
	}

	add_action( 'killar_after_site', 'killar_general_newsletter_popup_modal' );
}

/**
 * Header Right Layout List
 */
if ( ! function_exists( 'killarwt_header_right_layout_list' ) ) {

	function killarwt_header_right_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'header_right', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts[''] = esc_html__( 'None', 'killar' );
		$layouts['shop'] = esc_html__( 'Shop Buttons', 'killar' );
		
		return apply_filters( 'killar_header_right_layout_list', $layouts);
	}
}

/**
 * Header Right Content
 */
if ( ! function_exists( 'killarwt_header_right_content' ) ) {
	
	function killarwt_header_right_content() {

		$pm_layout = killarwt_get_post_meta( 'header_right_layout' );
		$layout = ( killarwt_is_not_def_empty( $pm_layout ) ) ? $pm_layout : get_theme_mod( 'killar_header_right_layout' );
		$layout = apply_filters('killar_header_right_layout', $layout);

		if ( in_array( $layout, array( 'shop' ) ) ) {
			get_template_part( 'template-parts/header/header-right-elements/' . $layout );
		} else if( !empty( $layout ) ) {
			echo killarwt_do_shortcode( 'killar_layout', array( 'id' => $layout ) );
		}
	}
	add_action( 'killar_header_right_content', 'killarwt_header_right_content' );
}

/**
 * Mobile Layout List
 */
if ( ! function_exists( 'killarwt_mobile_layout_list' ) ) {

	function killarwt_mobile_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'mobile', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts[''] = esc_html__( 'None', 'killar' );
		$layouts['mobile-shop'] = esc_html__( 'Shop Buttons', 'killar' );
		//$layouts['mobile-signin-button'] = esc_html__( 'SignIn - Account Button', 'killar' );
		
		return apply_filters( 'killar_mobile_layout_list', $layouts);
	}
}

/**
 * Mobile Header Right Content
 */
if ( ! function_exists( 'killarwt_mobile_header_right_content' ) ) {
	
	function killarwt_mobile_header_right_content(){

		$pm_layout = killarwt_get_post_meta( 'mobile_header_right_layout' );
		$layout = ( killarwt_is_not_def_empty( $pm_layout ) ) ? $pm_layout : get_theme_mod( 'killar_mobile_header_right_layout' );
		$layout = apply_filters('killar_mobile_header_right_layout', $layout);
		
		if ( in_array( $layout, array( 'mobile-signin-button', 'mobile-shop' ) ) ) {
			get_template_part( 'template-parts/header/header-right-elements/' . $layout );
		} else if( !empty( $layout ) ) {
			echo killarwt_do_shortcode( 'killar_layout', array( 'id' => $layout ) );
		}
	}
	add_action( 'killar_mobile_header_right_content', 'killarwt_mobile_header_right_content' );
}

/**
 * Advance navigation Layout List
 */
if ( ! function_exists( 'killarwt_advance_navigation_layout_list' ) ) {

	function killarwt_advance_navigation_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'advance_navigation', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts[''] = esc_html__( 'None', 'killar' );
		
		return apply_filters( 'killar_advance_navigation_layout_list', $layouts);
	}
}

/**
 * Add advance navigation right sidebar
 */
if (!function_exists('killarwt_header_right_advance_navigation_icon')) {

	function killarwt_header_right_advance_navigation_icon()
	{

		if (empty(killarwt_show_advance_navigation())) return;

		echo '<li>
				<a href="#" class="advance-navbar-action text-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
						<span class="svg-icon svg-icon-2hx">
							<svg width="22" height="22" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect y="6" width="16" height="3" rx="1.5" fill="currentColor"></rect>
								<rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor"></rect>
								<rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor"></rect>
							</svg>
						</span>
					</a>
			</li>';
	}
	add_filter('killar_header_right_sidebar_list_after', 'killarwt_header_right_advance_navigation_icon', 50);
}


/**
 * Menu Layout
 */
if ( ! function_exists( 'killarwt_megamenu_layout_list' ) ) {

	function killarwt_megamenu_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'megamenu', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts[''] = esc_html__( 'None', 'killar' );
		
		return apply_filters( 'killar_submenu_layout_list', $layouts);
	}
}

/**
 * After Content Wrap
 */
if ( ! function_exists( 'killarwt_after_site' ) ) {
	
	function killarwt_after_site() {

		if( !empty( !empty( killarwt_show_advance_navigation() ) ) ) {
			get_template_part( 'template-parts/elements/advance-navigation' );
		}

		if( !empty( killarwt_theme_mod( 'killar_show_header_search', false ) ) ) {
			get_template_part( 'template-parts/elements/search-flyout' );
		}

		get_template_part( 'template-parts/elements/mobile-flyout' );
	}
	add_action( 'killar_after_site', 'killarwt_after_site', 20 );
}


/*-----------------------------------------------
 * Page Header
 *----------------------------------------------*/

/**
 * Page header template
 */
if ( ! function_exists( 'killarwt_page_header_template' ) ) {

	function killarwt_page_header_template() {

		get_template_part( 'template-parts/header/page-header' );

	}

	add_action( 'killar_before_main', 'killarwt_page_header_template' );
}

/**
 * Return page title style
 */
if ( ! function_exists( 'killarwt_page_title_style' ) ) {

	function killarwt_page_title_style() {
		
		$style = 'left';
		$pm_style = killarwt_get_post_meta( 'page_title_style' );
		if ( killarwt_is_not_def_empty( $pm_style ) ) {
			$style = $pm_style;
		} else if ( is_front_page() ) {
			$style = 'hidden';
		} else if ( killarwt_is_portfolio_archive() ) {
			$style = get_theme_mod( 'killar_portfolio_loop_post_page_title_alignment', 'left' );
		} else if ( is_singular( 'portfolio' ) ) {
			$style = get_theme_mod( 'killar_portfolio_single_post_page_title_alignment', 'left' );
		} else if ( killarwt_is_catalog() ) {
			$style = get_theme_mod( 'killar_woo_archive_page_title_alignment', 'left' );
		} else if ( killarwt_is_woo_single_prod() ) {
			$style = get_theme_mod( 'killar_woo_single_prod_page_title_alignment', 'left' );
		} else if ( killarwt_is_blog_archive() ) {
			$style = get_theme_mod( 'killar_blog_loop_post_page_title_alignment', 'left' );
		} else if ( is_singular( 'post' ) ) {
			$style = get_theme_mod( 'killar_blog_single_post_page_title_alignment', 'left' );
		}
		
		$style = ( $style == 'default' ) ? get_theme_mod( 'killar_page_title_style', 'left' ) : $style;
		return apply_filters( 'killar_page_title_style', $style );

	}
}

/**
 * Display Page title
 */
if ( ! function_exists( 'killarwt_display_page_title' ) ) {

	function killarwt_display_page_title() {
		
		$return = true;
		$title = killarwt_get_post_meta( 'page_title_section' );
		if ( !killarwt_is_not_def_empty( $title ) ) {
			$title = get_theme_mod( 'killar_page_title_section', true );
		}

		if ( killarwt_is_portfolio_archive() ) {
			$title = get_theme_mod( 'killar_portfolio_loop_post_page_title_section', true );
		} else if ( is_singular( 'portfolio' ) ) {
			$title = get_theme_mod( 'killar_portfolio_single_post_page_title_section', true );
		} else if ( killarwt_is_catalog() ) {
			$title = get_theme_mod( 'killar_woo_archive_page_title_section', true );
		} else if ( killarwt_is_woo_single_prod() ) {
			$title = get_theme_mod( 'killar_woo_single_prod_page_title_section', true );
		} else if ( killarwt_is_blog_archive() ) {
			$title = get_theme_mod( 'killar_blog_loop_post_page_title_section', true );
		} else if ( is_singular( 'post' ) ) {
			$title = get_theme_mod( 'killar_blog_single_post_page_title_section', true );
		}
		
		if ( empty( $title ) || is_front_page() || is_page_template( 'templates/landing.php' ) || is_404() || ( function_exists('is_account_page') && is_account_page() ) ) {
			$return = false;
		}

		return apply_filters( 'killar_display_page_title', $return );
	}
}

/**
 * Page title
 */
if ( ! function_exists( 'killarwt_page_title' ) ) {

	function killarwt_page_title() {
		
		$pm_page_title = killarwt_get_post_meta( 'page_title_title' );
		if ( killarwt_is_not_def_empty( $pm_page_title ) ) {
			$page_title = $pm_page_title;
		} else {
			$page_title = get_theme_mod( 'killar_page_title', true );
		}
		
		if ( ! $page_title
			|| is_front_page() ) {
			return;
		}
		// addddddd -----------------------------------------
		
		// if ( ! $page_title
		// 	|| is_singular('post') ) {
		// 	return;
		// }

		//---------------------------------------------------
		

		$title = '';
		$post_id = killarwt_post_id();
		
		if ( killarwt_is_portfolio_archive() ) {
			
			$title = get_theme_mod( 'killar_portfolio_loop_post_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'killar_portfolio_loop_post_page_title_custom', 'Portfolio' );
			} else {
				
				if ( is_author() ) {
					$title = get_the_archive_title();
				} else if ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} else if ( is_day() ) {
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'killar' ), get_the_date() );
				} else if ( is_month() ) {
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'killar' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'killar' ) ) );
				} else if ( is_year() ) {
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'killar' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'killar' ) ) );
				} else {
					$title = single_term_title( '', false );
					if ( ! $title ) {
						global $post;
						$title = get_the_title( $post_id );
					}
				}
				
			}
		} else if ( killarwt_is_catalog() ) {
			
			$title = get_theme_mod( 'killar_woo_archive_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'killar_woo_archive_page_title_custom', 'Shop' );
			} else {
				
				$title = single_term_title( '', false );
				if ( ! $title ) {
					global $post;
					$title = get_the_title( $post_id );
				}
			}
		} else if ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'killar' );
		} else if ( killarwt_is_blog_archive() ) {
			
			$title = get_theme_mod( 'killar_blog_loop_post_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'killar_blog_loop_post_page_title_custom', 'Blog' );
			} else {
				
				if ( is_author() ) {
					$title = get_the_archive_title();
				} else if ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} else if ( is_day() ) {
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'killar' ), get_the_date() );
				} else if ( is_month() ) {
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'killar' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'killar' ) ) );
				} else if ( is_year() ) {
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'killar' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'killar' ) ) );
				} else {
					$title = single_term_title( '', false );
					if ( ! $title ) {
						global $post;
						$title = get_the_title( $post_id );
					}
				}
			}
		} else if ( is_404() ) {
			$title = esc_html__( '404: Page Not Found', 'killar' );
		} else if ( $post_id ) {
			
			// Single Pages
			$pm_page_title_text = killarwt_get_post_meta( 'page_title_text' );
			if( !empty( $pm_page_title_text ) && $pm_page_title_text == 'custom' ) {
				$title = killarwt_get_post_meta( 'page_title_custom_text' );
			} else {
				if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
					$title = get_the_title( $post_id );
				} else if ( is_singular( 'portfolio' ) ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'killar_portfolio_single_post_page_title', 'custom' ) : $pm_page_title_text;
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					} else if ( $title == 'custom' ) {
						$title = get_theme_mod( 'killar_portfolio_single_post_page_title_custom', esc_html__( 'Our Portfolio', 'killar' ) );
					}
				} else if ( killarwt_is_woo_single_prod() ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'killar_woo_single_prod_page_title', 'custom' ) : $pm_page_title_text;
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					} else if ( $title == 'custom' ) {
						$title = get_theme_mod( 'killar_woo_single_prod_page_title_custom', esc_html__( 'Our Catalog', 'killar' ) );
					}
				} else if ( is_singular( 'post' ) ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'killar_blog_single_post_page_title', 'custom' ) : $pm_page_title_text;
					
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					}
					 else if ( $title == 'custom' ) {
						return false;
						// $title = get_theme_mod( 'killar_blog_single_post_page_title_custom', esc_html__( 'Our Blog', 'killar' ) );
					}
				}
			}
		}
		
		$title = $title ? $title : $title = get_the_title( $post_id );;
		
		return apply_filters( 'killar_page_title', $title );
	}
}


/**
 * Display Page Title Content
 */
if ( ! function_exists( 'killarwt_page_title_content' ) ) {

	function killarwt_page_title_content() {
		
		ob_start();
		if ( killarwt_is_catalog() || killarwt_is_woo_single_prod() || is_archive() || is_singular( 'post') || is_singular( 'page') || is_singular( 'portfolio') || killarwt_is_portfolio_archive() ) {
			$content_type = get_theme_mod( 'killar_blog_single_post_page_title_inner_content', 'breadcrumbs' );
			if( $content_type == 'meta' ) {
				get_template_part( 'template-parts/single-post/meta'  );
			} else if( $content_type == 'breadcrumbs' && function_exists( 'killarwt_breadcrumb_trail' ) ) {
				killarwt_breadcrumb_trail();
			}
		}
		return ob_get_clean(); 
	}
}


/**
 * Display breadcrumbs
 */
if ( ! function_exists( 'killarwt_page_title_breadcrumbs_display' ) ) {

	function killarwt_page_title_breadcrumbs_display() {

		$pm_page_breadcrumb = killarwt_get_post_meta( 'page_title_breadcrumb' );
		if ( killarwt_is_not_def_empty( $pm_page_breadcrumb ) ) {
			$display = $pm_page_breadcrumb;
		} else if ( killarwt_is_portfolio_archive() ) {
			$display = get_theme_mod( 'killar_portfolio_loop_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'portfolio' ) ) {
			$display = get_theme_mod( 'killar_portfolio_single_post_page_header_breadcrumb', true );
		} else if ( killarwt_is_catalog() ) {
			$display = get_theme_mod( 'killar_woo_archive_page_header_breadcrumb', true );
		} else if ( killarwt_is_woo_single_prod() ) {
			$display = get_theme_mod( 'killar_woo_single_prod_page_header_breadcrumb', true );
		} else if ( killarwt_is_blog_archive() ) {
			$display = get_theme_mod( 'killar_blog_loop_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'post' ) ) {
			$display = get_theme_mod( 'killar_blog_single_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'page' ) ) {
			$display = get_theme_mod( 'killar_page_single_page_header_breadcrumb', true );
		} else {
			$display = get_theme_mod( 'killar_page_title_breadcrumbs_display', true );
		}
		
		return apply_filters( 'killar_page_title_breadcrumbs_display', $display );
	}
}

/**
 * Display Advance Navigation
 */
if ( ! function_exists( 'killarwt_show_advance_navigation' ) ) {

	function killarwt_show_advance_navigation() {

		$pm_advance_navigation = killarwt_get_post_meta( 'advance_navigation' );
		if ( killarwt_is_not_def_empty( $pm_advance_navigation ) ) {
			$display = $pm_advance_navigation;
		} else if ( killarwt_is_portfolio_archive() ) {
			$display = get_theme_mod( 'killar_portfolio_loop_post_page_advance_navigation', false );
		} else if ( is_singular( 'portfolio' ) ) {
			$display = get_theme_mod( 'killar_portfolio_single_post_page_advance_navigation', false );
		} else if ( killarwt_is_blog_archive() ) {
			$display = get_theme_mod( 'killar_blog_loop_post_page_advance_navigation', false );
		} else if ( is_singular( 'post' ) ) {
			$display = get_theme_mod( 'killar_blog_single_post_page_advance_navigation', false );
		} else {
			$display = get_theme_mod( 'killar_show_advance_navigation', false );
		}
		
		return apply_filters( 'killar_show_advance_navigation', $display );
	}
}

/**
 * Return Background Show
 */
if ( ! function_exists( 'killarwt_page_title_background' ) ) {

	function killarwt_page_title_background() {
		
		$pm_background = killarwt_get_post_meta( 'page_title_background' );
		if ( killarwt_is_not_def_empty( $pm_background ) ) {
			$background = $pm_background;
		} else if ( killarwt_is_portfolio_archive() ) {
			$background = apply_filters( 'killar_portfolio_loop_post_page_title_background', get_theme_mod( 'killar_portfolio_loop_post_page_title_background', 'default' ) );
		} else if ( is_singular( 'portfolio' ) ) {
			$background = apply_filters( 'killar_portfolio_single_post_page_title_background', get_theme_mod( 'killar_portfolio_single_post_page_title_background', 'default' ) );
		} else if ( killarwt_is_catalog() ) {
			$background = apply_filters( 'killar_woo_archive_page_title_background', get_theme_mod( 'killar_woo_archive_page_title_background', 'default' ) );
		} else if ( killarwt_is_woo_single_prod() ) {
			$background = apply_filters( 'killar_woo_single_prod_page_title_background', get_theme_mod( 'killar_woo_single_prod_page_title_background', 'default' ) );
		} else if ( killarwt_is_blog_archive() ) {
			$background = apply_filters( 'killar_blog_loop_post_page_title_background', get_theme_mod( 'killar_blog_loop_post_page_title_background', 'default' ) );
		} else if ( is_singular( 'post' ) ) {
			$background = apply_filters( 'killar_blog_single_post_page_title_background', get_theme_mod( 'killar_blog_single_post_page_title_background', 'default' ) );
		}
		
		$background = ( empty( $background ) || $background == 'default' ) ? get_theme_mod( 'killar_page_title_background', 'scene' ) : $background;

		return apply_filters( 'killarwt_page_title_background', $background ); 
	}
}

/**
 * Background image
 */
if ( ! function_exists( 'killarwt_page_title_bg_image' ) ) {

	function killarwt_page_title_bg_image() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$bg_image = get_theme_mod( 'killar_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
	
		if ( $pm_bg_image = killarwt_get_post_meta( 'page_title_bg_image' ) ) {
			$bg_image = wp_get_attachment_url( $pm_bg_image );
		} else if ( killarwt_is_portfolio_archive() ) {
			if ( get_theme_mod( 'killar_portfolio_loop_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_portfolio_loop_post_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( is_singular( 'portfolio' ) ) {
			if ( get_theme_mod( 'killar_portfolio_single_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_portfolio_single_post_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'killar_portfolio_single_post_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( killarwt_is_catalog() ) {
			if ( get_theme_mod( 'killar_woo_archive_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_woo_archive_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( killarwt_is_woo_single_prod() ) {
			if ( get_theme_mod( 'killar_woo_single_prod_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_woo_single_prod_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'killar_woo_single_prod_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( killarwt_is_blog_archive() ) {
			if ( get_theme_mod( 'killar_blog_loop_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_blog_loop_post_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( is_singular( 'post' ) ) {
			if ( get_theme_mod( 'killar_blog_single_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'killar_blog_single_post_page_title_bg_image', KILLARWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'killar_blog_single_post_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( has_post_thumbnail() ) {
			$bg_image = get_the_post_thumbnail_url();
		}
		
		return apply_filters( 'killar_page_title_bg_image', $bg_image ); 
	}
}

/**
 * Background position
 */
if ( ! function_exists( 'killarwt_page_title_bg_position' ) ) {

	function killarwt_page_title_bg_position() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$position = get_theme_mod( 'killar_page_title_bg_position', 'center center' );
		
		$pm_position = killarwt_get_post_meta( 'page_title_bg_position' );
		if ( killarwt_is_not_def_empty( $pm_position ) ) {
			$position = $pm_position;
		}
		
		return apply_filters( 'killar_page_title_bg_position', $position ); 
	}
}

/**
 * Background attachment
 */
if ( ! function_exists( 'killarwt_page_title_bg_attachment' ) ) {

	function killarwt_page_title_bg_attachment() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$attachment = get_theme_mod( 'killar_page_title_bg_attachment', 'initial' );
		
		$pm_attachment = killarwt_get_post_meta( 'page_title_bg_attachment' );
		if ( killarwt_is_not_def_empty( $pm_attachment ) ) {
			$attachment = $pm_attachment;
		}
		
		return apply_filters( 'killar_page_title_bg_attachment', $attachment ); 
	}
}

/**
 * Background repeat
 */
if ( ! function_exists( 'killarwt_page_title_bg_repeat' ) ) {

	function killarwt_page_title_bg_repeat() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$repeat = get_theme_mod( 'killar_page_title_bg_repeat', 'no-repeat' );
		
		$pm_repeat = killarwt_get_post_meta( 'page_title_bg_repeat' );
		if ( killarwt_is_not_def_empty( $pm_repeat ) ) {
			$repeat = $pm_repeat;
		}
		
		return apply_filters( 'killar_page_title_bg_repeat', $repeat ); 
	}
}

/**
 * Background size
 */
if ( ! function_exists( 'killarwt_page_title_bg_size' ) ) {

	function killarwt_page_title_bg_size() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$size = get_theme_mod( 'killar_page_title_bg_size', 'cover' );
		
		$pm_size = killarwt_get_post_meta( 'page_title_bg_size' );
		if ( killarwt_is_not_def_empty( $pm_size ) ) {
			$size = $pm_size;
		}
		
		return apply_filters( 'killar_page_title_bg_size', $size ); 
	}
}


/**
 * Background image overlay
 */
if ( ! function_exists( 'killarwt_page_title_bgimg_overlay' ) ) {

	function killarwt_page_title_bgimg_overlay() {

		if ( killarwt_page_title_background() ) {
			
			echo '<span class="page-header-bgimg-overlay"></span>';
			
		}
	}
	add_filter( 'killar_after_page_header', 'killarwt_page_title_bgimg_overlay' );
}


/**
 * Background overlay color
 */
if ( ! function_exists( 'killarwt_page_title_overlay_bg_color' ) ) {

	function killarwt_page_title_overlay_bg_color() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$color = get_theme_mod( 'killar_page_title_overlay_bg_color', '' );
		
		$pm_color = killarwt_get_post_meta( 'page_title_overlay_bg_color' );
		if ( killarwt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'killar_page_title_overlay_bg_color', $color ); 
	}
}

/**
 * Background overlay opacity
 */
if ( ! function_exists( 'killarwt_page_title_bg_overlay_opacity' ) ) {

	function killarwt_page_title_bg_overlay_opacity() {
		
		if ( !killarwt_page_title_background() ) {
			return;
		}
		
		$opacity = get_theme_mod( 'killar_page_title_bg_overlay_opacity', '0' );
		
		$pm_opacity = killarwt_get_post_meta( 'page_title_bg_overlay_opacity' );
		if ( killarwt_is_not_def_empty( $pm_opacity ) && $pm_opacity != -1 ) {
			$opacity = $pm_opacity;
		}
		
		return apply_filters( 'killar_page_title_bg_overlay_opacity', $opacity ); 
	}
}

/**
 * Page title font size
 */
if ( ! function_exists( 'killarwt_page_title_font_size' ) ) {

	function killarwt_page_title_font_size() {
		
		if ( !killarwt_page_title() ) {
			return;
		}
		
		$fontsize = get_theme_mod( 'killar_page_title_font_size', '' );
		
		$pm_fontsize = killarwt_get_post_meta( 'page_title_font_size' );
		if ( killarwt_is_not_def_empty( $pm_fontsize ) ) {
			$fontsize = $pm_fontsize;
		}
		
		return apply_filters( 'killar_page_title_font_size', $fontsize ); 
	}
}

/**
 * Page title background color
 */
if ( ! function_exists( 'killarwt_page_title_bg_color' ) ) {

	function killarwt_page_title_bg_color() {
		
		if ( !killarwt_display_page_title() ) {
			return;
		}
		
		$bgcolor = get_theme_mod( 'killar_page_title_bg_color', '' );
		
		$pm_bgcolor = killarwt_get_post_meta( 'page_title_bg_color' );
		if ( killarwt_is_not_def_empty( $pm_bgcolor ) ) {
			$bgcolor = $pm_bgcolor;
		}
		
		return apply_filters( 'killar_page_title_bg_color', $bgcolor ); 
		
	}

}

/**
 * Page title text color
 */
if ( ! function_exists( 'killarwt_page_title_text_color' ) ) {

	function killarwt_page_title_text_color() {
		
		if ( !killarwt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'killar_page_title_text_color', '' );
		
		$pm_color = killarwt_get_post_meta( 'page_title_text_color' );
		if ( killarwt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'killar_page_title_text_color', $color ); 
	}
}

/**
 * Page title separator color
 */
if ( ! function_exists( 'killarwt_page_title_separator_color' ) ) {

	function killarwt_page_title_separator_color() {
		
		if ( !killarwt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'killar_page_title_separator_color', '' );
		
		$pm_color = killarwt_get_post_meta( 'page_title_separator_color' );
		if ( killarwt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}

		return apply_filters( 'killar_page_title_separator_color', $color ); 
	}
}

/**
 * Page title link color
 */
if ( ! function_exists( 'killarwt_page_title_link_color' ) ) {

	function killarwt_page_title_link_color() {
		
		if ( !killarwt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'killar_page_title_link_color', '' );
		
		$pm_color = killarwt_get_post_meta( 'page_title_link_color' );
		if ( killarwt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'killar_page_title_link_color', $color ); 
	}
}

/**
 * Page title link hover color
 */
if ( ! function_exists( 'killarwt_page_title_link_hover_color' ) ) {

	function killarwt_page_title_link_hover_color() {
		
		if ( !killarwt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'killar_page_title_link_hover_color', '' );
		
		$pm_color = killarwt_get_post_meta( 'page_title_link_color' );
		if ( killarwt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'killar_page_title_link_hover_color', $color ); 
	}
}

/**
 * Page title Scene
 */
if ( ! function_exists( 'killarwt_page_title_scene' ) ) {

	function killarwt_page_title_scene() {
		
		if ( !killarwt_display_page_title() || killarwt_page_title_background() != 'scene' ) {
			return;
		}
		
		$scene_style = get_theme_mod( 'killar_page_title_scene', 'style-1' );
		$scene_img_path = KILLARWT_IMAGES_DIR_URI .'scene/' . $scene_style . '/';
		$scene_item = [];
		if( in_array( $scene_style, array( 'style-1' ) ) ) {
			$scene_item[] = array( 'parent_div' => array( 'class' => 'position-absolute top-0 end-0 z-0' ) ,
			'image' => array( 'class' => '', 'src' => esc_url( $scene_img_path . 'alert-bg.png' ), 'width' => '300', 'alt' => 'PNG' ) 
			);
			$scene_item[] = array( 'parent_div' => array( 'class' => 'position-absolute bottom-0 start-0 me-10 z-0' ) ,
			'image' => array( 'class' => '', 'src' => esc_url( $scene_img_path . 'circle.png' ), 'width' => '150', 'alt' => 'PNG' ) 
			);
		} else if( in_array( $scene_style, array( 'style-2' ) ) ) {
			$scene_item[] = array( 'parent_div' => array( 'class' => 'position-absolute top-0 start-0 z-0' ) ,
			'image' => array( 'class' => '', 'src' => esc_url( $scene_img_path . 'shape-1-soft-light.svg' ), 'width' => '200', 'alt' => 'SVG' ) 
			);
			$scene_item[] = array( 'parent_div' => array( 'class' => 'position-absolute bottom-0 end-0 me-10 z-0' ) ,
			'image' => array( 'class' => '', 'src' => esc_url( $scene_img_path . 'shape-1-soft-light.svg' ), 'width' => '150', 'alt' => 'SVG' ) 
			);
		}
		return apply_filters( 'killarwt_page_title_scene', $scene_item ); 
	}
}

/*-----------------------------------------------
 * Footer
 *----------------------------------------------*/

/**
 * Footer Layout List
 */
if ( ! function_exists( 'killarwt_footer_layout_list' ) ) {

	function killarwt_footer_layout_list() {
		
		$layouts = killarwt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_killar_layout_page_layout', 'meta_value'   => 'footer', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts['simple'] = esc_html__( 'Simple', 'killar' );
		$layouts['hidden'] = esc_html__( 'Hidden', 'killar' );
		
		return apply_filters( 'killar_footer_layout_list', $layouts);
	}
}

/**
 * Footer Layout
 */
if ( ! function_exists( 'killarwt_footer_layout' ) ) {

	function killarwt_footer_layout() {
		
		$pm_layout = killarwt_get_post_meta( 'footer_layout' );
		if ( killarwt_is_not_def_empty( $pm_layout ) ) {
			$layout = $pm_layout;
		} else {
			$layout = get_theme_mod( 'killar_footer_layout', 'simple' );	
		}
		
		$layout = ($layout) ? $layout : '';

		return apply_filters( 'killar_footer_layout', $layout );
	}
}


/**
 * Footer template
 */
if ( ! function_exists( 'killarwt_footer_template' ) ) {

	function killarwt_footer_template() {
		
		$layout = killarwt_footer_layout();
		if ( $layout == 'hidden' ) return;
		
		$args = $args['atts'] = array();
		$args['layout'] = $layout;
		$args['atts']['class'] = array( 'footer', 'footer-wrap' );
		$args['atts']['class'][] = 'footer-layout-' . $layout;
		// print_r($args['layout']);exit;
		killarwt_get_template( 'template-parts/footer/layout' , $args );
		
	}
	add_action( 'killar_footer', 'killarwt_footer_template' );
}

/*-----------------------------------------------
 * Main Page
 *----------------------------------------------*/

/**
 * Main section attributes
 */
if ( ! function_exists( 'killarwt_main_section_atts' ) ) {

	function killarwt_main_section_atts() {

		$atts = array();

		$classes = array( 'section' );

		$atts['class'] = killarwt_stringify_classes( apply_filters( 'killar_main_section_class', $classes ) );

		$atts = apply_filters( 'killar_main_section_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
		
	}
}

/**
 * Content attributes
 */
if ( ! function_exists( 'killarwt_main_page_atts' ) ) {

	function killarwt_main_page_atts() {

		$atts = array();

		$atts['id'] = 'main';
		$atts['class'] = killarwt_get_main_page_classes();

		$atts = apply_filters( 'killar_main_page_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
	}
}

if ( ! function_exists( 'killarwt_get_main_page_classes' ) ) {

	function killarwt_get_main_page_classes( $class = '' ) {

		// array of class names.
		$classes = array();

		// default class from widget area.
		$classes[] = 'site-main';

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}
		
		$el_classes = killarwt_get_post_meta( 'page_el_classes' );
		if( !empty( $el_classes ) ) {
			$classes = array_merge( $classes, array( $el_classes  ) );
		}
		
		$classes = apply_filters( 'killar_main_page_classes', $classes, $class );
		
		return array_unique( $classes );
	}
}


/*-----------------------------------------------
 * Primary Content
 *----------------------------------------------*/

/**
 * Content attributes
 */
if ( ! function_exists( 'killarwt_primary_col_atts' ) ) {

	function killarwt_primary_col_atts() {

		$atts = array();

		$atts['id'] = 'primary';
		$atts['class'] = killarwt_stringify_classes( killarwt_get_primary_col_class() );

		$atts = apply_filters( 'killar_primary_col_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
		
	}
}

/**
 * Retrieve the classes for the primary column element as an array.
 */
if ( ! function_exists( 'killarwt_get_primary_col_class' ) ) {

	function killarwt_get_primary_col_class( $class = '' ) {

		// array of class names.
		$classes = array();

		// default class from widget area.
		$classes[] = 'content-area';

		$cont_classes = killarwt_primary_columns();
		if ( !empty ( $cont_classes ) ) {
			$classes = array_merge( $classes, $cont_classes );
		} 

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'killar_primary_col_class', $classes, $class );

		return array_unique( $classes );
	}
}


/*-----------------------------------------------
 * Secondary Sidebar
 *----------------------------------------------*/

/**
 * Get the sidebar
 */
if ( ! function_exists( 'killarwt_display_sidebar' ) ) {

	function killarwt_display_sidebar() {

		// Return if full width or full screen
		if ( in_array( killarwt_get_layout(), array( 'full-screen', 'full-width' ) ) ) {
			return;
		}
		
		get_sidebar();
	}
}

/**
 * Sidebar attributes
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'killarwt_sidebar_atts' ) ) {

	function killarwt_sidebar_atts() {

		$atts = array();

		$atts['itemtype'] = "https://schema.org/WPSideBar";
		$atts['itemscope'] = "itemscope";
		$atts['id'] = "secondary";
		$atts['class'] = killarwt_get_secondary_col_class();

		//is catalog woo layout
		if ( !empty( killarwt_is_woo_layout() )  ) {
			$atts['id'] = "Sidebarshop";
			$atts['class'][] = 'offcanvas-lg offcanvas-start';
			$atts['data-bs-scroll'] = 'true';
			$atts['data-bs-backdrop'] = 'false';
		}

		$atts = apply_filters( 'killar_secondary_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
	}
}

/**
 * Returns the sidebar
 */
if ( ! function_exists( 'killarwt_sidebar_action' ) ) {

	function killarwt_sidebar_action() {
		
		$action = 'killar_after_primary';

		add_action( $action, 'killarwt_display_sidebar' );
		
	}
	add_action( 'wp', 'killarwt_sidebar_action', 20 );
}

/**
 * Sidebar
 */
if ( ! function_exists( 'killarwt_get_sidebar_name' ) ) {
	
	function killarwt_get_sidebar_name() {
		
		$sidebar = get_theme_mod( 'killar_blog_loop_post_sidebar', 'blog-sidebar' );
		
		$pm_sidebar = killarwt_get_post_meta( 'sidebar' );
		if ( killarwt_is_not_def_empty( $pm_sidebar ) ) {
			$sidebar = $pm_sidebar;
		} else if ( killarwt_is_portfolio_archive() ) {
			$sidebar = get_theme_mod( 'killar_portfolio_loop_post_sidebar', 'portfolio-sidebar' );
		} else if ( is_singular( 'portfolio' ) ) {
			$sidebar = get_theme_mod( 'killar_portfolio_single_post_sidebar', 'single-portfolio-sidebar' );
		} else if ( killarwt_is_catalog() ) {
			$sidebar = get_theme_mod( 'killar_woo_archive_sidebar', 'woo-archive-shop-sidebar' );
		} else if ( killarwt_is_woo_single_prod() ) {
			$sidebar = get_theme_mod( 'killar_woo_single_prod_sidebar', 'woo-single-prod-sidebar' );
		} else if ( is_singular( 'post' ) ) {
			$sidebar = get_theme_mod( 'killar_blog_single_post_sidebar', 'single-post-sidebar' );
		}

		$sidebar = apply_filters( 'killar_get_sidebar', $sidebar );
		if ( ! is_active_sidebar( $sidebar ) ) {
			$sidebar = 'sidebar-1';
			$sidebar = ( is_active_sidebar( $sidebar ) ) ? $sidebar : false;
		}
		
		return $sidebar;
	}
}

/**
 * Retrieve the classes for the secondary element as an array.
 */
if ( ! function_exists( 'killarwt_get_secondary_col_class' ) ) {

	function killarwt_get_secondary_col_class( $class = '' ) {

		$classes = array();

		$classes[] = 'widget-area';
		$classes[] = 'secondary';

		$sidebar_classes = killarwt_sidebar_columns();
		if ( !empty ( $sidebar_classes ) ) {
			$classes = array_merge( $classes, $sidebar_classes );
		} 

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'killar_secondary_class', $classes, $class );

		return array_unique( $classes );
	}
}
/*-----------------------------------------------
 * Social
 *----------------------------------------------*/

/**
 * Social Links
 */
if ( ! function_exists( 'killarwt_social_links_data' ) ) {

	function killarwt_social_links_data() {
		
		return apply_filters( 'killar_social_links', array(
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-facebook',
			),
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-twitter',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-instagram',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-pinterest',
			),
			'google_plus'  => array(
				'label' => esc_html__( 'Google Plus', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-google-plus',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-linkedin',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-tumblr',
			),
			'whatsapp'  => array(
				'label' => esc_html__( 'WhatsApp', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-whatsapp',
			),
			'github'  => array(
				'label' => esc_html__( 'Github', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-github',
			),
			'youtube' => array(
				'label' => esc_html__( 'Youtube', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-youtube',
			),
			'vimeo' => array(
				'label' => esc_html__( 'Vimeo', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-vimeo-square',
			),
			'rss'  => array(
				'label' => esc_html__( 'RSS', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'killar' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'killar' ),
				'icon_class' => 'fab fa-envelope',
			),
		) );
	}
}

/**
 * Social Links Settings
 */
if ( ! function_exists( 'killarwt_social_links_settings' ) ) {

	function killarwt_social_links_settings() {

		return apply_filters( 'killar_social_links_settings', get_theme_mod( 'killar_social_links_settings' ) );
	}
}

/**
 * Social Links Display Type
 */
if ( ! function_exists( 'killarwt_social_type' ) ) {

	function killarwt_social_type() {

		return apply_filters( 'killar_social_type', 'links' );
	}
}

/**
 * Social Links Display Type
 */
if ( ! function_exists( 'killarwt_social_links_display_type' ) ) {

	function killarwt_social_links_display_type() {

		return apply_filters( 'killar_social_links_display_type', get_theme_mod( 'killar_social_links_display_type', 'default' ) );
	}
}

/**
 * Social Links Icon Style
 */
if ( ! function_exists( 'killarwt_social_links_icon_style' ) ) {

	function killarwt_social_links_icon_style() {

		return apply_filters( 'killar_social_links_icon_style', get_theme_mod( 'killar_social_links_icon_style', 'default' ) );
	}
}

/**
 * Social Links Icon Shape
 */
if ( ! function_exists( 'killarwt_social_links_icon_shape' ) ) {

	function killarwt_social_links_icon_shape() {

		return apply_filters( 'killar_social_links_icon_shape', get_theme_mod( 'killar_social_links_icon_shape', 'default' ) );
	}
}

/**
 * Social Links Icon Size
 */
if ( ! function_exists( 'killarwt_social_links_icon_size' ) ) {

	function killarwt_social_links_icon_size() {

		return apply_filters( 'killar_social_links_icon_size', get_theme_mod( 'killar_social_links_icon_size', 'default' ) );
	}
}

/**
 * Social Share Links
 */
if ( ! function_exists( 'killarwt_social_share_links_data' ) ) {

	function killarwt_social_share_links_data( $display_type = 'settings'  ) {
		
		$social_share_links = array(
			'facebook' => array(
				'label' 		=> esc_html__( 'Facebook', 'killar' ),
				'url' 			=> 'https://www.facebook.com/sharer/sharer.php?u={url}',
				'icon_class'	=> 'fab fa-facebook-f',
			),
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'killar' ),
				'url' 			=> 'https://twitter.com/share?text={title}&amp;url={url}',
				'icon_class' => 'fab fa-twitter',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'killar' ),
				'url' 			=> 'https://twitter.com/share?url={title}&amp;{url}',
				'icon_class' => 'fab fa-instagram',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'killar' ),
				'url' 			=> 'https://www.pinterest.com/pin/create/button/?url={url}&amp;media={thumb_url}&amp;description={description}',
				'icon_class' => 'fab fa-pinterest',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'killar' ),
				'url' 			=> 'https://www.linkedin.com/shareArticle?mini=true&amp;url={url}&amp;title={title}',
				'icon_class' => 'fab fa-linkedin',
			),
			'whatsapp'  => array(
				'label' => esc_html__( 'WhatsApp', 'killar' ),
				'url'  => 'https://wa.me/?text={title}',
				'icon_class' => 'fab fa-whatsapp',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'killar' ),
				'url'  => 'https://tumblr.com/widgets/share/tool?canonicalUrl={url}&amp;name={title}',
				'icon_class' => 'fab fa-tumblr',
			),
			'email'  => array(
				'label' => esc_html__( 'E-Mail', 'killar' ),
				'url'  => 'mailto:?subject={title}&amp;body={url}',
				'icon_class' => 'fab fa-envelope',
			),
			'telegram'  => array(
				'label' => esc_html__( 'Telegram', 'killar' ),
				'url'  => 'https://telegram.me/share/url?url={url}',
				'icon_class' => 'fab fa-telegram',
			),
			'stumbleupon'  => array(
				'label' => esc_html__( 'StumbleUpon', 'killar' ),
				'url'  => 'http://www.stumbleupon.com/submit?url={url}&amp;title={title}',
				'icon_class' => 'fab fa-stumbleupon',
			),
			'reddit'  => array(
				'label' => esc_html__( 'Reddit', 'killar' ),
				'url'  => 'https://reddit.com/submit?url={url}&amp;title={title}',
				'icon_class' => 'fab fa-reddit',
			),
		);
		
		return apply_filters( 'killar_social_share_links', $social_share_links );
	}
}

/**
 * Social links share settings
 */
if ( ! function_exists( 'killarwt_social_share_links_settings' ) ) {

	function killarwt_social_share_links_settings() {

		return apply_filters( 'killar_social_share_links_settings', get_theme_mod( 'killar_social_share_links_settings' ) );
	}
}

/**
 * Social Share Links Display Type
 */
if ( ! function_exists( 'killarwt_social_share_links_display_type' ) ) {

	function killarwt_social_share_links_display_type() {

		return apply_filters( 'killar_social_share_links_display_type', get_theme_mod( 'killar_social_share_links_display_type', 'default' ) );
	}
}

/**
 * Social Share Links Icon Style
 */
if ( ! function_exists( 'killarwt_social_share_links_icon_style' ) ) {

	function killarwt_social_share_links_icon_style() {

		return apply_filters( 'killar_social_share_links_icon_style', get_theme_mod( 'killar_social_share_links_icon_style', 'default' ) );
	}
}

/**
 * Social Share Links Icon Shape
 */
if ( ! function_exists( 'killarwt_social_share_links_icon_shape' ) ) {

	function killarwt_social_share_links_icon_shape() {

		return apply_filters( 'killar_social_share_links_icon_shape', get_theme_mod( 'killar_social_share_links_icon_shape', 'default' ) );
	}
}

/**
 * Social Share Links Icon Size
 */
if ( ! function_exists( 'killarwt_social_share_links_icon_size' ) ) {

	function killarwt_social_share_links_icon_size() {

		return apply_filters( 'killar_social_share_links_icon_size', get_theme_mod( 'killar_social_share_links_icon_size', 'default' ) );
	}
}
 
 
/*-----------------------------------------------
 * Blog/Post
 *----------------------------------------------*/
 
function killarwt_get_post_thumbnail( $size = 'thumbnail', $css_class = '', $attributes = false ) {
	
	global $post;
	return killarwt_get_image_html( array( 'attach_id' => get_post_thumbnail_id(), 'size' => $size, 'class' => $css_class, 'attributes' => $attributes  ) );
}

/**
 * Blog Loop Wrapper Classes
 */
if ( ! function_exists( 'killarwt_blog_loop_post_wrapper_classes' ) ) {

	function killarwt_blog_loop_post_wrapper_classes( $class = '' ) {
		
		$classes = array();
		
		$view_type = killarwt_blog_loop_view_type();
		$display_type = killarwt_get_loop_prop( 'killar_blog_loop_display_type' );
		$classes[] = 'view-'.$view_type;
		$classes[] = 'blog-'.$view_type;
		$classes[] = 'blog-style-'.killarwt_get_loop_prop( 'killar_blog_loop_post_style' );

		if ( in_array( $view_type, array( 'slider', 'micro-slider', 'carousel', 'micro_carousel' ) )  ) {
			
			$classes[] = 'items-cen-cont';
			$classes[] = 'kwt-slick-slider';
			
			if( !in_array( $display_type, array('widget') ) ) {
				$classes[] = 'nav-on-hover';
			}
			
			$classes = array_merge( $classes, killarwt_get_nav_classes( array( 'carousel_nav' => killarwt_get_loop_prop( 'killar_blog_loop_carousel_nav' ), 'carousel_nav_position' => killarwt_get_loop_prop( 'killar_blog_loop_carousel_nav_position' ), 'carousel_nav_style' => killarwt_get_loop_prop( 'killar_blog_loop_carousel_nav_style' ) ) ) );
			
		} else if ( in_array( $view_type, array( 'gallery-filter' ) ) ) {
				$classes[] = 'blog-area';	
		} else {
			if (  in_array( $view_type, array( 'grid', 'list', 'modern', 'full', 'full-center' ) ) ) {
				$classes[] = 'row g-xl-4 g-lg-3 g-3';
			}

			if ( $view_type == 'grid' ) {
				$blog_grid_columns = killarwt_get_loop_prop( 'killar_blog_loop_items_col_lg', 2 );
				$classes[] = 'blog-grid-'.$blog_grid_columns.'cols';
			}
			
			if ( killarwt_is_blog_archive() && in_array( killarwt_blog_loop_post_pagination_style(), array( 'infinite-scroll', 'load-more' ) ) ) {
				$classes[] = 'infinite-scroll-wrap';
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'killar_blog_loop_post_wrapper_classes', $classes, $class );
		
		return array_unique( $classes );
	}
}

/**
 * Blog Loop Wrapper Attributes
 */
if ( ! function_exists( 'killarwt_blog_loop_post_wrapper_atts' ) ) {

	function killarwt_blog_loop_post_wrapper_atts() {

		$atts = array();		
		$atts['class'] = killarwt_stringify_classes( killarwt_blog_loop_post_wrapper_classes() );
		
		$p_atts = array(
			'view_type'			=> killarwt_blog_loop_view_type(),
			'carousel_nav'		=> killarwt_get_loop_prop( 'killar_blog_loop_carousel_nav', true ),
			'carousel_infinite'		=> killarwt_get_loop_prop( 'killar_blog_loop_carousel_infinite', false ),
			'carousel_autoplay' 	=> killarwt_get_loop_prop( 'killar_blog_loop_carousel_autoplay', false ),
			'carousel_dots' 		=> killarwt_get_loop_prop( 'killar_blog_loop_carousel_dots', false ),
			'items_col_xxl' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_xxl' ),
			'items_col_xl' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_xl' ),
			'items_col_lg' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_lg' ),
			'items_col_md' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_md' ),
			'items_col_sm' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_sm' ),
			'items_col_xs' 		=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_xs' ),
			'items_col_xxs' 	=> killarwt_get_loop_prop( 'killar_blog_loop_items_col_xxs', 1 ),
		);

		$atts = array_merge( $atts, killarwt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'killar_blog_loop_post_wrapper_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
	}
}

/**
 * Blog Loop Post Classes
 */
if ( ! function_exists( 'killarwt_blog_loop_post_classes' ) ) {

	function killarwt_blog_loop_post_classes( $class = '' ) {
		
		$classes = array();		
		$display_type = killarwt_get_loop_prop( 'killar_blog_loop_display_type' );
		$view_type = killarwt_blog_loop_view_type();
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			$classes[] = 'slider-item';
		} else {
			
			if ( in_array( $view_type, array( 'grid', 'gallery-filter' ) )  ) {
				$cats = get_the_terms( get_the_ID(), 'category' );
				if( !empty( $cats ) ) {
					$cat_ar = array_column( get_the_terms( get_the_ID(), 'category' ), 'slug');
					$classes[] = 'masonry-item';
					$classes[] = ( !empty( $cat_ar ) ) ? implode( ' ', $cat_ar ) : '';
				}
			}
			
			$classes[] = $display_type . '-item-entry item-entry-wrap';
			if ( in_array( $view_type, array( 'grid', 'gallery-filter', 'slider' ) ) ) {
				$classes[] = killarwt_cols_class( 'xxl', killarwt_get_loop_prop( 'killar_blog_loop_items_col_xxl' ) );
				$classes[] = killarwt_cols_class( 'xl', killarwt_get_loop_prop( 'killar_blog_loop_items_col_xl' ) );
				$classes[] = killarwt_cols_class( 'lg', killarwt_get_loop_prop( 'killar_blog_loop_items_col_lg' ) );
				$classes[] = killarwt_cols_class( 'md', killarwt_get_loop_prop( 'killar_blog_loop_items_col_md' ) );
				$classes[] = killarwt_cols_class( 'sm', killarwt_get_loop_prop( 'killar_blog_loop_items_col_sm' ) );
				$classes[] = killarwt_cols_class( 'xs', killarwt_get_loop_prop( 'killar_blog_loop_items_col_xs' ) );
				$classes[] = killarwt_cols_class( 'xxs', killarwt_get_loop_prop( 'killar_blog_loop_items_col_xxs' ) );
			} else if ( in_array( $view_type, array( 'list' ) ) ) {
				$classes[] = 'col-xl-12 col-lg-12 col-md-12 col-sm-12';
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}
		
		
		$classes = array_merge( $classes, get_post_class() );

		$classes = apply_filters( 'killar_blog_loop_post_wrapper_classes', $classes, $class );

		return array_unique( $classes );
	}
}

/**
 * Blog Loop Post Attributes
 */
if ( ! function_exists( 'killarwt_blog_loop_post_atts' ) ) {

	function killarwt_blog_loop_post_atts() {

		$atts = array();

		$atts['class'] = killarwt_blog_loop_post_classes();
		
		$p_atts = array(
			'id'			=> 'post-'.get_the_ID(),
		);

		$atts = array_merge( $atts, killarwt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'killar_blog_loop_post_atts', $atts );
		
		return killarwt_stringify_atts( $atts );
	}
}
 
/**
 * Blog Loop View Type
 */
if ( ! function_exists( 'killarwt_blog_loop_view_type' ) ) {

	function killarwt_blog_loop_view_type() {
		
		$view_type = killarwt_get_loop_prop( 'killar_blog_loop_view_type' );
		if ( empty( $view_type ) ) {
			$view_type = get_theme_mod( 'killar_blog_loop_view_type', 'list' );
		}
		
		return apply_filters( 'killar_blog_loop_view_type', $view_type );
	}
}
 
/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'killarwt_blog_loop_post_sections_positioning' ) ) {

	function killarwt_blog_loop_post_sections_positioning() {
		
		$sections = killarwt_get_loop_prop( 'killar_blog_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'killar_blog_loop_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Blog Loop Posts Gallery
 */
if ( ! function_exists( 'killarwt_after_blog_loop_post_start' ) ) {

	function killarwt_after_blog_loop_post_start() {
		
		$view_type = killarwt_blog_loop_view_type();
		if ( in_array( $view_type, array( 'gallery-filter' ) ) ) {
			$html = '';
			$categories = killarwt_categories( 'category' );
			
			unset($categories['']);
			if( !empty( $categories ) ) {
				$html .= '<div class="row">
							<div class="col-md-12 text-center">
								<div class="masonry-filter port-button mb-5 mt-3 portfolio-menu nav nav-pills lights border-0 justify-content-center">
									<button data-filter="*" class="active nav-link fs-6">All</button>';
				foreach( $categories as $key => $name ) {
					$html .= '<button class="nav-link fs-6" data-filter=".'.$key.'">'.$name.'</button>';
				}
				$html .= '		</div>
							</div>
						  </div>';
			}
			echo wp_kses_post( $html );
		}
	}
	
	add_action( 'killar_after_blog_loop_post_start', 'killarwt_after_blog_loop_post_start', 10 );
}

/**
 * Blog Gallery Filter
 */

if ( ! function_exists( 'killarwt_blog_gallery_filter_start' ) ) {

	function killarwt_blog_gallery_filter_start() {
		
		$view_type = killarwt_blog_loop_view_type();
		$html = '';
		if ( in_array( $view_type, array( 'gallery-filter' ) ) ) {
			$html = '<div class="row">	
						<div class="col-md-12 gallery-items-list">
							<div class="masonry-wrap grid-loaded row g-xl-4 g-lg-3 g-3">';
			}
			echo wp_kses_post( $html );
	}
	
	add_action( 'killar_after_blog_loop_post_start', 'killarwt_blog_gallery_filter_start', 20 );
}

if ( ! function_exists( 'killarwt_blog_gallery_filter_end' ) ) {

	function killarwt_blog_gallery_filter_end() {
		
		$view_type = killarwt_blog_loop_view_type();
		$html = '';
		if ( in_array( $view_type, array( 'gallery-filter' ) ) ) {
			$html = '</div></div></div>';
		}
		echo wp_kses_post( $html );
	}
	
	add_action( 'killar_before_blog_loop_post_end', 'killarwt_blog_gallery_filter_end', 20 );
}

/**
 * Returns sections single post positioning Array
 */
if ( ! function_exists( 'killarwt_blog_single_post_sections_positioning_array' ) ) {
	function killarwt_blog_single_post_sections_positioning_array() {
		return apply_filters( 'killar_blog_single_post_sections_positioning', array( 'thumbnail', 'title', 'meta', 'content', 'categories', 'tags', 'social-links', 'next-prev', 'author-info', 'related-posts', 'comments' ) );
	}
}

/**
 * Returns sections single post positioning
 */
if ( ! function_exists( 'killarwt_blog_single_post_sections_positioning' ) ) {

	function killarwt_blog_single_post_sections_positioning() {
		
		$sections = get_theme_mod( 'killar_blog_single_post_sections_positioning', killarwt_blog_single_post_sections_positioning_array() );
		$prefix = KILLARWT_PREFIX;
		$post_positions = killarwt_get_post_meta( 'post_section_positions' );
		if( !empty( $post_positions ) ) {
			$pm_positions = array_column( killarwt_get_post_meta( 'post_section_positions' ), "{$prefix}post_section");
			if( !empty( $pm_positions ) ) {
				$sections = $pm_positions;
			}
		}
	
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'killar_blog_single_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Loop Post : Blog Style
 */
if ( ! function_exists( 'killarwt_blog_loop_post_style' ) ) {
	
	function killarwt_blog_loop_post_style() {
		
		$style = get_theme_mod( 'killar_blog_loop_post_style', 'default' );
		if ( in_array( killarwt_get_loop_prop( 'killar_blog_loop_view_type' ), array( 'full', 'list', 'modern' ) ) ) {
			$style = 'default';
		}
		return $style;
	}
}

/**
 * Returns Content Limit
 */
if ( ! function_exists( 'killarwt_content_limit' ) ) {
	
	function killarwt_content_limit( $content, $length, $more = '' ) {
		
		$content = wp_trim_words( $content, $length );
		$content = preg_replace('`\[[^\]]*\]`','',$content);
		$content = stripslashes( wp_filter_nohtml_kses( $content ) );

		if ( $more ) {
			$output = sprintf(
				'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
				$content,
				get_permalink(),
				sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'killar' ), the_title_attribute( 'echo=0' ) ),
				esc_html( $more )
			);
		} else {
			$output = sprintf( '%s', $content );
		}
		
		return $output;
	}
}
 
/**
 * Returns blog meta
 */
if ( ! function_exists( 'killarwt_blog_post_meta' ) ) {

	function killarwt_blog_post_meta() {

		$display_type = killarwt_get_loop_prop( 'killar_blog_loop_display_type' );
		$sections = array( 'author', 'date' );   /*  , 'comments'   */
		$option_name = 'killar_blog_loop_post_meta';
		
		if ( is_singular( 'post' ) && !in_array( $display_type, array( 'related_posts' ) ) ) {
			$option_name = 'killar_blog_single_post_meta';
		}
		
		$sections = killarwt_get_loop_prop( $option_name, $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		$sections = apply_filters( $option_name, $sections );

		return $sections;

	}
}

/**
 * Returns reading time
*/
if ( ! function_exists( 'killarwt_reading_time' ) ) {

	function killarwt_reading_time() {

		global $post;

		$content      = get_post_field( 'post_content', $post->ID );
		$word_count   = str_word_count( strip_tags( $content ) );
		$reading_time = ceil( $word_count / 200 );

		$rwp_reading_time = $reading_time . " " . esc_html__( 'min read', 'killar' );
		return apply_filters( 'killarwt_post_reading_time', $rwp_reading_time );
	}}

/**
 * Returns the pagination style
 */
if ( ! function_exists( 'killarwt_blog_loop_post_pagination_style' ) ) {

	function killarwt_blog_loop_post_pagination_style() {

		return apply_filters( 'killar_blog_loop_post_pagination_style', killarwt_get_loop_prop( 'killar_blog_loop_post_pagination_style' ) );
	}
}

/**
 * Single post social share links
 */
if ( ! function_exists( 'ctm_killar_blog_single_post_social_share_links' ) ) {
	
	function ctm_killar_blog_single_post_social_share_links() {
		
		return apply_filters( 'killar_blog_single_post_social_share_links', get_theme_mod( 'killar_blog_single_post_social_share_links', array( 'facebook', 'twitter', 'linkedin' )) );
	}
}

/**
 * Single post social share links settings
 */
if ( ! function_exists( 'ctm_killar_blog_single_post_social_share_links_settings' ) ) {
	
	function ctm_killar_blog_single_post_social_share_links_settings() {
		
		return apply_filters( 'killar_blog_single_post_social_share_links_settings', get_theme_mod( 'killar_blog_single_post_social_share_links_settings') );
	}
}

if ( ! function_exists( 'killarwt_blog_loop_latest_articles_atts' ) ) {

	function killarwt_blog_loop_latest_articles_atts( $args = array() ) {
		
		$atts = array(); 
		$status = get_theme_mod( 'killar_blog_loop_latest_articles_section', true );
		if( $status ) {
			
			$default_args = array(
				'posts_per_page' => apply_filters( 'killar_blog_loop_latest_articles_limit', absint( get_theme_mod( 'killar_blog_loop_latest_articles_limit', 2 ) ) ),
				'orderby'        => 'id',
				'order'        	 => 'desc',
				'no_found_rows'  => true,
				'post__not_in'  => ( !empty( $args['exclude_posts'] ) ) ? $args['exclude_posts'] : '',
			);
							
			$args = wp_parse_args( $args, $default_args );
			$args = apply_filters( 'killar_blog_loop_post_latest_posts_query_args', $args );
			
			$atts['display_type'] 			= 'latest-posts';
			$atts['query_args'] 			= $args;
			$atts['view_type'] 				= 'list';
			$atts['blog_loop_post_tags'] 	= true;
			$atts['el_classes'] 			= 'latest-posts post-column-reverse';
			
			if( $title = get_theme_mod( 'killar_blog_loop_latest_articles_section_title', 'Latest Articles' ) ) {
				$atts['sec_title'] = '<h5 class="sec-title h5-xs border-bottom w-100 pb-3 mb-4">' . $title . '</h5>';
			}
		}
		return $atts;
	}
}

/**
 * Blog loop post show latest articles
 */
if ( !function_exists( 'killarwt_latest_articles' ) ) {

	function killarwt_latest_articles( $args = array() ) {
		
		$atts = killarwt_blog_loop_latest_articles_atts( $args );
		if( !empty( $atts['query_args'] ) ) {
			$posts = get_posts( $atts['query_args'] );
			if( function_exists('killarwt_blog') && !empty( $atts ) && count( $posts ) > 0 && ( !empty( $args['display_type'] ) && $args['display_type'] == 'loop' ) && $args['items_count'] == 1 ) {
				
				echo killarwt_blog( $atts );
				
				// Set main loop item count
				if( isset( $args['items_count'] ) ) $GLOBALS['items_count'] = $args['items_count'];
				if( !empty( $args['display_type'] ) ) $GLOBALS['display_type'] = $args['display_type'];
			}
		}
	}
	//add_action( 'killar_outer_before_loop_post_start', 'killarwt_latest_articles', 10 );
}

/**
 * Blog loop post show latest article
 */
if ( function_exists('killarwt_blog') && !function_exists( 'killarwt_loop_post_subatts' ) ) {

	function killarwt_loop_post_subatts( $sub_atts, $args = array() ) {
		
		$atts = killarwt_blog_loop_latest_articles_atts( $args );
		if( !empty( $atts['query_args'] ) ) {
			$posts = get_posts( $atts['query_args'] );
			if( !empty( $atts ) && count( $posts ) > 0 && ( !empty( $args['display_type'] ) && $args['display_type'] == 'loop' ) && $args['items_count'] == 0 ) {
				
				if( in_array( 'b-bottom', $sub_atts['class'] ) ) {
					unset( $sub_atts['class'][array_search( 'b-bottom', $sub_atts['class'] )] ); 
				}
			}
		}
		return $sub_atts;
	}
	add_filter( 'killar_loop_post_subatts', 'killarwt_loop_post_subatts', 10, 2 );
}

/**
 * Single post comment fields
 */
if ( !function_exists( 'killarwt_comment_form_field_author' ) ) {

	function killarwt_comment_form_field_author( $field ) {
		echo '<div class="col-6">' . $field . '</div>';
	}
	//add_filter( 'comment_form_field_author', 'killarwt_comment_form_field_author', 10, 2 );
}



/*-----------------------------------------------
 * Portfolio
 *----------------------------------------------*/
 
if( ! function_exists( 'killarwt_is_portfolio_archive' ) ) {
	
	function killarwt_is_portfolio_archive() {
		return ( is_post_type_archive('portfolio') || is_tax('portfolio-cat') || is_tax('portfolio-skills') );
	}
}

/**
 * Returns sections popup portfolio positioning
 */
if ( ! function_exists( 'killarwt_portfolio_popup_post_sections_positioning' ) ) {

	function killarwt_portfolio_popup_post_sections_positioning() {

		$sections = array( 'thumbnail', 'title', 'content', 'highlights', 'skills', 'social-links' );
		
		$sections = get_theme_mod( 'killar_portfolio_popup_post_sections_positioning', $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'killar_portfolio_popup_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections single portfolio positioning
 */
if ( ! function_exists( 'killarwt_portfolio_single_post_sections_positioning' ) ) {

	function killarwt_portfolio_single_post_sections_positioning() {

		$sections = get_theme_mod( 'killar_portfolio_single_post_sections_positioning', array( 'title', 'content', 'highlights', 'skills', 'social-links', 'related-portfolio' ) );
		
		if( !$show_categories = killarwt_get_post_meta( 'portfolio_show_categories' ) ) if (($key = array_search('categories', $sections)) !== false) unset($sections[$key]);
		if( !$show_title = killarwt_get_post_meta( 'portfolio_show_title' ) ) if (($key = array_search('title', $sections)) !== false) unset($sections[$key]);
		if( !$show_social = killarwt_get_post_meta( 'portfolio_show_share' ) ) if (($key = array_search('social-links', $sections)) !== false) unset($sections[$key]);
		if( !$show_social = killarwt_get_post_meta( 'portfolio_show_related' ) ) if (($key = array_search('related-portfolio', $sections)) !== false) unset($sections[$key]);

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'killar_portfolio_single_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'killarwt_portfolio_loop_post_sections_positioning' ) ) {

	function killarwt_portfolio_loop_post_sections_positioning() {
		
		$sections = killarwt_get_loop_prop( 'killar_portfolio_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'killar_portfolio_loop_post_sections_positioning', $sections );

		return $sections;
	}
}