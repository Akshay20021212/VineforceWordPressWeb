(function ($) {
	"use strict";
	jQuery(document).ready(function() {
		jQuery('body').on('change', ".edit-menu-item-menu-type", function( e ){
			var $this = jQuery(this);
			kwt_megamenu_items_handler( $this, $this.val() );
		});
		
		jQuery('body').on('change', ".edit-menu-item-megamenu-layout", function(){
			var $this = jQuery(this)
			killarwt_edit_megamenu_layout( $this, $this.val() );
		});
	});
	
	function kwt_megamenu_items_handler( $this, $type = '' ) {
		var mgFeilds = $this.parents('.killar-menu-fields');
		mgFeilds.find('.megamenu-fields').addClass('hidden');
		if( $type ) {
			mgFeilds.find('.megamenu-fields.'+ $type).removeClass('hidden');
		}
		killarwt_edit_megamenu_layout( $this, mgFeilds.find('.edit-menu-item-megamenu-layout option:selected').val() );
	}
	
	function killarwt_edit_megamenu_layout ( $this, layout = 'full-width' ) {
		var megamenu_flds_block = $this.parents('.killar-menu-fields').find('.megamenu-layout-block');
		megamenu_flds_block.addClass('hidden');
		if ( layout == 'custom-size' ) {
			megamenu_flds_block.removeClass('hidden');
		} else {
			megamenu_flds_block.addClass('hidden');
		}
		
	}
})(jQuery); 
