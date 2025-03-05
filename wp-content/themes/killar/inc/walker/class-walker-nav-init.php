<?php
/**
 * Navigation Init
 *
 * @package KillarWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
	* Custom menu items metadata:
*/
class KillarWT_Nav_Fields_Walker {
	
	/**
		* Initialize plugin
	*/
	public function __construct() {
	
		add_action( 'wp_nav_menu_item_custom_fields', array( $this , 'killarwt_menu_item_custom_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( $this , 'killarwt_menu_item_save' ), 10, 3 );		
	}
	
	/**
	* Save custom field value
	*
	* @wp_hook action wp_update_nav_menu_item
	*
	* @param int   $menu_id         Nav menu ID
	* @param int   $menu_item_db_id Menu item ID
	* @param array $menu_item_args  Menu item data
	*/
	public static function killarwt_menu_item_save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		
		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );
		$fields = array('menu-type', 'megamenu-layout', 'megamenu-width', 'megamenu-height', 'megamenu-columns', 'custom-layout');
		foreach ( $fields as $_key ) {
			
			$key = sprintf( 'menu-item-killar-%s', $_key );
			$value = '';
			// Sanitize
			if ( ! empty( $_REQUEST[ $key ][ $menu_item_db_id ] ) ) {
				$value = sanitize_text_field($_REQUEST[ $key ][ $menu_item_db_id ]);
			}

			// Update
			$update_key = sprintf( '_menu_item_killar_%s', $_key );
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $update_key, $value );
			} else {
				delete_post_meta( $menu_item_db_id, $update_key );
			}
		}
	}
	
	/**
	* Print field
	*
	* @param object $item  Menu item data object.
	* @param int    $depth  Depth of menu item. Used for padding.
	* @param array  $args  Menu item args.
	* @param int    $id    Nav menu ID.
	*
	* @return string Form fields
	*/
	public static function killarwt_menu_item_custom_fields( $id, $item, $depth, $args ) {
		
		$item_id 			= $item->ID;
		$menu_type			= get_post_meta( $item_id, '_menu_item_killar_menu-type', true );
		$megamenu_enable	= get_post_meta( $item_id, '_menu_item_killar_megamenu-enable', true );
		$menu_layout		= get_post_meta( $item_id, '_menu_item_killar_megamenu-layout', 'full-width' );
		$megamenu_width		= get_post_meta( $item_id, '_menu_item_killar_megamenu-width', true );
		$megamenu_height	= get_post_meta( $item_id, '_menu_item_killar_megamenu-height', true );
		$megamenu_columns	= get_post_meta( $item_id, '_menu_item_killar_megamenu-columns', true );
		$layouts			= killarwt_megamenu_layout_list();
		$custom_layout 		= get_post_meta( $item_id, '_menu_item_killar_custom-layout', true );
		?>
		<div class="killar-menu-fields">
			<?php if ( $depth == 0 ){ ?>
			<p class="field-menu-type description description-wide">
				<label for="edit-menu-item-menu-type-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Menu Type', 'killar' ); ?>
					<select id="edit-menu-item-menu-type-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-menu-type" name="menu-item-killar-menu-type[<?php echo esc_attr( $item_id ); ?>]">
						<?php $kwt_menu_types = array( 
							array('id' => '', 'name' => 'Standard Dropdown'),
							array('id' => 'megamenu-columns', 'name' => 'Megamenu ( Columns )'),
							array('id' => 'megamenu-layout', 'name' => 'Megamenu ( Layout )'),
						);
						$kwt_menu_types = array( '' => 'Standard Dropdown',
							'megamenu-columns' => 'Megamenu ( Columns )',
							'megamenu-layout' => 'Megamenu ( Layout )',
						);
						if ( ! empty( $kwt_menu_types ) && is_array( $kwt_menu_types ) ) :
							foreach ( $kwt_menu_types as $k => $v ) : ?>
								<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $menu_type, $k ); ?>><?php echo esc_html( $v ); ?></option>
						<?php endforeach; endif; ?>
					</select>
				</label>
			</p>
			<p class="field-megamenu-layout description description-wide megamenu-columns megamenu-layout megamenu-fields <?php echo ( !in_array( $menu_type, array( 'megamenu-columns', 'megamenu-layout' ) ) ) ? 'hidden' : ''; ?>">
				<label for="edit-menu-item-megamenu-layout-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Layout', 'killar' ); ?>
					<select id="edit-menu-item-megamenu-layout-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-layout" name="menu-item-killar-megamenu-layout[<?php echo esc_attr( $item_id ); ?>]">
						<?php $kwt_menu_layouts = array( 
							array('id' => 'full-width', 'name' => 'Full Width'),
							array('id' => 'custom-size', 'name' => 'Custom Size')
						);
						if ( ! empty( $kwt_menu_layouts ) && is_array( $kwt_menu_layouts ) ) :
							foreach ( $kwt_menu_layouts as $layout ) : ?>
								<option value="<?php echo esc_attr( $layout['id'] ); ?>" <?php selected( $menu_layout, $layout['id'] ); ?>><?php echo esc_html( $layout['name'] ); ?></option>
						<?php endforeach; endif; ?>
					</select>
				</label>
			</p>
			<div id="kwt-megamenu-layout-layout-<?php echo esc_attr( $item_id ); ?>" class="megamenu-layout-layout megamenu-columns megamenu-layout megamenu-fields <?php echo ( in_array( $menu_type, array( 'megamenu-columns', 'megamenu-layout' ) ) && $menu_layout == 'custom-size' ) ? '' : 'hidden'; ?>" >
				<p class="field-megamenu-width description description-thin megamenu-columns megamenu-layout megamenu-fields">
					<label for="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Megamenu Width', 'killar' ); ?><br>
						<input type="number" id="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-width" name="menu-item-killar-megamenu-width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $megamenu_width ); ?>" min="0" max="<?php echo killarwt_container_width(); ?>">
					</label>
				</p>
				<p class="field-megamenu-height description description-thin megamenu-columns megamenu-layout megamenu-fields">
					<label for="edit-menu-item-megamenu-height-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Megamenu Height', 'killar' ); ?><br>
						<input type="number" id="edit-menu-item-megamenu-height-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-height" name="menu-item-killar-megamenu-height[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $megamenu_height ); ?>">
					</label>
				</p>
			</div>
			<?php } ?>
			<?php if ( $depth == 0 ) { ?>
			<p class="field-megamenu-columns megamenu-columns description description-wide megamenu-fields <?php echo ( !in_array( $menu_type, array( 'megamenu-columns' ) ) ) ? 'hidden' : ''; ?>">
				<label for="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Columns', 'killar' ); ?>
					<select id="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-killar-megamenu-columns[<?php echo esc_attr( $item_id ); ?>]">
						<?php 
						$kwt_menu_cols = array( 
							array('id' => 'col-1', 'name' => '1 - Column'),
							array('id' => 'col-2', 'name' => '2 - Columns'),
							array('id' => 'col-3', 'name' => '3 - Columns'),
							array('id' => 'col-4', 'name' => '4 - Columns'),
							array('id' => 'col-5', 'name' => '5 - Columns'),
							array('id' => 'col-6', 'name' => '6 - Columns'),
						);
						if ( ! empty( $kwt_menu_cols ) && is_array( $kwt_menu_cols ) ) :
							foreach ( $kwt_menu_cols as $megamenu_column ) : ?>
								<option value="<?php echo esc_attr( $megamenu_column['id'] ); ?>" <?php selected( $megamenu_columns, $megamenu_column['id'] ); ?>><?php echo esc_html( $megamenu_column['name'] ); ?></option>
						<?php endforeach; endif; ?>
					</select>
				</label>
			</p>
			<p class="field-custom-layout megamenu-layout description description-wide megamenu-fields <?php echo ( !in_array( $menu_type, array( 'megamenu-layout' ) ) ) ? 'hidden' : ''; ?>">
				<label for="edit-menu-item-custom-layout-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Layout :', 'killar' ); ?>
					<select id="edit-menu-item-custom-layout-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-killar-custom-layout[<?php echo esc_attr( $item_id ); ?>]">
						<option value=""><?php esc_html_e( 'Select Layout', 'killar' ); ?></option>
						<?php
						if ( ! empty( $layouts ) && is_array( $layouts ) ) :
							foreach ( $layouts as $id => $title ) : ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $custom_layout, $id ); ?>><?php echo esc_html( $title ); ?></option>
						<?php endforeach; endif; ?>
					</select>
					<?php if(!empty( $custom_layout ) ){
						echo sprintf( '<a href="%s" class="button-link edit-custom-layout" target="_blank">%s</a>', "post.php?action=edit&amp;post={$custom_layout}", esc_html__( 'Edit Megamenu Layout', 'killar' ) ) . ' | ';
					} 
					echo sprintf( '<a href="%s" class="button-link add-custom-layout" target="_blank">%s</a>', "post-new.php?post_type=layout", esc_html__( 'Add Megamenu Layout', 'killar' ) );
					?>
				</label>
			</p>
			<?php } ?>
		</div>
		<?php
	}
	
	/**
		* Replace default menu editor walker with ours
		*
		* We don't actually replace the default walker. We're still using it and
		* only injecting some HTMLs.
		*
		* @since   0.1.0
		* @access  private
		* @wp_hook filter wp_edit_nav_menu_walker
		* @param   string $walker Walker class name
		* @return  string Walker class name
	*/
	public static function killarwt_edit_menu_walker( $walker ) {
		$walker = 'KillarWT_Edit_Menu_Custom_Fields_Walker';
		if ( ! class_exists( $walker ) ) {
			require_once KILLARWT_INC_DIR . 'walker/class-edit-menu-custom-walker.php';
		}
		
		return $walker;
	}
}
new KillarWT_Nav_Fields_Walker;