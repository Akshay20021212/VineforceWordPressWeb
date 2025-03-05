var kwtAdminWidgets = kwtAdminWidgets || {}, killarMediaInit, killarWidgetInit;
(function ($) {
	"use strict";
	kwtAdminWidgets = {

		widgetInit: function( selector )  {
			var widgetinit = {
				init: function (options) {
			
					widgetinit.validateDependency(this);
					jQuery(selector).each( function () {
						jQuery(this).on('change', '.killar-widget-action', function() {
							var dataName = jQuery(this).parent('p').data('name');
							widgetinit.validateDependency(this);
						} );
					});
				},
				validateDependency : function ( data  ) {
					jQuery(selector).each( function () {
						jQuery(this).children('p').each( function () {
							var $this = jQuery(this),
							curWidget = $this.parent(selector),
							dataName =  $this.data('name');
							if ( dataName ) {
								var findElements = curWidget.find("[data-element='" + dataName + "']");
								if ( findElements.length > 0 ) {
									var actionInpput = curWidget.find("[data-name='" + dataName + "'] .killar-widget-action"),
									defaultVal = actionInpput.val();
									if ( actionInpput.attr('type') == 'checkbox' ) {
										if ( actionInpput.prop('checked') == false ) {
											var defaultVal = 'no';
										}
									}
									
									findElements.each( function () {
										var curSelVal = jQuery(this).data('value'),
										curSelVal = curSelVal.toString();
										if ( curSelVal != null ) {
											var curSelValArr = curSelVal.split(',');
											if ( jQuery.inArray( defaultVal, curSelValArr ) == -1 ) {
												jQuery(this).addClass('dependent-hidden');
											} else {
												jQuery(this).removeClass('dependent-hidden');
											}
										}
									} );

								}
							}
						});
				   });
				}
				
			}
			kwtAdminWidgets.widgetinit = Object.create(widgetinit);
			kwtAdminWidgets.widgetinit.init();
		}
	};

})(jQuery); 
killarWidgetInit = kwtAdminWidgets.widgetInit;