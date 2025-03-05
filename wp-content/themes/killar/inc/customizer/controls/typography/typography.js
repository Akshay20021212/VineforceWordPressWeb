wp.customize.controlConstructor['killarwt-typography'] = wp.customize.killarwtBaseControl.extend( {} );

( function($) {
	
	$( document ).ready(function () {

		$( '.killarwt-typography-select' ).select2();

	} );

} )( jQuery );